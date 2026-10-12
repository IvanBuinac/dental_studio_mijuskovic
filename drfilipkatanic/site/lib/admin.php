<?php
/**
 * Admin (jednostavan): jedna lozinka, sesija, CSRF, flash poruke, zaglavlje/podnožje.
 *
 * Lozinka:  config.php → 'admin_password_hash' (ako je postavljen), inače hash sačuvan
 *           kroz admin/setup.php (jednom, tabela settings). Bez korisničkih imena i više naloga.
 * Zaštita:  zaključavanje posle 5 pogrešnih pokušaja (15 min, po IP), SameSite=Strict kolačić,
 *           regenerisanje ID-a sesije, automatska odjava posle neaktivnosti.
 */

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

const FK_ADMIN_COOKIE = 'fk_admin';
const FK_REMEMBER_SECONDS = 2592000; // "Zapamti me": 30 dana

function fk_admin_headers(): void
{
    header('X-Frame-Options: DENY');
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: same-origin');
    header('X-Robots-Tag: noindex, nofollow, noarchive');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
    header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data:; form-action 'self'; frame-ancestors 'none'; base-uri 'self'; object-src 'none'");
    if (fk_is_https()) {
        header('Strict-Transport-Security: max-age=31536000');
    }
}

function fk_admin_path(): string
{
    $dir = str_replace('\\', '/', dirname((string) ($_SERVER['SCRIPT_NAME'] ?? '/admin/index.php')));
    return rtrim($dir, '/') . '/';
}

/** Pokreće admin sesiju; ističe posle neaktivnosti. */
function fk_admin_boot(): void
{
    fk_admin_headers();
    set_exception_handler(static function (Throwable $ex): void {
        app_log('error', 'Admin izuzetak: ' . $ex->getMessage(), ['file' => $ex->getFile() . ':' . $ex->getLine()]);
        if (!headers_sent()) {
            http_response_code(500);
            header('Content-Type: text/html; charset=utf-8');
        }
        echo '<!doctype html><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Greška</title><link rel="stylesheet" href="admin.css">'
            . '<body><main class="wrap">'
            . '<h1>Došlo je do greške</h1><p>Pokušajte ponovo. <a href="index.php">Nazad na zahteve</a></p>';
    });

    // SameSite=Strict: link iz mejla (sa druge stranice) stiže BEZ kolačića. Umesto da napravimo novu,
    // praznu sesiju i "izlogujemo" doktora, jednom preusmerimo na isti URL sa našeg sajta.
    $site = (string) ($_SERVER['HTTP_SEC_FETCH_SITE'] ?? '');
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET' && empty($_COOKIE[FK_ADMIN_COOKIE])
        && in_array($site, ['cross-site', 'none'], true) && !isset($_GET['_b'])) {
        $uri = (string) ($_SERVER['REQUEST_URI'] ?? 'index.php');
        $url = $uri . (str_contains($uri, '?') ? '&' : '?') . '_b=1';
        header('Content-Type: text/html; charset=utf-8');
        echo '<!doctype html><meta charset="utf-8"><meta http-equiv="refresh" content="0;url=' . e($url) . '">'
            . '<title>Preusmeravanje…</title><p>Preusmeravanje… <a href="' . e($url) . '">nastavi</a></p>';
        exit;
    }

    fk_start_session(FK_ADMIN_COOKIE, fk_admin_path());

    if (!empty($_SESSION['fk_auth'])) {
        $remember = !empty($_SESSION['fk_remember']);
        $idle = $remember ? FK_REMEMBER_SECONDS : max(5, (int) cfg('admin.idle_minutes', 120)) * 60;
        $maxAge = $remember ? FK_REMEMBER_SECONDS : 43200;
        $last = (int) ($_SESSION['fk_seen'] ?? 0);
        $born = (int) ($_SESSION['fk_born'] ?? 0);
        $pwVer = (string) ($_SESSION['fk_pwv'] ?? '');
        if (time() - $last > $idle || time() - $born > $maxAge || $pwVer !== fk_password_version()) {
            fk_session_reset();
            fk_flash('info', 'Iz bezbednosnih razloga ste odjavljeni. Prijavite se ponovo.');
        } else {
            $_SESSION['fk_seen'] = time();
        }
    }
}

function fk_session_reset(): void
{
    $_SESSION = [];
    session_regenerate_id(true);
}

/* ------------------------------------------------------------------ lozinka */

/** Aktivni hash lozinke: config.php ima prednost nad onim iz setup.php. */
function fk_password_hash(): ?string
{
    $cfg = trim((string) cfg('admin_password_hash', ''));
    if ($cfg !== '' && str_starts_with($cfg, '$')) {
        return $cfg;
    }
    return fk_setting('admin_password_hash');
}

/** Promena lozinke (u config-u ili brisanjem i ponovnim setup-om) poništava postojeće prijave. */
function fk_password_version(): string
{
    return substr(hash('sha256', (string) fk_password_hash()), 0, 16);
}

function fk_is_logged_in(): bool
{
    return !empty($_SESSION['fk_auth']);
}

function fk_require_login(): void
{
    if (fk_password_hash() === null) {
        fk_redirect('setup.php');
    }
    if (!fk_is_logged_in()) {
        fk_redirect('login.php');
    }
}

