<?php
/**
 * Jednokratno postavljanje admin lozinke. Radi SAMO dok lozinka nije postavljena
 * (ni u config.php ni ovde), posle toga se sama onemogućava.
 * Ako je u config.php postavljen setup_key, traži ga (zaštita ako je sajt javan pre podešavanja).
 */

declare(strict_types=1);

require dirname(__DIR__) . '/lib/admin.php';
fk_admin_boot();

if (fk_password_hash() !== null) {
    http_response_code(404);
    fk_admin_header('Podešavanje završeno');
    echo '<section class="auth"><div class="auth__card"><span class="auth__mark" aria-hidden="true">FK</span>'
        . '<h1>Lozinka je već postavljena</h1><p class="muted">Ova stranica je onemogućena.</p>'
        . '<a class="btn btn--primary btn--block btn--lg" href="login.php">Na prijavu</a></div></section>';
    fk_admin_footer();
    exit;
}

$setupKey = (string) cfg('setup_key', '');
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    fk_require_csrf('setup.php');
    $pass = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';
    $pass2 = is_string($_POST['password2'] ?? null) ? $_POST['password2'] : '';

    if ($setupKey !== '' && !hash_equals($setupKey, is_string($_POST['setup_key'] ?? null) ? $_POST['setup_key'] : '')) {
        $errors['setup_key'] = 'Ključ za podešavanje nije ispravan.';
    }
    if (fk_len($pass) < 12) {
        $errors['password'] = 'Lozinka mora imati najmanje 12 znakova.';
    } elseif (in_array(strtolower($pass), ['ferona2026!', 'password1234', '123456789012', 'lozinka12345'], true)) {
        $errors['password'] = 'Izaberite manje predvidljivu lozinku.';
    }
    if ($pass !== $pass2) {
        $errors['password2'] = 'Lozinke se ne poklapaju.';
    }

    if (!$errors) {
        $pdo = db();
        $pdo->exec('BEGIN IMMEDIATE');
        if (fk_setting('admin_password_hash') !== null) {   // neko je bio brži
            $pdo->exec('ROLLBACK');
            fk_redirect('login.php');
        }
        fk_setting_set('admin_password_hash', password_hash($pass, PASSWORD_DEFAULT));
        $pdo->exec('COMMIT');

        fk_session_reset();
        $_SESSION['fk_auth'] = 1;
        $_SESSION['fk_born'] = time();
        $_SESSION['fk_seen'] = time();
        $_SESSION['fk_pwv'] = fk_password_version();
        fk_flash('success', 'Lozinka je postavljena i prijavljeni ste. Zapamtite je — ova stranica je sada onemogućena.');
        fk_redirect('index.php');
    }
}

fk_admin_header('Postavljanje lozinke — Zakazivanja');
?>
<section class="auth">
  <div class="auth__card">
    <span class="auth__mark" aria-hidden="true">FK</span>
    <p class="eyebrow">Prvo pokretanje</p>
    <h1>Postavite lozinku</h1>
    <p class="muted">Ovom lozinkom ćete se prijavljivati u Zakazivanja. Ova stranica radi samo jednom.</p>
    <form method="post" class="form">
      <?= fk_csrf_field() ?>
      <?php if ($setupKey !== ''): ?>
      <div class="field<?= isset($errors['setup_key']) ? ' has-error' : '' ?>">
        <label for="setup_key">Ključ za podešavanje</label>
        <input id="setup_key" name="setup_key" type="password" autocomplete="off" required>
        <?php if (isset($errors['setup_key'])): ?><p class="field__err"><?= e($errors['setup_key']) ?></p><?php endif; ?>
      </div>
      <?php endif; ?>
      <input type="text" name="username" value="admin" autocomplete="username" hidden>
      <div class="field<?= isset($errors['password']) ? ' has-error' : '' ?>">
        <label for="password">Nova lozinka</label>
        <input id="password" name="password" type="password" autocomplete="new-password" minlength="12" required>
        <p class="field__hint">Najmanje 12 znakova.</p>
        <?php if (isset($errors['password'])): ?><p class="field__err"><?= e($errors['password']) ?></p><?php endif; ?>
      </div>
      <div class="field<?= isset($errors['password2']) ? ' has-error' : '' ?>">
        <label for="password2">Ponovite lozinku</label>
        <input id="password2" name="password2" type="password" autocomplete="new-password" minlength="12" required>
        <?php if (isset($errors['password2'])): ?><p class="field__err"><?= e($errors['password2']) ?></p><?php endif; ?>
      </div>
      <button type="submit" class="btn btn--primary btn--block btn--lg">Sačuvaj lozinku</button>
    </form>
  </div>
</section>
<?php
fk_admin_footer();
