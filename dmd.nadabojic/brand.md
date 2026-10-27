# Brend — dr Nada Bojić · parodontologija i oralna medicina (Hope Dental, Beograd)

> Verzija: 27.10.2026. **Ovaj dokument je napisan iznova.** Prethodna verzija (18.10.2026.) je u
> celosti odbačena jer je sadržala izmišljene podatke — nepostojeći logo „stilizovano DMD sa
> zubima“, generičku paletu `#2A3F54 / #E74C3C / #3498DB` koja nije izvučena ni iz čega, i
> nepostojeće sajtove `dmd.nadabojic.com` / `hopedental.rs`. Vidi `NAPOMENA-TACNOST.md`.
>
> **Ništa ovde nije prepisano iz stare verzije.** Sve boje su izvučene programski iz 16 originalnih
> fotografija u `Assets/Raw/`. Sve što je predlog dizajnera, a ne nalaz iz materijala, označeno je
> **[PREDLOG]**. Sve što traži klijentkinju označeno je **[POTVRDITI SA KLIJENTOM]**.

---

## 0. Metod

- Pregledano je **svih 16 fotografija** iz `Assets/Raw/` (vizuelno, uz `ImageOps.exif_transpose`).
- Boje su izvučene **programski**: Pillow + ručni k-means (numpy, k=6 po slici / k=8 po grupi,
  slike smanjene na ≤140 px duže strane), plus **medijana po ručno zadatim regionima** za ciljane
  uzorke (uniforma, kompresa, zid, tkivo). Medijana po regionu je pouzdanija od k-means proseka i
  ona je osnova palete.
- Svi kontrasti u ovom dokumentu su **izmereni** (WCAG 2.1 relativna luminansa), nisu procenjeni.
- Dijakritici su **provereni** preuzimanjem `latin-ext` woff2 podskupa sa Google Fonts i čitanjem
  `cmap` tabele (fontTools), plus vizuelnim renderom specimena.
- Predloženi logo je **nacrtan i renderovan** (cairosvg) i testiran na 20/32/48 px, na svetloj i
  tamnoj pozadini i monohromatski — geometrija u §6 je proverena, nije teoretska.

### Šta je u materijalu zaista nađeno

| Nalaz | Gde |
|---|---|
| **Nema logotipa** — ni na jednoj od 16 slika, ni na mantilu, ni u prostoru | sve |
| Jedini postojeći vizuelni potpis: **vodeni žig „DMD Nada Bojić“** na pre/posle kolažima | 510877184, 513974491, 621843876, 622161443, 625968056 |
| Žig je **monospace, široko raspoređen (letter-spacing)**, beo ili u boji preuzetoj iz slike | 510877184, 513974491 |
| Oznake **„Pre“ / „Posle“** (ponegde verzalom vertikalno slovo-po-slovo, ponegde opisno: „Pre operacije“, „Odmah nakon operacije sa privremenim (plastičnim) zubima“) | 7 kolaža |
| **Nedoslednost:** žig se pojavljuje u najmanje 5 različitih tipografija/boja/pozicija (mono belo, sage serif verzal, losos, bold sans sa senkom, crna) | — |
| Ordinacija: topli, blago žuto-krem zidovi, krem/puter stomatološka stolica, toplo veštačko svetlo | 485739935, 491414133 |
| Uniforme: hirurški zelena, taupe/mauve, maslinasta | 629986735, 491414133, 503984767 |
| Hirurška kompresa / drape: tirkizno-zelena | 657169803, 503984767 |
| Ton: **telefonski snimci bez jedinstvene obrade**, dosta selfija, mešano osvetljenje | sve |

**Zaključak koji nosi ceo brend:** klijentkinja nema vizuelni identitet — ima *materijal*. Jedino
što se ponavlja kroz feed je **topla, zemljana, prirodna paleta** (krem zidovi, puter stolica, ten
i tkivo) presečena **hirurškom zelenom i tirkizom** (uniforma, kompresa). To je iskren i
neočekivano dobar temelj: topao i medicinski istovremeno, bez ijednog piksela „klinički plave“.

---

## 1. Sirovi uzorci (pre predloga palete)

Medijana po regionu, iz originalnih fajlova:

| Region | Fajl | Medijana | Prosek |
|---|---|---|---|
| Uniforma, hirurški zelena | 629986735 | `#144D3F` | `#1B5141` |
| Hirurška kompresa, tirkiz | 657169803 | `#1E7477` | `#1E7376` |
| Drape / zelena površina | 503984767 | `#214A43` | `#1D3D3A` |
| Zid ordinacije, krem (gore) | 485739935 | `#AE9B8A` | `#A9A091` |
| Zid ordinacije, krem (levo) | 485739935 | `#B39E75` | `#B6A279` |
| Stolica, puter-žuta | 491414133 | `#948063` | `#958678` |
| Tkivo / desni, roze | 670638417 | `#CA7973` | `#C08178` |
| Tkivo / desni, roze 2 | 622896017 | `#CC9F8D` | `#C69A90` |
| Usne, blush | 513974491 | `#D08988` | `#CE9894` |
| Hirurška maska (plava) | 629986735 | `#6093A8` | `#798A98` |

K-means po grupama (dominantni klasteri, sa udelom):

```
A  ordinacija/ambijent  #B19072 20%  #936F54 19%  #D2B28B 17%  #251B17 15%  #634835 12%
B  uniforma/drapes      #3A9BA1 24%  #1B322A 17%  #276E6D 12%  #A56F4B 12%  #5B3F2C 11%
C  pre-posle kolaži     #AB6E64 18%  #C68B7C 18%  #86504B 15%  #D5AE98 15%  #FEFEFE 10%
```

Tri grupe se slažu: **topla zemljana osnova (A, C) + duboka zeleno-tirkizna (B)**.

> Napomena o verodostojnosti: boje su snimljene pod toplim veštačkim svetlom ordinacije, pa su krem
> tonovi u originalima **topliji i prljaviji** nego što sme da bude pozadina sajta. Zato su
> pozadinski tonovi u paleti desaturisani i posvetljeni, uz zadržan topao podton. Zelena i tirkiz
> su preuzeti gotovo doslovno — plava maska je jednokratni potrošni materijal i **namerno nije ušla
> u paletu**.

