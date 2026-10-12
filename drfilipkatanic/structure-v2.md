# Structure v2 — dr Filip Katanić (dorada, 2026-10-12)

Autor: site-architect. Izvori: `brief-v2.md` (prioritet), `_reference/referenca-dizajn.webp`, postojeći `structure.md`, `seo.md`, `research.md`, `web-research.md`, `README.md`, `Assets/manifest.md`, `src/**`.
Stari `structure.md` ostaje kao arhiva; **gde se razlikuju, važi ovaj dokument** (a iznad njega `brief-v2.md`).

Oznake: `[POTVRDITI]` = mora u kod kao HTML komentar `<!-- [POTVRDITI SA KLIJENTOM: ...] -->` pored bezbedne vidljive formulacije.

---

## 0. Ključne odluke ukratko

1. **Lični sajt lekara, ne klinike.** Brend = "dr Filip Katanić · Reproduktivna medicina". SB Ferona se pominje samo kao *mesto ordiniranja* ("Ordinira u SB Ferona, Šarplaninska 19, Novi Sad"). Nijedno dugme, telefon, mejl, footer ili schema ne predstavljaju Feronu kao vlasnika/kontakt sajta.
2. **Glavni CTA svuda:** "Zakaži konsultaciju" → `/zakazivanje/` (navy dugme). Sekundarni kanal: Instagram @drfilipkatanic. Telefon/mejl doktora = placeholder iz `site.json` (vidi 5.3).
3. **Nova stranica `/zakazivanje/`** sa formom (API ugovor iz brief-v2 §4). Forma se uklanja sa početne (sada je tamo, sekcija `#zakazivanje`) — početna ide tačno po referenci i vodi na `/zakazivanje/`.
4. **Vizuelni smer = referenca:** krem pozadina, duboki navy, šampanj-zlato za tanke linije/ikone/eyebrow, visok-kontrast serif naslovi, puno vazduha, tanke 1px ivice umesto senki. Premium = disciplina (poravnanja, razmaci, tipografska skala), ne dekor.
5. **Mobile-first, savršeno na telefonu:** svaka sekcija ispod ima poseban opis prikaza na telefonu (≤ 767px).
6. **Sadržaj nikad nevidljiv bez JS-a** (vidi 2.0 — postojeći `.reveal` mora da se popravi).

---

## 1. Sitemap i navigacija

### 1.1 URL-ovi (svi postojeći ostaju — SEO je urađen)

```
/                                              Početna (redizajn po referenci)
/o-meni/                                       O meni (nove slike)
/oblasti-rada/                                 Hub
/oblasti-rada/vantelesna-oplodnja-ivf/
/oblasti-rada/zamrzavanje-jajnih-celija/
/oblasti-rada/pcos-i-neplodnost/
/oblasti-rada/muski-faktor-neplodnosti/
/oblasti-rada/redovni-ginekoloski-pregledi/
/zakazivanje/                                  NOVO — forma za zakazivanje (+ proces 01–05)
/pitanja-i-odgovori/
/blog/                                         (+ 3 postojeća članka)
/blog/koliko-jajnih-celija-je-potrebno-za-embrion/
/blog/sta-se-zaista-desava-tokom-ivf-postupka/
/blog/prva-konsultacija-sta-poneti/
/mediji-i-predavanja/
/kontakt/                                      redizajn (lični kontakt + lokacija ordiniranja)
/politika-privatnosti/                         dopuna (forma sada prikuplja podatke!)
/admin/                                        NOVO — PHP admin (noindex, Disallow u robots.txt, NIJE u sitemap)
/api/csrf.php, /api/zakazi.php                 NOVO — backend (Disallow, nije u sitemap)
404.html
```

`/zakazivanje/` ide u `sitemap.xml` (indeksira se: title "Zakažite konsultaciju – dr Filip Katanić | Novi Sad", meta description bez Ferone kao brenda). Front matter: `cta: none` (stranica je sama CTA), `scripts: booking.js`, `body_class: page-booking force-sticky-off` (sticky bar se ne prikazuje na ovoj stranici — vidi 2.1).

**Query parametar `?usluga=`** — vrednosti su tačno enum iz API ugovora:

| `?usluga=` | Labela u formi |
|---|---|
| `prva-konsultacija` | Prva konsultacija |
| `drugo-misljenje` | Drugo mišljenje (analiza dokumentacije) |
| `ivf` | Sterilitet i vantelesna oplodnja (IVF/ICSI) |
| `zamrzavanje-jajnih-celija` | Zamrzavanje jajnih ćelija |
| `pcos` | PCOS i poremećaji ovulacije |
| `muski-faktor` | Muški faktor neplodnosti |
| `ginekoloski-pregled` | Ginekološki pregled |
| `ostalo` | Nešto drugo |

### 1.2 Glavna navigacija (desktop ≥ 1120px)

```
┌──────────────────────────────────────────────────────────────────────────────────────┐
│ [FK] dr Filip Katanić        Početna  O meni  Oblasti rada ▾  Konsultacija  Blog  Kontakt   [ Zakaži konsultaciju ] │
│      Reproduktivna medicina ──  ‾‾‾‾‾‾ (zlatna linija ispod aktivne)                   │
└──────────────────────────────────────────────────────────────────────────────────────┘
```

| Stavka | Cilj | Napomena |
|---|---|---|
| Početna | `/` | |
| O meni | `/o-meni/` | aktivna i na `/mediji-i-predavanja/` |
| Oblasti rada ▾ | dugme (dropdown) | aktivna na `/oblasti-rada/**` i `/pitanja-i-odgovori/` |
| Konsultacija | `/zakazivanje/` | stranica sadrži proces 01–05 + formu; aktivna na `/zakazivanje/` |
| Blog | `/blog/` | na početnoj sekcija nosi eyebrow "Journal" (kao referenca), ali u meniju piše "Blog" — razumljivije pacijentkinjama, poklapa se sa URL-om |
| Kontakt | `/kontakt/` | |
| **Zakaži konsultaciju** | `/zakazivanje/` | navy puno dugme, uvek vidljivo u headeru |

**Dropdown "Oblasti rada"** (panel 560px, bela kartica, 1px zlatna gornja ivica, 2 kolone):

```
┌─────────────────────────────────────────────┬──────────────────────────────┐
│ OBLASTI RADA                                │ KORISNO                      │
│ ◯ Vantelesna oplodnja (IVF/ICSI)            │ Pitanja i odgovori         → │
│ ◯ Zamrzavanje jajnih ćelija                 │ Mediji i predavanja        → │
│ ◯ PCOS i neplodnost                         │ Prva konsultacija — šta    → │
│ ◯ Muški faktor neplodnosti                  │   poneti (blog)              │
│ ◯ Redovni ginekološki pregledi              │ ───────────────              │
│ Sve oblasti rada →                          │ Drugo mišljenje →            │
│                                             │ (/zakazivanje/?usluga=       │
│                                             │   drugo-misljenje)           │
└─────────────────────────────────────────────┴──────────────────────────────┘
```
◯ = mala zlatna linijska ikona (ista kao na karticama oblasti). Otvara se na klik (i hover sa 150ms delay-om na pointer: fine), `aria-expanded`, Esc zatvara, fokus ostaje u panelu.

Tako "Pitanja i odgovori" i "Mediji i predavanja" ostaju dostupni iz menija (sekundarno), plus u footeru i u mobilnom meniju.

### 1.3 Header — ponašanje

- Visina 84px desktop / 64px telefon. Pozadina: krem `rgba(251,247,240,.92)` + `backdrop-filter: blur(10px)`; na vrhu stranice bez donje ivice, posle 24px skrola dobija 1px `--color-border` donju liniju (klasa `.is-scrolled`, JS — bez JS-a linija stoji stalno, nije problem).
- Sticky (`position: sticky; top: 0`). Ne sakriva se na skrol nadole (pacijenti stalno traže dugme).
- **Brend znak levo** = potpisni FK monogram u kvadratnom zlatnom okviru (vidi §7), pored dva reda: "dr Filip Katanić" (serif 22px, navy) / "Reproduktivna medicina ——" (sans 11px, letter-spacing .08em, zlatna crtica 24px posle teksta).
- Aktivna stavka: tekst navy 500 + zlatna linija 24×1.5px centrirana 8px ispod (ne podvlačenje celog teksta).

### 1.4 Header na tabletu i telefonu (< 1120px)

```
┌──────────────────────────────────────────┐
│ [FK] dr Filip Katanić        [Zakaži] [≡]│   tablet 768–1119: kratko dugme "Zakaži" + burger
└──────────────────────────────────────────┘
┌──────────────────────────────────┐
│ [FK] dr Filip Katanić       [≡]  │   telefon < 768: samo znak + ime + burger (44×44)
│      Reproduktivna medicina      │   (podnaslov se krije < 380px)
└──────────────────────────────────┘
```

**Mobilni meni** (full-screen, navy pozadina, krem tekst, otvara se fade + slide 12px, 250ms):

```
┌──────────────────────────────────┐
│ [FK]                        [✕]  │
│                                  │
│ Početna                          │  serif 28px, razmak 4px, tanka linija između
│ O meni                           │
│ Oblasti rada                  +  │  akordeon → 5 oblasti + "Sve oblasti"
│ Konsultacija                     │
│ Blog                             │
│ Kontakt                          │
│ ─────────────                    │
│ Pitanja i odgovori               │  sans 15px, sekundarno
│ Mediji i predavanja              │
│                                  │
│ [   Zakaži konsultaciju   ]      │  zlatno puno dugme, full width
│ Instagram @drfilipkatanic        │
│ Ordinira u SB Ferona, Novi Sad   │  sitno, 60% opacity — informacija, ne kontakt
└──────────────────────────────────┘
```
`role="dialog"`, `aria-modal`, focus trap, Esc i klik na ✕ zatvaraju, `body` scroll lock. **Nema** Ferona telefona u meniju (sada postoji — ukloniti).

### 1.5 Mobilni sticky bar (< 768px)

```
┌──────────────────────────────────┐
│ [  Zakaži konsultaciju  ] [ IG ] │  navy dugme flex:1 + kvadratno 48px IG dugme (outline)
└──────────────────────────────────┘
```
- Pojavljuje se posle hero sekcije (IO na hero), sakriva se kad je CTA traka ili footer u viewport-u. Bez JS-a: uvek vidljiv (nije štetno).
- `padding-bottom: env(safe-area-inset-bottom)`; `body` dobija `padding-bottom` = visina bara da ne prekriva footer.
- Ne prikazuje se na `/zakazivanje/` (tamo je forma sama CTA; dugme "Pošalji" ne sme da se takmiči sa barom) i na `/admin/`.
- Link na `/zakazivanje/` (sada vodi na Ferona `tel:` — ukloniti).

### 1.6 Breakpointi (postojeći tokeni se zadržavaju)

| Naziv | Širina | Gutter |
|---|---|---|
| telefon | < 768px (dizajn za 360–430) | 20px (sada 16 — povećati na 20 za premium vazduh; min 16 na < 360) |
| tablet | 768–1023 | 24px |
| desktop | 1024–1279 | 32px |
| široki | ≥ 1280 | 40px, container 1200px (hero 1320px) |
| nav kolaps | < 1120 | (poseban breakpoint samo za header) |

---

## 2. POČETNA (`/`) — sekcija po sekcija, tačno redosledom reference

### 2.0 Globalna pravila za početnu (i ceo sajt)

