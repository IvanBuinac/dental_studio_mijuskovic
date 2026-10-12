<?php
/**
 * Lista zahteva: tabovi po statusu sa brojačima, pretraga, sortiranje, straničenje, izvoz CSV.
 * Na telefonu (< 760px) redovi tabele postaju kartice. Mikrokopija: copy-v2.md §7.3
 */

declare(strict_types=1);

require dirname(__DIR__) . '/lib/admin.php';
fk_admin_boot();
$user = fk_require_login();

[$f, $whereSql, $params, $orderSql] = fk_list_query($_GET);
$counts = fk_status_counts();

$perPage = 25;
$st = db()->prepare("SELECT COUNT(*) FROM appointments a {$whereSql}");
$st->execute($params);
$total = (int) $st->fetchColumn();
$pages = max(1, (int) ceil($total / $perPage));
$page = min($pages, max(1, (int) ($_GET['p'] ?? 1)));
$offset = ($page - 1) * $perPage;

$st = db()->prepare("SELECT a.* FROM appointments a {$whereSql} {$orderSql} LIMIT {$perPage} OFFSET {$offset}");
$st->execute($params);
$rows = $st->fetchAll();

$tabs = ['novo' => 'Novo', 'potvrdjeno' => 'Potvrđeno', 'odbijeno' => 'Odbijeno', 'otkazano' => 'Otkazano', 'svi' => 'Sve'];
$empty = [
    'novo'       => 'Nema novih zahteva. Kada stigne novi, dobićete mejl.',
    'potvrdjeno' => 'Još nema potvrđenih termina.',
    'odbijeno'   => 'Nema odbijenih zahteva.',
    'otkazano'   => 'Nema otkazanih termina.',
    'svi'        => 'Još nema nijednog zahteva. Kada pacijent pošalje formu, pojaviće se ovde.',
];
$qs = static fn (array $over = []): string => http_build_query(array_filter(array_merge($f, $over), static fn ($v) => $v !== '' && $v !== null));
$today = date('Y-m-d');

fk_admin_header('Zakazivanja (' . $counts['novo'] . ' novih) | Admin', $user, 'list');
?>
<div class="pagehead">
  <div>
    <p class="eyebrow">Zakazivanja</p>
    <h1>Zahtevi za konsultaciju</h1>
  </div>
  <a class="btn btn--ghost btn--small" href="izvoz.php?<?= e($qs()) ?>">Izvoz CSV</a>
</div>

<nav class="tabs" aria-label="Filter po statusu">
  <?php foreach ($tabs as $key => $label): ?>
    <a href="index.php?<?= e($qs(['status' => $key, 'p' => null])) ?>" class="tab<?= $f['status'] === $key ? ' is-active' : '' ?>"<?= $f['status'] === $key ? ' aria-current="page"' : '' ?>>
      <?= e($label) ?> <span class="tab__count<?= $key === 'novo' && $counts['novo'] > 0 ? ' tab__count--hot' : '' ?>"><?= (int) $counts[$key] ?></span>
    </a>
  <?php endforeach; ?>
</nav>

<form class="toolbar" method="get" action="index.php" role="search">
  <input type="hidden" name="status" value="<?= e($f['status']) ?>">
  <label class="sr-only" for="q">Pretraga</label>
  <input class="toolbar__search" type="search" id="q" name="q" value="<?= e($f['q']) ?>" placeholder="Ime, telefon ili e-mail">
  <label class="sr-only" for="sort">Sortiranje</label>
  <select id="sort" name="sort" class="toolbar__sort" data-autosubmit>
    <?php foreach (FK_SORTS as $k => [$label]): ?>
      <option value="<?= e($k) ?>"<?= $f['sort'] === $k ? ' selected' : '' ?>><?= e($label) ?></option>
    <?php endforeach; ?>
  </select>
  <button class="btn btn--primary" type="submit">Traži</button>
</form>

