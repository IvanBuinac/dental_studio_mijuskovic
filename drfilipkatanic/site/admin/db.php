<?php
/**
 * SQLite konekcija i inicijalizacija šeme.
 * Baza živi u /data/appointments.db (zaštićeno .htaccess-om).
 */

declare(strict_types=1);

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dir = dirname(__DIR__) . '/data';
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    $pdo = new PDO('sqlite:' . $dir . '/appointments.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->exec('PRAGMA foreign_keys = ON');

    $pdo->exec("CREATE TABLE IF NOT EXISTS appointments (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        ime_prezime TEXT NOT NULL,
        partner_ime TEXT,
        telefon TEXT NOT NULL,
        kontakt_kanal TEXT NOT NULL,
        email TEXT NOT NULL,
        tip_usluge TEXT NOT NULL,
        zeljeni_datum TEXT NOT NULL,
        doba_dana TEXT,
        dokumentacija_status TEXT,
        napomena TEXT,
        status TEXT NOT NULL DEFAULT 'novo',
        doktor_beleska TEXT,
        datum_kreiranja TEXT NOT NULL DEFAULT (datetime('now','localtime'))
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        password_hash TEXT NOT NULL,
        full_name TEXT,
        created_at TEXT NOT NULL DEFAULT (datetime('now','localtime'))
    )");

    seed_default_user($pdo);

    return $pdo;
}

/** Početni nalog: drkatanic / Ferona2026! — lozinku promeniti nakon prvog logovanja. */
function seed_default_user(PDO $pdo): void
{
    $exists = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    if ((int) $exists > 0) {
        return;
    }
    $stmt = $pdo->prepare("INSERT INTO users (username, password_hash, full_name) VALUES (?, ?, ?)");
    $stmt->execute([
        'drkatanic',
        password_hash('Ferona2026!', PASSWORD_DEFAULT),
        'dr Filip Katanić',
    ]);
}
