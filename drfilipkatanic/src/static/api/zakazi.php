<?php
/**
 * API endpoint za zakazivanje termina.
 * Prihvata POST zahteve i cuva podatke u SQLite bazi.
 */

declare(strict_types=1);

header('Content-Type: application/json');

require_once __DIR__ . '/../admin/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Metod nije dozvoljen']);
    exit;
}

try {
    $pdo = db();

    // Validacija podataka
    $required = ['ime_prezime', 'telefon', 'kontakt_kanal', 'email', 'tip_usluge', 'zeljeni_datum'];
    $data = [];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Polje '$field' je obavezno");
        }
        $data[$field] = trim($_POST[$field]);
    }

    // Dodatna validacija
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Neispravan format email adrese');
    }

    if (!preg_match('/^\+?[0-9\s-]{8,}$/', $data['telefon'])) {
        throw new Exception('Neispravan format broja telefona');
    }

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['zeljeni_datum'])) {
        throw new Exception('Neispravan format datuma');
    }

    // Čuvanje u bazi
    $stmt = $pdo->prepare("INSERT INTO appointments (
        ime_prezime, partner_ime, telefon, kontakt_kanal, email, tip_usluge,
        zeljeni_datum, doba_dana, dokumentacija_status, napomena
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->execute([
        $data['ime_prezime'],
        $_POST['partner_ime'] ?? null,
        $data['telefon'],
        $data['kontakt_kanal'],
        $data['email'],
        $data['tip_usluge'],
        $data['zeljeni_datum'],
        $_POST['doba_dana'] ?? null,
        $_POST['dokumentacija_status'] ?? null,
        $_POST['napomena'] ?? null,
    ]);

    // Uspešna odgovor
    http_response_code(200);
    echo json_encode(['ok' => true]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
