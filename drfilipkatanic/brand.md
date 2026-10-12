# Brand: dr Filip Katanić — ginekologija / IVF (vantelesna oplodnja)

## v2 (2026-10-12) — usklađeno sa referencom i zvaničnim logom

> **Ova sekcija ima prednost nad svim starijim delovima ovog fajla (v1, odeljci 0–8 ispod).** Gde se v1 i v2 razlikuju (paleta, fontovi, radijusi, uloga šalvije, logo), važi v2. v1 ostaje kao istorijat i za "raspoloženje / čega se klonimo", koje i dalje važi.
>
> Izvori: `brief-v2.md`, `_reference/referenca-dizajn.webp` (887×1774, webp), `Assets/Raw/Logo.PNG` (1024×1024, RGB, bez providnosti).

### v2.1 Paleta (izvučena programski, Python + Pillow)

**Metoda.** Logo: median-cut kvantizacija celog fajla + uglova (pozadina), maska `R−B>70 && R>150` za zlato (11 731 px) i `min(RGB)>235` za belu (43 472 px). Referenca: kvantizacija ciljanih regiona (pozadina hero/sekcija/kartice, navy traka, footer, dugme), najtamnijih 3–10 % piksela u regionima teksta (H1, H2, telo, muted u karticama) i maska `R−B>25` za zlatne natpise/ikone/outline dugme. Referenca je mali lossy webp i zlatni tekst je tanak, pa su sirovi uzorci zlata "isprani" antialiasingom (`#9B8D79`–`#CDC1AD`) — zato je **nijansa** zlata uzeta iz loga, a **zasićenost/svetlina** spuštena ka šampanj tonu reference i podešena za kontrast.

| Sirovi uzorak | Izvor |
|---|---|
| `#0C2343` / `#0D2444` / `#0E2544` | Logo — navy pozadina (dominantno, ~90 % piksela) |
| `#E8C868`, `#D0A848`, `#D8B050`, `#F8E898` (prosek `#EAD069`) | Logo — gradijent zlatnog kruga i srca "FK" (svetla→tamna) |
| `#FCFCFC` | Logo — bela (ruke, beba, script "Dr Filip Katanić") |
| `#FEFCFB` / `#FDFBF9` | Referenca — pozadina sekcija, header, kartice |
| `#FCF5F3` / `#FAF4F1` | Referenca — topliji krem u hero-u (iza fotografije) |
| `#13233D` / `#12223D` / `#13243E` | Referenca — navy traka, footer, puno dugme |
| `#070E1E`–`#121A2B` | Referenca — H1 / H2 (skoro crni navy) |
| `#636261`–`#7D7D7C` | Referenca — telo i muted tekst (sivo-ugljen; antialias ga posvetljava) |
| `#9B8D79`–`#BEAC92` | Referenca — zlatni podnaslov, eyebrow, outline dugme, ikone (isprano) |

**Konačna paleta**

| Token | Hex | Uloga / gde |
|---|---|---|
| `--c-navy` | `#12223D` | Primarna. Naslovi H1–H4, puno dugme, navy trake, aktivni elementi. (Referenca, UI navy) |
| `--c-navy-deep` | `#0D2444` | Tačna boja pozadine loga. Footer i svaka površina na kojoj stoji `Logo.PNG` (PNG nema providnost — pozadina mora biti identična da se ne vidi "kvadrat"). |
| `--c-navy-700` | `#1E3254` | Hover punog dugmeta, razdelnici na navy. |
| `--c-gold` | `#B8955A` | Dekorativno šampanj zlato: 1px linije, okviri kartica/ikona, podvlaka aktivnog menija, numeracija koraka velikim fontom. **Ne za tekst na svetlom.** |
| `--c-gold-icon` | `#A3824A` | Linijske ikone i outline dugme na krem/beloj (≥3:1, WCAG 1.4.11 za ne-tekstualne elemente). |
| `--c-gold-text` | `#82632F` | **Tekst-bezbedno zlato** za eyebrow, zlatni podnaslov hero-a, "Pročitaj više", tekst outline dugmeta na svetlom. |
| `--c-gold-light` | `#D4B068` | Zlato na navy (tekst, ikone, linije) — nijansa iz loga (`#D0A848`/`#E8C868`), malo smirenija. |
| `--c-gold-logo` | `#E8C868` | Samo referentno (srednji ton zlata u logu) — za favicon/pečat ako se crta vektorski. Ne u UI. |
| `--c-cream` | `#FBF8F3` | Glavna pozadina stranice (topla bela; reference `#FEFCFB` + v1 krem). |
| `--c-cream-2` | `#F6F1E9` | Alternativna/toplija pozadina: hero gradient, CTA traka, footer-pre traka, pozadina inputa. |
| `--c-white` | `#FFFFFF` | Kartice, forme, header pri skrolu. |
| `--c-text` | `#33302C` | Telo teksta (topli ugljen). |
| `--c-text-muted` | `#6A645C` | Opisi u karticama, meta, labele. |
| `--c-on-navy` | `#FBF8F3` | Tekst na navy. |
| `--c-on-navy-muted` | `#C9BFB0` | Sekundarni tekst na navy (footer, opisi u traci). |
| `--c-border` | `#E8E0D4` | Neutralna 1px linija (razdelnici, inputi). |
| `--c-border-gold` | `rgba(184,149,90,.38)` | 1px "zlatna" ivica kartica i pločica (kao na referenci — tanko, jedva vidljivo). |
| `--c-success` | `#4E6B54` | Šalvija — **samo** status "potvrđeno"/uspešno poslata forma i admin bedž. |
| `--c-error` | `#9B2C2C` | Greške u formi (koristiti štedljivo). |

**Šalvija zelena — odluka:** izbačena iz brend palete (dugmad, linkovi, tagovi, sekcije). Referenca je strogo trobojna (krem + navy + šampanj zlato) i zelena bi razbila premium/smiren utisak i konkurisala zlatu kao akcentu. Ostaje jedino kao semantička boja stanja (`--c-success`) — forma za zakazivanje ("Zahtev je poslat") i admin panel (status "Potvrđeno"), gde zelena nosi značenje, ne dekoraciju.

