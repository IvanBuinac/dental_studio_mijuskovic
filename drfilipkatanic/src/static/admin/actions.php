<?php
/**
 * Akcije za admin portal (ažuriranje statusa, beleške).
 */

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_login();

$pdo = db();

require_once __DIR__ . '/log.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = (int) ($_POST['id'] ?? 0);

    if ($action === 'update_status' && $id > 0) {
        $status = $_POST['status'] ?? '';
        $note = $_POST['doktor_beleska'] ?? '';

        if (in_array($status, ['prihvaceno', 'odbijeno', 'otkazano'], true)) {
            $stmt = $pdo->prepare("UPDATE appointments SET status = ?, doktor_beleska = ? WHERE id = ?");
            $stmt->execute([$status, $note, $id]);
            log_activity('appointment_status_update', ['id' => $id, 'status' => $status]);
        }
    }

    header('Location: index.php');
    exit;
}

header('HTTP/1.1 400 Bad Request');
