# Struktura sajta — dr Nada Bojić · parodontologija i oralna medicina (Hope Dental, Beograd)

**Verzija:** 1.0 — 27.10.2026.
**Ulaz:** `NAPOMENA-TACNOST.md`, `seo.md` v2.0, `brand.md` v2 (27.10.2026.), `Assets/manifest.md`, `Assets/NOTES.md`, `research.md` (DEO A), `web-research.md`
**Izlaz za:** Copywriter (`copy.md`) i Developer
**Tehnologija:** čist statični HTML + CSS + vanilla JS. **Bez build koraka, bez backenda, bez framework-a, bez npm-a.**

---

## 0. Šta ovaj dokument sme da tvrdi

Ovaj dokument **ne uvodi nijedan novi podatak o klijentkinji.** Sve činjenične tvrdnje su iz `seo.md` v2 i `research.md` DEO A. Sve ostalo je odluka o rasporedu, i tamo gde je odluka dizajnerska označena je **[ODLUKA]**. Gde podatak ne postoji, u strukturi stoji **komponenta** `[POTVRDITI]` (§4.12) — ne izmišljena vrednost.

### 0.1 Tri nasleđena konflikta i kako su rešeni

| # | Konflikt | Rešenje u ovom dokumentu |
|---|---|---|
| 1 | `seo.md` §4: „`/rezultati/` **NE pravi se** dok ne postoji saglasnost“ ⟷ zadatak: napravi pre/posle galeriju sa 7 slučajeva | Stranica se **projektuje i kodira**, ali se **isporučuje isključena** mehanizmom iz §7.4 (jedna linija u jednom deljenom CSS fajlu). Dok je isključena: nema ulaznih linkova, `noindex`, nije u `sitemap.xml`, nije među 16 indeksabilnih. Po dostavljenim saglasnostima postaje 17. indeksabilna stranica. Nijedna pre/posle slika se ne vidi dok je prekidač u položaju `off`. |
| 2 | `brand.md` §8: „**Ne koristiti slider sa prevlačenjem** — pretvara medicinski rezultat u igračku“ ⟷ zadatak: klizač pre/posle (miš, dodir, tastatura) | Komponenta je **dvoslojna** (§4.10): osnovno stanje u HTML-u su **dve slike jednake veličine, jedna pored druge** sa čipovima `PRE`/`POSLE` iznad — tačno kako brand nalaže, i to je stanje bez JS-a. JS je **nadogradnja** koja isto te dve slike spaja u klizač bez animacije, bez „bounce“ efekta, bez automatskog kretanja, sa ručkom u jeziku luka iz logotipa. Brand pravilo o dostojanstvu prikaza se poštuje, zahtev o klizaču se izvršava. Ako klijentkinja odbije klizač: ukida se `.ba--slider` klasa i ostaje brand-varijanta — bez ikakve izmene HTML-a. |
| 3 | `brand.md` §5 daje Google Fonts `<link>` ⟷ `seo.md` §9 nalaže self-hosting | Self-hosting, `woff2`, `latin-ext` podskup. Budžet 4 fajla: `EBGaramond-Medium`, `Inter-Regular`, `Inter-Medium`, `JetBrainsMono-Medium`. **Italic EB Garamond se ne učitava** — italic za stručne termine se ne koristi, umesto njega `--muted` boja i mono labela (ušteda jednog fajla, vidi §4.14). |

---

## 1. Odluka o tipu sajta

**Višestranični sajt, 16 indeksabilnih stranica + `/politika-privatnosti/` (noindex) + 404 + isključeno `/rezultati/`.**

Preuzeto iz `seo.md` §4 bez izmene. One-page je ovde isključen: simptomski klaster (`krvarenje-desni`, `povlacenje-desni`, `upala-desni`, `klimavi-zubi`) je **jezgro SEO strategije** i svaka od tih stranica mora imati svoj `<title>`, svoj `<h1>` i 900–1400 reči. One-page bi ih sabio u jedan dokument i ubio upravo ono što je jedina realna prilika za rangiranje.

### 1.1 Sitemap (tačno po `seo.md` §4)

```
/                                        Naslovna                            [hero, 6 kartica usluga]
├── /o-meni/                             Dr Nada Bojić
├── /usluge/                             Hub usluga
│   ├── /usluge/parodontologija/         ★ glavna stranica usluge
│   ├── /usluge/parodontoloska-hirurgija/
│   ├── /usluge/oralna-medicina/
│   ├── /usluge/oralna-hirurgija/
│   ├── /usluge/protetika/
│   └── /usluge/estetska-medicina/       ⚑ NEMA NI JEDNE FOTOGRAFIJE (§6)
├── /parodontopatija/                    ★★ hub simptomskog klastera
│   ├── /parodontopatija/krvarenje-desni/
│   ├── /parodontopatija/povlacenje-desni/
│   ├── /parodontopatija/upala-desni/
│   └── /parodontopatija/klimavi-zubi/
├── /pitanja-i-odgovori/
├── /kontakt/
├── /politika-privatnosti/               noindex, nije u sitemap.xml
├── /rezultati/                          ⛔ ISKLJUČENA (§7.4) — ne računa se u 16
└── /404.html                            noindex
```

**Dubina:** nijedna indeksabilna stranica nije dalje od 2 klika od naslovne (`seo.md` §5.17/6). Simptomske stranice su dostupne i direktno sa naslovne (sekcija 2) i sa huba.

### 1.2 Fajl struktura (bez build koraka)

```
site/
├── index.html
├── 404.html
├── robots.txt                 # demo: Disallow: /
├── sitemap.xml                # 16 URL-ova, bez /rezultati/ i /politika-privatnosti/
├── site.webmanifest
├── favicon.svg  favicon-32.png  favicon-16.png  apple-touch-icon.png
├── o-meni/index.html
├── usluge/index.html
├── usluge/parodontologija/index.html
├── usluge/parodontoloska-hirurgija/index.html
├── usluge/oralna-medicina/index.html
├── usluge/oralna-hirurgija/index.html
├── usluge/protetika/index.html
├── usluge/estetska-medicina/index.html
├── parodontopatija/index.html
├── parodontopatija/krvarenje-desni/index.html
├── parodontopatija/povlacenje-desni/index.html
├── parodontopatija/upala-desni/index.html
├── parodontopatija/klimavi-zubi/index.html
├── pitanja-i-odgovori/index.html
├── kontakt/index.html
├── politika-privatnosti/index.html
├── rezultati/index.html        # postoji, ali je isključena prekidačem
└── assets/
    ├── css/site.css            # JEDAN deljeni CSS — ovde je prekidač galerije (§7.4)
    ├── js/nav.js               # mobilni meni + sticky CTA stanje (defer)
    ├── js/reveal.js            # fade-up, isključivo progresivna nadogradnja (defer)
    ├── js/ba.js                # pre/posle klizač + filter (defer, samo /rezultati/)
    ├── font/*.woff2            # 4 fajla
    └── img/                    # 31 WebP fajl iz Assets/manifest.md + og-image (fali, §9.3)
```

Zajednički delovi (header, footer, mobilni meni) se **dupliraju u svakom HTML fajlu** — to je cena odsustva build koraka. Developer ih drži u `_partials/` kao referencu za ručno sinhronizovanje i **nikad ne menja header u jednom fajlu bez propagacije u svih 19**. Markup headera/footera je zato namerno kratak (§4.1, §4.5).

---

## 2. Kompozicija — zašto ovaj sajt ne izgleda kao šablon

Layout je izveden iz tri stvari koje piše u `brand.md`, ne iz omiljenog grida:

1. **Paleta je zemljana, topla i bez ijednog piksela klinički plave.** Zato: `--bg #FBF8F4` kao podloga papira, sekcije se smenjuju `--bg` / `--surface-alt`, a `--primary #14503F` se koristi u **punim blokovima** (footer, jedan tamni blok po stranici) a ne u tankim akcentima. Sajt treba da izgleda kao **štampana brošura ordinacije sa krem zidovima**, ne kao SaaS landing.
2. **Tipografija je EB Garamond + Inter + mono mikro-labele.** Serifni naslovi i mono eyebrow traže **asimetriju i tekstualnu kolonu, ne centriranje svega.** Zato: naslovi sekcija su **levo poravnati sa lukom ispod**, nikad centrirani; tekstualna kolona je 68 znakova (`--container-narrow` 720 px) i ne razvlači se; kartice su u asimetričnim grupama (3+2, 2+1), ne u savršenim 3×2 mrežama gde god je moguće.
3. **Niša je parodontologija = tkivo koje drži zub.** Zato je **luk** (ne krug, ne kvadrat, ne traka) jedini dekorativni oblik i on nosi potpis sajta (§3).

**Gustina:** prozračna, ne vazdušasta (`brand.md` §7). Konkretno: `--section-y` između sekcija, ali **unutar** sekcije gusto — kartice `gap: --sp-5`, tekst `--lh-body 1.65`. Nikad puna ekran visina belog prostora.

**Čega nema nigde:** full-bleed stock fotografije, centrirani hero sa tekstom preko slike na celoj širini, tri identične kolone sa ikonicama u krugovima, karusel koji se sam vrti, brojači, „trusted by“ trake, gradijenti.

---

## 3. Potpisni element

### 3.1 Osnova — „gingivalni luk“ (iz `brand.md` §9)

Luk iz logotipa je **jedini dekorativni oblik na sajtu** i javlja se na tačno pet mesta:

| # | Upotreba | Specifikacija |
|---|---|---|
| L1 | Podvlaka ispod svakog `h2` | SVG 64×10, `stroke #C98A7E`, `stroke-width 2.5`, `linecap round`, 12 px ispod naslova, levo poravnat. `aria-hidden="true"` |
| L2 | Razdelnik sekcija | isti luk na širini `--container`, visina 24 px, `stroke var(--border)`, `stroke-width 1.5` — zamena za `<hr>` |
| L3 | Donja ivica hero slike | `border-radius: 0 0 50% 50% / 0 0 28px 28px` — blaga U-kriva, sledeća sekcija ulazi u luk |
| L4 | Ručka pre/posle klizača | vertikalna linija + kružni grip sa istim `stroke-width` i `linecap: round` |
| L5 | **Lučna skala faza** — potpis sajta, vidi 3.2 | |

### 3.2 Potpis: **„lučna skala faza“** (arc stepper)

**[ODLUKA]** Jedinstveni element ovog sajta je **horizontalni luk na kome su ucrtane četiri faze bolesti zubnog mesa**, sa označenom fazom koja odgovara stranici na kojoj se posetilac nalazi.

```
 ZDRAVO            UPALA           POVLAČENJE        KLIMAVI ZUBI
   ○─────────────────●─────────────────○─────────────────○
    ╰───────────  luk, stroke #C98A7E 2.5  ────────────╯
                      ▲ ovde ste
```

- **Geometrija:** jedan `path` u blagoj U-krivi (ista kriva kao L1, razvučena na 100 % širine), četiri tačke `r=5` na luku. Neaktivne: `fill var(--surface)`, `stroke var(--border-strong)`. Aktivna: `fill var(--accent)`, `r=7`, bez belog teksta preko nje.
- **Labela ispod svake tačke:** JetBrains Mono 500, 13 px, uppercase, `letter-spacing 0.14em`, `--muted`; aktivna `--accent-ink`.
- **Semantika:** nije SVG dekoracija nego **`<nav>` sa `<ol>` od 4 `<a>`** (linkovi na 4 simptomske stranice), vizuelno postavljenih na luk; aktivna tačka je `<span aria-current="page">`. Dakle: potpisni ukras i interna navigacija u istom elementu — tačno ono što `seo.md` §5.17/3 traži od huba.
- **Bez JS-a je u celosti funkcionalna.** Bez CSS-a je obična numerisana lista linkova.
- **Gde se ponavlja:** `/parodontopatija/` (velika, centralna), sve 4 simptomske stranice (uža varijanta, odmah pod `h1`), `/usluge/parodontologija/` (u sekciji „Znaci na koje treba obratiti pažnju“), naslovna (sekcija 2 „Kada je vreme za parodontologa“ — tu nosi 4 linka na simptomske stranice). Dakle **šest stranica**, i to tačno onih šest koje nose SEO jezgro.
- **Zašto je ovo potpis a ne ukras:** pacijent sa simptomom ne zna gde je u bolesti. Luk mu to pokaže u jednoj sekundi, bez straha, bez crvene boje, i istovremeno ga vodi na sledeću stranicu. Nijedan konkurent iz `web-research.md` nema ništa slično jer nijedan nema simptomski klaster.

### 3.3 Drugi potpis — mono mikro-labele

Svaka sekcija na svakoj stranici ima **eyebrow**: JetBrains Mono 500, `--fs-xs` (13 px), uppercase, `letter-spacing .14em`, boja `--accent-ink` (6.27:1) ili `--muted`. Ovo je, po `brand.md` §9, njen sopstveni vodeni žig doveden u red. Eyebrow je **obavezan** — nijedna sekcija bez njega. Spisak eyebrow tekstova je u §8.

---

## 4. Zajedničke komponente

### 4.1 Header (sticky)

```
┌──────────────────────────────────────────────────────────────────────────┐
│ [⌾] dr Nada Bojić            Parodontopatija  Usluge ▾  O meni  Pitanja │
│     PARODONTOLOGIJA I ORALNA MEDICINA              [ Zakažite pregled ] │
└──────────────────────────────────────────────────────────────────────────┘
```

- `position: sticky; top: 0; z-index: 50`, pozadina `--surface`, visina **72 px** desktop / **60 px** mobilni.
- Do skrola: bez ivice. Posle 8 px skrola: `border-bottom: 1px solid var(--border)` + `--shadow-xs`. Klasu `.is-scrolled` dodaje `nav.js`; **bez JS-a header ostaje sticky i funkcionalan**, samo nema ivicu.
- **Logo:** inline SVG znak iz `brand.md` §6 (zub `#14503F` + luk `#C98A7E`), 40 px, + wordmark „dr Nada Bojić“ (EB Garamond 500, 22 px, `--text`) i podnaslov „PARODONTOLOGIJA I ORALNA MEDICINA“ (JetBrains Mono 500, 10 px, `ls .16em`, `--muted`). Podnaslov `display:none` ispod 400 px širine (brand §6). Ispod 480 px: samo znak + „dr Nada Bojić“.
- Logo je `<a href="/">` sa `aria-label="dr Nada Bojić — naslovna"`. Na naslovnoj je `<span>`, ne link.
- **Nav (desktop ≥900 px):** `Parodontopatija` · `Usluge ▾` · `O meni` · `Pitanja` · CTA dugme. „Kontakt“ **nije** u glavnoj navigaciji kao tekstualni link — CTA dugme vodi na `/kontakt/` i tako nosi klik (jedan cilj, ne dva).
- `Usluge ▾` je **`<details>`/`<summary>` disclosure**, ne hover-dropdown: otvara se klikom i tastaturom, radi bez JS-a, ne beži ispod kursora. Panel: 6 linkova u dve kolone, `--surface`, `--r-lg`, `--shadow-md`. Zatvara se na `Esc` i na klik van (to dodaje `nav.js`, uz `summary` fallback).
- **Aktivna stranica:** `aria-current="page"`, boja `--primary`, luk 24×6 ispod linka (mini L1).
- Tranzicija samo na `box-shadow` i `border-color`, `var(--dur) var(--ease)`. Header se **ne skriva** pri skrolu nadole (publika 30–55; skrivanje headera je izvor frustracije).

### 4.2 Mobilni meni (<900 px)

