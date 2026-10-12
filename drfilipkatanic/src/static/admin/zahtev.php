<?php
/**
 * Detalj zahteva: podaci, kontakt dugmad, akcije (Potvrdi / Odbij / Otkaži / Ponovo pošalji mejl / beleška),
 * istorija (aktivnosti + mejlovi) i log mejlova. Mikrokopija: copy-v2.md §7.4–7.7
 */

declare(strict_types=1);

require dirname(__DIR__) . '/lib/admin.php';
fk_admin_boot();
$user = fk_require_login();

$id = (int) ($_GET['id'] ?? 0);
$a = $id > 0 ? fk_appointment($id) : null;
if (!$a) {
    fk_flash('error', 'Zahtev nije pronađen.');
    fk_redirect('index.php');
}

$st = db()->prepare('SELECT l.*, u.full_name, u.username FROM activity_log l LEFT JOIN users u ON u.id = l.user_id WHERE l.appointment_id = ?');
$st->execute([$id]);
$activity = $st->fetchAll();

$st = db()->prepare('SELECT * FROM email_log WHERE appointment_id = ? ORDER BY id DESC');
$st->execute([$id]);
$emails = $st->fetchAll();

$status = (string) $a['status'];
$today = date('Y-m-d');
$ref = '#' . str_pad((string) $id, 4, '0', STR_PAD_LEFT);
$open = is_string($_GET['a'] ?? null) ? $_GET['a'] : ($status === 'novo' ? 'potvrdi' : '');
$confirmDate = $a['potvrdjeni_datum'] ?: ($a['zeljeni_datum'] >= $today ? $a['zeljeni_datum'] : $today);
$confirmTime = $a['potvrdjeno_vreme'] ?: ($a['doba_dana'] === 'posle-podne' ? '15:00' : ($a['doba_dana'] === 'pre-podne' ? '10:00' : ''));
$resendType = fk_email_type_for_status($status);
$created = strtotime((string) $a['datum_kreiranja']) ?: time();

/* Istorija: aktivnosti + mejlovi, hronološki (najnovije gore) */
$actionLabels = [
    'kreiran' => 'Zahtev primljen', 'potvrdjen' => 'Termin potvrđen', 'termin_izmenjen' => 'Termin izmenjen',
    'odbijen' => 'Zahtev odbijen', 'otkazan' => 'Označeno kao otkazano', 'mejl_ponovo' => 'Mejl ponovo poslat',
    'beleska' => 'Interna beleška izmenjena', 'vracen_u_novo' => 'Vraćeno u „Novo“',
];
$emailOk = [
    'primljen' => ['Mejl „Zahtev primljen“ poslat ✓', 'Mejl „Zahtev primljen“ nije poslat ✗'],
    'doktor'   => ['Obaveštenje doktoru poslato ✓', 'Obaveštenje doktoru nije poslato ✗'],
    'potvrda'  => ['Mejl „Potvrda termina“ poslat ✓', 'Mejl „Potvrda termina“ nije poslat ✗'],
    'odbijanje' => ['Mejl „Termin nije moguć“ poslat ✓', 'Mejl „Termin nije moguć“ nije poslat ✗'],
    'otkazivanje' => ['Mejl „Termin otkazan“ poslat ✓', 'Mejl „Termin otkazan“ nije poslat ✗'],
];
$history = [];
foreach ($activity as $h) {
    if ($h['akcija'] === 'mejl_ponovo') {
        continue; // vidi se kroz zapis mejla
    }
    $who = $h['user_id'] ? ($h['full_name'] ?: $h['username']) : null;
    $det = json_decode((string) $h['detalji'], true);
    $history[] = [
        'at'    => (string) $h['created_at'],
        'title' => ($actionLabels[$h['akcija']] ?? $h['akcija']) . ($who && $h['akcija'] !== 'kreiran' ? ' (' . $who . ')' : ''),
        'note'  => is_array($det) ? (string) ($det['opis'] ?? '') : '',
        'kind'  => 'act',
    ];
}
foreach ($emails as $m) {
    $labels = $emailOk[$m['tip']] ?? [$m['tip'] . ' ✓', $m['tip'] . ' ✗'];
    $history[] = [
        'at'    => (string) $m['created_at'],
        'title' => $m['status'] === 'poslato' ? $labels[0] : ($m['status'] === 'preskoceno' ? $labels[1] . ' (adresa nije podešena)' : $labels[1]),
        'note'  => '',
        'kind'  => $m['status'] === 'poslato' ? 'ok' : 'err',
    ];
}
usort($history, static fn ($x, $y) => strcmp($y['at'], $x['at']));

