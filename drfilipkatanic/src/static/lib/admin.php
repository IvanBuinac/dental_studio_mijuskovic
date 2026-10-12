<?php
/**
 * Admin: sesija, prijava/zaključavanje, CSRF, flash poruke, zaglavlje/podnožje stranica.
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
    header('Permissions-Policy: camera=(), microphone=(), geolocation=(), interest-cohort=()');
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
        echo '<!doctype html><meta charset="utf-8"><title>Greška</title><body style="font-family:sans-serif;padding:2rem;background:#FBF8F3;color:#12223D">'
            . '<h1>Došlo je do greške</h1><p>Detalji su upisani u log. Pokušajte ponovo ili se vratite na <a href="index.php">listu zahteva</a>.</p>';
    });

    // SameSite=Strict: link iz mejla (druga stranica) stiže BEZ kolačića. Umesto da napravimo novu
    // (praznu) sesiju i pregazimo postojeću, jednom "odbijemo" zahtev na isti URL sa našeg sajta.
    $site = (string) ($_SERVER['HTTP_SEC_FETCH_SITE'] ?? '');
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET' && empty($_COOKIE[FK_ADMIN_COOKIE])
        && in_array($site, ['cross-site', 'none'], true) && !isset($_GET['_b'])) {
        $uri = (string) ($_SERVER['REQUEST_URI'] ?? 'index.php');
        $url = $uri . (str_contains($uri, '?') ? '&' : '?') . '_b=1';
        header('Content-Type: text/html; charset=utf-8');
        echo '<!doctype html><meta charset="utf-8"><meta http-equiv="refresh" content="0;url=' . e($url) . '">'
            . '<title>Preusmeravanje…</title><p style="font-family:sans-serif">Preusmeravanje… <a href="' . e($url) . '">nastavi</a></p>';
        exit;
    }

    fk_start_session(FK_ADMIN_COOKIE, fk_admin_path());

    if (!empty($_SESSION['fk_uid'])) {
        $remember = !empty($_SESSION['fk_remember']);
        $idle = $remember ? FK_REMEMBER_SECONDS : max(5, (int) cfg('admin.idle_minutes', 120)) * 60;
        $maxAge = $remember ? FK_REMEMBER_SECONDS : 43200;
        $last = (int) ($_SESSION['fk_seen'] ?? 0);
        $born = (int) ($_SESSION['fk_born'] ?? 0);
        if (time() - $last > $idle || time() - $born > $maxAge) {
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

function fk_user(): ?array
{
    static $cache = null;
    $uid = (int) ($_SESSION['fk_uid'] ?? 0);
    if ($uid <= 0) {
        return null;
    }
    if ($cache !== null && (int) $cache['id'] === $uid) {
        return $cache;
    }
    $st = db()->prepare('SELECT id, username, full_name, email, last_login_at FROM users WHERE id = ?');
    $st->execute([$uid]);
    $cache = $st->fetch() ?: null;
    if ($cache === null) {
        fk_session_reset();
    }
    return $cache;
}

function fk_users_count(): int
{
    return (int) db()->query('SELECT COUNT(*) FROM users')->fetchColumn();
}

function fk_require_login(): array
{
    if (fk_users_count() === 0) {
        fk_redirect('setup.php');
    }
    $user = fk_user();
    if ($user === null) {
        $next = basename((string) ($_SERVER['SCRIPT_NAME'] ?? 'index.php'));
        $qs = (string) ($_SERVER['QUERY_STRING'] ?? '');
        fk_redirect('login.php?next=' . rawurlencode($next . ($qs !== '' ? '?' . $qs : '')));
    }
    return $user;
}

/** Dozvoljava samo lokalne admin stranice kao "next" (zaštita od open redirect-a). */
function fk_safe_next(?string $next): string
{
    $next = (string) $next;
    if (preg_match('/^[a-z0-9_\-]+\.php(\?[A-Za-z0-9_=&%.\-]*)?$/', $next) && !str_starts_with($next, 'login.php') && !str_starts_with($next, 'logout.php')) {
        return $next;
    }
    return 'index.php';
}

function fk_redirect(string $to): never
{
    header('Location: ' . $to, true, 303);
    exit;
}

/* ------------------------------------------------------------------ prijava */

/**
 * @return array{ok:bool, error?:string}
 */