- Trigger: `<button aria-expanded aria-controls="mmenu">` sa inline SVG od tri linije (`stroke 1.75`, `linecap round` — isti jezik kao ikone), 44×44 px tap cilj.
- Panel: **puna širina, od vrha headera do dna, `--surface`, pozicioniran `fixed`,** translira sa `transform: translateY(-8px)` + `opacity` u 220 ms. Ne „hamburger drawer“ sa strane — ovde je lista kratka i puni panel je mirniji.
- Sadržaj panela (redom):
  ```
  ┌─────────────────────────────┐
  │ NAVIGACIJA        (mono)    │
  │ Parodontopatija  →          │
  │   · Krvarenje desni         │   ← klaster otvoren, ne sakriven: to je SEO jezgro
  │   · Povlačenje desni        │
  │   · Upala desni             │
  │   · Klimavi zubi            │
  │ Usluge           →          │
  │   · 6 linkova               │
  │ O meni                      │
  │ Pitanja i odgovori          │
  │ Kontakt                     │
  │ ───── luk L2 ─────          │
  │ [ Pišite na Instagramu  ]   │  ← primarno dugme, puna širina
  │ Telefon: [POTVRDITI]        │  ← komponenta §4.12, ne mrtav link
  └─────────────────────────────┘
  ```
- Dok je otvoren: `overflow: hidden` na `<body>`, fokus zatvoren u panelu (`nav.js`), `Esc` zatvara, fokus se vraća na trigger.
- **Bez JS-a:** `nav.js` nije učitan → panel je realizovan `<details id="mmenu">` oko `summary` trigger-a, pa se otvara nativno. JS samo preuzima `aria-expanded`, zamku fokusa i `Esc`. **Nikad nav sakriven bez JS-a.**

### 4.3 Sticky CTA na telefonu (<900 px)

```
┌─────────────────────────────────────────────┐
│ [ ✉ Pišite na Instagramu ]  [ ☎ Telefon ]  │   56 px, position: sticky; bottom: 0
└─────────────────────────────────────────────┘
```
- Pojavljuje se posle prvog ekrana (`nav.js` dodaje `.is-visible` kad hero izađe iz viewport-a). **Bez JS-a je trajno vidljiv** — što je prihvatljivo stanje, ne pokvareno.
- Levo (70 % širine): **primarno dugme** `--primary` / belo, `Pišite na Instagramu`, `href="https://www.instagram.com/dmd.nadabojic/"` `rel="noopener"` — **jedini potvrđen kanal** (§7.3).
- Desno (30 %): sekundarno dugme `☎ Telefon`. Dok telefon nije potvrđen, to **nije `<a href="tel:">`** nego `<button>` koji otvara `<details>` sa tekstom iz §4.12. `seo.md` §6.6/7 zabranjuje `tel:` sa izmišljenom vrednošću.
- Pozadina `--surface`, `border-top: 1px solid var(--border)`, `--shadow-lg` nagore. `padding-bottom: env(safe-area-inset-bottom)`.
- `<body>` dobija `padding-bottom: 72px` na mobilnom da traka ne pokriva footer.

### 4.4 Breadcrumbs

Na svim stranicama dubine 2 (`seo.md` §5.17/5). `<nav aria-label="Putanja">` + `<ol>`; separator je inline SVG šеvron 12 px (`--muted-light`), ne znak „/“. Tekst JetBrains Mono 500, 13 px, uppercase, `ls .14em`, `--muted`; poslednji član `aria-current="page"`, bez linka, `--text`. Postavljen **ispod headera, iznad `h1`**, `margin-block: --sp-5 --sp-3`. Prati ga `BreadcrumbList` JSON-LD.

### 4.5 Footer

```
┌══════════════════════════════════════════════════════════════════════════┐
│  (pozadina --primary #14503F, tekst #FBF8F4)                            │
│                                                                          │
│  [⌾ znak na tamnoj]        USLUGE            PARODONTOPATIJA    KONTAKT │
│  dr Nada Bojić             Parodontologija   Vodič              Beograd  │
│  PARODONTOLOGIJA I         Parod. hirurgija  Krvarenje desni    Instagram│
│  ORALNA MEDICINA           Oralna medicina   Povlačenje desni   Telefon: │
│                            Oralna hirurgija  Upala desni        [POTVRD.]│
│  Hope Dental, Beograd      Protetika         Klimavi zubi       Radno vr.│
│  Instagram @dmd.nadabojic  Estetska medicina                    [POTVRD.]│
│                                                                          │
│  ──────────────── luk L2 u #E8B9AC, stroke 1.5 ────────────────          │
│                                                                          │
│  Sadržaj sajta je informativan i ne zamenjuje stomatološki pregled.      │
│  © 2026 dr Nada Bojić · Politika privatnosti                            │
└══════════════════════════════════════════════════════════════════════════┘
```
- 4 kolone desktop → 2 kolone tablet → 1 kolona (akordeon nije potreban, lista je kratka) mobilni.
- Linkovi `#FBF8F4` na `--primary` = 9.1:1; hover `--accent-soft` (5.32:1 na primarnoj, izmereno u `brand.md` §3).
- **Footer ne linkuje sve stranice** (`seo.md` §5.17/7): usluge + simptomski klaster + kontakt + politika privatnosti. Nema „O meni“ i „Pitanja“ u footeru — oni su u headeru.
- Znak je varijanta „na tamnoj“ (zub `#FBF8F4`, luk `#E8B9AC`).
- Medicinska napomena u footeru je **globalna** i stoji na svakoj stranici; na stranicama usluga i simptoma dolazi **još jedna, u telu** (§4.11), jer `seo.md` §0 to nalaže po stranici.

### 4.6 Dugmad (iz `brand.md` §7)

| Klasa | Pozadina | Tekst | Ivica | Upotreba |
|---|---|---|---|---|
| `.btn--primary` | `--primary` | `#FFFFFF` | — | glavni CTA. **Jedno po ekranu.** |
| `.btn--primary:hover` | `--primary-dark` | `#FFFFFF` | — | + `translateY(-1px)`, `--shadow-md` |
| `.btn--secondary` | transparentno | `--primary` | 1.5 px `--primary` | „Saznajte više“, „Pročitajte vodič“ |
| `.btn--text` | — | `--secondary-dark` | — | podvlaka na hover |
| `.btn--ghost-dark` | transparentno | `#FBF8F4` | 1.5 px `#FBF8F4` | **samo** unutar tamnog bloka / footera |

Visina 48 px desktop / 52 px mobilni, padding `14px 28px`, `--r-md` 12 px, Inter 500 `--fs-sm`, **bez uppercase**. `:focus-visible` = `--shadow-focus` + `outline: 2px solid var(--primary)` `outline-offset: 2px`. Ikona u dugmetu: 18 px, `stroke 1.75`, `--sp-2` razmaka, `aria-hidden`.

### 4.7 Kartice

| Varijanta | Opis |
|---|---|
| `.card--service` | ikona 24 px `stroke 1.75` `--secondary` u kvadratu 48×48 `--primary-wash` `--r-md` → `h3` EB Garamond 600 `--fs-h3` → opis Inter 400 `--fs-sm` `--muted` → link „Saznajte više →“. Cela kartica klikabilna (`<a>` omotač oko sadržaja, naslov je tekst linka). Hover: `--shadow-md` + `translateY(-2px)`, bez promene boje. |
| `.card--symptom` | **bez ikone u kvadratu**; umesto nje mono labela faze („FAZA 2“) i jedna rečenica simptoma u EB Garamond 500 `--fs-h3`. Levi `border-left: 3px solid var(--accent)`. Vizuelno se razlikuje od kartica usluga da posetilac odmah vidi da su to dve različite vrste sadržaja. |
| `.card--note` | pozadina `--primary-wash`, bez senke, `border-left: 3px solid var(--primary)`, ikona „info“ 20 px. Za „ovo je informativno“ i „kada ne čekati“. |
| `.card--step` | numerisana: broj u EB Garamond 500, 40 px, `--accent-soft`, apsolutno pozicioniran gore-levo iza naslova. Za „Kako izgleda prvi pregled“, „Kako teče terapija“. |
| `.card--pending` | `[POTVRDITI]` kartica, vidi §4.12 |
| `.card--case` | pre/posle slučaj, vidi §4.10 |

Sve: `--surface`, `--r-lg` 16 px, `1px solid --border`, `--shadow-sm`, padding 24 px mobilni / 32 px desktop. Mreža `repeat(auto-fit, minmax(300px, 1fr))`, `gap --sp-5`.

### 4.8 Ikone — inline SVG, linijske

Pravila iz `brand.md` §7: `stroke-width: 1.75`, `stroke-linecap/linejoin: round`, 24 px, `fill="none"`, **nikad punjene**, `stroke="currentColor"` da nasledi boju konteksta, `aria-hidden="true" focusable="false"`.

Potreban set (18 ikona, sve se crtaju ručno kao inline SVG — **bez ikonskih biblioteka i bez font-ikona**):

| Ikona | Opis crteža | Gde |
|---|---|---|
| `zub` | kontura zuba iz logotipa, linijska varijanta | usluge, protetika |
| `luk-desni` | otvoreni luk | parodontologija |
| `kap` | kap sa zaobljenim vrhom | krvarenje desni |
| `strelica-dole-tkivo` | luk + strelica nadole | povlačenje desni |
| `plamen-blago` | mek, zaobljen oblik (ne agresivan plamen) | upala desni |
| `zub-nakrivljen` | zub pod blagim uglom + dve linije kretanja | klimavi zubi |
| `skalpel` | linijski skalpel | parodontološka / oralna hirurgija |
| `jezik-sluznica` | ovalna kontura usne duplje | oralna medicina |
| `krunica` | kupola krunice na liniji gingive | protetika |
| `igla` | tanka igla pod uglom | estetska medicina |
| `lice-profil` | linijski profil lica | estetska medicina |
| `kap-plazma` | kružnica sa 3 tačke | PRP |
| `rtg` | pravougaonik sa konturom vilice | dijagnostika, prvi pregled |
| `sonda` | sonda sa oznakama dubine | parodontalni status |
| `kalendar` | kvadrat sa dve kvačice gore | kontrole, zakazivanje |
| `info` | krug + „i“ | `.card--note` |
| `instagram` | zaobljeni kvadrat + krug + tačka (linijski) | CTA, footer |
| `telefon` | linijska slušalica | CTA |

Plus utilitarne: `sevron`, `strelica-desno`, `plus`, `minus`, `tri-linije`, `x`.

### 4.9 Akordeon / FAQ

**`<details>` + `<summary>`, bez JS-a.** Nema `height: 0` trikova — sadržaj je u DOM-u i vidljiv kad je otvoren, pretraživač ga indeksira u oba stanja (`seo.md` §6.3/F zahteva da `FAQPage` sadrži samo vidljiva pitanja — `<details>` sadržaj se smatra vidljivim i to je ispravno).

```
┌──────────────────────────────────────────────────────┐
│ Zašto mi krvare desni kada perem zube?          [+] │  ← summary, Inter 500, 17px
├──────────────────────────────────────────────────────┤
│ Odgovor u 2–4 rečenice, Inter 400, --muted…          │
└──────────────────────────────────────────────────────┘
```
- `summary` visina min 56 px, `cursor: pointer`, `list-style: none`, `::-webkit-details-marker { display:none }`.
- Ikona `plus` → `minus` kad je `[open]`, rotacija 0 (bez rotacije — zamena patha), `--secondary`.
- Otvoren: pozadina `--surface`, zatvoren: transparentan. Razdelnik `1px solid var(--border)` između pitanja.
- Prvo pitanje na stranici usluge je `[open]` po defaultu (pokazuje da je blok interaktivan); ostala zatvorena. Na `/pitanja-i-odgovori/` **sva su zatvorena** (lista je dugačka) ali `#hash` link otvara ciljano pitanje (`:target { open }` nije dovoljan → `nav.js` dodaje `open` ako `location.hash` poklapa; bez JS-a pitanje je dostupno klikom).

### 4.10 Pre/posle komponenta (`.ba`)

Dvoslojna, po §0.1/2. **Isključena po defaultu** (§7.4).

**Osnovno stanje — HTML, bez JS-a, bez `.ba--slider`:**
```
┌─ .card--case ───────────────────────────────────────────────────┐
│ ESTETIKA · SLUČAJ 01                              (mono eyebrow)│
│ Estetska rekonstrukcija gornjih sekutića           (EB Gar. 600) │
│                                                                  │
│  [PRE]                        [POSLE]            ← čipovi IZNAD  │
│  ┌──────────────────┐         ┌──────────────────┐               │
│  │ ba-estetika-01-  │         │ ba-estetika-01-  │               │
│  │     pre.webp     │         │    posle.webp    │               │
│  └──────────────────┘         └──────────────────┘               │
│                                                                  │
│ Trajanje terapije: [POTVRDITI] · Složenost: jedna rečenica.      │
│ ⌾ Objavljeno uz pismenu saglasnost pacijenta. [POTVRDITI]        │
└──────────────────────────────────────────────────────────────────┘
```
Dve slike **jednakih piksel dimenzija** (manifest garantuje), `--r-lg`, `1px solid --border`, `gap --sp-3`. Na mobilnom jedna ispod druge. Čipovi `PRE`/`POSLE`: JetBrains Mono 500, 11 px, uppercase, `ls .14em`, tekst `--accent-ink`, pozadina `--accent-wash`, `--r-xs`, padding `4px 10px`, **iznad slike levo, nikad preko nje** (brand §8).

**Nadograđeno stanje — `ba.js` dodaje `.ba--slider` na `<figure>`:**
```
┌──────────────────────────────────────────────┐
│ [PRE]                               [POSLE]  │
│ ┌──────────────────────┬───────────────────┐ │
│ │   pre.webp           ┃   posle.webp      │ │
│ │                      ⌾  ← ručka (L4)     │ │
│ │                      ┃                   │ │
│ └──────────────────────┴───────────────────┘ │
│  ├──────────────◉───────────────────────┤    │ ← <input type="range">
│  (vidljiv range input ispod slike, 44px tap) │
└──────────────────────────────────────────────┘
```
- **Mehanika:** dve slike u `position: absolute` jedna preko druge u kontejneru fiksnog `aspect-ratio`; gornja (`posle`) se odseca `clip-path: inset(0 calc(100% - var(--ba-pos)) 0 0)`. `--ba-pos` postavlja `ba.js` iz vrednosti range inputa. **Nema transition na clip-path** (brand: nije igračka; i sprečava „gumeni“ osećaj pri prevlačenju).
- **Miš / dodir:** `pointerdown`/`pointermove`/`pointerup` na kontejneru (jedan `pointer*` set pokriva i miš i dodir i stylus), `touch-action: none` samo na ručki, ne na celoj slici — da se stranica može skrolovati prstom preko slike.
- **Tastatura:** **nativni `<input type="range" min="0" max="100" step="1" value="50">` ostaje vidljiv ispod slike** i jeste jedini izvor istine. Time ← → Home End PgUp PgDn rade bez ijedne linije koda, i screen reader dobija pravu kontrolu. `aria-label="Prikaz pre i posle — slučaj 01"`, `aria-valuetext` se ažurira na „Prikazano 70% slike posle terapije“. Ručka na slici je **vizuelni proxy**, `aria-hidden`, `tabindex="-1"`.
- **Bez JS-a:** `.ba--slider` nikad ne dobije klasu → ostaje dvoslika; range input je `display: none` dok `html` nema `.js` klasu.
- **Fallback ako par ne postoji:** spojene varijante `ba-*.webp` (žig i oznake su u slici) u `<img>` bez komponente.
- **Fokus:** `:focus-visible` na range inputu daje `--shadow-focus` i **podebljava ručku na slici** (2.5 → 3.5 px), da se vidi gde se akcija dešava.
- `prefers-reduced-motion`: nema šta da se isključi — komponenta nema animacije. To je namerno.

