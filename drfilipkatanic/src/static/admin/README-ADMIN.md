# Zakazivanja — uputstvo

## Za doktora (bez tehničkog znanja)

**Adresa:** `https://VAŠ-DOMEN/admin/` — sačuvajte je kao obeleživač ili ikonicu na početnom ekranu telefona.

1. **Prijava** — upišite lozinku i kliknite **Prijava**. Ako je čekirano „Zapamti me na ovom uređaju“, telefon Vas pamti 30 dana.
2. **Novi zahtevi** su u tabu **Novi** (broj pored taba = koliko ih čeka). Za svaki novi zahtev dobijate i mejl sa dugmetom „Otvori zahtev“.
3. Na kartici pacijenta vidite ime, razlog, željeni datum, telefon i mejl. Dugmad **Pozovi / Viber / WhatsApp** otvaraju razgovor odmah.
4. **Potvrdi** → proverite datum i vreme (već su popunjeni željenim datumom), po želji napišite kratku poruku → **Potvrdi i pošalji mejl**.
5. **Odbij** → po želji napišite razlog (npr. „Termin je popunjen, pošaljite novi zahtev“) → **Odbij i pošalji mejl**.
6. Posle klika pacijent **automatski dobija mejl**, a na vrhu stranice piše zeleno: *„Mejl je poslat pacijentu“*.
   Ako piše žuto *„mejl NIJE poslat“* — pozovite pacijenta telefonom (broj je u poruci) i javite se tehničkoj podršci.
7. Potvrđeni i odbijeni zahtevi su u tabovima **Potvrđeni** i **Odbijeni**. **Odjava** je gore desno.

Zaboravljena lozinka: javite se osobi koja održava sajt (vidi „Promena lozinke“ ispod).

---

## Tehničko postavljanje (deljeni PHP hosting, PHP 8.1+ sa PDO SQLite)

1. **Upload:** pokrenite `python build.py` i ceo sadržaj foldera `site/` prebacite u javni folder hostinga (`public_html/`). Uključite i skrivene fajlove (`.htaccess`) — u FileZilli: *Server → Force showing hidden files*.
2. **Konfiguracija:** kopirajte `config.sample.php` u `config.php` (isti folder; ili još bolje iznad `public_html/` kao `fk-config.php`) i popunite:
   - `site_url` (npr. `https://drfilipkatanic.rs`),
   - `mail`: SMTP podaci mejl naloga sa hostinga (obično `mail.domen.rs`, port **465 + `ssl`** ili **587 + `tls`**) ili Gmail (`smtp.gmail.com`, 587, `tls`, korisnik = Gmail adresa, lozinka = **App password** iz Google naloga → Bezbednost → 2-Step Verification → App passwords),
   - `from_email` (mora biti na istom domenu kao SMTP nalog), `reply_to` (adresa koju doktor čita — pacijenti odgovaraju na nju), `doctor_email` (gde stižu obaveštenja o novim zahtevima).
3. **Prava foldera:** `data/` → `0750` (ili `0700`), mora biti upisiv za PHP. Baza `data/appointments.db`, sesije `data/sessions/` i log `data/app.log` se prave sami. Folder je zaključan `.htaccess`-om; ako hosting nije Apache/LiteSpeed (nginx), postavite `db_path` van `public_html/`.
4. **Lozinka:** odmah otvorite `https://VAŠ-DOMEN/admin/setup.php` i postavite lozinku (min. 12 znakova). Stranica radi samo jednom, posle se sama gasi. (Alternativa: upišite `admin_password_hash` u `config.php` — komanda je opisana u `config.sample.php`.)
5. **Test:** pošaljite probni zahtev sa `/zakazivanje/` na svoj mejl → treba da stignu 2 mejla (pacijentu i doktoru) → u adminu kliknite **Potvrdi** → stiže mejl potvrde. Ako mejl ne stigne, pogledajte `data/app.log` (preko FTP-a) — tu piše tačna SMTP greška. Za test bez SMTP-a: `'transport' => 'log'` upisuje mejlove kao `.eml` u `data/mail/`.

**Promena lozinke:** u `config.php` upišite novi `admin_password_hash` (ima prednost i odjavljuje sve uređaje) ILI obrišite red `admin_password_hash` iz tabele `settings` u bazi i ponovo otvorite `/admin/setup.php`.

**Bezbednost (radi samo):** CSRF tokeni, honeypot i limit 5 zahteva/sat po IP adresi na formi, zaključavanje prijave posle 5 pogrešnih lozinki (15 min), IP adrese se čuvaju samo kao heš, `.htaccess` zabranjuje pristup `config*.php`, `data/`, `lib/`, `*.db`, `*.log`, `*.md`.