function fk_login(string $username, string $password, bool $remember = false): array
{
    $pdo = db();
    $ipKey = fk_ip_hash();
    $maxFails = max(3, (int) cfg('admin.max_login_fails', 5));
    $lockSec = max(60, (int) cfg('admin.lock_minutes', 15) * 60);

    if (fk_rate_count('login_fail', $ipKey, $lockSec) >= $maxFails) {
        $min = (int) ceil(fk_rate_retry_after('login_fail', $ipKey, $lockSec) / 60);
        fk_activity('prijava_blokirana_ip', null, ['korisnik' => mb_substr($username, 0, 60)]);
        return ['ok' => false, 'error' => "Previše neuspelih pokušaja. Pokušajte ponovo za {$min} minuta."];
    }

    $st = $pdo->prepare('SELECT * FROM users WHERE username = ? COLLATE NOCASE');
    $st->execute([$username]);
    $user = $st->fetch() ?: null;

    if ($user && !empty($user['locked_until']) && (int) $user['locked_until'] > time()) {
        $min = (int) ceil(((int) $user['locked_until'] - time()) / 60);
        fk_rate_hit('login_fail', $ipKey);
        return ['ok' => false, 'error' => "Previše neuspelih pokušaja. Pokušajte ponovo za {$min} minuta."];
    }

    // password_verify i kad korisnik ne postoji — isto trajanje, bez otkrivanja postojanja naloga
    $hash = $user['password_hash'] ?? '$2y$10$V/rpsGNemEJbrW4QGn3VjuqT68hcwGXI7S3wGBSh/iqf4VFle8E7u';
    $valid = password_verify($password, (string) $hash) && $user !== null;

    if (!$valid) {
        fk_rate_hit('login_fail', $ipKey);
        if ($user) {
            $fails = (int) $user['failed_attempts'] + 1;
            $lockUntil = $fails >= $maxFails ? time() + $lockSec : null;
            $pdo->prepare('UPDATE users SET failed_attempts = ?, locked_until = ? WHERE id = ?')
                ->execute([$lockUntil ? 0 : $fails, $lockUntil, $user['id']]);
            if ($lockUntil) {
                fk_activity('nalog_zakljucan', null, ['korisnik' => $user['username']], (int) $user['id']);
            }
        }
        fk_activity('prijava_neuspesna', null, ['korisnik' => mb_substr($username, 0, 60)]);
        return ['ok' => false, 'error' => 'Pogrešno korisničko ime ili lozinka.'];
    }

    if (password_needs_rehash((string) $user['password_hash'], PASSWORD_DEFAULT)) {
        $pdo->prepare('UPDATE users SET password_hash = ? WHERE id = ?')
            ->execute([password_hash($password, PASSWORD_DEFAULT), $user['id']]);
    }
    $pdo->prepare('UPDATE users SET failed_attempts = 0, locked_until = NULL, last_login_at = ? WHERE id = ?')
        ->execute([fk_now(), $user['id']]);
    fk_rate_clear('login_fail', $ipKey);

    fk_session_reset();
    $_SESSION['fk_uid'] = (int) $user['id'];
    $_SESSION['fk_born'] = time();
    $_SESSION['fk_seen'] = time();
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
    fk_activity('prijava', null, null, (int) $user['id']);
    return ['ok' => true];
}

/* ------------------------------------------------------------------ CSRF / flash */

function fk_csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(fk_csrf_token()) . '">';
}