---

## 2. Paleta

Pravac: **čisto i medicinski, ali toplo i blago premium.** Nišu (parodontologija + estetska medicina
lica) i publiku (pretežno žene 30–55) nosi topla neutralna osnova sa dubokom zelenom kao bojom
struke. Svesno **nema jarko plave** (klišе klinike) i **nema jarko crvene** (alarmantna je, a u
parodontologiji neizbežno asocira na krvarenje desni).

| Uloga | Token | Hex | Poreklo | Gde se koristi |
|---|---|---|---|---|
| **Primarna** | `--primary` | `#14503F` | uniforma 629986735 `#144D3F` | logo, naslovi, primarno dugme, footer, ikone |
| Primarna tamna | `--primary-dark` | `#0E3A2E` | zatamnjena primarna | hover primarnog dugmeta, aktivni link |
| Primarna pozadina | `--primary-wash` | `#E3EDE7` | posvetljena primarna | istaknuti blokovi, „napomena“ kartice |
| **Sekundarna** | `--secondary` | `#1E7477` | kompresa 657169803 `#1E7477` | linkovi, sekundarne ikone, akcenat u grafikama |
| Sekundarna tamna | `--secondary-dark` | `#165457` | zatamnjena | sekundarna boja **za tekst** (vidi §3) |
| **Akcent** | `--accent` | `#C98A7E` | tkivo/usne `#CA7973` / `#CC9F8D` | CTA kontura, podvlake, pre/posle oznake, hover |
| Akcent za tekst | `--accent-ink` | `#8C4A3D` | zatamnjen akcent | tekst i ikone u akcentu (akcent sam **ne prolazi** AA) |
| Akcent meki | `--accent-soft` | `#E8B9AC` | posvetljen akcent | pozadina čipova, dekorativni luk na tamnom |
| Akcent wash | `--accent-wash` | `#F7E6E0` | — | pozadina istaknutog citata / recenzije |
| **Pozadina** | `--bg` | `#FBF8F4` | zid `#B39E75`, posvetljen i desaturisan | pozadina celog sajta |
| **Površina** | `--surface` | `#FFFFFF` | — | kartice, forme, sticky header |
| Površina alt | `--surface-alt` | `#F3EDE4` | zid / stolica, posvetljeno | naizmenične sekcije, gornji deo footera |
| **Tekst** | `--text` | `#1F2421` | `#251B17`, ohlađen ka zelenoj | sav osnovni tekst i naslovi na svetlom |
| **Muted** | `--muted` | `#5C645F` | — | podnaslovi, meta podaci, labele |
| Muted svetli | `--muted-light` | `#7A817C` | — | **samo** tekst ≥18.66 px bold / ≥24 px, ili ikone |
| **Border** | `--border` | `#E6DED2` | zid, posvetljen | linije kartica, razdelnici (dekorativno) |
| Border jaki | `--border-strong` | `#8E8375` | zid | **obavezno** za ivice input polja i focus ring |
| **Potvrđeno / uspeh** | `--success` | `#2E7D5B` | izvedeno iz primarne, svesno življe | kvačice u listi usluga, „zakazano“, validacija |
| Uspeh tamni | `--success-dark` | `#226044` | — | tekst poruke o uspehu |
| Uspeh wash | `--success-wash` | `#E8F0EA` | — | pozadina poruke o uspehu |
| Upozorenje | `--warning` | `#A86A2B` | puter-stolica `#948063`, pojačana | greške u formi (**namerno nije crvena**) |

**Pravilo odnosa:** 70 % `--bg` / `--surface`, 20 % `--primary` (+ `--primary-wash`), 10 % `--accent`.
Tirkiz `--secondary` je *začin* — linkovi i poneka ikona, nikad velike površine, inače sajt sklizne
u „spa“.

---

## 3. Kontrast — izmereno (WCAG 2.1)

Prag: AA normalan tekst **4.5:1**, AA krupan tekst (≥24 px ili ≥18.66 px bold) **3:1**, AA ivice UI
kontrola (1.4.11) **3:1**.

| Prednji plan | Pozadina | Odnos | Status |
|---|---|---|---|
| `--text` `#1F2421` | `--bg` `#FBF8F4` | **14.88:1** | AA / AAA |
| `--text` | `--surface` `#FFFFFF` | **15.76:1** | AA / AAA |
| `--text` | `--surface-alt` `#F3EDE4` | **13.54:1** | AA / AAA |
| `--text` | `--accent-soft` `#E8B9AC` | **8.98:1** | AA / AAA |
| `--muted` `#5C645F` | `--bg` | **5.76:1** | AA |
| `--muted` | `--surface` | **6.10:1** | AA |
| `--muted` | `--surface-alt` | **5.24:1** | AA |
| `--muted-light` `#7A817C` | `--bg` | **3.77:1** | ⚠ samo krupan tekst / ikone |
| `--primary` `#14503F` | `--bg` | **8.82:1** | AA / AAA |
| `--primary` | `--surface` | **9.34:1** | AA / AAA |
| `--primary` | `--surface-alt` | **8.02:1** | AA / AAA |
| `--primary` | `--primary-wash` `#E3EDE7` | **7.80:1** | AA / AAA |
| `--secondary` `#1E7477` | `--bg` | **5.19:1** | AA |
| `--secondary` | `--surface` | **5.50:1** | AA |
| `--secondary-dark` `#165457` | `--bg` | **8.13:1** | AA / AAA |
| `--accent` `#C98A7E` | `--bg` | **2.67:1** | ❌ **NE koristiti kao tekst** |
| `--accent` | `--surface` | **2.83:1** | ❌ **NE koristiti kao tekst** |
| `--accent-ink` `#8C4A3D` | `--bg` | **6.27:1** | AA — **ovo je akcent za tekst** |
| `--accent-ink` | `--surface` | **6.64:1** | AA |
| `--accent-ink` | `--accent-wash` `#F7E6E0` | **5.49:1** | AA |
| `--success` `#2E7D5B` | `--bg` | **4.72:1** | AA (tesno) |
| `--success-dark` `#226044` | `--bg` | **7.02:1** | AA / AAA |
| `--success-dark` | `--success-wash` `#E8F0EA` | **6.40:1** | AA |
| `#FFFFFF` | `--primary` | **9.34:1** | AA / AAA |
| `#FFFFFF` | `--primary-dark` | **12.63:1** | AA / AAA |
| `#FFFFFF` | `--secondary` | **5.50:1** | AA |
| `#FFFFFF` | `--accent` | **2.83:1** | ❌ — na akcentu ide `--text`, ne belo |
| `--text` | `--accent` | **5.57:1** | AA — **ovako se piše po akcentu** |
| `#FFFFFF` | `--accent-ink` | **6.64:1** | AA |
| `#FFFFFF` | `--success` | **5.00:1** | AA |
| `--accent-soft` | `--primary` | **5.32:1** | AA — dekorativni luk na tamnoj pozadini |
| `--border` `#E6DED2` | `--bg` | **1.26:1** | ❌ samo dekorativne linije |
| `--border-strong` `#8E8375` | `--bg` | **3.51:1** | ✔ 1.4.11 — ivice inputa, focus ring |

