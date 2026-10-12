<?php
/**
 * SQLite (PDO) konekcija + migracije šeme.
 * Kompatibilno sa starom šemom (appointments iz prve verzije): kolone koje fale dodaju se sa
 * ALTER TABLE ADD COLUMN, stari status 'prihvaceno' prelazi u 'potvrdjeno'.
 * Stara tabela users (sa javno poznatom lozinkom) se više NE koristi — prijava ide preko
 * jedne admin lozinke (config.php admin_password_hash ili admin/setup.php).
 * Tabele: appointments, rate_limits, email_log (interni log slanja), settings.
 */

declare(strict_types=1);

const FK_SCHEMA_VERSION = 2;

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $path = (string) cfg('db_path', FK_ROOT . '/data/appointments.db');
    $dir = dirname($path);
    if (!is_dir($dir) && !@mkdir($dir, 0750, true)) {
        throw new RuntimeException('Ne mogu da napravim folder za bazu: ' . $dir);
    }
    fk_protect_dir($dir);

    $pdo = new PDO('sqlite:' . $path, null, null, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::ATTR_TIMEOUT            => 10,
    ]);
    $pdo->exec('PRAGMA foreign_keys = ON');
    $pdo->exec('PRAGMA busy_timeout = 10000');
    @chmod($path, 0640);

    // fk_fold() u SQL-u: pretraga bez obzira na velika slova i dijakritike
    $fold = static fn ($v) => fk_fold($v === null ? '' : (string) $v);
    if (method_exists($pdo, 'createFunction')) {
        $pdo->createFunction('fk_fold', $fold, 1);
    } elseif (method_exists($pdo, 'sqliteCreateFunction')) {
        @$pdo->sqliteCreateFunction('fk_fold', $fold, 1);
    }

    $version = (int) $pdo->query('PRAGMA user_version')->fetchColumn();
    if ($version < FK_SCHEMA_VERSION) {
        fk_migrate($pdo);
    }
    return $pdo;
}

function fk_table_columns(PDO $pdo, string $table): array
{
    $cols = [];
    foreach ($pdo->query('PRAGMA table_info(' . $table . ')')->fetchAll() as $row) {
        $cols[$row['name']] = true;
    }
    return $cols;
}

function fk_add_columns(PDO $pdo, string $table, array $columns): void
{
    $existing = fk_table_columns($pdo, $table);
    foreach ($columns as $name => $definition) {
        if (!isset($existing[$name])) {
            $pdo->exec("ALTER TABLE {$table} ADD COLUMN {$name} {$definition}");
        }
    }
}

function fk_migrate(PDO $pdo): void
{
    $pdo->exec('BEGIN IMMEDIATE');
    try {
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
        fk_add_columns($pdo, 'appointments', [
            'potvrdjeni_datum'  => 'TEXT',
            'potvrdjeno_vreme'  => 'TEXT',
            'poruka_pacijentu'  => 'TEXT',
            'razlog_odbijanja'  => 'TEXT',
            'predlog_termina'   => 'TEXT',
            'razlog_otkazivanja' => 'TEXT',
            'updated_at'        => 'TEXT',
            'ip_hash'           => 'TEXT',
            'saglasnost_at'     => 'TEXT',
        ]);
        $pdo->exec("UPDATE appointments SET status = 'potvrdjeno' WHERE status IN ('prihvaceno','prihvaćeno')");
        $pdo->exec('CREATE INDEX IF NOT EXISTS idx_appt_status ON appointments(status, datum_kreiranja)');
        $pdo->exec('CREATE INDEX IF NOT EXISTS idx_appt_email ON appointments(email)');

        $pdo->exec("CREATE TABLE IF NOT EXISTS rate_limits (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            bucket TEXT NOT NULL,
            key_hash TEXT NOT NULL,
            created_at INTEGER NOT NULL
        )");
        $pdo->exec('CREATE INDEX IF NOT EXISTS idx_rl ON rate_limits(bucket, key_hash, created_at)');

        $pdo->exec("CREATE TABLE IF NOT EXISTS email_log (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            appointment_id INTEGER,
            tip TEXT NOT NULL,
            primalac TEXT NOT NULL,
            naslov TEXT,
            status TEXT NOT NULL,
            transport TEXT,
            message_id TEXT,
            greska TEXT,
            created_at TEXT NOT NULL
        )");
        $pdo->exec('CREATE INDEX IF NOT EXISTS idx_email_appt ON email_log(appointment_id)');

        $pdo->exec("CREATE TABLE IF NOT EXISTS settings (
            k TEXT PRIMARY KEY,
            v TEXT NOT NULL
        )");

        $pdo->exec('PRAGMA user_version = ' . FK_SCHEMA_VERSION);
        $pdo->exec('COMMIT');
    } catch (Throwable $e) {
        $pdo->exec('ROLLBACK');
        throw $e;
    }
}

