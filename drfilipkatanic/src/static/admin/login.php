<?php
/**
 * Login forma za admin portal.
 */

declare(strict_types=1);

require_once __DIR__ . '/auth.php';

if (is_logged_in()) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if (login($username, $password)) {
        header('Location: index.php');
        exit;
    }
    $error = 'Pogrešno korisničko ime ili lozinka.';
}
?>
<!DOCTYPE html>
<html lang="sr-Latn-RS">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prijava | Admin portal</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body class="login-body">
    <div class="login-container">
        <h1>Admin portal</h1>
        <p class="login-subtitle">dr Filip Katanić</p>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" class="login-form">
            <div class="form-group">
                <label for="username">Korisničko ime</label>
                <input type="text" id="username" name="username" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Lozinka</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Prijavite se</button>
        </form>
    </div>
</body>
</html>