### Tri obavezna pravila — ako padnu, pristupačnost pada

1. **`--accent` nikada nije boja teksta.** Za tekst u akcentu ide `--accent-ink` (`#8C4A3D`).
2. **Na `--accent` pozadini piše se `--text`, ne belo.** Belo na akcentu je 2.83:1 i pada.
3. **`--border` nije dovoljan za input polja.** Polja forme i focus ring koriste `--border-strong`.

---

## 4. CSS varijable — spremno za copy/paste

```css
:root {
  /* ——— Boje ——— */
  --primary:        #14503F;
  --primary-dark:   #0E3A2E;
  --primary-wash:   #E3EDE7;

  --secondary:      #1E7477;
  --secondary-dark: #165457;  /* koristi za TEKST u tirkiznoj */

  --accent:         #C98A7E;  /* NIKAD kao boja teksta */
  --accent-ink:     #8C4A3D;  /* akcent za tekst/ikone */
  --accent-soft:    #E8B9AC;
  --accent-wash:    #F7E6E0;

  --bg:             #FBF8F4;
  --surface:        #FFFFFF;
  --surface-alt:    #F3EDE4;

  --text:           #1F2421;
  --muted:          #5C645F;
  --muted-light:    #7A817C;  /* samo ≥18.66px bold / ≥24px */

  --border:         #E6DED2;  /* dekorativno */
  --border-strong:  #8E8375;  /* inputi + focus ring */

  --success:        #2E7D5B;
  --success-dark:   #226044;
  --success-wash:   #E8F0EA;
  --warning:        #A86A2B;

  /* ——— Tipografija ——— */
  --font-display: "EB Garamond", "Iowan Old Style", Georgia, "Times New Roman", serif;
  --font-body:    "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
  --font-mono:    "JetBrains Mono", ui-monospace, "SFMono-Regular", Menlo, Consolas, monospace;

  --fs-xs:   0.8125rem;  /* 13px — mono labele */
  --fs-sm:   0.9375rem;  /* 15px */
  --fs-base: 1.0625rem;  /* 17px — osnovni tekst, publika 30–55 */
  --fs-lg:   1.1875rem;  /* 19px — uvodni pasus */
  --fs-h3:   1.5rem;
  --fs-h2:   clamp(1.75rem, 1.2rem + 1.8vw, 2.5rem);
  --fs-h1:   clamp(2.25rem, 1.4rem + 3.2vw, 3.75rem);

  --lh-tight: 1.15;   /* naslovi */
  --lh-body:  1.65;   /* tekst — namerno široko, čita se na telefonu */
  --ls-mono:  0.14em; /* letter-spacing mono labela — iz njenog vodenog žiga */

  /* ——— Radijusi ——— */
  --r-xs:   4px;   /* čipovi, badževi */
  --r-sm:   8px;   /* input polja */
  --r-md:   12px;  /* dugmad */
  --r-lg:   16px;  /* kartice */
  --r-xl:   24px;  /* veliki medija blokovi, hero slika */
  --r-full: 999px; /* pilule, avatari */

  /* ——— Senke (topao podton, nikad siva/plava) ——— */
  --shadow-xs: 0 1px 2px rgba(31, 36, 33, 0.05);
  --shadow-sm: 0 2px 6px rgba(31, 36, 33, 0.06);
  --shadow-md: 0 6px 18px rgba(31, 36, 33, 0.08);
  --shadow-lg: 0 16px 40px rgba(31, 36, 33, 0.10);
  --shadow-focus: 0 0 0 3px rgba(20, 80, 63, 0.28);

  /* ——— Razmaci (skala 4px) ——— */
  --sp-1:  4px;   --sp-2:  8px;   --sp-3:  12px;  --sp-4:  16px;
  --sp-5:  24px;  --sp-6:  32px;  --sp-7:  48px;  --sp-8:  64px;
  --sp-9:  96px;  --sp-10: 128px;

  --section-y:        clamp(56px, 7vw, 112px);
  --container:        1160px;
  --container-narrow: 720px;   /* tekstualne stranice */
  --gutter:           clamp(16px, 4vw, 32px);

  /* ——— Ostalo ——— */
  --ease: cubic-bezier(0.22, 0.61, 0.36, 1);
  --dur:  220ms;
  --border-w: 1px;
}

@media (prefers-reduced-motion: reduce) {
  :root { --dur: 1ms; }
}
```

---

## 5. Tipografija

### Provera dijakritika (urađena, ne pretpostavljena)

Preuzet je `latin-ext` woff2 podskup sa Google Fonts i pročitana `cmap` tabela. Za svaki kandidat
**svih 10 znakova `č ć š ž đ Č Ć Š Ž Đ` postoji**. Zatim je renderovan specimen da se vidi *kako su
nacrtani* — prisustvo glifa ne znači ništa ako je kvačica loše postavljena.

