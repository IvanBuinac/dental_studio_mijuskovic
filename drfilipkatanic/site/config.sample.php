<?php
/**
 * Konfiguracija zakazivanja i admin panela — dr Filip Katanić
 * ------------------------------------------------------------------
 * 1) Kopirajte ovaj fajl u  config.php  (isti folder), ILI ga stavite
 *    iznad javnog foldera kao  ../fk-config.php  (preporuka: van webroot-a).
 * 2) Popunite SMTP podatke i adrese ispod.
 * 3) config.php se NIKAD ne commit-uje u git (vidi .gitignore) i
 *    .htaccess zabranjuje pristup preko weba.
 *
 * Ako config.php ne postoji, sistem radi sa bezbednim podrazumevanim
 * vrednostima: mejl ide preko PHP mail() funkcije, doktor ne dobija
 * obaveštenja (nema adrese), baza je u data/appointments.db.
 */

declare(strict_types=1);

return [
    // Javna adresa sajta BEZ kose crte na kraju. Koristi se za linkove u mejlovima.
    // Obavezno popuniti u produkciji (inače se adresa izvodi iz zahteva).
    'site_url'  => 'https://www.example.rs',

    // Adresa admin panela; ako je prazno => site_url . '/admin/'
    'admin_url' => '',

    'timezone'  => 'Europe/Belgrade',

    // Putanja do SQLite baze. Preporuka: folder VAN javnog dela sajta, npr.
    // '/home/korisnik/private/zakazivanje.db'. Podrazumevano: data/appointments.db
    // (folder data/ je zaštićen .htaccess-om).
    'db_path'   => __DIR__ . '/data/appointments.db',

    // Dugačak nasumičan string (min. 32 znaka) — koristi se za heširanje IP adresa.
    // Ako je prazno, generiše se automatski i čuva u bazi.
    // Generisanje: php -r "echo bin2hex(random_bytes(32)), PHP_EOL;"
    'app_secret' => '',

    // ADMIN LOZINKA — dva načina (izaberite jedan):
    //  a) ostavite prazno i jednom otvorite  /admin/setup.php  (lozinka se čuva u bazi, stranica se zatim sama gasi), ili
    //  b) upišite hash lozinke ovde. Hash se pravi komandom:
    //       php -r "echo password_hash('VASA-LOZINKA', PASSWORD_DEFAULT), PHP_EOL;"
    //     Kad je postavljen ovde, ima prednost nad setup.php. Promena hash-a odjavljuje sve uređaje.
    'admin_password_hash' => '',

    // Opciono: ako je postavljeno, admin/setup.php traži ovaj ključ (zaštita ako sajt
    // bude javan pre nego što postavite lozinku).
    'setup_key' => '',

    'mail' => [
        // 'smtp' (preporuka) | 'mail' (PHP mail()) | 'log' (samo upis .eml fajla u data/mail/ — za testiranje)
        'transport'   => 'smtp',

        // SMTP server. Primeri:
        //  - hosting mejl:  host 'mail.vasdomen.rs', port 465, secure 'ssl'  (ili 587 + 'tls')
        //  - Gmail:         host 'smtp.gmail.com',   port 587, secure 'tls', username = Gmail adresa,
        //                   password = "App password" (Google nalog → Bezbednost → 2FA → App passwords)
        'host'        => 'mail.example.rs',
        'port'        => 465,
        'secure'      => 'ssl',          // 'ssl' (465) | 'tls' (STARTTLS, 587) | 'none' (samo lokalni relay)
        'username'    => 'zakazivanje@example.rs',
        'password'    => '',
        'timeout'     => 15,             // sekundi
        'verify_peer' => true,           // proveravaj TLS sertifikat (ne isključivati u produkciji)
        'ehlo_host'   => '',             // prazno = automatski

        // Ako SMTP ne uspe, pokušaj i preko PHP mail() funkcije.
        'fallback_to_mail' => true,

        // Pošiljalac. Adresa MORA biti na domenu SMTP naloga (SPF/DKIM), inače mejl ide u spam.
        'from_email'  => 'zakazivanje@example.rs',
        'from_name'   => 'dr Filip Katanić',

        // Na koju adresu pacijent odgovara (Reply-To). Prazno = from_email.
        'reply_to'    => '',

        // Gde stižu obaveštenja o novim zahtevima (doktor / asistent). Može više adresa odvojenih zarezom.
        'doctor_email' => 'doktor@example.rs',
    ],

    'booking' => [
        'max_per_hour_per_ip'   => 5,    // uspešnih zahteva po IP adresi na sat
        'max_tries_per_hour_ip' => 30,   // svih pokušaja (uklj. neispravne) po IP na sat
        'min_fill_seconds'      => 3,    // ako frontend pošalje polje ts (Date.now() pri prikazu forme)
        'max_months_ahead'      => 6,    // copy-v2: "Izaberite datum u narednih 6 meseci."
    ],

    // Mesto ordiniranja — prikazuje se u mejlu potvrde.
    'location' => [
        'name'    => 'SB Ferona',
        'address' => 'Šarplaninska 19, Novi Sad',
        'map_url' => 'https://www.google.com/maps/search/?api=1&query=SB+Ferona+Sarplaninska+19+Novi+Sad',
    ],

    // Admin sesija ("Zapamti me" drži prijavu 30 dana)
    'admin' => [
        'idle_minutes'     => 120,       // automatska odjava posle neaktivnosti
        'max_login_fails'  => 5,         // pogrešnih pokušaja pre zaključavanja
        'lock_minutes'     => 15,
    ],

    // Iza reverse proxy-ja/CDN-a (npr. Cloudflare) postavite na true da bi se koristila prava IP adresa.
    'trust_proxy' => false,
];