### v2.2 Kontrast (WCAG 2.1, izračunato)

| Kombinacija | Odnos | Rezultat |
|---|---|---|
| Tekst `#33302C` na kremu `#FBF8F3` | 12.39:1 | AAA |
| Tekst `#33302C` na `#F6F1E9` | 11.67:1 | AAA |
| Muted `#6A645C` na kremu `#FBF8F3` | 5.52:1 | AA (normalan tekst) |
| Muted `#6A645C` na beloj kartici | 5.85:1 | AA |
| Muted `#6A645C` na `#F6F1E9` | 5.20:1 | AA |
| Navy `#12223D` na kremu `#FBF8F3` | 15.00:1 | AAA |
| Dekorativno zlato `#B8955A` na kremu | 2.65:1 | **Ne prolazi** ni za tekst ni za ikone → samo linije/okviri/dekor |
| Zlato ikona `#A3824A` na kremu / beloj | 3.39 / 3.59:1 | Prolazi 3:1 za grafiku/ikone i outline; NE za mali tekst |
| **Zlato-tekst `#82632F` na kremu** | **5.25:1** | **AA za mali tekst (eyebrow 12–13px)** |
| Zlato-tekst `#82632F` na beloj / `#F6F1E9` | 5.56 / 4.95:1 | AA |
| Krem `#FBF8F3` na navy `#12223D` | 15.00:1 | AAA |
| Bela na navy `#12223D` / na logo-navy `#0D2444` | 15.89 / 15.52:1 | AAA |
| Muted-on-navy `#C9BFB0` na `#12223D` | 8.75:1 | AAA |
| Zlato `#D4B068` na navy `#12223D` / `#0D2444` | 7.72 / 7.55:1 | AAA (normalan tekst ≥7) |
| Dekorativno zlato `#B8955A` na navy | 5.66:1 | AA — sme i kao tekst na navy |
| Šalvija `#4E6B54` na kremu | 5.58:1 | AA |

**Pravilo:** na svetlim pozadinama zlatni *tekst* je uvek `--c-gold-text`; `--c-gold-icon` za ikone/outline; `--c-gold` samo linije. Na navy sve zlatne varijante (`--c-gold-light` preporučeno) prolaze.

### v2.3 Tipografija

Referenca: naslovi su klasičan Garamond-tip serif, visokog kontrasta, srednje težine, sa malom x-visinom i elegantnim "ć" (H1 "dr Filip Katanić", "Ne postoji univerzalni IVF protokol."); zlatni podnaslov hero-a je isti serif u semibold-u. Telo, meni i dugmad su čist, topao sans sa jednospratnim "g" i otvorenim oblicima.

**Izbor (zamenjuje v1 Fraunces + Karla):**
- **Naslovi:** **Cormorant Garamond** — 500 (H1–H3), 600 (H4–H6, podnaslovi, kartice), 500 italic (citati, istaknuta rečenica). Najbliži referenci (Garamond kostur, visok kontrast, uske kapitale); Fraunces je "mekši"/zaobljeniji i deluje manje premium-klasično od reference.
- **Telo / UI:** **Mulish** — 400 (telo), 500 (meni, labele), 600 (dugmad, eyebrow), 700 (retko, jaki naglasci). Topao humanist-geometrijski sans, jednospratno "g", odlična čitljivost na telefonu i dobro "sedi" uz Garamond.

**Srpska latinica:** provereno direktno sa `fonts.googleapis.com/css2` (2026-10-12) — obe familije serviraju `latin-ext` subset sa `unicode-range: U+0100-02BA…`, koji pokriva č (U+010D), ć (U+0107), š (U+0161), ž (U+017E), đ (U+0111) i velika slova (Č Ć Š Ž Đ). Google Fonts automatski učitava samo potrebne subsete.

**Napomena za Cormorant:** mala x-visina → nikad ispod ~20px i ne za telo teksta; težina 300/400 je pretanka na ekranu (koristiti 500+). Za naslove kartica na mobilnom minimum `1.25rem`.

```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;1,500&family=Mulish:wght@400;500;600;700&display=swap" rel="stylesheet">
```

Fallback: `'Cormorant Garamond', 'EB Garamond', Garamond, 'Times New Roman', serif` / `'Mulish', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif`.

### v2.4 Tokens — gotov blok za zamenu `src/static/assets/css/tokens.css`

Sadrži i **kompatibilne alijase** v1 imena (`--color-primary`, `--font-heading`, `--radius-*`…), tako da postojeći CSS radi odmah posle zamene; nove komponente koriste `--c-*`, `--fs-*`, `--sp-*`.

