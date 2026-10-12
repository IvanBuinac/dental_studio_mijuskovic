<?php
/**
 * POST api/zakazi.php — prijem zahteva za konsultaciju (ugovor: brief-v2.md, sekcija 4).
 *
 * Polja (multipart/form-data ili x-www-form-urlencoded):
 *   csrf_token*, ime_prezime*, email*, telefon*, kontakt_kanal*, tip_usluge*, zeljeni_datum* (YYYY-MM-DD),
 *   doba_dana, partner_ime, dokumentacija_status, napomena (≤2000), saglasnost* (=1),
 *   website (honeypot — mora biti prazno), ts (opciono: Date.now() u trenutku prikaza forme)
 *
 * Odgovori:
 *   200 {"ok":true,"id":N}
 *   403 {"ok":false,"error":"…"}                       — CSRF / sesija istekla
 *   405 {"ok":false,"error":"…"}                       — nije POST
 *   422 {"ok":false,"error":"…","fields":{"polje":"…"}} — validacija
 *   429 {"ok":false,"error":"…"} + Retry-After         — rate limit
 *   500 {"ok":false,"error":"…"}                       — interna greška (detalji samo u logu)
 */

declare(strict_types=1);

require dirname(__DIR__) . '/lib/bootstrap.php';

fk_api_headers();
fk_api_error_handler();

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    fk_json(405, ['ok' => false, 'error' => 'Metod nije dozvoljen.'], ['Allow' => 'POST']);
}

$ipKey = fk_ip_hash();

/* --- 1. grubi limit svih pokušaja (štiti od skeniranja/bombardovanja) */
$maxTries = (int) cfg('booking.max_tries_per_hour_ip', 30);
if (fk_rate_count('zakazi_try', $ipKey, 3600) >= $maxTries) {
    fk_json(429, ['ok' => false, 'error' => 'Previše pokušaja u kratkom roku. Pokušajte ponovo za nekoliko minuta ili nam pišite na Instagramu.'], [
        'Retry-After' => (string) fk_rate_retry_after('zakazi_try', $ipKey, 3600),
    ]);
}
fk_rate_hit('zakazi_try', $ipKey);

/* --- 2. CSRF */
fk_start_session('fk_pub');
$csrfOk = fk_csrf_valid(is_string($_POST['csrf_token'] ?? null) ? $_POST['csrf_token'] : null);
session_write_close();
if (!$csrfOk) {
    fk_json(403, ['ok' => false, 'error' => 'Sesija je istekla. Osvežite stranicu i pokušajte ponovo.']);
}

/* --- 3. limit uspešnih zahteva po IP */
$maxOk = (int) cfg('booking.max_per_hour_per_ip', 5);
if (fk_rate_count('zakazi_ok', $ipKey, 3600) >= $maxOk) {
    fk_json(429, ['ok' => false, 'error' => 'Previše pokušaja u kratkom roku. Pokušajte ponovo za nekoliko minuta ili nam pišite na Instagramu.'], [
        'Retry-After' => (string) fk_rate_retry_after('zakazi_ok', $ipKey, 3600),
    ]);
}

/* --- 4. honeypot: botu glumimo uspeh, ništa se ne upisuje */
if (trim((string) (is_string($_POST['website'] ?? null) ? $_POST['website'] : '')) !== '' || is_array($_POST['website'] ?? null)) {
    fk_rate_hit('zakazi_ok', $ipKey);
    app_log('info', 'Honeypot: odbačen zahtev', ['ip' => $ipKey]);
    fk_json(200, ['ok' => true, 'id' => 0]);
}

/* --- 5. minimalno vreme popunjavanja (samo ako frontend pošalje ts u ms) */
$ts = $_POST['ts'] ?? '';
if (is_string($ts) && ctype_digit($ts) && strlen($ts) >= 12 && strlen($ts) <= 14) {
    $elapsedMs = (int) floor(microtime(true) * 1000) - (int) $ts;
    $minMs = (int) cfg('booking.min_fill_seconds', 3) * 1000;
    if ($elapsedMs >= 0 && $elapsedMs < $minMs) {
        app_log('info', 'Prebrzo popunjena forma', ['ms' => $elapsedMs, 'ip' => $ipKey]);
        fk_json(422, ['ok' => false, 'error' => 'Forma je poslata prebrzo. Proverite podatke i pošaljite ponovo.', 'fields' => (object) []]);
    }
}

/* --- 6. validacija */
$enums = fk_enums();
$errors = [];
$in = static fn (string $k): mixed => $_POST[$k] ?? null;

$ime = fk_clean_line($in('ime_prezime'));
if ($ime === '') {
    $errors['ime_prezime'] = 'Unesite ime i prezime.';
} elseif (fk_len($ime) < 2) {
    $errors['ime_prezime'] = 'Ime mora imati bar 2 znaka.';
} elseif (fk_len($ime) > 100) {
    $errors['ime_prezime'] = 'Ime može imati najviše 100 znakova.';
} elseif (!preg_match("/^\p{L}[\p{L}\p{M} .'’\-]*$/u", $ime) || preg_match_all('/\p{L}/u', $ime) < 2) {
    $errors['ime_prezime'] = 'Ime i prezime može sadržati samo slova, razmak, crticu i apostrof.';
}

$email = strtolower(fk_clean_line($in('email')));
if ($email === '') {
    $errors['email'] = 'Unesite e-mail adresu.';
} elseif (strlen($email) > 190 || !Mailer::validEmail($email)) {
    $errors['email'] = 'E-mail adresa nije ispravna — proverite da li sadrži @ i domen.';
}

