<?php
/** (2) Doktoru — "Novi zahtev za konsultaciju" sa linkom na detalj u admin panelu. Tekst: copy-v2.md §6.5 */

declare(strict_types=1);

/** @var array $v */
$a = $v['a'];
$rows = [
    'Pacijent'        => $v['ime'],
    'Partner'         => (string) ($a['partner_ime'] ?? ''),
    'Razlog'          => $v['usluga'],
    'Željeni datum'   => $v['zeljeni'],
    'Doba dana'       => $v['doba'],
    'Kontakt putem'   => $v['kanal'],
    'Telefon'         => (string) $a['telefon'],
    'E-mail'          => (string) $a['email'],
    'Nalazi'          => $v['dokumentacija'],
    'Napomena'        => (string) ($a['napomena'] ?? ''),
    'Primljeno'       => fk_date_short((string) ($a['datum_kreiranja'] ?? '')),
];

$content = em_p('Stigao je novi zahtev preko sajta.')
    . em_rows($rows)
    . em_button($v['admin_link'], 'Otvori zahtev →')
    . em_small('U admin panelu kliknite „Potvrdi“ ili „Odbij“ — pacijent automatski dobija mejl.<br>Odgovor na ovaj mejl ide direktno pacijentu.');

$text = "Stigao je novi zahtev preko sajta ({$v['ref']}).\n\n"
    . em_text_rows($rows) . "\n"
    . "Otvori zahtev: {$v['admin_link']}\n\n"
    . "U admin panelu kliknite „Potvrdi“ ili „Odbij“ — pacijent automatski dobija mejl.\n"
    . "Odgovor na ovaj mejl ide direktno pacijentu.\n";

return [
    'subject'   => 'Novi zahtev ' . $v['ref'] . ' — ' . $v['ime'] . ', ' . $v['usluga'],
    'preheader' => 'Željeni datum ' . $v['zeljeni'] . ' (' . $v['doba'] . ') · tel. ' . $a['telefon'],
    'eyebrow'   => 'Admin · zahtev ' . $v['ref'],
    'heading'   => 'Novi zahtev za konsultaciju',
    'content'   => $content,
    'text'      => $text,
    'audience'  => 'doctor',
];
