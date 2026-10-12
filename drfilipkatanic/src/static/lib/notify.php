<?php
/**
 * Slanje mejlova vezanih za zahteve + upis u email_log.
 * Nijedna funkcija ovde ne baca izuzetak ka pozivaocu — neuspeh mejla ne sme oboriti zahtev.
 *
 * Tipovi:  primljen (pacijentu)  | doktor (obaveštenje)  | potvrda | odbijanje | otkazivanje
 */

declare(strict_types=1);

const FK_EMAIL_TYPES = [
    'primljen'    => ['tpl' => 'zahtev-primljen',    'to' => 'patient', 'label' => 'Zahtev primljen'],
    'doktor'      => ['tpl' => 'novi-zahtev-doktor', 'to' => 'doctor',  'label' => 'Obaveštenje doktoru'],
    'potvrda'     => ['tpl' => 'potvrda-termina',    'to' => 'patient', 'label' => 'Potvrda termina'],
    'odbijanje'   => ['tpl' => 'odbijanje',          'to' => 'patient', 'label' => 'Odbijanje / nemogućnost termina'],
    'otkazivanje' => ['tpl' => 'otkazivanje',        'to' => 'patient', 'label' => 'Otkazivanje termina'],
];

/** Mejl koji odgovara trenutnom statusu (za "Ponovo pošalji mejl"). */
function fk_email_type_for_status(string $status): string
{
    return match ($status) {
        'potvrdjeno' => 'potvrda',
        'odbijeno'   => 'odbijanje',
        'otkazano'   => 'otkazivanje',
        default      => 'primljen',
    };
}

/** Promenljive dostupne šablonima. */
function fk_email_vars(array $a): array
{
    $site = fk_site_url();
    return [
        'a'            => $a,
        'id'           => (int) $a['id'],
        'ref'          => '#' . str_pad((string) $a['id'], 4, '0', STR_PAD_LEFT),
        'ime'          => (string) $a['ime_prezime'],
        'usluga'       => fk_label('tip_usluge', $a['tip_usluge'] ?? null),
        'kanal'        => fk_label('kontakt_kanal', $a['kontakt_kanal'] ?? null),
        'doba'         => fk_label('doba_dana', $a['doba_dana'] ?? null),
        'dokumentacija' => fk_label('dokumentacija_status', $a['dokumentacija_status'] ?? null),
        'zeljeni'      => fk_date_sr($a['zeljeni_datum'] ?? null),
        'termin_datum' => fk_date_sr($a['potvrdjeni_datum'] ?? null),
        'termin_vreme' => (string) ($a['potvrdjeno_vreme'] ?? ''),
        'predlog'      => fk_proposal_sr($a['predlog_termina'] ?? null),
        'site_url'     => $site,
        'booking_url'  => $site . '/zakazivanje/',
        'admin_link'   => fk_admin_url('zahtev.php?id=' . (int) $a['id']),
        'loc_name'     => (string) cfg('location.name', 'SB Ferona'),
        'loc_address'  => (string) cfg('location.address', 'Šarplaninska 19, Novi Sad'),
        'map_url'      => (string) cfg('location.map_url', ''),
        'doctor'       => 'dr Filip Katanić',
    ];
}

function fk_render_email(string $template, array $v): array
{
    require_once FK_LIB . '/templates/_layout.php';
    $file = FK_LIB . '/templates/' . basename($template) . '.php';
    $m = (static function (string $__file, array $v): array {
        return require $__file;
    })($file, $v);
    $m += ['subject' => '', 'preheader' => '', 'eyebrow' => '', 'heading' => '', 'content' => '', 'text' => '', 'audience' => 'patient'];
    return [
        'subject' => $m['subject'],
        'html'    => fk_email_layout($m, $v),
        'text'    => fk_email_text_wrap($m, $v),
    ];
}

/**
 * Pošalji mejl tipa $type za zahtev $a. Vraća ['ok' => bool, 'error' => ?string, 'skipped' => bool].
 */
function fk_send_appointment_email(string $type, array $a): array
{
    $out = ['ok' => false, 'error' => null, 'skipped' => false];
    try {
        $def = FK_EMAIL_TYPES[$type] ?? null;
        if ($def === null) {
            throw new InvalidArgumentException('Nepoznat tip mejla: ' . $type);
        }
        $mail = fk_render_email($def['tpl'], fk_email_vars($a));
        $mailer = new Mailer((array) cfg('mail', []));

        if ($def['to'] === 'doctor') {
            $recipients = array_values(array_filter(array_map('trim', explode(',', (string) cfg('mail.doctor_email', '')))));
            $recipients = array_values(array_filter($recipients, static fn ($r) => !str_contains($r, 'example.')));
            if (!$recipients) {
                fk_email_log((int) $a['id'], $type, '—', $mail['subject'], 'preskoceno', null, null, 'mail.doctor_email nije podešen u config.php');
                return ['ok' => false, 'error' => 'Adresa doktora nije podešena.', 'skipped' => true];
            }
            $allOk = true;
            $errors = [];
            foreach ($recipients as $to) {
                $r = $mailer->send($to, '', $mail['subject'], $mail['html'], $mail['text'], [
                    'reply_to'      => (string) $a['email'],
                    'reply_to_name' => (string) $a['ime_prezime'],
                ]);
                fk_email_log((int) $a['id'], $type, $to, $mail['subject'], $r['ok'] ? 'poslato' : 'greska', $r['transport'], $r['message_id'], $r['error']);
                $allOk = $allOk && $r['ok'];
                if (!$r['ok']) {
                    $errors[] = $r['error'];
                }
            }
            return ['ok' => $allOk, 'error' => $errors ? implode(' | ', $errors) : null, 'skipped' => false];
        }

        $r = $mailer->send((string) $a['email'], (string) $a['ime_prezime'], $mail['subject'], $mail['html'], $mail['text'], [
            'headers' => ['Auto-Submitted' => 'auto-generated'],
        ]);
        fk_email_log((int) $a['id'], $type, (string) $a['email'], $mail['subject'], $r['ok'] ? 'poslato' : 'greska', $r['transport'], $r['message_id'], $r['error']);
        if (!$r['ok']) {
            app_log('warning', 'Mejl nije poslat', ['tip' => $type, 'id' => $a['id'], 'greska' => $r['error']]);
        }
        return ['ok' => $r['ok'], 'error' => $r['error'], 'skipped' => false];
    } catch (Throwable $e) {
        app_log('error', 'Greška pri slanju mejla: ' . $e->getMessage(), ['tip' => $type, 'id' => $a['id'] ?? null, 'file' => $e->getFile() . ':' . $e->getLine()]);
        fk_email_log((int) ($a['id'] ?? 0), $type, (string) ($a['email'] ?? '—'), null, 'greska', null, null, 'Interna greška: ' . $e->getMessage());
        $out['error'] = 'Interna greška pri pripremi mejla.';
        return $out;
    }
}

function fk_email_log(int $apptId, string $type, string $to, ?string $subject, string $status, ?string $transport, ?string $messageId, ?string $error): void
{
    try {
        db()->prepare('INSERT INTO email_log (appointment_id, tip, primalac, naslov, status, transport, message_id, greska, created_at)
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)')
            ->execute([$apptId ?: null, $type, $to, $subject, $status, $transport, $messageId, $error ? mb_substr($error, 0, 1000) : null, fk_now()]);
    } catch (Throwable $e) {
        app_log('error', 'email_log upis nije uspeo: ' . $e->getMessage());
    }
}
