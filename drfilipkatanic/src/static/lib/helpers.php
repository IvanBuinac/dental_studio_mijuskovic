<?php
/**
 * Pomoćne funkcije: konfiguracija, escape, log, IP, sesije, CSRF, oznake, datumi, telefon.
 */

declare(strict_types=1);

/* ------------------------------------------------------------------ konfiguracija */

function fk_default_config(): array
{
    return [
        'site_url'   => '',
        'admin_url'  => '',
        'timezone'   => 'Europe/Belgrade',
        'db_path'    => FK_ROOT . '/data/appointments.db',
        'app_secret' => '',
        'setup_key'  => '',
        'mail' => [
            'transport'        => 'mail',   // bez config.php: PHP mail()
            'host'             => '',
            'port'             => 587,
            'secure'           => 'tls',
            'username'         => '',
            'password'         => '',
            'timeout'          => 15,
            'verify_peer'      => true,
            'ehlo_host'        => '',
            'fallback_to_mail' => true,
            'from_email'       => '',
            'from_name'        => 'dr Filip Katanić',
            'reply_to'         => '',
            'doctor_email'     => '',
        ],
        'booking' => [
            'max_per_hour_per_ip'   => 5,
            'max_tries_per_hour_ip' => 30,
            'min_fill_seconds'      => 3,
            'max_months_ahead'      => 6,
        ],
        'location' => [
            'name'    => 'SB Ferona',
            'address' => 'Šarplaninska 19, Novi Sad',
            'map_url' => 'https://www.google.com/maps/search/?api=1&query=SB+Ferona+Sarplaninska+19+Novi+Sad',
        ],
        'admin' => [
            'idle_minutes'    => 120,
            'max_login_fails' => 5,
            'lock_minutes'    => 15,
        ],
        'trust_proxy' => false,
    ];
}

/** Traži config: $FK_CONFIG env → <webroot>/config.php → <iznad webroot-a>/fk-config.php */
function fk_load_config(): array
{
    $candidates = array_filter([
        getenv('FK_CONFIG') ?: null,
        FK_ROOT . '/config.php',
        dirname(FK_ROOT) . '/fk-config.php',
    ]);
    $user = [];
    foreach ($candidates as $file) {
        if (is_file($file) && is_readable($file)) {
            $loaded = (static function (string $__f) {
                return require $__f;
            })($file);
            if (is_array($loaded)) {
                $user = $loaded;
                $GLOBALS['FK_CONFIG_FILE'] = $file;
                break;
            }
        }
    }
    return array_replace_recursive(fk_default_config(), $user);
}

/** cfg('mail.host') — čitanje konfiguracije tačkastom putanjom. */
function cfg(string $path, mixed $default = null): mixed
{
    $node = $GLOBALS['FK_CONFIG'] ?? [];
    foreach (explode('.', $path) as $key) {
        if (!is_array($node) || !array_key_exists($key, $node)) {
            return $default;
        }
        $node = $node[$key];
    }
    return $node ?? $default;
}

/* ------------------------------------------------------------------ izlaz / log */

function e(mixed $value): string
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
}

/** Interni log (data/app.log + PHP error_log). Nikad se ne prikazuje korisniku. */
function app_log(string $level, string $message, array $context = []): void
{
    $line = sprintf(
        "[%s] %s: %s %s\n",
        date('Y-m-d H:i:s'),
        strtoupper($level),
        $message,
        $context ? json_encode($context, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR) : ''
    );
    $dir = fk_data_dir();
    if ($dir !== null) {
        @file_put_contents($dir . '/app.log', $line, FILE_APPEND | LOCK_EX);
    }
    error_log('[fk] ' . rtrim($line));
}

function fk_data_dir(): ?string
{
    $dir = dirname((string) cfg('db_path', FK_ROOT . '/data/appointments.db'));
    if (!is_dir($dir) && !@mkdir($dir, 0750, true)) {
        return null;
    }
    fk_protect_dir($dir);
    return is_writable($dir) ? $dir : null;
}