**Filter po kategoriji** (`/rezultati/`):
```
KATEGORIJA
( ) Svi (7)   ( ) Estetika (3)   ( ) Protetika (3)   ( ) Hirurgija (1)
```
- `<fieldset>` + 4 `<input type="radio" name="kat">` sa `<label>` stilizovanim kao čip-pilule (`--r-full`, `--surface`, `1px solid --border-strong`; izabran: `--primary-wash`, `1.5px solid --primary`, tekst `--primary`).
- **Bez JS-a:** radio dugmad su obmotana u `<a href="#estetika">` sekcijske linkove? Ne — čistije: **bez JS-a su to tri `<h2>` sekcije** (`#estetika`, `#protetika`, `#hirurgija`) i filter je skip-nav koji skače na sekciju. Sa JS-om, isti radio set skriva/prikazuje `.card--case` po `data-kat` atributu i aktivira `aria-live="polite"` poruku „Prikazano 3 od 7 slučajeva“. **Nijedan slučaj nikad nije nevidljiv bez JS-a.**
- Filter je `position: sticky; top: 72px` na desktopu.

**Napomena o saglasnosti — dva nivoa, oba obavezna:**
1. **Po slučaju**, vidljivo u kartici, ne u tooltipu: mono labela + tekst `Objavljeno uz pismenu saglasnost pacijenta.` Dok saglasnost nije dostavljena, komponenta `[POTVRDITI]` (§4.12) stoji na tom mestu — i to je dodatni razlog zašto je cela sekcija isključena.
2. **Po sekciji**, na dnu, `--fs-sm`, `--muted`, doslovno iz `brand.md` §8: *„Prikazani slučajevi su objavljeni uz pismenu saglasnost pacijenata. Rezultat terapije je individualan i zavisi od stanja tkiva, opšteg zdravlja i saradnje pacijenta.“*

### 4.11 Medicinska napomena (`.card--note--medical`)

Obavezna u telu svake stranice usluge i svake simptomske stranice (`seo.md` §0, §5.4, §5.11–14). Pozicija: **ispod poslednje sadržajne sekcije, iznad FAQ-a.** Tekst: *„Ovaj tekst je informativan i ne zamenjuje pregled. Za procenu stanja potreban je klinički pregled.“* Stil: `.card--note`, ikona `info`, `--primary-wash`, bez senke. **Nikad sitnim slovima u footeru kao jedina instanca.**

### 4.12 Komponenta `[POTVRDITI]` — kako nepoznat podatak ne izgleda kao greška

Ovo je kritična komponenta ovog projekta: 13 od 15 kontakt podataka ne postoji (`seo.md` §8.1), a sajt mora da izgleda dovršeno i klijentkinji (koja mora da primeti šta da pošalje) i posetiocu demo verzije.

**Rešenje: podatak koji još nije objavljen prikazuje se kao _status_, ne kao prazno polje.**

```
┌───────────────────────────────────┐
│ ⌾ TELEFON                         │  ← mono labela, --muted
│ Objavljujemo po potvrdi            │  ← Inter 400, --muted, NIJE "N/A", NIJE prazno
│ Do tada: poruka na Instagramu →    │  ← uvek ponuđena alternativa koja RADI
└───────────────────────────────────┘
   1px dashed var(--border-strong), --r-sm, bg --surface-alt, padding 16px
```

- **Isprekidana ivica** je jedini mesto na sajtu gde se koristi `dashed` — čita se kao „u pripremi“, ne kao „pokvareno“.
- Nikad reči „placeholder“, „lorem“, „TODO“, „XXX“ ni prazna crta posetiocu.
- **Za klijentkinju** (demo režim, `seo.md` §6.6/6) ista komponenta nosi dodatni red: `<span class="pending__tag">[POTVRDITI SA KLIJENTOM]</span>` — JetBrains Mono, 11 px, `--warning` `#A86A2B`, uppercase. Taj red je u HTML-u obmotan markerom:
  ```html
  <!-- DEMO:START --><span class="pending__tag">[POTVRDITI SA KLIJENTOM]</span><!-- DEMO:END -->
  ```
  Pri objavi se pretraga po `DEMO:START` u repozitorijumu briše sve takve blokove, a `.card--pending` se zamenjuje stvarnim podatkom. Pretraga po `[POTVRDITI` mora vratiti **0 rezultata** (`seo.md` §6.6, korak 2).
- **Nikad `<a href="tel:">` ni `<a href="mailto:">` sa nepostojećom vrednošću.** Gde bi stajalo dugme, stoji `<button>` koji otvara `<details>` sa objašnjenjem i Instagram alternativom.

### 4.13 Čipovi, labele, tabele

- **Čip** (`.chip`): `--r-xs`, padding `4px 10px`, JetBrains Mono 500, 11 px, uppercase, `ls .14em`. Varijante: `--accent` (PRE/POSLE, faze), `--primary-wash` (kategorija usluge), `--surface-alt` (meta).
- **Lista sa kvačicama** (`.list--check`): ikona kvačica 18 px `--success`, `stroke 1.75`, `padding-left: 32px`, `--sp-3` između stavki. Za „šta obuhvata“, „šta možete sami“.
- **Tabela** (`.table`): samo gde je zaista tabela (poređenje gingivitis/parodontitis). `border-collapse`, zaglavlje `--surface-alt` + mono labela, redovi razdvojeni `1px solid var(--border)`, `padding 12px 16px`. Na mobilnom: `display: block` + `overflow-x: auto` sa `-webkit-overflow-scrolling` i vidljivom senkom na ivici, **ne** transformacija u kartice (gubi se poređenje).

### 4.14 Tipografski ritam (iz `brand.md` §5)

| Element | Font | Veličina |
|---|---|---|
| `h1` | EB Garamond 500 | `--fs-h1` clamp(2.25rem, 1.4rem+3.2vw, 3.75rem), `ls -0.015em`, `lh 1.15` |
| `h2` | EB Garamond 500 | `--fs-h2` clamp(1.75rem…2.5rem) + luk L1 ispod |
| `h3` | EB Garamond 600 | `--fs-h3` 1.5rem |
| lead | Inter 400 | `--fs-lg` 19 px, `--muted`, max 60 znakova |
| telo | Inter 400 | `--fs-base` 17 px, `lh 1.65`, **max 68 znakova u redu** |
| eyebrow | JetBrains Mono 500 | `--fs-xs` 13 px, uppercase, `ls .14em`, `--accent-ink` |

EB Garamond se **nikad ne koristi ispod 18 px** i nikad za telo teksta (brand §5). Italic se ne učitava (§0.1/3) — stručni termin se izdvaja `--muted` bojom ili čipom, ne kurzivom.

---

## 5. Specifikacija po stranici

Legenda wireframe-a: `▰` slika · `□` kartica · `≡` tekstualni blok · `◉` CTA · `⌒` luk razdelnik · `⌾` eyebrow

---

### 5.1 `/` — Naslovna

**Cilj:** u 5 sekundi odgovoriti „ovo je parodontolog u Beogradu i ovo je osoba“, i odvesti posetioca u jedan od dva tunela: **simptom** (edukacija → terapija) ili **usluga** (direktna namera).
**H1:** `Parodontolog u Beogradu — zdravo zubno meso kao osnova zdravih zuba`
**H2 redosled je obavezan i preuzet iz `seo.md` §5.1.**

```
┌ HEADER (sticky) ─────────────────────────────────────────────────────────┐
└──────────────────────────────────────────────────────────────────────────┘
┌ 1. HERO ─────────────────────────────────────────────────────────────────┐
│                                        ⌾ PARODONTOLOGIJA · BEOGRAD      │
│  ▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰                                                   │
│  ▰  hero.webp 3:2   ▰▰▰▰▰▰▰▰        Parodontolog u Beogradu —          │
│  ▰  (puna širina,   ▰▰▰▰▰▰▰▰        zdravo zubno meso kao              │
│  ▰   leva 58%)      ▰▰▰▰▰▰▰▰        osnova zdravih zuba       (h1)     │
│  ▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰▰                                                   │
│   ╰──── luk L3, donja ivica ────╯   lead: 2 rečenice, --muted           │
│                                                                          │
│                                      [ ◉ Zakažite pregled ] [ Vodič → ] │
└──────────────────────────────────────────────────────────────────────────┘
┌ 2. KADA JE VREME ZA PARODONTOLOGA ───────────── (bg --surface-alt) ─────┐
│ ⌾ SIMPTOMI                                                              │
│ Kada je vreme za parodontologa                              (h2 + luk)  │
│                                                                          │
│         ░░░░░ LUČNA SKALA FAZA — potpisni element §3.2 ░░░░░             │
│   ○───────────────○───────────────○───────────────○                      │
│  UPALA        KRVARENJE      POVLAČENJE     KLIMAVI ZUBI                │
│  (4 linka na simptomske stranice, luk ide ispod njih)                   │
│                                                                          │
│  □ card--symptom  □ card--symptom  □ card--symptom  □ card--symptom     │
│  „Desni krvare    „Zubno meso je   „Zubi deluju     „Zub se klati        │
│   pri pranju“      crveno…“         duži…“           pri žvakanju“       │
│  Krvarenje →      Upala →          Povlačenje →     Klimavi zubi →      │
└──────────────────────────────────────────────────────────────────────────┘
                              ⌒ L2 ⌒
┌ 3. USLUGE ──────────────────────────────────────────── (bg --bg) ───────┐
│ ⌾ USLUGE                                                                │
│ Usluge                                                       (h2 + luk) │
│  □ Parodontologija   □ Parod. hirurgija   □ Oralna medicina             │
│  □ Oralna hirurgija  □ Fiksna protetika   □ Estetska medicina lica      │
│                                             [ Sve usluge → ]            │
└──────────────────────────────────────────────────────────────────────────┘
┌ 4. DR NADA BOJIĆ ───────────────── (bg --surface-alt, split 40/60) ─────┐
│  ▰▰▰▰▰▰▰▰▰▰▰      ⌾ O MENI                                              │
│  ▰ doktor-     ▰   Dr Nada Bojić                             (h2+luk)   │
│  ▰ portret-    ▰   ≡ 3–4 rečenice: citat titule iz bio-a, oblasti rada  │
│  ▰ kvadrat 1:1 ▰   ≡ „Spec. dr parodontologije i oralne medicine“       │
│  ▰▰▰▰▰▰▰▰▰▰▰      [ Više o meni → ]                                     │
└──────────────────────────────────────────────────────────────────────────┘
┌ 5. KAKO IZGLEDA PRVI PREGLED ─────────── (bg --primary, TAMNI BLOK) ────┐
│ ⌾ PRVI PREGLED        (boja --accent-soft)                              │
│ Kako izgleda prvi pregled                  (h2 #FBF8F4 + luk #E8B9AC)   │
│  □ 01 Pregled      □ 02 Nalaz          □ 03 Plan terapije               │
│    i razgovor        parodontalni        pisan, sa koracima             │
│                      status + RTG        i redosledom                   │
│  ▰ proces-rtg.webp (desno, 4:3, --r-xl, opacity 1, bez overlay-a)       │
│                                       [ ◉ ghost-dark: Zakažite → ]      │
└──────────────────────────────────────────────────────────────────────────┘
┌ 6. ČESTA PITANJA ────────────────────────────────── (bg --bg) ──────────┐
│ ⌾ PITANJA · 4 akordeona (§4.9), prvi [open] · [ Sva pitanja → ]        │
└──────────────────────────────────────────────────────────────────────────┘
┌ 7. KONTAKT I LOKACIJA ───────────────────── (bg --surface-alt) ─────────┐
│ ⌾ KONTAKT                                                               │
│ Kontakt i lokacija                                          (h2 + luk)  │
│  □ card--pending: ADRESA   □ card--pending: TELEFON                     │
│  □ card--pending: RADNO VREME  □ RADI: Instagram ◉                      │
│  [ MAPA — POTVRDITI ADRESU ]  (tipografski blok, §5.16)                 │
│                                       [ ◉ Pišite na Instagramu ]        │
└──────────────────────────────────────────────────────────────────────────┘
┌ FOOTER (tamni) ──────────────────────────────────────────────────────────┐
└──────────────────────────────────────────────────────────────────────────┘
[ sticky CTA traka — samo mobilni ]
```

**Slike:** `hero.webp` (hero, `loading="eager"` + `fetchpriority="high"`, 3:2, **tekst gore desno** po preporuci manifesta — mirna zona je žuti zid i prozor; `width="1440" height="960"`), `doktor-portret-kvadrat.webp` (sekcija 4, 1:1, lazy), `proces-rtg.webp` (sekcija 5, lazy).
**Zabranjeno na naslovnoj:** `detalj-implant.webp`, `osmeh-rezultat.webp`, bilo koji `ba-*` i bilo koji klinički makro — `brand.md` §8 to eksplicitno zabranjuje. `ordinacija-01.webp` se ne koristi (bokeh).
**Hero overlay:** teksta **nema preko slike** na desktopu (split layout), pa overlay nije potreban. Na mobilnom se hero prelomi: slika gore (3:2), tekst ispod na `--bg` — i time se u celosti izbegava problem kontrasta nad fotografijom.
**Ikone:** 6 u karticama usluga (`luk-desni`, `skalpel`, `jezik-sluznica`, `zub`, `krunica`, `igla`), 4 u simptomskim karticama, 3 u koracima pregleda (`sonda`, `rtg`, `kalendar`).
**Animacije:** `fade-up` 16 px / 400 ms / stagger 60 ms na sekcijama 2–7 (ne na heroju — hero je LCP i ne sme čekati). Implementacija §7.5.
**Layout:**
- **Telefon (<600):** sve 1 kolona. Hero: slika → h1 → lead → 2 dugmeta jedno pod drugim. Lučna skala faza: luk se **rotira u vertikalu** (4 tačke jedna pod drugom, luk postaje blaga vertikalna kriva levo, labele desno) — `media (max-width: 599px)` menja `viewBox` preko druge `<svg>` instance sa `hidden` atributom? **Ne** — rešenje bez duplog markup-a: ista `<ol>`, CSS `flex-direction: column`, a SVG luk `display: none` ispod 600 px, zamenjen levom vertikalnom linijom `2px` u `--accent` i tačkama. Jedan markup, dva izgleda.
- **Tablet (600–899):** hero ostaje split ali 50/50; usluge 2 kolone; simptomi 2×2; koraci pregleda 3 u redu ispod naslova, slika `proces-rtg` ispod njih na punoj širini.
- **Desktop (≥900):** kako je nacrtano. ≥1200: `--container` 1160 px, hero slika dobija negativnu levu marginu do ivice viewport-a (full-bleed levo, tekst u gridu) — jedini full-bleed element na sajtu.

**Schema:** `Dentist` + `WebSite` (`seo.md` §6.3 A, F). **Bez `address`, `telephone`, `openingHoursSpecification`, `priceRange`, `aggregateRating`.**

---

### 5.2 `/o-meni/`

**Cilj:** lični brend nosi konverziju (`web-research.md`: ordinacija Vuković potvrđuje model). Ovde se gradi poverenje u **osobu**, uz pravnu disciplinu oko titule.
**H1:** `Dr Nada Bojić`

