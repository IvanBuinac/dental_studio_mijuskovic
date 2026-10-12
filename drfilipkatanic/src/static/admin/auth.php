<?php
/**
 * Sesijska autentifikacija za admin portal.
 * Koristi PDO SQLite iz db.php.
 */

declare(strict_types=1);

require_once __DIR__ . '/db.php';

require_once __DIR__ . '/log.php';

function is_logged_in(): bool
{
    return isset($_SESSION['user_id']);
}

function require_login(): void
{
    if (!is_logged_in()) {
        log_activity('access_denied', ['page' => $_SERVER['REQUEST_URI']]);
        header('Location: login.php');
        exit;
    }
}

function login(string $username, string $password): bool
{
    $pdo = db();
    $stmt = $pdo->prepare("SELECT id, password_hash FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        log_activity('login_success', ['username' => $username]);
        return true;
    }

    log_activity('login_failed', ['username' => $username]);
    return false;
}

function logout(): void
{
    log_activity('logout', ['user_id' => $_SESSION['user_id']]);
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}

session_start();