```css
/* ==========================================================================
   dr Filip Katanić — tokens.css (v2, 2026-10-12)
   Izvor: brand.md § v2. Ne menjati boje/fontove bez izmene brand.md.
   ========================================================================== */
:root {
  /* ---- Boje: brend ---- */
  --c-navy:          #12223D;  /* primarna: naslovi, puno dugme, trake */
  --c-navy-deep:     #0D2444;  /* = pozadina Logo.PNG; footer, površine sa logom */
  --c-navy-700:      #1E3254;  /* hover punog dugmeta */
  --c-gold:          #B8955A;  /* dekor: 1px linije, okviri — NE tekst na svetlom */
  --c-gold-icon:     #A3824A;  /* linijske ikone, outline dugme na svetlom (>=3:1) */
  --c-gold-text:     #82632F;  /* zlatni tekst na svetlom: eyebrow, podnaslov (5.25:1) */
  --c-gold-light:    #D4B068;  /* zlato na navy: tekst, ikone, linije (7.7:1) */
  --c-gold-tint:     #F3EBDD;  /* pozadina ikone/bedža, hover kartice */

  /* ---- Boje: površine ---- */
  --c-cream:         #FBF8F3;  /* glavna pozadina */
  --c-cream-2:       #F6F1E9;  /* hero gradient, CTA traka, inputi */
  --c-white:         #FFFFFF;  /* kartice, forme, header */

  /* ---- Boje: tekst ---- */
  --c-text:          #33302C;  /* 12.4:1 na kremu */
  --c-text-muted:    #6A645C;  /* 5.5:1 na kremu */
  --c-heading:       var(--c-navy);
  --c-on-navy:       #FBF8F3;
  --c-on-navy-muted: #C9BFB0;

  /* ---- Boje: linije i stanja ---- */
  --c-border:        #E8E0D4;
  --c-border-gold:   rgba(184, 149, 90, .38);
  --c-border-on-navy: rgba(212, 176, 104, .28);
  --c-focus:         #A3824A;
  --c-success:       #4E6B54;  /* šalvija — SAMO status "potvrđeno/poslato" */
  --c-success-tint:  #E9F0EA;
  --c-error:         #9B2C2C;
  --c-error-tint:    #F8E9E7;

  /* ---- Gradijenti ---- */
  --grad-hero-photo: linear-gradient(90deg, var(--c-cream-2) 0%, rgba(246,241,233,.85) 18%, rgba(246,241,233,0) 45%);
  --grad-hero-photo-mobile: linear-gradient(0deg, var(--c-cream) 0%, rgba(251,248,243,.9) 14%, rgba(251,248,243,0) 42%);
  --grad-cta:        linear-gradient(90deg, var(--c-cream-2) 0%, #EFE7DA 100%);

  /* ---- Fontovi ---- */
  --ff-serif: 'Cormorant Garamond', 'EB Garamond', Garamond, 'Times New Roman', serif;
  --ff-sans:  'Mulish', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
  --fw-regular: 400;
  --fw-medium:  500;
  --fw-semi:    600;
  --fw-bold:    700;

  /* ---- Tipografska skala (fluid, 360px -> 1280px) ---- */
  --fs-h1:   clamp(2.5rem,  1.72rem + 3.48vw, 4.5rem);    /* 40 -> 72 */
  --fs-h2:   clamp(2rem,    1.61rem + 1.74vw, 3rem);      /* 32 -> 48 */
  --fs-h3:   clamp(1.625rem,1.38rem + 1.09vw, 2.25rem);   /* 26 -> 36 */
  --fs-h4:   clamp(1.375rem,1.23rem + 0.65vw, 1.75rem);   /* 22 -> 28 */
  --fs-h5:   clamp(1.25rem, 1.15rem + 0.43vw, 1.5rem);    /* 20 -> 24 (naslov kartice) */
  --fs-h6:   clamp(1.125rem,1.08rem + 0.22vw, 1.25rem);   /* 18 -> 20 */
  --fs-lead: clamp(1.0625rem,1rem + 0.27vw, 1.25rem);     /* 17 -> 20 */
  --fs-body: 1rem;                                        /* 16 */
  --fs-sm:   0.875rem;                                    /* 14 */
  --fs-xs:   0.8125rem;                                   /* 13 */
  --fs-eyebrow: 0.75rem;                                  /* 12, verzal */
  --fs-num:  clamp(2rem, 1.6rem + 1.7vw, 3rem);           /* "01–05" u koracima */

  --lh-tight:   1.1;    /* H1–H2 */
  --lh-heading: 1.2;    /* H3–H6 */
  --lh-body:    1.65;
  --ls-heading: -0.005em;
  --ls-eyebrow: 0.18em;
  --ls-button:  0.02em;

  /* Eyebrow: Mulish 600, 12px, VERZAL, zlatni tekst */
  --eyebrow-font: var(--fw-semi) var(--fs-eyebrow)/1.4 var(--ff-sans);
  --eyebrow-color: var(--c-gold-text);
  --eyebrow-color-on-navy: var(--c-gold-light);

  /* ---- Razmaci (osnova 4px) ---- */
  --sp-1: 4px;   --sp-2: 8px;   --sp-3: 12px;  --sp-4: 16px;
  --sp-5: 24px;  --sp-6: 32px;  --sp-7: 48px;  --sp-8: 64px;
  --sp-9: 96px;  --sp-10: 128px;
  --sec:  clamp(56px, 4rem + 4vw, 120px);   /* vertikalni ritam sekcija */
  --card-pad: clamp(20px, 1rem + 1vw, 32px);

  /* ---- Layout ---- */
  --container: 1200px;
  --container-narrow: 760px;   /* centrirani tekst ("Moj pristup") */
  --gutter: 16px;
  --hdr: 64px;
  --sticky-h: 64px;

  /* ---- Radijusi (referenca: blago, 4–8px) ---- */
  --r-xs: 2px;     /* inputi u tabelama, bedževi */
  --r-sm: 4px;     /* dugmad, inputi */
  --r-md: 6px;     /* kartice, pločice */
  --r-lg: 8px;     /* fotografije, veliki blokovi */
  --r-round: 999px;/* samo kružne ikone/avatar — NE dugmad */

  /* ---- Linije ---- */
  --line: 1px solid var(--c-border);
  --line-gold: 1px solid var(--c-border-gold);
  --line-gold-solid: 1px solid var(--c-gold);
  --line-on-navy: 1px solid var(--c-border-on-navy);
  --icon-stroke: 1.4px;            /* 1.25–1.5 */
  --underline-active: 2px;         /* zlatna podvlaka aktivnog menija */

  /* ---- Senke (vrlo meke, topla navy) ---- */
  --sh-xs:   0 1px 2px rgba(18, 34, 61, .04);
  --sh-card: 0 2px 6px rgba(18, 34, 61, .04), 0 10px 28px rgba(18, 34, 61, .05);
  --sh-hover:0 4px 10px rgba(18, 34, 61, .06), 0 18px 40px rgba(18, 34, 61, .08);
  --sh-header: 0 1px 0 var(--c-border), 0 6px 20px rgba(18, 34, 61, .05);

  /* ---- Animacije (mirno, bez bounce) ---- */
  --ease: cubic-bezier(.4, 0, .2, 1);
  --dur-fast: 180ms;
  --dur: 400ms;
  --dur-slow: 700ms;

  /* ---- Alijasi v1 (kompatibilnost sa postojećim CSS-om) ---- */
  --color-primary: var(--c-navy);
  --color-primary-light: var(--c-navy-700);
  --color-primary-tint: #E7EAF0;
  --color-secondary: var(--c-gold-text);        /* šalvija više nije sekundarna */
  --color-secondary-light: var(--c-gold-icon);
  --color-secondary-tint: var(--c-gold-tint);
  --color-accent: var(--c-gold-text);
  --color-accent-decorative: var(--c-gold);
  --color-accent-tint: var(--c-gold-tint);
  --color-bg: var(--c-cream);
  --color-surface: var(--c-white);
  --color-surface-dark: var(--c-navy);
  --color-text: var(--c-text);
  --color-text-muted: var(--c-text-muted);
  --color-text-on-dark: var(--c-on-navy);
  --color-text-on-primary: #FFFFFF;
  --color-border: var(--c-border);
  --color-border-on-dark: var(--c-border-on-navy);
  --radius-sm: var(--r-sm);
  --radius-md: var(--r-md);
  --radius-lg: var(--r-lg);
  --radius-pill: var(--r-sm);   /* v2: nema pill dugmadi */
  --shadow-soft: var(--sh-hover);
  --shadow-card: var(--sh-card);
  --font-heading: var(--ff-serif);
  --font-body: var(--ff-sans);
}

@media (min-width: 768px)  { :root { --gutter: 24px; } }
@media (min-width: 1024px) { :root { --hdr: 84px; } }
@media (min-width: 1280px) { :root { --gutter: 40px; } }
@media (prefers-reduced-motion: reduce) { :root { --dur-fast: 0ms; --dur: 0ms; --dur-slow: 0ms; } }
```