/** Ako je folder u webroot-u, osiguraj .htaccess (FTP klijenti često preskoče dot-fajlove). */
function fk_protect_dir(string $dir): void
{
    if (!is_file($dir . '/.htaccess')) {
        @file_put_contents(
            $dir . '/.htaccess',
            "<IfModule mod_authz_core.c>\n    Require all denied\n</IfModule>\n<IfModule !mod_authz_core.c>\n    Order allow,deny\n    Deny from all\n</IfModule>\n"
        );
    }
    if (!is_file($dir . '/index.html')) {
        @file_put_contents($dir . '/index.html', '');
    }
}

/* ------------------------------------------------------------------ zahtev / URL */

function fk_is_https(): bool
{
    if (!empty($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off') {
        return true;
    }
    if ((int) ($_SERVER['SERVER_PORT'] ?? 0) === 443) {
        return true;
    }
    if (cfg('trust_proxy') && strtolower((string) ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '')) === 'https') {
        return true;
    }
    return false;
}

function fk_client_ip(): string
{
    if (cfg('trust_proxy')) {
        foreach (['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP'] as $h) {
            if (!empty($_SERVER[$h])) {
                $ip = trim(explode(',', (string) $_SERVER[$h])[0]);
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }
    }
    return (string) ($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');
}

/** Ne čuvamo sirovu IP adresu (privatnost) — samo HMAC. */
function fk_ip_hash(?string $ip = null): string
{
    return substr(hash_hmac('sha256', $ip ?? fk_client_ip(), fk_app_secret()), 0, 32);
}

/** Bazni URL sajta (bez / na kraju): config site_url ili izveden iz zahteva. */
function fk_site_url(): string
{
    $url = rtrim((string) cfg('site_url', ''), '/');
    if ($url !== '' && !str_contains($url, 'example.')) {
        return $url;
    }
    $host = (string) ($_SERVER['HTTP_HOST'] ?? 'localhost');
    if (!preg_match('/^[a-z0-9.\-]+(:\d+)?$/i', $host)) {
        $host = 'localhost';
    }
    // skripte su uvek u /<base>/api/ ili /<base>/admin/
    $base = rtrim(str_replace('\\', '/', dirname((string) ($_SERVER['SCRIPT_NAME'] ?? '/x/y'), 2)), '/');
    return (fk_is_https() ? 'https' : 'http') . '://' . $host . $base;
}

function fk_admin_url(string $path = ''): string
{
    $url = trim((string) cfg('admin_url', ''));
    if ($url === '' || str_contains($url, 'example.')) {
        $url = fk_site_url() . '/admin/';
    }
    return rtrim($url, '/') . '/' . ltrim($path, '/');
}

function fk_json(int $status, array $payload, array $headers = []): never
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    foreach ($headers as $k => $v) {
        header($k . ': ' . $v);
    }
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function fk_api_headers(): void
{
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store, max-age=0');
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('X-Robots-Tag: noindex, nofollow');
}

/** API: neuhvaćene greške → 500 sa generičkom porukom, detalji samo u logu. */
function fk_api_error_handler(): void
{
    set_exception_handler(static function (Throwable $ex): void {
        app_log('error', 'API izuzetak: ' . $ex->getMessage(), ['file' => $ex->getFile() . ':' . $ex->getLine()]);
        if (!headers_sent()) {
            http_response_code(500);
            header('Content-Type: application/json; charset=utf-8');
        }
        echo json_encode(['ok' => false, 'error' => 'Zahtev trenutno nije moguće poslati. Pokušajte ponovo za nekoliko minuta ili nam pišite na Instagramu @drfilipkatanic.'], JSON_UNESCAPED_UNICODE);
    });
}

/* ------------------------------------------------------------------ sesija / CSRF */

function fk_start_session(string $name, string $path = '/'): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.use_trans_sid', '0');
    ini_set('session.cookie_httponly', '1');
    // Sopstveni folder za sesije (data/sessions): deljeni hosting često briše sesije posle 24 min
    // zbog tuđeg GC-a u zajedničkom /tmp. Trajanje sesije kontroliše naš kod (admin idle/remember).
    $dir = fk_data_dir();
    if ($dir !== null) {
        $sdir = $dir . '/sessions';
        if (is_dir($sdir) || @mkdir($sdir, 0700, true)) {
            session_save_path($sdir);
        }
    }
    ini_set('session.gc_maxlifetime', '2592000');
    ini_set('session.gc_probability', '1');
    ini_set('session.gc_divisor', '100');
    session_name($name);
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => $path,
        'secure'   => fk_is_https(),
        'httponly' => true,
        'samesite' => 'Strict',
    ]);
    session_start();
}