```
┌ HEADER ─┐  Putanja: POČETNA › O MENI
┌ 1. UVOD — split 45/55 ──────────────────────────────────────────────────┐
│  ▰▰▰▰▰▰▰▰▰▰▰▰        ⌾ O MENI                                           │
│  ▰ doktor-      ▰     Dr Nada Bojić                              (h1)   │
│  ▰ portret.webp ▰     ≡ „Spec. dr parodontologije i oralne medicine“    │
│  ▰ 4:5          ▰       — citirano iz njenog bio-a, bez proširivanja    │
│  ▰              ▰     ≡ lead 2–3 rečenice                               │
│  ▰▰▰▰▰▰▰▰▰▰▰▰        ⌾ čipovi: PARODONTOLOGIJA · ORALNA MEDICINA ·      │
│                        ESTETSKA MEDICINA LICA                           │
│  ⚠ card--pending: PORTRET BEZ MASKE — Assets/NOTES §6/2                 │
└─────────────────────────────────────────────────────────────────────────┘
┌ 2. OBRAZOVANJE I STRUČNO USMERENJE ─────────────── (--container-narrow)┐
│ ⌾ OBRAZOVANJE · h2 + luk                                                │
│ □ card--pending: FAKULTET I GODINA DIPLOMIRANJA  [POTVRDITI]            │
│ □ card--pending: STATUS SPECIJALIZACIJE          [POTVRDITI]            │
│ ≡ tekst koji radi i bez tih podataka: čime se bavi, zašto parodontologija│
└─────────────────────────────────────────────────────────────────────────┘
┌ 3. OBLASTI RADA ────────────────────────── (bg --surface-alt, 2 kol) ───┐
│ ⌾ OBLASTI RADA · h2 + luk                                               │
│ list--check, 5 oblasti, svaka linkuje na svoju stranicu usluge          │
└─────────────────────────────────────────────────────────────────────────┘
┌ 4. PRISTUP PACIJENTU ─────────────────── (bg --primary, TAMNI BLOK) ────┐
│ ⌾ PRISTUP · h2 #FBF8F4                                                  │
│ ≡ 3 kratka pasusa: objasni dijagnozu, pisan plan, kontrole.             │
│ ▰ ordinacija-01.webp — MALO I SITNO (max 280 px širine, 3:4, --r-lg),   │
│   desno, jer je bokeh/neoštar (NOTES §4). Dekorativno: alt=""           │
└─────────────────────────────────────────────────────────────────────────┘
┌ 5. DODATNE EDUKACIJE I SERTIFIKATI ────────────────────────────────────┐
│ ⌾ EDUKACIJE · h2 + luk                                                  │
│ □ card--pending (velika, puna širina): SERTIFIKATI, KURSEVI, ČLANSTVA   │
│   „Objavljujemo po potvrdi.“ + [POTVRDITI SA KLIJENTOM]                 │
└─────────────────────────────────────────────────────────────────────────┘
┌ 6. CTA ─────────────────────────────────────────────────────────────────┐
│ ⌾ ZAKAZIVANJE · [ ◉ Pišite na Instagramu ] [ Pročitajte vodič → ]      │
└─────────────────────────────────────────────────────────────────────────┘
```
**Slike:** `doktor-portret.webp` (4:5, max 800 px širine na mobilnom po `seo.md` §9), `ordinacija-01.webp` (sitno, dekorativno).
**Napomena Copywriteru:** titula se **citira**, ne proširuje („Spec. dr parodontologije i oralne medicine“). Nikad „specijalista parodontologije“ bez pisane potvrde (`seo.md` §5.2).
**Layout:** <600 slika gore punom širinom → tekst; 600–899 split 50/50, sekcija 3 u jednoj koloni; ≥900 kako je nacrtano, tekstualne sekcije u `--container-narrow` 720 px centrirano u kontejneru (asimetrija: naslov sekcije „visi“ levo van kolone na ≥1200 px).
**Schema:** `Person` (`seo.md` §6.3 B) — bez `alumniOf`, `hasCredential`, `memberOf`.
**Animacija:** `fade-up` na sekcijama 2–6.

---

### 5.3 `/usluge/` — hub

**Cilj:** razvodna tabla; svaka usluga dobija 2–3 rečenice i link. Hub, ne prodajna stranica.
**H1:** `Usluge`

```
Putanja: POČETNA › USLUGE
┌ 1. UVOD ────────────────────────────────────────────────────────────────┐
│ ⌾ USLUGE · h1 Usluge · lead: 2 rečenice (put pacijenta: desni → sanacija │
│   → protetika) · bez slike                                              │
└─────────────────────────────────────────────────────────────────────────┘
┌ 2. 6 × H2 blok — naizmenično poravnanje (ZIG-ZAG, ne mreža) ───────────┐
│  ┌───────────────────────────────┐                                      │
│  │ [ikona] ⌾ 01 / PARODONTOLOGIJA│  (bg --surface, --r-lg, span 7/12)   │
│  │ h2 Parodontologija        ⌒   │                                      │
│  │ ≡ 2–3 rečenice                │                                      │
│  │ [ Parodontologija → ]         │                                      │
│  └───────────────────────────────┘                                      │
│                   ┌───────────────────────────────┐                     │
│                   │ [ikona] ⌾ 02 / PAROD. HIRURG. │ (offset desno 5/12) │
│                   └───────────────────────────────┘                     │
│  ┌───────────────────────────────┐                                      │
│  │ 03 / ORALNA MEDICINA          │                                      │
│  ...                                                                     │
│  (06 ESTETSKA MEDICINA LICA — poslednja, jer je druga niša)             │
└─────────────────────────────────────────────────────────────────────────┘
┌ 3. BANER: VODIČ KROZ PARODONTOPATIJU ──── (bg --primary-wash) ─────────┐
│ ⌾ VODIČ · „Ako još ne znate koja usluga vam treba — počnite od simptoma“│
│ 4 linka na simptomske stranice + [ Vodič → ]                            │
└─────────────────────────────────────────────────────────────────────────┘
```
**Slike:** **nijedna.** Hub se nosi tipografijom, ikonama i zig-zag ritmom. Nema fotografije koja bi bilo šta dodala, a 6 slabih thumbnail-a bi srušilo ton.
**[ODLUKA]** Zig-zag umesto 3×2 mreže: razlikuje hub od sekcije „Usluge“ na naslovnoj (koja JE mreža), pa posetilac vidi da je na drugom nivou.
**Layout:** <900 sve 1 kolona, bez offseta (zig-zag se gubi, ostaje vertikalni niz sa mono brojevima 01–06 kao ritmom). ≥900 grid 12 kolona, naizmenični `grid-column: 1/8` i `6/13`.
**Animacija:** `fade-up`, stagger 60 ms, naizmenično sa malim horizontalnim pomerajem (±8 px) u smeru offseta.

---

### 5.4 Šablon stranice usluge (važi za 5.4–5.8)

Svih pet stranica usluga (`parodontologija`, `parodontoloska-hirurgija`, `oralna-medicina`, `oralna-hirurgija`, `protetika`) koristi **isti skelet**; razlikuju se po slikama i po jednom specifičnom bloku. `estetska-medicina` ima **svoj** šablon (§6) jer nema fotografija.

```
Putanja: POČETNA › USLUGE › [NAZIV]
┌ 1. HERO USLUGE (kompaktan, bez velike slike) ──────────────────────────┐
│ ⌾ USLUGA                                                                │
│ h1 [Naziv]                                                              │
│ lead: 2 rečenice, --fs-lg, --muted, max 60 znakova u redu               │
│ [ ◉ Zakažite pregled ]   ← prvi CTA, visoko                             │
│ ──────────────────────────────────────────────── 1px --border ──────────│
│ ⌾ NA OVOJ STRANICI  (sadržaj / mini TOC, 3–5 anchor linkova, mono 13px) │
└─────────────────────────────────────────────────────────────────────────┘
┌ 2. GLAVNI TEKST + MEDIJA ─────────── (--container-narrow + izlazi) ────┐
│ h2 [prvi H2 iz seo.md]  ⌒                                               │
│ ≡ tekst                                                                 │
│   ▰ slika 1 — izlazi iz tekstualne kolone levo/desno na ≥1200 px        │
│ h3 / h3 ...                                                             │
│ h2 [drugi H2] ⌒                                                         │
│ ≡ tekst, list--check                                                    │
└─────────────────────────────────────────────────────────────────────────┘
┌ 3. KORACI TERAPIJE ───────────────────── (bg --surface-alt) ───────────┐
│ ⌾ KAKO TEČE TERAPIJA · h2 ⌒                                             │
│ □ 01 ... □ 02 ... □ 03 ... □ 04 ...   (card--step, 2×2 tablet, 4 desk.) │
└─────────────────────────────────────────────────────────────────────────┘
┌ 4. SPECIFIČAN BLOK (različit po stranici — vidi tabelu niže) ──────────┐
└─────────────────────────────────────────────────────────────────────────┘
┌ 5. KLINIČKE FOTOGRAFIJE — samo gde postoje ────────────────────────────┐
│ <details>  ▸ Prikaži kliničke fotografije   (zatvoreno po defaultu)     │
│   ▰ slika + 1 rečenica objašnjenja šta se vidi                          │
│   ⌾ napomena o saglasnosti pacijenta [POTVRDITI]                        │
└─────────────────────────────────────────────────────────────────────────┘
┌ 6. POVEZANE USLUGE (min 2, kontekstualno — seo.md §5.17/2) ────────────┐
│ ⌾ POVEZANO · 2–3 male kartice                                           │
└─────────────────────────────────────────────────────────────────────────┘
┌ 7. MEDICINSKA NAPOMENA (§4.11) ────────────────────────────────────────┐
┌ 8. ČESTA PITANJA (3–4, akordeon, FAQPage schema) ──────────────────────┐
┌ 9. CTA BLOK (bg --primary, tamni) ─────────────────────────────────────┐
│ ⌾ ZAKAZIVANJE · h2 „Zakažite pregled“ · [ ◉ Instagram ] [ Telefon ⋯ ]  │
└─────────────────────────────────────────────────────────────────────────┘
```

**Mini TOC (sekcija 1)** je `<nav aria-label="Sadržaj stranice">` sa `<ol>` anchor linkova na `h2` ID-jeve. Na ≥1200 px postaje **`position: sticky` levi rail** (širine 180 px, `top: 96px`) uz tekstualnu kolonu, sa aktivnim stanjem koje `reveal.js` ažurira preko IntersectionObserver-a; **bez JS-a ostaje statična lista linkova na vrhu.** Ovo je ono što stranicu od 1200 reči čini upotrebljivom, a nijedan konkurent iz `web-research.md` to nema.

| Stranica | Slike (samo postojeći fajlovi) | Specifičan blok (sekcija 4) | Klinički `<details>` |
|---|---|---|---|
| `/usluge/parodontologija/` ★ | `ordinacija-02.webp` (model vilice — uz „Šta je parodontopatija“), `proces-rtg.webp` (uz „Pregled i parodontalni status“) | **Lučna skala faza** (§3.2) u sekciji „Znaci na koje treba obratiti pažnju“ + tabela `gingivitis / parodontitis` (§4.13) | — (nema perio makro snimka u setu) |
| `/usluge/parodontoloska-hirurgija/` | `proces-instrumenti.webp` (sterilni set, 1:1) | „Posle zahvata — oporavak i kontrole“ kao **vremenska osa**: 4 lučne tačke (dan 1 / nedelja 1 / nedelja 2 / kontrola) — varijanta potpisnog elementa | — |
| `/usluge/oralna-medicina/` | **nijedna** | 4 `.card--symptom` varijante (afte · plakovi · suva usta · pečenje) + `.card--note` „Kada je promena razlog za hitan pregled“ | — |
| `/usluge/oralna-hirurgija/` | `proces-hirurgija.webp` (16:10, kropovan, `alt` iz manifesta), `proces-instrumenti.webp` | „Oporavak i uputstva posle intervencije“ kao numerisana lista sa kvačicama | `detalj-implant.webp` — **max 480 px širine** (NOTES §4: mutan), sa objašnjenjem šta se vidi |
| `/usluge/protetika/` | `osmeh-rezultat.webp` (4:5) | „Zašto zdravo zubno meso dolazi pre protetike“ — **tamni blok** `--primary` sa jakim kontekstualnim linkom na `/usluge/parodontologija/` (`seo.md` §5.8) | `detalj-implant.webp` (deli se sa oralnom hirurgijom; na jednoj od dve stranice — **[ODLUKA]** ostaje na oralnoj hirurgiji, protetika ga ne ponavlja) |

**Layout (sve stranice usluga):**
- **<600:** jedna kolona, `--gutter` 16 px; TOC je `<details>` zatvoren („Sadržaj ▾“); `card--step` jedna pod drugom; slike punom širinom `--r-lg`.
- **600–899:** tekst u jednoj koloni (max 68 znakova), slike do 560 px centrirane; koraci 2×2.
- **900–1199:** `--container-narrow` 720 px za tekst, centrirano; slike mogu do 860 px (izlaze iz kolone simetrično); koraci 4 u redu.
- **≥1200:** sticky TOC rail levo + tekst 720 px + slike izlaze desno do 1160 px (asimetrično). Ovo je jedini raspored na sajtu sa tri kolone.

**Animacije:** `fade-up` na sekcijama; **sekcija 5 (`<details>`) se ne animira** — klinička fotografija se pojavljuje bez ikakvog efekta, to je pitanje tona.
**Schema:** `MedicalProcedure` po stranici + `FAQPage` (samo vidljiva pitanja) + `BreadcrumbList`. Bez `cost`/`offers`.

---

### 5.5 `/parodontopatija/` — hub simptomskog klastera

**Cilj:** ovo je **najvažnija stranica sajta posle naslovne** (`seo.md` §1: „simptomske stranice su realno osvojive“). Hub mora da (a) smesti posetioca na skalu faza, (b) pošalje ga na pravu simptomsku stranicu, (c) ne uplaši ga.
**H1:** `Parodontopatija — vodič za pacijente`