| Font | Glifova u latin-ext | `čćšžđ` | Crtež kvačice |
|---|---|---|---|
| EB Garamond | 799 | svi | ✔ čvrsta, dobro spuštena i centrirana |
| Inter | 733 | svi | ✔ čista, dobro uklopljena |
| JetBrains Mono | 190 | svi | ✔ izražena, čitljiva i na 13 px |
| Source Serif 4 | 276 | svi | ✔ čvrsta |
| Source Sans 3 | 563 | svi | ✔ čvrsta |
| Spectral | 312 | svi | ✔ dobra |
| Lora | 192 | svi | ✔ dobra |
| Work Sans | 318 | svi | ✔ dobra |
| **Cormorant Garamond** | — | svi | ❌ **kvačica sitna, previsoka i vizuelno odvojena** — potvrđeno renderom, **ne koristiti** |

Specimen potvrđuje upozorenje iz brifa: Cormorant Garamond *ima* glifove, ali ih crta tako da
„Bojić“ izgleda nedovršeno. EB Garamond rešava isti estetski zadatak bez tog problema.

### Par A — **preporučen**

**EB Garamond** (naslovi) + **Inter** (tekst) + **JetBrains Mono** (mikro-labele)

```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
```

**Zašto baš ovaj par:**

- **EB Garamond** daje ono što estetska medicina lica traži — *mekoću i tiho poštovanje prema
  izgledu* — a da ne sklizne u dekorativnost. Humanistički i topao: čita se kao ozbiljnost, ne kao
  trend. Slaže se sa krem zidovima i zemljanim tonovima iz njenog materijala. Ima pravu italic (ne
  mehanički nagib), dragocenu za stručne termine (*gingivitis*, *periimplantitis*) i za potpis
  ispod citata pacijenta.
- **Inter** je najneutralniji mogući partner: visok x-height, otvorene forme, odličan na 17 px na
  telefonu — a saobraćaj sa IG bio linka je gotovo u celosti mobilni. Ima `tabular-nums` za cene i
  telefone. Namerno je *dosadan* — sav karakter nosi naslov.
- **JetBrains Mono** nije ukras nego **jedini element preuzet iz njenog postojećeg vizuelnog
  jezika**. Vodeni žig na njenim pre/posle kolažima je monospace sa širokim razmakom; taj gest se
  zadržava i formalizuje kao sistem mikro-labela. Prepoznaće ga kao svoj.

**Raspodela uloga:**

| Element | Font | Veličina / stil |
|---|---|---|
| H1 | EB Garamond 500 | `--fs-h1`, `--lh-tight`, `letter-spacing: -0.015em` |
| H2 | EB Garamond 500 | `--fs-h2`, `--lh-tight` |
| H3 | EB Garamond 600 | `--fs-h3` |
| Uvodni pasus (lead) | Inter 400 | `--fs-lg`, boja `--muted` |
| Osnovni tekst | Inter 400 | `--fs-base`, `--lh-body`, max 68 znakova u redu |
| Dugmad, navigacija | Inter 500 | `--fs-sm` |
| **Eyebrow, „PRE“/„POSLE“, oznake sekcija** | JetBrains Mono 500 | `--fs-xs`, `uppercase`, `letter-spacing: var(--ls-mono)`, `--accent-ink` ili `--muted` |
| Cene, telefon | Inter 500 | `font-variant-numeric: tabular-nums` |

> Ne koristiti EB Garamond ispod 18 px i nikad za duži tekst — nizak x-height, na telefonu pada.
> Naslovi i citati, ništa više.

### Par B — alternativa (institucionalniji, „ozbiljna medicina“)

**Source Serif 4** (naslovi) + **Source Sans 3** (tekst)

```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,400;8..60,600&family=Source+Sans+3:wght@400;500;600&display=swap" rel="stylesheet">
```

Superfamilija iz istog izvora (Adobe), pa se naslov i tekst uklapaju bez podešavanja. Source Serif 4
ima **optičke veličine** — isti font je robustan na 15 px i elegantan na 56 px, čime rešava jedinu
slabost EB Garamonda. Dijakritici su crtani po Adobe standardu, najsigurniji od svih kandidata.

Uzeti Par B ako klijentkinja kaže da joj je Par A „previše mek / previše kao kozmetički salon“, ili
ako se planira blog i duži stručni tekstovi. Par B je sigurniji, Par A je karakterniji.
**[POTVRDITI SA KLIJENTOM]**

---

## 6. Logo

> **Logo ne postoji.** Nijedna od 16 fotografija ne sadrži logotip, znak, pečat ni natpis na
> mantilu. Jedino postojeće brendiranje je nedosledan tekstualni vodeni žig. Sve ispod je
> **[PREDLOG]** — crta se kao SVG, nema rasterskog izvora.
> **Finalni izbor i odobrenje: [POTVRDITI SA KLIJENTOM].**

### Polazište

Standardni stomatološki logo je „zub + četkica“ ili „zub + osmeh“ — pogrešan za nju iz dva razloga:
nije opšti stomatolog nego **parodontolog** (bavi se *tkivom oko zuba*, ne zubom samim), a uz to radi
i **estetsku medicinu lica**. Motiv zato mora da uključi **desni** — to je i njena struka i jedino
što je razlikuje od svake druge ordinacije u Beogradu.

### Tri koncepta

**Koncept 1 — „Gingivalni zagrljaj“ (zub u luku desni)**
Pun, mek zub kao znak, obgrljen otvorenim lukom koji predstavlja parodoncijum — potporno tkivo koje
drži zub. Luk je u akcentnoj roze boji (boja zdravog tkiva, direktno iz njenih fotografija), zub u
primarnoj zelenoj. Poruka: *zub stoji zato što ga nešto drži.* To je bukvalno definicija
parodontologije. Nema četkice, nema osmeha, nema klišea.

**Koncept 2 — „Monogram NB sa gingivalnom linijom“**
Inicijali `NB` u EB Garamond verzalu, a dijagonala slova `N` produžena u blagi skalopirani luk
(prirodni talasasti oblik gingivalne margine) koji podvlači oba slova. Suptilno, tipografski, „za
one koji znaju“. Mana: čita se kao inicijali bilo koga, znak ne govori čime se bavi, a na 16 px
favicon-u skalop nestaje.