function fk_csrf_token(): string
{
    if (empty($_SESSION['_csrf']) || !is_string($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf'];
}

function fk_csrf_valid(?string $token): bool
{
    return is_string($token) && $token !== ''
        && !empty($_SESSION['_csrf']) && is_string($_SESSION['_csrf'])
        && hash_equals($_SESSION['_csrf'], $token);
}

/* ------------------------------------------------------------------ šifarnici */

function fk_enums(): array
{
    return [
        'kontakt_kanal' => [
            'telefon'  => 'Telefonski poziv',
            'viber'    => 'Viber',
            'whatsapp' => 'WhatsApp',
            'email'    => 'E-mail',
        ],
        'tip_usluge' => [
            'prva-konsultacija'         => 'Prva konsultacija',
            'drugo-misljenje'           => 'Drugo mišljenje (analiza dokumentacije)',
            'ivf'                       => 'Sterilitet i vantelesna oplodnja (IVF/ICSI)',
            'zamrzavanje-jajnih-celija' => 'Zamrzavanje jajnih ćelija',
            'pcos'                      => 'PCOS i poremećaji ovulacije',
            'muski-faktor'              => 'Muški faktor neplodnosti',
            'ginekoloski-pregled'       => 'Ginekološki pregled',
            'ostalo'                    => 'Nešto drugo',
        ],
        'doba_dana' => [
            'pre-podne'   => 'Pre podne',
            'posle-podne' => 'Posle podne',
            'svejedno'    => 'Svejedno',
        ],
        'dokumentacija_status' => [
            'imam'      => 'Imam nalaze',
            'nemam'     => 'Nemam nalaze',
            'delimicno' => 'Delimično',
        ],
        'status' => [
            'novo'       => 'Novo',
            'potvrdjeno' => 'Potvrđeno',
            'odbijeno'   => 'Odbijeno',
            'otkazano'   => 'Otkazano',
        ],
    ];
}

/** Ljudska oznaka za vrednost iz šifarnika (stari zapisi: vraća sirovu vrednost). */
function fk_label(string $group, ?string $value): string
{
    if ($value === null || $value === '') {
        return '—';
    }
    return fk_enums()[$group][$value] ?? $value;
}

/* ------------------------------------------------------------------ datumi */

function fk_now(): string
{
    return date('Y-m-d H:i:s');
}

/** "utorak, 21. oktobar 2026." */
function fk_date_sr(?string $ymd, bool $withDay = true): string
{
    if (!$ymd) {
        return '—';
    }
    $d = DateTimeImmutable::createFromFormat('!Y-m-d', substr($ymd, 0, 10));
    if (!$d) {
        return $ymd;
    }
    $days = ['nedelja', 'ponedeljak', 'utorak', 'sreda', 'četvrtak', 'petak', 'subota'];
    $months = [1 => 'januar', 'februar', 'mart', 'april', 'maj', 'jun', 'jul', 'avgust', 'septembar', 'oktobar', 'novembar', 'decembar'];
    $s = (int) $d->format('j') . '. ' . $months[(int) $d->format('n')] . ' ' . $d->format('Y') . '.';
    return $withDay ? $days[(int) $d->format('w')] . ', ' . $s : $s;
}

function fk_date_short(?string $value): string
{
    if (!$value) {
        return '—';
    }
    $ts = strtotime($value);
    if ($ts === false) {
        return $value;
    }
    return strlen($value) > 10 ? date('d.m.Y. H:i', $ts) : date('d.m.Y.', $ts);
}

/** Predlog termina se čuva kao "YYYY-MM-DD" ili "YYYY-MM-DD HH:MM". */
function fk_proposal_sr(?string $value): string
{
    if (!$value) {
        return '';
    }
    $date = substr($value, 0, 10);
    $time = trim(substr($value, 11, 5));
    return fk_date_sr($date) . ($time !== '' ? ' u ' . $time . ' h' : '');
}

function fk_valid_date(string $ymd): bool
{
    if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $ymd, $m)) {
        return false;
    }
    return checkdate((int) $m[2], (int) $m[3], (int) $m[1]);
}

