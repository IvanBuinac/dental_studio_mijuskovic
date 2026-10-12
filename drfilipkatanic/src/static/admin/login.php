<?php
/**
 * Prijava — samo lozinka. Posle 5 pogrešnih pokušaja (po IP) prijava se zaključava na 15 min.
 */

declare(strict_types=1);

require dirname(__DIR__) . '/lib/admin.php';
fk_admin_boot();

if (fk_password_hash() === null) {
    fk_redirect('setup.php');
}
if (fk_is_logged_in()) {
    fk_redirect('index.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    fk_require_csrf('login.php');
    $password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';
    if ($password === '') {
        $error = 'Unesite lozinku.';
    } else {
        $r = fk_login(mb_substr($password, 0, 1000), ($_POST['remember'] ?? '') === '1');
        if ($r['ok']) {
            fk_redirect('index.php');
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
    <p class="eyebrow">Zakazivanja</p>
    <?php if ($error !== ''): ?><div class="flash flash--error" role="alert"><?= e($error) ?></div><?php endif; ?>
    <form method="post" action="login.php" class="form">
      <?= fk_csrf_field() ?>
      <input type="text" name="username" value="admin" autocomplete="username" hidden>
      <div class="field">
        <label for="password">Lozinka</label>
        <div class="pw">
          <input id="password" name="password" type="password" autocomplete="current-password" required autofocus>
          <button type="button" class="pw__toggle" data-pw-toggle="password" aria-controls="password" aria-pressed="false">Prikaži</button>
        </div>
      </div>
      <label class="check"><input type="checkbox" name="remember" value="1" checked> Zapamti me na ovom uređaju</label>
      <button type="submit" class="btn btn--primary btn--block btn--lg" data-busy="Prijavljujem…">Prijava</button>
    </form>
  </div>
</section>
<?php
fk_admin_footer();