**Koncept 3 — „Zub kao negativni prostor u kapi“**
Zaobljena kap/štit u punoj zelenoj, sa zubom izrezanim kao negativni prostor. Moderno i čisto,
odlično na favicon-u. Mana: kap/štit forma je preterano iskorišćena u medicinskom brendiranju
(osiguranje, apoteke) i ne govori ništa o desnima — gubi se baš ono po čemu se izdvaja.

### ✅ Preporuka: **Koncept 1 — „Gingivalni zagrljaj“**

Jedini od tri koji **istovremeno** kaže „stomatologija“ i „parodontologija“, izdržava 20 px, radi
monohromatski i nije viđen na svakom drugom sajtu. Koncept 2 se zadržava kao **sekundarni element**
(monogram u mejl potpisu i na poleđini vizitke), ne kao glavni znak.

#### Geometrija (crtano i provereno renderom)

Mreža **48 × 48**, `viewBox="0 0 48 48"`. Dva elementa:

**(a) Zub** — simetričan, jedan zatvoren `path`. Kruna je široka zaobljena kupola (y ≈ 9 → 18),
bočne strane se blago sužavaju nadole, dva korena se razdvajaju plitkim šiljkom u sredini i
završavaju zaobljenim vrhovima (y ≈ 38). Ceo zub je skaliran na **0.84** i pomeren naviše
(`translate(24, 22.5)`) da bi luk ispod njega imao vazduha.

**(b) Luk desni** — otvoren luk, **samo stroke, nikad fill**, `stroke-width: 2.5`,
`stroke-linecap: round`. Počinje na (9.5, 18) levo, spušta se u čistu U-krivu do (24, 40) i
simetrično se diže do (38.5, 18). Krajevi luka završavaju **iznad** najšireg dela krune — to oblik
čini „zagrljajem“, a ne „tanjirom“.

**Optički centar:** masa zuba je u gornje dve trećine, pa se u punom logotipu ceo znak pomera
**1.5 % naviše** u odnosu na matematički centar reda sa tekstom, inače izgleda da „pada“.

**Minimalni razmak između luka i korena zuba: 2 px na mreži 48.** Ako se dodiruju, znak se na malim
veličinama slepi u mrlju — testirano, prva verzija je upravo na tome pala.

#### SVG — samo znak (kopirati u projekat)

```html
<!-- Znak — primarna varijanta, svetla pozadina -->
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48" height="48"
     role="img" aria-label="dr Nada Bojić — parodontologija i oralna medicina">
  <path d="M9.5 18 C9.5 31 16 40 24 40 C32 40 38.5 31 38.5 18"
        fill="none" stroke="#C98A7E" stroke-width="2.5" stroke-linecap="round"/>
  <g transform="translate(24,22.5) scale(0.84) translate(-24,-24)">
    <path d="M15 18 C15 11.5 20 9 24 9 C28 9 33 11.5 33 18
             C33 22 32.4 25.6 31.4 29.6 C30.6 32.8 29.4 36 28.4 38
             C27.6 39.6 26 39.3 25.7 37.3 L24.7 28.8
             C24.5 27.2 23.5 27.2 23.3 28.8 L22.3 37.3
             C22 39.3 20.4 39.6 19.6 38 C18.6 36 17.4 32.8 16.6 29.6
             C15.6 25.6 15 22 15 18 Z" fill="#14503F"/>
  </g>
</svg>
```

**Linijska varijanta** (veliki formati, štampa, vodeni žig na slikama): isti `path` zuba, ali
`fill="none" stroke="#14503F" stroke-width="2.3" stroke-linejoin="round" stroke-linecap="round"`.
Ne koristiti ispod 32 px — linija se zatvori.

#### Varijante — obavezne

| Varijanta | Zub | Luk | Pozadina | Gde |
|---|---|---|---|---|
| Primarna | `#14503F` pun | `#C98A7E` | `--bg` / `--surface` | header, sve svetle površine |
| Linijska | `#14503F` stroke 2.3 | `#C98A7E` | svetla | veliki formati, štampa, vodeni žig |
| Na tamnoj | `#FBF8F4` pun | `#E8B9AC` (5.32:1) | `--primary` `#14503F` | footer, hero preko slike |
| Monohromatska tamna | `#14503F` | `#14503F` | svetla | pečat, jednobojna štampa, faks |
| Monohromatska bela | `#FFFFFF` | `#FFFFFF` | `--text` / fotografija | preko fotografija |
| Krug (medaljon) | `#FBF8F4` | `#E8B9AC` | krug `#14503F`, `r=24` | favicon, avatar, mobilni header |

Za krug: znak se unutar kruga skalira na **0.76** i pomera na `translate(24, 25)` — vizuelno
centriran, ne matematički.

#### Pun logotip

**Horizontalna varijanta** (podrazumevana — header, mejl potpis, vizitka):

```
[znak 40px]  dr Nada Bojić
             PARODONTOLOGIJA I ORALNA MEDICINA
```

- Znak: visina **40 px**, levo.
- Razmak znak ↔ tekst: **0.5 × visina znaka** (20 px na 40 px znaku).
- „dr Nada Bojić“: **EB Garamond 500**, 24 px, `--text` ili `--primary`, `letter-spacing: -0.01em`.
  Malo `dr`, bez tačke, bez verzala — tako i ona sebe piše u bio-u.
- Podnaslov: **JetBrains Mono 500**, 10 px, `uppercase`, `letter-spacing: 0.16em`, `--muted`.
  Mono ovde nije hir — to je njen vodeni žig pretvoren u sistem.
- Podnaslov poravnat levo sa imenom, razmak između redova **6 px**.
- Podnaslov se **izostavlja ispod 360 px širine ekrana** — ostaje znak + ime.

**Vertikalna varijanta** (otvaranje stranice, štampa, og-image): znak centriran gore, ime **16 px**
ispod, podnaslov **8 px** ispod imena, sve centrirano. Znak 56–72 px.

**Samo znak:** favicon, mobilni header ispod 480 px, avatar na društvenim mrežama, loader.

#### Minimalne veličine i bezbedni prostor