Primer osnovnih pravila (za `base.css`, ne deo tokens.css):

```css
h1,h2,h3,h4,h5,h6 { font-family: var(--ff-serif); color: var(--c-heading); font-weight: 500; line-height: var(--lh-heading); letter-spacing: var(--ls-heading); }
h1 { font-size: var(--fs-h1); line-height: var(--lh-tight); }
h2 { font-size: var(--fs-h2); line-height: var(--lh-tight); }
h4,h5,h6 { font-weight: 600; }
.eyebrow { font: var(--eyebrow-font); text-transform: uppercase; letter-spacing: var(--ls-eyebrow); color: var(--eyebrow-color); }
.on-navy .eyebrow { color: var(--eyebrow-color-on-navy); }
.eyebrow--rule { display: flex; align-items: center; gap: var(--sp-4); }      /* "—— KONSULTACIJA NIJE SAMO PREGLED ——" */
.eyebrow--rule::before, .eyebrow--rule::after { content: ""; flex: 1; border-top: var(--line-gold); }
```

### v2.5 UI smernice

**Dugmad** (Mulish 600, 15px, `--ls-button`, visina 48px desktop / 52px mobilni, padding 0 28px, `--r-sm`):
- *Primarno:* `--c-navy` puno, tekst bela; hover `--c-navy-700`; focus `outline: 2px solid var(--c-focus); outline-offset: 3px`.
- *Sekundarno (zlatni outline):* providno, `1px solid var(--c-gold-icon)`, tekst `--c-gold-text`; hover pozadina `--c-gold-tint`.
- *Na navy:* primarno postaje krem puno (`--c-on-navy`, tekst `--c-navy`); outline `--c-gold-light` + tekst `--c-gold-light`.
- *Tekst-link "Pročitaj više →":* `--c-gold-text`, 600, strelica se pomera 4px na hover. Bez pill oblika, bez senki na dugmadima, bez scale/bounce.

**Kartice** ("Kada ima smisla", "Oblasti rada", Journal, konferencijske pločice):
- `--c-white` na `--c-cream`, `--line-gold` (1px), `--r-md`, `--card-pad`, `--sh-card` (može i bez senke za pločice "Nauka i edukacija").
- Hover: `--sh-hover` + ivica `--c-gold` (bez pomeranja > 2px).
- *Ikona:* 40–48px linijska ikona `--c-gold-icon`, stroke `--icon-stroke`; opciono u krugu/kvadratu 56px sa `--line-gold`. "Kada ima smisla" = ikona centrirana iznad naslova; "Oblasti rada" = ikona levo, naslov (`--fs-h5`, serif 600) + opis (`--fs-sm`, muted) desno, grid 3×2 → 2 kol (tablet) → 1 kol (mobilni).
- *Koraci 01–05:* broj u serifu `--fs-num` navy, naslov Mulish 600, opis muted; između koraka tanka zlatna strelica (`→`, `--c-gold`). Na mobilnom vertikalna lista sa zlatnom 1px vertikalnom linijom levo umesto strelica.

**Ikone:** isključivo linijske (Lucide / Phosphor "Light" ili ručno SVG), `stroke-width: 1.25–1.5`, `stroke-linecap: round`, bez fill-a, `currentColor` → `--c-gold-icon` na svetlom, `--c-gold-light` na navy. Jedan set kroz ceo sajt. Bez emoji, bez punih (solid) ikona, bez dvobojnih.

**Header:** bela/krem (`--c-white` sa 92% opacity + `backdrop-filter: blur(8px)` pri skrolu), visina `--hdr`, `--sh-header` tek posle skrola. Levo: FK znak u kvadratnom zlatnom okviru (`--line-gold-solid`, 44px) + "dr Filip Katanić" (serif 600, 22px, navy) / "Reproduktivna medicina" (Mulish 13px muted). Meni Mulish 500 15px `--c-text`; aktivna stavka `--c-navy` + 2px zlatna podvlaka (`--c-gold`) širine ~24px centrirana ispod. Desno navy dugme "Zakaži konsultaciju" → `/zakazivanje/`. Mobilni (<1024px): logo-blok + hamburger (tanka linija, navy); meni kao full-screen krem panel sa serifnim stavkama 28px i dugmetom na dnu; sticky donja traka "Zakaži konsultaciju" (navy, 56px) na mobilnom.

