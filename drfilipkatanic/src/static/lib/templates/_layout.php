<?php
/**
 * Zajednički okvir i komponente za HTML mejlove (inline CSS, tabele — Gmail/Outlook/Apple Mail).
 * Brend (brand.md v2): navy #12223D, zlato #B8955A (linije) / #82632F (tekst), krem #FBF8F3, serifni naslovi.
 *
 * Šablon (npr. potvrda-termina.php) vraća niz:
 *   subject, preheader, eyebrow, heading, content (HTML fragment iz em_* funkcija), text (plain), audience
 */

declare(strict_types=1);

const EM_NAVY  = '#12223D';
const EM_GOLD  = '#B8955A';   // linije/okviri
const EM_GOLDT = '#82632F';   // zlato za tekst (kontrast na beloj)
const EM_CREAM = '#F6F1E9';
const EM_SOFT  = '#FBF8F3';
const EM_TEXT  = '#33302C';
const EM_MUTED = '#6A645C';
const EM_LINE  = '#E8E0D4';
const EM_SERIF = "'Cormorant Garamond', Georgia, 'Times New Roman', serif";
const EM_SANS  = "'Mulish', 'Segoe UI', Helvetica, Arial, sans-serif";

function em_p(string $html, string $style = ''): string
{
    return '<p style="margin:0 0 16px;font-family:' . EM_SANS . ';font-size:15px;line-height:1.65;color:' . EM_TEXT . ';' . $style . '">' . $html . '</p>';
}

function em_small(string $html): string
{
    return '<p style="margin:0 0 12px;font-family:' . EM_SANS . ';font-size:13px;line-height:1.6;color:' . EM_MUTED . ';">' . $html . '</p>';
}

function em_h2(string $text): string
{
    return '<h2 style="margin:28px 0 12px;font-family:' . EM_SERIF . ';font-weight:600;font-size:21px;line-height:1.3;color:' . EM_NAVY . ';">' . e($text) . '</h2>';
}

/** Tabela "oznaka — vrednost"; vrednosti se escape-uju, prazne se preskaču. */
function em_rows(array $rows): string
{
    $html = '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;margin:0 0 20px;border-top:1px solid ' . EM_LINE . ';">';
    foreach ($rows as $label => $value) {
        $value = trim((string) $value);
        if ($value === '' || $value === '—') {
            continue;
        }
        $html .= '<tr>'
            . '<td valign="top" style="padding:11px 12px 11px 0;border-bottom:1px solid ' . EM_LINE . ';width:38%;font-family:' . EM_SANS . ';font-size:12px;letter-spacing:.06em;text-transform:uppercase;color:' . EM_MUTED . ';">' . e($label) . '</td>'
            . '<td valign="top" style="padding:11px 0;border-bottom:1px solid ' . EM_LINE . ';font-family:' . EM_SANS . ';font-size:15px;line-height:1.5;color:' . EM_TEXT . ';">' . nl2br(e($value)) . '</td>'
            . '</tr>';
    }
    return $html . '</table>';
}

/** "Bulletproof" dugme (radi i u Outlook-u). */
function em_button(string $url, string $label, bool $gold = false): string
{
    $bg = $gold ? EM_GOLD : EM_NAVY;
    return '<table role="presentation" cellpadding="0" cellspacing="0" border="0" style="margin:8px 0 24px;"><tr>'
        . '<td align="center" bgcolor="' . $bg . '" style="background:' . $bg . ';border-radius:3px;">'
        . '<a href="' . e($url) . '" target="_blank" style="display:inline-block;padding:14px 30px;font-family:' . EM_SANS . ';font-size:14px;font-weight:700;letter-spacing:.04em;color:#FFFFFF;text-decoration:none;border-radius:3px;">' . e($label) . '</a>'
        . '</td></tr></table>';
}