function fk_valid_time(string $hm): bool
{
    return (bool) preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $hm);
}

/* ------------------------------------------------------------------ tekst / telefon */

/** Normalizuje telefon u +381… oblik; null ako nije validan. */
function fk_normalize_phone(string $raw): ?string
{
    $raw = trim($raw);
    if ($raw === '' || preg_match('/[^0-9+\s\-\.\/()]/', $raw)) {
        return null;
    }
    $count = strlen(preg_replace('/\D+/', '', $raw) ?? '');
    if ($count < 6 || $count > 20) {                 // copy-v2 §3.3: 6 do 20 cifara
        return null;
    }
    $plus = str_starts_with($raw, '+');
    $digits = preg_replace('/\D+/', '', $raw) ?? '';
    if (!$plus && str_starts_with($digits, '00')) {
        $digits = substr($digits, 2);
        $plus = true;
    }
    if (!$plus) {
        if (str_starts_with($digits, '0')) {
            $digits = '381' . substr($digits, 1);   // domaći broj: 064… → +38164…
        } elseif (str_starts_with($digits, '381')) {
            // već sa pozivnim brojem, bez +
        } else {
            $digits = '381' . $digits;
        }
    }
    if (str_starts_with($digits, '3810')) {          // +381 064… → +38164…
        $digits = '381' . substr($digits, 4);
    }
    $len = strlen($digits);
    if ($len < 6 || $len > 15) {                     // E.164: najviše 15 cifara
        return null;
    }
    if (str_starts_with($digits, '381') && $len < 9) {
        return null;                                 // srpski broj: 381 + bar 6 cifara
    }
    return '+' . $digits;
}

/** Jedan red teksta: trim, bez kontrolnih znakova, sažeti razmaci. */
function fk_clean_line(mixed $v): string
{
    $s = is_string($v) ? $v : '';
    $s = preg_replace('/[\x00-\x1F\x7F]+/u', ' ', $s) ?? '';
    $s = preg_replace('/\s{2,}/u', ' ', $s) ?? '';
    return trim($s);
}

/** Višeredni tekst: dozvoljeni novi redovi, bez ostalih kontrolnih znakova. */
function fk_clean_text(mixed $v): string
{
    $s = is_string($v) ? $v : '';
    $s = str_replace(["\r\n", "\r"], "\n", $s);
    $s = preg_replace('/[\x00-\x08\x0B-\x1F\x7F]+/u', '', $s) ?? '';
    $s = preg_replace("/\n{3,}/", "\n\n", $s) ?? '';
    return trim($s);
}

function fk_len(string $s): int
{
    return function_exists('mb_strlen') ? mb_strlen($s, 'UTF-8') : (int) preg_match_all('/./us', $s);
}

/** Za pretragu: mala slova + bez dijakritika (Katanić → katanic). */
function fk_fold(?string $s): string
{
    $s = (string) $s;
    $s = function_exists('mb_strtolower') ? mb_strtolower($s, 'UTF-8') : strtolower($s);
    return strtr($s, ['č' => 'c', 'ć' => 'c', 'š' => 's', 'ž' => 'z', 'đ' => 'dj', 'dž' => 'dz']);
}

/** Linkovi za brzi kontakt pacijenta (admin). */
function fk_contact_links(array $a): array
{
    $phone = (string) ($a['telefon'] ?? '');
    $digits = preg_replace('/\D+/', '', $phone) ?? '';
    $links = [];
    if ($digits !== '') {
        $links['Pozovi'] = 'tel:+' . $digits;
        $links['WhatsApp'] = 'https://wa.me/' . $digits;
        $links['Viber'] = 'viber://chat?number=%2B' . $digits;
    }
    if (!empty($a['email'])) {
        $links['Mejl'] = 'mailto:' . rawurlencode((string) $a['email']);
    }
    return $links;
}
