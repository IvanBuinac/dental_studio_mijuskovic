# QA — dr Filip Katanić (v2, 2026-10-12)

Obim: sve stranice iz `sitemap.xml` (17) + `/zakazivanje/` + 404, na 390 / 768 / 1440 px (Playwright, Chromium, full-page screenshotovi isečeni i pregledani); zakazivanje end-to-end na pravom PHP-u (`php -S` + lokalni SMTP sink); admin panel na 390 i 1440; mejl šabloni renderovani i pregledani; sadržaj, SEO, performanse.

Alati: `python3 build.py --lint` → **0 grešaka** (20 očekivanih upozorenja: `[POTVRDITI]` komentari, `DEMO=True`), `python3 check.py` → **0 grešaka, 0 upozorenja**.

## Nalazi

| # | ozbiljnost | gde | problem | predlog / status |
|---|---|---|---|---|
| 1 | kritično | svi naslovi, admin, mejlovi, favicon/monogram | Cormorant Garamond crta kvačicu na č/ž previsoko (kao odvojeno "v") — neprihvatljivo za srpski | **ISPRAVLJENO:** zamenjen sa **EB Garamond** (latin-ext, 400/500 + italic 400) u `layout.html`, `tokens.css`, `admin.css` + `lib/admin.php` link, mejl `_layout.php` (font stack + `<link>` za Apple Mail), `seal.html`, `favicon.svg`, brand.md v2.3, structure-v2.md. Veličine naslova −10% (tokeni + hardkodovane serif veličine u components/pages.css), serif 600→500, italic 500→400. Provereno screenshotom 2× (Č Ć Š Ž Đ č ć š ž đ — ispravno). "Cormorant" ostaje samo u napomeni o zameni. |
| 2 | srednje | `/mediji-i-predavanja/` 390px | Pločice konferencija u 2 kolone sa ikonom levo — tekst se lomi na 5–7 redova, zbijeno | **ISPRAVLJENO:** `.tiles--wide` → 1 kolona ispod 560px (početna zadržava 2 kolone, kratki opisi). |
| 3 | srednje | footer / CTA traka / navy pozadine | `logo-znak-providni.png` 258 KB (440px PNG) učitava se na svakoj stranici; `logo-znak-krem.png` 172 KB | **ISPRAVLJENO:** WebP verzije (69 KB / 47 KB), reference u `footer.html`, `cta-band.html`, CSS. Inicijalna težina početne 427 → **~235 KB**. |
| 4 | srednje | Apache `.htaccess` | Nije bilo `ErrorDocument 404` — nepostojeće putanje ne bi prikazale brendiranu 404 | **ISPRAVLJENO:** `ErrorDocument 404 /404.html` u `src/static/.htaccess`. |
| 5 | srednje | `build.py --lint` / `check.py` | PHP u runtime-u pravi prazan `site/data/index.html` → lint puca ("broj H1 != 1") čim se sajt jednom pokrene lokalno | **ISPRAVLJENO:** lint i check preskaču `data/`. |
| 6 | sitno | `/zakazivanje/` poruka uspeha | Broj zahteva "#1", a u mejlu "#0001" | **ISPRAVLJENO** (`booking.js`, padding na 4 cifre). |
| 7 | sitno | admin, otvoreno "Potvrdi" | "Potvrdi×" — razmak u `content` se gubi | **ISPRAVLJENO** (`margin-left` na `::after`). |
| 8 | sitno | `lib/admin.php` | Inline `style=""` na stranici greške/preusmerenja blokira sopstveni CSP (konzolna greška, nestilizovano) | **ISPRAVLJENO:** stranica greške koristi `admin.css`, inline stilovi uklonjeni. |
| 9 | sitno | mejl odbijanja | "rado ćemo pronaći" — ostali mejlovi su u 1. licu jednine | **ISPRAVLJENO** → "rado ću". |
| 10 | sitno | footer (svi), 390px | "Novi / Sad" se lomi u dva reda | **ISPRAVLJENO** (`&nbsp;`). |
| 11 | sitno | blog članci | Ispod članka dva uzastopna bloka "Zakažite konsultaciju" (aside-cta + CTA traka) | Developer: na člancima zadržati jedan. |
| 12 | sitno | blog breadcrumb 390px | Dug naslov članka prelama "/ Koliko jajnih…" u drugi red | Developer: skratiti poslednji element (ellipsis) na mobilnom. |
| 13 | sitno | početna, Journal | Kartica "Prva konsultacija — šta poneti" koristi IG sliku sa tekstom "IVF nije pokušaj…" (ne odgovara naslovu) | Zameniti kad stigne odgovarajući vizual. |
| 14 | sitno | `assets/js/carousel.js` | Fajl se ne koristi ni na jednoj stranici (mrtav kod) | Developer: obrisati ili iskoristiti. |
| 15 | info | `/zakazivanje/`, admin | `input type=date/time` prikazuje format uređaja (u testu en-US "mm/dd/yyyy") — na srpskom telefonu je dd.mm.gggg | Bez izmene. |
| 16 | info | demo URL | `SITE_URL` je workers.dev (statički) — PHP zakazivanje tamo ne radi | Objava mora biti na PHP hostingu (vidi dole). |

### Šta je provereno i radi

