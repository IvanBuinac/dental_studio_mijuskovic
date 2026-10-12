<?php
/**
 * POST akcije nad zahtevom (sve uz CSRF):
 *   potvrdi (datum, vreme, poruka, posalji) · odbij (razlog_tip, razlog, predlog_datum, predlog_vreme, posalji)
 *   otkazi (razlog, posalji) · ponovo (ponovo pošalji mejl za trenutni status) · beleska · vrati (u "novo")
 * Polje v = updated_at u trenutku otvaranja stranice — zaštita od istovremene izmene (dva uređaja).
 * Flash poruke: copy-v2.md §7.8
 */

declare(strict_types=1);

require dirname(__DIR__) . '/lib/admin.php';
fk_admin_boot();
$user = fk_require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    fk_redirect('index.php');
}
fk_require_csrf();

$id = (int) ($_POST['id'] ?? 0);
$a = $id > 0 ? fk_appointment($id) : null;
if (!$a) {
    fk_flash('error', 'Zahtev nije pronađen.');
    fk_redirect('index.php');
}
$back = 'zahtev.php?id=' . $id;
$action = is_string($_POST['action'] ?? null) ? $_POST['action'] : '';
$send = ($_POST['posalji'] ?? '') === '1';
$pdo = db();
$now = fk_now();
$uid = (int) $user['id'];

// Istovremena izmena: stranica je otvorena pre nego što je neko drugi promenio zahtev
if (in_array($action, ['potvrdi', 'odbij', 'otkazi', 'vrati'], true) && isset($_POST['v'])
    && (string) $_POST['v'] !== (string) ($a['updated_at'] ?? '')) {
    fk_flash('warning', 'Ovaj zahtev je u međuvremenu izmenjen. Osvežite stranicu.');
    fk_redirect($back);
}

/** Pošalji mejl (ako je čekirano) i postavi flash. */
$mailAndFlash = static function (string $type, int $id, bool $send, string $okWithMail, string $okWithoutMail): void {
    if (!$send) {
        fk_flash('success', $okWithoutMail);
        return;
    }
    $fresh = fk_appointment($id);
    $r = $fresh ? fk_send_appointment_email($type, $fresh) : ['ok' => false, 'error' => null];
    if ($r['ok']) {
        fk_flash('success', $okWithMail);
    } else {
        fk_flash('warning', 'Sačuvano, ali mejl NIJE poslat (greška pri slanju). Kontaktirajte pacijenta direktno: '
            . ($fresh['telefon'] ?? '') . '. Detalji su u odeljku „Mejlovi“.');
    }
};

