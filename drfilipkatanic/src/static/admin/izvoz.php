<?php
/**
 * Izvoz zahteva u CSV (UTF-8 sa BOM, separator ";" — otvara se ispravno u Excel-u sa srpskim podešavanjima).
 * Poštuje iste filtere kao lista (status, pretraga, sortiranje).
 */

declare(strict_types=1);

require dirname(__DIR__) . '/lib/admin.php';
fk_admin_boot();
$user = fk_require_login();

[$f, $whereSql, $params, $orderSql] = fk_list_query($_GET + ['status' => 'svi']);
$st = db()->prepare("SELECT a.* FROM appointments a {$whereSql} {$orderSql}");
$st->execute($params);

fk_activity('izvoz_csv', null, ['status' => $f['status'], 'q' => $f['q']], (int) $user['id']);

/** Zaštita od CSV/formula injection-a u Excel-u. */
$cell = static function (mixed $v): string {
    $s = (string) ($v ?? '');
    if ($s !== '' && in_array($s[0], ['=', '+', '-', '@', "\t", "\r"], true)) {
        $s = "'" . $s;
    }
    return $s;
};

$filename = 'zahtevi-' . $f['status'] . '-' . date('Y-m-d') . '.csv';
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$out = fopen('php://output', 'wb');
fwrite($out, "\xEF\xBB\xBF");
fputcsv($out, [
    'ID', 'Primljeno', 'Status', 'Ime i prezime', 'E-mail', 'Telefon', 'Kontakt putem', 'Usluga',
    'Željeni datum', 'Doba dana', 'Partner', 'Nalazi', 'Napomena', 'Potvrđen datum', 'Vreme',
    'Poruka pacijentu', 'Razlog odbijanja', 'Predlog termina', 'Razlog otkazivanja', 'Interna beleška', 'Poslednja izmena',
], ';', '"', '');
while ($r = $st->fetch()) {
    fputcsv($out, array_map($cell, [
        $r['id'], $r['datum_kreiranja'], fk_label('status', $r['status']), $r['ime_prezime'], $r['email'], $r['telefon'],
        fk_label('kontakt_kanal', $r['kontakt_kanal']), fk_label('tip_usluge', $r['tip_usluge']),
        $r['zeljeni_datum'], fk_label('doba_dana', $r['doba_dana']), $r['partner_ime'],
        fk_label('dokumentacija_status', $r['dokumentacija_status']), $r['napomena'], $r['potvrdjeni_datum'],
        $r['potvrdjeno_vreme'], $r['poruka_pacijentu'], $r['razlog_odbijanja'], $r['predlog_termina'],
        $r['razlog_otkazivanja'], $r['doktor_beleska'], $r['updated_at'],
    ]), ';', '"', '');
}
fclose($out);