- **Frontend:** 18 stranica × 3 širine — bez horizontalnog skrola (`scrollWidth ≤ innerWidth` svuda), bez JS grešaka, bez mrtvih slika/404 resursa. Redosled i kompozicija prate referencu (hero sa fotografijom koja se pretapa u krem → Moj pristup → Kada se javiti → Oblasti rada → 5 koraka → O meni → navy traka → Nauka i edukacija → Journal → CTA → navy footer). Mobilni meni (otvaranje, akordeon "Oblasti rada", Esc), desktop mega dropdown (Esc), scroll-snap kartice (x mandatory + tačke), FAQ akordeoni (`aria-expanded`), lightbox (strelice, Esc, brojač 3/5), mapa tek na klik (iframe se ubacuje), sticky bar (pojavljuje se posle hero-a, skriva se na CTA traci).
- **Zakazivanje (390px, `?usluga=ivf`):** usluga predizabrana; prazno slanje → 5 jasnih poruka + fokus na sažetak grešaka; loš mejl → "E-mail adresa nije ispravna…"; uspešno slanje → "Hvala, zahtev je primljen" sa mejlom; zapis u SQLite (`status=novo`, telefon normalizovan `+381…`, IP heširan); **2 mejla** (pacijent "Primili smo Vaš zahtev za konsultaciju #0001", doktor "Novi zahtev #0001 — …" sa Reply-To pacijenta). SMTP sa AUTH LOGIN radi.
- **Admin:** `/admin/setup.php` postavlja lozinku i prijavljuje, posle se gasi ("Lozinka je već postavljena"); pogrešna lozinka → poruka + log; tabovi Novi/Potvrđeni/Odbijeni sa brojačima; **Potvrdi** (datum/vreme predpopunjeni, poruka) → flash "Termin je potvrđen… Mejl je poslat pacijentu" + mejl potvrde; **Odbij** sa razlogom → flash + mejl odbijanja; Odjava. Velika dugmad, bez horizontalnog skrola na 390.
- **Mejlovi:** navy zaglavlje sa FK monogramom, zlatna linija, EB Garamond naslovi, kartica termina, "Šta poneti", potpis — u brendu; č/ć/š/ž/đ ispravni u temi, imenu i telu; plain-text verzija postoji.
- **Sadržaj:** Ferona se u vidljivom tekstu pojavljuje samo kao mesto ordiniranja ("Ordinira u SB Ferona…", adresa, mapa, "konsultacije i postupci obavljaju se u SB Ferona"); Ferona telefon (`ferona_tel` u site.json) se ne renderuje nigde; schema koristi `workLocation`, ne `worksFor`. `[POTVRDITI]` markeri samo u HTML komentarima. Nema cena, recenzija, procenata uspeha ni garancija; lični detalji ("suprug, otac, gitara") potkrepljeni u research.md.
- **SEO:** po jedan H1, title/description/canonical/OG svuda, validan JSON-LD, sitemap 17 URL-ova, `robots.txt` (demo: Disallow; uvek `/admin/`, `/api/`), `lang="sr-Latn-RS"`.
- **Performanse:** početna ~235 KB inicijalno (HTML + CSS + fontovi + hero WebP 30–36 KB + JS 11 KB); sve `<img>` imaju `width/height`, sve ispod pregiba `loading="lazy"` (check.py).

## Ocena autentičnosti: **8.5 / 10**

Izgleda kao lični brend ovog lekara, ne kao šablon: prave fotografije dr Katanića u svakoj ključnoj sekciji, njegov logo (ruke + beba + FK) i monogram, njegove IG edukativne kartice i konferencijske fotografije, njegov citat i ton ("Ne postoji univerzalni IVF protokol"). Kompozicija verno prati referencu. Minus: tamne IG grafike u Journal karticama odstupaju od svetle palete; nema fotografija prostora.

## Verdikt: **SPREMNO** (za predaju/demo klijentu)

Sve kritične i srednje greške su ispravljene u `src/` i potvrđene ponovnim screenshotom; preostale su sitnice za Developera (#11–#14). Objava na pravom domenu tek kad klijent dostavi stavke ispod (1–4 su obavezne).

## Šta klijent mora da dostavi / podesi

1. **PHP hosting** (PHP 8.1+, PDO SQLite, Apache/LiteSpeed zbog `.htaccess`) i **domen** → u `build.py` `SITE_URL` + `DEMO = False`, pa `python3 build.py --lint`.
2. **SMTP nalog** za `zakazivanje@domen` (host, port 465/ssl ili 587/tls, korisnik, lozinka) + SPF/DKIM na domenu → `config.php` (iz `config.sample.php`): `from_email`, `reply_to` (adresa koju doktor čita), `doctor_email`.
3. **Admin lozinka:** posle upload-a odmah otvoriti `/admin/setup.php` (min. 12 znakova); folder `data/` upisiv za PHP.
4. **Pismena potvrda titule** (specijalista ginekologije i akušerstva, master reproduktivni embriolog) i doktorskih studija (MF Novi Sad).
5. Opciono lični telefon/mejl za prikaz → `src/data/site.json` (`tel`, `tel_href`, `email`).
6. Tačni linkovi: Mondo.rs članak, Selfnest epizoda, "Popodne sa Tanjom"; potvrda SPRING Fertility; saglasnost za referisanje slučaja iz Mondo.rs intervjua.
7. Da li se koristi analitika (za politiku privatnosti).
8. Opciono: vektorski (SVG) logo, fotografije ordinacije/prostora, tačan Google Maps link za SB Ferona.

Finalni screenshotovi: `_preview/v2/` (pocetna-1440, pocetna-390 + deo1/deo2, zakazivanje-390, admin-390, admin-1440, mejl-potvrda).
