<?php
/**
 * Zajednički start za API i admin: konfiguracija, vremenska zona, greške, biblioteke.
 * Ovaj folder (lib/) je zaštićen .htaccess-om i nikad se ne poziva direktno preko weba.
 */

declare(strict_types=1);

if (defined('FK_BOOT')) {
    return;
}
define('FK_BOOT', true);
define('FK_LIB', __DIR__);
define('FK_ROOT', dirname(__DIR__)); // javni koren sajta (site/)

ini_set('display_errors', '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);

if (PHP_VERSION_ID < 80100) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Potreban je PHP 8.1 ili noviji.';
    exit;
}
if (function_exists('mb_internal_encoding')) {
    mb_internal_encoding('UTF-8');
}

require_once FK_LIB . '/helpers.php';
require_once FK_LIB . '/db.php';
require_once FK_LIB . '/Mailer.php';
require_once FK_LIB . '/notify.php';

$GLOBALS['FK_CONFIG'] = fk_load_config();

$tz = (string) cfg('timezone', 'Europe/Belgrade');
if (!@date_default_timezone_set($tz)) {
    date_default_timezone_set('Europe/Belgrade');
}
