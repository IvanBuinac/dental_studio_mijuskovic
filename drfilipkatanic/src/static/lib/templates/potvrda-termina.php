<?php
/**
 * (3) Pacijentu — POTVRDA termina. Tekst: copy-v2.md §6.2
 * [POTVRDITI SA KLIJENTOM] "lična karta / zdravstvena knjižica" i "dođite 10 minuta ranije" su namerno
 * izostavljeni dok ih klijent ne potvrdi (copy-v2 §9, tačka 18).
 */

declare(strict_types=1);

/** @var array $v */
$a = $v['a'];
$poruka = trim((string) ($a['poruka_pacijentu'] ?? ''));
$vreme = $v['termin_vreme'];
$adresa = $v['loc_name'] . ', ' . $v['loc_address'];
$poneti = [
    'Hormonske analize, ako ih imate',
    'Nalaz spermograma partnera, ako postoji',
    'Prethodnu medicinsku dokumentaciju (nalaze, ultrazvuk, izveštaje o ranijim postupcima)',
    'Spisak terapije koju trenutno koristite',
    'Pitanja koja želite da postavite — zapisana unapred, da ništa ne zaboravite',
];

$content = em_p('Poštovani/a ' . e($v['ime']) . ',')
    . em_p('sa zadovoljstvom Vam potvrđujem termin konsultacije.')
    . em_appointment_card('Vaš termin', $v['termin_datum'], $vreme, $v['loc_name'], $v['loc_address'], $v['map_url'])
    . ($poruka !== '' ? em_h2('Poruka za Vas') . em_quote($poruka, $v['doctor']) : '')
    . em_h2('Šta poneti')
    . em_list($poneti)
    . em_p('Ako ste sprečeni ili želite da pomerite termin, javite mi se odgovorom na ovaj mejl što ranije, kako bi termin mogao da se ustupi nekom drugom.')
    . em_p('<em style="font-family:' . EM_SERIF . ';font-size:18px;color:' . EM_NAVY . ';">Ne možemo kontrolisati baš sve, ali možemo napraviti najbolji plan.</em> Vidimo se.')
    . em_signature(false)
    . em_small('Razlog: ' . e($v['usluga']) . ' &middot; Broj zahteva: ' . e($v['ref']));

$text = "Poštovani/a {$v['ime']},\n\n"
    . "sa zadovoljstvom Vam potvrđujem termin konsultacije.\n\n"
    . "Datum: {$v['termin_datum']}\n"
    . ($vreme !== '' ? "Vreme: {$vreme} h\n" : '')
    . "Mesto: {$adresa}\n"
    . ($v['map_url'] !== '' ? "Otvori u Google mapama: {$v['map_url']}\n" : '')
    . ($poruka !== '' ? "\nPoruka za Vas:\n{$poruka}\n" : '')
    . "\nŠta poneti:\n– " . implode("\n– ", $poneti) . "\n\n"
    . "Ako ste sprečeni ili želite da pomerite termin, javite mi se odgovorom na ovaj mejl što ranije, kako bi termin mogao da se ustupi nekom drugom.\n\n"
    . "Ne možemo kontrolisati baš sve, ali možemo napraviti najbolji plan. Vidimo se.\n"
    . em_text_signature(false)
    . "\nRazlog: {$v['usluga']} · Broj zahteva: {$v['ref']}\n";

$kada = $v['termin_datum'] . ($vreme !== '' ? ' u ' . $vreme . ' h' : '');
return [
    'subject'   => 'Vaš termin je potvrđen: ' . $kada,
    'preheader' => 'Vidimo se ' . $kada . ' — ' . $adresa . '.',
    'eyebrow'   => 'Potvrda termina',
    'heading'   => 'Vaš termin je potvrđen',
    'content'   => $content,
    'text'      => $text,
];