```
Putanja: POČETNA › PARODONTOPATIJA
┌ 1. UVOD ───────────────────────────────────── (bg --bg, bez slike) ────┐
│ ⌾ VODIČ ZA PACIJENTE                                                    │
│ h1 Parodontopatija — vodič za pacijente                                 │
│ lead: „Bolest zubnog mesa napreduje tiho. Ovde je opisano kako, i gde    │
│        ste vi u tome.“ (ton: smiren, bez „izgubićete zube“)             │
└─────────────────────────────────────────────────────────────────────────┘
┌ 2. KAKO BOLEST NAPREDUJE ──────── (bg --surface-alt, CENTRALNI BLOK) ──┐
│ ⌾ FAZE · h2 Kako bolest napreduje ⌒                                     │
│                                                                          │
│   ░░░ LUČNA SKALA FAZA — VELIKA VARIJANTA (jedino mesto) ░░░            │
│                                                                          │
│    ZDRAVO          UPALA        POVLAČENJE     KLIMAVI ZUBI             │
│      ○───────────────○───────────────○───────────────○                  │
│       ╰──────── luk, 100% širine kontejnera ────────╯                   │
│      │              │               │               │                   │
│      ≡              ≡               ≡               ≡                   │
│   1 rečenica   1 rečenica      1 rečenica      1 rečenica               │
│   (nije link)  [Upala →]    [Povlačenje →]  [Klimavi zubi →]            │
│                                                                          │
│   NB: „Krvarenje desni“ je simptom koji prati faze 1–3 i stoji ISPOD    │
│       skale kao poprečna kartica punom širinom: [Krvarenje desni →]     │
└─────────────────────────────────────────────────────────────────────────┘
┌ 3. SIMPTOMI PO FAZAMA ─────────────────────────────────────────────────┐
│ ⌾ SIMPTOMI · h2 ⌒ · 4 × card--symptom (velike, 2×2) sa linkovima       │
└─────────────────────────────────────────────────────────────────────────┘
┌ 4. FAKTORI RIZIKA ────────────────────── (--container-narrow) ─────────┐
│ ⌾ RIZIK · h2 ⌒ · list--check u 2 kolone (pušenje, dijabetes, trudnoća, │
│   genetika, higijena, lekovi…) — bez moralisanja                        │
└─────────────────────────────────────────────────────────────────────────┘
┌ 5. ŠTA MOŽETE SAMI, A ŠTA NE ──────── (dve kolone, kontrast) ──────────┐
│ ┌ MOŽETE SAMI (bg --success-wash) ┐ ┌ NE MOŽE SE SAMO (bg --primary-   │
│ │ list--check, --success ikone    │ │ wash) list sa ikonom „info“      │
│ └─────────────────────────────────┘ └──────────────────────────────────┘│
│  [ODLUKA] Namerno NIJE crveno/zeleno „do & don't“ — levo je --success-  │
│  wash, desno --primary-wash. Nema zabrane, ima granica kompetencije.    │
└─────────────────────────────────────────────────────────────────────────┘
┌ 6. KADA KOD PARODONTOLOGA ─────── (bg --primary, TAMNI BLOK + CTA) ────┐
│ ⌾ KADA DOĆI · h2 · 3 kratke tvrdnje · [ ◉ Instagram ] [ Parodontologija→]│
└─────────────────────────────────────────────────────────────────────────┘
┌ 7. MEDICINSKA NAPOMENA (§4.11) ────────────────────────────────────────┐
```
**Slike:** **nijedna.** Hub je u celosti tipografija + potpisni luk + inline SVG. To je svesna odluka: stranica o bolesti ne treba fotografiju bolesti na vrhu, a fotografije koje postoje (ordinacija, instrumenti) ne ilustruju ništa iz ovog teksta. Praznina se rešava **skalom faza** (velikom, ~420 px visine na desktopu), dvokolonskim kontrastnim blokom i tamnim CTA blokom — tri različite teksture na jednoj stranici.
**Ikone:** `plamen-blago`, `kap`, `strelica-dole-tkivo`, `zub-nakrivljen`, `info`, kvačice.
**Layout:** <600 skala vertikalna (§5.1); 600–899 skala horizontalna ali bez opisa pod tačkama (opisi se spuštaju u kartice iz sekcije 3); ≥900 puna varijanta.
**Animacija:** luk se **iscrtava** (`stroke-dasharray`/`stroke-dashoffset`, 600 ms, jednom, `--ease`) kad uđe u viewport; tačke se pojavljuju sa stagger 80 ms. **Bez JS-a i pri `prefers-reduced-motion` luk je odmah ceo iscrtan** (`stroke-dashoffset: 0` je podrazumevano stanje u CSS-u, animacija se dodaje samo preko `html.js-reveal .arc.is-in`).
**Schema:** `BreadcrumbList`. (Ne `FAQPage` — hub nema FAQ.)

---

### 5.6 Šablon simptomske stranice (važi za 4 stranice) — SEO JEZGRO

Četiri stranice: `krvarenje-desni`, `povlacenje-desni`, `upala-desni`, `klimavi-zubi`. ~900–1400 reči svaka, identičan skelet (`seo.md` §5.11–5.14).

**Ton i zadatak šablona:** posetilac dolazi uznemiren, sa pretragom „zašto mi krvare desni“. Stranica mora da deluje kao **mirno objašnjenje specijaliste, ne kao članak koji plaši da bi prodao**. Zato: bez crvene boje, bez uzvičnika, bez „ne čekajte, zub će vam ispasti“, bez slika krvarećih desni. Prvi ekran daje **odgovor**, ne CTA.

**H2 skelet je zaključan na `seo.md` §5.11–14:** `Šta znači [simptom]` · `Najčešći uzroci` · `Kada je razlog za pregled` · `Kako se leči` · `Šta možete sami` · `Česta pitanja`.
Zadatak traži i korake „kada je hitno“ i „šta se dešava na pregledu“. **Mapiranje bez kršenja SEO plana:**
- „kada je hitno“ → **`.card--note--urgent` unutar H2 „Kada je razlog za pregled“** (ne novi H2),
- „šta se dešava na pregledu“ → **H3 `Kako izgleda pregled` unutar H2 „Kako se leči“**.
Hijerarhija H2→H3 ostaje bez preskakanja, `<title>`/`<h1>` nedirnuti.

```
Putanja: POČETNA › PARODONTOPATIJA › [SIMPTOM]
┌ 1. ODGOVOR ODMAH ──────────────────── (bg --bg, bez slike, 720 px) ────┐
│ ⌾ SIMPTOM                                                               │
│ h1 Krvarenje desni                                                      │
│                                                                          │
│ ┌ .answer-card  (bg --surface, --r-lg, border-left 3px --accent) ──────┐ │
│ │ ⌾ KRATAK ODGOVOR                                                     │ │
│ │ ≡ 2–3 rečenice koje odgovaraju na pitanje posetioca ODMAH.          │ │
│ │   EB Garamond 500, --fs-lg (19px) — jedini duži tekst u serifu,     │ │
│ │   namerno: čita se kao rečeno, ne kao napisano.                     │ │
│ └──────────────────────────────────────────────────────────────────────┘ │
│                                                                          │
│   ○──────●──────○──────○   ← LUČNA SKALA FAZA, uža varijanta (§3.2),    │
│   UPALA KRVARENJE …          aktivna tačka = ova stranica               │
│                                                                          │
│ ⌾ NA OVOJ STRANICI · mini TOC (6 anchora, mono 13 px)                   │
└─────────────────────────────────────────────────────────────────────────┘
┌ 2. h2 Šta znači krvarenje desni ────────────── (720 px kolona) ────────┐
│ ⌒ · ≡ 2–3 pasusa · inline SVG linijska ilustracija (§6.3 tip D):       │
│   presek zdrave vs. zahvaćene gingive, 2 stanja jedan pored drugog,     │
│   max 2 boje (--primary linija, --accent tkivo), labele mono 11px       │
└─────────────────────────────────────────────────────────────────────────┘
┌ 3. h2 Najčešći uzroci ─────────────────────────────────────────────────┐
│ ⌒ · 4–6 × mini kartica (ikona 20px + naslov h3 + 1–2 rečenice),        │
│   grid 2 kolone na ≥600, 1 na telefonu. BEZ numeracije (nisu koraci).  │
└─────────────────────────────────────────────────────────────────────────┘
┌ 4. h2 Kada je razlog za pregled ──────── (bg --surface-alt) ───────────┐
│ ⌒                                                                       │
│ ≡ uvodni pasus                                                          │
│ ┌ .card--note--urgent  (bg --primary-wash, border-left 3px --primary,  │
│ │  ikona info; NIJE crveno, NIJE „warning“ žuto) ─────────────────────┐ │
│ │ ⌾ NE ČEKAJTE AKO:                                                   │ │
│ │ ✓ krvarenje ne prestaje posle ... ✓ otok i bol ... ✓ povišena temp. │ │
│ │ ≡ „U tim situacijama pregled je potreban u najkraćem roku.“          │ │
│ │ [ ◉ Pišite na Instagramu ]   ← CTA #1, tačno posle 2. sekcije        │ │
│ └─────────────────────────────────────────────────────────────────────┘ │
└─────────────────────────────────────────────────────────────────────────┘
┌ 5. h2 Kako se leči ────────────────────────────────────────────────────┐
│ ⌒ · ≡ uvod                                                              │
│ □ 01 □ 02 □ 03  (card--step: faze terapije)                            │
│                                                                          │
│ h3 Kako izgleda pregled      ← „šta se dešava na pregledu“              │
│ ┌ .exam-strip (bg --surface, --r-lg, 1px --border) ────────────────────┐ │
│ │ [sonda] Razgovor → [sonda] Parodontalni status → [rtg] Snimak po     │ │
│ │ potrebi → [kalendar] Pisan plan terapije                            │ │
│ │ (4 koraka u redu, strelice su luk-segmenti, ne „→“ glifovi)          │ │
│ │ ≡ „Pregled ne podrazumeva intervenciju. Plan dobijate pre terapije.“ │ │
│ └─────────────────────────────────────────────────────────────────────┘ │
│ [ Parodontologija — kako teče terapija → ]  ← OBAVEZAN link (seo §5.17/1)│
└─────────────────────────────────────────────────────────────────────────┘
┌ 6. h2 Šta možete sami ─────────────────────────────────────────────────┐
│ ⌒ · list--check sa --success ikonama · + jedna rečenica o granici:      │
│   „Ovo ne zamenjuje terapiju, ali bez ovoga terapija ne drži.“          │
└─────────────────────────────────────────────────────────────────────────┘
┌ 7. SRODNI SIMPTOMI ────────────────────────────────────────────────────┐
│ ⌾ SRODNO · 1–2 card--symptom + link na /parodontopatija/ (hub)         │
└─────────────────────────────────────────────────────────────────────────┘
┌ 8. MEDICINSKA NAPOMENA (§4.11, obavezna doslovno iz seo.md §5.11–14) ──┐
┌ 9. h2 Česta pitanja (3, akordeon, FAQPage — ista pitanja NE ponavljati  │
│    na drugoj stranici: seo.md §7) ─────────────────────────────────────┐
┌ 10. CTA BLOK (bg --primary) ───────────────────────────────────────────┐
│ ⌾ ZAKAZIVANJE · h2 „Zakažite pregled“ · lead 1 rečenica                │
│ [ ◉ Pišite na Instagramu ] [ Telefon ⋯ ]  ← CTA #2, na dnu             │
└─────────────────────────────────────────────────────────────────────────┘
```

**Šta ovaj šablon čini prepoznatljivim (a ne „još jedan članak o desnima“):**
1. **`.answer-card` pre svega ostalog** — jedini serifni duži tekst na sajtu. Posetilac dobije odgovor u prvom ekranu, bez skrolovanja i bez CTA-a. To je i najjači signal kvaliteta prema SERP-u koji drže medijski portali (`seo.md` §3).
2. **Lučna skala faza** odmah pod `h1` — orijentacija „gde sam ja u ovome“, i navigacija ka ostale tri stranice.
3. **`.exam-strip`** — isti blok, identičan na sve 4 stranice. Skida najveću nepoznanicu („šta će mi raditi“) bez obećanja.
4. **Hitnost u `--primary-wash`, nikad u crvenoj.** Alarm se postiže tipografijom i mono labelom „NE ČEKAJTE AKO“, ne bojom. `brand.md` §10 crvenu eksplicitno zabranjuje u parodontologiji.
5. **Nula fotografija.** Namerno — vidi §6.3 tip D (linijske ilustracije). Nijedna slika u setu ne prikazuje nijedan od 4 simptoma.

**Slike:** **nijedna, ni na jednoj od 4 stranice.** Sve je inline SVG linijska ilustracija (§6.3).
**Layout:** <600 jedna kolona, TOC zatvoren `<details>`, `.exam-strip` vertikalno; 600–899 uzroci 2 kolone, `.exam-strip` 2×2; ≥1200 sticky TOC rail levo + 720 px kolona.
**Animacije:** `fade-up` po sekcijama; `.answer-card` **se ne animira** (sadržaj iznad preloma mora biti odmah tu). Luk skale se iscrtava jednom.
**Schema:** `FAQPage` (3 pitanja, samo vidljiva) + `BreadcrumbList`.
**OG slika:** po jedna za svaku od 4 stranice (`seo.md` §6.2) — generiše se iz istog SVG šablona kao og-image (§9.3), bez telefona i adrese.

---

### 5.7 `/pitanja-i-odgovori/`

**Cilj:** jedna stranica koja hvata long-tail upite i služi kao referenca. 15 pitanja iz `seo.md` §7, grupisanih u 5 H2 sekcija.
**H1:** `Česta pitanja`

```
Putanja: POČETNA › PITANJA I ODGOVORI
┌ 1. UVOD + FILTER ──────────────────────────────────────────────────────┐
│ ⌾ PITANJA · h1 Česta pitanja · lead 1 rečenica                          │
│ ⌾ OBLAST  [Parodontologija] [Pregled] [Hirurgija i protetika]          │
│           [Estetska medicina] [Zakazivanje]                             │
│   → ovo su ANCHOR LINKOVI na H2 sekcije (rade bez JS-a), stil čip       │
└─────────────────────────────────────────────────────────────────────────┘
┌ 2–6. Pet H2 sekcija ───────────────── (--container-narrow 720 px) ─────┐
│ h2 Parodontologija ⌒                                                    │
│   10 × <details> akordeon (§4.9), svi zatvoreni                         │
│ h2 Pregled i terapija ⌒  (+ card--pending: NAČIN ZAKAZIVANJA)          │
│ h2 Oralna hirurgija i protetika ⌒                                       │
│ h2 Estetska medicina lica ⌒                                             │
│ h2 Zakazivanje i organizacija ⌒  → card--pending (§4.12)               │
└─────────────────────────────────────────────────────────────────────────┘
┌ 7. „Nema vašeg pitanja?“ (bg --primary-wash) ──────────────────────────┐
│ ≡ „Pitajte direktno.“ [ ◉ Pišite na Instagramu ]                        │
└─────────────────────────────────────────────────────────────────────────┘
┌ 8. MEDICINSKA NAPOMENA ────────────────────────────────────────────────┐
```
**Slike:** nijedna.
**Layout:** jedna kolona svuda; čipovi se prelome u 2 reda na telefonu; `sticky` čip traka na ≥900 px (`top: 72px`).
**Animacije:** samo `fade-up` na H2 sekcijama. Akordeoni se ne animiraju (native `<details>`).
**Schema:** `FAQPage` sa **svim** vidljivim pitanjima. Pravilo: pitanje markirano ovde **ne** sme biti markirano i na stranici usluge (`seo.md` §7) — Developer vodi listu u komentaru na vrhu fajla.

---

### 5.8 `/kontakt/` — stranica bez poznatih kontakt podataka

**Cilj:** pretvoriti nameru u kontakt **preko jedinog potvrđenog kanala (Instagram DM)**, a istovremeno izgledati kao dovršena stranica a ne kao formular koji je neko ostavio na pola.
**H1:** `Kontakt`
**Glavni CTA dok nema telefona:** **„Pišite na Instagramu“** → `https://www.instagram.com/dmd.nadabojic/`. To je jedini kanal potvrđen u `research.md` DEO A i `seo.md` §8.2/4. **Bez forme** — sajt je statičan, nema backend, a `mailto:` forma zahteva mejl koji nije poznat.

