# dr Filip Katanić — sajt (build sistem i objava)

Statičan sajt (čist HTML5 + CSS + malo vanilla JS, bez frameworka i bez build koraka u produkciji). Izvor je u `src/` (partial-i, stranice, podaci), generisani izlaz koji se objavljuje je `site/`.

## 1. Kako se gradi

Preduslov: Python 3.8+ (opciono `pip install pillow` — bez toga se `favicon.ico/-32/-180.png` i `assets/img/og-image.jpg` preskaču uz upozorenje, ali su već generisani u repou).

```
python build.py            # gradi src/ -> site/
python build.py --lint     # gradi + provera zabranjenih izraza/pravila (exit 1 ako padne)
python build.py --kit      # gradi src/pages/_kit.html -> _preview/ (interni pregled komponenti, NE ide u site/)
python check.py            # dodatna tehnička QA provera (linkovi, alt/width/height, H1, SEO tagovi, JSON-LD, sitemap)
```

`build.py --lint` mora proći bez **grešaka** pre svake objave (upozorenja o `[POTVRDITI SA KLIJENTOM]`, `DEMO=True` i placeholder domenu su očekivana i OK). `check.py` mora vratiti 0 grešaka.

## 2. Lokalna provera pre objave

```
cd site
python -m http.server 8000
```
Otvoriti `http://localhost:8000/` i proći kroz meni, mobilni prikaz (< 1024px), FAQ akordeone, edukativni karusel, lightbox galerije i kontakt stranicu.

## 3. Objava (PHP hosting — zbog zakazivanja)

> **v2:** sajt ima PHP backend za zakazivanje (`api/`, `admin/`, `lib/`) → treba **deljeni PHP 8.1+ hosting sa PDO SQLite** (ne Cloudflare/Netlify static). Postavljanje backend-a: `src/static/admin/README-ADMIN.md`.


1. U `build.py` promeniti:
   - `SITE_URL = "https://DOMEN.rs"` → pravi domen (bez trailing slash).
   - `DEMO = True` → `DEMO = False` (uklanja `noindex` i menja `robots.txt` u `Allow: /`).
2. Pokrenuti `python build.py --lint` — mora proći bez grešaka.
3. Otpremiti **sadržaj** foldera `site/` (ne sam folder) na hosting (Netlify/Vercel/GitHub Pages/Cloudflare Pages/bilo koji statički host) — `index.html` mora biti u korenu.
4. Ako se hostuje na podputanji (npr. `nekihosting.com/katanic/`), sve interne putanje su relativne (`{{root}}` sistem) pa rade i tako — **izuzetak je `404.html`**, koji koristi `root: /` (apsolutne putanje) jer većina statičkih hostova servira taj fajl za bilo koju nepostojeću putanju; ako se sajt hostuje na podputanji, front matter `root:` u `src/pages/404.html` treba ručno podesiti na tu podputanju pre builda.
5. Proveriti da `sitemap.xml` i `robots.txt` na živom sajtu pokazuju pravi domen i `Allow: /`.

## 4. Struktura (v2)

```
site/
  index.html, o-meni/, oblasti-rada/ (+5), blog/ (+3), mediji-i-predavanja/, pitanja-i-odgovori/,
  kontakt/, zakazivanje/ (forma), politika-privatnosti/, 404.html, sitemap.xml, robots.txt, favicon*
  assets/css/ (tokens/base/components/pages)  assets/js/ (main, booking, lightbox, map)  assets/img/
  api/ (csrf.php, zakazi.php)  admin/ (login, lista, potvrdi/odbij)  lib/ (Mailer, db, mejl šabloni)
  data/ (SQLite baza, sesije, log — pravi ih PHP; zaključan .htaccess-om)  config.sample.php
src/      layout.html, partials/, pages/, data/site.json (lični tel/mejl — prazno = ne prikazuje se), data/jsonld/, static/
build.py  builder + --lint     check.py  tehnička QA
```

17 URL-ova u sitemap.xml + `404.html`. Fontovi: **EB Garamond** (naslovi) + Mulish (telo) — Cormorant Garamond je zamenjen jer loše crta kvačicu na č/ž (brand.md v2.3).

