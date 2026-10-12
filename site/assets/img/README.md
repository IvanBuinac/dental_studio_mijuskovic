# Slike sajta (`site/assets/img/`)

**Stanje 12. 10. 2026. (ispravka placeholdera):** sajt više nema nijedan placeholder. Svaki `<img>` pokazuje na fajl koji postoji (provereno skriptom nad svim `.html` fajlovima). Natpisi sa imenom fajla (`.ph__label`, `data-ph`) uklonjeni su iz HTML-a i CSS-a. Okvir `.ph` ostaje samo kao omotač sa fiksnim odnosom stranica i `object-fit: cover`. Ako se slika ne učita, JS sakriva slomljenu ikonu i ostaje neutralna svetla podloga, bez teksta.

- Format: WebP, kvalitet 80–86 (og-cover i kao `.jpg`). Ilustracije su SVG (vektorske, oko 3 KB, oštre na svakoj veličini).
- Pre/posle se uvek isporučuje kao par `-pre` / `-posle` istog kadra, odnosa i veličine (3:2).
- `width`/`height` u HTML-u odgovaraju stvarnim dimenzijama fajlova.
- **Novi slučaj pre/posle** se dodaje kao `<li class="case" data-cat="…">` na `/rezultati/`. Ako je kategorija nova (npr. implanti), u filter se dodaje i dugme, pa i sekcija „Pre i posle“ na stranici usluge.
- **Nova fotografija prostora:** zameniti `ordinacija-prijem.webp` istim imenom, ili dodati nove fajlove i ubaciti ih u galerije (`.gallery--stack` na početnoj, `.gallery--row` na `/o-nama/`).

## Fajlovi i gde se koriste

| Fajl | Stranica | Dimenzije | Šta prikazuje |
|---|---|---|---|
| `logo.webp` (+ `logo.png` kao rezerva) | sve (header, footer) | 168×96 | Logo „Dental Studio Mijušković“ |
| `og-cover.jpg` (+ `.webp`) | og:image / twitter:image; JSON-LD `image` na `/usluge/implanti/` | 1200×630 | Logo na #0B3B46 + doktor |
| `hero.webp` | `/` hero; `/o-nama/` galerija ordinacije | 1200×1500 | Dr Mijušković sa lupama pri radu |
| `doctor-portrait.webp` | `/` Specijalista; `/o-nama/` hero | 900×1125 | Doktor u mantilu pri radu |
| `doctor-konsultacija.webp` | `/o-nama/` Kako radimo | 1440×810 | Doktor pokazuje rendgenski snimak |
| `tim.webp` | `/o-nama/` Tim; `/` galerija ordinacije | 900×600 | Doktor sa asistentkinjom |
| `detalj-preciznost.webp` | `/o-nama/` Preciznost; `/usluge/implanti/` Zašto kod nas; `/` galerija ordinacije | 900×1125 | Rad sa lupama, keramički rad na modelu |
| **`ordinacija-prijem.webp`** *(novo)* | `/` galerija (glavna, visoka); `/o-nama/` galerija (glavna); `/kontakt/` hero | 387×516 (3:4) | Hodnik i čekaonica sa logom na zidu, fotelje, recepcija |
| `usluga-lumineeri.webp` | `/`, `/usluge/`, `/usluge/lumineeri/` hero | 956×717 | Osmeh sa lumineerima |
| `usluga-protetika.webp` | `/`, `/usluge/`, `/usluge/protetika/` hero | 1600×1200 | Bezmetalne krunice, makro |
| **`usluga-implanti.svg`** *(ilustracija)* | `/`, `/usluge/`, `/usluge/implanti/` hero | viewBox 1600×1200 (4:3, centar bezbedan za 3:4 isečak) | Linijska ilustracija implanta, abatmenta i krunice |
| `usluga-izbeljivanje.webp` | `/`, `/usluge/`, `/usluge/izbeljivanje/` hero; `/o-nama/` galerija ordinacije | 1265×949 | Lampa za ordinacijsko izbeljivanje |
| **`detalj-fasete.svg`** *(ilustracija)* | `/usluge/lumineeri/` Uvod | viewBox 1200×1500 (4:5) | Prednji zubi i tanka faseta pre postavljanja |
| **`detalj-boja.svg`** *(ilustracija)* | `/usluge/protetika/` Zašto specijalista; `/usluge/izbeljivanje/` Uvod | viewBox 1200×1500 (4:5) | Ključ boja (A1–C1), odabrana nijansa |
| `ba-lumineeri-01…05-pre/-posle.webp` | `/` (01), `/usluge/lumineeri/` (01, 02), `/rezultati/` (01–05) | ~800×534 | Pre/posle lumineera |
| `ba-protetika-01…02-pre/-posle.webp` | `/` (01), `/usluge/protetika/` (01, 02), `/rezultati/` (01–02) | ~800×534 | Pre/posle krunica |

## Uklonjeno iz Mape slika (nema i neće biti fotografija)

| Bivše mesto | Zamena |
|---|---|
| `ordinacija-stolica`, `ordinacija-prostor`, `ordinacija-sterilizacija` | Galerije su smanjene na 3 kadra: `ordinacija-prijem` + postojeći radni kadrovi |
| `ba-implanti-01/02` | Uklonjeni sa `/rezultati/` (i tab „Implanti“ u filteru). Na `/usluge/implanti/` sekcija „Pre i posle“ je zamenjena sekcijom „Konsultacija: prvi korak“ sa CTA |
| `ba-izbeljivanje-01` | Uklonjen sa `/rezultati/` (i tab „Izbeljivanje“). Sekcija „Pre i posle“ na `/usluge/izbeljivanje/` je uklonjena |
| `ba-lumineeri-06`, `ba-protetika-03/04` | Slučajevi uklonjeni sa `/rezultati/` (sada 7 slučajeva: 5 lumineera, 2 protetike) |
