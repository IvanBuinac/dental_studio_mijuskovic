<?php
/** Pacijentu — otkazivanje prethodno potvrđenog termina. Tekst: copy-v2.md §6.4 */

declare(strict_types=1);

/** @var array $v */
$a = $v['a'];
$razlog = trim((string) ($a['razlog_otkazivanja'] ?? ''));
$kada = $v['termin_datum'] . ($v['termin_vreme'] !== '' ? ' u ' . $v['termin_vreme'] . ' h' : '');

$content = em_p('Poštovani/a ' . e($v['ime']) . ',')
    . em_p('obaveštavam Vas da je termin konsultacije zakazan za <strong>' . e($kada) . '</strong> nažalost otkazan. Izvinjavam se zbog neprijatnosti.')
    . ($razlog !== '' ? em_h2('Obrazloženje') . em_quote($razlog, $v['doctor']) : '')
    . em_p('Odgovorite na ovaj mejl ili pošaljite novi zahtev — rado ćemo pronaći novi termin što pre:')
    . em_button($v['booking_url'], 'Pošaljite novi zahtev')
    . em_signature(false);

$text = "Poštovani/a {$v['ime']},\n\n"
    . "obaveštavam Vas da je termin konsultacije zakazan za {$kada} nažalost otkazan. Izvinjavam se zbog neprijatnosti.\n"
    . ($razlog !== '' ? "\nObrazloženje:\n{$razlog}\n" : '')
    . "\nOdgovorite na ovaj mejl ili pošaljite novi zahtev — rado ćemo pronaći novi termin što pre: {$v['booking_url']}\n"
    . em_text_signature(false);

return [
    'subject'   => 'Termin ' . $kada . ' je otkazan',
    'preheader' => 'Izvinjavam se zbog promene — evo kako da zakažete novi termin.',
    'eyebrow'   => 'Zahtev ' . $v['ref'],
    'heading'   => 'Termin je otkazan',
    'content'   => $content,
    'text'      => $text,
];
