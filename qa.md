# QA: Dental Studio Mijušković (@dental_studio_mijuskovic)

**Datum:** 12. oktobar 2026. · **Recenzent:** qa-reviewer
**Metod:** lokalni server (`python3 -m http.server 8080` u `site/`), Playwright + Chromium. Za 9 stranica i 404: full-page screenshot na 375, 768 i 1440px. Pregledani su svi snimci. Merene su `scrollWidth`, console greške, neuspeli requestovi i WCAG kontrast (skripta nad svim tekstualnim elementima). Klikom su provereni meni, dropdown, klizač, filter, FAQ i fokus. Statički su provereni SEO, JSON-LD, linkovi, alt tekstovi i tekst.

## Rezime merenja

- **Horizontalni scroll:** nema ga ni na jednoj stranici, ni na jednoj širini (`scrollWidth === innerWidth`).
- **Console / mreža:** nema JS grešaka. Jedini 404 su slike koje `assets/NOTES.md` i `assets/img/README.md` navode kao nedostajuće (`usluga-implanti`, `detalj-fasete`, `detalj-boja`, `ordinacija-*` ×4, `ba-lumineeri-06`, `ba-protetika-03/04`, `ba-implanti-01/02`, `ba-izbeljivanje-01`). Na njihovom mestu se uredno prikazuje placeholder sa imenom fajla i opisom. Google Fonts se učitava.
- **Linkovi:** nijedan interni link nije pokvaren, a sva `#` sidra postoje. Postoje samo dva broja, upisana dosledno: `tel:+38267440414` (63×), `tel:+38267341214` (21×), `wa.me/38267440414` (38×), `viber://chat?number=%2B382…` (38×). Svi `target="_blank"` linkovi imaju `rel="noopener"`. Linkovi na 404 stranici su apsolutni (`/`, `/usluge/`), što je namerno.
- **Interakcije:**
  - Mobilni meni se otvara i zatvara; Esc i klik na link ga zatvaraju; skrol tela je zaključan.
  - Dropdown „Usluge“ radi na klik, tastaturom i na Esc.
  - Klizač pre/posle radi mišem, tapom i tastaturom (strelice, Home, End).
  - Filter na `/rezultati/`: Sve 13, Lumineeri 6, Protetika 4, Implanti 2, Izbeljivanje 1. Hash se upisuje u URL, a `/rezultati/#implanti` se otvara sa već primenjenim filterom.
  - Tabovi na početnoj, FAQ `<details>` i skip-link rade. Fokus je mint i dobro se vidi.
- **SEO:**
  - Svaka stranica ima jedan H1 i hijerarhiju bez preskakanja. Title ima ≤ 65 znakova, a description ≤ 135.
  - Canonical, og:url, og:image (1200×630) i twitter card postoje svuda; `lang="sr-Latn-ME"`.
  - JSON-LD je validan na svim stranicama: `Dentist`, `Person`, `MedicalProcedure`, `ContactPage`, `BreadcrumbList`. U njemu nema izmišljene adrese, ocena ni radnog vremena.
  - `sitemap.xml` ima 9 URL-ova. `robots.txt` i meta `noindex` su namerno uključeni za demo.
- **Slike:** sve `<img>` imaju alt i width/height. Ispod pregiba se koristi `loading="lazy"`.
- **Performanse:** slike po stranici iznose oko 240–360 KB (WebP), HTML oko 23–39 KB, CSS 42 KB, JS 7,5 KB. Nema biblioteka.

## Ispravke i nalazi