/** Prekida obradu ako CSRF token ne valja. */
function fk_require_csrf(): void
{
    $t = $_POST['csrf_token'] ?? null;
    if (!fk_csrf_valid(is_string($t) ? $t : null)) {
        http_response_code(403);
        fk_flash('error', 'Sesija je istekla. Osvežite stranicu i pokušajte ponovo.');
        $back = fk_safe_next(basename((string) ($_SERVER['SCRIPT_NAME'] ?? 'index.php')));
        header('Location: ' . $back, true, 303);
        exit;
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

function fk_status_badge(string $status): string
{
    return '<span class="badge badge--' . e($status) . '">' . e(fk_label('status', $status)) . '</span>';
}

function fk_admin_header(string $title, ?array $user = null, string $active = ''): void
{
    $flashes = fk_flashes();
    $newCount = 0;
    if ($user) {
        $newCount = (int) db()->query("SELECT COUNT(*) FROM appointments WHERE status = 'novo'")->fetchColumn();
    }
    $fullTitle = str_contains($title, '|') ? $title : $title . ' | Admin';
    $self = basename((string) ($_SERVER['SCRIPT_NAME'] ?? 'index.php'));
    $refresh = $self . (($_SERVER['QUERY_STRING'] ?? '') !== '' ? '?' . $_SERVER['QUERY_STRING'] : '');
    ?><!DOCTYPE html>
<html lang="sr-Latn-RS">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="robots" content="noindex, nofollow">
<meta name="theme-color" content="#12223D">
<title><?= e($fullTitle) ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Mulish:wght@400;600;700&display=swap">
<link rel="stylesheet" href="admin.css?v=3">
<link rel="icon" href="../favicon.svg" type="image/svg+xml">
<script src="admin.js?v=3" defer></script>
</head>
<body class="<?= $user ? 'is-auth' : 'is-guest' ?>">
<?php if ($user): ?>
<header class="topbar">
  <div class="wrap topbar__in">
    <a class="brand" href="index.php" aria-label="Zakazivanja — lista zahteva">
      <span class="brand__mark" aria-hidden="true">FK</span>
      <span class="brand__txt"><strong>Zakazivanja</strong><small>dr Filip Katanić</small></span>
    </a>
    <?php if ($newCount > 0): ?>
      <a class="newbadge" href="index.php?status=novo" aria-label="<?= $newCount ?> novih zahteva"><?= $newCount ?> <?= $newCount === 1 ? 'nov' : 'novih' ?></a>
    <?php endif; ?>
    <nav class="topnav" aria-label="Admin meni">
      <a href="<?= e($refresh) ?>" class="topnav__refresh">Osveži</a>
      <details class="menu">
        <summary aria-label="Meni">⋯</summary>
        <div class="menu__panel">
          <a href="index.php" class="<?= $active === 'list' ? 'is-active' : '' ?>">Zahtevi</a>
          <a href="lozinka.php" class="<?= $active === 'pass' ? 'is-active' : '' ?>">Promena lozinke</a>
          <form method="post" action="logout.php">
            <?= fk_csrf_field() ?>
            <button type="submit" class="linkbtn">Odjava</button>
          </form>
        </div>
      </details>
    </nav>
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
<footer class="wrap foot">dr Filip Katanić · Zakazivanja — admin</footer>
</body>
</html>
<?php
}

/* ------------------------------------------------------------------ lista / filteri (index + izvoz) */

const FK_SORTS = [
    'novi'   => ['Najnovije prvo', 'a.id DESC'],
    'datum'  => ['Po željenom datumu', 'a.zeljeni_datum ASC, a.id ASC'],
    'termin' => ['Po potvrđenom terminu', 'CASE WHEN a.potvrdjeni_datum IS NULL THEN 1 ELSE 0 END, a.potvrdjeni_datum ASC, a.potvrdjeno_vreme ASC'],
    'stari'  => ['Najstarije prvo', 'a.id ASC'],
    'ime'    => ['Po imenu (A–Ž)', 'fk_fold(a.ime_prezime) ASC'],
];

/** Čita filtere iz $_GET i vraća [filters, whereSql, params, orderSql]. */
function fk_list_query(array $get): array
{
    $status = is_string($get['status'] ?? null) ? $get['status'] : 'novo';
    if ($status !== 'svi' && !isset(fk_enums()['status'][$status])) {
        $status = 'novo';
    }
    $q = mb_substr(fk_clean_line($get['q'] ?? ''), 0, 80);
    $sort = is_string($get['sort'] ?? null) && isset(FK_SORTS[$get['sort']]) ? $get['sort'] : 'novi';

    $where = [];
    $params = [];
    if ($status !== 'svi') {
        $where[] = 'a.status = ?';
        $params[] = $status;
    }
    if ($q !== '') {
        $or = ['fk_fold(a.ime_prezime) LIKE ?', 'fk_fold(a.email) LIKE ?', 'fk_fold(a.partner_ime) LIKE ?', 'a.telefon LIKE ?'];
        $like = '%' . str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], fk_fold($q)) . '%';
        $or = array_map(static fn ($c) => $c . " ESCAPE '\\'", $or);
        array_push($params, $like, $like, $like, $like);
        $digits = preg_replace('/\D+/', '', $q) ?? '';
        if (strlen($digits) >= 4) {
            $or[] = 'a.telefon LIKE ?';
            $params[] = '%' . (str_starts_with($digits, '0') ? substr($digits, 1) : $digits) . '%';
        }
        if (preg_match('/^#?(\d{1,7})$/', $q, $m)) {
            $or[] = 'a.id = ?';
            $params[] = (int) $m[1];
        }
        $where[] = '(' . implode(' OR ', $or) . ')';
    }
    return [
        ['status' => $status, 'q' => $q, 'sort' => $sort],
        $where ? 'WHERE ' . implode(' AND ', $where) : '',
        $params,
        'ORDER BY ' . FK_SORTS[$sort][1],
    ];
}

function fk_status_counts(): array
{
    $counts = ['novo' => 0, 'potvrdjeno' => 0, 'odbijeno' => 0, 'otkazano' => 0, 'svi' => 0];
    foreach (db()->query('SELECT status, COUNT(*) c FROM appointments GROUP BY status')->fetchAll() as $r) {
        $counts[$r['status']] = (int) $r['c'];
        $counts['svi'] += (int) $r['c'];
    }
    return $counts;
}

/** "upravo sada · pre {n} min · pre {n} h · juče · {datum}" (copy-v2 §7.3) */
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
