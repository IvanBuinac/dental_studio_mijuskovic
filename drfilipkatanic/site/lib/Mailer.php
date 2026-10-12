<?php
/**
 * Mali SMTP klijent bez zavisnosti.
 *  - SSL (implicitni TLS, port 465), STARTTLS (587) ili bez šifrovanja (lokalni relay)
 *  - AUTH LOGIN (ili AUTH PLAIN ako server ne nudi LOGIN)
 *  - UTF-8, multipart/alternative (text + HTML, quoted-printable), Message-ID, Reply-To
 *  - fallback na PHP mail(); transport 'log' upisuje .eml u data/mail/ (testiranje)
 *
 * Upotreba:
 *   $r = (new Mailer(cfg('mail')))->send('pacijent@x.rs', 'Ime', 'Naslov', $html, $text);
 *   // $r = ['ok' => bool, 'transport' => 'smtp|mail|log', 'message_id' => '<…>', 'error' => ?string]
 */

declare(strict_types=1);

final class Mailer
{
    private array $c;
    /** @var resource|null */
    private $sock = null;
    private array $ext = [];

    public function __construct(array $config)
    {
        $this->c = $config + [
            'transport' => 'mail', 'host' => '', 'port' => 587, 'secure' => 'tls',
            'username' => '', 'password' => '', 'timeout' => 15, 'verify_peer' => true,
            'ehlo_host' => '', 'fallback_to_mail' => true, 'from_email' => '',
            'from_name' => '', 'reply_to' => '',
        ];
    }

    public function fromEmail(): string
    {
        $from = trim((string) $this->c['from_email']);
        if ($from === '' || !self::validEmail($from)) {
            $host = preg_replace('/:\d+$/', '', strtolower((string) ($_SERVER['HTTP_HOST'] ?? 'localhost'))) ?: 'localhost';
            $host = preg_replace('/^www\./', '', $host);
            $from = 'no-reply@' . (preg_match('/^[a-z0-9.\-]+$/', $host) ? $host : 'localhost');
        }
        return $from;
    }

    /**
     * @param array $opts reply_to, reply_to_name, headers (dodatni, npr. ['Auto-Submitted' => 'auto-generated'])
     */
    public function send(string $toEmail, string $toName, string $subject, string $html, string $text, array $opts = []): array
    {
        $toEmail = trim($toEmail);
        $messageId = '<' . bin2hex(random_bytes(12)) . '.' . time() . '@' . self::domainOf($this->fromEmail()) . '>';
        $result = ['ok' => false, 'transport' => (string) $this->c['transport'], 'message_id' => $messageId, 'error' => null];

        if (!self::validEmail($toEmail)) {
            $result['error'] = 'Neispravna adresa primaoca.';
            return $result;
        }

        [$headers, $body] = $this->build($toEmail, $toName, $subject, $html, $text, $messageId, $opts);
        $transport = strtolower((string) $this->c['transport']);

        if ($transport === 'log') {
            return $this->sendLog($toEmail, $headers, $body, $result);
        }

        if ($transport === 'smtp' && trim((string) $this->c['host']) !== '') {
            try {
                $this->sendSmtp($toEmail, $headers, $body);
                $result['ok'] = true;
                $result['transport'] = 'smtp';
                return $result;
            } catch (Throwable $e) {
                $this->close();
                $result['error'] = 'SMTP: ' . $this->scrub($e->getMessage());
                if (!$this->c['fallback_to_mail']) {
                    return $result;
                }
            }
        }

        // PHP mail()
        $smtpError = $result['error'];
        $result['transport'] = 'mail';
        if (!function_exists('mail')) {
            $result['error'] = trim(($smtpError ? $smtpError . ' | ' : '') . 'mail() nije dostupna na serveru.');
            return $result;
        }
        $hdr = $headers;
        unset($hdr['To'], $hdr['Subject']);
        $ok = false;
        try {
            $ok = @mail(
                self::formatAddress($toEmail, $toName),
                $headers['Subject'],
                $body,
                self::headerLines($hdr),
                '-f' . $this->fromEmail()
            );
        } catch (Throwable $e) {
            $ok = false;
        }
        $result['ok'] = (bool) $ok;
        $result['error'] = $ok ? $smtpError : trim(($smtpError ? $smtpError . ' | ' : '') . 'mail() nije uspeo (server nema podešen sendmail?).');
        return $result;
    }

    /* ------------------------------------------------------------ poruka */