| # | ozbiljnost | gde | problem | predlog / status |
|---|---|---|---|---|
| 1 | kritično | header i footer, sve stranice | `.brand__word { display: inline-grid }` je pregazio atribut `hidden`. Kada se `logo.webp` učita, JS sakriva tekstualni wordmark, ali je on i dalje bio vidljiv. Zato je u headeru dvaput pisalo „DENTAL STUDIO Mijušković“ (logo pa tekst pored njega). | **ISPRAVLJENO:** u `css/style.css` dodato je globalno `[hidden] { display: none !important; }`. Sada se prikazuje samo logo, kako i README predviđa. |
| 2 | kritično | `/rezultati/`, uvodni pasus | Tvrdnja „Fotografije su objavljene uz saglasnost pacijenata.“ je stajala na sajtu kao činjenica, iako je saglasnost još `[POTVRDITI SA KLIJENTOM]` (NOTES.md: „treba dobiti pisanu potvrdu“). | **ISPRAVLJENO:** rečenica je uklonjena iz vidljivog teksta. Ostala je u HTML komentaru i vraća se kada klijent potvrdi. |
| 3 | srednje | početna, pre/posle blok, ≤ 899px | Flex kolona je nasledila `align-items: center` od `.split`, pa se klizač skupio na oko 225px (375) i oko 190px (768) i bio je nečitljiv. | **ISPRAVLJENO:** `.ba-home { align-items: stretch; }` u mobilnom media query-ju. Klizač je sada pune širine. |
| 4 | srednje | početna, „Pacijenti van Nikšića“, ≥ 600px | Kartice su grid sa jednom kolonom, a redovi su se razvlačili po visini. Zbog toga je naslov i tekst „plutao“ na različitim visinama u tri kartice. | **ISPRAVLJENO:** `.places li { align-content: start; }`. |
| 5 | srednje | brojevi koraka (`.steps__num`) na lumineeri, protetika, implanti, izbeljivanje i kontakt | Mint `#2DD4BF` na beloj ili sivoj podlozi daje kontrast 1,8:1, a za veliki tekst treba 3:1. | **ISPRAVLJENO:** boja je promenjena u brand teal `#0D9488` (oko 3,6:1). Ostali tekst prolazi AA (skener nije našao drugih padova). |
| 6 | srednje | logo u headeru (52px visine) | Logo postoji samo kao mali raster (168×96). Na 52px tekst „MIJUŠKOVIĆ“ ima oko 6px i jedva se čita. Veći prikaz bi bio mutan. | Tražiti SVG ili PNG logo velike rezolucije (vidi NOTES.md), pa podići visinu na oko 60px. Developer. |
| 7 | srednje | `/usluge/implanti/`, `/usluge/izbeljivanje/`, `/rezultati/` (6 slučajeva), početna (galerija ordinacije), `/o-nama/` (4 slike ordinacije), `/kontakt/` hero | U demu je placeholder uredan. Pre objave, međutim, sekcija „Pre i posle“ na implantima sa dva prazna okvira i dugmetom „Želite ovakav rezultat?“ izgleda nedovršeno, a isto važi i za slučajeve bez slika na `/rezultati/`. | Pre objave ukloniti `<li class="case">` i blokove bez fotografija (README, korak 3). Prioritet su 3–4 fotografije enterijera. |
| 8 | srednje | `/usluge/`, kartice „Kompletna nega“ | „Oralna hirurgija (komplikovanije ekstrakcije, umnjaci)“ i „Dečija stomatologija“ potiču iz research.md, a nisu potvrđeni kod klijenta. Ortodoncija je već izostavljena iz istog razloga. | Potvrditi sa klijentom zajedno sa stavkom 10 iz README-a. |
| 9 | sitno | `/rezultati/`, mobilni | Sticky filter zauzima oko 154px visine (oko 19% ekrana na 812px), pa uz donju action bar traku ostaje malo prostora za slike. | Na < 600px sakriti oznaku „Filter · ključ boja“ ili filter učiniti ne-sticky. |
| 10 | sitno | početna i `/o-nama/`, 600–899px | Portret doktora (4:5) ide celom širinom kolone i na tabletu je visok oko 900px. | Ograničiti `max-width` slike u jednoj koloni na tabletu (oko 480px). |
| 11 | sitno | početna i `/o-nama/` | Isti kadar (`doctor-portrait.webp`) je i hero na `/o-nama/` i u sekciji „Specijalista“ na početnoj. | Kada stigne pravi portret, na jedno mesto staviti `detalj-preciznost` ili novi kadar. |
| 12 | sitno | Viber linkovi | `viber://` ne radi na desktopu bez instaliranog Vibera. Klik tada ne radi ništa. | Prihvatljivo, jer je poziv primaran. Opciono dodati `title` sa brojem. |
| 13 | sitno | tekst | Pravopis i doslednost su u redu: „lumineeri“, „Mijušković“, „Nikšić“, oba broja i Instagram handle su svuda isti. Persiranje („Vi“, „Vaš“) je dosledno. Nema vidljivih `[POTVRDITI]` markera, jer su svi u HTML komentarima (ukupno 67). | Pre objave rešiti sve komentare (README, korak 4). |

