<?php
/**
 * Zakazivanja — JEDINA admin stranica.
 * Tabovi Novi / Potvrđeni / Odbijeni. Svaka kartica: podaci pacijenta + dva velika dugmeta
 * "Potvrdi" (datum i vreme predpopunjeni, opciona poruka) i "Odbij" (opcioni razlog).
 * Posle klika pacijent automatski dobija mejl (akcija.php).
 */

declare(strict_types=1);

require dirname(__DIR__) . '/lib/admin.php';
fk_admin_boot();
fk_require_login();

$tabs = ['novo' => 'Novi', 'potvrdjeno' => 'Potvrđeni', 'odbijeno' => 'Odbijeni'];
$status = is_string($_GET['status'] ?? null) && isset($tabs[$_GET['status']]) ? $_GET['status'] : 'novo';

$counts = array_fill_keys(array_keys($tabs), 0);
foreach (db()->query('SELECT status, COUNT(*) c FROM appointments GROUP BY status')->fetchAll() as $r) {
    if (isset($counts[$r['status']])) {
        $counts[$r['status']] = (int) $r['c'];
    }
}

$order = match ($status) {
    'novo'       => 'zeljeni_datum ASC, id ASC',                       // najhitniji prvi
    'potvrdjeno' => 'potvrdjeni_datum ASC, potvrdjeno_vreme ASC',      // sledeći termin prvi
    default      => 'id DESC',
};
$limit = 200;
$st = db()->prepare("SELECT * FROM appointments WHERE status = ? ORDER BY {$order} LIMIT {$limit}");
$st->execute([$status]);
$rows = $st->fetchAll();

$today = date('Y-m-d');
$empty = [
    'novo'       => 'Nema novih zahteva. Kada stigne novi, dobićete mejl.',
    'potvrdjeno' => 'Još nema potvrđenih termina.',
    'odbijeno'   => 'Nema odbijenih zahteva.',
];

fk_admin_header('Zakazivanja' . ($counts['novo'] ? ' (' . $counts['novo'] . ' novih)' : '') . ' | dr Filip Katanić', true);
?>
<nav class="tabs" aria-label="Zahtevi po statusu">
  <?php foreach ($tabs as $key => $label): ?>
    <a href="index.php?status=<?= e($key) ?>" class="tab tab--<?= e($key) ?><?= $status === $key ? ' is-active' : '' ?>"<?= $status === $key ? ' aria-current="page"' : '' ?>>
      <?= e($label) ?> <span class="tab__count"><?= (int) $counts[$key] ?></span>
    </a>
  <?php endforeach; ?>
</nav>

<?php if (!$rows): ?>
  <div class="empty">
    <span class="empty__mark" aria-hidden="true">◇</span>
    <p><?= e($empty[$status]) ?></p>
  </div>
<?php endif; ?>

<div class="cards">
<?php foreach ($rows as $a):
    $id = (int) $a['id'];
    $past = $a['zeljeni_datum'] < $today;
    $confirmDate = $past ? $today : $a['zeljeni_datum'];
    $confirmTime = $a['doba_dana'] === 'posle-podne' ? '15:00' : '10:00';
    $links = fk_contact_links($a);
