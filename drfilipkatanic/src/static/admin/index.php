<?php
/**
 * Admin dashboard za upravljanje terminima.
 */

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_login();

$pdo = db();
$date = $_GET['date'] ?? date('Y-m-d');
$status = $_GET['status'] ?? 'novo';

// Dohvatanje termina
$stmt = $pdo->prepare("SELECT * FROM appointments WHERE zeljeni_datum = ? AND status = ? ORDER BY datum_kreiranja DESC");
$stmt->execute([$date, $status]);
$appointments = $stmt->fetchAll();

// Broj novih termina
$newCount = $pdo->query("SELECT COUNT(*) FROM appointments WHERE status = 'novo'")->fetchColumn();

// Statusi
$statuses = ['novo', 'prihvaceno', 'odbijeno', 'otkazano'];

// Kontakt URL-ovi
function get_contact_url(string $channel, string $value): string
{
    switch ($channel) {
        case 'WhatsApp': return 'https://wa.me/' . preg_replace('/[^0-9]/', '', $value);
        case 'Viber': return 'viber://chat?number=' . urlencode($value);
        case 'Poziv': return 'tel:' . urlencode($value);
        case 'Email': return 'mailto:' . urlencode($value);
        default: return '#';
    }
}
?>
<!DOCTYPE html>
<html lang="sr-Latn-RS">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Termini | Admin portal</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h1>Termini</h1>
            <div class="header-actions">
                <a href="logout.php" class="btn btn-secondary">Odjava</a>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="filters">
            <form method="get" class="filter-form">
                <div class="filter-group">
                    <label for="date">Datum:</label>
                    <input type="date" id="date" name="date" value="<?= htmlspecialchars($date) ?>">
                </div>
                <div class="filter-group">
                    <label for="status">Status:</label>
                    <select id="status" name="status">
                        <?php foreach ($statuses as $s): ?>
                            <option value="<?= $s ?>" <?= $s === $status ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Primeni filtere</button>
            </form>
        </div>

        <?php if ($newCount > 0 && $status === 'novo'): ?>
            <div class="alert alert-info">Imate <?= $newCount ?> novih zahteva za termin.</div>
        <?php endif; ?>

        <div class="appointments-grid">
            <?php if (empty($appointments)): ?>
                <div class="empty-state">Nema termina za prikaz.</div>
            <?php else: ?>
                <?php foreach ($appointments as $app): ?>
                    <div class="appointment-card">
                        <div class="appointment-header">
                            <h3><?= htmlspecialchars($app['ime_prezime']) ?></h3>
                            <span class="appointment-date"><?= date('d.m.Y', strtotime($app['zeljeni_datum'])) ?></span>
                        </div>
                        <div class="appointment-body">
                            <div class="appointment-detail">
                                <strong>Partner:</strong> <?= htmlspecialchars($app['partner_ime'] ?? 'Nije naveden') ?>
                            </div>
                            <div class="appointment-detail">
                                <strong>Kontakt:</strong> <?= htmlspecialchars($app['kontakt_kanal']) ?>
                            </div>
                            <div class="appointment-detail">
                                <strong>Usluga:</strong> <?= htmlspecialchars($app['tip_usluge']) ?>
                            </div>
                            <div class="appointment-detail">
                                <strong>Dokumentacija:</strong> <?= htmlspecialchars($app['dokumentacija_status']) ?>
                            </div>
                            <?php if ($app['napomena']): ?>
                                <div class="appointment-note">
                                    <strong>Napomena:</strong> <?= htmlspecialchars($app['napomena']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="appointment-actions">
                            <a href="<?= get_contact_url($app['kontakt_kanal'], $app['telefon']) ?>" class="btn btn-contact" target="_blank">Kontaktiraj</a>
                            <form method="post" action="actions.php" class="inline-form">
                                <input type="hidden" name="id" value="<?= $app['id'] ?>">
                                <input type="hidden" name="action" value="update_status">
                                <input type="hidden" name="status" value="prihvaceno">
                                <button type="submit" class="btn btn-success">Prihvati</button>
                            </form>
                            <form method="post" action="actions.php" class="inline-form">
                                <input type="hidden" name="id" value="<?= $app['id'] ?>">
                                <input type="hidden" name="action" value="update_status">
                                <input type="hidden" name="status" value="odbijeno">
                                <button type="submit" class="btn btn-danger">Odbij</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