$telRaw = fk_clean_line($in('telefon'));
$telefon = null;
if ($telRaw === '') {
    $errors['telefon'] = 'Unesite broj telefona.';
} elseif (strlen($telRaw) > 30 || ($telefon = fk_normalize_phone($telRaw)) === null) {
    $errors['telefon'] = 'Broj telefona nije ispravan — unesite 6 do 20 cifara.';
}

$kanal = fk_clean_line($in('kontakt_kanal'));
if ($kanal === '') {
    $errors['kontakt_kanal'] = 'Izaberite način kontakta.';
} elseif (!isset($enums['kontakt_kanal'][$kanal])) {
    $errors['kontakt_kanal'] = 'Izaberite način kontakta.';
}

$usluga = fk_clean_line($in('tip_usluge'));
if ($usluga === '') {
    $errors['tip_usluge'] = 'Izaberite razlog konsultacije.';
} elseif (!isset($enums['tip_usluge'][$usluga])) {
    $errors['tip_usluge'] = 'Izaberite razlog konsultacije.';
}

$datum = fk_clean_line($in('zeljeni_datum'));
$maxMonths = (int) cfg('booking.max_months_ahead', 6);
if ($datum === '') {
    $errors['zeljeni_datum'] = 'Izaberite željeni datum.';
} elseif (!fk_valid_date($datum)) {
    $errors['zeljeni_datum'] = 'Izaberite željeni datum.';
} else {
    $today = new DateTimeImmutable('today');
    $d = new DateTimeImmutable($datum);
    if ($d < $today) {
        $errors['zeljeni_datum'] = 'Datum ne može biti u prošlosti.';
    } elseif ($d > $today->modify('+' . $maxMonths . ' months')) {
        $errors['zeljeni_datum'] = 'Izaberite datum u narednih ' . $maxMonths . ' meseci.';
    }
}

$doba = fk_clean_line($in('doba_dana'));
if ($doba === '') {
    $doba = 'svejedno';
} elseif (!isset($enums['doba_dana'][$doba])) {
    $errors['doba_dana'] = 'Izaberite jednu od ponuđenih opcija.';
}

$partner = fk_clean_line($in('partner_ime'));
if (fk_len($partner) > 100) {
    $errors['partner_ime'] = 'Ime partnera može imati najviše 100 znakova.';
}

$dok = fk_clean_line($in('dokumentacija_status'));
if ($dok !== '' && !isset($enums['dokumentacija_status'][$dok])) {
    $errors['dokumentacija_status'] = 'Izaberite jednu od ponuđenih opcija.';
}

$napomena = fk_clean_text($in('napomena'));
if (fk_len($napomena) > 2000) {
    $errors['napomena'] = 'Napomena može imati najviše 2000 znakova.';
}

$saglasnost = strtolower(trim(is_string($in('saglasnost')) ? $in('saglasnost') : ''));
if (!in_array($saglasnost, ['1', 'on', 'true', 'da', 'yes'], true)) {
    $errors['saglasnost'] = 'Za slanje zahteva potrebna je Vaša saglasnost.';
}

if ($errors) {
    fk_json(422, [
        'ok'     => false,
        'error'  => count($errors) === 1 ? reset($errors) : 'Proverite označena polja.',
        'fields' => $errors,
    ]);
}

/* --- 7. upis (zaštita od duplog klika: isti zahtev u poslednjih 10 min vraća postojeći id) */
$pdo = db();
$dup = $pdo->prepare("SELECT id FROM appointments WHERE email = ? AND zeljeni_datum = ? AND tip_usluge = ? AND status = 'novo'
                      AND datum_kreiranja >= ? ORDER BY id DESC LIMIT 1");
$dup->execute([$email, $datum, $usluga, date('Y-m-d H:i:s', time() - 600)]);
$existing = $dup->fetchColumn();
if ($existing) {
    fk_json(200, ['ok' => true, 'id' => (int) $existing]);
}

$now = fk_now();
$st = $pdo->prepare("INSERT INTO appointments (
        ime_prezime, partner_ime, telefon, kontakt_kanal, email, tip_usluge, zeljeni_datum, doba_dana,
        dokumentacija_status, napomena, status, datum_kreiranja, updated_at, ip_hash, saglasnost_at
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'novo', ?, ?, ?, ?)");
$st->execute([
    $ime, $partner !== '' ? $partner : null, $telefon, $kanal, $email, $usluga, $datum, $doba,
    $dok !== '' ? $dok : null, $napomena !== '' ? $napomena : null, $now, $now, $ipKey, $now,
]);
$id = (int) $pdo->lastInsertId();
fk_rate_hit('zakazi_ok', $ipKey);
fk_activity('kreiran', $id, ['izvor' => 'sajt']);

$appointment = fk_appointment($id);
$payload = (string) json_encode(['ok' => true, 'id' => $id], JSON_UNESCAPED_UNICODE);

/* --- 8. mejlovi — neuspeh ne obara zahtev. Na PHP-FPM/LiteSpeed odgovor ide pre slanja mejla. */
ignore_user_abort(true);
http_response_code(200);
$finish = function_exists('fastcgi_finish_request') ? 'fastcgi_finish_request'
    : (function_exists('litespeed_finish_request') ? 'litespeed_finish_request' : null);
if ($finish !== null) {
    echo $payload;
    $finish();
}
try {
    if ($appointment) {
        fk_send_appointment_email('primljen', $appointment);
        fk_send_appointment_email('doktor', $appointment);
    }
} catch (Throwable $e) {
    app_log('error', 'Slanje mejlova posle zahteva: ' . $e->getMessage(), ['id' => $id]);
}
if ($finish === null) {
    echo $payload;
}
