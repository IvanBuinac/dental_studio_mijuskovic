<?php
/**
 * Promena lozinke prijavljenog korisnika.
 */

declare(strict_types=1);

require dirname(__DIR__) . '/lib/admin.php';
fk_admin_boot();
$user = fk_require_login();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    fk_require_csrf();
    $cur = is_string($_POST['current'] ?? null) ? $_POST['current'] : '';
    $new = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';
    $new2 = is_string($_POST['password2'] ?? null) ? $_POST['password2'] : '';

    $st = db()->prepare('SELECT password_hash FROM users WHERE id = ?');
    $st->execute([$user['id']]);
    $hash = (string) $st->fetchColumn();

    if (!password_verify($cur, $hash)) {
        $errors['current'] = 'Trenutna lozinka nije ispravna.';
        usleep(300000);
    }
    if (fk_len($new) < 12) {
        $errors['password'] = 'Nova lozinka mora imati najmanje 12 znakova.';
    } elseif (strtolower($new) === strtolower((string) $user['username']) || $new === $cur) {
        $errors['password'] = 'Nova lozinka mora biti drugačija od korisničkog imena i stare lozinke.';
    }
    if ($new !== $new2) {
        $errors['password2'] = 'Lozinke se ne poklapaju.';
    }
    if (!$errors) {
        db()->prepare('UPDATE users SET password_hash = ?, password_changed_at = ? WHERE id = ?')
            ->execute([password_hash($new, PASSWORD_DEFAULT), fk_now(), $user['id']]);
        session_regenerate_id(true);
        fk_activity('lozinka_promenjena', null, null, (int) $user['id']);
        fk_flash('success', 'Lozinka je promenjena.');
        fk_redirect('index.php');
    }
}

fk_admin_header('Promena lozinke', $user, 'pass');
?>
<section class="narrow">
  <p class="eyebrow">Nalog · <?= e($user['username']) ?></p>
  <h1>Promena lozinke</h1>
  <form method="post" class="card form">
    <?= fk_csrf_field() ?>
    <input type="text" name="username" value="<?= e($user['username']) ?>" autocomplete="username" hidden>
    <div class="field<?= isset($errors['current']) ? ' has-error' : '' ?>">
      <label for="current">Trenutna lozinka</label>
      <input id="current" name="current" type="password" autocomplete="current-password" required>
      <?php if (isset($errors['current'])): ?><p class="field__err"><?= e($errors['current']) ?></p><?php endif; ?>
    </div>
    <div class="field<?= isset($errors['password']) ? ' has-error' : '' ?>">
      <label for="password">Nova lozinka</label>
      <input id="password" name="password" type="password" autocomplete="new-password" minlength="12" aria-describedby="pw-hint" required>
      <p class="field__hint" id="pw-hint">Najmanje 12 znakova.</p>
      <?php if (isset($errors['password'])): ?><p class="field__err"><?= e($errors['password']) ?></p><?php endif; ?>
    </div>
    <div class="field<?= isset($errors['password2']) ? ' has-error' : '' ?>">
      <label for="password2">Ponovite novu lozinku</label>
      <input id="password2" name="password2" type="password" autocomplete="new-password" minlength="12" required>
      <?php if (isset($errors['password2'])): ?><p class="field__err"><?= e($errors['password2']) ?></p><?php endif; ?>
    </div>
    <button type="submit" class="btn btn--primary btn--lg btn--block">Sačuvaj</button>
  </form>
</section>
<?php
fk_admin_footer();