**Navy trake** (vrednosti/statistika, CTA, footer): pozadina `--c-navy` (footer `--c-navy-deep` zbog loga), tekst `--c-on-navy`, ikone/eyebrow `--c-gold-light`, vertikalni razdelnici `--line-on-navy`. Ikone u traci 40px linijske. Bez izmišljenih brojki — samo kvalitativne vrednosti (npr. "Individualizovan plan", "Embriologija", "Naučni rad") dok klijent ne potvrdi brojeve.

**Footer:** `--c-navy-deep`; levo pun logo (vidi v2.7) ili tekstualni potpis serif "dr Filip Katanić" + "Reproduktivna medicina ——" zlatna linija; u redu: Instagram, "Ordinira u SB Ferona, Šarplaninska 19, Novi Sad", link na zakazivanje (telefon/mejl tek kad ih klijent potvrdi). Donja linija `--line-on-navy`, copyright `--fs-xs` `--c-on-navy-muted`.

**CTA traka pre footera:** `--grad-cta` (topla krem), levo FK pečat u zlatnom kvadratnom okviru, serifni naslov `--fs-h3` navy, opis muted, desno navy dugme. Opciono dekorativna fotografija (vaza/grančica) desno, pretopljena u gradijent.

**Fotografija:**
- Hero: `IMG_1626.jpg` desno (≈55% širine na desktopu), `object-fit: cover`, `object-position` na lice; preko leve ivice slike `--grad-hero-photo` tako da se fotografija **pretapa u krem** (kao referenca) — bez okvira i bez radijusa na hero slici. Pozadina hero sekcije `--c-cream-2`.
- Ostale fotografije ("O meni" `IMG_4647.JPG`, Journal): `--r-lg`, bez okvira ili sa `--line-gold`; topla, svetla korekcija (blago +toplina, bez filtera/duotona). Ferona logo na mantilu (`IMG_4641/4642`) kropovati.
- Format: AVIF/WebP + JPG fallback, `srcset` 480/768/1200/1600, `loading="lazy"` sve osim hero-a (`fetchpriority="high"`).

**Forme (zakazivanje):** labele Mulish 500 14px `--c-text`; input visina 48px, `--c-white`, `--line`, `--r-sm`; focus ivica `--c-gold-icon` + `box-shadow: 0 0 0 3px var(--c-gold-tint)`; greška `--c-error` tekst + `--c-error-tint` pozadina poruke; uspeh `--c-success` / `--c-success-tint`. Radio/checkbox kao "chip" kartice sa `--line-gold`, selektovano = navy ivica + navy tekst. Font-size inputa ≥16px (iOS zoom).

**Mobilni (prioritet, 360–430px):**
- `--gutter` 16px, bez horizontalnog skrola; sve sekcije jedna kolona, kartice puna širina, razmak između kartica 12–16px.
- Hero redosled: fotografija na vrhu (visina ~58vh, `object-position: 60% 20%`, donja ivica pretopljena `--grad-hero-photo-mobile` u krem) → H1 (40px) → zlatni podnaslov → uvod → dugmad **jedno ispod drugog, puna širina** → kredencijali kao vertikalna lista sa ikonama.
- Grid "Oblasti rada" i "Nauka i edukacija" → 1 kolona (pločice konferencija mogu horizontalni scroll-snap sa vidljivim delom sledeće).
- Touch mete ≥44×44px; tekst tela 16px, linije ≤ 70 znakova na desktopu.
- Navy traka vrednosti: 2×2 grid ili vertikalna lista sa horizontalnim razdelnicima.

### v2.6 Raspored po referenci (podsetnik za razvoj)
Header → Hero (H1 + zlatni podnaslov + 2 dugmeta + 3 kredencijala | foto sa gradientom) → "Moj pristup" (centrirano, `--container-narrow`) → "Kada ima smisla da se javite?" (4 kartice) → "Oblasti rada" (3×2) → "Konsultacija nije samo pregled…" (eyebrow sa linijama + 5 koraka) → "O meni" (foto levo + 3 kolone) → navy traka vrednosti → "Nauka i edukacija" (pločice; samo potvrđene konferencije, ostalo [POTVRDITI SA KLIJENTOM]) → "Journal" (3 kartice) → CTA traka sa FK pečatom → navy footer. Sekcije naizmenično `--c-cream` / `--c-white` ili razdvojene `--line` linijom, nikad više od jedne navy sekcije zaredom.

### v2.7 Upotreba loga (`Assets/Raw/Logo.PNG`)

Logo: navy kvadrat (`#0D2444`), zlatni krug sa šakama i bebom, zlatno srce sa "FK", beli script "Dr Filip Katanić". Sadržaj zauzima približno x 160–866, y 186–778 od 1024px (≈16 % prazne margine sa svake strane); znak (krug) je gornjih ~60 %, script potpis donjih ~30 %. PNG **nema providnu pozadinu**.