**Strategija da stranica ne deluje nedovršeno — tri poteza:**
1. **Redosled je obrnut od uobičajenog.** Prvo ide **ono što radi** („Kako se zakazuje“ + Instagram dugme), pa onda NAP blok. Posetilac prvo dobije rešenje, pa tek onda vidi polja u pripremi.
2. **Nepoznati podaci su jedna kompaktna kartica sa statusom** (§4.12), ne četiri prazna reda. Kartica ima naslov „Kontakt podaci“ i **jednu rečenicu objašnjenja**: „Ordinacija je u Beogradu. Precizni podaci se objavljuju po potvrdi.“ — Beograd je potvrđen podatak i on nosi lokalni signal.
3. **Mesto mape nosi tipografski blok**, ne sivi pravougaonik: veliki `BEOGRAD` u EB Garamond 500 preko `--primary-wash`, luk L2, mono labela `[MAPA — POTVRDITI ADRESU]`. Deluje kao namera, ne kao greška. `seo.md` §8.1 eksplicitno zabranjuje mapu druge lokacije.

```
Putanja: POČETNA › KONTAKT
┌ 1. UVOD ───────────────────────────────────────────────────────────────┐
│ ⌾ KONTAKT · h1 Kontakt                                                  │
│ lead: „Pregled se zakazuje porukom. Odgovor dobijate sa iste adrese.“   │
└─────────────────────────────────────────────────────────────────────────┘
┌ 2. h2 Zakazivanje pregleda ──── (bg --surface-alt, PRVA SEKCIJA) ──────┐
│ ⌾ KAKO SE ZAKAZUJE · ⌒                                                  │
│ □ 01 Pošaljete poruku   □ 02 Dogovor termina   □ 03 Dolazite na pregled │
│   [instagram] opis        [kalendar] opis        [sonda] opis           │
│                                                                          │
│ ┌──────────────── KANAL KOJI RADI (bg --primary, tamni) ──────────────┐ │
│ │ ⌾ INSTAGRAM · @dmd.nadabojic                                        │ │
│ │ h3 „Najbrži put do termina je poruka na Instagramu.“                │ │
│ │ [ ◉ btn--primary na tamnom = #FBF8F4 bg / --primary tekst:          │ │
│ │     „Pišite na Instagramu“ ]       ← GLAVNI CTA SAJTA               │ │
│ └─────────────────────────────────────────────────────────────────────┘ │
└─────────────────────────────────────────────────────────────────────────┘
┌ 3. h2 Kontakt podaci ───────────────────── (grid 2 kolone) ────────────┐
│ ⌒                                                                       │
│ ┌ POTVRĐENO ───────────────────┐ ┌ U PRIPREMI (card--pending) ───────┐ │
│ │ ⌾ ORDINACIJA                 │ │ ⌾ ADRESA      Objavljujemo po     │ │
│ │ Hope Dental                  │ │               potvrdi             │ │
│ │ ⌾ GRAD                       │ │ ⌾ TELEFON     —//—                │ │
│ │ Beograd                      │ │ ⌾ MEJL        —//—                │ │
│ │ ⌾ DOKTOR                     │ │ ⌾ RADNO VREME —//—                │ │
│ │ dr Nada Bojić                │ │ (isprekidana ivica, --surface-alt)│ │
│ │ ⌾ INSTAGRAM                  │ │ ⌾ [POTVRDITI SA KLIJENTOM] ×4     │ │
│ │ @dmd.nadabojic →             │ │   (DEMO:START…END, §4.12)         │ │
│ └──────────────────────────────┘ └───────────────────────────────────┘ │
│ ≡ „Hope Dental — naziv iz profila dr Nade Bojić. [POTVRDITI: pravni    │
│    naziv]“ (sitno, --muted, --fs-sm)                                    │
└─────────────────────────────────────────────────────────────────────────┘
┌ 4. h2 Radno vreme ─────────────────────────────────────────────────────┐
│ ⌒ · card--pending puna širina: tabela dana sa praznim kolonama? NE.     │
│   Jedan blok: ⌾ RADNO VREME / „Termini se dogovaraju porukom.“ /        │
│   „Raspored po danima objavljujemo po potvrdi.“ + [POTVRDITI]           │
│   [ODLUKA] Prazna tabela 7 dana × 2 kolone je najgorе moguće rešenje —  │
│   ona izgleda pokvareno. Jedna rečenica izgleda namerno.                │
└─────────────────────────────────────────────────────────────────────────┘
┌ 5. h2 Lokacija ────────────────────────────────── (bg --primary-wash) ─┐
│ ⌒                                                                       │
│ ┌──────────────────────────────────────────────────────────────────────┐│
│ │                                                                      ││
│ │            B E O G R A D        (EB Garamond 500, clamp 48–96px,     ││
│ │                                  --primary, ls .02em, centrirano)    ││
│ │           ╰──────── luk L2, 240 px, --accent ────────╯               ││
│ │        ⌾ [MAPA — POTVRDITI ADRESU]   (mono 13px, --warning)          ││
│ │  ≡ „Mapu i precizne instrukcije za dolazak objavljujemo po potvrdi   ││
│ │     adrese.“                                                         ││
│ │                                                                      ││
│ │  <!-- MAPA:START  ... ovde ide <iframe loading="lazy" title="…">     ││
│ │       posle potvrde adrese; click-to-load (seo.md §9)  MAPA:END -->  ││
│ └──────────────────────────────────────────────────────────────────────┘│
│   aspect-ratio 16:9 na desktopu / 4:3 na telefonu — zauzima ISTI prostor │
│   koji će mapa zauzeti, pa ubacivanje mape ne menja layout (CLS = 0)    │
│ ▰ ordinacija-01.webp — sitno, 240 px, desno dole, dekorativno (alt="")  │
└─────────────────────────────────────────────────────────────────────────┘
┌ 6. MEDICINSKA NAPOMENA + FOOTER ───────────────────────────────────────┐
```
**Slike:** `ordinacija-01.webp` (malo, dekorativno — jedina ambijentalna koja ostaje). **Fotografija ulaza ne postoji** (`NOTES` §6/4) — to je najveći nedostatak ove stranice i stoji u §9.3.
**Nema:** forme, `tel:`, `mailto:`, Google Maps embed-a, nijednog izmišljenog podatka.
**Layout:** <600 sve 1 kolona, redosled kao u wireframe-u; 600–899 sekcija 3 u 2 kolone, koraci 3 u redu; ≥900 kako je nacrtano, `--container` 1160 px.
**Animacija:** `fade-up`; tamni Instagram blok bez animacije (glavni CTA mora biti odmah tu).
**Schema:** `Dentist` (bez `address`, `telephone`, `openingHours`, `geo`) + `BreadcrumbList`.

---

### 5.9 `/politika-privatnosti/`

**Cilj:** pravna obaveza, `noindex`, nije u `sitemap.xml`.
**Layout:** `--container-narrow` 720 px, jedna kolona, H2/H3, bez slika, bez CTA sekcije (samo footer). Na vrhu `.card--note`: „Dokument se dopunjava po potvrdi podataka o rukovaocu i načinu obrade. [POTVRDITI]“. Sadržaj mora pokriti: nema forme → ne prikupljaju se podaci; nema analitike u demo režimu; spoljni linkovi (Instagram); fontovi su self-hostovani (nema zahteva ka Google-u); kolačići — nijedan dok nema analitike.
**Header/footer:** identični kao svuda. Breadcrumb: `POČETNA › POLITIKA PRIVATNOSTI`.

### 5.10 `/404.html`

```
⌾ GREŠKA 404
h1 Ova stranica ne postoji
lead: „Moguće je da je adresa pogrešno upisana.“
⌒ L2
□ Parodontopatija — vodič   □ Usluge   □ Kontakt
[ ◉ Na naslovnu ]
```
`noindex`. Bez slike. Centrirano u `--container-narrow` (jedina centrirana stranica na sajtu — i to je u redu, 404 je izuzetak).

---

## 6. `/usluge/estetska-medicina/` — stranica bez ijedne fotografije

**Problem:** `NOTES` §6/8 je nedvosmislen — *„Estetska medicina lica (botoks, fileri, PRP, skinbooster) je u bio-u kao usluga, a u materijalu nema nijedne slike za tu celu kategoriju.“* Uz to, `seo.md` §5.9 zabranjuje pre/posle bez saglasnosti, a `brand.md` §10 zabranjuje stock fotografije („jedna stock slika ruši sve“). Dakle: **nijedna fotografija, nijedan stock, nijedna ilustracija lica koja bi mogla da se pročita kao fotografija.**

**Odgovor:** stranica se gradi na **četiri teksture koje nisu fotografija**, i to je ujedno najkarakternija stranica sajta.

### 6.1 Četiri teksture

| # | Tekstura | Čemu služi |
|---|---|---|
| T1 | **Tipografski hero** — `h1` u EB Garamond na `clamp(2.5rem, 6vw, 4.5rem)`, preko punog `--primary` bloka visine 44vh, sa velikim lukom u `#E8B9AC` kao jedinim grafičkim elementom | zamenjuje hero fotografiju; prazan prostor je ovde *materijal*, ne nedostatak |
| T2 | **Dijagram postupka** — vodoravna lučna osa sa 4 koraka (konsultacija → procena → tretman → kontrola), inline SVG, isti jezik kao potpisni element | daje „ima se šta videti“ bez slike; ponavlja potpis sajta |
| T3 | **Linijske ilustracije** — 4 ilustracije po tretmanu, max 2 boje, `stroke 1.75`, **apstraktne i anatomski neutralne** (vidi 6.3) | ilustruje 4 tretmana bez prikazivanja lica |
| T4 | **Kartice sa gustim sadržajem** — svaka sa 5 mono-labeliranih redova (trajanje efekta, broj poseta, oporavak, ko nije kandidat, napomena) | gustina teksta je ono što zamenjuje slike; kartica puna podataka ne izgleda prazno |

### 6.2 Wireframe

```
Putanja: POČETNA › USLUGE › ESTETSKA MEDICINA LICA
┌ 1. TIPOGRAFSKI HERO ──── (bg --primary, visina 44vh, bez slike) ───────┐
│ ⌾ ESTETSKA MEDICINA  (mono, --accent-soft)                              │
│                                                                          │
│    Estetska                                                             │
│    medicina lica            (h1, EB Garamond 500, #FBF8F4,              │
│                              clamp(2.5rem, 6vw, 4.5rem), lh 1.05)      │
│                                                                          │
│    ╰───────── veliki luk, 320px, #E8B9AC, stroke 3 ─────────╯           │
│                                                                          │
│    ≡ lead (Inter 400, 19px, #E8DCD4): 2 rečenice                        │
│    [ ◉ ghost-dark: Zakažite konsultaciju ]                              │
└─────────────────────────────────────────────────────────────────────────┘
┌ 2. h2 Tretmani ──────────────────────────── (bg --bg) ─────────────────┐
│ ⌒ · 4 × kartica, grid 2×2 na ≥900, 1 kolona na telefonu                │
│ ┌────────────────────────────┐ ┌────────────────────────────┐          │
│ │ [SVG T3: igla + linije]    │ │ [SVG T3: kap + linije]     │          │
│ │ ⌾ 01 / BOTOKS              │ │ ⌾ 02 / HIJALURONSKI FILERI │          │
│ │ h3 Botoks              ⌒   │ │ h3 Hijaluronski fileri ⌒   │          │
│ │ ≡ 2–3 rečenice             │ │ ≡ 2–3 rečenice             │          │
│ │ ───────────── 1px border ──│ │ ──────────────────────────  │          │
│ │ ⌾ TRAJANJE EFEKTA  [POTV.] │ │ ⌾ TRAJANJE EFEKTA  [POTV.] │          │
│ │ ⌾ BROJ POSETA      [POTV.] │ │ ⌾ BROJ POSETA      [POTV.] │          │
│ │ ⌾ OPORAVAK         ≡       │ │ ⌾ OPORAVAK         ≡       │          │
│ │ ⌾ NIJE ZA           ≡      │ │ ⌾ NIJE ZA           ≡      │          │
│ └────────────────────────────┘ └────────────────────────────┘          │
│ ┌ 03 / PRP ──────────────────┐ ┌ 04 / SKINBOOSTER ──────────┐          │
│ └────────────────────────────┘ └────────────────────────────┘          │
│ [ODLUKA] Ilustracija zauzima gornjih 120 px kartice na --primary-wash   │
│ pozadini, pa kartica ima vizuelnu „glavu“ i ne izgleda kao samo tekst.  │
└─────────────────────────────────────────────────────────────────────────┘
┌ 3. h2 Kako teče konsultacija ─── (bg --surface-alt, DIJAGRAM T2) ──────┐
│ ⌒                                                                       │
│      ①                ②                ③                ④              │
│      ○────────────────○────────────────○────────────────○              │
│       ╰──────── luk, --accent, stroke 2.5, 100% ────────╯              │
│  KONSULTACIJA     PROCENA         TRETMAN         KONTROLA              │
│  ≡ 1 rečenica    ≡ 1 rečenica    ≡ 1 rečenica   ≡ 1 rečenica           │
│                                                                          │
│  ≡ „Konsultacija ne podrazumeva tretman.“ (card--note)                  │
└─────────────────────────────────────────────────────────────────────────┘
┌ 4. h2 Zašto kod stomatologa ─── (split: tekst 7/12 + veliki citat) ───┐
│ ⌒                                                                       │
│ ≡ 2 pasusa o anatomiji perioralne regije — BEZ poređenja sa drugim      │
│   profesijama (seo.md §5.9)                                             │
│ ┌ .pullquote (bg --accent-wash, --r-lg, border-left 3px --accent) ─────┐│
│ │ „Perioralna regija je područje u kom stomatolog radi svakodnevno.“   ││
│ │  EB Garamond 500, 26px, --text  (tekst na --accent-wash = 5.49:1)    ││
│ └──────────────────────────────────────────────────────────────────────┘│
│ ⌾ card--pending: EDUKACIJA I DOZVOLA ZA ESTETSKE INTERVENCIJE          │
│   [POTVRDITI] — seo.md §5.9 zabranjuje tvrdnju o sertifikatu dok se     │
│   ne potvrdi. Kartica stoji vidljivo, ne skriva problem.                │
└─────────────────────────────────────────────────────────────────────────┘
┌ 5. h2 Za koga tretman nije preporučljiv ──── (bg --primary-wash) ──────┐
│ ⌒ · list sa ikonom „info“ (NE sa X ikonom, NE crveno) · 5–7 stavki     │
│ ≡ „Procena je individualna i radi se na konsultaciji.“                  │
└─────────────────────────────────────────────────────────────────────────┘
┌ 6. MEDICINSKA NAPOMENA (§4.11) ────────────────────────────────────────┐
┌ 7. h2 Česta pitanja (3, iz seo.md §7 pitanja 13–15, FAQPage) ──────────┐
┌ 8. CTA (bg --primary) · [ ◉ Pišite na Instagramu ] ────────────────────┐
┌ 9. GALERIJA — gallery-entry (sakriveno prekidačem §7.4) ───────────────┐
│ ⌾ REZULTATI · [ Pre i posle → ]  — pojavljuje se SAMO kad prekidač     │
│   pređe u „on“ I kad za estetske slučajeve postoje saglasnosti          │
└─────────────────────────────────────────────────────────────────────────┘
```

### 6.3 Linijske ilustracije — specifikacija (inline SVG, bez fajlova)

Četiri tipa, svi: `viewBox="0 0 160 120"`, `fill="none"`, `stroke-width="1.75"`, `linecap/linejoin: round`, max 2 boje (`--primary` za liniju, `--accent` za jedan akcentni element), `aria-hidden="true"`, `role` nema. Teže < 1 KB svaka, inline u HTML-u (nema zahteva ka mreži).