**Tipografija** (usklađivanje sa referencom):
- Naslovi: klasičan serif visokog kontrasta. Preporuka: **Cormorant Garamond** 500/600 (Google Fonts) za H1/H2 i naslove kartica ≥ 20px; Fraunces ostaje fallback ako developer proceni da je promena prevelika — ali referenca jasno traži "Garamond" osećaj, ne Fraunces "soft" osećaj. Telo: Karla ostaje (ili Jost — ne obavezno).
- Skala (clamp): H1 hero `clamp(44px, 7vw, 84px)` / line-height 1.02 / letter-spacing -0.01em; H2 `clamp(30px, 4vw, 44px)` / 1.15; H3 kartice 20–22px / 1.25; telo 16–17px / 1.65; eyebrow 12px, uppercase, letter-spacing .18em, zlatna `--color-accent` (#8C7355, tekst-bezbedna), 600.
- **Eyebrow motiv:** svaki eyebrow centriranih sekcija ima tanke zlatne linije levo i desno (`— MOJ PRISTUP —`, linije 32px, 1px). To je deo potpisnog sistema (§7).

**Boje** (tokens.css — predlog izmena):
- `--color-primary: #14213D` (referentni navy; sadašnji #10284A je blizu — developer bira, ali naslovi, dugmad, trake i footer moraju biti isti navy).
- Zlato: tekst/eyebrow `#8C7355` (AA na kremu), dekor/linije/ikone `#B8976A` na kremu, `#C9AD87` na navy.
- Krem `#FBF7F0` pozadina, bele kartice `#FFFFFF` sa 1px `#E8E1D5` ivicom; senka samo `0 1px 2px rgba(20,33,61,.04)`, na hover `0 12px 32px rgba(20,33,61,.08)`.
- Salvija zelena iz brand.md se na početnoj **ne koristi** (referenca je nema) — ostaje samo za eventualne statusne oznake.

**Dugmad:**
- `.btn--primary`: navy puno, krem tekst, 48px visina (52 na telefonu), padding 0 28px, radius 2px (referenca ima skoro oštre uglove — premium), sans 15px 600, letter-spacing .02em. Hover: navy svetliji `#22335A` + strelica → pomera 3px.
- `.btn--outline-gold`: transparentno, 1px zlatna ivica, navy tekst; hover: zlatna pozadina 8% tint.
- `.btn--gold` (samo na navy pozadinama): zlatno puno, navy tekst.
- Tekst-link "Pročitaj više →": zlatni tekst, 14px 600, strelica linijska SVG.

**Kartice:** bela, 1px ivica, radius 4px, padding 28–32px. Ikona 36px zlatna linijska. Hover (samo `@media (hover:hover)`): podizanje -2px + senka + zlatna gornja linija 0→100% širine (transform: scaleX, 400ms).

**Ikone:** sve inline SVG, `viewBox="0 0 32 32"`, `fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"`, `aria-hidden="true"`, boja `--gold-deco`. Novi partial `src/partials/icons/*.html` (jedan fajl po ikoni) ili jedan SVG sprite `src/static/assets/img/icons.svg` sa `<symbol id="i-...">` + `<svg><use href="{{root}}assets/img/icons.svg#i-..."/></svg>`. Preporuka: **sprite** (manje HTML-a, keš). Spisak ikona je u §2.15.

**Animacije — pravilo progresivnog poboljšanja (OBAVEZNO, sadašnja implementacija je kršenje):**
- Sada: `base.css` → `.reveal { opacity: 0 }` za svakog ko ima `html.js`, a `js` klasa se postavlja inline skriptom pre `main.js`. Ako `main.js` padne, kasni, ili alat za screenshot/print ne skroluje, **sadržaj je nevidljiv**. Takođe `kontakt.html` i `mediji-i-predavanja.html` imaju `reveal` na **hero sekciji sa H1**.
- Novo pravilo:
  1. CSS sakriva samo pod `html.reveal-ready .reveal:not(.is-in)`. Klasu `reveal-ready` dodaje **main.js** tek kad je IntersectionObserver uspešno postavljen i kad je odmah označio sve elemente koji su već u viewport-u kao `.is-in`.
  2. Failsafe: `setTimeout(() => all .reveal → .is-in, 2500)` i `beforeprint` → sve vidljivo.
  3. `@media (prefers-reduced-motion: reduce)` → bez transform/transition, sve vidljivo.
  4. Hero (above the fold) **nikad** nema `.reveal`. Dozvoljeno samo: slika hero-a `transform: scale(1.03) → 1` za 1.2s (CSS animation, opacity ostaje 1), i zlatne linije eyebrow-a koje se "iscrtavaju" (scaleX) — tekst je vidljiv od prvog paint-a.
  5. Pomeraj max 12px, trajanje 600ms, `cubic-bezier(.2,.6,.2,1)`, stagger za kartice 60ms (max 5 elemenata, posle toga bez delay-a).
- Ostale suptilne animacije: brojevi procesa 01–05 i strelice — linija između koraka se iscrtava (scaleX) kad sekcija uđe; kartice hover kao gore; Journal slike zoom 1.04 na hover (overflow hidden); navy traka — bez animacije.

**Slike (nove, iz `Assets/Raw/` → `src/static/assets/img/`):** obrada u webp, srcset 1x/2x (ili 640/960/1440w), `width/height` atributi, `loading="lazy"` osim hero-a (`fetchpriority="high"` + `preload`).

| Novi fajl | Izvor | Obrada | Gde |
|---|---|---|---|
| `hero-portret.webp` (1600×1200 i 960w) | `IMG_1626.jpg` | landscape; leva trećina već svetla — dodatno izbledeti levo ka krem (#FBF7F0) u samoj slici ILI CSS maskom (preporuka CSS `mask-image: linear-gradient(to right, transparent 0, #000 35%)`) | Hero desktop/tablet |
| `hero-portret-mobile.webp` (900×1100, 4:5 → 4:4.9) | `IMG_1626.jpg` | krop 4:5 centriran na lice/ramena (glava u gornjoj trećini, ruke odsečene ili do zgloba); Ferona logo se na ovom kadru ne vidi | Hero telefon (`<picture>` + `media="(max-width: 767px)"`) |
| `portret-mantil.webp` (1200×1350) | `IMG_4642.jpg` | **krop iznad grudi** — Ferona logo na majici (≈ 70% visine originala) MORA biti van kadra; alternativa retuš (clone) ako treba širi kadar. `[POTVRDITI: retuš/krop odobren]` | `/o-meni/` page hero, `/zakazivanje/` bočni panel (mali okrugli/ovalni isečak), OG slika |
| `portret-mantil-2.webp` | `IMG_4641.JPG` | isto pravilo (logo van kadra); visoka "glava-prostor" kompozicija | rezerva: `/kontakt/` ili blog autor-boks |
| `o-meni.webp` (1000×1250, 4:5) | `IMG_4647.JPG` | krop: ukloniti žuti sto u dnu (donjih ~22%) i desni deo sa katalozima ("Galenska laboratorija" tekst ne treba da bude čitljiv) | Početna "O meni", `/o-meni/` sekcija "Ko sam ja" |
| `konferencija-panel.webp` (1200×1500 i 640w) | `IMG_1740.JPG` | blagi krop; bedž "Bebologijini krugovi / Bio Save" ostaje (potvrđuje Bio Save). Na bedžu piše titula — sada dozvoljeno po brief-v2, ali staviti `[POTVRDITI: pismena potvrda titule]` u komentar uz sliku | "Nauka i edukacija" pozadinska slika/akcent, `/mediji-i-predavanja/` hero |
| `logo-znak.png` (+ `logo-znak.svg` ako se vektorizuje) | `Logo.PNG` | iseći samo okrugli znak (zlatni krug, ruke, beba, FK u srcu) na **transparentnu** pozadinu, 512×512; varijanta za navy pozadinu (beli/zlatni) i za krem (navy/zlatni) | CTA traka, footer, favicon/OG (opciono), admin login |
| `logo-pun.png` | `Logo.PNG` | ceo logo (znak + script ime) na navy, 1024×1024 | samo OG/Instagram/šeriovanje; **ne** u header (header koristi tipografski FK monogram — vidi §7) |

`hero.webp` (stari IG portret sa utisnutim tekstom) i `brend-vizual-01/02.webp` **izlaze sa početne**. Pravilo `CROP_REQUIRED` u `build.py` ostaje za stare fajlove dok god se negde koriste.

---

### 2.1 Header
Opisan u §1.2–1.4. Na početnoj aktivna je "Početna".

---

### 2.2 Hero

**Cilj:** u 3 sekunde: ko je (ime), čime se bavi (reproduktivna medicina/IVF), zašto mu verovati (3 kredencijala), šta da uradim (Zakaži konsultaciju). Lice doktora je glavni nosilac poverenja.

**Desktop (≥ 1024) wireframe:**
```
┌───────────────────────────────────────────────────────────────────────────────┐
│                                         ░░░░░▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓ │
│  dr Filip Katanić                       ░░░▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓ │
│  (serif 84px, navy)                     ░░▓▓▓▓▓▓▓  hero-portret.webp ▓▓▓▓▓▓▓ │
│  Reproduktivna medicina • IVF •         ░▓▓▓▓▓▓▓▓  (beli mantil, lice  ▓▓▓▓▓ │
│  Klinička istraživanja  (zlatni serif)  ░▓▓▓▓▓▓▓▓   u desnoj polovini) ▓▓▓▓▓ │
│                                         ░▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓ │
│  Individualizovan pristup lečenju       ░▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓ │
│  steriliteta zasnovan na savremenoj...  ░▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓ │
│                                         ░▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓ │
│  [ Zakaži konsultaciju ]  [ Oblasti rada ]                                    │
│  ───────────────────────────────────── (1px zlatna linija, 60% širine kolone) │
│  (ikona) Specijalista   │ (ikona) Master reprod. │ (ikona) Doktorske studije —│
│  ginekologije i akuš.   │ biologije i kl. embr.  │ klinička istraživanja      │
└───────────────────────────────────────────────────────────────────────────────┘
```
- Layout: full-bleed sekcija, `min-height: min(760px, 100svh - header)`. Slika je **apsolutno pozicionirana** desno, širine 62% (od 1280: 58%), visine 100%, `object-fit: cover; object-position: 60% 25%`, sa CSS maskom levo (prelaz u krem preko ~35% širine slike) i blagom donjom maskom (poslednjih 8%) da se prelije u sledeću sekciju. Tekst u containeru, kolona max 560px, vertikalno centrirana.
- H1 = "dr Filip Katanić" (jedini H1; ime je i brend i primarni SEO entitet). Podnaslov `<p class="hero__sub">` zlatni serif 22px: "Reproduktivna medicina • IVF • Klinička istraživanja" (tačka-separator `•` u zlatu 50%).
- Uvod (max 46ch, 18px, `--color-text-muted`): "Individualizovan pristup lečenju steriliteta zasnovan na savremenoj reproduktivnoj medicini, embriologiji i kliničkom iskustvu." + nova kratka linija ispod, 14px: "Ordinira u SB Ferona, Novi Sad." (sa malom pin ikonom) — informacija o mestu, ne brend.
- Dugmad: `Zakaži konsultaciju` (primary) → `/zakazivanje/`; `Oblasti rada` (outline-gold) → `#oblasti`.
- **3 kredencijala** (red, `display:grid; grid-template-columns: repeat(3, auto)`, razdeljeni 1px vertikalnim zlatnim linijama 32px visine), ikona 28px + tekst 13px/1.35 navy-muted:
  1. ikona `i-doctor` — "Specijalista ginekologije i akušerstva" `<!-- [POTVRDITI SA KLIJENTOM: pismena potvrda titule pre objave] -->`
  2. ikona `i-dna` — "Master reproduktivni embriolog" (formulacija sa IG bio-a; referenca kaže "Master reproduktivne biologije i kliničke embriologije" — `[POTVRDITI tačan naziv mastera]`)
  3. ikona `i-microscope` — "Doktorske studije — klinička istraživanja" `<!-- [POTVRDITI: doktorske studije, Medicinski fakultet Novi Sad, prediktivno modelovanje ovarijalnog odgovora] -->`
- Pozadina iza teksta: krem; ispod hero-a nema oštre ivice.

**Tablet (768–1023):**
```
┌─────────────────────────────────────────┐
│ dr Filip Katanić          ▓▓▓▓▓▓▓▓▓▓▓▓▓ │  slika 55% desno, maska jača (prelaz 45%),
│ Reproduktivna medicina... ▓▓▓▓▓▓▓▓▓▓▓▓▓ │  H1 56px, tekst kolona 60%
│ uvod...                   ▓▓▓▓▓▓▓▓▓▓▓▓▓ │
│ [Zakaži] [Oblasti rada]   ▓▓▓▓▓▓▓▓▓▓▓▓▓ │
├─────────────────────────────────────────┤
│ (i) kred 1  │ (i) kred 2  │ (i) kred 3  │  kredencijali ispod, puna širina, bela traka 1px ivica
└─────────────────────────────────────────┘
```

**Telefon (< 768) — slika gore sa gradijentom, pa tekst:**
```
┌──────────────────────────────┐
│ header 64px                  │
├──────────────────────────────┤
│▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓│
│▓▓▓▓▓ hero-portret-mobile ▓▓▓▓│  aspect-ratio 4/4.4, max-height 62svh,
│▓▓▓▓▓ (lice u gornjoj     ▓▓▓▓│  object-position 50% 20%
│▓▓▓▓▓  trećini)           ▓▓▓▓│
│▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒│  donjih 35% slike: linear-gradient(transparent → #FBF7F0)
│ dr Filip Katanić             │  H1 44–48px, NEGATIVNI margin-top -56px (tekst
│ Reproduktivna medicina •     │  ulazi u gradijent — "pretapanje" kao na referenci)
│ IVF • Klinička istraživanja  │  podnaslov zlatni 17px, može u 2 reda
│                              │
│ Individualizovan pristup...  │  16px, max 3–4 reda
│ ⌖ Ordinira u SB Ferona, NS   │
│ [   Zakaži konsultaciju   ]  │  full width 52px
│ [      Oblasti rada       ]  │  full width outline
│ ──────────────────────────── │
│ (i) Specijalista ginekologije│  kredencijali VERTIKALNO: 3 reda, ikona levo 24px,
│     i akušerstva             │  tekst desno 14px, razdvojeni 1px linijom
│ (i) Master reprod. embriolog │  (ne horizontalni scroll — mora sve da se vidi)
│ (i) Doktorske studije — ...  │
└──────────────────────────────┘
```
- Mobilna slika kroz `<picture><source media="(max-width:767px)" srcset="hero-portret-mobile.webp">`; preload samo odgovarajuće varijante (`<link rel="preload" as="image" media="...">` za obe).
- Gradijent je CSS pseudo-element (`::after`) — tekst je pravi HTML, ne preko lica (lice ostaje čisto).
- Bez JS-a sve radi; nema animacije teksta.

---

### 2.3 Moj pristup

**Cilj:** filozofija u jednoj rečenici — razlikovanje od "fabrike" IVF-a.

```
            ── MOJ PRISTUP ──
     Ne postoji univerzalni IVF protokol.          (serif H2, centriran)
  Uspešno lečenje steriliteta ne počinje istom terapijom za svakog
  pacijenta, već razumevanjem kompletne kliničke slike — ovarijalne
  rezerve, prethodnog odgovora na stimulaciju, embrioloških faktora i
  realne prognoze. Moj pristup zasniva se na individualizovanim
  terapijskim odlukama, jasnoj komunikaciji i realnom planu.
                         (max 68ch, centriran, 17px muted)
```
- Layout: centrirana kolona 760px, padding sekcije 96px gore / 40px dole (spaja se vizuelno sa sledećom sekcijom — na referenci "Kada ima smisla" je odmah ispod, bez novog bloka pozadine).
- Napomena za copy: "Uspešno lečenje" je OK (nema brojke), lint `LINT_USPESNOST` hvata samo % blizu "uspe*".
- Telefon: levo poravnato? **Ne** — ostaje centrirano (kratak blok), H2 30px, pasus 16px, gutter 20px.
- Animacija: reveal (fade+8px) na H2 i pasus.
- Slike: nema. Ikone: nema.

---

### 2.4 Kada ima smisla da se javite? (4 kartice)

**Cilj:** prepoznavanje sebe — svaka posetiteljka nalazi svoju situaciju i ima direktan put ka formi.

**Desktop:**
```
                  ── KADA IMA SMISLA DA SE JAVITE? ──
┌────────────────┐ ┌────────────────┐ ┌────────────────┐ ┌────────────────┐
│      (🌱)      │ │      (↻)       │ │      (📉)      │ │      (?)       │
│ Ako tek        │ │ Ako imate      │ │ Ako imate nizak│ │ Ako niste      │
│ počinjete      │ │ neuspešne      │ │ AMH ili slab   │ │ sigurni da li  │
│ obradu         │ │ pokušaje iza   │ │ odgovor        │ │ je IVF sledeći │
│ steriliteta    │ │ sebe           │ │                │ │ korak          │
│ Rano postavlj..│ │ Analiziramo... │ │ Strategije...  │ │ Pomažem vam... │
└────────────────┘ └────────────────┘ └────────────────┘ └────────────────┘
```
- Grid 4 kolone, gap 16px, kartice centrirane (ikona 36px gore, naslov serif 21px, opis 14.5px muted). Ceo blok kartice je link (`<a>`) → `/zakazivanje/?usluga=…`:
  1. `i-sprout` — "Ako tek počinjete obradu steriliteta" — "Rano postavljanje pravog plana štedi vreme i daje jasan pravac." → `?usluga=prva-konsultacija`
  2. `i-cycle` — "Ako imate neuspešne pokušaje iza sebe" — "Analiziramo prethodne cikluse i menjamo ono što je važno." → `?usluga=drugo-misljenje`
  3. `i-chart-down` — "Ako imate nizak AMH ili slab odgovor" — "Strategije za poboljšanje ishoda i realna očekivanja." → `?usluga=ivf`
  4. `i-question` — "Ako niste sigurni da li je IVF sledeći korak" — "Pomažem vam da donesete sigurnu i informisanu odluku." → `?usluga=prva-konsultacija`
- Na dnu kartice skriveni-na-desktopu, vidljivi-na-hover mikro link "Zakaži →" (zlatni, opacity .0→1 na hover; na touch uređajima uvek vidljiv — `@media (hover:none)`).
- **Tablet:** 2×2 grid.
- **Telefon:** **horizontalni scroll-snap karusel** (kartice 78% širine, `scroll-snap-type: x mandatory`, `scroll-padding-inline: 20px`, poslednja kartica ima desni "peek" razmak) + ispod 4 tačkice-indikatora (dekorativne, JS ažurira aktivnu; bez JS-a i dalje skroluje prstom). Kartice horizontalno: ikona levo 32px, tekst desno? **Ne** — ostaje vertikalna centrirana kartica (kao referenca), visina ujednačena (`align-items: stretch`).
  - Alternativa ako tester proceni da se karusel ne primećuje: 1 kolona sa kompaktnim karticama (ikona levo, naslov + opis desno, 1px linija između) — developer implementira karusel, ali CSS mora imati klasu `.cards--stack` kao fallback koji se lako uključi.
  - Pristupačnost karusela: `<ul role="list">`, `aria-label="Situacije"`, svaka kartica fokusabilna (link), nema auto-play-a.
- Animacija: stagger reveal (60ms).

---

### 2.5 Oblasti rada (6 kartica 3×2) — `id="oblasti"`

**Cilj:** pregled ekspertize + interni linkovi ka SEO podstranicama.

**Desktop:**
```
                         ── OBLASTI RADA ──
┌────────────────────────┐┌────────────────────────┐┌────────────────────────┐
│ (◎)  Sterilitet i IVF   ││ (💬) Drugo mišljenje   ││ (▦) Jednodnevna dija-  │
│      Individualizovan.. ││      Nezavisna proc..  ││     gnostika sterilit. │
├────────────────────────┤├────────────────────────┤├────────────────────────┤
│ (▥)  Poor responders    ││ (♀)  PCOS i poremećaji ││ (⚲) Histeroskopija    │
│      Napredne strate..  ││      ovulacije         ││     Dijagnostička i... │
└────────────────────────┘└────────────────────────┘└────────────────────────┘
   Takođe: Zamrzavanje jajnih ćelija · Muški faktor neplodnosti · Redovni ginekološki pregledi · Sve oblasti →
```
- Kartica: **ikona levo** (40px zlatna, u tankom zlatnom krugu 56px), desno naslov serif 21px + opis 14.5px; desna strana kartice ima strelicu → koja se na hover pomera. Grid 3 kolone, gap 16px.
- Mapiranje (sve kartice su `<a>`):

| # | Ikona | Naslov | Opis (kratko, sa reference) | Link |
|---|---|---|---|---|
| 1 | `i-target` (krug sa jajnom ćelijom) | Sterilitet i IVF | Individualizovan pristup od dijagnostike do transfera embriona. | `/oblasti-rada/vantelesna-oplodnja-ivf/` |
| 2 | `i-chat` | Drugo mišljenje | Nezavisna procena i preporuka zasnovana na dokazima i iskustvu. | `/zakazivanje/?usluga=drugo-misljenje` (nema podstranice) |
| 3 | `i-calendar-grid` | Jednodnevna dijagnostika steriliteta | Ključne analize i ultrazvuk u jednom danu. `[POTVRDITI: da li se nudi kao poseban paket]` | `/zakazivanje/?usluga=prva-konsultacija` |
| 4 | `i-bars` | Poor responders | Prilagođene strategije za pacijentkinje sa slabijim odgovorom. | `/oblasti-rada/vantelesna-oplodnja-ivf/#slab-odgovor` (developer dodaje `id="slab-odgovor"` na odgovarajući H2/H3 na toj stranici; ako sekcija ne postoji → `/zakazivanje/?usluga=ivf`) |
| 5 | `i-female` | PCOS i poremećaji ovulacije | Dijagnostika i terapija sa fokusom na metaboličko i hormonsko zdravlje. | `/oblasti-rada/pcos-i-neplodnost/` |
| 6 | `i-uterus` | Histeroskopija | Dijagnostička i operativna histeroskopija u ambulantnim uslovima. `[POTVRDITI: da li dr Katanić radi histeroskopije]` | `/zakazivanje/?usluga=ginekoloski-pregled` |

- **Red "Takođe"** ispod grida (14px, centriran, zlatni linkovi razdvojeni `·`) — obavezan, da sve 5 SEO podstranica dobija link sa početne: Zamrzavanje jajnih ćelija, Muški faktor neplodnosti, Redovni ginekološki pregledi, "Sve oblasti rada →" (`/oblasti-rada/`).
- Uklanja se rečenica "u okviru tima Specijalne bolnice Ferona" iz uvoda sekcije (sekcija nema uvodni pasus — kao referenca).
- **Tablet:** 2 kolone × 3 reda.
- **Telefon:** 1 kolona, kompaktne kartice (ikona 32px levo, naslov 18px, opis 14px, strelica desno), razmak 10px; **ne karusel** (ovo su navigacioni linkovi — treba da se vide svi). Red "Takođe" postaje lista chip-ova (pill linkovi, wrap).
- Animacija: stagger reveal.

---

### 2.6 Proces konsultacije 01–05

**Cilj:** smanjiti strah od prvog dolaska — konsultacija = konkretan plan.

**Desktop:**
```
──────────── KONSULTACIJA NIJE SAMO PREGLED. KONSULTACIJA JE PLAN. ────────────
 01               02               03               04               05
 Analiza     →    Ultrazvučna  →   Procena      →   Individuali- →   Jasni
 dokumentacije    procena          prethodnog       zovana           naredni
                                   odgovora         strategija       koraci
 Detaljna         Procena          Razumevanje      Personalizovan   Precizan plan
 analiza...       ovarijalne...    kako ste...      plan lečenja...  i preporuke...
───────────────────────────────────────────────────────────────────────────────
```
- Eyebrow je ovde **naslov sekcije** (H2 vizuelno stilizovan kao eyebrow sa linijama koje se šire do ivica containera — kao na referenci). Za SEO/a11y: `<h2 class="eyebrow-rule">Konsultacija nije samo pregled. Konsultacija je plan.</h2>`.
- 5 kolona (`grid-template-columns: repeat(5,1fr)` + strelice kao `::after` pseudo-elementi između kolona, tanka zlatna strelica 28px). Broj serif 34px navy, naslov serif 17px 600, opis 13.5px muted.
- Pod sekcijom: link "Kako izgleda prva konsultacija →" (`/blog/prva-konsultacija-sta-poneti/`) i dugme outline "Zakaži konsultaciju" (desno poravnato). 
- Tekst koraka: postojeći tekst sa `index.html` je dobar; korak 05 — "Pismeni zaključak..." zadržati samo ako je potvrđeno `[POTVRDITI: da li pacijent dobija pismeni zaključak]`, inače tekst sa reference "Precizan plan i preporuke za sledeće korake."
- **Tablet:** 3 + 2 (grid 3 kolone; strelice se kriju, umesto njih brojevi imaju tanku liniju ispod).
- **Telefon: vertikalni timeline.**
```
 KONSULTACIJA NIJE SAMO
 PREGLED. KONSULTACIJA JE PLAN.
  ┌──┐
  │01│  Analiza dokumentacije
  └┬─┘  Detaljna analiza vaše medicinske istorije...
   │    (1px zlatna vertikalna linija, levo 22px)
  ┌┴─┐
  │02│  Ultrazvučna procena
  └┬─┘  ...
   ┆
  ┌┴─┐
  │05│  Jasni naredni koraci
  └──┘
 [   Zakaži konsultaciju   ]
```
  Brojevi u kružiću 44px (1px zlatna ivica, krem pozadina, serif 16px), linija se "iscrtava" odozgo nadole (scaleY) kad sekcija uđe — bez JS-a linija je puna. `<ol>` lista (semantički redosled).

---

### 2.7 O meni (foto + 3 kolone)

**Cilj:** ljudsko lice + trostruka ekspertiza (klinika / akademija / međunarodno).

**Desktop:**
```
┌───────────────────────┐   ── O MENI (eyebrow levo, linija samo desno)
│                       │   Klinička praksa, embriologija i istraživanje —
│   o-meni.webp         │   povezani u jednom pristupu.            (serif H2 38px)
│   (nasmejan za        │   Specijalista ginekologije i akušerstva sa fokusom na
│    stolom, 4:5)       │   reproduktivnu medicinu, IVF i ... (pasus 16px, 62ch)
│                       │   ─────────────────────────────────────────────
│                       │   (i) Klinički rad  │ (i) Akademski rad │ (i) Edukacija i
│                       │   Višegodišnje...   │ Master reprod...  │ međunarodni rad
│                       │                     │ doktorske studije │ Kontinuirana...
└───────────────────────┘   Više o meni →
```
- Grid `5fr 7fr`, gap 64px. Slika: 4:5, `object-fit: cover`, bez zaobljenja, sa **zlatnim offset okvirom** (1px linija pomerena 16px dole-desno iza slike — potpisni element, §7). Slika se na desktopu izliva do leve ivice containera (kao referenca — počinje na ivici).
- 3 kolone: ikona 28px (`i-stethoscope`, `i-mortarboard`, `i-globe`), H3 serif 18px, tekst 13.5px. Razdvojene 1px vertikalnim zlatnim linijama.
  - Klinički rad: "Rad u lečenju steriliteta, IVF programima i ginekologiji. Ordinira u SB Ferona, Novi Sad." `[POTVRDITI "višegodišnje iskustvo" i "histeroskopska hirurgija" sa reference — ne pisati dok se ne potvrdi]`
  - Akademski rad: "Master reproduktivne embriologije; doktorske studije na Medicinskom fakultetu u Novom Sadu — prediktivno modelovanje ovarijalnog odgovora." `[POTVRDITI]`
  - Edukacija i međunarodni rad: "Predavanja i učešće na stručnim skupovima (ESHRE, GIGANODE, Thrombosis Days) i edukacija pacijenata."
- Pasus: bez "u okviru tima Specijalne bolnice Ferona" kao identiteta; titula sme (`[POTVRDITI]` komentar).
- Link "Više o meni →" → `/o-meni/`.
- **Tablet:** slika 40% / tekst 60%, 3 kolone se slažu u 1 kolonu (ikona levo, tekst desno).
- **Telefon:** slika gore, puna širina (bez gutter-a, edge-to-edge), aspect 4:4.5, offset okvir se ne prikazuje (umesto njega tanka zlatna linija 48px ispod slike, centrirana). Zatim eyebrow, H2 28px, pasus, pa 3 stavke kao **vertikalna lista** (ikona 24px levo u krugu, naslov + tekst desno, 1px linija između). Link na kraju.
- Animacija: slika fade (opacity .0→1 samo uz reveal-ready pravilo) + 3 kolone stagger.

---

### 2.8 Navy traka (vrednosti)

**Cilj:** vizuelni predah + ritam (svetlo → tamno → svetlo), sažetak vrednosti. **Bez izmišljenih brojki** (referenca prikazuje nečitke statistike — ne kopirati, pravilo brief-v2 §3).

```
███████████████████████████████████████████████████████████████████████████████
█  (📅)              │  (👥)            │  (◎)             │  (⚲)       │ (📖)   █
█  Individualni      │  Vreme za        │  Embriološka     │  Plan zasno-│ Edu-  █
█  plan              │  razgovor        │  perspektiva     │  van na     │ kacija█
█                    │                  │                  │  dokazima   │       █
███████████████████████████████████████████████████████████████████████████████
```
- Navy `--color-primary` puna širina, padding 56px, 5 stavki u redu, razdvojene 1px `rgba(201,173,135,.35)` linijama. Ikona 36px `#C9AD87`, ispod 2 reda teksta 15px krem (serif). Stavke (copywriter može preformulisati, bez brojki):
  1. `i-calendar` — Individualni plan
  2. `i-people` — Vreme za razgovor i pitanja
  3. `i-embryo` — Embriološka perspektiva
  4. `i-uterus` — Odluke zasnovane na dokazima
  5. `i-book` — Edukacija pacijenata
- Suptilan dekor: veliki FK-monogram ili `logo-znak` u 4% opacity, desno, odsečen ivicom (CSS background, `aria-hidden`).
- `<section aria-label="Vrednosti">`, lista `<ul>`.
- **Tablet:** 3 + 2 (grid), linije horizontalne između redova.
- **Telefon:** **horizontalni scroll-snap** red (stavke 42% širine, ~2.3 vidljive, "peek" signalizira skrol) ILI 2 kolone grid sa 5. stavkom preko cele širine. Preporuka: **2-kolonski grid** (bez skrola; kratke stavke), padding 40px.

---

### 2.9 Nauka i edukacija (pločice konferencija)

**Cilj:** kredibilitet kroz stručnu vidljivost — samo potvrđeno.

**Potvrđeno u `research.md` / `web-research.md`:** ESHRE (kongres, prisustvo), GIGANODE International Panel (Švajcarska, "Infertility and Indications for Assisted Reproduction"), Thrombosis Days 2026 (Švajcarska, govornik), SPRING Fertility (mart 2026 — status `[POTVRDITI]` već postoji u README §7.11), Bio Save edukativni program / "Bebologijini krugovi" (potvrđeno i bedžom na `IMG_1740`), Divčibare (predavač, "Peripartum Hemorrhage").

**Sa reference, NEpotvrđeno → ne prikazivati vidljivo, samo HTML komentar:** Weill Cornell Seminar Salzburg, LH in ART — Sorrento, MSRM — Bari. `<!-- [POTVRDITI SA KLIJENTOM: učešće na Weill Cornell Seminar Salzburg, LH in ART Sorrento, MSRM Bari — sa reference; dodati pločice tek po potvrdi] -->`

**Desktop:**
```
                       ── NAUKA I EDUKACIJA ──
┌──────────┐┌──────────┐┌──────────┐┌──────────┐┌──────────┐┌──────────┐
│(◎) ESHRE ││(◎)GIGANO-││(◎)Thromb-││(◎) SPRING││(◎)Bio Save││(◎)Divči- │
│ kongres  ││ DE panel ││ osis Days││ Fertility││ edukacija ││ bare     │
│          ││ Švajcars.││ Švajcars.││          ││ za pacij. ││ predavanje│
└──────────┘└──────────┘└──────────┘└──────────┘└──────────┘└──────────┘
                    Mediji i predavanja →
```
- 6 pločica u redu (grid 6 kolona, gap 12px), bela kartica 1px ivica, visina 76px, ikona 24px levo + naziv 14px 600 navy + podnaslov 12px muted. Ikone: `i-congress` (ESHRE), `i-panel` (GIGANODE), `i-drop` (Thrombosis Days), `i-sprout` (SPRING), `i-mother` (Bio Save), `i-podium` (Divčibare).
- Pločice su linkovi → `/mediji-i-predavanja/#konferencije` (isti anchor; developer dodaje `id`).
- Opciono (desktop ≥ 1280): levo od pločica uska vertikalna fotografija `konferencija-panel.webp` (3:4, 220px) sa sitnim natpisom "Bio Save, Bebologijini krugovi" — daje ljudski kontekst. Ako se doda, grid postaje `220px 1fr` i pločice idu 3×2.
- **Tablet:** 3×2.
- **Telefon:** 2 kolone × 3 reda (pločice 64px visine, naziv 13px). Ne karusel — 6 pločica je malo i lako se vidi.
- Animacija: stagger reveal.

---

### 2.10 Journal (3 postojeća blog članka sa slikama)

**Cilj:** dokaz edukativnog pristupa + SEO interni linkovi.

**Desktop:**
```
                            ── JOURNAL ──
┌─────────┬─────────────┐┌─────────┬─────────────┐┌─────────┬─────────────┐
│ [slika] │ Koliko jaj- ││ [slika] │ Šta se zai- ││ [slika] │ Prva konsul-│
│  1:1.2  │ nih ćelija  ││         │ sta dešava  ││         │ tacija — šta│
│         │ je potrebno ││         │ tokom IVF   ││         │ poneti      │
│         │ Pročitaj  → ││         │ Pročitaj  → ││         │ Pročitaj  → │
└─────────┴─────────────┘└─────────┴─────────────┘└─────────┴─────────────┘
                          Svi članci →
```
- Horizontalna kartica (kao referenca): slika levo 42% (`object-fit: cover`, krop centra), desno naslov serif 22px + "Pročitaj više →". Ceo kartica = link. Hover: slika zoom 1.04.
- Članci i slike:
  1. `/blog/koliko-jajnih-celija-je-potrebno-za-embrion/` — `edukacija-embrioni-01.webp`
  2. `/blog/sta-se-zaista-desava-tokom-ivf-postupka/` — `edukacija-ivf-proces-01.webp`
  3. `/blog/prva-konsultacija-sta-poneti/` — **nema sliku na blog listi danas**; koristiti `edukacija-ivf-proces-04.webp` ("Pre straha — činjenice. Pre odluke — plan.") — tematski odgovara; isto dodati i na `/blog/` listu.
- Napomena: slike su IG kartice sa tekstom — krop na kartici će odseći deo teksta; to je OK za thumbnail (alt opisuje karticu). Alt: "Naslovna kartica članka: …".
- **Tablet:** 1 kolona, horizontalne kartice (slika 35%).
- **Telefon:** **horizontalni scroll-snap**, kartice **vertikalne** (slika gore 16:10, naslov ispod) širine 82%. Ispod "Svi članci →". Alternativa 1 kolona — developer bira karusel (konzistentno sa §2.4).

---

### 2.11 CTA traka sa logo znakom

**Cilj:** završni poziv; jedan jasan korak.

**Desktop:**
```
┌──────────────────────────────────────────────────────────────────────────────┐
│ ┌──────┐  Zakažite konsultaciju i napravimo plan            [Zakaži konsult.]│
│ │ znak │  koji je pravi za vas.                    (serif 36px)               │
│ └──────┘  Individualna konsultacija, jasni koraci i plan koji odgovara vašoj  │
│           situaciji.                                     ░░ (dekor desno)     │
└──────────────────────────────────────────────────────────────────────────────┘
```
- Pozadina: topla bež `#F1EBE1` (tamnija od krema), ne navy (navy je footer odmah ispod — referenca ima svetlu traku). Levo: `logo-znak.png` 88px u **kvadratnom zlatnom okviru** (1px, padding 12px) — isti jezik kao FK monogram u headeru. Sredina: H2 + pasus. Desno: navy dugme `Zakaži konsultaciju` → `/zakazivanje/` + ispod sitno "ili pišite na Instagramu @drfilipkatanic".
- Dekor desno (referenca ima vazu sa granama): **ne fotografija** — umesto toga tanka zlatna linijska ilustracija grančice (SVG, 120px, 40% opacity), opciono. Bez izmišljenih slika.
- Partial `cta-band.html` se **prepisuje**: uklanja se "Zakažite u SB Feroni", Ferona telefon i adresa kao kontakt. Ostaje citat (`g.citat`) kao sitan italic ispod? Preporuka: citat izbaciti iz trake (traka mora biti čista), citat ide u footer.
- **Tablet:** znak gore-levo, tekst, dugme ispod (levo poravnato).
- **Telefon:** centrirano: znak 64px u okviru, H2 26px, pasus 15px, dugme full width, IG link ispod. Padding 48px.

---

### 2.12 Footer (navy)

**Desktop (referenca: jedan red sa kontaktima + kompletiran sitemap za SEO):**
```
████████████████████████████████████████████████████████████████████████████████
█ dr Filip Katanić         (☎) [POTVRDITI tel] │ (✉) [POTVRDITI mejl] │ (◎) @drfilipkatanic │ (⌖) Ordinira: SB Ferona, Novi Sad █
█ Reproduktivna medicina ──                                                     █
█ ─────────────────────────────────────────────────────────────────────────────█
█ OBLASTI RADA          SAJT                    ZAKAZIVANJE                    [znak]█
█ IVF / ICSI            O meni                  Zakaži konsultaciju →               █
█ Zamrzavanje j. ćelija Konsultacija            „Ne možemo kontrolisati baš sve,   █
█ PCOS i neplodnost     Blog                     ali možemo napraviti najbolji     █
█ Muški faktor          Pitanja i odgovori       plan.“ (citat, italic)            █
█ Redovni pregledi      Mediji i predavanja                                         █
█                       Kontakt                                                     █
█ ─────────────────────────────────────────────────────────────────────────────█
█ Disclaimer (12px, 60%): Sadržaj sajta je informativan ... Postupci se obavljaju █
█ u SB Ferona, Novi Sad, gde dr Katanić ordinira. ...                             █
█ © 2026 dr Filip Katanić · Politika privatnosti            Nazad na vrh ↑        █
████████████████████████████████████████████████████████████████████████████████
```
- Brend levo: ime serif 26px krem + "Reproduktivna medicina ——" zlatno. **Nema** naslova "Kontakt / Ustanova", nema Ferona telefona/mejla, nema "Kontakt centar ustanove".
- Kontakt red: telefon i mejl dolaze iz `site.json` (`g.tel`, `g.email`) — **renderuju se samo ako nisu prazni** (build uslov; dok su `[POTVRDITI]` placeholder, prikazuje se samo IG + "Zakaži online" link). Lokacija: "Ordinira u SB Ferona, Šarplaninska 19, Novi Sad" → link na Google mape.
- Godina: `{{year}}` (ne "2024" kao na referenci).
- Veliki dekorativni "KATANIĆ" watermark (postoji) — zadržati, ali zameniti `seal` sa novim FK monogramom.
- **Tablet:** kontakt red se lomi u 2×2; kolone sitemap-a 3.
- **Telefon:** sve u jednoj koloni, centrirano: brend, kontakt stavke kao lista sa ikonama (min 44px visina tap target), sitemap kolone kao **akordeoni** (`<details>`; bez JS-a rade nativno), disclaimer, copyright. Footer ima donji padding = visina sticky bara.

---

### 2.13 Šta se UKLANJA sa početne

- Sekcija `#zakazivanje` sa formom i "Direktan kontakt" karticom (WhatsApp/Viber `+381 63 102 2442` — **nepoznato čiji broj, ne postoji u research.md/web-research.md** → ukloniti dok se ne potvrdi; Ferona telefon/mejl). Forma se seli na `/zakazivanje/`.
- FAQ teaser — **opciono zadržati** ispod Journal-a? Referenca ga nema. Odluka: **ukloniti sa početne** (FAQ JSON-LD ostaje na `/pitanja-i-odgovori/`; početna dobija link "Pitanja i odgovori" u Journal sekciji pored "Svi članci"). Ako SEO agent insistira na FAQ na početnoj → kompaktni akordeon od 3 pitanja između Journal-a i CTA trake, istog stila.
- "Edukacija — Razumeti proces..." sekcija se zamenjuje Journal-om.
- `{{> venue}}` traka u hero-u.

### 2.14 Front matter početne (izmene)
- `title`: "dr Filip Katanić – Reproduktivna medicina, IVF i sterilitet | Novi Sad"
- `description`: "dr Filip Katanić — reproduktivna medicina, IVF i lečenje steriliteta u Novom Sadu. Individualizovan plan, jasna komunikacija i online zakazivanje konsultacije." (bez "član tima SB Ferona" kao identiteta)
- `preload`: `assets/img/hero-portret.webp` (+ mobile kroz `media`)
- `scripts`: — (booking.js više nije potreban na početnoj)

### 2.15 Spisak inline SVG ikona (linijske, 32×32, stroke 1.25)

| ID | Motiv | Gde |
|---|---|---|
| `i-doctor` | poprsje + stetoskop oko vrata | hero kred. 1 |
| `i-dna` | dvostruka spirala | hero kred. 2 |
| `i-microscope` | mikroskop | hero kred. 3 |
| `i-pin` | lokacijski pin | hero "Ordinira u…", footer, zakazivanje |
| `i-sprout` | klica sa 2 lista | "Kada" 1, SPRING pločica |
| `i-cycle` | kružne strelice | "Kada" 2 |
| `i-chart-down` | linijski grafikon nadole | "Kada" 3 |
| `i-question` | upitnik u krugu | "Kada" 4 |
| `i-target` | jajna ćelija (krug u krugu sa tačkama) | Oblasti 1 |
| `i-chat` | oblačić govora | Oblasti 2 |
| `i-calendar-grid` | kalendar sa mrežom | Oblasti 3 |
| `i-bars` | stubičasti grafikon | Oblasti 4 |
| `i-female` | simbol ♀ | Oblasti 5 |
| `i-uterus` | stilizovana materica | Oblasti 6, navy traka 4 |
| `i-arrow-right` | tanka strelica | proces, linkovi |
| `i-stethoscope` | stetoskop | O meni 1 |
| `i-mortarboard` | akademska kapa | O meni 2 |
| `i-globe` | globus | O meni 3 |
| `i-calendar` | kalendar | navy traka 1, forma datum |
| `i-people` | dve osobe | navy traka 2 |
| `i-embryo` | ćelija u deobi (2–4 kruga) | navy traka 3 |
| `i-book` | otvorena knjiga | navy traka 5 |
| `i-congress` `i-panel` `i-drop` `i-mother` `i-podium` | zgrada sa stubovima / 3 osobe za stolom / kap / majka sa bebom / govornica | Nauka i edukacija |
| `i-phone` `i-mail` `i-instagram` `i-whatsapp` `i-viber` | kontakt | footer, forma (kanal) |
| `i-check` `i-alert` `i-spinner` | stanja forme | zakazivanje, admin |
| `i-clock` `i-file` `i-user` | doba dana / dokumentacija / partner | forma |

Brend ikone (Instagram/WhatsApp/Viber) takođe u linijskoj verziji (outline), ne pune — konzistentno.

---

## 3. `/zakazivanje/` — stranica sa formom

### 3.1 Cilj i odluka
**Jedna elegantna forma u kartici + bočni panel "Šta očekivati"** (ne 2 koraka). Razlog: polja su malo (7 obaveznih), dvo-koračni wizard dodaje JS zavisnost i gubi se pregled; ali forma je **vizuelno podeljena u 3 grupe** (fieldset-ovi sa brojem) da deluje kao vođen proces:
1. Vaši podaci  2. Termin i razlog  3. Dodatno (opciono)

### 3.2 Desktop (≥ 1024)
```
header
┌───────────────────────────────────────────────────────────────────────────────┐
│ Početna / Zakazivanje                                         (breadcrumb)     │
│ ── ZAKAZIVANJE ──                                                              │
│ Zakažite konsultaciju                         (serif H1 56px)                  │
│ Pošaljite zahtev — javićemo vam se sa potvrdom termina. (lead)                 │
├──────────────────────────────────────────────────┬────────────────────────────┤
│ ┌──────────────────────────────────────────────┐ │ ┌────────────────────────┐ │
│ │ 1  VAŠI PODACI                               │ │ │ [portret-mantil, oval] │ │
│ │ Ime i prezime*        │ Ime partnera (opc.)  │ │ │ dr Filip Katanić       │ │
│ │ E-mail*               │ Telefon*             │ │ │ Reproduktivna medicina │ │
│ │ Kako da vas kontaktiramo?*                   │ │ ├────────────────────────┤ │
│ │ (○Telefon)(○Viber)(○WhatsApp)(○E-mail)  chip │ │ │ ŠTA OČEKIVATI          │ │
│ │ ──────────────────────────────────────────── │ │ │ 01 Analiza dokument.   │ │
│ │ 2  TERMIN I RAZLOG                           │ │ │ 02 Ultrazvučna procena │ │
│ │ Razlog konsultacije* [select ▾]              │ │ │ 03 Procena odgovora    │ │
│ │ Željeni datum*  [📅]  │ Doba dana (seg.)     │ │ │ 04 Strategija          │ │
│ │                       │ [Pre podne|Posle|Sve]│ │ │ 05 Jasni koraci        │ │
│ │ ──────────────────────────────────────────── │ │ ├────────────────────────┤ │
│ │ 3  DODATNO (opciono)                         │ │ │ ⌖ MESTO ORDINIRANJA    │ │
│ │ Medicinska dokumentacija (seg.)              │ │ │ SB Ferona              │ │
│ │ [Imam | Delimično | Nemam]                   │ │ │ Šarplaninska 19,       │ │
│ │ Napomena [textarea]           0 / 2000       │ │ │ 21000 Novi Sad         │ │
│ │ ──────────────────────────────────────────── │ │ │ Otvori u mapama →      │ │
│ │ ☐ Saglasan/na sam ... Politika privatnosti*  │ │ ├────────────────────────┤ │
│ │ [        Pošalji zahtev  →        ]          │ │ │ ⓘ Ovo je zahtev, ne    │ │
│ │ 🔒 Podaci se koriste samo za zakazivanje.     │ │ │ potvrđen termin. Potvr-│ │
│ └──────────────────────────────────────────────┘ │ │ du dobijate mejlom.    │ │
│                                                  │ └────────────────────────┘ │
└──────────────────────────────────────────────────┴────────────────────────────┘
CTA traka: NE (cta: none)   footer
```
- Grid `7fr 4fr`, gap 48px. Bočni panel `position: sticky; top: header+24px`.
- Kartica forme: bela, 1px ivica, zlatna linija 2px na vrhu, padding 40px. Fieldset naslovi: broj u zlatnom kružiću 28px + uppercase 12px eyebrow.
- Page hero ovde je kompaktan (bez slike) — fokus na formi.

### 3.3 Polja (tačno po API ugovoru)

| Polje (`name`) | Kontrola | Obavezno | Validacija (klijent; server je izvor istine) | Napomena |
|---|---|---|---|---|
| `csrf_token` | hidden | da | — | puni se iz `GET api/csrf.php` na učitavanje stranice (i ponovo pre slanja ako je prošlo > 20 min) |
| `ime_prezime` | text, `autocomplete="name"` | * | 2–100 znakova, bar 2 reči? → **ne** (neki pišu samo ime); min 2 znaka | |
| `email` | email, `autocomplete="email"`, `inputmode="email"` | * | `type=email` + regex `.+@.+\..+` | |
| `telefon` | tel, `autocomplete="tel"`, `inputmode="tel"` | * | 6–20 cifara posle uklanjanja razmaka, `+`, `/`, `-` | placeholder "06x xxx xxxx" |
| `kontakt_kanal` | radio grupa kao chip-ovi (fieldset+legend) | * | jedna od `telefon|viber|whatsapp|email` | **bez predizbora** (svesna odluka pacijenta); ikona u chip-u |
| `tip_usluge` | `<select>` | * | enum (tabela §1.1) | predizbor iz `?usluga=`; ako parametar nevažeći → ignorisati |
| `zeljeni_datum` | `type="date"`, `min`=danas (lokalna zona, NE `toISOString` UTC — sadašnji booking.js greši posle ponoći/pre 1h) | * | ≥ danas, ≤ danas+180 dana | ispod sitno: "Okvirni datum — tačan termin potvrđujemo." Vikendi dozvoljeni? → `[POTVRDITI radne dane]`, za sada dozvoljeni |
| `doba_dana` | segmentirana kontrola (3 radio dugmeta u traci) | ne | `pre-podne|posle-podne|svejedno` | default `svejedno` |
| `partner_ime` | text, `autocomplete="off"` | ne | max 100 | labela "Ime partnera (opciono)" |
| `dokumentacija_status` | segmentirana kontrola | ne | `imam|nemam|delimicno` | labela "Da li imate prethodne nalaze?"; bez defaulta |
| `napomena` | textarea 4 reda, auto-grow | ne | max 2000, živi brojač "0 / 2000" (`aria-live="polite"` samo kad pređe 1800) | placeholder: "Npr. prethodni postupci, AMH, pitanja…" + upozorenje sitno: "Ne morate slati detaljne medicinske podatke — o tome razgovaramo na konsultaciji." |
| `saglasnost` | checkbox `value="1"` | * | čekiran | tekst: "Saglasan/na sam da se moji podaci koriste isključivo za zakazivanje konsultacije, u skladu sa [Politikom privatnosti]." |
| `website` | text, honeypot | mora prazno | — | u `div` sa `position:absolute; left:-9999px`, `tabindex="-1"`, `autocomplete="off"`, `aria-hidden="true"`, labela "Ne popunjavati" |

Forma ima `action="{{root}}api/zakazi.php" method="post" enctype="multipart/form-data"` — **radi i bez JS-a** (server tada vraća HTML redirect na `/zakazivanje/?poslato=1` ili prikaz greške; dogovoriti sa backend agentom: ako `Accept` nije JSON → 303 redirect). Bez JS-a nema CSRF tokena iz GET-a → backend može da izda token i kroz cookie (double-submit) — **napomena backend agentu**. Ako se ne podrži, `<noscript>` poruka iznad forme: "Za slanje forme potreban je JavaScript. Možete nam pisati i na Instagramu."

### 3.4 Validacija i UX
- Validacija na `blur` (posle prve interakcije) i na submit; ne na svaki keystroke pre blur-a.
- Greška: crvena (`#A23B2A`, AA na beloj) 1px ivica + ikona `i-alert` + tekst ispod polja (`id="err-email"`, polje `aria-invalid="true" aria-describedby="err-email"`).
- Na submit sa greškama: **error summary** kartica na vrhu forme ("Proverite 2 polja:" + linkovi na polja), fokus na summary (`tabindex="-1"`), `role="alert"`.
- Server greške `fields` mapiraju se na ista polja; opšta `error` poruka u summary.
- `429`: "Previše pokušaja. Pokušajte ponovo za nekoliko minuta ili pišite na Instagramu."
- Mrežna greška: "Zahtev nije poslat — proverite internet vezu i pokušajte ponovo." Podaci ostaju u formi.
- Dugme na telefonu je uvek dostupno (forma nije previsoka da bi trebalo sticky dugme).

### 3.5 Stanja
| Stanje | Prikaz |
|---|---|
| Početno | forma; ako `?usluga=` → select predizabran + mala zlatna oznaka iznad forme "Izabrano: Drugo mišljenje · promeni" (link fokusira select) |
| Slanje | dugme: spinner + "Šaljem…", `disabled`, `aria-busy="true"` na formi; polja `readonly` (ne `disabled` — da ostanu u FormData) |
| Uspeh | kartica forme se **zamenjuje** (ne alert) panelom: zlatni krug sa `i-check` (iscrtava se 600ms), H2 "Hvala, zahtev je primljen.", tekst "Na vaš e-mail [adresa] poslaćemo potvrdu ili predlog drugog termina. Ako ne vidite poruku, proverite i spam folder." + broj zahteva `#N` + dugmad "Nazad na početnu" / "Pročitajte: Prva konsultacija — šta poneti". Fokus na H2, `role="status"`. URL dobija `?poslato=1` (history.replaceState) da refresh ne šalje ponovo. |
| Greška | error summary (gore) — forma ostaje popunjena |

### 3.6 Pristupačnost
- Svako polje ima vidljivu `<label>` (nema placeholder-kao-labela); obavezna polja `*` + `required` + na vrhu "Polja označena * su obavezna".
- Radio/segmenti: `<fieldset><legend>`, nativni `input type=radio` vizuelno skriveni, fokus prsten na labeli (2px zlatni outline + 2px offset).
- Tap target ≥ 44px; font polja 16px (sprečava iOS zoom).
- Kontrast: labela navy na beloj, hint `#6B655D` (AA).
- `autocomplete` atributi kao u tabeli; `lang` atribut stranice već je sr-Latn.

### 3.7 Tablet i telefon
- **Tablet:** jedna kolona; bočni panel ide **ispod forme**, ali "ŠTA OČEKIVATI" skraćeno + lokacija u 2 kolone.
- **Telefon (< 768):**
```
┌──────────────────────────────┐
│ Početna / Zakazivanje        │
│ Zakažite konsultaciju (H1 34)│
│ lead 15px                    │
│ ┌──────────────────────────┐ │  info traka (kolaps): "Šta očekivati?" ▾
│ │ ⓘ Šta očekivati?       ▾ │ │  <details> sa 01–05 i lokacijom
│ └──────────────────────────┘ │
│ ┌──────────────────────────┐ │  kartica forme: padding 20px, BEZ bočnih ivica
│ │ 1 VAŠI PODACI            │ │  (puna širina, samo gornja zlatna linija)
│ │ Ime i prezime*           │ │  sva polja 1 kolona
│ │ [______________________] │ │
│ │ E-mail*  [_____________] │ │
│ │ Telefon* [_____________] │ │
│ │ Kontakt: (Tel)(Viber)    │ │  chip-ovi 2×2 grid
│ │          (WA)(E-mail)    │ │
│ │ 2 TERMIN I RAZLOG        │ │
│ │ Razlog*  [select      ▾] │ │
│ │ Datum*   [__________📅]  │ │  nativni date picker
│ │ Doba dana [Pre|Posle|Sve]│ │  segment 3 jednaka dela
│ │ 3 DODATNO                │ │
│ │ ...                      │ │
│ │ ☐ Saglasnost             │ │
│ │ [   Pošalji zahtev →   ] │ │  52px full width
│ └──────────────────────────┘ │
│ ⌖ SB Ferona, Šarplaninska 19 │  lokacija kartica
│ Instagram @drfilipkatanic    │
└──────────────────────────────┘
```
- Sticky bar se ne prikazuje. Pri fokusu polja, `scroll-margin-top: header+16px`.

### 3.8 SEO / schema
- H1 "Zakažite konsultaciju"; `BreadcrumbList` (Početna → Zakazivanje).
- `/politika-privatnosti/` **mora** da se dopuni (forma sada prikuplja lične i potencijalno zdravstvene podatke): ko je rukovalac (dr Filip Katanić `[POTVRDITI pravni oblik / ko je rukovalac]`), svrha, rok čuvanja, prava, mejl za zahteve. Ukloniti rečenicu "Ovaj sajt trenutno ne sadrži kontakt formular".

---

## 4. Ostale stranice — isti premium izgled

### 4.1 Zajednički šablon podstranice
```
┌───────────────────────────────────────────────────────────────────────────┐
│ Početna / Oblasti rada / Vantelesna oplodnja           (breadcrumb 13px)  │
│ ── OBLASTI RADA ──   (eyebrow, levo poravnato, linija samo desno)          │
│ Vantelesna oplodnja (IVF) i ICSI          (serif H1 clamp(36px,5vw,60px))  │
│ Lead pasus 18px, max 60ch                                       [slika?]  │
│ ─────────────────────────────── (1px zlatna linija, puna širina container)│
├──────────────────────────────────────────────┬────────────────────────────┤
│ Sadržaj (prose, max 68ch ≈ 680px)            │ ┌────────────────────────┐ │
│ H2 serif 32px, razmak 56px iznad             │ │ [FK]                   │ │
│ pasusi 17px/1.7                              │ │ Zakažite konsultaciju  │ │
│ liste sa zlatnim crticama                    │ │ Individualni plan za   │ │
│ citati: levo 2px zlatna linija, serif italic │ │ vašu situaciju.        │ │
│ FAQ akordeoni (postojeći {{faq}})            │ │ [Zakaži konsultaciju]  │ │
│                                              │ │ ⌖ Ordinira: SB Ferona  │ │
│                                              │ └────────────────────────┘ │
│                                              │ (sticky, top: hdr+32)      │
│                                              │ "Na ovoj stranici" TOC     │
│                                              │ (H2 anchori, samo ≥1024)   │
└──────────────────────────────────────────────┴────────────────────────────┘
CTA traka · footer
```
- Page hero: krem, **bez navy pozadine** (sadašnji `hero on-dark` na `/o-meni/` i `/kontakt/` → prelazi na svetli hero; navy ostaje za trake/footer — ritam kao na referenci). Hero nema `.reveal` (pravilo 2.0).
- Grid `minmax(0, 680px) 300px`, gap 80px, centrirano u containeru.
- **Bočna CTA kartica** = novi partial `src/partials/aside-cta.html`: bela, 1px ivica, 2px zlatna linija gore, FK monogram 40px, H3 serif "Zakažite konsultaciju", 1 rečenica, navy dugme → `/zakazivanje/?usluga={{usluga}}` (front matter `usluga:` po stranici — IVF → `ivf`, zamrzavanje → `zamrzavanje-jajnih-celija`, PCOS → `pcos`, muški faktor → `muski-faktor`, redovni pregledi → `ginekoloski-pregled`, blog/FAQ/ostalo → bez parametra), ispod "⌖ Ordinira u SB Ferona, Novi Sad".
- Ovo zamenjuje sadašnja dugmad "Zakažite u SB Feroni" u hero-u podstranica (linija 19 u svakoj `oblasti-rada/*.html`) — u hero-u ostaje navy dugme "Zakaži konsultaciju" + outline "Pitanja i odgovori".
- **Tablet/telefon:** jedna kolona; bočna kartica se **ne ponavlja na vrhu** — prikazuje se jednom, posle prvog H2 bloka (CSS `order` ili duplikat u HTML-u sa `hidden` po breakpointu — preporuka: jedan HTML element, CSS grid `grid-template-areas` koji ga na mobilnom stavlja posle sadržaja; plus sticky bar pokriva CTA). TOC se krije.
- Slike u sadržaju: puna širina prose kolone, `figure` sa sitnim captionom 13px muted; IG serije (karuseli 1/5–5/5) ostaju lightbox kao sada.

### 4.2 `/o-meni/` (nove slike)
- Page hero (split, kao početna ali manji): levo eyebrow "O MENI", H1 "dr Filip Katanić", podnaslov zlatni "Specijalista ginekologije i akušerstva · Master reproduktivni embriolog" (`[POTVRDITI titula]`), lead, dugme "Zakaži konsultaciju". Desno `portret-mantil.webp` (krop bez Ferona logoa) sa zlatnim offset okvirom. Telefon: slika gore sa gradijentom kao početni hero (isti komponent `.hero--split`, manja visina).
- "Ko sam ja": tekst + `o-meni.webp` (nasmejan za stolom) — **zamenjuje** `brend-vizual-01.webp`.
- "Obrazovanje i afilijacije": timeline (isti stil kao proces 01–05 vertikalni): MD → Master reproduktivne embriologije → Doktorske studije (MF Novi Sad, `[POTVRDITI]`) → "Ordinira u SB Ferona, Novi Sad" (umesto "Član tima SB Ferona"; status zaposlenja i dalje `[POTVRDITI]`).
- "Van ordinacije" / konferencije: `konferencija-panel.webp` kao velika slika + postojeće `konferencija-01..04`; pločice konferencija iste kao na početnoj (§2.9).
- `portret-01.webp` (SPRING) ostaje na `/mediji-i-predavanja/`.
- Title/description bez "| SB Ferona" (vidi §5).

### 4.3 `/kontakt/`
**Odluka:** `/kontakt/` NE duplira celu formu (jedan izvor istine = `/zakazivanje/`; manje održavanja, jasnije za analitiku). Umesto toga veliki CTA blok + kanali + lokacija.
```
Početna / Kontakt
── KONTAKT ──
Kontakt                                             (H1)
Najbrži put do termina je online zahtev.            (lead)
┌─────────────────────────────────────┐ ┌──────────────────────────┐
│ (navy kartica, velika)              │ │ (i) Instagram            │
│ ZAKAZIVANJE                         │ │ @drfilipkatanic        → │
│ Zakažite konsultaciju online        │ ├──────────────────────────┤
│ Popunite kratak zahtev — potvrdu    │ │ (☎) Telefon [POTVRDITI]  │  ← render samo ako g.tel postoji
│ ili predlog termina dobijate mejlom.│ ├──────────────────────────┤
│ [ Zakaži konsultaciju → ] (zlatno)  │ │ (✉) E-mail [POTVRDITI]   │  ← render samo ako g.email postoji
└─────────────────────────────────────┘ └──────────────────────────┘
── MESTO ORDINIRANJA ──
┌──────────────────────────────┬────────────────────────────────────┐
│ ⌖ SB Ferona                  │  [ mapa — "Učitaj mapu" klik,      │
│ Šarplaninska 19              │    postojeće lazy rešenje ]        │
│ 21000 Novi Sad               │                                    │
│ Konsultacije i postupci se   │                                    │
│ obavljaju u SB Ferona.       │                                    │
│ Otvori u Google mapama →     │                                    │
└──────────────────────────────┴────────────────────────────────────┘
```
- Uklanja se: "Zakažite u SB Feroni" tile sa Ferona telefonom, "Kontakt centar SB Ferona… Telefon i email pripadaju ustanovi", Ferona mejl. Ako klijent kaže da se zakazivanje i dalje može obaviti preko Ferona kontakt centra → dodati **sekundarnu**, sitnu napomenu u lokacijskoj kartici "Termin možete zakazati i preko kontakt centra SB Ferona: +381 21 3000 220" `[POTVRDITI SA KLIJENTOM da li to želi]` — nikada kao glavni kontakt.
- Telefon: navy kartica gore, kanali ispod (1 kolona), lokacija, mapa (aspect 4:3).
- Front matter: `cta: none` ostaje; title "Kontakt – dr Filip Katanić | Novi Sad"; description bez Ferona telefona/mejla.
- `RADNO_VREME=False` ostaje.

### 4.4 `/mediji-i-predavanja/`
- Page hero: `konferencija-panel.webp` (Bio Save panel) umesto `portret-01.webp`; `portret-01` ide u konferencijsku galeriju. Hero bez `.reveal`.
- Pločice konferencija (§2.9) na vrhu sekcije `id="konferencije"`.

### 4.5 `/oblasti-rada/` hub
- Grid kartica kao §2.5 (sa 5 pravih podstranica + "Drugo mišljenje" + "Prva konsultacija" kartice ka `/zakazivanje/?usluga=…`).
- Sekcija `aria-label="SB Ferona"` → preimenovati u "Mesto ordiniranja" i formulisati: "Konsultacije i postupci obavljaju se u SB Ferona, Šarplaninska 19, Novi Sad."

### 4.6 Blog, FAQ, politika privatnosti
- Blog lista: kartice kao Journal (§2.10), 3 kolone desktop / 1 kolona telefon; dodati sliku za "Prva konsultacija".
- Blog članak: šablon 4.1 + na kraju "autor" boks (mali `portret-mantil` krug 64px + "dr Filip Katanić · Reproduktivna medicina" + link O meni) — E-E-A-T.
- FAQ: šablon 4.1; odgovori o ceni: "Cena zavisi od individualnog plana — informacije dobijate pri zakazivanju." (umesto "obratite se kontakt centru SB Ferona").

---

## 5. Ferona — gde se pojavljuje kao vlasnik/brend/kontakt i šta treba da piše

Pravilo: Ferona = **mesto ordiniranja** ("Ordinira u SB Ferona, Novi Sad" / "Konsultacije i postupci se obavljaju u SB Ferona"). Interne `[POTVRDITI…]` HTML komentare koji pominju Feronu (nisu vidljivi) **ne treba** menjati.

### 5.1 Partiali
| Fajl:linija | Sada | Treba |
|---|---|---|
| `partials/header.html:27` | dugme "Zakažite u SB Feroni" → `kontakt/#zakazivanje` | "Zakaži konsultaciju" → `{{root}}zakazivanje/` |
| `partials/header.html:28` | `hdr-tel` ikona → Ferona `tel:` | **ukloniti** (ili render samo ako `g.tel` doktora postoji) |
| `partials/header.html:4–6` | `brand__sub` "Ginekologija · IVF" | "Reproduktivna medicina" + novi FK monogram |
| `partials/header.html:54` | mobilni meni "Zakažite u SB Feroni" → Ferona `tel:` | "Zakaži konsultaciju" → `/zakazivanje/` |
| `partials/header.html:56` | `{{g.ferona}} · {{g.adresa}} · {{g.tel}}` | "Ordinira u SB Ferona, Novi Sad" (bez telefona) |
| `partials/sticky-bar.html:2` | "Zakažite u SB Feroni" → Ferona `tel:` | "Zakaži konsultaciju" → `/zakazivanje/` |
| `partials/cta-band.html:7` | "Zakažite u SB Feroni" | "Zakaži konsultaciju" → `/zakazivanje/` |
| `partials/cta-band.html:10` | Ferona tel + adresa kao kontakt | ukloniti; (opciono sitno: "Konsultacije u SB Ferona, Novi Sad") |
| `partials/footer.html:5–11` | kolona "Kontakt / Ustanova": Ferona adresa, tel, mejl, "Kontakt centar ustanove…" | kontakt red iz §2.12 (tel/mejl doktora iz `site.json` ako postoje, IG, "Ordinira u SB Ferona, Novi Sad") |
| `partials/footer.html:16` | "Lekar · Master reproduktivne embriologije · Član tima SB Ferona" | "Reproduktivna medicina · IVF · Klinička istraživanja" |
| `partials/credential.html:1` | "… · Član tima SB Ferona" | "Specijalista ginekologije i akušerstva · Master reproduktivni embriolog" (`[POTVRDITI]`) ili "Reproduktivna medicina · IVF" |
| `partials/venue.html:1` | "Postupci se sprovode u okviru SB Ferona…" + "Kontakt i mapa" | OK kao informacija; tekst: "Konsultacije i postupci se obavljaju u SB Ferona, Šarplaninska 19, Novi Sad." link "Lokacija i mapa" |
| `partials/venue-card.html:3` | eyebrow `{{g.ferona}}` | eyebrow "Mesto ordiniranja", ispod "SB Ferona" — OK |

### 5.2 Stranice
| Fajl:linija | Sada | Treba |
|---|---|---|
| `pages/index.html:3` (description) | "… i član tima SB Ferona u Novom Sadu" | §2.14 |
| `pages/index.html:13` | "…u okviru tima Specijalne bolnice Ferona." | hero uvod sa reference + "Ordinira u SB Ferona, Novi Sad." |
| `pages/index.html:15–18` | pill "SB Ferona, Novi Sad" kao kredencijal | zamenjuju ga 3 kredencijala (§2.2) |
| `pages/index.html:80` | "…u okviru tima Specijalne bolnice Ferona." | ukloniti pasus |
| `pages/index.html:171` | "Rad u okviru tima Specijalne bolnice Ferona…" | §2.7 tekst "Ordinira u SB Ferona, Novi Sad." |
| `pages/index.html:233–439` | cela booking sekcija (Ferona tel/mejl, "jednodnevna dijagnostika u SB Ferona", WA/Viber nepoznat broj) | **uklanja se** (seli na `/zakazivanje/`, bez Ferona kanala) |
| `pages/kontakt.html:2–3` | title "…, SB Ferona"; description sa Ferona tel/mejlom | "Kontakt – dr Filip Katanić \| Novi Sad"; "Zakažite konsultaciju kod dr Filipa Katanića online ili preko Instagrama. Ordinira u SB Ferona, Šarplaninska 19, Novi Sad." |
| `pages/kontakt.html:13–15, 22, 33–35` | "Zakažite u SB Feroni", kontakt centar, mejl ustanove | §4.3 |
| `pages/kontakt.html:29` | skriveni H2 "SB Ferona" | "Mesto ordiniranja" |
| `pages/o-meni.html:2–3` | title "… \| SB Ferona, Novi Sad"; desc "član tima Specijalne bolnice Ferona" | "O meni – dr Filip Katanić \| Reproduktivna medicina, Novi Sad"; desc: "…Ordinira u SB Ferona u Novom Sadu." (na kraju, kao informacija) |
| `pages/o-meni.html:15` | "Zakažite u SB Feroni" | "Zakaži konsultaciju" |
| `pages/o-meni.html:32` | "…u okviru tima SB Ferona u Novom Sadu." | "…Ordiniram u SB Ferona u Novom Sadu." |
| `pages/o-meni.html:44` | "Član tima SB Ferona, Novi Sad" | "Ordinira u SB Ferona, Novi Sad" |
| `pages/oblasti-rada/*.html:19` (5 fajlova) | "Zakažite u SB Feroni" | "Zakaži konsultaciju" → `/zakazivanje/?usluga=…` |
| `pages/oblasti-rada/index.html:9` | "…u okviru tima SB Ferona." | "Pregled oblasti u kojima dr Filip Katanić radi." |
| `pages/oblasti-rada/index.html:51` | sekcija `aria-label="SB Ferona"` | "Mesto ordiniranja" (§4.5) |
| `pages/oblasti-rada/zamrzavanje-jajnih-celija.html:74` | "…obratite se kontakt centru SB Ferona." | §4.6 formulacija o ceni |
| `pages/pitanja-i-odgovori.html:49` | isto | isto |
| `pages/blog/prva-konsultacija-sta-poneti.html:53` | "Zakažite u SB Feroni" | "Zakaži konsultaciju" → `/zakazivanje/?usluga=prva-konsultacija` |
| `pages/politika-privatnosti.html:15, 22` | "kontakt centru SB Ferona…", "obratite se direktno SB Feroni", "nema formulara" | §3.8 — nova sekcija o formi; rukovalac = dr Katanić `[POTVRDITI]`; Ferona se pominje samo ako ona obrađuje podatke tokom lečenja |
| `pages/_kit.html:44` | "Zakažite u SB Feroni" | "Zakaži konsultaciju" (interni kit) |

### 5.3 Podaci, schema, backend, build
| Fajl | Sada | Treba |
|---|---|---|
| `data/site.json` `tel`, `tel_href`, `email` | Ferona `+381 21 3000 220`, `office@ferona.rs` | `"tel": ""`, `"tel_href": ""`, `"email": ""` + `"_napomena": "[POTVRDITI] lični telefon/mejl dr Katanića — prazno = ne prikazuje se"`; novi ključevi `"ferona_tel": "+381 21 3000 220"` (samo za opcionu sekundarnu napomenu §4.3), `"lokacija": "SB Ferona, Šarplaninska 19, 21000 Novi Sad"`, `"ordinira": "Ordinira u SB Ferona, Novi Sad"` |
| `data/site.json` `disclaimer` | "Postupci se sprovode u okviru Specijalne bolnice Ferona." | "Konsultacije i postupci obavljaju se u SB Ferona, Novi Sad, gde dr Katanić ordinira." |
| `data/site.json` `napomena_institucija` | "Kontakt centar SB Ferona… Telefon i email pripadaju ustanovi." | ukloniti ključ (i svako korišćenje) |
| `data/site.json` `ferona` | `SB "Ferona"` | OK (koristi se kao naziv mesta) |
| `data/jsonld/person.json` | `description` "član tima Specijalne bolnice Ferona"; `worksFor` → MedicalOrganization Ferona (`feronaivf.rs`) | `Person` (ili `Physician`) "dr Filip Katanić" kao **glavni entitet**; `description` "Reproduktivna medicina, IVF i lečenje steriliteta, Novi Sad."; `jobTitle` "Specijalista ginekologije i akušerstva" (`[POTVRDITI]`, do tada "Lekar"); `sameAs` Instagram; `workLocation` → `{ "@type": "Place", "name": "SB Ferona", "address": {...Šarplaninska 19...} }` umesto `worksFor` (ili `worksFor` ostaje ali bez Ferona `url` kao glavnog — preporuka `workLocation`); `url` = domen sajta. |
| `static/admin/db.php:56,66` | početna lozinka `Ferona2026!` (i komentar) | nasumična lozinka generisana pri instalaciji ili iz `config.php`; nikad brend druge firme, nikad u kodu |
| `build.py:481` (lint `zaposlen u feroni…`) | OK — lint pravilo, ostaje | dodati lint: "zakazite u sb feroni", "kontakt centar", "office@ferona", "3000 220" van `ferona_tel` → greška |
| `build.py` `TITULA_SPECIJALISTA`/`specijalist` lint | blokira titulu | ukloniti blokadu (brief-v2 §3), zadržati `[POTVRDITI]` komentar |
| `build.py` OG slika tekst "GINEKOLOGIJA · IVF · NOVI SAD" | OK | opciono "REPRODUKTIVNA MEDICINA · IVF · NOVI SAD" |
| `README.md` §4, §7.2, §7.13 | Person `worksFor` Ferona; "kontakt isključivo Ferona" | ažurira developer posle izmena |

---

## 6. Admin panel `/admin/` — UX skica

Korisnik: dr Katanić, **pretežno sa telefona**, između pacijenata. Cilj: za < 30 sekundi otvoriti novi zahtev i potvrditi/odbiti. Brend isti (navy/zlato/krem), ali utilitaran — bez dekora. `noindex`, bez linka sa javnog sajta.

> Napomena: u `src/static/admin/` već postoji ranija PHP implementacija; backend agent je usklađuje sa brief-v2 §4 i ovim UX-om.

### 6.1 Login
```
┌──────────────────────────────┐
│          [logo-znak]         │  krem pozadina, kartica centrirana max 380px
│      dr Filip Katanić        │
│      Zakazivanja — admin     │
│ Korisničko ime               │
│ [__________________________] │  autocomplete="username"
│ Lozinka                      │
│ [______________________] 👁  │  autocomplete="current-password", prikaži/sakrij
│ ☐ Zapamti me na ovom uređaju │  (duža sesija, 30 dana, httpOnly cookie)
│ [         Prijava          ] │  navy
│ (greška: "Pogrešni podaci.") │  generička poruka, rate limit posle 5 pokušaja
└──────────────────────────────┘
```

### 6.2 Lista zahteva
**Top bar (sticky, navy, 56px):** FK monogram + "Zakazivanja" + broj novih badge (zlatni) + meni (Odjava).

**Filteri:** segmentirana traka tabova (horizontalni scroll na telefonu): `Novo (3)` · `Potvrđeno` · `Odbijeno` · `Otkazano` · `Sve`. Default: **Novo**. Ispod: pretraga (ime/telefon/mejl) + sort (najnovije / po željenom datumu).

**Telefon — kartice:**
```
┌──────────────────────────────┐
│ ● NOVO        pre 2 h   #128 │  status chip: Novo = zlatni, Potvrđeno = zeleni (salvija),
│ Jelena Petrović              │  Odbijeno = crveni-muted, Otkazano = sivi
│ Drugo mišljenje              │  serif 18px ime, usluga 14px
│ 📅 14.11. (čet) · pre podne  │  željeni datum + doba
│ ☎ Viber · 064 123 4567       │  preferirani kanal
│ [ Potvrdi ]  [ Odbij ]    ›  │  brze akcije direktno sa kartice (samo za "Novo")
└──────────────────────────────┘
```
Tap na karticu → detalj. Pull-to-refresh nije potreban; dugme "Osveži" u top baru.

**Desktop — tabela:**
```
| Status | Primljeno ▾ | Ime i prezime | Usluga | Željeni datum | Doba | Kanal | Telefon | Akcije |
```
Red klik → detalj u **bočnom panelu** (drawer desno 480px) ili zasebna stranica (`?id=N`) — jednostavnije za PHP: zasebna stranica, oba prikaza je koriste.

Prazno stanje: "Nema novih zahteva." + ilustracija FK znak 10% opacity.

### 6.3 Detalj zahteva
```
┌──────────────────────────────┐
│ ‹ Nazad          #128 ● NOVO │
│ Jelena Petrović              │  H1 serif
│ Primljeno 12.10.2026. 09:14  │
│ ─────────────────────────────│
│ USLUGA     Drugo mišljenje   │  definicione liste (dt/dd), 2 kolone
│ ŽELJENI    čet 14.11. · pre p│
│ PARTNER    Marko Petrović    │
│ DOKUMENT.  Delimično         │
│ KANAL      Viber             │
│ NAPOMENA   (pun tekst)       │
│ ─────────────────────────────│
│ [☎ Pozovi] [Viber] [WA] [✉]  │  tel:, viber://chat?number=, https://wa.me/, mailto:
│ ─────────────────────────────│
│ ISTORIJA                     │  log: kreirano, potvrđeno (ko/kad), mejl poslat ✓/✗
│ ─────────────────────────────│
│ [   Potvrdi   ] [  Odbij   ] │  sticky dno ekrana na telefonu (safe-area)
└──────────────────────────────┘
```

### 6.4 Potvrdi (bottom sheet na telefonu / modal na desktopu)
```
┌──────────────────────────────┐
│ Potvrda termina          ✕   │
│ Datum*   [14.11.2026     📅] │  predpopunjeno željenim datumom
│ Vreme*   [10:30          🕑] │  type=time, step 900 (15 min)
│ Poruka pacijentu (opciono)   │
│ [Ponesite dosadašnje nalaze  │  predlog teksta (šablon) koji može da izmeni
│  hormona i spermogram.     ] │
│ ── Pregled mejla ▾ ──        │  <details> sa tačnim tekstom mejla koji ide pacijentu
│ [ Potvrdi i pošalji mejl ]   │  navy
└──────────────────────────────┘
```
Mejl pacijentu (potvrda): datum, vreme, mesto "SB Ferona, Šarplaninska 19, Novi Sad" + link na mapu, poruka doktora, potpis "dr Filip Katanić". Pošiljalac = doktor (ime), ne Ferona.

### 6.5 Odbij
```
┌──────────────────────────────┐
│ Odbijanje / predlog termina ✕│
│ Razlog*                      │
│ (○) Termin nije dostupan     │  brzi razlozi (radio) + "Drugo"
│ (○) Potrebna je druga        │
│     vrsta pregleda           │
│ (○) Drugo                    │
│ Predlog drugog termina (opc.)│
│ [datum 📅] [vreme 🕑]         │
│ Poruka pacijentu*            │  šablon se menja po razlogu
│ [________________________]   │
│ [ Pošalji odgovor ]          │  crveno-muted outline? → ne: navy; destruktivnost je niska
└──────────────────────────────┘
```
Posle akcije: toast "Potvrđeno — mejl poslat pacijentu." ili "Sačuvano, ali mejl NIJE poslat (SMTP greška) — kontaktirajte pacijenta: [Pozovi]". Status se menja odmah u listi.

**Otkazano** status: akcija "Označi kao otkazano" u detalju (meni ⋯) za slučaj da pacijent otkaže telefonom — bez automatskog mejla (opcija "pošalji mejl" checkbox).

### 6.6 Mobilni zahtevi i bezbednost (UX deo)
- Sve akcije ≥ 44px, dugmad pri dnu (palac), bottom sheet umesto modala < 768px, font 16px u poljima.
- `<meta name="robots" content="noindex,nofollow">`, `Cache-Control: no-store`, CSRF na svim POST, sesija httpOnly+Secure+SameSite=Strict, auto-odjava posle 30 dana (zapamti me) ili 8 h.
- Opciono PWA "Dodaj na početni ekran" (manifest sa `logo-znak`, `start_url=/admin/`) — doktor ga otvara kao aplikaciju.
- Mejl obaveštenje doktoru za novi zahtev sadrži direktan link `/admin/?id=N`.

---

## 7. Potpisni element sajta

**"Zlatni okvir" — FK monogram u kvadratnom zlatnom okviru i sistem tankih zlatnih linija koji iz njega proizlazi.**

1. **Monogram (header, CTA traka, footer, admin, favicon):** serif "FK" (Cormorant, ligatura F i K se blago preklapaju — K-ova dijagonala dodiruje F-ovu horizontalu) unutar **kvadrata** 44×44 sa 1px zlatnom ivicom i **odsečenim donjim desnim uglom** (mali 6px dijagonalni rez — "otvoren" okvir, kao korak napred). Implementacija: novi `partials/seal.html` (SVG, `currentColor` za slova, zlatna za okvir). Na navy: krem slova + zlatni okvir. Zamenjuje sadašnji krug.
2. **Zlatni offset okvir oko fotografija doktora:** svaka velika fotografija (hero na podstranicama, O meni) ima 1px zlatnu liniju pomerenu 16px dole-desno iza slike, sa istim odsečenim uglom. Na telefonu se zamenjuje kratkom zlatnom linijom ispod slike.
3. **Eyebrow sa linijama** (`── MOJ PRISTUP ──`) i **zlatna linija aktivne stavke menija** — isti 1px zlatni potez.
4. **Logo znak (ruke + beba + FK srce)** se koristi štedljivo — samo CTA traka, footer i admin login — da ostane emotivni pečat, a monogram je "radni" znak.

Zašto: referenca nosi kvadratni FK okvir kao jedini grafički identitet; dosledna primena jednog tankog zlatnog poteza (okvir → linije → offset) daje "složen, premium" utisak bez dodatnog dekora i radi jednako dobro na 360px ekranu.

---

## 8. Kontrolna lista za developera (redosled rada)

1. Tokens/tipografija (§2.0), novi `seal.html` monogram (§7), icon sprite (§2.15).
2. Popravka `.reveal` (§2.0) + uklanjanje `.reveal` sa hero sekcija svih stranica.
3. Header/meni/sticky bar/footer/cta-band partiali (§1, §2.11–2.12, §5.1).
4. Obrada novih slika (§2.0 tabela) — proveriti da Ferona logo nije u kadru (`portret-mantil*`).
5. Početna po §2.2–2.10.
6. `/zakazivanje/` + `booking.js` prepisan po §3 (enum vrednosti, CSRF GET, lokalni datum, stanja).
7. Podstranice šablon §4, `aside-cta.html`, `/kontakt/`, `/o-meni/`, politika privatnosti.
8. `site.json`, `person.json`, `build.py` lint (§5.3); `sitemap.xml` + `/zakazivanje/`; `robots.txt` Disallow `/admin/` i `/api/`.
9. QA na 360 / 390 / 768 / 1024 / 1440; test bez JS-a (sav sadržaj vidljiv); `grep -rni "feroni\|kontakt centar\|office@ferona\|3000 220" site/` → 0 vidljivih pogodaka (osim opcione `ferona_tel` napomene ako je klijent odobri).

## 9. Otvorena pitanja za klijenta (novo u v2)
1. Lični telefon i mejl za sajt (ili samo forma + IG)?
2. Pismena potvrda titule "Specijalista ginekologije i akušerstva" i tačnog naziva mastera.
3. Weill Cornell Salzburg, LH in ART Sorrento, MSRM Bari — učešće i godina?
4. Histeroskopija i "jednodnevna dijagnostika" — da li ih radi/nudi?
5. Čiji je broj `+381 63 102 2442` (WhatsApp/Viber na sadašnjoj početnoj)?
6. Da li Ferona kontakt centar sme da se navede kao sekundarna opcija zakazivanja?
7. Ko je rukovalac podacima iz forme (za politiku privatnosti) i odakle se šalju mejlovi (adresa pošiljaoca)?
8. Odobrenje kropa/retuša portreta sa Ferona logom na majici.
9. Radni dani/termini (da li forma dozvoljava vikend).