/** Istaknuti blok termina: datum (serif), vreme, mesto. */
function em_appointment_card(string $eyebrow, string $date, string $time, string $place, string $address, string $mapUrl = ''): string
{
    $map = $mapUrl !== '' ? '<br><a href="' . e($mapUrl) . '" target="_blank" style="color:' . EM_GOLDT . ';font-size:13px;text-decoration:underline;">Prikaži na mapi</a>' : '';
    return '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:8px 0 24px;border-collapse:separate;">'
        . '<tr><td bgcolor="' . EM_CREAM . '" style="background:' . EM_CREAM . ';border:1px solid ' . EM_LINE . ';border-top:3px solid ' . EM_GOLD . ';padding:24px 26px;">'
        . '<div style="font-family:' . EM_SANS . ';font-size:11px;letter-spacing:.2em;text-transform:uppercase;color:' . EM_GOLDT . ';margin:0 0 8px;">' . e($eyebrow) . '</div>'
        . '<div style="font-family:' . EM_SERIF . ';font-size:26px;line-height:1.2;font-weight:600;color:' . EM_NAVY . ';margin:0 0 4px;">' . e($date) . '</div>'
        . ($time !== '' ? '<div style="font-family:' . EM_SERIF . ';font-size:22px;color:' . EM_NAVY . ';margin:0 0 14px;">u ' . e($time) . ' h</div>' : '<div style="height:10px;line-height:10px;font-size:0;">&nbsp;</div>')
        . '<div style="font-family:' . EM_SANS . ';font-size:14px;line-height:1.55;color:' . EM_TEXT . ';"><strong>' . e($place) . '</strong><br>' . e($address) . $map . '</div>'
        . '</td></tr></table>';
}

/** Citat/poruka sa zlatnom linijom levo. */
function em_quote(string $text, string $author = ''): string
{
    return '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:4px 0 24px;"><tr>'
        . '<td width="3" bgcolor="' . EM_GOLD . '" style="background:' . EM_GOLD . ';width:3px;font-size:0;">&nbsp;</td>'
        . '<td style="padding:4px 0 4px 18px;font-family:' . EM_SERIF . ';font-size:19px;font-style:italic;line-height:1.5;color:' . EM_NAVY . ';">'
        . nl2br(e($text))
        . ($author !== '' ? '<div style="font-family:' . EM_SANS . ';font-style:normal;font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:' . EM_MUTED . ';margin-top:10px;">— ' . e($author) . '</div>' : '')
        . '</td></tr></table>';
}

/** Lista sa zlatnim tačkama. */
function em_list(array $items): string
{
    $html = '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 20px;">';
    foreach ($items as $item) {
        $html .= '<tr><td valign="top" width="22" style="width:22px;padding:5px 0;font-family:' . EM_SERIF . ';font-size:16px;line-height:1.4;color:' . EM_GOLD . ';">&#9670;</td>'
            . '<td style="padding:5px 0;font-family:' . EM_SANS . ';font-size:15px;line-height:1.55;color:' . EM_TEXT . ';">' . e($item) . '</td></tr>';
    }
    return $html . '</table>';
}

function em_note(string $html): string
{
    return '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 20px;"><tr>'
        . '<td bgcolor="' . EM_SOFT . '" style="background:' . EM_SOFT . ';border:1px solid ' . EM_LINE . ';padding:14px 18px;font-family:' . EM_SANS . ';font-size:14px;line-height:1.6;color:' . EM_TEXT . ';">' . $html . '</td>'
        . '</tr></table>';
}

/** Potpis doktora (prvo lice, copy-v2 §6). */
function em_signature(bool $withTitle = true): string
{
    return '<p style="margin:28px 0 0;font-family:' . EM_SANS . ';font-size:15px;line-height:1.5;color:' . EM_TEXT . ';">Srdačno,</p>'
        . '<p style="margin:4px 0 20px;font-family:' . EM_SERIF . ';font-size:22px;line-height:1.2;color:' . EM_NAVY . ';">dr Filip Katanić'
        . ($withTitle ? '<br><span style="font-family:' . EM_SANS . ';font-size:11px;letter-spacing:.2em;text-transform:uppercase;color:' . EM_GOLDT . ';">Reproduktivna medicina</span>' : '')
        . '</p>';
}

function em_text_signature(bool $withTitle = true): string
{
    return "\nSrdačno,\ndr Filip Katanić" . ($withTitle ? "\nReproduktivna medicina" : '') . "\n";
}

/** Plain-text rezime (oznaka: vrednost). */
function em_text_rows(array $rows): string
{
    $out = '';
    foreach ($rows as $label => $value) {
        $value = trim((string) $value);
        if ($value === '' || $value === '—') {
            continue;
        }
        $out .= $label . ': ' . str_replace("\n", "\n    ", $value) . "\n";
    }
    return $out;
}

