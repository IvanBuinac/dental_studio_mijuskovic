<?php
/**
 * Prijava u admin panel. Posle 5 neuspešnih pokušaja (po IP adresi i po nalogu) prijava se zaključava na 15 min.
 */

declare(strict_types=1);

require dirname(__DIR__) . '/lib/admin.php';
fk_admin_boot();

if (fk_users_count() === 0) {
    fk_redirect('setup.php');
}
$next = fk_safe_next(is_string($_REQUEST['next'] ?? null) ? $_REQUEST['next'] : null);
if (fk_user() !== null) {
    fk_redirect($next);
}

$error = '';
$username = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    fk_require_csrf();
    $username = fk_clean_line($_POST['username'] ?? '');
    $password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';
    if ($username === '' || $password === '') {
        $error = 'Pogrešno korisničko ime ili lozinka.';
    } else {
        $r = fk_login(mb_substr($username, 0, 80), mb_substr($password, 0, 1000), ($_POST['remember'] ?? '') === '1');
        if ($r['ok']) {
            fk_redirect($next);
        }
        $error = $r['error'] ?? 'Prijava nije uspela.';
        usleep(random_int(200000, 500000));   // usporava pogađanje
    }
}

fk_admin_header('Prijava — Zakazivanja | dr Filip Katanić');
?>
<section class="auth">
  <div class="auth__card">
    <span class="auth__mark" aria-hidden="true">FK</span>
    <h1>dr Filip Katanić</h1>
    <p class="eyebrow">Zakazivanja — admin</p>
    <?php if ($error !== ''): ?><div class="flash flash--error" role="alert"><?= e($error) ?></div><?php endif; ?>
    <form method="post" action="login.php" class="form">
      <?= fk_csrf_field() ?>
      <input type="hidden" name="next" value="<?= e($next) ?>">
      <div class="field">
        <label for="username">Korisničko ime</label>
        <input id="username" name="username" value="<?= e($username) ?>" autocomplete="username" autocapitalize="none" spellcheck="false" required autofocus>
      </div>
      <div class="field">
        <label for="password">Lozinka</label>
        <div class="pw">
          <input id="password" name="password" type="password" autocomplete="current-password" required>
          <button type="button" class="pw__toggle" data-pw-toggle="password" aria-controls="password" aria-pressed="false">Prikaži lozinku</button>
        </div>
      </div>
      <label class="check"><input type="checkbox" name="remember" value="1"> Zapamti me na ovom uređaju</label>
      <button type="submit" class="btn btn--primary btn--block btn--lg" data-busy="Prijavljujem…">Prijava</button>
    </form>
  </div>
</section>
<?php
fk_admin_footer();