?>
  <article class="card card--<?= e($a['status']) ?>" id="z<?= $id ?>">
    <header class="card__head">
      <div>
        <h2 class="card__name"><?= e($a['ime_prezime']) ?></h2>
        <p class="card__service"><?= e(fk_label('tip_usluge', $a['tip_usluge'])) ?></p>
      </div>
      <span class="card__when" title="<?= e(fk_date_short($a['datum_kreiranja'])) ?>"><?= e(fk_relative($a['datum_kreiranja'])) ?></span>
    </header>

    <?php if ($a['status'] === 'potvrdjeno'): ?>
      <div class="slot slot--ok">
        <span class="slot__label">Termin</span>
        <strong><?= e(fk_date_sr($a['potvrdjeni_datum'])) ?></strong>
        <span><?= $a['potvrdjeno_vreme'] ? 'u ' . e($a['potvrdjeno_vreme']) . ' h' : '' ?></span>
      </div>
    <?php else: ?>
      <div class="slot<?= $past && $a['status'] === 'novo' ? ' slot--past' : '' ?>">
        <span class="slot__label">Željeni datum</span>
        <strong><?= e(fk_date_sr($a['zeljeni_datum'])) ?></strong>
        <span><?= e(fk_label('doba_dana', $a['doba_dana'])) ?><?= $past && $a['status'] === 'novo' ? ' · datum je prošao' : '' ?></span>
      </div>
    <?php endif; ?>

    <dl class="facts">
      <div><dt>Telefon</dt><dd><a href="<?= e($links['Pozovi'] ?? '#') ?>"><?= e($a['telefon']) ?></a></dd></div>
      <div><dt>E-mail</dt><dd><a href="mailto:<?= e($a['email']) ?>"><?= e($a['email']) ?></a></dd></div>
      <?php if (!empty($a['kontakt_kanal'])): ?><div><dt>Kontakt putem</dt><dd><?= e(fk_label('kontakt_kanal', $a['kontakt_kanal'])) ?></dd></div><?php endif; ?>
      <?php if (!empty($a['partner_ime'])): ?><div><dt>Partner</dt><dd><?= e($a['partner_ime']) ?></dd></div><?php endif; ?>
      <?php if (!empty($a['dokumentacija_status'])): ?><div><dt>Nalazi</dt><dd><?= e(fk_label('dokumentacija_status', $a['dokumentacija_status'])) ?></dd></div><?php endif; ?>
    </dl>
    <?php if (!empty($a['napomena'])): ?><p class="note"><?= nl2br(e($a['napomena'])) ?></p><?php endif; ?>
    <?php if ($a['status'] === 'potvrdjeno' && !empty($a['poruka_pacijentu'])): ?><p class="note note--gold"><span>Vaša poruka:</span> <?= nl2br(e($a['poruka_pacijentu'])) ?></p><?php endif; ?>
    <?php if ($a['status'] === 'odbijeno' && !empty($a['razlog_odbijanja'])): ?><p class="note"><span>Razlog:</span> <?= nl2br(e($a['razlog_odbijanja'])) ?></p><?php endif; ?>

    <div class="quick">
      <?php if (isset($links['Pozovi'])): ?><a href="<?= e($links['Pozovi']) ?>">Pozovi</a><?php endif; ?>
      <?php if (isset($links['Viber'])): ?><a href="<?= e($links['Viber']) ?>">Viber</a><?php endif; ?>
      <?php if (isset($links['WhatsApp'])): ?><a href="<?= e($links['WhatsApp']) ?>" target="_blank" rel="noopener">WhatsApp</a><?php endif; ?>
    </div>

    <?php if ($a['status'] === 'novo'): ?>
    <div class="decide">
      <details class="decide__item decide__item--ok">
        <summary class="bigbtn bigbtn--ok">Potvrdi</summary>
        <form method="post" action="akcija.php" class="form">
          <?= fk_csrf_field() ?>
          <input type="hidden" name="id" value="<?= $id ?>">
          <input type="hidden" name="action" value="potvrdi">
          <div class="grid2">
            <div class="field">
              <label for="d<?= $id ?>">Datum</label>
              <input type="date" id="d<?= $id ?>" name="datum" value="<?= e($confirmDate) ?>" min="<?= e($today) ?>" required>
            </div>
            <div class="field">
              <label for="t<?= $id ?>">Vreme</label>
              <input type="time" id="t<?= $id ?>" name="vreme" value="<?= e($confirmTime) ?>" step="900" required>
            </div>
          </div>
          <div class="field">
            <label for="p<?= $id ?>">Kratka poruka pacijentu <small>(nije obavezno)</small></label>
            <textarea id="p<?= $id ?>" name="poruka" rows="2" maxlength="2000" placeholder="Npr. Ponesite dosadašnje nalaze, ako ih imate."></textarea>
          </div>
          <button type="submit" class="btn btn--ok btn--lg btn--block" data-busy="Šaljem…">Potvrdi i pošalji mejl</button>
        </form>
      </details>
      <details class="decide__item decide__item--no">
        <summary class="bigbtn bigbtn--no">Odbij</summary>
        <form method="post" action="akcija.php" class="form">
          <?= fk_csrf_field() ?>
          <input type="hidden" name="id" value="<?= $id ?>">
          <input type="hidden" name="action" value="odbij">
          <div class="field">
            <label for="r<?= $id ?>">Razlog <small>(nije obavezno — ide u mejl)</small></label>
            <textarea id="r<?= $id ?>" name="razlog" rows="2" maxlength="1000" placeholder="Npr. Željeni termin je popunjen — pošaljite novi zahtev sa drugim datumom."></textarea>
          </div>
          <button type="submit" class="btn btn--no btn--lg btn--block" data-busy="Šaljem…">Odbij i pošalji mejl</button>
        </form>
      </details>
    </div>
    <?php endif; ?>
  </article>
<?php endforeach; ?>
</div>
<?php
fk_admin_footer();