| Varijanta | Minimum |
|---|---|
| Samo znak (pun) | **20 px** — testirano renderom, čita se |
| Samo znak (linijski) | **32 px** |
| Horizontalni logotip sa podnaslovom | **180 px** širine |
| Horizontalni bez podnaslova | **120 px** širine |
| Vertikalni | **96 px** širine |

**Bezbedni prostor:** sa svih strana najmanje **visina krune zuba** (≈ 0.45 × visina znaka). Ništa
— ni tekst, ni ivica, ni druga slika — ne ulazi u tu zonu.

**Zabranjeno:** rotiranje, razvlačenje (uvek `aspect-ratio: 1` za znak), senka ispod znaka,
gradijent, menjanje odnosa znaka i teksta, zamena boje luka bilo čime van navedenih varijanti,
postavljanje na fotografiju bez dovoljnog kontrasta (tada ide monohromatska bela).

#### Favicon

- `favicon.svg` — varijanta **krug** (znak u zelenom medaljonu). SVG favicon se skalira savršeno i
  podržan je u svim modernim pregledačima.
- `favicon-32.png` — fallback, takođe krug.
- `favicon-16.png` — na 16 px luk se stapa sa ivicom kruga, pa za tu veličinu rasterizovati **bez
  luka** (samo zub `#FBF8F4` na krugu `#14503F`). Testirano — luk na 16 px samo zamućuje znak.
- `apple-touch-icon.png` 180×180 — znak na punoj `#14503F` pozadini, **bez kruga** (iOS sam
  zaobljava), znak skaliran na 60 % platna.
- `site.webmanifest`: `theme_color: "#14503F"`, `background_color: "#FBF8F4"`.

#### og-image (1200 × 630)

- Pozadina: `--primary` `#14503F` puna, **ili** fotografija ordinacije prekrivena
  `rgba(20, 80, 63, 0.78)`.
- Levo, sa `--sp-9` margine: vertikalni logotip u varijanti „na tamnoj“, znak 88 px.
- Ispod: „dr Nada Bojić“ EB Garamond 500, 64 px, `#FBF8F4`; podnaslov JetBrains Mono 20 px,
  uppercase, `letter-spacing: 0.16em`, `#E8B9AC`.
- Dole levo: `PARODONTOLOG · BEOGRAD` u mono, 18 px, `#E8B9AC`.
- **Bez telefona, adrese i cena na og-image-u** — ti podaci nisu potvrđeni (vidi §11), a og-image se
  kešira na društvenim mrežama mesecima i teško se menja.

---

## 7. Smernice za UI

### Dugmad

| Tip | Pozadina | Tekst | Ivica | Napomena |
|---|---|---|---|---|
| Primarno | `--primary` | `#FFFFFF` (9.34:1) | — | „Zakažite pregled“. **Jedno po ekranu.** |
| Primarno :hover | `--primary-dark` | `#FFFFFF` (12.63:1) | — | + `translateY(-1px)`, `--shadow-md` |
| Sekundarno | transparentno | `--primary` | 1.5 px `--primary` | „Saznajte više“ |
| Sekundarno :hover | `--primary-wash` | `--primary` | 1.5 px `--primary` | |
| Tekstualno | — | `--secondary-dark` | — | podvlaka na hover |
| Telefon (sticky mobilni) | `--primary` | `#FFFFFF` | — | puna širina, `position: sticky; bottom: 0` |

- Visina: **48 px** desktop, **52 px** mobilni (prst; publika 30–55).
- Padding `14px 28px`, radijus `--r-md` (12 px) — zaobljeno, ali ne pilula. Pilula vuče ka
  „wellness“, oštar ugao ka „klinika“; 12 px je tačno između.
- Font Inter 500, `--fs-sm`, **bez `uppercase`** (uppercase na dugmadima deluje vikajuće).
- `:focus-visible`: `box-shadow: var(--shadow-focus)` + `outline: 2px solid var(--primary)` sa
  `outline-offset: 2px`. **Nikad `outline: none` bez zamene.**
- Tranzicija `var(--dur) var(--ease)` na `background-color, transform, box-shadow`.

### Kartice

- Pozadina `--surface`, radijus `--r-lg` (16 px), ivica `1px solid --border`, senka `--shadow-sm`.
- Padding `--sp-5` (24 px) mobilni, `--sp-6` (32 px) desktop.
- Hover (samo ako je cela kartica klikabilna): `--shadow-md` + `translateY(-2px)`. Bez promene boje
  pozadine — kartice sa uslugama ne treba da „svetle“.
- Ikona usluge: **24 px, stroke 1.75, `--secondary`**, u kvadratu 48×48 sa pozadinom
  `--primary-wash` i radijusom `--r-md`.
- Naslov kartice: EB Garamond 600, `--fs-h3`, `--text`. Opis: Inter 400, `--fs-sm`, `--muted`.
- Mreža: `repeat(auto-fit, minmax(300px, 1fr))`, gap `--sp-5`.

### Ikone

- **Stroke stil, `stroke-width: 1.75`, `stroke-linecap: round`, 24 px** — mora da se slaže sa lukom
  iz logotipa (isti jezik: zaobljeni krajevi, tanka linija).
- Boja: `--secondary` dekorativne, `--primary` funkcionalne, `--success` kvačice.
- **Nikad punjene (filled) ikone** — sukobile bi se sa punim zubom u logotipu, koji mora da ostane
  jedini puni oblik u sistemu.

### Forme

- Polje: visina 48 px, pozadina `--surface`, **`1px solid --border-strong`** (3.51:1, zadovoljava
  1.4.11), radijus `--r-sm` (8 px), padding `12px 16px`, Inter 400 `--fs-base`.
  **Font ne sme biti ispod 16 px** — iOS inače zumira pri fokusu.
- `:focus`: ivica `--primary` + `--shadow-focus`.
- Labela **iznad polja**, uvek vidljiva, Inter 500 `--fs-sm` `--text`. Bez placeholder-a umesto
  labele — nestaje čim korisnik kuca, što je gubitak za stariju publiku.
- Greška: tekst i ivica `--warning` `#A86A2B` + ikona. **Namerno nije crvena.**
- Uspeh: pozadina `--success-wash`, tekst `--success-dark` (6.40:1), ikona kvačice `--success`.
- Obavezna polja: `*` u `--accent-ink`, plus tekst „obavezno“ za čitače ekrana.

