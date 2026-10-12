<?php
/**
 * Odjava (samo POST sa CSRF tokenom). GET samo vraća na listu.
 */

declare(strict_types=1);

require dirname(__DIR__) . '/lib/admin.php';
fk_admin_boot();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    fk_redirect('index.php');
}
fk_require_csrf();

$uid = (int) ($_SESSION['fk_uid'] ?? 0);
if ($uid > 0) {
    fk_activity('odjava', null, null, $uid);
}
$_SESSION = [];
$p = session_get_cookie_params();
setcookie(session_name(), '', [
    'expires'  => time() - 3600,
    'path'     => $p['path'],
    'secure'   => $p['secure'],
    'httponly' => true,
    'samesite' => 'Strict',
]);
session_destroy();

fk_start_session(FK_ADMIN_COOKIE, fk_admin_path());
session_regenerate_id(true);
fk_flash('success', 'Odjavljeni ste.');
fk_redirect('login.php');
