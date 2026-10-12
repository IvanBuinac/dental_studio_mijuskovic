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

fk_session_reset();          // briše prijavu i menja ID sesije
fk_flash('success', 'Odjavljeni ste.');
fk_redirect('login.php');
