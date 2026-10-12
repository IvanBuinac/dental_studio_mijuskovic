# Dental Studio Mijušković — sajt (demo)

Statičan sajt: čist HTML + CSS + malo vanilla JS-a. Nema framework-a, build koraka, baze ni backend-a. Radi na bilo kom statičnom hostingu (Netlify, Cloudflare Pages, GitHub Pages, Vercel, običan FTP).

## Struktura

```
index.html                     Početna
o-nama/index.html              Dr Žarko Mijušković, tim, ordinacija
usluge/index.html              Pregled usluga
usluge/lumineeri/index.html    Lumineeri i keramičke fasete
usluge/protetika/index.html    Cirkonijum krunice i mostovi
usluge/implanti/index.html     Zubni implanti
usluge/izbeljivanje/index.html Izbeljivanje zuba
rezultati/index.html           Pre/posle galerija sa filterom (#lumineeri, #protetika, #implanti, #izbeljivanje)
kontakt/index.html             Telefoni, Viber, WhatsApp, Instagram, dolazak iz drugih gradova
404.html                       Samostalna stranica greške (inline stil)
css/style.css                  Ceo stil (boje iz brand.md kao CSS varijable)
js/main.js                     Meni, dropdown, pre/posle klizač, filter, placeholderi slika, animacije
assets/img/                    Slike (vidi assets/img/README.md)
favicon.svg                    Monogram „M“ (petrolej + mint tačka)
sitemap.xml, robots.txt
```

Sve putanje su **relativne**, pa sajt radi i na koren-domenu i na podputanji (npr. `user.github.io/repo/`). Jedini izuzetak je `404.html`, čiji linkovi vode na `/` (vidi komentar u fajlu).

## Lokalni pregled

```
cd site
python3 -m http.server 8080
# otvoriti http://localhost:8080/
```

## Objava (pre-flight lista)

1. **Domen:** u svim HTML fajlovima, `sitemap.xml` i `robots.txt` zameniti `https://dentalstudiomijuskovic.example` pravim domenom (canonical, og:url, og:image, JSON-LD). Jedna pretraga-i-zamena.
2. **Indeksiranje (demo je noindex):**
   - u svakom HTML-u obrisati `<meta name="robots" content="noindex, nofollow">`;
   - u `robots.txt` zameniti `Disallow: /` sa `Allow: /` i otkomentarisati `Sitemap:` liniju;
   - u footeru obrisati „Demo verzija sajta“.
3. **Slike:** dodati fajlove koji nedostaju u `assets/img/` tačno pod imenima iz `assets/img/README.md`. HTML se ne menja. Slučajeve na `/rezultati/` za koje nema fotografija ukloniti (`<li class="case">`).
4. Rešiti sve stavke `[POTVRDITI SA KLIJENTOM]` (pretraga po tom tekstu; sve su HTML komentari).
5. Postaviti ceo sadržaj foldera `site/` na hosting.

## Šta treba potvrditi sa klijentom

Sve je u kodu označeno komentarom `<!-- [POTVRDITI SA KLIJENTOM: …] -->`. Na sajtu su ta mesta neutralna („Adresa uskoro“, „Radno vreme uskoro“) ili izostavljena.

| # | Stavka | Gde |
|---|---|---|
| 1 | Adresa (ulica i broj); posle potvrde dodati Google mapu (iframe, učitavanje na klik) i `streetAddress` u JSON-LD `Dentist` | /kontakt/, footer, FAQ na početnoj |
| 2 | Radno vreme (posle potvrde i `openingHours` u JSON-LD) | /kontakt/, footer |
| 3 | Email (ako postoji, dodati karticu sa `mailto:`) | /kontakt/ |
| 4 | Obrazovanje, specijalizacija, godina osnivanja, usavršavanja | /o-nama/ |
| 5 | Funkcija u Stomatološkoj komori CG (naziv, period, da li se navodi) | /, /o-nama/ |
| 6 | Tim: imena i uloge; ko radi koje zahvate | /o-nama/, FAQ početna |
| 7 | Sopstvena laboratorija / CAD/CAM ili saradnja; materijali (E.max…) | /, /o-nama/, lumineeri, protetika |
| 8 | Ko ugrađuje implante; implantni sistemi | /usluge/implanti/ |
| 9 | All-on-4 / All-on-6 (fiksni radovi za bezubu vilicu) — ako se ne rade, ukloniti karticu | /usluge/implanti/ |
| 10 | Ortodoncija — da li se radi (kartica je trenutno izostavljena) | /usluge/ |
| 11 | Pisana saglasnost pacijenata za pre/posle fotografije + jedna rečenica opisa po slučaju | /, usluge, /rezultati/ |
| 12 | Meta opis za Izbeljivanje (koristi se oprezniji predlog iz copy.md) i title/meta za /usluge/ (predlog copywritera) | `<head>` |
| 13 | Domen | svi fajlovi |

## Tehničke napomene

- **Potpisni element „Ključ boja“:** pločice za usluge (`.shade-tab`), mini pločice za pod-navigaciju, tabove i filter (`.shade-mini`), eyebrow čip iznad naslova. Kodovi L1/P2/I3/B4 su oznake sajta, ne VITA nijanse.
- **Placeholderi slika:** svaka slika je `<figure class="ph">` sa oznakom (ime fajla + opis) ispod `<img>`. Ako fajl ne postoji, JS sakriva `<img>`; kada fajl postoji, slika prekriva oznaku. Bez CLS-a (`aspect-ratio` + `width`/`height`).
- **Pre/posle klizač:** `<input type="range">` preko slike (radi mišem, dodirom i tastaturom). Bez JS-a dve slike stoje jedna pored druge.
- **Logo:** `assets/img/logo.webp` se prikazuje kada se učita; ako ga nema, ostaje tekstualni wordmark.
- **Pristupačnost:** jedan H1 po stranici, skip-link, vidljiv mint fokus, `aria-expanded`/`aria-pressed`, `prefers-reduced-motion`. Dugmad i teal tekst koriste `#0F766E` (umesto `#0D9488`) zbog WCAG AA kontrasta belog teksta.
- **Font:** Plus Jakarta Sans (Google Fonts, `display=swap`), jedna familija.
- **Kontakt forma:** namerno je nema (nema backend-a; klijent radi preko telefona, Vibera i Instagrama). Ako se doda, ide preko `mailto:` ili servisa kao Formspree.