/** @return array{ok:bool, error?:string} */
function fk_login(string $password, bool $remember = false): array
{
    $ipKey = fk_ip_hash();
    $maxFails = max(3, (int) cfg('admin.max_login_fails', 5));
    $lockSec = max(60, (int) cfg('admin.lock_minutes', 15) * 60);

    if (fk_rate_count('login_fail', $ipKey, $lockSec) >= $maxFails) {
        $min = (int) ceil(fk_rate_retry_after('login_fail', $ipKey, $lockSec) / 60);
        return ['ok' => false, 'error' => "Previše neuspelih pokušaja. Pokušajte ponovo za {$min} minuta."];
    }

    $hash = (string) fk_password_hash();
    if ($hash === '' || !password_verify($password, $hash)) {
        fk_rate_hit('login_fail', $ipKey);
        app_log('info', 'Neuspešna prijava u admin', ['ip' => $ipKey]);
        if (fk_rate_count('login_fail', $ipKey, $lockSec) >= $maxFails) {
            return ['ok' => false, 'error' => 'Previše neuspelih pokušaja. Pokušajte ponovo za ' . (int) ceil($lockSec / 60) . ' minuta.'];
        }
        return ['ok' => false, 'error' => 'Pogrešna lozinka.'];
    }

    if (password_needs_rehash($hash, PASSWORD_DEFAULT) && trim((string) cfg('admin_password_hash', '')) === '') {
        fk_setting_set('admin_password_hash', password_hash($password, PASSWORD_DEFAULT));
    }
    fk_rate_clear('login_fail', $ipKey);

    fk_session_reset();
    $_SESSION['fk_auth'] = 1;
    $_SESSION['fk_born'] = time();
    $_SESSION['fk_seen'] = time();
    $_SESSION['fk_pwv'] = fk_password_version();
    if ($remember) {
        $_SESSION['fk_remember'] = 1;
        $p = session_get_cookie_params();
        setcookie(session_name(), session_id(), [
            'expires'  => time() + FK_REMEMBER_SECONDS,
            'path'     => $p['path'],
            'secure'   => $p['secure'],
            'httponly' => true,
            'samesite' => 'Strict',
        ]);
    }
    return ['ok' => true];
}

/* ------------------------------------------------------------------ CSRF / flash / redirect */

function fk_redirect(string $to): never
{
    header('Location: ' . $to, true, 303);
    exit;
}

function fk_csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(fk_csrf_token()) . '">';
}

/** Prekida obradu ako CSRF token ne valja. */
function fk_require_csrf(string $back = 'index.php'): void
{
    $t = $_POST['csrf_token'] ?? null;
    if (!fk_csrf_valid(is_string($t) ? $t : null)) {
        fk_flash('error', 'Sesija je istekla. Osvežite stranicu i pokušajte ponovo.');
        fk_redirect($back);
    }
}

function fk_flash(string $type, string $message): void
{
    $_SESSION['fk_flash'][] = ['type' => $type, 'msg' => $message];
}

function fk_flashes(): array
{
    $f = $_SESSION['fk_flash'] ?? [];
    unset($_SESSION['fk_flash']);
    return is_array($f) ? $f : [];
}

/* ------------------------------------------------------------------ prikaz */

/** "upravo sada · pre {n} min · pre {n} h · juče · {datum}" */
function fk_relative(?string $dt): string
{
    $ts = $dt ? strtotime($dt) : false;
    if ($ts === false) {
        return '—';
    }
    $diff = time() - $ts;
    if ($diff < 60) {
        return 'upravo sada';
    }
    if ($diff < 3600) {
        return 'pre ' . intdiv($diff, 60) . ' min';
    }
    if (date('Y-m-d', $ts) === date('Y-m-d')) {
        return 'pre ' . intdiv($diff, 3600) . ' h';
    }
    if (date('Y-m-d', $ts) === date('Y-m-d', strtotime('-1 day'))) {
        return 'juče';
    }
    return date('d.m.Y.', $ts);
}

function fk_admin_header(string $title, bool $auth = false): void
{
    $flashes = fk_flashes();
    ?><!DOCTYPE html>
<html lang="sr-Latn-RS">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="robots" content="noindex, nofollow">
<meta name="theme-color" content="#12223D">
<title><?= e($title) ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;1,400&family=Mulish:wght@400;600;700&display=swap">
<link rel="stylesheet" href="admin.css?v=4">
<link rel="icon" href="../favicon.svg" type="image/svg+xml">
<script src="admin.js?v=4" defer></script>
</head>
<body class="<?= $auth ? 'is-auth' : 'is-guest' ?>">
<?php if ($auth): ?>
<header class="topbar">
  <div class="wrap topbar__in">
    <a class="brand" href="index.php">
      <span class="brand__mark" aria-hidden="true">FK</span>
      <span class="brand__txt"><strong>Zakazivanja</strong><small>dr Filip Katanić</small></span>
    </a>
    <div class="topbar__right">
      <a class="topbar__link" href="index.php">Osveži</a>
      <form method="post" action="logout.php">
        <?= fk_csrf_field() ?>
        <button type="submit" class="topbar__link">Odjava</button>
      </form>
    </div>
  </div>
</header>
<?php endif; ?>
<main class="wrap main" id="main">
<?php foreach ($flashes as $f): ?>
  <div class="flash flash--<?= e($f['type']) ?>" role="<?= $f['type'] === 'error' ? 'alert' : 'status' ?>"><?= e($f['msg']) ?></div>
<?php endforeach;
}

function fk_admin_footer(): void
{
    ?>
</main>
<footer class="wrap foot">dr Filip Katanić · Zakazivanja</footer>
</body>
</html>
<?php
}