$emailLabels = array_map(static fn ($d) => $d['label'], FK_EMAIL_TYPES);
$closed = in_array($status, ['odbijeno', 'otkazano'], true);

fk_admin_header($a['ime_prezime'] . ' ' . $ref . ' | Admin', $user, 'list');
?>
<a class="back" href="index.php?status=<?= e($status) ?>">‹ Svi zahtevi</a>

<div class="pagehead pagehead--detail">
  <div>
    <p class="pagehead__meta"><span class="ref"><?= e($ref) ?></span> <?= fk_status_badge($status) ?></p>
    <h1><?= e($a['ime_prezime']) ?></h1>
    <p class="muted">Primljeno <?= e(date('d.m.Y.', $created)) ?> u <?= e(date('H:i', $created)) ?></p>
  </div>
  <div class="quick">
    <?php $links = fk_contact_links($a); ?>
    <?php foreach (['Pozovi' => 'Pozovi', 'Viber' => 'Viber', 'WhatsApp' => 'WhatsApp', 'Mejl' => 'Pošalji mejl'] as $k => $label): ?>
      <?php if (isset($links[$k])): ?>
        <a class="btn btn--ghost btn--small" href="<?= e($links[$k]) ?>"<?= str_starts_with($links[$k], 'https') ? ' target="_blank" rel="noopener"' : '' ?>><?= e($label) ?></a>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
</div>

