# Struktura sajta: Dental Studio Mijušković, Nikšić

**Autor:** site-architect · **Datum:** 12. oktobar 2026.
**Ulaz:** `research.md`, `brand.md`, `seo.md`, `image-shortlist.md`. Fajl `assets/manifest.md` još ne postoji jer slike nisu obrađene, pa su sve slike ispod **placeholderi sa unapred određenim imenima fajlova**.
**Tehnologija:** čist HTML/CSS/JS, bez framework-a i build koraka. Copywriter i developer rade po ovom dokumentu.

---

## 0. Ključne odluke ukratko

| Odluka | Izbor | Zašto |
|---|---|---|
| Tip sajta | **Više stranica (9)** | `seo.md` traži posebne stranice za 4 high-ticket usluge (lumineeri, protetika, implanti, izbeljivanje) sa sopstvenim ključnim rečima, plus O nama, Rezultati i Kontakt. |
| Kompozicija | Mnogo vazduha, velike fotografije, uske kolone teksta, mineralne svetle površine i jedna tamna petrolej sekcija po stranici | Brend je „mineralno-mediteranski“: porcelan, svetlost, preciznost. Nije klinički hladan, a nije ni zlatno-crni luksuz. |
| Glavni CTA | **„Pozovite: 067 440 414“** (`tel:+38267440414`) | Publika 40–65 godina i lokalni pacijenti najčešće zovu. Viber i WhatsApp su odmah pored kao sekundarni kanali. |
| Potpisni element | **„Ključ boja“**: navigacija i filteri u obliku stomatoloških pločica za određivanje nijanse | Vidi odeljak 2. Element je izveden iz zanata (shade matching, keramika) i nema ga nijedan konkurent. |
| Dokaz | Pre/posle klizač i specijalistički status doktora | Prave recenzije, ocene i broj pacijenata **ne izmišljamo** (pravilo iz `seo.md`). |

---

## 1. Sitemap

```
/                         Početna                (H1: stomatolog Nikšić + ime ordinacije)
├── /o-nama/              Dr Žarko Mijušković, tim i ordinacija
├── /usluge/              Pregled svih usluga (4 istaknute + ostale)
│   ├── /usluge/lumineeri/     Lumineeri i keramičke fasete   (hero usluga)
│   ├── /usluge/protetika/     Cirkonijum, E.max, mostovi, rad na implantima
│   ├── /usluge/implanti/      Zubni implanti, All-on-4 / All-on-6
│   └── /usluge/izbeljivanje/  Ordinacijsko i kućno izbeljivanje
├── /rezultati/           Galerija pre/posle sa filterom
└── /kontakt/             Telefoni, Viber/WhatsApp, mapa, dolazak iz drugih gradova
```

**Fajlovi za developera:**
```
index.html
o-nama/index.html
usluge/index.html
usluge/lumineeri/index.html
usluge/protetika/index.html
usluge/implanti/index.html
usluge/izbeljivanje/index.html
rezultati/index.html
kontakt/index.html
assets/css/style.css
assets/js/main.js
assets/img/            ← svi .webp fajlovi iz „Mape slika“
robots.txt  sitemap.xml
```
- Putanje su **relativne** (`../../assets/img/...`), da bi sajt radio i lokalno i na bilo kom hostu.
- Ortodoncija, endodoncija, preventiva i dečja stomatologija **nemaju svoje stranice**, jer ih nema u URL strukturi iz `seo.md`. Pokrivene su blokom „Kompletna stomatološka nega“ na `/usluge/`.

**Interno povezivanje (`seo.md`):** početna linkuje na sve 4 usluge. Svaka usluga linkuje na `/rezultati/` (sa filterom te usluge, npr. `/rezultati/#lumineeri`) i na `/kontakt/`. Rezultati linkuju nazad na usluge.

---

## 2. Potpisni element: „Ključ boja“ (shade guide)

Stomatolog određuje nijansu keramike pomoću ključa boja, niza izduženih porcelanskih pločica sa drškom. Taj predmet postaje vizuelni motiv sajta:

- **Oblik pločice:** uski vertikalni element, gornji deo („drška“) je traka u `--c-primary` (#0B3B46) sa malom oznakom (npr. `L1`, `P2`, `I3`, `B4`), a donji deo („zub“) ima zaobljeno dno (`border-radius: 6px 6px 40% 40% / 6px 6px 28% 28%`) i suptilan gradijent od `#FFFFFF` do `#EEF7F6`, sa unutrašnjim sjajem u `--c-mint` pri hoveru (translucencija).
- **Gde se koristi:**
  1. **Početna, sekcija Usluge:** 4 usluge su 4 pločice u redu (desktop), a hover „izvlači“ pločicu iz držača (`translateY(-10px)`, jača senka).
  2. **`/rezultati/`:** filter galerije (Sve · Lumineeri · Protetika · Implanti · Izbeljivanje) je red mini pločica, a aktivna pločica je „izvučena“ i ima mint ivicu.
  3. **Pod-navigacija na stranicama usluga:** traka sa 4 mini pločice ispod hero dela služi za skok na drugu uslugu.
  4. **Mikro-detalj:** iznad H2 naslova stoji eyebrow oznaka u obliku male pločice (npr. `L1 · Lumineeri`).
- **Oznake su kodovi sajta, ne prave VITA nijanse:** L = lumineeri, P = protetika, I = implanti, B = beljenje. Ne tvrdimo ništa medicinski.
- **Implementacija:** samo HTML/CSS. Pločica je `<a class="shade-tab">` sa `<span class="shade-tab__neck">L1</span><span class="shade-tab__tooth">Lumineeri</span>`. Bez slika, pa ne zavisi od asseta.
- **Pristupačnost:** filteri su `<button aria-pressed>`, a fokus prsten je mint, 2px offset.

Prateći element (nije potpisni, ali je važan): **pre/posle klizač** sa vertikalnom „staklenom“ linijom (frosted glass, `backdrop-filter: blur(8px)`) i ručicom u obliku male pločice ključa boja. Tako se motiv ponavlja i u galeriji.

---

## 3. Globalne komponente

### 3.1 Header (sticky)
```
┌────────────────────────────────────────────────────────────────────────┐
│ [logo.webp | wordmark]   Usluge ▾  Rezultati  O nama  Kontakt  [📞 067 440 414] │
└────────────────────────────────────────────────────────────────────────┘
```
- Visina je 76px na vrhu stranice i 64px posle skrola, kada dobija belu podlogu 85% + `backdrop-filter: blur(12px)`, donju liniju `--c-border` i `--shadow-sm`. Na vrhu je proziran, preko svetlog hero dela.
- **„Usluge ▾“** otvara mali dropdown (desktop, hover i klik) sa 4 usluge i linkom „Sve usluge“. Na mobilnom je to harmonika u meniju.
- **Logo i fallback:**
  - Podrazumevano se uvek renderuje **tekstualni wordmark**:
    ```html
    <a class="brand" href="/" aria-label="Dental Studio Mijušković, početna">
      <img class="brand__logo" src="assets/img/logo.webp" alt="" width="180" height="48" hidden>
      <span class="brand__word"><small>DENTAL STUDIO</small><strong>Mijušković</strong></span>
    </a>
    ```
  - Wordmark: `DENTAL STUDIO` je 11px, `letter-spacing: .24em`, 600, `--c-teal`. `Mijušković` je 22px, 700, `-0.02em`, `--c-primary`. Ispred stoji mala mint tačka (6px) kao „sjaj“.
  - JS: `img.decode().then(() => { img.hidden = false; word.hidden = true })`. Ako `logo.webp` ne postoji, ostaje wordmark i ništa ne puca.
  - Ista logika važi za footer (svetla varijanta wordmarka na tamnoj podlozi; za logo `filter` ili zasebna verzija po potrebi).
- **Favicon:** inline SVG monogram „M“ (petrolej kvadrat 8px radius + bela „M“ + mint tačka), kao data URI. Ne čeka sliku klijenta. Kada klijent dostavi logo, može se zameniti.

### 3.2 Mobilni meni
- Ispod 900px stoje logo levo i hamburger desno (44×44). Meni je panel preko celog ekrana na `--c-surface` sa velikim linkovima (24px), harmonikom za usluge i dole sa 3 velika dugmeta: Pozovite / Viber / WhatsApp.
- Zaključava skrol tela, zatvara se na Esc i klik na link, koristi `aria-expanded`.

### 3.3 Uvek vidljiva akcija (konverzija)
- **Desktop:** dugme „📞 067 440 414“ u headeru (teal, pill).
- **Mobilni (<900px):** fiksna **donja traka akcija** (64px + safe-area), 3 jednake ćelije:
  `[ 📞 Pozovite ] [ Viber ] [ WhatsApp ]`
  - Pozovite: `tel:+38267440414`
  - Viber: `viber://chat?number=%2B38267440414`
  - WhatsApp: `https://wa.me/38267440414`
  - Traka ima belu podlogu sa blur efektom, gornju liniju `--c-border`, a ćelija „Pozovite“ je ispunjena teal bojom. Telu se dodaje `padding-bottom` da footer ne bude prekriven.
- **Drugi broj** `067 341 214` (pozivi i Viber) prikazuje se u footeru, na `/kontakt/` i u kontakt traci, ali ne u glavnom CTA, da izbor ostane jednostavan.

### 3.4 Završni CTA blok (na svakoj stranici osim `/kontakt/`)
Tamna sekcija (`--c-primary`) sa suptilnim radijalnim mint sjajem u uglu.
```
┌──────────────────────────────────────────────────────────────┐
│  Zakažite pregled                                            │
│  Plan terapije pravimo posle pregleda i RTG snimka.          │
│  [📞 067 440 414]  [Viber]  [WhatsApp]                       │
│  ili 067 341 214 · Nikšić, Crna Gora                         │
└──────────────────────────────────────────────────────────────┘
```

### 3.5 Footer
4 kolone na desktopu i 1 na mobilnom: (1) wordmark/logo + jedna rečenica o ordinaciji; (2) Usluge (4 linka); (3) Ordinacija (O nama, Rezultati, Kontakt); (4) Kontakt (oba broja, Instagram `@dental_studio_mijuskovic`, „Nikšić, Crna Gora“). Donja traka: © godina · „Demo verzija sajta“ (dok traje noindex).
**Adresa ulice, radno vreme i email** su placeholderi `[POTVRDITI]` i ne ulaze u schema dok ih klijent ne potvrdi.

### 3.6 Biblioteka komponenti (stil iz `brand.md`)

| Komponenta | Stil |
|---|---|
| **Dugme primarno** | `--c-teal` pozadina, beli tekst 600 16px, `padding: 14px 26px`, `--radius-full`, hover `--c-teal-hover` + `translateY(-1px)` + `--shadow-md`. Min. visina 48px. |
| **Dugme sekundarno** | Providno, 1.5px ivica `--c-primary`, tekst `--c-primary`, hover pozadina `--c-surface-soft`. Na tamnoj podlozi bela ivica i beli tekst. |
| **Dugme Viber / WhatsApp** | Sekundarni stil + mala monohromna SVG ikonica (inline, bez brend boja). Doslednost je važnija od šarenila. |
| **Tekst-link sa strelicom** | `--c-teal`, 600, strelica `→` se pomera 4px na hover. |
| **Kartica usluge** | Bela, `--radius-lg`, `--shadow-sm`, ivica 1px `--c-border`, slika gore 4:3, telo `padding: 24px`. Hover `--shadow-md`. |
| **Staklena kartica** | `rgba(255,255,255,.72)` + `backdrop-filter: blur(14px)`, ivica `rgba(255,255,255,.6)`, `--radius-md`. Koristi se preko fotografija (hero bedž, oznaka na slici). |
| **Bedž** | Mala pill oznaka, `--c-surface-soft` pozadina, `--c-primary` tekst 13px 600. Mint varijanta (`--c-mint` tačka) za „Specijalista protetike“. |
| **Eyebrow** | Mini pločica ključa boja + tekst velikim slovima 12px `.18em` `--c-teal`. |
| **Pre/posle klizač** | Vidi 3.7. |
| **FAQ harmonika** | `<details>/<summary>`, linija `--c-border` između stavki, `+` se okreće u `×`. Bez JS-a. |
| **Koraci (proces)** | Numerisani 01–04, broj u `--c-mint` 700 40px, tanka linija koja povezuje korake (horizontalno desktop, vertikalno mobilni). |
| **Placeholder slike** | Vidi 3.8. |

### 3.7 Pre/posle klizač (`.ba`)
- Dve slike iste veličine, `-pre` i `-posle`, naslagane. „Posle“ se otkriva sa `clip-path: inset(0 0 0 X%)`.
- Kontrola je `<input type="range">` preko cele površine (pristupačno, radi tastaturom i dodirom), a JS samo ažurira `--pos`.
- Razdelnik je 2px bela linija sa frosted glass trakom od 14px. Ručica je mini pločica ključa boja (42×56) sa strelicama ‹ ›.
- Oznake „PRE“ i „POSLE“ su staklene bedž-pločice u gornjim uglovima.
- Odnos je **3:2**, a početna pozicija 50%. Ispod je natpis: vrsta rada + kratak opis (npr. „Lumineeri, gornji front, 10 zuba“), koji popunjava copywriter **samo na osnovu podataka od klijenta**.
- Bez JS-a se prikazuju dve slike jedna pored druge.

### 3.8 Placeholder sistem za slike (dok nema `assets/manifest.md`)
- Svaka slika je `<figure class="ph" style="aspect-ratio: 4/5">` + `<img src="assets/img/IME.webp" width height alt loading>`.
- `.ph` ima pozadinu `--c-surface-soft` sa tankim dijagonalnim mint šrafiranjem.
- Ako slika ne postoji (`img.onerror`), JS dodaje `.is-missing` i prikazuje ime fajla i šta treba da prikazuje (iz `data-ph="hero.webp: dr Mijušković u ordinaciji"`), centrirano, 13px `--c-muted`. Kada korisnik ubaci fajl sa tačnim imenom, slika se sama pojavljuje bez izmene HTML-a.
- `alt` tekst je opisni, na srpskom, upisan već sada (vidi kolonu „šta prikazuje“ u Mapi slika).
- Prva slika na stranici (hero) ide sa `fetchpriority="high"`, a sve ostale sa `loading="lazy" decoding="async"`.

---

## 4. Stranice: sekcije, wireframe, slike i tekst

Oznaka **[copy: …]** znači tekst koji piše copywriter. **[POTVRDITI]** znači podatak koji mora da potvrdi klijent pre objave.

### 4.1 Početna `/`
**Cilj:** posetilac za 5 sekundi zna ko je doktor (specijalista protetike), šta je glavno (lumineeri, protetika, implanti) i kako da pozove.
**H1:** [copy: varijanta „Stomatolog u Nikšiću: lumineeri, protetika i implanti“ uz ime ordinacije u eyebrow-u]

**S1. Hero (split 7/5, svetla podloga `--c-surface`)**
```
┌──────────────────────────────────────────┬─────────────────────────┐
│ [eyebrow] DENTAL STUDIO MIJUŠKOVIĆ · NIKŠIĆ │  ┌───────────────────┐ │
│                                          │  │                   │ │
│ H1 (52–64px, 2–3 reda, --c-primary)      │  │    hero.webp      │ │
│                                          │  │      4:5          │ │
│ Podnaslov: Dr Žarko Mijušković,          │  │                   │ │
│ specijalista stomatološke protetike…     │  │ ┌───────────────┐ │ │
│                                          │  │ │staklena kart.:│ │ │
│ [📞 Pozovite 067 440 414]  [Viber] [WA]  │  │ │Specijalista   │ │ │
│                                          │  │ │protetike      │ │ │
│ ── 12,6K pratilaca na Instagramu ·       │  │ └───────────────┘ │ │
│    Nikšić · Podgorica · dijaspora        │  └───────────────────┘ │
└──────────────────────────────────────────┴─────────────────────────┘
```
- Slika `hero.webp` (4:5) je radni portret doktora u ordinaciji, sa velikim radijusom `--radius-lg`. Iza nje je ofsetovan blok `--c-surface-soft` (pomeren 24px dole-desno) za dubinu.
- Traka poverenja ispod CTA dugmadi sadrži samo proverljive činjenice: specijalizacija, Nikšić, Instagram zajednica. **Bez** izmišljenih „hiljada pacijenata“ i ocena.
- Mobilni: tekst ide prvi, pa CTA, pa slika 4:5 (max-height 70vh, `object-position: center top`).
- Animacija: tekst fade-up (stagger 80ms), slika blagi scale 1.03→1 (600ms).

**S2. Usluge: „Ključ boja“ (bela podloga)**
```
 [eyebrow] USLUGE                                    Sve usluge →
 H2: [copy: npr. „U čemu smo najjači“]
 ┌──L1──┐   ┌──P2──┐   ┌──I3──┐   ┌──B4──┐
 │ img  │   │ img  │   │ img  │   │ img  │   ← pločice ključa boja sa slikom
 │      │   │      │   │      │   │      │     u „zubu“ (3:4, zaobljeno dno)
 │Lumin.│   │Protet│   │Implan│   │Izbelj│
 │1 red │   │1 red │   │1 red │   │1 red │
 └──────┘   └──────┘   └──────┘   └──────┘
```
- Slike: `usluga-lumineeri.webp`, `usluga-protetika.webp`, `usluga-implanti.webp`, `usluga-izbeljivanje.webp` (izvor 4:3, ovde isečene na 3:4 sa `object-fit: cover`).
- Desktop: 4 u redu. Tablet: 2×2. Mobilni: horizontalni scroll-snap red (pločice 72vw), uz vidljiv deo sledeće.
- [copy: jedna rečenica po usluzi + link „Saznajte više“]

**S3. Dokaz: pre/posle (podloga `--c-surface-soft`)**
```
 [eyebrow] REZULTATI
 H2 + 1 red uvoda                     ┌───────────────────────────────┐
 [tab pločice: Lumineeri | Protetika] │  .ba klizač 3:2               │
 Opis slučaja (2 reda)                │  ba-lumineeri-01-pre/-posle   │
 [Pogledajte sve rezultate →]         └───────────────────────────────┘
```
- Split 5/7. Mini pločice menjaju slučaj: `ba-lumineeri-01-*` i `ba-protetika-01-*`.
- Mobilni: klizač ide prvi (pune širine), pa tekst.

**S4. Specijalista (tamna sekcija `--c-primary`, jedina tamna pre završnog CTA)**
```
┌─────────────────────────┬──────────────────────────────────────┐
│  doctor-portrait.webp   │ [eyebrow mint] SPECIJALISTA PROTETIKE │
│        4:5              │ H2: Dr Žarko Mijušković               │
│                         │ [copy: 2 pasusa, filozofija:          │
│                         │  funkcija + estetika]                 │
│                         │ ▸ specijalista stomatološke protetike │
│                         │ ▸ angažman u Stomatološkoj komori CG  │
│                         │   [POTVRDITI tačnu funkciju]          │
│                         │ ▸ sopstvena saradnja sa CAD/CAM lab.  │
│                         │   [POTVRDITI]                         │
│                         │ [Više o doktoru →]                    │
└─────────────────────────┴──────────────────────────────────────┘
```
- `research.md` navodi funkciju u komori neprecizno („predsednik / potpredsednik / član izvršnog odbora“), pa copywriter piše **neutralno** dok klijent ne potvrdi.

**S5. Kako izgleda tretman (bela)**: 4 koraka: Pregled i RTG → Plan terapije → Izrada (lab, CAD/CAM) → Kontrole. [copy]. Bez slika, numerisani koraci sa linijom.

**S6. Ordinacija (bela, asimetrična galerija)**
```
 ┌────────────────────────┬───────────┐
 │ ordinacija-stolica.webp│ detalj-   │
 │        3:2             │ fasete    │
 │                        │  .webp 1:1│
 ├───────────┬────────────┴───────────┤
 │ detalj-   │ ordinacija-prostor.webp│
 │ boja 1:1  │        3:2             │
 └───────────┴────────────────────────┘
```
- [copy: 1 kratak pasus o prostoru, sterilizaciji i opremi]. Mobilni: 1 kolona, redosled stolica → fasete → prostor (detalj-boja se skriva).

**S7. Pacijenti van Nikšića (`--c-surface`)**: kratak blok sa 3 stavke (Podgorica ~45–50 min · primorje · dijaspora) + link „Kako organizujemo dolazak →“ (`/kontakt/#dolazak`). Bez slike, ikone su linijske SVG.

**S8. Završni CTA** (3.4).

### 4.2 O nama `/o-nama/`
**Cilj:** autoritet i poverenje. **H1:** „Dr Žarko Mijušković, specijalista stomatološke protetike“. **Schema:** `Person`.

1. **Hero (split 5/7):** levo `doctor-portrait.webp` (4:5), desno H1, uvod [copy] i bedževi (Specijalista protetike · Nikšić). CTA „Zakažite pregled“.
2. **Biografija:** uska kolona (max 680px) [copy na osnovu podataka od klijenta: obrazovanje, specijalizacija, komora; sve **[POTVRDITI]**]. Desno sticky citat filozofije (veliki 28px, mint navodnici): [copy: „Zubi ne smeju biti samo beli, već funkcionalno trajni i zdravi.“, parafraza iz research-a, potvrditi].
3. **Kako radimo:** 3 kartice sa staklenim efektom preko slike `doctor-konsultacija.webp` (16:9, puna širina): Preciznost · Funkcija · Estetika.
4. **Tim:** tekst [copy] + `tim.webp` (3:2, opciono). Ako slike nema, sekcija je samo tekst.
5. **Ordinacija:** mreža 2×2 `ordinacija-stolica.webp`, `ordinacija-prostor.webp`, `ordinacija-prijem.webp`, `ordinacija-sterilizacija.webp` (sve 3:2). Mobilni: horizontalni scroll-snap.
6. **Preciznost u detalju:** split, `detalj-preciznost.webp` (4:5) + tekst o laboratoriji i materijalima (cirkonijum, E.max).
7. **Završni CTA.**

### 4.3 Usluge `/usluge/`
**Cilj:** pregled i rutiranje na 4 stranice. **H1:** [copy: „Stomatološke usluge u Nikšiću“].

1. **Uvodni hero (bez slike):** H1 + 2 reda + red od 4 velike pločice ključa boja kao ulaz.
2. **Istaknute usluge:** 4 horizontalne kartice (split, slika levo 4:3 / tekst desno, smer se naizmenično menja): `usluga-lumineeri.webp`, `usluga-protetika.webp`, `usluga-implanti.webp`, `usluga-izbeljivanje.webp`. Svaka ima 2–3 reda [copy], 3 tačke i link.
3. **Kompletna stomatološka nega:** mreža 2×3 tekstualnih kartica bez slika: Ortodoncija (fiksni aparati, folije) · Lečenje kanala · Kompozitni ispuni · Oralna hirurgija · Preventiva (Air-Flow) · Dečja stomatologija. CTA svake kartice je „Pitajte nas“ (Viber).
4. **Završni CTA.**

### 4.4 Šablon stranice usluge (`/usluge/lumineeri/`, `/protetika/`, `/implanti/`, `/izbeljivanje/`)
Sve 4 stranice dele isti šablon, a razlike su u tabeli ispod. **Schema:** `MedicalProcedure`.

```
S1 Hero split 6/6 (--c-surface)
   [mrvice: Početna / Usluge / Lumineeri]
   eyebrow pločica (L1) · H1 · uvod 2–3 reda · [Pozovite] [Viber]
   desno: usluga-<slug>.webp 4:3, radius-lg, staklena oznaka u uglu
S2 Pod-navigacija: traka 4 mini pločice (aktivna izvučena)
S3 Za koga je (bela): 3–4 kartice „Ako vas muči…“ [copy]
S4 Šta dobijate / prednosti (split): tekst + detalj slika
S5 Postupak korak po korak (koraci 01–04) [copy]
S6 Rezultati: 1–2 .ba klizača ove usluge + „Svi rezultati →“ (/rezultati/#<slug>)
S7 FAQ (5–6 pitanja, <details>) [copy]
S8 Završni CTA
```

| Stranica | H1 (pravac, piše copywriter) | Detalj slika (S4) | Pre/posle (S6) | Posebno |
|---|---|---|---|---|
| Lumineeri | Lumineeri i keramičke fasete u Nikšiću | `detalj-fasete.webp` (4:5) | `ba-lumineeri-01`, `ba-lumineeri-02` | Najduža stranica. Pomenuti dizajn osmeha i razliku keramičke i kompozitne fasete. |
| Protetika | Cirkonijum krunice i mostovi | `detalj-boja.webp` (4:5) | `ba-protetika-01`, `ba-protetika-02` | Naglasiti da je to uže polje specijaliste. Bezmetalna vs. metalokeramika. Proteze sa atečmenima idu kratko u FAQ. |
| Implanti | Zubni implanti u Nikšiću | `detalj-preciznost.webp` (4:5) | `ba-implanti-01`, `ba-implanti-02` | Blok „All-on-4 / All-on-6“. Interni link na Protetiku (rad na implantima). |
| Izbeljivanje | Izbeljivanje zuba u Nikšiću | `detalj-boja.webp` (4:5) | `ba-izbeljivanje-01` (opciono) | Najkraća stranica. Ordinacijsko vs. kućno (splintovi). **Ako nema slučaja, S6 se sakriva** i ostaje samo link na rezultate. |

- Tvrdnje u `seo.md` opisu („rezultat istog dana, bez oštećenja gleđi“) copywriter formuliše oprezno, uz potvrdu klijenta.
- Cene se ne navode (nisu javne). CTA tekst je „Plan i cena posle pregleda“.

### 4.5 Rezultati `/rezultati/`
**Cilj:** najjači dokaz kvaliteta. **H1:** „Rezultati: pre i posle“.

1. **Hero (bez slike):** H1 + 1 red + napomena „Prikazani su radovi naše ordinacije, uz saglasnost pacijenata“ [POTVRDITI saglasnost].
2. **Filter: ključ boja:** `Sve · Lumineeri · Protetika · Implanti · Izbeljivanje`. Hash u URL-u (`#lumineeri`) postavlja filter pri učitavanju, a filtriranje radi JS preko `data-cat`.
3. **Mreža slučajeva:** 2 kolone desktop, 1 kolona mobilni. Svaka stavka je `.ba` klizač 3:2 + natpis (vrsta rada, kratak opis) + link na uslugu.
   - Lumineeri: `ba-lumineeri-01` … `-06`
   - Protetika: `ba-protetika-01` … `-04`
   - Implanti: `ba-implanti-01`, `-02`
   - Izbeljivanje: `ba-izbeljivanje-01` (opciono)
   - Slučaj bez fajlova se **ne renderuje u objavljenoj verziji**. U demo verziji se prikazuje placeholder.
4. **Instagram poziv:** traka „Još radova na Instagramu → @dental_studio_mijuskovic“ (link, bez embeda radi brzine).
5. **Završni CTA.**

### 4.6 Kontakt `/kontakt/`
**Cilj:** poziv ili poruka bez trenja. **H1:** „Kontakt i zakazivanje“.

```
┌──────────────────────────────┬──────────────────────────────┐
│ H1 + 1 red                   │ ordinacija-prijem.webp 4:3   │
│ ┌──────────────────────────┐ │                              │
│ │ 📞 067 440 414            │ │                              │
│ │ pozivi · Viber · WhatsApp │ │                              │
│ │ [Pozovite] [Viber] [WA]   │ │                              │
│ ├──────────────────────────┤ │                              │
│ │ 📞 067 341 214            │ │                              │
│ │ pozivi · Viber            │ │                              │
│ │ [Pozovite] [Viber]        │ │                              │
│ ├──────────────────────────┤ │                              │
│ │ Instagram DM →            │ │                              │
│ └──────────────────────────┘ │                              │
└──────────────────────────────┴──────────────────────────────┘
 Adresa [POTVRDITI] · Radno vreme [POTVRDITI]
 [ mapa: Google Maps iframe, Nikšić, lazy, 16:9 / 4:5 mobilni ]
 #dolazak: Dolazite iz Podgorice, sa primorja ili iz inostranstva?
   3 koraka: Pošaljite poruku i snimke → Plan i termini → Dolazak i tretman [copy]
```
- **Bez kontakt forme**: nema backend-a, a klijent radi preko telefona, Vibera i Instagrama. Ako se kasnije doda forma, ide kao `mailto:` ili servis treće strane.
- Mapa: iframe na nivou grada Nikšića dok klijent ne potvrdi tačnu lokaciju. Iframe se učitava na klik („Prikaži mapu“) radi brzine i privatnosti.
- Nema završnog CTA bloka, jer je cela stranica CTA.

---

## 5. Animacije (suptilne)
- `IntersectionObserver` dodaje `.is-in`: fade-up 16px, 500ms, `cubic-bezier(.2,.7,.2,1)`, stagger 60–80ms u mrežama.
- Pločice ključa boja: hover/fokus `translateY(-10px)` + mint unutrašnji sjaj (250ms).
- Header: prelaz visine i podloge pri skrolu (200ms).
- Pre/posle: pri prvom ulasku u viewport ručica se jednom pomeri 50→60→50% (900ms) kao nagoveštaj interakcije.
- `@media (prefers-reduced-motion: reduce)` isključuje sve, osim samog prikaza.

---

## 6. Responzivnost (mobile-first)

| Breakpoint | Promene |
|---|---|
| **< 600px** (osnova) | 1 kolona, bočni razmak 20px, H1 34–38px, H2 28px. Donja traka akcija. Hero tekst ide pre slike. Pločice usluga u horizontalnom scroll-snap redu. Galerija ordinacije u 1 koloni (skriven `detalj-boja`). |
| **≥ 600px** | Pločice usluga 2×2, rezultati i dalje u 1 koloni, footer u 2 kolone. |
| **≥ 900px** | Desktop navigacija sa dropdown-om i CTA u headeru, donja traka se skriva. Split layouti (hero, specijalista, usluge), rezultati u 2 kolone. |
| **≥ 1200px** | Container 1200px (tekstualne kolone max 680px), H1 56–64px, sekcije `padding-block: 120px` (mobilni 72px). |

- Tipografija preko `clamp()`. Svi tap-targeti ≥ 44px.
- Slike sa `width`/`height` atributima i `aspect-ratio` u CSS-u (bez CLS-a). Za hero i usluge koristiti `srcset` samo ako pipeline napravi više veličina, inače jedna WebP.

---

## 7. Konverzija: gde se ponavlja CTA

| Mesto | CTA |
|---|---|
| Header (desktop) | 📞 067 440 414 |
| Donja traka (mobilni) | Pozovite · Viber · WhatsApp (uvek vidljivo) |
| Hero svake stranice | Pozovite + Viber (+ WhatsApp na početnoj) |
| Posle pre/posle sekcija | „Želite ovakav rezultat? Pozovite“ (tekst-link) |
| Kraj svake stranice | Završni CTA blok (3.4) |
| `/kontakt/` | Svi kanali + dolazak iz drugih gradova |

Glavna poruka CTA: **„Zakažite pregled“**. Ne pominjemo cene ni popuste, u skladu sa tonom „bez jeftinih marketinških trikova“.

---

## 8. Mapa teksta (za copywritera)

| Stranica | Blokovi teksta |
|---|---|
| `/` | eyebrow, H1, podnaslov, traka poverenja, 4× opis usluge (1 rečenica), uvod rezultata + 2 natpisa slučaja, bio doktora (2 pasusa + 3 stavke), 4 koraka tretmana, pasus o ordinaciji, blok „van Nikšića“, završni CTA |
| `/o-nama/` | H1, uvod, biografija (300–450 reči), citat, 3 principa, tim, ordinacija, materijali i laboratorija |
| `/usluge/` | H1, uvod, 4× opis (2–3 reda + 3 tačke), 6 kratkih opisa ostalih usluga |
| Usluga (×4) | H1, uvod, „za koga je“ (3–4), prednosti, 4 koraka, natpisi pre/posle, FAQ 5–6 (lumineeri i implanti 600–900 reči ukupno, izbeljivanje 400–600) |
| `/rezultati/` | H1, uvod, napomena o saglasnosti, natpisi svih slučajeva |
| `/kontakt/` | H1, uvod, opisi kanala, vodič za dolazak (3 koraka) |
| Globalno | meni, footer rečenica, alt tekstovi (iz Mape slika), meta title/description (iz `seo.md`) |

---

## 9. Mapa slika

Sve slike idu u `assets/img/`, format **WebP**, kvalitet 80–85. Ako fajl ne postoji, prikazuje se placeholder (3.8). Kolona „Izvor“ upućuje na predlog iz `image-shortlist.md`, kako bi asset pipeline znao šta u šta da preimenuje.

| Fajl | Stranica / sekcija | Odnos / dimenzije | Šta treba da prikazuje | Izvor (shortlist) |
|---|---|---|---|---|
| `logo.webp` | Header, footer (sve stranice) | slobodan, visina 48px (izvoz 2× = 96px visine), providna pozadina | Logo „Dental Studio Mijušković“. Ako ne postoji, ostaje tekstualni wordmark. | `logo_dental_studio_mijuskovic.png/.svg` |
| `og-cover.webp` *(izvoz i kao `og-cover.jpg` za društvene mreže)* | `<meta property="og:image">` sve stranice | 1.91:1, 1200×630 | Doktor ili osmeh + wordmark na `--c-primary` podlozi (pravi se iz `hero.webp`) | izvedeno |
| `hero.webp` | `/` S1 Hero | 4:5, 1200×1500 | Dr Mijušković u ordinaciji (radni portret, mantil, svetao prostor), pogled ka kameri ili pacijentu | `mijuskovic_portrait_clinic.jpg` |
| `doctor-portrait.webp` | `/` S4 Specijalista; `/o-nama/` hero | 4:5, 1000×1250 | Klasičan profesionalni portret doktora u belom mantilu, neutralna svetla pozadina | `mijuskovic_portrait_hero.jpg` |
| `doctor-konsultacija.webp` | `/o-nama/` Kako radimo (pozadina staklenih kartica) | 16:9, 1920×1080 | Doktor u razgovoru sa pacijentom ili pregledu snimka. Lice pacijenta van fokusa ili okrenuto. | `mijuskovic_portrait_consultation.jpg` |
| `tim.webp` *(opciono)* | `/o-nama/` Tim | 3:2, 1600×1067 | Tim ordinacije (stomatolozi, asistenti) | nice-to-have |
| `usluga-lumineeri.webp` | `/` S2 pločica; `/usluge/` kartica; `/usluge/lumineeri/` hero | 4:3, 1600×1200 (na početnoj isečena 3:4, centar važan) | Makro blistav osmeh sa lumineerima (posle), prirodna translucencija | najbolji „posle“ kadar iz lumineera ili `procedure_macro_veneers_detail.jpg` |
| `usluga-protetika.webp` | `/` S2; `/usluge/`; `/usluge/protetika/` hero | 4:3, 1600×1200 | Bezmetalne (cirkonijum/E.max) krunice ili most, makro | „posle“ kadar iz protetike |
| `usluga-implanti.webp` | `/` S2; `/usluge/`; `/usluge/implanti/` hero | 4:3, 1600×1200 | Završen rad na implantu u estetskoj zoni ili fiksni rad (All-on-X), makro | „posle“ kadar iz implanata |
| `usluga-izbeljivanje.webp` | `/` S2; `/usluge/`; `/usluge/izbeljivanje/` hero | 4:3, 1600×1200 | Svetao, prirodno beo osmeh (makro) ili lampa za izbeljivanje u ordinaciji | nema u shortlist-u, tražiti od klijenta (privremeno može `ordinacija-stolica`) |
| `detalj-fasete.webp` | `/` S6 galerija; `/usluge/lumineeri/` S4 | izvor 4:5, 1200×1500 (na početnoj isečen 1:1) | Gotove keramičke fasete na modelu pre cementiranja, makro | `procedure_macro_veneers_detail.jpg` |
| `detalj-boja.webp` | `/` S6 galerija (skriveno na mobilnom); `/usluge/protetika/` S4; `/usluge/izbeljivanje/` S4 | izvor 4:5, 1200×1500 (na početnoj isečen 1:1) | Određivanje nijanse: ključ boja pored zuba pacijenta | `procedure_shade_matching.jpg` |
| `detalj-preciznost.webp` | `/o-nama/` Preciznost; `/usluge/implanti/` S4 | 4:5, 1200×1500 | Ruke doktora sa preciznim instrumentima ili lupama, krupni plan | `procedure_hands_precision.jpg` |
| `ordinacija-stolica.webp` | `/` S6; `/o-nama/` Ordinacija | 3:2, 1600×1067 | Glavna stomatološka jedinica, čist i svetao prostor | `clinic_chair_main.jpg` |
| `ordinacija-prostor.webp` | `/` S6; `/o-nama/` Ordinacija | 3:2, 1600×1067 | Širi kadar radnog prostora ordinacije | `clinic_room_wide.jpg` |
| `ordinacija-prijem.webp` | `/o-nama/` Ordinacija; `/kontakt/` hero | 3:2, 1600×1067 (na kontaktu isečen 4:3) | Prijemni pult ili čekaonica, topao i prijatan prostor | `clinic_reception.jpg` |
| `ordinacija-sterilizacija.webp` | `/o-nama/` Ordinacija | 3:2, 1600×1067 | Sterilizacija i uredno složeni sterilni instrumenti | `clinic_sterilization_equipment.jpg` |
| `ba-lumineeri-01-pre.webp` / `ba-lumineeri-01-posle.webp` | `/` S3; `/usluge/lumineeri/` S6; `/rezultati/` | 3:2, 1200×800 (oba identičan kadar) | Lumineeri, slučaj 1: osmeh pre i posle (makro, bez očiju i lica) | `beforeafter_lumineers_01.jpg` |
| `ba-lumineeri-02-pre.webp` / `-posle.webp` | `/usluge/lumineeri/` S6; `/rezultati/` | 3:2, 1200×800 | Lumineeri, slučaj 2 (npr. zatvaranje dijasteme) | `beforeafter_lumineers_02.jpg` |
| `ba-lumineeri-03-pre.webp` / `-posle.webp` | `/rezultati/` | 3:2, 1200×800 | Lumineeri, slučaj 3 (npr. prebojeni zubi) | `beforeafter_lumineers_03.jpg` |
| `ba-lumineeri-04-pre.webp` / `-posle.webp` | `/rezultati/` | 3:2, 1200×800 | Lumineeri, slučaj 4 (npr. istrošeni ili nepravilni zubi) | `beforeafter_lumineers_04.jpg` |
| `ba-lumineeri-05-pre.webp` / `-posle.webp` | `/rezultati/` | 3:2, 1200×800 | Lumineeri, slučaj 5 | `beforeafter_lumineers_05.jpg` |
| `ba-lumineeri-06-pre.webp` / `-posle.webp` | `/rezultati/` | 3:2, 1200×800 | Lumineeri, slučaj 6 | `beforeafter_lumineers_06.jpg` |
| `ba-protetika-01-pre.webp` / `-posle.webp` | `/` S3; `/usluge/protetika/` S6; `/rezultati/` | 3:2, 1200×800 | Cirkonijum krunice: stari metalokeramički rad → bezmetalna keramika | `beforeafter_prosthetics_zirconia_01.jpg` |
| `ba-protetika-02-pre.webp` / `-posle.webp` | `/usluge/protetika/` S6; `/rezultati/` | 3:2, 1200×800 | Cirkonijum ili E.max, slučaj 2 | `beforeafter_prosthetics_zirconia_02.jpg` |
| `ba-protetika-03-pre.webp` / `-posle.webp` | `/rezultati/` | 3:2, 1200×800 | Bezmetalni most | `beforeafter_prosthetics_bridge_01.jpg` |
| `ba-protetika-04-pre.webp` / `-posle.webp` | `/rezultati/` | 3:2, 1200×800 | Kompletna rekonstrukcija zagrižaja | `beforeafter_full_reconstruction_01.jpg` |
| `ba-implanti-01-pre.webp` / `-posle.webp` | `/usluge/implanti/` S6; `/rezultati/` | 3:2, 1200×800 | Nadoknada jednog zuba u estetskoj zoni (implant + bezmetalna krunica) | `beforeafter_implants_single_01.jpg` |
| `ba-implanti-02-pre.webp` / `-posle.webp` | `/usluge/implanti/` S6; `/rezultati/` | 3:2, 1200×800 | Fiksni rad All-on-4 / All-on-6 kod bezube vilice | `beforeafter_implants_allonx_01.jpg` |
| `ba-izbeljivanje-01-pre.webp` / `-posle.webp` *(opciono)* | `/usluge/izbeljivanje/` S6; `/rezultati/` | 3:2, 1200×800 | Osmeh pre i posle ordinacijskog izbeljivanja | nema u shortlist-u, tražiti od klijenta |

**Napomene za pipeline (asset-collector):**
- Pre/posle se **uvek isporučuje kao par** `-pre` i `-posle` istog kadra, odnosa i veličine, jer to traži klizač. Ako klijent ima samo složenu (split) sliku, pipeline je seče na dve polovine. Kao krajnja opcija može se koristiti jedna kompozitna slika `ba-<usluga>-NN.webp` (3:2), pa developer za taj slučaj prikazuje statičnu sliku umesto klizača.
- Pre/posle kadrovi su makro osmeha, **bez očiju i prepoznatljivog lica** (privatnost, `image-shortlist.md`).
- Favicon ne zahteva sliku (inline SVG monogram, 3.1). Logo klijenta se, kada stigne, izvozi u `logo.webp`, a po želji i kao `favicon.png` 512×512.
- Minimum za lansiranje: `hero.webp`, `doctor-portrait.webp`, 4 `usluga-*`, `ba-lumineeri-01..04`, `ba-protetika-01..02`, 3–4 `ordinacija-*`, `logo.webp`.