### Razmaci i ritam

- Sekcija: `padding-block: var(--section-y)`.
- Naslov sekcije ↔ sadržaj: `--sp-6` (32 px). Eyebrow ↔ naslov: `--sp-2` (8 px).
- Kontejner `--container` (1160 px); tekstualne stranice `--container-narrow` (720 px).
- Naizmenične sekcije `--bg` / `--surface-alt`. **Nikad dve susedne sekcije iste boje bez
  razdelnika** — sajt se slije u jednu traku.
- Gustina: **prozračna, ne vazdušasta.** Mnogo belog prostora čita se kao luksuz, previše kao
  nedovršeno.

### Animacije

- Suzdržano: `fade-up` 16 px na ulazu u viewport, 400 ms, `--ease`, stagger 60 ms.
- Bez paralakse, bez auto-play karusela, bez brojača, bez animiranih zuba.
- `@media (prefers-reduced-motion: reduce)` mora da isključi sve — već je u CSS-u u §4.

---

## 8. Smernice za fotografiju

### Problem sa postojećim materijalom (iskreno)

Svih 16 slika je snimljeno telefonom, u mešanom osvetljenju, bez jedinstvene obrade. Među njima: tri
selfija sa maskom, nekoliko kliničkih makro snimaka, sedam pre/posle kolaža — i **nijedan upotrebljiv
hero portret**, **nijedan širok kadar ordinacije sa upaljenim svetlima**, **nijedna fotografija
ulaza**. Sajt se može napraviti sa ovim materijalom, ali će izgledati kao Instagram, ne kao brend.

**Blokirajuće za finalnu verziju:** portret u mantilu na čistoj pozadini (4:5 i 16:9), širok kadar
ordinacije, fotografija ulaza u zgradu. Vidi `image-shortlist.md`. **[POTVRDITI SA KLIJENTOM]**

### Obrada — jedinstven izgled

- **Topla, svetla, blago izbledela.** Podići senke, spustiti kontrast ~5 %, temperatura ka toploj
  (slike ordinacije su već tople — zadržati to, ne „ispravljati“ u neutralno).
- Zasićenost **−8 do −12 %** na svemu osim na kliničkim snimcima; tamo ide tačna boja, to je
  medicinski podatak i ne sme se retuširati.
- **Bez** plavih/hladnih filtera, bez HDR-a, bez vinjete.
- Jedan preset za sve ambijentalne i portretne slike. Klinički snimci su izuzetak.

### Prikaz na sajtu

- Radijus `--r-xl` (24 px) za hero i velike medija blokove, `--r-lg` (16 px) unutar kartica.
- Okvir: `1px solid --border` + `--shadow-sm`. Suptilno — slika treba da „sedi“ na papiru, ne da
  lebdi.
- `object-fit: cover`, fiksni `aspect-ratio` po tipu (hero 16:9, portret 4:5, galerija 1:1) da ne
  bude skoka u layoutu.
- Obavezno `loading="lazy"` svuda osim na hero slici, plus `width`/`height` atributi.
- Preko fotografije uvek `rgba(20, 80, 63, 0.55)` overlay pre belog teksta — kontrast proveriti na
  **najsvetlijem** delu slike, ne na proseku.

### Pre/posle — pristojno, bez senzacionalizma

Najosetljiviji deo sajta. Pravila:

- **Nijedna pre/posle slika ne ide na sajt bez potpisane saglasnosti pacijenta.** Bez izuzetka.
  **[POTVRDITI SA KLIJENTOM]**
- **Kadrirati na usta.** Bez očiju, bez prepoznatljivih detalja. Postojeći kolaži — npr.
  `513974491` i `622161443` — pokazuju deo lica; **moraju se prekadrirati** pre upotrebe.
- **Dve slike jedna pored druge** (desktop) ili jedna ispod druge (mobilni), **jednake veličine**,
  radijus `--r-lg`, razmak `--sp-3`, tanka `--border` linija oko svake.
  **Ne koristiti „slider“ sa prevlačenjem** — pretvara medicinski rezultat u igračku.
- Oznake **„PRE“ / „POSLE“** kao čipovi: JetBrains Mono 500, 11 px, uppercase,
  `letter-spacing: var(--ls-mono)`, tekst `--accent-ink`, pozadina `--accent-wash`, radijus `--r-xs`,
  padding `4px 10px`, **iznad slike levo — ne preko nje.** Ovo zamenjuje pet različitih žigova koji
  trenutno stoje na njenim kolažima.
- Ispod svakog para **obavezno**: naziv intervencije, trajanje terapije i jedna rečenica o
  složenosti slučaja. Rezultat bez konteksta je reklama; sa kontekstom je dokumentacija.
- Ispod cele sekcije, sitno, `--muted`, `--fs-sm`:
  *„Prikazani slučajevi su objavljeni uz pismenu saglasnost pacijenata. Rezultat terapije je
  individualan i zavisi od stanja tkiva, opšteg zdravlja i saradnje pacijenta.“*
- **Najviše 3 para na naslovnoj.** Ostalo u galeriju po uslugama.
- Bez strelica „↓“, bez „neverovatna transformacija“, bez crveno-zelenih oznaka, bez emodžija.

### Klinički snimci (makro, intraoralno)

- Idu **samo** na stranice pojedinačnih usluga i u galeriju — **nikad na naslovnu**, nikad u hero.
- Uvek iza `<details>` / „Prikaži kliničke fotografije“ toggle-a, zatvoreno po defaultu. Publika
  30–55 koja traži „parodontolog Beograd“ ne treba da naleti na `521906199` (otvorena vilica sa
  implantima) pri prvom skrolu.
- Uz svaki snimak kratak opis šta se vidi. Snimak bez objašnjenja plaši; sa objašnjenjem edukuje.

---

## 9. Potpisni vizuelni element

### „Gingivalni luk“ — luk iz logotipa kao sistemski element

Isti otvoreni luk koji u logotipu obgrljuje zub koristi se kroz ceo sajt kao **jedini dekorativni
oblik u sistemu**. Nigde drugde nema ukrasa — zato ovaj nešto znači.