## Autentičnost: 7/10

**Za:** sajt ne izgleda kao generički dental template.
- Ima sopstveni potpisni element „ključ boja“: pločice L1/P2/I3/B4 kao tabovi, filter i eyebrow čipovi.
- Petrolejsko-mint paleta prati brand.md.
- Fotografije su prave, iz ordinacije (doktor sa lupama, rendgen, lampa za izbeljivanje).
- Ima stvarne pre/posle slučajeve sa klizačem.
- Ton je odmeren i specijalistički („Cilj nije najbelji osmeh“). Nema izmišljenih ocena ni procenata.
- Blok za pacijente iz Podgorice, sa primorja i iz dijaspore je specifičan za ovog klijenta.

**Protiv:** nedostaju fotografije enterijera i portret, pa velike površine stoje kao placeholderi (početna, o-nama, kontakt, implanti). Nema adrese, mape ni radnog vremena. Struktura sekcija (hero, uvod, „za koga je“, postupak, FAQ, CTA) je standardna za ovu vrstu sajta. Kada stignu fotografije prostora i portret, realna ocena je 8–8,5.

## Verdikt

**POTREBNE ISPRAVKE**: kao demo za prezentaciju klijentu sajt je **spreman**. Tehnički je čist: nema grešaka, nema horizontalnog skrola, interakcije rade, SEO i JSON-LD su ispravni, a kritične stavke 1–5 su ispravljene. Za **javnu objavu** ostaju:
1. podaci od klijenta: adresa, radno vreme, saglasnost pacijenata, potvrda usluga (#8);
2. fotografije enterijera i logo u visokoj rezoluciji (#6, #7);
3. uklanjanje slučajeva i sekcija bez fotografija (#7);
4. koraci iz pre-flight liste u `site/README.md` (domen, noindex, robots).

Posle ispravki ponovo su snimljene sve stranice na sve tri širine. Pogođene sekcije su vizuelno proverene, i nema novih 404, console grešaka ni horizontalnog skrola.
Reprezentativni snimci: `qa-screens/pocetna-1440.png`, `qa-screens/pocetna-375.png`, `qa-screens/usluga-lumineeri-1440.png`. Snimci su full-page; header i donja traka su za snimanje postavljeni kao statični, da se ne bi ponavljali usred stranice.


## Ispravke 2026-10-12 — placeholderi

**Povod:** klijent je poslao jednu fotografiju prostora (`assets/raw/images.jpg`, čekaonica) i potvrdio da fotografija implanata nema i neće ih biti. Cilj: nijedan vidljiv placeholder, a struktura sajta ostaje ista.

| # | gde | izmena |
|---|---|---|
| P1 | `assets/build_images.py`, `site/assets/img/` | `images.jpg` → `ordinacija-prijem.webp` (387×516, 3:4, bez uvećanja, blago izoštreno, q86). |
| P2 | `/` „Zašto Dental Studio Mijušković“, galerija | 4 polja (2 nepostojeće fotografije enterijera + fasete + boja) → 3: `ordinacija-prijem` (visoka, preko dva reda) + `tim` + `detalj-preciznost`. Novi `.gallery--stack`; na mobilnom velika slika 4:5 + dva kvadrata. |
| P3 | `/o-nama/` galerija „Ordinacija“ | 4 placeholdera (2×2 / horizontalni skrol) → 3 slike u redu (`.gallery--row` 3fr/4.5fr/4.5fr): `ordinacija-prijem`, `usluga-izbeljivanje`, `hero`. Ništa se ne ponavlja u sekciji (`tim` je već u istoj sekciji, pa nije korišćen). |
| P4 | `/kontakt/` hero | `ordinacija-prijem` u okviru 3:4, `max-width: 400px` (izvor je mali, pa nije razvučen preko pola ekrana). |
| P5 | implanti (`/`, `/usluge/`, `/usluge/implanti/`) | `usluga-implanti.svg`: linijska ilustracija implanta u brend paleti. JSON-LD `image` → `og-cover.jpg`. Na mobilnom je bedž „I3 · Implanti“ pomeren ispod ilustracije, da je ne prekriva. |
| P6 | `/usluge/lumineeri/`, `/usluge/protetika/`, `/usluge/izbeljivanje/` | `detalj-fasete.svg` i `detalj-boja.svg`, ilustracije u istom stilu (ključ boja se uklapa u potpisni element sajta). |
| P7 | `/usluge/implanti/` „Pre i posle“ | Zamenjeno sekcijom „Konsultacija: prvi korak“ (lead, CTA „Zakažite konsultaciju“, kartica „Šta dobijate na konsultaciji“, link na radove iz protetike, napomena o individualnom planu). Link u završnom CTA `rezultati/#implanti` → `rezultati/`. |
| P8 | `/usluge/izbeljivanje/` „Pre i posle“ | Sekcija uklonjena; smenjivanje pozadina sekcija ostaje pravilno. Link `rezultati/#izbeljivanje` → `rezultati/`. |
| P9 | `/rezultati/` | Uklonjeni slučajevi `lumineeri-06`, `protetika-03/04`, `implanti-01/02`, `izbeljivanje-01` i tabovi „Implanti“ i „Izbeljivanje“. Filter: Sve 7, Lumineeri i fasete 5, Krunice i mostovi 2. „Ključ boja“ ostaje. |
| P10 | sve stranice, CSS, JS | Uklonjeni `.ph__label` natpisi sa imenom fajla i `data-ph` atributi (ranije su bili u DOM-u i ispod učitanih slika), CSS za njih i šrafura okvira. |

**Provera (posle izmena):**
- Statička skripta nad svim `.html` u `site/`: proverila je 429 lokalnih `src`/`srcset`/`href`. Svi fajlovi postoje, nijedan `.ph__label`/`data-ph` nije ostao, svaki `rezultati/#…` hash ima tab, svaki tab ima slučajeve, svih 9 URL-ova iz `sitemap.xml` postoji, `url()` u CSS-u su ispravni. U HTML-u (ni u JSON-LD-u) se ne pominje nijedan nepostojeći fajl iz `assets/img/`.
- Playwright (Chromium), 9 stranica × 1440 i 375 px: **0 console grešaka, 0 odgovora ≥ 400, 0 neuspelih zahteva, 0 slomljenih slika, bez horizontalnog skrola**. Pregledani su isečci full-page snimaka; jedina popravka posle pregleda bio je bedž na implantima (P5) i razmak liste u kartici konsultacije.
- Ažurirani snimci: `qa-screens/pocetna-1440.png`, `qa-screens/pocetna-375.png`.

**Otvoreno:** na `/kontakt/` i dalje stoje tekstualne oznake „Mapa lokacije biće dodata uskoro“ i „Radno vreme uskoro“. To nisu slike, nego čekaju podatke od klijenta (adresa, radno vreme). Stavka #7 iz tabele iznad je ovim rešena.