- **Pun logo (znak + script):** samo na **tamnoj** pozadini identičnoj `--c-navy-deep #0D2444` — footer, CTA "pečat" blok na navy, OG/share slika (1200×630 navy sa logom centriranim), Instagram/print. Minimalna širina **160px** (ispod toga script "Dr Filip Katanić" postaje nečitak); preporučeno 200–240px u footeru. Zaštitna zona = visina srca "FK" sa svih strana. Za oštrinu: izrezati prazne margine (crop ≈ 160,170,870,790) i izvesti WebP 2× (npr. 480px za prikaz 240px).
- **Samo znak (krug sa šakama/bebom + FK srce):** avatar, favicon izvor, dekorativni pečat. Minimalno **48px** na ekranu; ispod toga (favicon 16/32px, header mobilni) detalji šaka/bebe se gube → koristiti **FK monogram** (zlatno "FK" u tankom zlatnom kvadratu/krugu, kao na referenci u headeru i CTA traci) — to je dozvoljena pojednostavljena varijanta loga.
- **Header:** NE ubacivati PNG sa navy kvadratom na belu/krem pozadinu (izgleda kao nalepnica). Koristiti kombinaciju referenca-stila: FK monogram u zlatnom kvadratnom okviru (`--c-gold`, 1px, 44px) + tipografski naziv "dr Filip Katanić" (Cormorant 600) / "Reproduktivna medicina". Monogram treba izraditi kao SVG (zlato `--c-gold-text` na svetlom za kontrast, `--c-gold-light` na navy). [POTVRDITI SA KLIJENTOM: da li postoji vektorski (SVG/AI) zvanični logo — ako postoji, koristiti ga umesto PNG-a i izvesti varijantu na providnoj pozadini.]
- **Na svetloj pozadini:** pun logo samo unutar navy pločice (`--c-navy-deep`, `--r-lg`, padding ≥ 24px) — nikad sam znak sa belim script-om direktno na krem (bela na kremu je nevidljiva). Za svetle površine koristi se monogram ili tipografski potpis u navy.
- **Na tamnoj pozadini:** pun logo ili znak direktno; ako je pozadina `--c-navy` (`#12223D`) umesto `#0D2444`, razlika je vidljiva na velikim ekranima → stavljati logo samo na `--c-navy-deep` ili ga izvesti sa providnom pozadinom.
- **Favicon / apple-touch-icon:** FK srce ili FK monogram zlatno (`#D4B068`) na `#0D2444`, 32/180/512px.
- **Ne raditi:** menjati boje loga, rastezati, dodavati senku/sjaj, stavljati preko fotografije bez navy pločice, koristiti script potpis kao naslovni font sajta.

---

# v1 (2026-09-25) — zamenjeno sekcijom v2 gde se razlikuje

Datum: 2026-09-25
Izvor: 23 slike iz `Assets/Raw/` (IG @drfilipkatanic), `research.md`. Nema zvaničnog logotipa — postoji neformalni "FK" monogram (krug, tanka linija) koji se koristi kao potpis na edukativnim grafikama i može poslužiti kao osnova za favicon/monogram na sajtu.

## 0. Šta pokazuju slike (metoda)

Pregledano 20 od 23 slike (portreti, konferencije, porodica, i tri ponavljajuća **edukativna template stila** koja dizajner/klijent već koristi na IG-u):

1. **Krem/polaroid stil** — topla bež pozadina (`#FDFAF5`–`#FFFCF7`), polaroid okviri sa portretom, potpis rukopisom ("suprug", "otac", "gitarista"), taman toplo-smeđi tekst.
2. **Crna school-board grafika** — crna tabla u drvenom ramu na zidu od cigle, beli serifni citat — koristi se za "teže" edukativne poruke (biologija, selekcija embriona).
3. **Tamno-teget "premium" kartica** — duboko teget/antracit pozadina, tanka zlatna (šampanj) linija/okvir, zlatni serifni naslov, potpis "dr Filip Katanić" u kurzivnom rukopisu — koristi se za brojčane tabele (godine/broj ćelija) i "važne poruke za kraj".
4. **Krem + teget + zlato + FK monogram** — najčistiji, najbrendiraniji template (npr. "Social freezing" carousel): krem pozadina, teget serifni naslov, kurzivni teget podnaslov, tanke zlatne linije/grančice, FK monogram u krugu kao potpis.

Ova četiri stila već dele **istu paletu i istu logiku** (topao krem + duboki teget + zlato/šampanj + povremeno šalvija zelena za "zeleno = umirujuće/potvrđeno") — to je čvrsta osnova za sajt, nije potrebno izmišljati novu paletu, samo je konsolidovati i proveriti kontrast.

Boje su izvučene programski (Python + Pillow, median-cut kvantizacija + ciljano uzorkovanje piksela iz tekstualnih/akcentnih regiona), ne procenjene vizuelno.

## 1. Paleta

| Uloga | Hex | Izvor / gde se koristi |
|---|---|---|
| **Primarna** (Navy) | `#10284A` | Izvučeno iz navy naslova na "Social freezing" carouselu (sirovi uzorak `#06224a`, blago posvetljeno radi upotrebljivosti). Naslovi, primarna dugmad, navigacija, ikonice — nosi stručnost i poverenje bez "bolničkog" hladnog plavo-belog. |
| **Sekundarna** (Šalvija zelena) | `#4E6B54` (tekst/ikone) / `#7A9885` (dekorativno, veći elementi) | Izvučeno iz "zeleno = potvrđeno/umirujuće" checkmark elemenata (PCOS/ovulacija grafike, sirovi uzorak `#7a9885`, potamnjeno za AA tekst). Sekundarna dugmad, potvrde, "zelene zastavice", linkovi, tagovi. Namerno *nije* plava (izbegava klinički osećaj) niti roze/lila (izbegava doslovan "beba" kliše) — zemljano-zelena nosi nadu i smirenost bez patetike. |
| **Akcent** (Šampanj zlato) | `#8C7355` (tekst-bezbedno) / `#C9AD87` (dekorativno na tamnim pozadinama) | Izvučeno iz zlatnog teksta na teget "premium" karticama (sirovi uzorak `#bda78c`). Tanke linije, okviri, ikonice, citati, hover stanja — daje toplinu i diskretnu premium notu bez "spa/wellness" utiska. |
| **Pozadina** (Krem) | `#FBF7F0` | Prosek dominantnih pozadina sa gotovo svih carousela (`#FDFAF5`, `#FFFCF7`, `#FCF9F4`). Glavna pozadina sajta umesto klinički hladnog belog. |
| **Površina / kartice** | `#FFFFFF` ili `#FFFDF9` | Kartice, forme, elevated elementi na krem pozadini — blago hladnija/svetlija od pozadine radi razlikovanja slojeva. |
| **Tamna površina** (za "važne poruke") | `#10284A` (ista kao primarna) ili `#14181F` | Za povremene "premium citat" sekcije koje repliciraju postojeći teget/crni template (npr. istaknuta izjava lekara, "važna poruka za kraj") — koristiti retko, za naglasak, ne kao dominantnu pozadinu. |
| **Tekst** | `#2E2A26` | Potamnjeno iz uzorka tamnog teksta na krem karticama (sirovi `#494742`) radi AA/AAA kontrasta. Toplo ugljen-smeđa, ne čisto crna — mekši je i topliji od `#000000`. |
| **Tekst na tamnoj površini** | `#FBF7F0` (krem) + `#C9AD87` (zlato za naglaske) | Za tekst na navy/tamnim karticama. |