function fk_email_layout(array $m, array $v): string
{
    $pre = e($m['preheader']) . str_repeat('&#847;&zwnj;&nbsp;', 40);
    $siteHost = preg_replace('#^https?://#', '', (string) $v['site_url']);
    $footerNote = ($m['audience'] ?? 'patient') === 'doctor'
        ? 'Interno obaveštenje sistema za zakazivanje. Odgovorom na ovaj mejl pišete direktno pacijentu.'
        : 'Ovaj mejl ste dobili jer ste poslali zahtev za konsultaciju preko sajta dr Filipa Katanića. Za hitna stanja obratite se najbližoj hitnoj službi.';

    return '<!DOCTYPE html>
<html lang="sr-Latn" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="x-apple-disable-message-reformatting">
<meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
<meta name="color-scheme" content="light">
<meta name="supported-color-schemes" content="light">
<title>' . e($m['subject']) . '</title>
<!--[if mso]><noscript><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml></noscript><![endif]-->
<style>
  body,table,td,a{-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}
  table,td{mso-table-lspace:0pt;mso-table-rspace:0pt}
  a{color:' . EM_NAVY . '}
  @media only screen and (max-width:620px){
    .fk-container{width:100%!important}
    .fk-px{padding-left:24px!important;padding-right:24px!important}
    .fk-h1{font-size:28px!important}
  }
</style>
</head>
<body style="margin:0;padding:0;background:' . EM_CREAM . ';word-spacing:normal;">
<div style="display:none;font-size:1px;line-height:1px;max-height:0;max-width:0;opacity:0;overflow:hidden;mso-hide:all;">' . $pre . '</div>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="' . EM_CREAM . '" style="background:' . EM_CREAM . ';">
<tr><td align="center" style="padding:32px 12px 40px;">
<!--[if mso]><table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0"><tr><td><![endif]-->
<table role="presentation" class="fk-container" width="600" cellpadding="0" cellspacing="0" border="0" style="width:600px;max-width:600px;">
  <tr><td class="fk-px" bgcolor="' . EM_NAVY . '" style="background:' . EM_NAVY . ';padding:26px 44px;">
    <table role="presentation" cellpadding="0" cellspacing="0" border="0"><tr>
      <td width="46" height="46" align="center" valign="middle" style="width:46px;height:46px;border:1px solid ' . EM_GOLD . ';font-family:' . EM_SERIF . ';font-size:19px;letter-spacing:1px;color:#D4B068;">FK</td>
      <td style="padding-left:16px;">
        <div style="font-family:' . EM_SERIF . ';font-size:23px;line-height:1.1;color:#FBF8F3;">dr Filip Katanić</div>
        <div style="font-family:' . EM_SANS . ';font-size:10px;line-height:1.6;letter-spacing:.24em;text-transform:uppercase;color:#D4B068;padding-top:4px;">Reproduktivna medicina</div>
      </td>
    </tr></table>
  </td></tr>
  <tr><td height="3" bgcolor="' . EM_GOLD . '" style="background:' . EM_GOLD . ';height:3px;font-size:0;line-height:0;">&nbsp;</td></tr>
  <tr><td class="fk-px" bgcolor="#FFFFFF" style="background:#FFFFFF;padding:40px 48px 28px;">
    ' . ($m['eyebrow'] !== '' ? '<div style="font-family:' . EM_SANS . ';font-size:11px;letter-spacing:.24em;text-transform:uppercase;color:' . EM_GOLDT . ';margin:0 0 12px;">' . e($m['eyebrow']) . '</div>' : '') . '
    <h1 class="fk-h1" style="margin:0 0 22px;font-family:' . EM_SERIF . ';font-weight:600;font-size:32px;line-height:1.15;color:' . EM_NAVY . ';">' . e($m['heading']) . '</h1>
    ' . $m['content'] . '
  </td></tr>
  <tr><td class="fk-px" bgcolor="' . EM_SOFT . '" style="background:' . EM_SOFT . ';border-top:1px solid ' . EM_LINE . ';padding:24px 48px 28px;">
    <div style="font-family:' . EM_SERIF . ';font-size:17px;color:' . EM_NAVY . ';margin:0 0 6px;">dr Filip Katanić</div>
    <div style="font-family:' . EM_SANS . ';font-size:12px;line-height:1.7;color:' . EM_MUTED . ';">
      Reproduktivna medicina &middot; IVF<br>
      Ordinira u ' . e($v['loc_name']) . ', ' . e($v['loc_address']) . '<br>
      <a href="' . e($v['site_url']) . '" target="_blank" style="color:' . EM_GOLDT . ';text-decoration:none;">' . e($siteHost) . '</a>
    </div>
    <div style="font-family:' . EM_SANS . ';font-size:11px;line-height:1.6;color:#9A938A;margin-top:14px;">' . e($footerNote) . '</div>
  </td></tr>
</table>
<!--[if mso]></td></tr></table><![endif]-->
</td></tr>
</table>
</body>
</html>';
}

function fk_email_text_wrap(array $m, array $v): string
{
    $footer = "\n--\nOrdinira u " . $v['loc_name'] . ', ' . $v['loc_address'] . "\n" . $v['site_url'] . "\n";
    return trim((string) $m['text']) . "\n" . $footer;
}