1. **Podvlaka ispod naslova sekcije.** Ispod svakog H2, poravnat levo, širine **64 px**, visine
   10 px, razmak 12 px od naslova:

   ```html
   <svg width="64" height="10" viewBox="0 0 64 10" aria-hidden="true" focusable="false">
     <path d="M2 2 C2 8 10 8 32 8 C54 8 62 8 62 2"
           fill="none" stroke="#C98A7E" stroke-width="2.5" stroke-linecap="round"/>
   </svg>
   ```

2. **Razdelnik sekcija.** Isti luk, širine `--container`, veoma blag (visina 24 px na 1160 px),
   `stroke: --border`, `stroke-width: 1.5` — umesto obične `<hr>`. Jedva se primeti, ali daje ritam.

3. **Luk kao maska hero slike.** Donja ivica hero fotografije nije prava linija nego ista blaga
   U-kriva (`clip-path` ili `border-radius: 0 0 50% 50% / 0 0 24px 24px`). Sledeća sekcija ulazi u
   taj luk. Suptilno „tkivo koje drži“ — niko to neće svesno primetiti, ali sajt postaje prepoznatljiv.

**Drugi potpisni element: mono mikro-labele.** Svaka sekcija ima eyebrow u JetBrains Mono, uppercase,
`letter-spacing: 0.14em`, u `--accent-ink` (`USLUGE`, `O MENI`, `REZULTATI`, `KONTAKT`). Ovo **nije
izmišljeno** — to je njen sopstveni vodeni žig, samo doveden u red. Kad vidi sajt, prepoznaće svoj
rukopis.

---

## 10. Raspoloženje

**Pet prideva:** `smirena` · `precizna` · `topla` · `stručna` · `uzdržano otmena`

**Čega se klonimo:**

| Ne | Zašto |
|---|---|
| Jarko plava + bela („klinika“) | Klišе stomatološkog sajta, hladno i bezlično. U njenom materijalu te boje **nema** — jedino plavo je jednokratna hirurška maska. |
| Jarko crvena | Alarmantna, a u parodontologiji direktno asocira na krvarenje desni — tačno na simptom od kog pacijent beži. Zato greške idu u `--warning` `#A86A2B`. |
| Gradijenti, neon, glassmorphism | Sukob sa medicinskim poverenjem; brzo zastari. |
| Stock fotografije savršenih osmeha i ljudi koji nisu ona | Lični brend. Jedna stock slika ruši sve. |
| Emodži u UI-ju, uzvičnici, „🦷✨“ | Na Instagramu prolazi, na sajtu lekara specijaliste ne. |
| „Neverovatna transformacija“, „magija“, „savršen osmeh“ | Senzacionalizam; takođe problematično u odnosu na oglašavanje zdravstvenih usluga. |
| Odbrojavanja, pop-up popusti, „poslednja mesta“ | Degradira specijalistu u prodavca. |
| Animirani zubi, maskote, četkice | Pedijatrijska stomatologija, ne parodontologija. |
| Previše belog prostora | Granica između „luksuzno“ i „nedovršeno“ je tanka. Prozračno, ne prazno. |
| Tamna tema (dark mode) | Za medicinski sadržaj i publiku 30–55 — ne. Tamna se koristi **samo** u footeru i hero overlay-u. |
| Cormorant Garamond i slični fontovi sa lošim kvačicama | Provereno renderom: „Bojić“ izgleda nedovršeno. |

**Jedna rečenica za dizajnera:** *ordinacija sa krem zidovima i toplim svetlom, u kojoj doktorka u
tamnozelenoj uniformi objašnjava stvari mirno i do kraja* — to je ceo brend, i to je doslovno ono
što se vidi na njenim fotografijama.

---

## 11. Šta nije poznato

Ništa od ovoga nije pogađano. Sve blokira finalnu verziju sajta i traži klijentkinju.

**Brend i identitet**
- Postoji li ikakav logo, pečat, vizitka ili natpis na vratima koji nismo videli — i da li je
  predloženi znak iz §6 prihvatljiv
- Da li brend ide pod **ličnim imenom** (dr Nada Bojić) ili pod **Hope Dental**, i kakav je odnos ta
  dva — da li Hope Dental ima svoj logo i boje kojima se ovaj identitet mora podrediti
- Da li je „Spec. dr“ iz bio-a **specijalista** (završena specijalizacija) ili **specijalizant** —
  pravno i etički bitna razlika u ispisu titule na sajtu
- Izbor između tipografskog Para A i Para B

**Kontakt i poslovanje — ništa od ovoga nije poznato**
- Adresa ordinacije
- Telefon, Viber/WhatsApp, e-mail
- Radno vreme po danima
- Cene (pojedinačne ili raspon) i da li uopšte žele javan cenovnik
- Način zakazivanja (telefon / formular / WhatsApp / online kalendar)
- **Domen ne postoji.** `dmd.nadabojic.com` i `hopedental.rs` iz stare verzije su izmišljeni/
  nepotvrđeni i ne smeju se koristiti nigde, ni kao primer.
- Postojeći Google Business profil, Facebook stranica, drugi nalozi

**Struka**
- Fakultet, godina diplomiranja, godine iskustva
- Sertifikati, kursevi, članstva u komori i stručnim društvima
- Kompletna i tačna lista usluga sa opisima. Sa profila su poznate samo kategorije: pregled i plan
  terapije, parodontologija i oralna medicina, oralna hirurgija, fiksna protetika, estetska medicina
  lica (botoks, fileri, PRP, skinbooster)
- Oprema koja se ističe
- Da li radi sama ili ima tim

**Materijal i pravo**
- **Postoje li potpisane saglasnosti pacijenata** za pre/posle i kliničke fotografije — bez njih
  nijedna od 7 pre/posle slika iz `Assets/Raw/` ne sme na sajt
- Postoji li profesionalna fotosesija ili je sve snimljeno telefonom (sudeći po materijalu —
  telefonom)
- Broj pratilaca i Google ocena, ako želi da se prikazuju
- Tekstualne recenzije pacijenata sa dozvolom za objavu