    private function build(string $to, string $toName, string $subject, string $html, string $text, string $messageId, array $opts): array
    {
        $from = $this->fromEmail();
        $replyTo = trim((string) ($opts['reply_to'] ?? '')) ?: trim((string) $this->c['reply_to']);
        $boundary = '=_fk_' . bin2hex(random_bytes(12));

        $headers = [
            'Date'         => date('r'),
            'From'         => self::formatAddress($from, (string) $this->c['from_name']),
            'To'           => self::formatAddress($to, $toName),
            'Subject'      => self::encodeHeader(self::oneLine($subject)),
            'Message-ID'   => $messageId,
            'MIME-Version' => '1.0',
            'Content-Type' => 'multipart/alternative; boundary="' . $boundary . '"',
        ];
        if ($replyTo !== '' && self::validEmail($replyTo)) {
            $headers['Reply-To'] = self::formatAddress($replyTo, (string) ($opts['reply_to_name'] ?? ''));
        }
        foreach (($opts['headers'] ?? []) as $k => $v) {
            if (preg_match('/^[A-Za-z0-9\-]+$/', (string) $k)) {
                $headers[$k] = self::oneLine((string) $v);
            }
        }

        $body = "This is a multi-part message in MIME format.\r\n\r\n"
            . '--' . $boundary . "\r\n"
            . "Content-Type: text/plain; charset=UTF-8\r\n"
            . "Content-Transfer-Encoding: quoted-printable\r\n\r\n"
            . self::qp($text) . "\r\n\r\n"
            . '--' . $boundary . "\r\n"
            . "Content-Type: text/html; charset=UTF-8\r\n"
            . "Content-Transfer-Encoding: quoted-printable\r\n\r\n"
            . self::qp($html) . "\r\n\r\n"
            . '--' . $boundary . "--\r\n";

        return [$headers, $body];
    }

    private static function qp(string $s): string
    {
        $s = preg_replace('/\r\n|\r|\n/', "\r\n", $s) ?? $s;
        return quoted_printable_encode($s);
    }

    private static function headerLines(array $headers): string
    {
        $out = [];
        foreach ($headers as $k => $v) {
            $out[] = $k . ': ' . $v;
        }
        return implode("\r\n", $out);
    }

    public static function oneLine(string $s): string
    {
        return trim(preg_replace('/[\r\n\t]+/', ' ', $s) ?? '');
    }

