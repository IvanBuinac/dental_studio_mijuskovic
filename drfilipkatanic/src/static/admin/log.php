<?php
/**
 * Logovanje aktivnosti u admin portalu.
 * Zapisuje u /data/admin.log (zaštićeno .htaccess-om).
 */

declare(strict_types=1);

function log_activity(string $action, array $context = []): void
{
    $dir = dirname(__DIR__) . '/data';
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    $logFile = $dir . '/admin.log';
    $timestamp = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $user = $_SESSION['user_id'] ?? 'guest';

    $contextStr = json_encode($context, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    $logEntry = "[$timestamp] [$ip] [$user] $action: $contextStr\n";

    file_put_contents($logFile, $logEntry, FILE_APPEND);
}