## 2. CSS varijable

```css
:root {
  /* Primarna paleta */
  --color-primary: #10284A;       /* deep navy — stručnost, poverenje */
  --color-primary-light: #2C4B78; /* hover/active varijanta */
  --color-primary-tint: #E7ECF2;  /* svetla pozadina sekcija, badge-ovi */

  --color-secondary: #4E6B54;     /* šalvija zelena — nada, smirenost */
  --color-secondary-light: #7A9885;
  --color-secondary-tint: #E9F0EA;

  --color-accent: #8C7355;        /* šampanj zlato — tekst-bezbedna varijanta */
  --color-accent-decorative: #C9AD87; /* svetlija, samo za dekor/tamne pozadine */
  --color-accent-tint: #F3EAD9;

  --color-bg: #FBF7F0;            /* topao krem — glavna pozadina */
  --color-surface: #FFFFFF;       /* kartice, forme */
  --color-surface-dark: #10284A;  /* "premium" kartice / istaknuti citati */

  --color-text: #2E2A26;          /* topao ugljen — telo teksta */
  --color-text-muted: #6B655D;    /* sekundarni tekst, meta info */
  --color-text-on-dark: #FBF7F0;  /* tekst na tamnoj površini */
  --color-text-on-primary: #FFFFFF;

  --color-border: #E3DCD1;        /* suptilne linije, razdelnici */

  /* Zaobljenja i senke — "mek" osećaj, ne oštar/klinički */
  --radius-sm: 10px;
  --radius-md: 16px;
  --radius-lg: 24px;
  --radius-pill: 999px;
  --shadow-soft: 0 8px 24px rgba(16, 40, 74, 0.08);
  --shadow-card: 0 4px 16px rgba(46, 42, 38, 0.06);
}
```

## 3. Kontrast (WCAG AA, min 4.5:1 za tekst)

| Kombinacija | Odnos | Status |
|---|---|---|
| Tekst `#2E2A26` na pozadini `#FBF7F0` | 13.33:1 | Prolazi AAA |
| Primarna `#10284A` kao tekst na `#FBF7F0` | 13.81:1 | Prolazi AAA |
| Bela `#FFFFFF` na primarnoj `#10284A` (dugmad) | 14.74:1 | Prolazi AAA |
| Krem tekst `#FBF7F0` na primarnoj pozadini `#10284A` | 13.81:1 | Prolazi AAA |
| Sekundarna (tamnija) `#4E6B54` na `#FBF7F0` | 5.53:1 | Prolazi AA (normalan tekst) |
| Sirova šalvija `#7A9885` na `#FBF7F0` | 3.47:1 | **Ne prolazi** za tekst — koristiti samo dekorativno/za velike naslove ili ikone |
| Akcent (tamniji) `#8C7355` na `#FBF7F0` | 4.19:1 | Prolazi AA samo za veliki tekst (≥18px / bold ≥14px) — **ne koristiti za sitan telesni tekst** |
| Zlato `#C9AD87` na tamnoj `#10284A` | 6.89:1 | Prolazi AA — bezbedno za tekst/naslove na tamnim karticama |

**Pravilo:** primarna navy i osnovni tekst su bezbedni svuda. Sekundarna (šalvija) i akcent (zlato) koristiti za tekst samo u potamnjenoj varijanti ili u velikim/bold naslovima; svetlije, dekorativne varijante (`--color-secondary-light`, `--color-accent-decorative`) rezervisati za ikone, linije, pozadine tagova i tamne kartice — nikad za sitan tekst na krem pozadini.

## 4. Tipografija

Stil sa IG-a: elegantan, visoko-kontrastan serif za naslove (vidljivo na gotovo svim edukativnim karticama — "PCOS", "JEDINSTVENOST", "Kada zamrzavanje jajnih ćelija") u kombinaciji sa čistim, toplim sans-serifom za telo i liste, plus kurzivna serifna varijanta za lični potpis ("dr Filip Katanić"). Ovo NIJE dekorativan/luksuzan display font (izbegava "spa" utisak) niti hladan geometrijski sans poput Montserrat/Poppins (izbegava generički "estetska klinika" template izgled).

Oba predložena para su proverena na fonts.google.com (Glyphs & languages) za puni **latin-ext** set (č ć š ž đ Č Ć Š Ž Đ) — oba prolaze.