    public static function validEmail(string $email): bool
    {
        return strlen($email) <= 254
            && !preg_match('/[\r\n<>,;"\s]/', $email)
            && filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    private static function domainOf(string $email): string
    {
        $d = strtolower(substr(strrchr($email, '@') ?: '@localhost', 1));
        return preg_match('/^[a-z0-9.\-]+$/', $d) ? $d : 'localhost';
    }

    /** RFC 2047 encoded-word (base64), fold na ≤ 75 znakova, bez cepanja UTF-8 znakova. */
    public static function encodeHeader(string $s): string
    {
        if ($s === '' || !preg_match('/[^\x20-\x7E]/', $s)) {
            return $s;
        }
        $chars = preg_split('//u', $s, -1, PREG_SPLIT_NO_EMPTY) ?: [$s];
        $words = [];
        $chunk = '';
        foreach ($chars as $ch) {
            if (strlen($chunk . $ch) > 45) {
                $words[] = '=?UTF-8?B?' . base64_encode($chunk) . '?=';
                $chunk = '';
            }
            $chunk .= $ch;
        }
        if ($chunk !== '') {
            $words[] = '=?UTF-8?B?' . base64_encode($chunk) . '?=';
        }
        return implode("\r\n ", $words);
    }

    public static function formatAddress(string $email, string $name = ''): string
    {
        $email = self::oneLine($email);
        $name = self::oneLine($name);
        if ($name === '') {
            return $email;
        }
        if (preg_match('/[^\x20-\x7E]/', $name)) {
            $name = self::encodeHeader($name);
        } else {
            $name = '"' . addcslashes($name, '"\\') . '"';
        }
        return $name . ' <' . $email . '>';
    }

    /* ------------------------------------------------------------ SMTP */

    private function sendSmtp(string $to, array $headers, string $body): void
    {
        $host = trim((string) $this->c['host']);
        $port = (int) $this->c['port'];
        $secure = strtolower((string) $this->c['secure']);
        $timeout = max(3, (int) $this->c['timeout']);
        $verify = (bool) $this->c['verify_peer'];

        $ctx = stream_context_create(['ssl' => [
            'verify_peer'       => $verify,
            'verify_peer_name'  => $verify,
            'allow_self_signed' => !$verify,
            'peer_name'         => $host,
            'SNI_enabled'       => true,
        ]]);
        $remote = ($secure === 'ssl' ? 'ssl://' : 'tcp://') . $host . ':' . $port;
        $errno = 0;
        $errstr = '';
        $sock = @stream_socket_client($remote, $errno, $errstr, $timeout, STREAM_CLIENT_CONNECT, $ctx);
        if (!$sock) {
            throw new RuntimeException("konekcija na {$host}:{$port} nije uspela ({$errno} {$errstr})");
        }
        $this->sock = $sock;
        stream_set_timeout($sock, $timeout);

        $this->expect([220]);
        $this->ehlo();

        if ($secure === 'tls') {
            if (!isset($this->ext['STARTTLS'])) {
                throw new RuntimeException('server ne podržava STARTTLS');
            }
            $this->cmd('STARTTLS', [220]);
            $method = STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT;
            if (defined('STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT')) {
                $method |= STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT;
            }
            if (!@stream_socket_enable_crypto($sock, true, $method)) {
                throw new RuntimeException('STARTTLS pregovaranje nije uspelo (sertifikat?)');
            }
            $this->ehlo();
        }

        $user = (string) $this->c['username'];
        if ($user !== '') {
            $auth = strtoupper($this->ext['AUTH'] ?? '');
            $pass = (string) $this->c['password'];
            if ($auth === '' || str_contains($auth, 'LOGIN')) {
                $this->cmd('AUTH LOGIN', [334]);
                $this->cmd(base64_encode($user), [334], true);
                $this->cmd(base64_encode($pass), [235], true);
            } elseif (str_contains($auth, 'PLAIN')) {
                $this->cmd('AUTH PLAIN ' . base64_encode("\0" . $user . "\0" . $pass), [235], true);
            } else {
                throw new RuntimeException('server ne nudi AUTH LOGIN/PLAIN');
            }
        }

        $this->cmd('MAIL FROM:<' . $this->fromEmail() . '>', [250]);
        $this->cmd('RCPT TO:<' . $to . '>', [250, 251]);
        $this->cmd('DATA', [354]);

        $data = self::headerLines($headers) . "\r\n\r\n" . $body;
        $data = preg_replace('/\r\n|\r|\n/', "\r\n", $data) ?? $data;
        $data = preg_replace('/^\./m', '..', $data) ?? $data;   // dot-stuffing
        $this->write($data . "\r\n.\r\n");
        $this->expect([250]);

        try {
            $this->cmd('QUIT', [221]);
        } catch (Throwable) {
            // poruka je već prihvaćena
        }
        $this->close();
    }

    private function ehlo(): void
    {
        $name = trim((string) $this->c['ehlo_host']);
        if ($name === '') {
            $name = preg_replace('/:\d+$/', '', (string) ($_SERVER['SERVER_NAME'] ?? $_SERVER['HTTP_HOST'] ?? '')) ?: '';
            if (!preg_match('/^[a-z0-9.\-]+\.[a-z]{2,}$/i', $name)) {
                $name = self::domainOf($this->fromEmail());
            }
        }
        $lines = $this->cmd('EHLO ' . $name, [250]);
        $this->ext = [];
        foreach (array_slice($lines, 1) as $l) {
            $parts = explode(' ', strtoupper(trim(substr($l, 4))), 2);
            $this->ext[$parts[0]] = $parts[1] ?? '';
        }
    }

    /** @return string[] linije odgovora */
    private function cmd(string $command, array $okCodes, bool $secret = false): array
    {
        $this->write($command . "\r\n");
        try {
            return $this->expect($okCodes);
        } catch (RuntimeException $e) {
            $shown = $secret ? '[skriveno]' : (str_starts_with($command, 'AUTH') ? 'AUTH' : $command);
            throw new RuntimeException($shown . ' → ' . $e->getMessage());
        }
    }

    private function write(string $data): void
    {
        $len = strlen($data);
        $done = 0;
        while ($done < $len) {
            $n = @fwrite($this->sock, substr($data, $done, 8192));
            if ($n === false || $n === 0) {
                throw new RuntimeException('veza sa SMTP serverom je prekinuta pri slanju');
            }
            $done += $n;
        }
    }

    private function expect(array $okCodes): array
    {
        $lines = [];
        while (true) {
            $line = @fgets($this->sock, 2048);
            if ($line === false) {
                $meta = stream_get_meta_data($this->sock);
                throw new RuntimeException(!empty($meta['timed_out']) ? 'isteklo vreme čekanja odgovora' : 'server je zatvorio vezu');
            }
            $lines[] = rtrim($line, "\r\n");
            if (strlen($line) < 4 || $line[3] !== '-') {
                break;
            }
        }
        $code = (int) substr($lines[count($lines) - 1], 0, 3);
        if (!in_array($code, $okCodes, true)) {
            throw new RuntimeException('neočekivan odgovor: ' . mb_substr(implode(' / ', $lines), 0, 300));
        }
        return $lines;
    }

    private function close(): void
    {
        if (is_resource($this->sock)) {
            @fclose($this->sock);
        }
        $this->sock = null;
    }

    private function scrub(string $msg): string
    {
        $pass = (string) $this->c['password'];
        if ($pass !== '') {
            $msg = str_replace([$pass, base64_encode($pass)], '[skriveno]', $msg);
        }
        return mb_substr($msg, 0, 500);
    }

    /* ------------------------------------------------------------ log transport */

    private function sendLog(string $to, array $headers, string $body, array $result): array
    {
        $result['transport'] = 'log';
        $dir = fk_data_dir();
        if ($dir === null) {
            $result['error'] = 'data/ folder nije upisiv.';
            return $result;
        }
        $dir .= '/mail';
        if (!is_dir($dir)) {
            @mkdir($dir, 0750, true);
        }
        $file = $dir . '/' . date('Ymd-His') . '-' . bin2hex(random_bytes(3)) . '.eml';
        $ok = @file_put_contents($file, self::headerLines($headers) . "\r\n\r\n" . $body) !== false;
        $result['ok'] = $ok;
        if (!$ok) {
            $result['error'] = 'Upis .eml fajla nije uspeo.';
        }
        return $result;
    }
}