| Tip | Sadržaj crteža | Gde |
|---|---|---|
| **A — botoks** | tri paralelne horizontalne linije koje se ka desnoj strani izglađuju u jednu; tanka igla pod 30° dodiruje srednju liniju | kartica 01 |
| **B — fileri** | prazan zaobljeni oblik koji se ispunjava: kontura + tri lučna sloja iznutra, gornji u `--accent` | kartica 02 |
| **C — PRP / skinbooster** | krug sa 7 tačaka raspoređenih po mreži (mikro-ubodi), jedan luk preko njih | kartice 03, 04 (varijacija u gustini tačaka) |
| **D — anatomski presek (simptomske stranice)** | dva stanja jedan pored drugog: levo zdrav parodoncijum (zub + luk gingive koji ga obgrljuje visoko), desno zahvaćen (isti zub, luk spušten, prostor označen `--accent` isprekidanom linijom). Labele JetBrains Mono 11 px. **Apstraktno, shematski, nije medicinska ilustracija i tako se i opisuje u `copy.md`.** | 4 simptomske stranice, `/usluge/parodontologija/` |

**Pravilo:** nijedna ilustracija ne prikazuje lice, oči, usne ni prepoznatljivu osobu. Nikakva ilustracija nema `alt` tekst sa medicinskom tvrdnjom — objašnjenje ide u vidljivi tekst ispod, ne u `alt`.

### 6.4 Zašto stranica ne deluje prazno — rezime u jednoj tabeli

| Rizik | Protivmera na stranici |
|---|---|
| „Nema slike, izgleda nedovršeno“ | 44vh pun `--primary` blok sa velikom serifnom tipografijom = jaka vizuelna masa bez slike |
| „Četiri kartice teksta, dosadno“ | Svaka kartica ima SVG „glavu“ na `--primary-wash` + 4 mono-labelirana reda podataka |
| „Nema čime da se ilustruje postupak“ | T2 dijagram — isti potpisni luk, 4 koraka, puna širina |
| „Nema socijalnog dokaza“ | `.pullquote` u `--accent-wash` nosi vizuelni akcenat koji bi inače nosila fotografija |
| „Previše belog prostora“ | 5 sekcija sa naizmeničnim pozadinama (`--primary` → `--bg` → `--surface-alt` → `--bg` → `--primary-wash` → `--primary`) — nijedne dve susedne iste (`brand.md` §7) |

---

## 7. Konverzija, prekidači, ponašanje

### 7.1 Glavni CTA

**Dok telefon nije potvrđen: „Pišite na Instagramu“** → `https://www.instagram.com/dmd.nadabojic/` (`target="_blank" rel="noopener"`, `aria-label="Pišite na Instagramu — @dmd.nadabojic (otvara se u novom tabu)"`).
**Po potvrdi telefona:** primarni CTA postaje `tel:`, Instagram se spušta u sekundarni. Zamena se radi na jednom mestu po stranici (blok `<!-- CTA:START --> … <!-- CTA:END -->`), 19 fajlova, jedna pretraga.

**Gde se CTA ponavlja (pravilo „jedno primarno dugme po ekranu“ iz `brand.md` §7):**

| Mesto | Naslovna | Usluga | Simptomska | Hub | Kontakt |
|---|---|---|---|---|---|
| Header (desktop) | ✔ | ✔ | ✔ | ✔ | ✔ |
| Sticky traka (mobilni) | ✔ | ✔ | ✔ | ✔ | ✔ |
| Hero | ✔ | ✔ | — (prvi ekran = odgovor, ne prodaja) | — | — |
| Posle 2. sekcije | — | — | ✔ (u `.card--note--urgent`) | — | — |
| Tamni blok pre footera | ✔ | ✔ | ✔ | ✔ | ✔ (gore) |
| Mobilni meni | ✔ | ✔ | ✔ | ✔ | ✔ |

Dakle: **3–4 pojave po stranici na mobilnom, nikad dve u istom vidnom polju.**

### 7.2 Sekundarni CTA-i (po nameri)
„Pročitajte vodič →“ (edukativna namera), „Kako teče terapija →“ (sa simptomske na uslugu — obavezan po `seo.md` §5.17/1), „Više o meni →“ (poverenje).

### 7.3 Kanali — status
| Kanal | Status | Upotreba |
|---|---|---|
| Instagram DM | **POTVRĐEN** (`research.md` DEO A) | glavni CTA |
| Telefon | nepoznat | `.card--pending`, `<button>` + `<details>`, **nikad `tel:`** |
| Mejl | nepoznat | `.card--pending`, **nikad `mailto:`** |
| Forma | nema backend | **ne postoji na sajtu** |
| Viber / WhatsApp | nepoznat | ne pominje se |

### 7.4 Prekidač galerije — „jedan potez“

U **jednom deljenom fajlu** `assets/css/site.css`, na samom početku:

```css
/* ══════════════════════════════════════════════════════════════════════
   PREKIDAČ PRE/POSLE GALERIJE  —  JEDAN POTEZ
   ISKLJUČENO (podrazumevano): galerija se ne vidi nigde na sajtu.
   UKLJUČIVANJE: zameni vrednosti u sledeća dva reda (zamene su označene).
   Uključiti SAMO kad postoje pisane saglasnosti pacijenata za svih 7
   slučajeva (Assets/NOTES.md §5).
   ══════════════════════════════════════════════════════════════════════ */
:root {
  --gallery-entry-display: none;      /* uključeno → contents  */
  --gallery-page-display:  none;      /* uključeno → block     */
  --gallery-lock-display:  block;     /* uključeno → none      */
}
.gallery-entry  { display: var(--gallery-entry-display); }
.gallery-page   { display: var(--gallery-page-display); }
.gallery-locked { display: var(--gallery-lock-display); }
```

- **`.gallery-entry`** nosi svaki ulazni link ka `/rezultati/` — tačno **4 mesta**: footer (kolona „Parodontopatija“ dobija 5. stavku), `/usluge/protetika/` sekcija 9, `/usluge/estetska-medicina/` sekcija 9, `/usluge/parodontoloska-hirurgija/` sekcija 9. Developer ne sme da doda peti ulaz bez upisa u ovu listu.
- **`/rezultati/index.html`** ima dva bloka: `.gallery-page` (cela galerija) i `.gallery-locked` (poruka „Sekcija sa rezultatima biće objavljena po pribavljanju saglasnosti pacijenata. [POTVRDITI]“ + linkovi na usluge). Direktan pristup URL-u dok je prekidač `off` daje smislenu stranicu, ne prazan ekran.
- **Dok je `off`:** `/rezultati/` nosi `<meta name="robots" content="noindex, nofollow">` i **nije** u `sitemap.xml`. Pri uključivanju se briše `noindex`, dodaje URL u sitemap i stranica postaje 17. indeksabilna.
- **Zašto CSS varijabla, a ne JS flag:** radi bez JS-a, radi bez build koraka, i menja se na **jednom mestu za ceo sajt** jer je CSS fajl deljen — što HTML (bez include-a) nije.
- **Dodatna zaštita:** dok je prekidač `off`, slike `ba-*.webp` se **ne referenciraju** nijednim `<img src>` nego `<img data-src>` + `<noscript>` fallback? **Ne** — to bi ih sakrilo od posetioca bez JS-a i prekršilo pravilo „sadržaj nikad nevidljiv bez JS-a“. Umesto toga: `display: none` na kontejneru je dovoljno za vizuelno sakrivanje, a **pravna zaštita je `noindex` + nepostojanje ulaznog linka**. Ako je potrebna stroža zaštita do dolaska saglasnosti, Developer premešta `rezultati/` folder izvan `site/` — to je drugi, grublji potez i opisan je u `/rezultati/index.html` u komentaru.

### 7.5 `/rezultati/` — wireframe (isključena stranica)

**H1:** `Pre i posle` · **title/description:** nisu u `seo.md` v2 (stranica nije planirana) → Copywriter ih piše pri uključivanju, uz `noindex` do tada.

```
Putanja: POČETNA › PRE I POSLE
┌ .gallery-locked  (vidi se dok je prekidač OFF) ────────────────────────┐
│ ⌾ U PRIPREMI                                                           │
│ h1 Pre i posle                                                          │
│ card--note: „Prikaz rezultata objavljujemo po pribavljanju pisanih      │
│ saglasnosti pacijenata. [POTVRDITI SA KLIJENTOM]“                       │
│ [ Usluge → ] [ Parodontopatija → ]                                      │
└─────────────────────────────────────────────────────────────────────────┘
┌ .gallery-page  (vidi se kad je prekidač ON) ───────────────────────────┐
│ ⌾ REZULTATI · h1 Pre i posle · lead 2 rečenice                          │
│ card--note: zakonska/etička napomena (ceo tekst iz brand.md §8)         │
│                                                                          │
│ ⌾ KATEGORIJA   ( )Svi 7  ( )Estetika 3  ( )Protetika 3  ( )Hirurgija 1 │
│   (sticky top:72px na ≥900; bez JS-a = anchor skok na H2 sekcije)       │
│                                                                          │
│ h2 Estetika (#estetika) ⌒                                               │
│   □ .card--case  SLUČAJ 01  →  ba-estetika-01-pre / -posle              │
│   □ .card--case  SLUČAJ 02  →  ba-estetika-02-pre / -posle              │
│   □ .card--case  SLUČAJ 03  →  ba-estetika-03-pre / -posle              │
│ h2 Protetika (#protetika) ⌒                                             │
│   □ SLUČAJ 04 → ba-protetika-01-*   □ 05 → ba-protetika-02-*            │
│   □ SLUČAJ 06 → ba-protetika-03-*                                       │
│ h2 Hirurgija (#hirurgija) ⌒                                             │
│   □ SLUČAJ 07 → ba-hirurgija-01-*  (+ napomena: „stanje odmah nakon     │
│     operacije, sa privremenim zubima“ — iz alt teksta u manifestu)      │
│                                                                          │
│ ───── luk L2 ─────                                                      │
│ ≡ sekcijska napomena o saglasnosti (brand.md §8, doslovno)               │
│ [ ◉ Pišite na Instagramu ]                                              │
└─────────────────────────────────────────────────────────────────────────┘
```
**Svaki `.card--case` sadrži, obavezno i vidljivo:** mono eyebrow `KATEGORIJA · SLUČAJ NN` → `h3` naziv intervencije → pre/posle komponenta (§4.10) → `Trajanje terapije: [POTVRDITI]` → jedna rečenica o složenosti slučaja → **`⌾ Objavljeno uz pismenu saglasnost pacijenta. [POTVRDITI]`** (mono labela + tekst, `--muted`, `--fs-sm`, ikona `info` 16 px). Ako za neki slučaj saglasnost ne stigne, **briše se cela `.card--case`**, ne samo napomena — i brojevi u filteru se ažuriraju ručno.
**Kadriranje:** `brand.md` §8 nalaže prekadriranje `ba-estetika-02-*` i `ba-estetika-03-*` (prikazuju usne i deo brade). `NOTES` §2 isto: „ako klijent nema saglasnost, ove dve prvo izbaciti“. Developer koristi `object-fit: cover` + `object-position` da ih stisne na usta — ali **to nije zamena za pravo prekadriranje** i upisano je u §9.3.
**Layout:** <600 slučajevi 1 kolona, pre/posle slike jedna pod drugom (ili klizač punom širinom); 600–899 1 kolona, slike jedna pored druge; ≥900 slučajevi 1 kolona ali širine 860 px (slučaj je dokument, ne thumbnail — **ne** mreža 3×3).
**Animacije:** nijedna osim `fade-up` na kartici. Klizač bez tranzicija (§4.10).

### 7.6 Animacije — pravilo koje se ne krši

> **Sadržaj nikada ne sme biti nevidljiv bez JS-a.**

Implementacija:
```css
/* podrazumevano: sve je vidljivo */
.reveal { opacity: 1; transform: none; }

/* skrivanje se aktivira SAMO ako je JS dodao klasu na <html> */
html.js-reveal .reveal        { opacity: 0; transform: translateY(16px);
                                transition: opacity 400ms var(--ease),
                                            transform 400ms var(--ease); }
html.js-reveal .reveal.is-in  { opacity: 1; transform: none; }

@media (prefers-reduced-motion: reduce) {
  html.js-reveal .reveal { opacity: 1; transform: none; transition: none; }
}
```
`reveal.js` kao **prvu** radnju dodaje `js-reveal` na `<html>`, pa IntersectionObserver (`rootMargin: "0px 0px -10% 0px"`, `threshold: 0.1`) dodaje `.is-in`. Ako JS padne, skripta nije učitana, ili je `prefers-reduced-motion` — sve je vidljivo. Stagger 60 ms preko `transition-delay: calc(var(--i) * 60ms)` sa `--i` u inline `style` (ne JS).

**Šta se animira:** sekcije (`fade-up` 16 px), kartice (stagger), luk skale faza (jednokratno iscrtavanje), hover stanja dugmadi i kartica.
**Šta se ne animira nikad:** hero (LCP), `.answer-card` na simptomskim stranicama, Instagram CTA blok, klinične fotografije u `<details>`, pre/posle klizač, `<details>` otvaranje.
**Zabranjeno (`brand.md` §7):** paralaksa, auto-play karusel, brojači, animirani zubi, bilo šta na skrol-poziciji vezano `transform` na slikama.

### 7.7 Responzivnost — breakpointi i šta se sklapa

Mobile-first; `min-width` media query-ji.

| Breakpoint | Širina | Grid | Šta se menja |
|---|---|---|---|
| **S** (osnovni) | 0–599 | 1 kolona, `--gutter` 16 px | mobilni meni; sticky CTA traka; TOC kao `<details>`; lučna skala **vertikalna**; hero slika iznad teksta; footer 1 kolona; pre/posle slike jedna pod drugom; podnaslov logotipa skriven <400 px |
| **M** | 600–899 | 2 kolone, `--gutter` 24 px | kartice 2 u redu; koraci 2×2; lučna skala horizontalna bez opisa pod tačkama; footer 2 kolone; mobilni meni i sticky CTA **još uvek aktivni** |
| **L** | 900–1199 | 12-kolonski grid, `--container` 1160 | desktop nav + `Usluge ▾` disclosure; sticky CTA traka i mobilni meni **isključeni**; hero split; kartice 3 u redu; koraci 4 u redu; footer 4 kolone; filter galerije sticky |
| **XL** | ≥1200 | 12 kolona + levi rail | sticky TOC rail na stranicama usluga i simptoma; hero slika full-bleed levo; slike izlaze iz tekstualne kolone asimetrično; lučna skala u punoj varijanti |

**Šta se skriva (nikad sadržaj, samo dekoracija i duplikati):**
- `<400 px`: podnaslov logotipa, SVG luk skale (zamenjen vertikalnom linijom).
- `<600 px`: opisne rečenice pod tačkama skale faza — **ne brišu se**, prebacuju se u `.card--symptom` sekciju koja na telefonu dolazi odmah ispod (isti tekst, jedno mesto u HTML-u, ne duplirano).
- `<900 px`: desktop nav (zamenjen mobilnim menijem — isti linkovi).
- `≥900 px`: sticky CTA traka (CTA je u headeru).
- `ordinacija-01.webp` na `/kontakt/`: `display: none` ispod 600 px (dekorativna, oduzima prostor).

**Tap ciljevi:** min 44×44 px. Dugmad 52 px visine na mobilnom. Range input pre/posle klizača: 44 px visine tap zone (`height: 44px`, thumb 28 px).

---

## 8. Mapa teksta i eyebrow labela (za Copywritera)

Copywriter piše `copy.md` **po ovoj tabeli**; ID je `data-copy` atribut u HTML-u da se tekst može mapirati bez pogađanja.