### Opcija A (preporučeno)
- **Naslovi:** [Fraunces](https://fonts.google.com/specimen/Fraunces) — varijabilni serif sa "soft"/optical-size osobinama, topao i savremen, najbliži postojećem IG stilu naslova.
- **Telo:** [Karla](https://fonts.google.com/specimen/Karla) — human sans, blago zaobljeni završeci, topliji od Inter/Roboto, odličan za dugačke edukativne tekstove.

```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;1,9..144,500&family=Karla:wght@400;500;600;700&display=swap" rel="stylesheet">
```
```css
--font-heading: 'Fraunces', Georgia, 'Times New Roman', serif;
--font-body: 'Karla', -apple-system, Segoe UI, sans-serif;
```

### Opcija B (alternativa)
- **Naslovi:** [Lora](https://fonts.google.com/specimen/Lora) — klasičniji, "knjiški" topao serif, vrlo blizak fontu korišćenom u postojećim carousel grafikama.
- **Telo:** [Mulish](https://fonts.google.com/specimen/Mulish) — čist, topao sans, širok raspon težina, dobra čitljivost na malim ekranima.

```html
<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..600&family=Mulish:wght@400;500;600;700&display=swap" rel="stylesheet">
```
```css
--font-heading: 'Lora', Georgia, serif;
--font-body: 'Mulish', -apple-system, Segoe UI, sans-serif;
```

**Kurziv za lični ton** (citati, potpis "dr Filip Katanić", istaknute rečenice poput "Ne možemo kontrolisati baš sve, ali možemo napraviti najbolji plan"): koristiti italic rez naslovnog fonta (Fraunces Italic / Lora Italic) — ne uvoditi treći, dekorativni script font. Dva porodice fontova su dovoljna i lakša za održavanje.

## 5. Vizuelni stil

- **Fotografija:** svetla, prirodno/meko osvetljenje, portreti dr Katanića u belom mantilu ili smart-casual, direktan pogled u kameru, topao ali ozbiljan izraz. Pozadine blago zamućene (ordinacija, konferencijska sala) — nikad fluorescentno-hladan "bolnički" izgled. Nema pre/posle slika (nije primenljivo za IVF), nema close-up stock fotografija trudničkih stomaka ili beba — ton ostaje dostojanstven i fokusiran na lekara/proces, ne na senzacionalizovan "rezultat".
- **Prostor/kompozicija:** izdašan negativni prostor, jedna centralna poruka po sekciji/slajdu (kao u IG carouselima) — izbegavati zbijene, "dashboard" gust raspored informacija.
- **Oblici:** dosledno **zaobljeni** uglovi (polaroid okviri, pill-bedž "SOCIAL FREEZING", zaobljene teget kartice) — nikad oštri/pravougaoni "klinički" blokovi. Zaobljenost signalizira mekoću i smirenost, važno za osetljivu temu steriliteta.
- **Gustina:** nizak do srednji — puno vazduha oko teksta, kratki pasusi, liste sa ikonama umesto zidova teksta.
- **Ikonografija:** jednostavne linijske ikone; šalvija-zeleni check za "normalno/umirujuće/potvrđeno" (već ustaljen obrazac na IG-u); crvena/upozoravajuća ikonografija koristiti izuzetno retko i samo tamo gde je medicinski opravdano (npr. "kada se javiti lekaru" vodič), nikad kao marketinški alarm.
- **Animacije:** suptilne, spore (fade/slide na scroll, 300-500ms), bez "bouncy" ili igrivih mikro-animacija, bez countdown tajmera ili "urgency" elemenata — tema zahteva mirnoću, ne pritisak.

## 6. UI smernice

- **Dugmad:** meko zaobljena (`--radius-pill` ili `--radius-md`), primarna = navy pozadina + beli/krem tekst; sekundarna = outline navy ili puna šalvija-zelena; hover = blago potamnjenje boje (bez skaliranja/bounce efekta koji deluje neozbiljno za ovu temu).
- **Kartice:** zaobljeni uglovi (`--radius-lg`), meka topla senka (`--shadow-card`), generozan padding (min 24-32px). Povremena "premium" varijanta kartice (teget pozadina + zlatni tekst) za istaknute citate lekara ili ključne poruke — direktno replicira postojeći IG stil i daje sajtu prepoznatljivost.
- **Forme (zakazivanje/kontakt):** mirni, jednostavni inputi sa tankim toplim border-om (`--color-border`), bez agresivnih multi-step funnela ili "poslednja šansa" formulacija — u duhu postojećeg "Zakazivanje u DM" pristupa, samo formalizovanog kroz formu/telefon/email.
- **Svedočanstva:** samo tekstualna, anonimizovana, sa jasnom napomenom o saglasnosti pacijentkinje (već praksa na IG-u) — nikad izmišljena, nikad sa brojkama uspešnosti.
- **Statistike/tabele:** kada se prikazuju medicinski podaci (npr. tabele godine/broj ćelija iz IG grafika), koristiti mirnu tabelarnu prezentaciju sa neutralnim tonom — ne kao "marketing" grafikon uspeha.

## 7. Raspoloženje

**5 prideva:** stručno · toplo · smireno · poverljivo · obazrivo (pažljivo/empatično)

**Čega se klonimo:**
- Stock fotografija trudnica/beba, generički "srećna porodica" klišei
- Roze/lila kao doslovna "beba/plodnost" simbolika
- Hladno kliničko plavo-belo (bolnički, sterilan utisak)
- Jarke, neonske ili previše saturisane boje
- Bilo kakvo obećanje uspeha — velike brojke "% uspešnosti", "garantovano", poređenje sa konkurencijom
- Agresivni marketinški jezik i UI (countdown tajmeri, "ZAKAŽITE ODMAH", pop-up pritisak, pre/posle vizuali)
- Previše dekorativan/luksuzan "wellness-spa" vizuelni jezik (svileni tekstovi, cveće, previše zlata) — ravnoteža mora ostati na strani struke, ne estetike
- Oštri, pravougaoni, "korporativno-hladni" UI elementi bez zaobljenja

## 8. Napomena za sledeće agente

- FK monogram (krug + tanka linija, viđen u "Social freezing" carouselu) je neformalan i može se koristiti kao osnova za favicon/watermark, ali nije zvaničan logotip — proveriti sa klijentom da li postoji vektorska verzija ili ga treba redizajnirati.
- Paleta i tipografija su namerno usklađene sa postojećim IG vizuelnim identitetom (nije nova/izmišljena paleta) kako bi sajt delovao kao prirodni nastavak brenda koji klijent već gradi, ne kao generički template.