<div class="detail">
  <div class="detail__main">

    <?php if ($status === 'potvrdjeno'): ?>
    <section class="termin">
      <p class="eyebrow">Potvrđen termin</p>
      <p class="termin__date"><?= e(fk_date_sr($a['potvrdjeni_datum'])) ?></p>
      <p class="termin__time"><?= $a['potvrdjeno_vreme'] ? 'u ' . e($a['potvrdjeno_vreme']) . ' h · ' : '' ?><?= e(cfg('location.name') . ', ' . cfg('location.address')) ?></p>
      <?php if (!empty($a['poruka_pacijentu'])): ?><blockquote><?= nl2br(e($a['poruka_pacijentu'])) ?></blockquote><?php endif; ?>
    </section>
    <?php endif; ?>

    <section class="card">
      <dl class="dl">
        <dt>Razlog</dt><dd><?= e(fk_label('tip_usluge', $a['tip_usluge'])) ?></dd>
        <dt>Željeni datum</dt><dd><?= e(fk_date_sr($a['zeljeni_datum'])) ?><?= $status === 'novo' && $a['zeljeni_datum'] < $today ? ' <span class="badge badge--warn">prošao</span>' : '' ?></dd>
        <dt>Doba dana</dt><dd><?= e(fk_label('doba_dana', $a['doba_dana'])) ?></dd>
        <dt>Partner</dt><dd><?= e($a['partner_ime'] ?: '—') ?></dd>
        <dt>Nalazi</dt><dd><?= e(fk_label('dokumentacija_status', $a['dokumentacija_status'])) ?></dd>
        <dt>Kontakt putem</dt><dd><?= e(fk_label('kontakt_kanal', $a['kontakt_kanal'])) ?></dd>
        <dt>Telefon</dt><dd><a href="tel:<?= e($a['telefon']) ?>"><?= e($a['telefon']) ?></a></dd>
        <dt>E-mail</dt><dd><a href="mailto:<?= e($a['email']) ?>"><?= e($a['email']) ?></a></dd>
        <dt>Napomena</dt><dd><?= $a['napomena'] ? nl2br(e($a['napomena'])) : '—' ?></dd>
        <?php if ($a['potvrdjeni_datum']): ?>
        <dt>Potvrđen termin</dt><dd><?= e(fk_date_sr($a['potvrdjeni_datum']) . ($a['potvrdjeno_vreme'] ? ' u ' . $a['potvrdjeno_vreme'] . ' h' : '')) ?><?= $status === 'otkazano' ? ' <span class="badge badge--otkazano">otkazan</span>' : '' ?></dd>
        <?php endif; ?>
        <?php if ($a['razlog_odbijanja']): ?>
        <dt>Razlog odbijanja</dt><dd><?= nl2br(e($a['razlog_odbijanja'])) ?></dd>
        <?php endif; ?>
        <?php if ($a['predlog_termina']): ?>
        <dt>Predlog termina</dt><dd><?= e(fk_proposal_sr($a['predlog_termina'])) ?></dd>
        <?php endif; ?>
        <?php if ($a['razlog_otkazivanja']): ?>
        <dt>Razlog otkazivanja</dt><dd><?= nl2br(e($a['razlog_otkazivanja'])) ?></dd>
        <?php endif; ?>
      </dl>
    </section>

    <!-- AKCIJE -->
    <section class="actions" id="akcije" aria-label="Akcije">
      <?php if ($closed): ?>
        <div class="closed">
          <p>Zahtev je zatvoren.</p>
          <form method="post" action="akcija.php" data-confirm="Da li ste sigurni? Ova radnja menja status zahteva.">
            <?= fk_csrf_field() ?>
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="hidden" name="v" value="<?= e($a['updated_at'] ?? '') ?>">
            <input type="hidden" name="action" value="vrati">
            <button type="submit" class="btn btn--text">Vrati u „Novo“</button>
          </form>
        </div>
      <?php else: ?>

      <details class="action action--confirm"<?= $open === 'potvrdi' ? ' open' : '' ?>>
        <summary><?= $status === 'potvrdjeno' ? 'Izmeni termin' : 'Potvrdi' ?></summary>
        <form method="post" action="akcija.php" class="form">
          <h2 class="action__title">Potvrda termina</h2>
          <?= fk_csrf_field() ?>
          <input type="hidden" name="id" value="<?= $id ?>">
          <input type="hidden" name="v" value="<?= e($a['updated_at'] ?? '') ?>">
          <input type="hidden" name="action" value="potvrdi">
          <div class="grid2">
            <div class="field">
              <label for="c_datum">Datum *</label>
              <input type="date" id="c_datum" name="datum" value="<?= e($confirmDate) ?>" min="<?= e($today) ?>" aria-describedby="c_datum_h" required>
              <p class="field__hint" id="c_datum_h">Predpopunjeno željenim datumom pacijenta.</p>
            </div>
            <div class="field">
              <label for="c_vreme">Vreme *</label>
              <input type="time" id="c_vreme" name="vreme" value="<?= e($confirmTime) ?>" step="900" aria-describedby="c_vreme_h" required>
              <p class="field__hint" id="c_vreme_h">Korak 15 minuta.</p>
            </div>
          </div>
          <div class="field">
            <label for="c_poruka">Poruka pacijentu (opciono)</label>
            <textarea id="c_poruka" name="poruka" rows="4" maxlength="2000" placeholder="Molim Vas da ponesete dosadašnje nalaze, ako ih imate."><?= e($a['poruka_pacijentu'] ?? '') ?></textarea>
          </div>
          <label class="check"><input type="checkbox" name="posalji" value="1" checked> Pošalji mejl pacijentu</label>
          <div class="form__actions">
            <button type="submit" class="btn btn--primary btn--lg" data-busy="Šaljem…">Potvrdi i pošalji mejl</button>
            <button type="button" class="btn btn--text" data-close-details>Odustani</button>
          </div>
        </form>
      </details>

      <?php if ($status === 'novo'): ?>
      <details class="action action--reject"<?= $open === 'odbij' ? ' open' : '' ?>>
        <summary>Odbij</summary>
        <form method="post" action="akcija.php" class="form" data-reject>
          <h2 class="action__title">Odbijanje / predlog termina</h2>
          <?= fk_csrf_field() ?>
          <input type="hidden" name="id" value="<?= $id ?>">
          <input type="hidden" name="v" value="<?= e($a['updated_at'] ?? '') ?>">
          <input type="hidden" name="action" value="odbij">
          <fieldset class="field">
            <legend>Razlog *</legend>
            <label class="check"><input type="radio" name="razlog_tip" value="nije-dostupan" data-template="Željeni termin je već popunjen. Predlažem drugi termin u nastavku — ili pošaljite novi zahtev sa datumom koji Vam odgovara." required> Termin nije dostupan</label>
            <label class="check"><input type="radio" name="razlog_tip" value="drugi-pregled" data-template="Na osnovu onoga što ste naveli, smatram da bi za Vas bio korisniji drugačiji pregled. Javite mi se odgovorom na ovaj mejl, pa ćemo zajedno dogovoriti najbolji sledeći korak."> Potrebna je druga vrsta pregleda</label>
            <label class="check"><input type="radio" name="razlog_tip" value="drugo" data-template=""> Drugo</label>
          </fieldset>
          <p class="field__label">Predlog drugog termina (opciono)</p>
          <div class="grid2">
            <div class="field">
              <label for="r_pdatum">Datum</label>
              <input type="date" id="r_pdatum" name="predlog_datum" min="<?= e($today) ?>">
            </div>
            <div class="field">
              <label for="r_pvreme">Vreme</label>
              <input type="time" id="r_pvreme" name="predlog_vreme" step="900">
            </div>
          </div>
          <div class="field">
            <label for="r_razlog">Poruka pacijentu *</label>
            <textarea id="r_razlog" name="razlog" rows="4" maxlength="1000" required></textarea>
          </div>
          <label class="check"><input type="checkbox" name="posalji" value="1" checked> Pošalji mejl pacijentu</label>
          <div class="form__actions">
            <button type="submit" class="btn btn--danger btn--lg" data-busy="Šaljem…">Pošalji odgovor</button>
            <button type="button" class="btn btn--text" data-close-details>Odustani</button>
          </div>
        </form>
      </details>
      <?php endif; ?>

      <?php if ($status === 'potvrdjeno'): ?>
      <details class="action action--cancel"<?= $open === 'otkazi' ? ' open' : '' ?>>
        <summary>Otkaži termin</summary>
        <form method="post" action="akcija.php" class="form" data-confirm="Da li ste sigurni? Ova radnja menja status zahteva.">
          <h2 class="action__title">Označi kao otkazano</h2>
          <?= fk_csrf_field() ?>
          <input type="hidden" name="id" value="<?= $id ?>">
          <input type="hidden" name="v" value="<?= e($a['updated_at'] ?? '') ?>">
          <input type="hidden" name="action" value="otkazi">
          <div class="field">
            <label for="x_razlog">Razlog (opciono)</label>
            <textarea id="x_razlog" name="razlog" rows="3" maxlength="1000"></textarea>
          </div>
          <label class="check"><input type="checkbox" name="posalji" value="1" checked> Pošalji mejl pacijentu o otkazivanju</label>
          <div class="form__actions">
            <button type="submit" class="btn btn--danger btn--lg" data-busy="Šaljem…">Označi kao otkazano</button>
            <button type="button" class="btn btn--text" data-close-details>Odustani</button>
          </div>
        </form>
      </details>
      <?php endif; ?>
      <?php endif; ?>
    </section>

    <section class="card">
      <h2>Interna beleška</h2>
      <form method="post" action="akcija.php" class="form">
        <?= fk_csrf_field() ?>
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="hidden" name="action" value="beleska">
        <div class="field">
          <label class="sr-only" for="beleska">Interna beleška</label>
          <textarea id="beleska" name="beleska" rows="3" maxlength="4000" placeholder="Vidljivo samo u admin panelu — pacijent je ne vidi."><?= e($a['doktor_beleska'] ?? '') ?></textarea>
        </div>
        <button type="submit" class="btn btn--ghost">Sačuvaj belešku</button>
      </form>
    </section>
  </div>

  <aside class="detail__side">
    <section class="card">
      <h2 class="eyebrow eyebrow--h">Istorija</h2>
      <ul class="log">
        <?php foreach ($history as $h): ?>
        <li class="log__item log__item--<?= e($h['kind']) ?>">
          <span class="log__dot" aria-hidden="true"></span>
          <div>
            <strong><?= e($h['title']) ?></strong>
            <span class="log__meta"><?= e(fk_date_short($h['at'])) ?></span>
            <?php if ($h['note'] !== ''): ?><span class="log__note"><?= e($h['note']) ?></span><?php endif; ?>
          </div>
        </li>
        <?php endforeach; ?>
        <?php if (!$history): ?><li class="muted small">—</li><?php endif; ?>
      </ul>
    </section>

    <section class="card">
      <div class="card__head">
        <h2 class="eyebrow eyebrow--h">Mejlovi</h2>
        <form method="post" action="akcija.php" data-confirm="Ponovo poslati mejl „<?= e($emailLabels[$resendType]) ?>“ pacijentu?">
          <?= fk_csrf_field() ?>
          <input type="hidden" name="id" value="<?= $id ?>">
          <input type="hidden" name="action" value="ponovo">
          <button type="submit" class="btn btn--small btn--ghost" data-busy="Šaljem…" title="<?= e($emailLabels[$resendType]) ?>">Ponovo pošalji mejl</button>
        </form>
      </div>
      <?php if (!$emails): ?>
        <p class="muted small">—</p>
      <?php else: ?>
      <ul class="log">
        <?php foreach ($emails as $m): ?>
        <li class="log__item log__item--<?= e($m['status']) ?>">
          <span class="log__dot" aria-hidden="true"></span>
          <div>
            <strong><?= e($emailLabels[$m['tip']] ?? $m['tip']) ?></strong>
            <span class="log__meta"><?= e(fk_date_short($m['created_at'])) ?> · <?= e($m['primalac']) ?><?= $m['transport'] ? ' · ' . e($m['transport']) : '' ?></span>
            <span class="log__status"><?= $m['status'] === 'poslato' ? 'Poslato' : ($m['status'] === 'preskoceno' ? 'Preskočeno' : 'Greška') ?></span>
            <?php if (!empty($m['greska'])): ?><span class="log__err"><?= e($m['greska']) ?></span><?php endif; ?>
          </div>
        </li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
    </section>
  </aside>
</div>
<?php
fk_admin_footer();