switch ($action) {
    case 'potvrdi':
        $datum = fk_clean_line($_POST['datum'] ?? '');
        $vreme = fk_clean_line($_POST['vreme'] ?? '');
        $poruka = fk_clean_text($_POST['poruka'] ?? '');
        $err = [];
        if (!fk_valid_date($datum)) {
            $err[] = 'Izaberite datum.';
        } elseif ($datum < date('Y-m-d')) {
            $err[] = 'Datum ne može biti u prošlosti.';
        }
        if (!fk_valid_time($vreme)) {
            $err[] = 'Izaberite vreme.';
        }
        if (fk_len($poruka) > 2000) {
            $err[] = 'Poruka može imati najviše 2000 znakova.';
        }
        if ($err) {
            fk_flash('error', implode(' ', $err));
            fk_redirect($back . '&a=potvrdi#akcije');
        }
        $wasConfirmed = $a['status'] === 'potvrdjeno';
        $pdo->prepare("UPDATE appointments SET status = 'potvrdjeno', potvrdjeni_datum = ?, potvrdjeno_vreme = ?, poruka_pacijentu = ?,
                       razlog_otkazivanja = NULL, updated_at = ? WHERE id = ?")
            ->execute([$datum, $vreme, $poruka !== '' ? $poruka : null, $now, $id]);
        fk_activity($wasConfirmed ? 'termin_izmenjen' : 'potvrdjen', $id, ['opis' => fk_date_short($datum) . ' u ' . $vreme], $uid);
        $mailAndFlash('potvrda', $id, $send, 'Termin je potvrđen — mejl je poslat pacijentu.', 'Termin je potvrđen. Mejl nije slat.');
        break;

    case 'odbij':
        $tip = is_string($_POST['razlog_tip'] ?? null) ? $_POST['razlog_tip'] : '';
        $razlog = fk_clean_text($_POST['razlog'] ?? '');
        $pd = fk_clean_line($_POST['predlog_datum'] ?? '');
        $pv = fk_clean_line($_POST['predlog_vreme'] ?? '');
        $tipovi = ['nije-dostupan' => 'Termin nije dostupan', 'drugi-pregled' => 'Potrebna je druga vrsta pregleda', 'drugo' => 'Drugo'];
        $err = [];
        if (!isset($tipovi[$tip])) {
            $err[] = 'Izaberite razlog.';
        }
        if (fk_len($razlog) < 3) {
            $err[] = 'Napišite kratku poruku pacijentu.';
        } elseif (fk_len($razlog) > 1000) {
            $err[] = 'Poruka može imati najviše 1000 znakova.';
        }
        $predlog = null;
        if (($pd === '') !== ($pv === '')) {
            $err[] = 'Unesite i datum i vreme predloga, ili ostavite oba prazna.';
        } elseif ($pd !== '') {
            if (!fk_valid_date($pd) || !fk_valid_time($pv)) {
                $err[] = 'Unesite i datum i vreme predloga, ili ostavite oba prazna.';
            } elseif ($pd < date('Y-m-d')) {
                $err[] = 'Datum ne može biti u prošlosti.';
            } else {
                $predlog = $pd . ' ' . $pv;
            }
        }
        if ($err) {
            fk_flash('error', implode(' ', array_unique($err)));
            fk_redirect($back . '&a=odbij#akcije');
        }
        $pdo->prepare("UPDATE appointments SET status = 'odbijeno', razlog_odbijanja = ?, predlog_termina = ?, updated_at = ? WHERE id = ?")
            ->execute([$razlog, $predlog, $now, $id]);
        fk_activity('odbijen', $id, ['opis' => $tipovi[$tip] . ($predlog ? ' · predlog: ' . fk_date_short(substr($predlog, 0, 10)) . ' ' . substr($predlog, 11) : ''), 'tip' => $tip], $uid);
        $mailAndFlash('odbijanje', $id, $send, 'Odgovor je poslat pacijentu.', 'Zahtev je odbijen. Mejl nije slat.');
        break;

    case 'otkazi':
        if ($a['status'] !== 'potvrdjeno') {
            fk_flash('warning', 'Ovaj zahtev je u međuvremenu izmenjen. Osvežite stranicu.');
            fk_redirect($back);
        }
        $razlog = fk_clean_text($_POST['razlog'] ?? '');
        if (fk_len($razlog) > 1000) {
            fk_flash('error', 'Razlog može imati najviše 1000 znakova.');
            fk_redirect($back . '&a=otkazi#akcije');
        }
        $pdo->prepare("UPDATE appointments SET status = 'otkazano', razlog_otkazivanja = ?, updated_at = ? WHERE id = ?")
            ->execute([$razlog !== '' ? $razlog : null, $now, $id]);
        fk_activity('otkazan', $id, ['opis' => mb_substr($razlog, 0, 140)], $uid);
        $mailAndFlash('otkazivanje', $id, $send, 'Termin je otkazan — pacijent je obavešten mejlom.', 'Termin je označen kao otkazan. Mejl nije slat.');
        break;

    case 'ponovo':
        $type = fk_email_type_for_status((string) $a['status']);
        fk_activity('mejl_ponovo', $id, ['opis' => FK_EMAIL_TYPES[$type]['label']], $uid);
        $mailAndFlash($type, $id, true, 'Mejl je ponovo poslat.', '');
        break;

    case 'beleska':
        $note = fk_clean_text($_POST['beleska'] ?? '');
        if (fk_len($note) > 4000) {
            fk_flash('error', 'Beleška može imati najviše 4000 znakova.');
            fk_redirect($back);
        }
        $pdo->prepare('UPDATE appointments SET doktor_beleska = ? WHERE id = ?')->execute([$note !== '' ? $note : null, $id]);
        fk_activity('beleska', $id, null, $uid);
        fk_flash('success', 'Beleška je sačuvana.');
        break;

    case 'vrati':
        $pdo->prepare("UPDATE appointments SET status = 'novo', updated_at = ? WHERE id = ?")->execute([$now, $id]);
        fk_activity('vracen_u_novo', $id, ['opis' => 'iz: ' . fk_label('status', (string) $a['status'])], $uid);
        fk_flash('success', 'Zahtev je vraćen u status „Novo“.');
        break;

    default:
        fk_flash('error', 'Došlo je do greške. Pokušajte ponovo.');
}

fk_redirect($back);
