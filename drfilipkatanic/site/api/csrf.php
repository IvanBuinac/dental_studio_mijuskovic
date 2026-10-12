<?php
/**
 * GET api/csrf.php → {"token":"…"}
 * Token je vezan za sesiju (kolačić fk_pub, HttpOnly, SameSite=Strict) i šalje se kao csrf_token u api/zakazi.php.
 */

declare(strict_types=1);

require dirname(__DIR__) . '/lib/bootstrap.php';

fk_api_headers();
fk_api_error_handler();

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'GET') {
    fk_json(405, ['ok' => false, 'error' => 'Metod nije dozvoljen.'], ['Allow' => 'GET']);
}

fk_start_session('fk_pub');
$token = fk_csrf_token();
session_write_close();

fk_json(200, ['token' => $token]);