**JSON-LD:** `Person` (jobTitle "Lekar — reproduktivna medicina", `workLocation` = SB Ferona kao *mesto* rada, bez `worksFor`/`alumniOf`/ocena), `BreadcrumbList`, `FAQPage` (automatski iz `{{faq}}` blokova), `Article` na 3 članka.

## 5. Pravila sadržaja (v2)

- **Lični sajt dr Katanića.** SB Ferona se pominje **samo** kao mesto ordiniranja ("Ordinira u SB Ferona, Novi Sad", adresa, mapa) — nikad kao vlasnik sajta, CTA ili glavni kontakt. Ferona telefon se ne prikazuje.
- Glavni kontakt = **forma `/zakazivanje/`** + Instagram @drfilipkatanic. Lični telefon/mejl: upisati u `src/data/site.json` (prazno = ne prikazuje se).
- Titula "Specijalista ginekologije i akušerstva" / "Master reproduktivni embriolog" je dozvoljena (IG bio + odobrena referenca; `TITULA_SPECIJALISTA=True`), uz HTML komentar `[POTVRDITI: pismena potvrda titule]`.
- `hero.webp` i `konferencija-02.webp` (stare slike sa utisnutim tekstom) i dalje smeju samo kroz `.crop-hero` / `.crop-konferencija02` — `--lint` (`CROP_REQUIRED`) to proverava. v2 hero koristi nove fotografije (`hero-portret*.webp`).
- Bez izmišljenih brojki, recenzija, cena i garancija ishoda.

## 6. QA rezultati (2026-10-12, v2 — detalji u `qa.md`)

- `python build.py --lint` → 0 grešaka (20 očekivanih upozorenja: `[POTVRDITI]` komentari, `DEMO=True`).
- `python check.py` → 0 grešaka, 0 upozorenja.
- Playwright: 18 stranica × 390/768/1440 — bez horizontalnog skrola, bez JS grešaka i mrtvih slika; meni, dropdown, scroll-snap kartice, FAQ, lightbox, mapa na klik i sticky bar rade.
- Zakazivanje end-to-end na pravom PHP-u (lokalni SMTP): validacija, zapis u bazi, 2 mejla (pacijent + doktor), admin Potvrdi/Odbij → mejl pacijentu + flash "Mejl je poslat pacijentu".
- Početna: ~235 KB inicijalno (HTML+CSS+fontovi+hero+JS), ostale slike lazy.

## 7. Šta klijent mora da dostavi / podesi

1. **PHP hosting + domen** (`SITE_URL` i `DEMO=False` u `build.py`; trenutni demo URL je workers.dev — tamo PHP ne radi).
2. **SMTP nalog** za slanje mejlova (`config.php`: host/port/korisnik/lozinka, `from_email` na istom domenu, `doctor_email`, `reply_to`) + SPF/DKIM na domenu.
3. **Admin lozinka** — jednom otvoriti `/admin/setup.php` (ili `admin_password_hash` u `config.php`).
4. **Pismena potvrda titule** i doktorskih studija (Medicinski fakultet Novi Sad).
5. Lični telefon/mejl (opciono) → `src/data/site.json`.
6. Tačni linkovi: Mondo.rs članak, Selfnest epizoda, "Popodne sa Tanjom" (sada vode na IG objave / jedan YouTube kandidat); status SPRING Fertility.
7. Saglasnost da se slučaj iz Mondo.rs intervjua referiše; analitika (ako se koristi) za politiku privatnosti.
8. Opciono: vektorski logo (SVG), fotografije prostora, tačan Google Maps link.

Sve otvorene stavke su u kodu kao `<!-- [POTVRDITI SA KLIJENTOM: ...] -->` na tačnom mestu.

## 8. Poznata ograničenja / dizajnerske odluke

- Backend je namerno prost (brief-v2 §5): jedna admin stranica, tabovi Novi/Potvrđeni/Odbijeni, Potvrdi/Odbij → automatski mejl. Bez CSV-a, istorije, više korisnika i promene lozinke iz UI-a.
- Testimonijali i cenovnik ne postoje (nema saglasnosti; cena se dogovara na konsultaciji).
- Google mapa se učitava tek na klik (bez mrežnog zahteva ka Google-u pre toga).
- `php -S` (lokalni test) ne servira `404.html` za nepostojeće putanje — na Apache hostingu to radi `.htaccess`.
- Polje datuma koristi format uređaja (na srpskom telefonu dd.mm.gggg).
