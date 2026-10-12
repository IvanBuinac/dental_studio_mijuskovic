<?php
/** (4) Pacijentu — termin nije moguć (odbijanje), uz razlog i opcioni predlog drugog termina. Tekst: copy-v2.md §6.3 */

declare(strict_types=1);

/** @var array $v */
$a = $v['a'];
$razlog = trim((string) ($a['razlog_odbijanja'] ?? ''));
$imaPredlog = $v['predlog'] !== '';
$adresa = $v['loc_name'] . ', ' . $v['loc_address'];

$content = em_p('Poštovani/a ' . e($v['ime']) . ',')
    . em_p('hvala Vam na zahtevu i poverenju. Nažalost, termin koji ste tražili (' . e($v['zeljeni']) . ') trenutno nije moguć.')
    . ($razlog !== '' ? em_h2('Obrazloženje') . em_quote($razlog, $v['doctor']) : '')
    . ($imaPredlog
        ? em_appointment_card('Predlog drugog termina', fk_date_sr(substr((string) $a['predlog_termina'], 0, 10)), trim(substr((string) $a['predlog_termina'], 11, 5)), $v['loc_name'], $v['loc_address'], $v['map_url'])
          . em_p('Ako Vam ovaj termin odgovara, <strong>samo odgovorite na ovaj mejl</strong> i potvrdiću ga.')
        : '')
    . em_h2('Kako zakazati drugi termin')
    . em_p('Novi zahtev možete poslati bilo kada, sa drugim željenim datumom:')
    . em_button($v['booking_url'], 'Pošaljite novi zahtev')
    . em_p('Možete i odgovoriti na ovaj mejl — rado ćemo pronaći termin koji Vam odgovara.')
    . em_signature(false);

$text = "Poštovani/a {$v['ime']},\n\n"
    . "hvala Vam na zahtevu i poverenju. Nažalost, termin koji ste tražili ({$v['zeljeni']}) trenutno nije moguć.\n"
    . ($razlog !== '' ? "\nObrazloženje:\n{$razlog}\n" : '')
    . ($imaPredlog ? "\nPredlog drugog termina: {$v['predlog']}, {$adresa}\nAko Vam ovaj termin odgovara, samo odgovorite na ovaj mejl i potvrdiću ga.\n" : '')
    . "\nKako zakazati drugi termin\nNovi zahtev možete poslati bilo kada, sa drugim željenim datumom: {$v['booking_url']}\n"
    . "Možete i odgovoriti na ovaj mejl — rado ćemo pronaći termin koji Vam odgovara.\n"
    . em_text_signature(false);

return [
    'subject'   => $imaPredlog ? 'Vaš zahtev za konsultaciju — predlog drugog termina' : 'Vaš zahtev za konsultaciju — termin nije dostupan',
    'preheader' => $imaPredlog ? 'Traženi termin nije slobodan — predlažem ' . $v['predlog'] . '.' : 'Traženi termin nažalost nije moguć — evo kako da zakažete drugi.',
    'eyebrow'   => 'Zahtev ' . $v['ref'],
    'heading'   => $imaPredlog ? 'Predlažem drugi termin' : 'Termin nažalost nije moguć',
    'content'   => $content,
    'text'      => $text,
];