<?php if (!$rows): ?>
  <div class="empty">
    <span class="empty__mark" aria-hidden="true">◇</span>
    <?php if ($f['q'] !== ''): ?>
      <p>Nema rezultata za „<?= e($f['q']) ?>“.</p>
      <a href="index.php?<?= e($qs(['q' => null])) ?>">Obriši pretragu</a>
    <?php else: ?>
      <p><?= e($empty[$f['status']] ?? $empty['svi']) ?></p>
    <?php endif; ?>
  </div>
<?php else: ?>
  <table class="list">
    <thead>
      <tr>
        <th scope="col">Status</th>
        <th scope="col">Primljeno</th>
        <th scope="col">Ime i prezime</th>
        <th scope="col">Razlog</th>
        <th scope="col">Željeni datum</th>
        <th scope="col">Doba</th>
        <th scope="col">Kanal</th>
        <th scope="col">Telefon</th>
        <th scope="col">Akcije</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($rows as $r):
        $rid = (int) $r['id'];
        $past = $r['status'] === 'novo' && $r['zeljeni_datum'] < $today; ?>
      <tr class="list__row status-<?= e($r['status']) ?>">
        <td class="list__status" data-label="Status"><?= fk_status_badge((string) $r['status']) ?></td>
        <td class="list__when muted" data-label="Primljeno" title="<?= e(fk_date_short($r['datum_kreiranja'])) ?>"><?= e(fk_relative($r['datum_kreiranja'])) ?></td>
        <td class="list__who" data-label="Ime i prezime">
          <a class="list__name" href="zahtev.php?id=<?= $rid ?>"><?= e($r['ime_prezime']) ?></a>
          <span class="list__ref">#<?= str_pad((string) $rid, 4, '0', STR_PAD_LEFT) ?></span>
        </td>
        <td data-label="Razlog"><?= e(fk_label('tip_usluge', $r['tip_usluge'])) ?></td>
        <td data-label="Željeni datum" class="<?= $past ? 'is-past' : '' ?>">
          <?= e(fk_date_short($r['zeljeni_datum'])) ?>
          <?php if ($r['status'] === 'potvrdjeno' && $r['potvrdjeni_datum']): ?><small>Termin: <?= e(fk_date_short($r['potvrdjeni_datum']) . ' ' . ($r['potvrdjeno_vreme'] ?? '')) ?></small><?php endif; ?>
        </td>
        <td data-label="Doba"><?= e(fk_label('doba_dana', $r['doba_dana'])) ?></td>
        <td data-label="Kanal"><?= e(fk_label('kontakt_kanal', $r['kontakt_kanal'])) ?></td>
        <td data-label="Telefon"><a class="list__tel" href="tel:<?= e($r['telefon']) ?>"><?= e($r['telefon']) ?></a></td>
        <td class="list__go">
          <?php if ($r['status'] === 'novo'): ?>
            <a class="btn btn--small btn--primary" href="zahtev.php?id=<?= $rid ?>&amp;a=potvrdi#akcije">Potvrdi</a>
            <a class="btn btn--small btn--ghost" href="zahtev.php?id=<?= $rid ?>&amp;a=odbij#akcije">Odbij</a>
          <?php endif; ?>
          <a class="btn btn--small btn--text" href="zahtev.php?id=<?= $rid ?>">Detalji →</a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>

  <?php if ($pages > 1): ?>
  <nav class="pager" aria-label="Paginacija">
    <?php if ($page > 1): ?><a class="btn btn--ghost" href="index.php?<?= e($qs(['p' => $page - 1])) ?>">Prethodna</a><?php endif; ?>
    <span class="muted">Strana <?= $page ?> od <?= $pages ?></span>
    <?php if ($page < $pages): ?><a class="btn btn--ghost" href="index.php?<?= e($qs(['p' => $page + 1])) ?>">Sledeća</a><?php endif; ?>
  </nav>
  <?php endif; ?>
<?php endif; ?>
<?php
fk_admin_footer();
