<?php
/** (1) Pacijentu odmah po slanju forme — "Zahtev je primljen". Tekst: copy-v2.md §6.1 */

declare(strict_types=1);

/** @var array $v */
$a = $v['a'];
$rows = [
    'Broj zahteva'    => $v['ref'],
    'Razlog'          => $v['usluga'],
    'Željeni datum'   => $v['zeljeni'],
    'Doba dana'       => $v['doba'],
    'Kontakt'         => $v['kanal'],
    'Telefon'         => (string) $a['telefon'],
    'E-mail'          => (string) $a['email'],
    'Partner'         => (string) ($a['partner_ime'] ?? ''),
    'Nalazi'          => $v['dokumentacija'],
    'Napomena'        => (string) ($a['napomena'] ?? ''),
];

$content = em_p('Poštovani/a ' . e($v['ime']) . ',')
    . em_p('hvala Vam na poverenju. Vaš zahtev za konsultaciju je primljen i pregledaću ga u najkraćem roku.')
    . em_note('<strong style="color:' . EM_NAVY . ';">Ovo još nije potvrda termina.</strong> Tačan datum i vreme — ili predlog drugog termina, ako željeni nije slobodan — dobićete u posebnom mejlu. Po potrebi ću Vas kontaktirati i putem kanala koji ste izabrali (' . e($v['kanal']) . ').')
    . em_h2('Rezime zahteva')
    . em_rows($rows)
    . em_p('Ako ste nešto pogrešno uneli ili želite da dopunite zahtev, samo odgovorite na ovaj mejl.')
    . em_p('Do konsultacije, ako imate prethodne nalaze (hormonske analize, ultrazvuk, spermogram partnera, izveštaje o ranijim postupcima), pripremite ih — razgovor će biti konkretniji. Ako ih nemate, nema problema: zajedno ćemo videti šta ima smisla uraditi.')
    . em_signature();

$text = "Poštovani/a {$v['ime']},\n\n"
    . "hvala Vam na poverenju. Vaš zahtev za konsultaciju je primljen i pregledaću ga u najkraćem roku.\n\n"
    . "Ovo još nije potvrda termina. Tačan datum i vreme — ili predlog drugog termina, ako željeni nije slobodan — dobićete u posebnom mejlu. Po potrebi ću Vas kontaktirati i putem kanala koji ste izabrali ({$v['kanal']}).\n\n"
    . "REZIME ZAHTEVA\n" . em_text_rows($rows) . "\n"
    . "Ako ste nešto pogrešno uneli ili želite da dopunite zahtev, samo odgovorite na ovaj mejl.\n\n"
    . "Do konsultacije, ako imate prethodne nalaze (hormonske analize, ultrazvuk, spermogram partnera, izveštaje o ranijim postupcima), pripremite ih — razgovor će biti konkretniji. Ako ih nemate, nema problema: zajedno ćemo videti šta ima smisla uraditi.\n"
    . em_text_signature();

return [
    'subject'   => 'Primili smo Vaš zahtev za konsultaciju ' . $v['ref'],
    'preheader' => 'Ovo još nije potvrda termina — potvrdu dobijate u posebnom mejlu.',
    'eyebrow'   => 'Zahtev ' . $v['ref'],
    'heading'   => 'Zahtev je primljen',
    'content'   => $content,
    'text'      => $text,
];