| Stranica | Sekcija | ID | Eyebrow (mono) | Šta treba napisati |
|---|---|---|---|---|
| `/` | hero | `home.hero` | `PARODONTOLOGIJA · BEOGRAD` | h1 iz `seo.md` §5.1 + lead 2 rečenice |
| `/` | simptomi | `home.symptoms` | `SIMPTOMI` | h2 + 4 kartice × (naslov 4–6 reči + 1 rečenica) + 4 labele faza |
| `/` | usluge | `home.services` | `USLUGE` | h2 + 6 × (naslov + 1 rečenica) |
| `/` | o meni | `home.about` | `O MENI` | h2 + 3–4 rečenice (citat titule) |
| `/` | prvi pregled | `home.firstvisit` | `PRVI PREGLED` | h2 + 3 koraka × (naslov + 1 rečenica) |
| `/` | FAQ | `home.faq` | `PITANJA` | 4 pitanja + odgovori (3–4 rečenice) |
| `/` | kontakt | `home.contact` | `KONTAKT` | h2 + 1 rečenica + tekst za `.card--pending` |
| `/o-meni/` | 6 sekcija | `about.*` | `O MENI`, `OBRAZOVANJE`, `OBLASTI RADA`, `PRISTUP`, `EDUKACIJE`, `ZAKAZIVANJE` | po `seo.md` §5.2; titula se **citira** |
| `/usluge/` | hub | `services.*` | `USLUGE`, `01`–`06`, `VODIČ` | 6 × (h2 + 2–3 rečenice) |
| 5 stranica usluga | po §5.4 | `svc.<slug>.*` | `USLUGA`, `NA OVOJ STRANICI`, `KAKO TEČE TERAPIJA`, `POVEZANO`, `PITANJA`, `ZAKAZIVANJE` | H2/H3 skelet iz `seo.md` §5.4–5.8, doslovno |
| `/usluge/estetska-medicina/` | po §6.2 | `svc.estetika.*` | `ESTETSKA MEDICINA`, `01`–`04`, `KONSULTACIJA`, `PITANJA` | 4 tretmana × (3 rečenice + 4 mono reda) + pullquote |
| `/parodontopatija/` | po §5.5 | `perio.*` | `VODIČ ZA PACIJENTE`, `FAZE`, `SIMPTOMI`, `RIZIK`, `KADA DOĆI` | h2 skelet iz `seo.md` §5.10 + 4 opisa faza po 1 rečenici |
| 4 simptomske | po §5.6 | `sym.<slug>.*` | `SIMPTOM`, `KRATAK ODGOVOR`, `NA OVOJ STRANICI`, `NE ČEKAJTE AKO`, `SRODNO`, `PITANJA`, `ZAKAZIVANJE` | 900–1400 reči, H2 skelet zaključan, `.answer-card` 2–3 rečenice |
| `/pitanja-i-odgovori/` | 5 sekcija | `faq.*` | `PITANJA`, `OBLAST` | 15 pitanja iz `seo.md` §7 |
| `/kontakt/` | po §5.8 | `contact.*` | `KONTAKT`, `KAKO SE ZAKAZUJE`, `INSTAGRAM`, `RADNO VREME`, `LOKACIJA` | 3 koraka + tekstovi `.card--pending` |
| `/rezultati/` | po §7.5 | `cases.*` | `REZULTATI`, `KATEGORIJA`, `SLUČAJ NN` | 7 × (naziv intervencije + 1 rečenica o složenosti) |

**Zabrane za Copywritera** (iz `seo.md` §0 i `brand.md` §10): bez „najbolji / vodeći / broj 1“, bez obećanja ishoda, bez „bezbolno“ kao garancije, bez cena, bez poređenja sa konkurencijom po imenu, bez emodžija, bez uzvičnika, bez „neverovatna transformacija“. Reč „specijalista“ samo kao citat iz bio-a.

---

## 9. Mapa slika

### 9.1 Tabela — fajl → mesto → odnos → namena

Svi fajlovi iz `Assets/manifest.md`, putanja `site/assets/img/`. **Nijedan drugi fajl ne postoji i ne sme se referencirati.**

| Fajl | Stranica / sekcija | Odnos | Namena | Učitavanje |
|---|---|---|---|---|
| `hero.webp` | `/` → hero (1) | 3:2 (1440×960) | jedina hero slika na sajtu; tekst **gore desno** (mirna zona po manifestu); donja ivica = luk L3 | `eager`, `fetchpriority="high"`, ≤180 KB |
| `ordinacija-01.webp` | `/o-meni/` → „Pristup pacijentu“ (4); `/kontakt/` → „Lokacija“ (5) | 3:4 (785×1008) | ambijent, **max 280 px širine** (bokeh/neoštra, `NOTES` §4); dekorativna `alt=""` | lazy |
| `ordinacija-02.webp` | `/usluge/parodontologija/` → „Šta je parodontopatija“ | 1:1 (1000×1000) | model vilice = edukativni rekvizit, zamena za anatomsku ilustraciju | lazy |
| `doktor-portret.webp` | `/o-meni/` → uvod (1) | 4:5 (1000×1250) | glavni portret; max 800 px širine na mobilnom (`seo.md` §9) | lazy |
| `doktor-portret-kvadrat.webp` | `/` → „Dr Nada Bojić“ (4) | 1:1 (1000×1000) | lice lekara visoko na naslovnoj (lični brend) | lazy |
| `proces-instrumenti.webp` | `/usluge/parodontoloska-hirurgija/`; `/usluge/oralna-hirurgija/` | 1:1 (1000×1000) | sterilnost i priprema — nosi poverenje bez prikaza intervencije | lazy |
| `proces-rtg.webp` | `/` → „Kako izgleda prvi pregled“ (5); `/usluge/parodontologija/` → „Pregled i parodontalni status“ | 4:3 (1000×781) | dijagnostika; **saglasnost pacijenta potrebna** (`NOTES` §5 — RTG je medicinski podatak) | lazy |
| `proces-hirurgija.webp` | `/usluge/oralna-hirurgija/` → „Zahvati koje radimo“ | 3:2 (953×635) | rad u timu; lice pacijenta nije prepoznatljivo (`NOTES` §2); **saglasnost potrebna** | lazy |
| `detalj-implant.webp` | `/usluge/oralna-hirurgija/` → `<details>` „Prikaži kliničke fotografije“ | 4:5 (720×900) | klinički snimak, **zatvoreno po defaultu**, max 480 px (mutan); **saglasnost potrebna** | lazy |
| `osmeh-rezultat.webp` | `/usluge/protetika/` → „Vrste fiksnih nadoknada“ | 4:5 (1000×1250) | rezultat protetske terapije; **saglasnost potrebna** | lazy |
| `ba-estetika-01-pre` / `-posle` | `/rezultati/` → Estetika, slučaj 01 | 1000×672 (identične) | pre/posle klizač | lazy, prekidač OFF |
| `ba-estetika-02-pre` / `-posle` | `/rezultati/` → slučaj 02 | 1000×630 | isto; **traži prekadriranje** (vidi se brada/usne) | lazy, OFF |
| `ba-estetika-03-pre` / `-posle` | `/rezultati/` → slučaj 03 | 779×651 | isto; **traži prekadriranje** | lazy, OFF |
| `ba-protetika-01-pre` / `-posle` | `/rezultati/` → Protetika, slučaj 04 | 992×720 | pre/posle klizač | lazy, OFF |
| `ba-protetika-02-pre` / `-posle` | `/rezultati/` → slučaj 05 | 1000×504 | isto | lazy, OFF |
| `ba-protetika-03-pre` / `-posle` | `/rezultati/` → slučaj 06 | 1000×470 | isto | lazy, OFF |
| `ba-hirurgija-01-pre` / `-posle` | `/rezultati/` → Hirurgija, slučaj 07 | 811×516 | isto; obavezna napomena „odmah nakon operacije, privremeni zubi“ | lazy, OFF |
| `ba-estetika-01..03.webp`, `ba-protetika-01..03.webp`, `ba-hirurgija-01.webp` (spojene) | `/rezultati/` — **fallback** ako klizač/par ne radi | ~1:1 / 3:4 | rezerva; žig i oznake su u slici | lazy, OFF |
| `favicon.svg`, `favicon-32.png`, `favicon-16.png`, `apple-touch-icon.png` | sve stranice | 1:1 | po `brand.md` §6 (favicon-16 **bez luka**) | — |

**Stranice koje svesno ne koriste nijednu fotografiju:** `/usluge/`, `/usluge/oralna-medicina/`, `/usluge/estetska-medicina/`, `/parodontopatija/`, sve 4 simptomske, `/pitanja-i-odgovori/`, `/politika-privatnosti/`, `/404.html`. To je **9 od 17 stranica** — zato su tipografija, luk i inline SVG nosivi, a ne dekorativni elementi ovog sajta.

### 9.2 Tehnička pravila za sve slike (`seo.md` §9)
`<picture>` sa AVIF → WebP → JPG nije moguć (postoji samo WebP) → koristi se `<img src="*.webp">` sa `width`/`height` atributima, `decoding="async"`, `loading="lazy"` (osim heroja), `object-fit: cover`, fiksni `aspect-ratio` po tipu. `srcset` se **ne pravi** — izvori su 720–1440 px i smanjene varijante bi tražile build korak; umesto toga `max-width` u CSS-u i `sizes`-neutralan pristup. Hero ≤180 KB, ostale ≤100 KB (manifest: 31 fajl ≈ 1,5 MB ukupno — prosečno ~48 KB, u budžetu).

### 9.3 Gde slika FALI — i čime se nedostatak pokriva

| # | Nedostaje | Pogođeno mesto | Rešenje u ovoj strukturi | Status |
|---|---|---|---|---|
| 1 | **Portret bez maske i kape** (postoji samo selfi u hirurškoj maski) | `/o-meni/` uvod, `/` sekcija 4 | Koristi se `doktor-portret.webp` kakav je; uz njega `.card--pending` „PORTRET — u pripremi“. Lični brend bez vidljivog lica je **ozbiljan nedostatak konverzije** (`NOTES` §6/2) | **blokira finalnu verziju** |
| 2 | **Horizontalna oštra fotografija ordinacije** | hero, `/o-meni/`, `/kontakt/` | Hero je krop kvadrata u 3:2 (`hero.webp`); split layout tako da slika ne mora biti 16:9; `ordinacija-01` samo sitno | **blokira finalnu verziju** |
| 3 | **Fotografija ulaza / table** | `/kontakt/` → Lokacija | Tipografski blok `BEOGRAD` + luk + `[MAPA — POTVRDITI ADRESU]` (§5.8/3) | blokira lokalni SEO zajedno sa adresom |
| 4 | **Estetska medicina lica — 0 fotografija za celu kategoriju** | `/usluge/estetska-medicina/` cela stranica | Četiri teksture iz §6: tipografski `--primary` hero, lučni dijagram postupka, 4 linijske SVG ilustracije, kartice sa 4 mono-labelirana reda podataka | **rešeno dizajnom**, ne blokira |
| 5 | **Simptomi (krvarenje, povlačenje, upala, klimavi zubi) — 0 fotografija** | 4 simptomske stranice + `/parodontopatija/` | Inline SVG ilustracija tip D (§6.3) + lučna skala faza + `.answer-card` + `.exam-strip` | **rešeno dizajnom**, i poželjno: fotografija simptoma bi plašila |
| 6 | **Čekaonica, recepcija, sterilizacija, rendgen aparat kao celina** | `/o-meni/` „Pristup“, `/kontakt/` | Ne koristi se; prostor nosi tamni `--primary` blok sa tekstom | nije blokirajuće |
| 7 | **Tim** | nijedna stranica ne tvrdi da tim postoji | Celo tekstualno rešenje je u prvom licu jednine; `proces-hirurgija.webp` se opisuje neutralno („dva člana tima“ iz alt-a manifesta) i **ne tvrdi se ništa o timu** | `[POTVRDITI]` |
| 8 | **Logo** | header, footer, favicon, og-image | Inline SVG „gingivalni zagrljaj“ iz `brand.md` §6 — **nacrtan i proveren renderom**, nije fotografija pa ga nema u ovoj tabeli; ostaje `[POTVRDITI SA KLIJENTOM]` | predlog, čeka odobrenje |
| 9 | **og-image 1200×630** | `<meta property="og:image">` na svih 16 stranica + 4 posebne za simptomske | **Fajl ne postoji.** Developer ga generiše iz SVG šablona po `brand.md` §6 (pun `--primary`, vertikalni logotip, `PARODONTOLOG · BEOGRAD` u mono) → `assets/img/og-default.png` + `og-sym-<slug>.png` ×4. **Bez telefona i adrese.** Dok ne postoji, `og:image` se **izostavlja** (bolje nego 404 slika) | **treba napraviti** |
| 10 | **Prekadrirane verzije `ba-estetika-02` i `ba-estetika-03`** | `/rezultati/` slučajevi 02, 03 | `object-position` krop u CSS-u je privremeno; pravi krop na usta je obavezan pre uključivanja galerije (`brand.md` §8, `NOTES` §2) | **blokira uključivanje galerije** |

---

## 10. Checklist pre predaje Developeru

| # | Provera |
|---|---|
| 1 | 19 HTML fajlova (16 indeksabilnih + privatnost + 404 + rezultati), header/footer identični u svima |
| 2 | Tačno jedan `<h1>` po stranici; H2/H3 doslovno po `seo.md` §5 |
| 3 | Nijedan `tel:`, `mailto:`, nijedna adresa, nijedna cena, nijedan domen osim relativnih URL-ova / `https://PLACEHOLDER-DOMEN` |
| 4 | `<meta name="robots" content="noindex, nofollow">` na svakoj stranici (demo režim) + `robots.txt` = `Disallow: /` |
| 5 | Svaki `[POTVRDITI]` u `<!-- DEMO:START -->…<!-- DEMO:END -->` i vidljiv klijentkinji |
| 6 | Prekidač galerije u `off`; `/rezultati/` `noindex`; 0 ulaznih linkova vidljivo; `ba-*.webp` nigde vidljivo |
| 7 | Svaka slika: `width`, `height`, `loading`, `decoding`, `alt` iz manifesta (dekorativne `alt=""`) |
| 8 | Nijedna referenca na fajl koji nije u `Assets/manifest.md` |
| 9 | Sadržaj vidljiv sa isključenim JS-om na svih 19 stranica (test: `javascript.enabled=false`) |
| 10 | Tastatura: `Tab` kroz ceo header, mobilni meni, `Usluge ▾`, sve `<details>`, pre/posle range input; `Esc` zatvara meni; fokus vidljiv svuda |
| 11 | `prefers-reduced-motion: reduce` — nijedna animacija ne radi |
| 12 | Kontrasti po `brand.md` §3; `--accent` nigde kao boja teksta; na `--accent` pozadini `--text`, ne belo; inputi `--border-strong` |
| 13 | Eyebrow (mono) na svakoj sekciji; luk L1 pod svakim `h2` |
| 14 | Potpisni element (§3.2) na tačno 6 stranica |
| 15 | Medicinska napomena (§4.11) u telu svake stranice usluge i svake simptomske stranice |
| 16 | `FAQPage` samo sa vidljivim pitanjima; nijedno pitanje markirano dvaput |
| 17 | 4 `woff2` fajla, self-hostovana, `font-display: swap`, preload primarnog |
| 18 | `sitemap.xml` = 16 URL-ova (bez `/rezultati/`, bez `/politika-privatnosti/`) |
