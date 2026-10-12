<?php
/**
 * Dve akcije (POST + CSRF): potvrdi (datum, vreme, poruka) i odbij (razlog).
 * Posle promene statusa pacijent automatski dobija mejl; flash poruka jasno kaže da li je mejl poslat.
 */

declare(strict_types=1);

require dirname(__DIR__) . '/lib/admin.php';
fk_admin_boot();
fk_require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    fk_redirect('index.php');
}
fk_require_csrf();

$id = (int) ($_POST['id'] ?? 0);
$a = $id > 0 ? fk_appointment($id) : null;
$action = is_string($_POST['action'] ?? null) ? $_POST['action'] : '';

if (!$a) {
    fk_flash('error', 'Zahtev nije pronađen.');
    fk_redirect('index.php');
}
if ($a['status'] !== 'novo') {
    fk_flash('info', 'Ovaj zahtev je već obrađen.');
    fk_redirect('index.php?status=' . rawurlencode((string) $a['status']));
}

$back = 'index.php?status=novo#z' . $id;

/** Pošalji mejl i postavi jasnu poruku. */
$notify = static function (string $type, int $id, string $done): void {
    $fresh = fk_appointment($id);
    $r = $fresh ? fk_send_appointment_email($type, $fresh) : ['ok' => false];
    if ($r['ok']) {
        fk_flash('success', $done . ' Mejl je poslat pacijentu (' . $fresh['email'] . ').');
    } else {
        fk_flash('warning', $done . ' ALI mejl NIJE poslat — pozovite pacijenta: ' . ($fresh['telefon'] ?? '') . '.');
    }
};

if ($action === 'potvrdi') {
    $datum = fk_clean_line($_POST['datum'] ?? '');
    $vreme = fk_clean_line($_POST['vreme'] ?? '');
    $poruka = mb_substr(fk_clean_text($_POST['poruka'] ?? ''), 0, 2000);
    if (!fk_valid_date($datum)) {
        fk_flash('error', 'Izaberite datum.');
        fk_redirect($back);
    }
    if ($datum < date('Y-m-d')) {
        fk_flash('error', 'Datum ne može biti u prošlosti.');
        fk_redirect($back);
    }
    if (!fk_valid_time($vreme)) {
        fk_flash('error', 'Izaberite vreme.');
        fk_redirect($back);
    }
    db()->prepare("UPDATE appointments SET status = 'potvrdjeno', potvrdjeni_datum = ?, potvrdjeno_vreme = ?, poruka_pacijentu = ?, updated_at = ?
                   WHERE id = ? AND status = 'novo'")
        ->execute([$datum, $vreme, $poruka !== '' ? $poruka : null, fk_now(), $id]);
    $notify('potvrda', $id, 'Termin je potvrđen: ' . fk_date_short($datum) . ' u ' . $vreme . ' h.');
    fk_redirect('index.php?status=novo');
}

if ($action === 'odbij') {
    $razlog = mb_substr(fk_clean_text($_POST['razlog'] ?? ''), 0, 1000);
    db()->prepare("UPDATE appointments SET status = 'odbijeno', razlog_odbijanja = ?, updated_at = ? WHERE id = ? AND status = 'novo'")
        ->execute([$razlog !== '' ? $razlog : null, fk_now(), $id]);
    $notify('odbijanje', $id, 'Zahtev je odbijen.');
    fk_redirect('index.php?status=novo');
}

fk_flash('error', 'Došlo je do greške. Pokušajte ponovo.');
fk_redirect('index.php');
