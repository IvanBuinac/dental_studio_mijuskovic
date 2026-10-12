<?php
/**
 * Pravljenje PRVOG admin naloga. Radi samo dok u bazi ne postoji nijedan korisnik,
 * posle toga se sam onemogućava (404). Ako je u config.php postavljen setup_key, traži ga.
 */

declare(strict_types=1);

require dirname(__DIR__) . '/lib/admin.php';
fk_admin_boot();

if (fk_users_count() > 0) {
    http_response_code(404);
    fk_admin_header('Podešavanje završeno');
    echo '<section class="auth"><div class="auth__card"><span class="auth__mark" aria-hidden="true">FK</span>'
        . '<h1>Podešavanje je završeno</h1><p class="muted">Admin nalog već postoji, pa je ova stranica onemogućena.</p>'
        . '<a class="btn btn--primary btn--block" href="login.php">Na prijavu</a></div></section>';
    fk_admin_footer();
    exit;
}

$setupKey = (string) cfg('setup_key', '');
$errors = [];
$old = ['username' => '', 'full_name' => 'dr Filip Katanić', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    fk_require_csrf();
    $old['username'] = strtolower(fk_clean_line($_POST['username'] ?? ''));
    $old['full_name'] = fk_clean_line($_POST['full_name'] ?? '');
    $old['email'] = strtolower(fk_clean_line($_POST['email'] ?? ''));
    $pass = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';
    $pass2 = is_string($_POST['password2'] ?? null) ? $_POST['password2'] : '';

    if ($setupKey !== '' && !hash_equals($setupKey, is_string($_POST['setup_key'] ?? null) ? $_POST['setup_key'] : '')) {
        $errors['setup_key'] = 'Ključ za podešavanje nije ispravan.';
    }
    if (!preg_match('/^[a-z0-9._\-]{3,40}$/', $old['username'])) {
        $errors['username'] = 'Korisničko ime: 3–40 znakova (mala slova, brojevi, tačka, crtica).';
    }
    if ($old['email'] !== '' && !Mailer::validEmail($old['email'])) {
        $errors['email'] = 'E-mail adresa nije ispravna.';
    }
    if (fk_len($pass) < 12) {
        $errors['password'] = 'Lozinka mora imati najmanje 12 znakova.';
    } elseif (strtolower($pass) === $old['username'] || in_array(strtolower($pass), ['ferona2026!', 'password123', '1234567890', 'lozinka123'], true)) {
        $errors['password'] = 'Izaberite manje predvidljivu lozinku.';
    }
    if ($pass !== $pass2) {
        $errors['password2'] = 'Lozinke se ne poklapaju.';
    }

    if (!$errors) {
        $pdo = db();
        $pdo->exec('BEGIN IMMEDIATE');
        try {
            if ((int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn() > 0) {
                $pdo->exec('ROLLBACK');
                fk_redirect('login.php');
            }
            $pdo->prepare('INSERT INTO users (username, password_hash, full_name, email, created_at, password_changed_at) VALUES (?, ?, ?, ?, ?, ?)')
                ->execute([$old['username'], password_hash($pass, PASSWORD_DEFAULT), $old['full_name'] ?: null, $old['email'] ?: null, fk_now(), fk_now()]);
            $uid = (int) $pdo->lastInsertId();
            $pdo->exec('COMMIT');
        } catch (Throwable $e) {
            $pdo->exec('ROLLBACK');
            throw $e;
        }
        fk_session_reset();
        $_SESSION['fk_uid'] = $uid;
        $_SESSION['fk_born'] = time();
        $_SESSION['fk_seen'] = time();
        fk_activity('nalog_kreiran', null, ['korisnik' => $old['username']], $uid);
        fk_flash('success', 'Admin nalog je napravljen i prijavljeni ste. Stranica za podešavanje je sada onemogućena.');
        fk_redirect('index.php');
    }
}

fk_admin_header('Prvo podešavanje');
?>
<section class="auth auth--wide">
  <div class="auth__card">
    <span class="auth__mark" aria-hidden="true">FK</span>
    <p class="eyebrow">Prvo pokretanje</p>
    <h1>Napravite admin nalog</h1>
    <p class="muted">Ova stranica radi samo jednom — dok ne postoji nijedan nalog.</p>
    <?php if ($errors): ?><div class="flash flash--error" role="alert">Proverite označena polja.</div><?php endif; ?>
    <form method="post" class="form" novalidate>
      <?= fk_csrf_field() ?>
      <?php if ($setupKey !== ''): ?>
      <div class="field<?= isset($errors['setup_key']) ? ' has-error' : '' ?>">
        <label for="setup_key">Ključ za podešavanje <small>(iz config.php)</small></label>
        <input id="setup_key" name="setup_key" type="password" autocomplete="off" required>
        <?php if (isset($errors['setup_key'])): ?><p class="field__err"><?= e($errors['setup_key']) ?></p><?php endif; ?>
      </div>
      <?php endif; ?>
      <div class="field<?= isset($errors['username']) ? ' has-error' : '' ?>">
        <label for="username">Korisničko ime</label>
        <input id="username" name="username" value="<?= e($old['username']) ?>" autocomplete="username" autocapitalize="none" required>
        <?php if (isset($errors['username'])): ?><p class="field__err"><?= e($errors['username']) ?></p><?php endif; ?>
      </div>
      <div class="field">
        <label for="full_name">Ime za prikaz</label>
        <input id="full_name" name="full_name" value="<?= e($old['full_name']) ?>" autocomplete="name">
      </div>
      <div class="field<?= isset($errors['email']) ? ' has-error' : '' ?>">
        <label for="email">E-mail <small>(opciono)</small></label>
        <input id="email" name="email" type="email" value="<?= e($old['email']) ?>" autocomplete="email">
        <?php if (isset($errors['email'])): ?><p class="field__err"><?= e($errors['email']) ?></p><?php endif; ?>
      </div>
      <div class="field<?= isset($errors['password']) ? ' has-error' : '' ?>">
        <label for="password">Lozinka <small>(najmanje 12 znakova)</small></label>
        <input id="password" name="password" type="password" autocomplete="new-password" minlength="12" required>
        <?php if (isset($errors['password'])): ?><p class="field__err"><?= e($errors['password']) ?></p><?php endif; ?>
      </div>
      <div class="field<?= isset($errors['password2']) ? ' has-error' : '' ?>">
        <label for="password2">Ponovite lozinku</label>
        <input id="password2" name="password2" type="password" autocomplete="new-password" minlength="12" required>
        <?php if (isset($errors['password2'])): ?><p class="field__err"><?= e($errors['password2']) ?></p><?php endif; ?>
      </div>
      <button type="submit" class="btn btn--primary btn--block btn--lg">Napravi nalog</button>
    </form>
  </div>
</section>
<?php
fk_admin_footer();