/* ------------------------------------------------------------------ settings / tajna */

function fk_setting_set(string $key, string $value): void
{
    db()->prepare('INSERT INTO settings (k, v) VALUES (?, ?) ON CONFLICT(k) DO UPDATE SET v = excluded.v')->execute([$key, $value]);
}

function fk_setting(string $key): ?string
{
    $st = db()->prepare('SELECT v FROM settings WHERE k = ?');
    $st->execute([$key]);
    $v = $st->fetchColumn();
    return $v === false ? null : (string) $v;
}

function fk_app_secret(): string
{
    static $secret = null;
    if ($secret !== null) {
        return $secret;
    }
    $cfg = (string) cfg('app_secret', '');
    if (strlen($cfg) >= 16) {
        return $secret = $cfg;
    }
    $stored = fk_setting('app_secret');
    if ($stored === null) {
        $stored = bin2hex(random_bytes(32));
        db()->prepare('INSERT OR IGNORE INTO settings (k, v) VALUES (?, ?)')->execute(['app_secret', $stored]);
        $stored = fk_setting('app_secret') ?? $stored;
    }
    return $secret = $stored;
}

/* ------------------------------------------------------------------ rate limit */

function fk_rate_count(string $bucket, string $key, int $windowSeconds): int
{
    $st = db()->prepare('SELECT COUNT(*) FROM rate_limits WHERE bucket = ? AND key_hash = ? AND created_at > ?');
    $st->execute([$bucket, $key, time() - $windowSeconds]);
    return (int) $st->fetchColumn();
}

function fk_rate_hit(string $bucket, string $key): void
{
    db()->prepare('INSERT INTO rate_limits (bucket, key_hash, created_at) VALUES (?, ?, ?)')
        ->execute([$bucket, $key, time()]);
    if (random_int(1, 50) === 1) {                     // povremeno čišćenje starih zapisa
        db()->prepare('DELETE FROM rate_limits WHERE created_at < ?')->execute([time() - 86400 * 2]);
    }
}

function fk_rate_clear(string $bucket, string $key): void
{
    db()->prepare('DELETE FROM rate_limits WHERE bucket = ? AND key_hash = ?')->execute([$bucket, $key]);
}

/** Najstariji zapis u prozoru → koliko sekundi do oslobađanja. */
function fk_rate_retry_after(string $bucket, string $key, int $windowSeconds): int
{
    $st = db()->prepare('SELECT MIN(created_at) FROM rate_limits WHERE bucket = ? AND key_hash = ? AND created_at > ?');
    $st->execute([$bucket, $key, time() - $windowSeconds]);
    $oldest = (int) $st->fetchColumn();
    return max(60, $oldest + $windowSeconds - time());
}

function fk_appointment(int $id): ?array
{
    $st = db()->prepare('SELECT * FROM appointments WHERE id = ?');
    $st->execute([$id]);
    $row = $st->fetch();
    return $row ?: null;
}
