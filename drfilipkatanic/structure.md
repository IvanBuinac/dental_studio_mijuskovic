# Structure: dr Filip Katanić (višestranični statički sajt)

Ulazi: `research.md`, `web-research.md`, `seo.md` (posebno odeljak 0 — obavezna pravila, i odeljak 3 — arhitektonska odluka), `brand.md`, `assets/manifest.md`, `assets/NOTES.md` + pregled slika (`hero.webp`, `portret-01.webp`, `edukacija-embrioni-01.webp`, `brend-vizual-01.webp`, `edukacija-social-freezing-01.webp`, `konferencija-02.webp`, `edukacija-simptomi-01.webp`). Datum: 2026-09-25.

Copywriter i Developer rade po ovom dokumentu. Build sistem: `build.py` + `src/partials` + `src/pages` → `site/` (isti sistem kao kod ostalih klijenata), statički HTML/CSS/JS bez baze. Boje/fontovi/CSS varijable isključivo iz `brand.md` — ovde se ne ponavljaju u celosti. seo.md je autoritet za title/meta/H1/schema — ovaj dokument ih ne prepisuje, samo referencira.

**Titula, kontakt-napomene i zabranjeni izrazi u ovom dokumentu prate seo.md odeljak 0 doslovno — nema odstupanja.**

---

## 0. Koncept — kako sajt NIJE šablon "estetske klinike" ni "korporativne bolnice"

Ovo je **lični brend/portfolio** mladog lekara u izrazito osetljivoj temi (sterilitet), ne sajt klinike (seo.md 0.4). Ton: empatičan, uzdržan, edukativan — sajt mora delovati kao **produžetak postojećeg IG glasa** dr Katanića, ne kao generički medicinski template. Iz `brand.md` odeljka 0 vidljivo je da već postoje 4 dosledna vizuelna obrasca na IG-u (krem/polaroid, crna school-board sa zaobljenim zlatnim ramom, teget/zlatna "premium" kartica, krem+teget+zlato+FK monogram) — sajt ih konsoliduje, ne izmišlja novu estetiku.

**Raspodela boja** (za razliku od "noir-dominantnog" pristupa u drugim nišama): ~65% topao krem (`--color-bg`), ~20% navy (hero, credential/citat blokovi, CTA traka, footer, mobilni meni), ~10% bela/kartice, ~5% šalvija/zlato kao akcenat (nikad kao dominantna pozadina, vidi brand.md 3 — kontrast pravila). Tamne (navy) sekcije: hero na početnoj, "Pristup radu" citat blokovi, CTA traka, footer, mobilni meni. Sve ostalo je krem/belo — sajt mora delovati **vazdušasto, ne klinički gusto** (brand.md 5: "nizak do srednji nivo gustine, puno vazduha").

**Nema:** cenovnika, brojeva uspešnosti, countdown/urgency elemenata, stock fotografija trudnica/beba, pre/posle vizuala, poređenja sa drugim lekarima/klinikama, oštrih pravougaonih blokova (sve je zaobljeno — brand.md 5), testimonijala dok ih nema sa saglasnošću.

### 0.1 POTPISNI ELEMENT: "FK pečat" i zlatni oval okvir (`.seal` + `.frame--halo`)

Izveden direktno iz postojećeg IG vizuelnog jezika (ne izmišljen, ne kopiran od drugog klijenta):
1. **FK monogram u krugu** — već postoji kao potpis na "Social freezing" karusel kartici (tanka teget linija, krug, "FK" iznutra) — brand.md ga eksplicitno navodi kao osnovu za favicon/watermark.
2. **Zaobljeni zlatni ram** — vidljiv na "school-board" premium karticama (crna tabla, zaobljen zlatni okvir sa malim razmakom od ivice — vidi `edukacija-embrioni-01.webp`).
3. **Oval pill-bedž** — "SOCIAL FREEZING" oznaka na `edukacija-social-freezing-01.webp` (tanka zaobljena oval kontura, uppercase tekst, mala ikona).

Ova tri elementa se spajaju u dosledan sistem:

| # | Komponenta | Gde | Kako |
|---|---|---|---|
| A | **`.seal`** (FK pečat) | Header logo, favicon, footer, kraj istaknutih citata, section-divider na prelazu krem→navy | Krug (36–48px), tanka linija (`--color-accent-decorative` na navy / `--color-accent` na kremu), inicijali "FK" centrirano (Fraunces). Deluje kao "pečat/potpis", ne kao ukras — koristi se retko, namerno, kao tačka na kraju važne misli (npr. posle citata "Nije garancija, ali može sačuvati važnu šansu"). |
| B | **`.frame--halo`** (zaobljeni zlatni ram) | Svi portreti (hero, O meni, mediji-galerija) i istaknuti citat-blokovi | Zaobljeni uglovi (`--radius-lg`, 24px), tanka zlatna linija **uvučena** 8–10px od ivice slike/kartice (dupla kontura — spoljašnja slika, unutrašnja tanka zlatna linija sa razmakom), tačno kako izgleda okvir na school-board karticama. Nikad oštri ugao, nikad linija uz samu ivicu (razmak je bitan deo prepoznatljivosti). |
| C | **`.badge`** (oval pill-bedž) | Iznad H1 na svakoj `/oblasti-rada/*` podstranici, na FAQ kategorijama, na blog karticama | Oval kontura (`--radius-pill`), tanka linija, mala linijska ikona + uppercase tekst (Karla 500, letter-spacing .12em), npr. "IVF / ICSI", "SOCIAL FREEZING", "PCOS", "MUŠKI FAKTOR", "REDOVNI PREGLEDI" — direktan citat postojećeg "SOCIAL FREEZING" bedža sa IG-a. |
| D | **`.steps`** (koraci procesa) | Tok dijagnostike/konsultacije na oblasti-rada stranicama | Vertikalna hairline linija sa **okruglim** (ne dijagonalnim) brojevima u tankom zlatnom krugu — isti "seal" jezik, ne kosa linija kao dekorativni motiv (za razliku od drugih projekata, ovaj brend nema dijagonalu u izvornom materijalu — sve linije su **horizontalne/vertikalne/ovalne**, nikad kose; brand.md 5 eksplicitno: "dosledno zaobljeni uglovi"). |
| E | **`.edu-carousel`** kartice | "Iz edukacije" sekcije | Kartice alterniraju krem (checklist/infografika stil) i navy (school-board/premium citat stil) tačno kao na IG-u — ovo NIJE ujednačavanje u jedan stil, već svesno čuvanje IG raznolikosti unutar jednog sistema okvira (`.frame--halo` oko svake). |

**Pravilo:** nikad kosa linija/dijagonala kao dekor (nema osnove u brendu — sve reference su ovalne/zaobljene/vertikalne). Max jedan `.seal` u vidnom polju. `.frame--halo` je jedini dozvoljeni okvir za fotografije — bez senki tipa "card shadow" preko fotografija, samo tanka zlatna kontura.

### 0.2 Kritično zapažanje sa slika — DVE slike sadrže reč "specijalista"/"specialist" UGRAVIRANU u sliku

Pregledom `hero.webp` i `konferencija-02.webp` potvrđeno je da **obe slike krše pravilo 0.1 iz seo.md** jer imaju tekst zapečen u samu sliku:

- **`hero.webp`** — portret sa utisnutim tekstom: "Specijalista ginekologije i akušerstva / Master reproduktivni embriolog / Dr Filip Katanić / [citat]". Donja trećina slike (od ~60% visine naniže) sadrži zabranjenu reč.
- **`konferencija-02.webp`** — fotografija sa predavanja u Divčibarama; na projektovanom slajdu u pozadini, kada se zumira, čita se: "Filip Katanić, MD, MSc / **Ob/Gyn Specialist** / MSc in Reproductive Embryology / SGH "Ferona", Serbia."

**Odluka (obavezna za Developera):** obe slike se koriste **isključivo kao kadrirani izrezi (crop), ne u punoj visini/širini**:
- `hero.webp` → koristi se samo gornjih ~55% slike (glava/ramena/mantil), kroz `.frame--halo` sa `object-position: 50% 15%` i fiksnom visinom kontejnera — tekst iz donje trećine je fizički van vidljivog kadra na svim breakpointima (ne samo `overflow:hidden` teoretski, nego stvarno testirati na 320px, 768px, 1440px da tekst nikad ne "upadne" nazad u kadar kad se menja aspect-ratio).
- `konferencija-02.webp` → koristi se kadriran na centralni deo (dr Katanić na podijumu), sa dovoljnim opsegom da se slajd u pozadini vidi kao **kontekst** (plava/bela pozadina, siluета table), ali bez čitljivog teksta — kadar mora biti dovoljno uzak/zumiran da "Ob/Gyn Specialist" nije čitljiv ni pri kliku/lightbox uvećanju. Alt tekst NE prepisuje sadržaj slajda (ne "predavanje o..." sa punim naslovom ako se time referencira titula) — koristiti seo.md formulaciju: "dr Filip Katanić kao predavač na stručnom skupu u Divčibarama".
- **U `build.py --lint`:** dodati proveru da se ova dva fajla ne koriste van definisanih `.frame--halo` krop-preseta (spečeno u CSS-u, ne inline stil), kako slučajna izmena layout-a ne bi vratila zabranjeni tekst u kadar.
- **Otvoreno pitanje ka klijentu** (dodato u odeljak 9): zatražiti čist portret bez utisnutog teksta i, ako je moguće, drugi kadar sa konferencije bez čitljivog slajda — ovo je rešenje "za sada", ne trajno idealno stanje.

### 0.3 Nedostatak fotografija prostora — rešenje

Nema nijedne čiste slike ordinacije/OR/laboratorije SB Ferona (NOTES.md). Rešeno **tipografski + ikonografski**, ne stock fotografijom:
- **`.venue-card`**: navy panel sa "SB FERONA" (Karla uppercase), adresom (Fraunces veliki), sitnim linijskim SVG (2–3 linije kao skica ulice + zlatna tačka), link "Otvori u Google mapama". Isti obrazac kao NAP prikaz.
- **`.illo` slotovi** za oblasti rada bez slika (muški faktor, redovni pregledi) — vidi 3.7/3.8.
- Kad klijent/Ferona dostave prave fotografije prostora (i odobrenje da se koriste), zamena je direktna u istom `.frame--halo` slotu.

---

## 1. Sitemap i fajl-struktura

```
site/
  index.html                                          /
  o-meni/index.html                                   /o-meni/
  oblasti-rada/index.html                              /oblasti-rada/
  oblasti-rada/vantelesna-oplodnja-ivf/index.html       /oblasti-rada/vantelesna-oplodnja-ivf/
  oblasti-rada/zamrzavanje-jajnih-celija/index.html     /oblasti-rada/zamrzavanje-jajnih-celija/
  oblasti-rada/pcos-i-neplodnost/index.html             /oblasti-rada/pcos-i-neplodnost/
  oblasti-rada/muski-faktor-neplodnosti/index.html      /oblasti-rada/muski-faktor-neplodnosti/
  oblasti-rada/redovni-ginekoloski-pregledi/index.html  /oblasti-rada/redovni-ginekoloski-pregledi/
  pitanja-i-odgovori/index.html                         /pitanja-i-odgovori/
  blog/index.html                                       /blog/
  blog/koliko-jajnih-celija-je-potrebno-za-embrion/index.html   /blog/koliko-jajnih-celija-je-potrebno-za-embrion/
  blog/sta-se-zaista-desava-tokom-ivf-postupka/index.html        /blog/sta-se-zaista-desava-tokom-ivf-postupka/
  blog/prva-konsultacija-sta-poneti/index.html          /blog/prva-konsultacija-sta-poneti/
  mediji-i-predavanja/index.html                        /mediji-i-predavanja/
  kontakt/index.html                                    /kontakt/
  politika-privatnosti/index.html                       /politika-privatnosti/  (noindex nije potreban — sadržaj je bezbedan)
  404.html  sitemap.xml  robots.txt
  favicon.svg  favicon-32.png  favicon-180.png  site.webmanifest  (bazirano na FK pečatu, 0.1.A)
  assets/css/ (tokens.css base.css components.css pages.css)  js/ (main.js, lightbox.js, carousel.js)  img/ (postoji, vidi manifest)
src/
  partials/  header.html  footer.html  cta-band.html  sticky-bar.html  seal.svg  venue.html  credential.html
  pages/     *.html (sa {{include}} i {{key}})
  data/      copy.md → prevedeno u data po ključevima; NEMA prices.json (nema cenovnika, seo.md 0.5)
build.py
```

**Samo 3 blog članka u prvoj fazi** (ne 5 kako je seo.md predložio kao primer slugova) — odluka doneta na osnovu stvarno dostupnog materijala: dve pune IG karusel-serije (`ivf-proces-karusel`, `embrioni-karusel`, po 5 slika) daju dovoljno sadržaja za 2 vizuelno bogata članka; treći (`prva-konsultacija-sta-poneti`) ima jak tekstualni izvor u `research.md` (checklist) ali nema sliku — rešen kao tipografski checklist. Ostali slugovi iz seo.md primera (`pcos-najcesce-zablude`, `da-li-stres-utice-na-plodnost`, `kada-razmisljati-o-zamrzavanju-jajnih-celija`, `spermogram-osnovni-pojmovi`) **nisu napravljeni u ovoj fazi** — postoji samo po jedna pojedinačna infografika po temi (ne serija), nedovoljno za pun članak bez izmišljanja sadržaja. Navedeno kao otvoreno pitanje (odeljak 9).

**Build flagovi** (`build.py`, na vrhu):
```python
TITULA_SPECIJALISTA = False   # NIKAD True dok klijent pismeno ne potvrdi (seo.md 0.1) — lint pada bez obzira na flag
STATUS_ZAPOSLENJA_POTVRDJEN = False   # dok False: samo "clan tima SB Ferona", nikad "zaposlen/vlasnik"
RADNO_VREME = False           # sekcija hidden dok se ne potvrdi
CENOVNIK = False              # nema cenovnika nigde; flag postoji samo da spreci slucajno dodavanje
ALUMNI_NOVISAD = False        # "Medicinski fakultet Novi Sad" ostaje van schema alumniOf i van vidljivog teksta kao neupitna cinjenica dok se ne potvrdi; sme se pomenuti opisno kao "prema javno dostupnim izvorima" u /o-meni/ tek uz internu napomenu, NE u schema
GALERIJA_PROSTORA = False     # sekcija za prave fotografije SB Ferona, sakrivena dok ne stignu
TESTIMONIALS = False          # cela komponenta ne postoji u kodu dok ne stignu pisane saglasnosti; kad se doda, OBAVEZNA napomena "Objavljeno uz saglasnost pacijentkinje" uz svaki unos
BLOG_EXPANDED = False         # dodatni clanci (PCOS zablude, social freezing, muski faktor) cekaju vise IG materijala
GBP_SEPARATE = False          # zaseban Google Business Profil za doktora — van obima prve faze (seo.md 7)
```

**Build lint (`build.py --lint`)** — pada ako izlaz (HTML tekst, alt atributi, meta, JSON-LD) sadrži (case-insensitive, uključujući ćirilične i padeže):
`"specijalista", "specijalistkinj", "specialist"` (osim unutar CSS/HTML komentara koji eksplicitno objašnjavaju krop pravilo iz 0.2), `"% uspešnosti"/"% uspesnosti"`, `"garantov"`, `"najbolj"` (osim citiranog komentara korisnika — koji se uopšte ne koristi, vidi 0.4), `"aggregateRating"`, `"5:00–23:45"`, `"4.0/5"/"3.9/5"/"203 verified"/"217 reviews"`, `"cena od"` praćeno brojem/€ (van internog komentara), `"zaposlen u Feroni"/"vlasnik ordinacije"/"privatna ordinacija dr Katanić"`, imena konkurencije (`"Trninić", "Gemma Clinic", "Kalember"`) u poredbenom kontekstu, `"plasticni hirurg"` (nerelevantno ovde ali zadržano kao safety-net iz zajedničkog builda).

### 1.1 Šta se NE pravi (eksplicitne odluke)

- **Testimonijali/iskustva pacijentkinja** — nijedna komponenta, nijedan red u HTML-u, dok ne stignu tekstovi sa pisanom saglasnošću (klijentov IG obrazac "Objavljeno uz saglasnost pacijentkinje" je standard koji sajt mora zadržati kad se doda — seo.md 0.5, brand.md 6).
- **Cenovnik / bilo kakav raspon cena** — nigde, ni okvirno (seo.md 0.4, 0.5).
- **Radno vreme** — sekcija na `/kontakt/` postoji strukturno ali je `hidden` (flag `RADNO_VREME`).
- **Google ocena/broj recenzija** — nigde (izvori se ne slažu, seo.md 0.5).
- **Family/baby fotografije** (`671176208...`, `629474218...`) — isključene po NOTES.md, ne ulaze u manifest sajta.
- **Zasebna stranica za SB Ferona kao "kliniku"** — sajt se nigde ne predstavlja kao klinika (seo.md 0.4); sve institucionalne informacije idu kroz `.venue`/`.venue-card` sa jasnom napomenom.

---

## 2. Zajedničke komponente

Raspored svake stranice:
```
[skip link] → HEADER (sticky) → <main> → CTA TRAKA (navy) → FOOTER (navy)
                                            (+ MOBILNI STICKY BAR, fixed bottom, < 900px)
```
Izuzetak: `/kontakt/` nema CTA traku (cela stranica je poziv na akciju); `/politika-privatnosti/` nema sticky bar.

### 2.1 Header (sticky)

- Visina 76px desktop / 64px mobilni, **uvek solidna krem pozadina** (`--color-bg`) — čak i na početnoj, gde hero počinje ispod headera (ne transparentan preko hero-a, jer je hero tamna navy sekcija i mora se jasno odvojiti da header ostane čitljiv). 1px `--color-border` ispod tek posle skrola (`.is-scrolled`).
- **Levo:** `.seal` (FK pečat, 40px, navy linija na kremu) + "dr Filip Katanić" (Fraunces 500, 21px) + mikro-linija ispod "GINEKOLOGIJA · IVF" (Karla 500, .625rem, letter-spacing .2em, `--color-text-muted`). Cela grupa je link na `/`.
- **Navigacija (≥ 1024px):** O meni · Oblasti rada (dropdown) · Pitanja i odgovori · Blog · Mediji i predavanja · Kontakt. Karla 500 uppercase .75rem, letter-spacing .12em; aktivno stanje: tanka navy linija ispod (offset 8px); hover: `--color-primary-light`.
- **Dropdown "Oblasti rada":** panel `--color-surface`, `.frame--halo`-stil tanka zlatna linija oko panela, 5 stavki sa `.badge` ikonicom i jednom rečenicom opisa; `aria-expanded`, Esc zatvara.
- **Desno:** primarno dugme **"Zakažite u SB Feroni"** (navy pozadina, krem tekst, `.btn` pill) — link na `/kontakt/#zakazivanje` (ne direktan `tel:` u headeru, da klik uvek prođe kroz jasnu napomenu o instituciji). < 1024: telefon-ikona (44px, `tel:+381213000220`) + burger.
- **Mobilni meni (< 1024):** full-screen **navy** (eho "premium kartice" template-a sa IG-a — svesno tamniji od ostatka sajta), fade 240ms; stavke Fraunces 32px krem, razdvojene 1px `--color-border` (svetlija varijanta za tamnu pozadinu); "Oblasti rada" akordeon sa 5 podstavki sa `.badge`; na dnu: `.seal` u zlatnoj varijanti, zlatno dugme "Zakažite u SB Feroni" (`tel:+381213000220`), tekstualni link "Poruka dr Kataniću na Instagramu" (`https://instagram.com/drfilipkatanic`), NAP SB Ferone u jednom redu. Fokus-trap, Esc, zaključan scroll.
- Skip link "Preskoči na sadržaj".

### 2.2 Mobilni sticky bar (< 900px)

- Fixed bottom, 64px + `env(safe-area-inset-bottom)`, navy pozadina, gornja ivica 1px `--color-border` (tamna varijanta).
- Dve akcije: **[ Zakažite u SB Feroni ]** (zlatno dugme, tekst navy, `tel:+381213000220`) i **[ Poruka na Instagramu ]** (outline krem, link IG DM — klijentov stvarni primarni kanal po `research.md`). Bez WhatsApp/Viber (nisu potvrđeni).
- Pojavljuje se posle 240px skrola, sakriva se dok je CTA traka u viewportu; `body padding-bottom` = visina bara. Na `/kontakt/` uvek prikazan.

### 2.3 CTA traka (pre footera)

Navy pozadina, padding 120/72px, centrirano; `.seal` diskretno iza teksta (dekor, `opacity: .06`, `aria-hidden`).
```
                    ( FK pečat, vodeni žig )
        Sledeći korak je razgovor              (H2 Fraunces, krem)
   Za zakazivanje pregleda obratite se kontakt centru SB Ferona —
   ustanove u kojoj dr Filip Katanić radi.           (Karla, text-on-dark-muted)
   [ Zakažite u SB Feroni ]  (zlatno)    [ Poruka na Instagramu ] (outline krem)
         +381 21 3000 220  ·  Šarplaninska 19, Novi Sad
      "Ne možemo kontrolisati baš sve, ali možemo napraviti najbolji plan."  (Fraunces italic, gold)
```
Tekst: `[global.cta]` (isti svuda osim na `/oblasti-rada/*` gde varijanta naslova koristi `[oblast.<slug>.cta]`). Napomena o instituciji (seo.md 0.3) je OBAVEZAN deo ovog bloka na svakoj stranici gde se traka pojavljuje — ne sme se izostaviti radi "čistijeg" dizajna.

### 2.4 Footer (navy)

```
[ diskretan FK pecat @ 6% + "dr Filip Katanic" wordmark, dekor ]
| Brend                        | Oblasti rada         | Sajt                | Kontakt / Ustanova                         |
| .seal (svetla varijanta)     | IVF / ICSI            | O meni              | SB "Ferona"                                |
| dr Filip Katanic             | Zamrzavanje jajnih    | Pitanja i odgovori  | Sarplaninska 19, 21000 Novi Sad            |
| Lekar · IVF i ginekologija · | celija                | Blog                | +381 21 3000 220 · office@ferona.rs        |
| clan tima SB Ferona          | PCOS i neplodnost     | Mediji i predavanja | Kontakt centar ustanove — za zakazivanje   |
| "Ne mozemo kontrolisati bas  | Muski faktor          | Kontakt             | pregleda kod dr Filipa Katanica.           |
|  sve, ali mozemo napraviti   | Redovni pregledi      |                      | Instagram @drfilipkatanic                  |
|  najbolji plan."             |                       |                      |                                             |
Donja traka: (c) 2026 dr Filip Katanic · Politika privatnosti · Nazad na vrh
Napomena (Karla 13px): "Sadrzaj sajta je informativan i edukativan i ne zamenjuje pregled ili konsultaciju lekara.
Postupci se sprovode u okviru Specijalne bolnice Ferona. Svaki slucaj se procenjuje individualno."  ([global.disclaimer])
```
- NAP identičan svuda (seo.md 7): `SB "Ferona", Šarplaninska 19, 21000 Novi Sad · +381 21 3000 220 · office@ferona.rs`.
- Grid: 4 kolone ≥ 1024, 2 kolone ≥ 600, 1 ispod ("Kontakt/Ustanova" prva na mobilnom, jer je najčešće traženo).
- Footer NIKAD ne piše "zaposlen u", "vlasnik", "moja ordinacija" — uvek "član tima SB Ferona".

### 2.5 Dugmad i tipografija (skraćeno; puni detalji u brand.md)

- `.btn` primarno: navy pozadina/krem tekst (na kremu) ili zlato/navy tekst (na navy pozadini), pill radius, Karla 500 uppercase .8rem letter-spacing .1em, 16×32px padding; hover blago potamnjenje; fokus outline vidljiv. Max jedno primarno po ekranu.
- `.btn--ghost`: outline navy (na kremu) / outline krem ili zlato (na navy), hover popuna.
- `.link`: `--color-secondary` (šalvija, potamnjena varijanta za tekst), donja linija, bez strelice-dekoracije (brend nema taj motiv) — koristi mali linijski chevron ako treba indikator.
- H1 Fraunces 500 `clamp(2.25rem, 5.5vw, 4.5rem)`; H2 `clamp(1.75rem, 3.5vw, 2.75rem)`; sentence case (ne uppercase van `.badge`/`.eyebrow`).

### 2.6 Komponente

| Komponenta | Specifikacija |
|---|---|
| **`.seal`** | Potpis A (0.1). FK pečat, koristi se retko i namerno. |
| **`.frame--halo`** | Potpis B (0.1). Zaobljeni ram sa uvučenom zlatnom linijom oko fotografija/citata. Varijante: `--portrait` (4:5, hero/O meni), `--wide` (3:2, mediji galerija), `--square` (1:1, edu-carousel kartice). |
| **`.badge`** | Potpis C (0.1). Oval pill sa ikonom + uppercase tekst; koristi se za kategorije oblasti rada i FAQ teme. |
| **`.credential`** | Blok sa afilijacijom: "Lekar · Master reproduktivne embriologije · Član tima SB Ferona", Fraunces italic 19px, ispod link "O meni →". Ide u home hero, `/o-meni/` hero, footer, i "Ko se ovim bavi" na svakoj oblasti rada. **Nikad ne sadrži reč "specijalista"** (0.1 seo.md). |
| **`.venue`** | Tanka traka "Postupci se sprovode u okviru SB Ferona": adresa + link "Kontakt i mapa". Ide ispod hero-a svake `/oblasti-rada/*` stranice i u kontakt/footer. |
| **`.venue-card`** | Navy panel — tipografsko rešenje za nedostatak fotografija prostora (0.3). |
| **`.steps`** | Vertikalna hairline sa okruglim brojevima u tankom zlatnom krugu (ne dijagonala — vidi 0.1.D); ≥ 900px dve kolone. |
| **`.faq`** (akordeon) | `<h3><button aria-expanded>`, red sa `--color-border`, plus/minus ikonica, panel `grid-template-rows 0fr→1fr`; isti tekst duplira se u `FAQPage` JSON-LD. Odgovori uvek uslovni ton ("može", "individualno", "nije garancija"). |
| **`.edu-carousel`** | Horizontalni `scroll-snap-type: x mandatory`; kartice u `.frame--halo--square`, širina 78vw (mobilni) / 280px (≥768) / 320px (≥1200); alterniraju krem i navy kartice (0.1.E); strelice prev/next (skrivene na touch); klik → lightbox. Bez autoplay-a. |
| **`.pair`** | Krop (mediji-galerija ili edu-teaser, `.frame--halo--wide`) + mala `.badge`-oznaka "Iz edukacije"/"Iz konferencija" preklopljena u donji ugao, klik → lightbox ili link na pun blog članak. |
| **`.checklist`** | Za `/blog/prva-konsultacija-sta-poneti/` (nema slike): lista stavki kao oval pill-red (isti `.badge` jezik) sa kratkim opisom svake stavke — čist tipografski ekvivalent IG checklist-grafike. |
| **Ilustracija-slot `.illo`** | SVG linijske ilustracije za oblasti rada bez fotografija (muški faktor, redovni pregledi — vidi 3.7/3.8) i za `.venue-card` skicu. Jednostavna linija, bez lica/tela, `alt=""` uz tekst pored. |
| **Lightbox** | Fullscreen `rgba(16,40,74,.94)` (navy, ne crna), slika `contain`, prev/next, brojač, caption, Esc/strelice/swipe, fokus-trap. Za `edu-carousel` serije (ivf-proces, embrioni) čuva redosled 1/5–5/5 i prikazuje ga u brojaču. |
| **Reveal** | fade + translateY 10px, 500ms, IntersectionObserver, jednom; `prefers-reduced-motion` i no-JS isključuju (brand.md 5: "suptilne, spore animacije, bez bouncy efekata"). |

### 2.7 Responzivnost (globalno)

Mobile-first. Breakpointi **480 / 768 / 1024 / 1280**. Container 1200px (tekst 65ch), gutter 16 (<768) / 24 (≥768) / 40 (≥1280). Sekcije 56–64px vert. razmak mobilni, 96–120px desktop. Split hero: < 900 portret gore (`.frame--halo--portrait`, `max-height: 62vh`, kadriran po 0.2), tekst ispod na navy; ≥ 900 dve kolone. Dropdown "Oblasti rada" na mobilnom postaje akordeon u meniju (nema hover). Dodirne površine ≥ 44px. Slike: hero `fetchpriority="high"`, bez lazy-load iznad prve linije; sve ostalo `loading="lazy"`; `width`/`height` atributi obavezni (CLS).

### 2.8 Kako se rešavaju slike koje ne postoje ili su problematične

| Šta fali/je problematično | Rešenje |
|---|---|
| Ordinacija/lab/OR SB Ferona | `.venue-card` tipografski (0.3); zamena kad stignu prave fotografije (odeljak 9). |
| Slika za "Muški faktor neplodnosti" | `.illo--spermogram`: minimalistička linijska ilustracija epruvete/mikroskopa (isti linijski stil kao IG "epruveta" ilustracija na `edukacija-social-freezing-01`), bez tela/lica. |
| Slika za "Redovne ginekološke preglede" | `.illo--pregled`: linijska ilustracija kalendara sa jednom zlatnom kvačicom (eho `.badge`/checkmark jezika sa IG-a). |
| `hero.webp` sadrži utisnut tekst "Specijalista..." | Krop na gornjih ~55% (0.2) — obavezno, ne opciono. |
| `konferencija-02.webp` sadrži čitljivo "Ob/Gyn Specialist" na slajdu | Uzak krop na govornika, slajd kao zamućen/sitan kontekst, ne čitljiv tekst (0.2). |
| Testimonijali/iskustva | Ne postoji komponenta dok ne stignu pisane saglasnosti (flag `TESTIMONIALS`). |
| Medijska fotografija (Mondo.rs, Selfnest, TV) | Nema dedikovane slike (NOTES.md) — koristi se `portret-01.webp` kao generička reprezentativna slika uz tekstualne kartice sa linkom ka izvoru za svaki nastup. |

### 2.9 Zabranjeno/pravila za slike (obavezno Developeru i Copywriteru)

1. **`baby-foto` i `porodicni-kolaz`** (isključeni u NOTES.md) — ne ulaze u sajt ni u jednom obliku dok ne stigne pisana saglasnost za svaku prikazanu osobu.
2. **`hero.webp` i `konferencija-02.webp`** — samo kroz definisane krop-presete iz 0.2, nikad u punoj slici, nikad kao pozadina cele sekcije bez kropa.
3. **`brend-vizual-01.webp` i `brend-vizual-02.webp`** — isti bazni portret (manifest napomena); koristiti **samo jednu** na sajtu odjednom, nikad obe na istoj stranici. Odluka: `brend-vizual-01` ("Jedinstvenost — vaša priča je početna tačka") ide na `/o-meni/` (sekcija "Pristup radu"); `brend-vizual-02` ostaje neiskorišćena u prvoj fazi (rezerva za blog/social).
4. **`edukacija-ivf-proces-*` (5 kom.) i `edukacija-embrioni-*` (5 kom.)** — svaka serija se prikazuje **kao celina i u tačnom redosledu** (1/5→5/5) unutar odgovarajućeg blog članka; ne mešati kartice iz dve serije u istom carouselu; ne prikazivati pojedinačnu karticu van konteksta serije osim jedne "teaser" kartice sa linkom na pun članak (na `/oblasti-rada/vantelesna-oplodnja-ivf/` i na `/blog/`).
5. **`konferencija-01.webp` (ESHRE grupna fotografija)** — treća lica na slici se ne imenuju (NOTES.md — nisu identifikovana/potvrđena), alt tekst ostaje generički: "grupna fotografija sa ESHRE kongresa".
6. Alt tekst iz `manifest.md`, osim gde seo.md traži drugačiju formulaciju (seo.md pobeđuje) — i osim gde ovaj dokument eksplicitno menja alt zbog 0.2 (npr. `hero.webp` alt ne sme pominjati "specijalista" iako je tako napisano u trenutnom manifestu — Developer koristi: "dr Filip Katanić, doktor medicine, portret").
7. Bez teksta preko fotografija sem unutar postojećih IG grafika (koje se prikazuju kao celina, ne sečene); nova, sajt-originalna tipografija ide pored slike, ne preko nje.

---

## 3. Stranice: sekcije, cilj, izvor teksta, slike, layout

Oznaka izvora: `copy.md → [ključ]`. Jedan H1 po stranici; H1/title/meta iz seo.md se prepisuju doslovno gde su definisani.

### 3.1 Početna `/`

| # | Sekcija | Cilj | Tekst | Slike / vizuel | Pozadina |
|---|---|---|---|---|---|
| 1 | **Hero split** | Odmah: ko je, čime se bavi, gde zakazati — bez agresivnog tona | `[home.hero]`: H1 "dr Filip Katanić — ginekologija i put ka roditeljstvu" (seo.md), podnaslov empatičan ("Edukacija i podrška na putu ka roditeljstvu — bez obećanja, sa razumevanjem."), `.credential`, CTA primarni "Zakažite u SB Feroni", sekundarni tekstualni "Pogledajte oblasti rada ↓"; ispod `.venue` u jednom redu | `hero.webp` (desno, `.frame--halo--portrait`, **kropovano po 0.2** — samo gornjih ~55%) | navy |
| 2 | **Pristup bez obećanja** (zamena za "poverenje/brojke" — nema brojki po pravilu) | Emotivni i pozicioni cilj | `[home.philosophy]`: veliki Fraunces italic citat ("Ne možemo kontrolisati baš sve, ali možemo napraviti najbolji plan.") + 2 kratka pasusa (edukacija umesto obećanja; individualan pristup) | `.seal` kao vizuelna tačka na kraju citata | krem |
| 3 | **Oblasti rada** | Deep linkovi ka 5 podstranica | `[home.areas]` uvod + po oblasti `[oblast.<slug>.short]` (1 rečenica) | 5 `.badge` kartica u gridu (2×3 desktop, 1 kolona mobilni), svaka sa linijskom ikonicom teme | bela/krem |
| 4 | **O meni (teaser)** | E-E-A-T, najava pune stranice | `[home.about]`: kratak pasus, `.credential`, link "Saznajte više o meni →" | `brend-vizual-01.webp` (`.frame--halo--portrait`, manji format) | krem |
| 5 | **Mediji i konferencije** | Kredibilitet bez brojki | `[home.media]` uvod (Thrombosis Days, ESHRE, GIGANODE, Mondo.rs, Selfnest — kratko pobrojano) + link | Mini-grid 4 slike: `konferencija-01`, `konferencija-02` (kropovano), `konferencija-03`, `konferencija-04`, u `.frame--halo--wide`, malog formata | bela |
| 6 | **Iz edukacije** | Pokazati edukativni pristup, uvod u blog | `[home.edu]` uvod + naslovi kartica | `.edu-carousel`: po 1 teaser-kartica iz svake serije (`edukacija-embrioni-01`, `edukacija-ivf-proces-01`) + `edukacija-pcos-01` + `edukacija-simptomi-01`, svaka linkuje na odgovarajući blog/oblast/FAQ | krem |
| 7 | **Najčešća pitanja (teaser)** | Konverzija + priprema za FAQPage na pod-stranici | `[home.faq]`: 4 pitanja iz seo.md 1.4 (skraćeni odgovori) + link "Sva pitanja →" | — | bela |
| 8 | CTA traka + footer | | `[global.cta]` | `.seal` dekor | navy |

Wireframe (desktop, 1440px):
```
HEADER: [FK] dr Filip Katanic          O meni  Oblasti rada v  Pitanja  Blog  Mediji  Kontakt   [Zakažite u SB Feroni]
┌────────────────────────── NAVY HERO (min-height min(88vh,760px)) ──────────────────────────┐
│  Ginekologija i IVF · Novi Sad (eyebrow)              ┌─────────────────────────┐          │
│                                                         │  hero.webp (kropovan,   │          │
│  dr Filip                                               │  frame--halo--portrait) │          │
│  Katanić                    (H1 Fraunces 72px)          │                         │          │
│  Edukacija i podrška na putu ka roditeljstvu...          └─────────────────────────┘          │
│  Lekar · Master reproduktivne embriologije · Clan tima SB Ferona  (.credential)               │
│  [ Zakažite u SB Feroni ]   Pogledajte oblasti rada ↓                                          │
│  ─────────── SB Ferona · Sarplaninska 19, Novi Sad ───────────                                │
└──────────────────────────────────────────────────────────────────────────────────────────────┘
PRISTUP (krem):        "Ne mozemo kontrolisati bas sve, ali mozemo napraviti najbolji plan."  (centrirano, Fraunces italic 48px)
                                     2 pasusa (uska kolona)  ·  (FK) pecat
OBLASTI RADA (bela):    [IVF/ICSI]     [Zamrzavanje]    [PCOS]
                        [Muski faktor] [Redovni pregledi]
O MENI (krem):     brend-vizual-01 (frame--halo, 4 kol)  |  H2 + pasus + credential + link  (7 kol)
MEDIJI (bela):     H2 + lead  ·  [konf-01][konf-02][konf-03][konf-04]  (mini grid, frame--halo--wide)  ·  link
EDUKACIJA (krem):  H2 + lead   ← kartica | kartica | kartica | kartica →  (scroll-snap, alternira krem/navy)
FAQ (bela):        H2 (4 kol)  |  4 pitanja skraceno (8 kol)  ·  link "Sva pitanja →"
CTA TRAKA -> FOOTER
```

- **Responzivnost:** < 900px hero portret gore (4:5, max-height 62vh), tekst ispod na navy; oblasti rada 1 kolona; O meni portret manji/levo ili iznad teksta; mediji grid 2×2; edu-carousel 78vw kartice.
- **Konverzija:** primarni CTA u hero-u i CTA traci; sticky bar mobilni; nijedan agresivan/urgency element (seo.md 0.5, 0.6).
- **Jedinstveno:** navy hero sa kropovanim portretom i `.frame--halo`, "Pristup bez obećanja" sekcija bez ijedne brojke, `.seal` kao potpis na kraju citata.

### 3.2 O meni `/o-meni/`

| # | Sekcija | Cilj | Tekst | Slike |
|---|---|---|---|---|
| 1 | Hero (navy, split) | H1 "dr Filip Katanić" (seo.md), `.credential`, CTA | `[omeni.hero]` | `portret-01.webp` (čist, `.frame--halo--portrait`) — koristi se ovde umesto `hero.webp` jer je jedina potpuno čista slika bez utisnutog teksta (NOTES.md tačka 3) |
| 2 | Ko sam ja | Topao, ličan uvod (bez "specijalista") | `[omeni.who]` | — |
| 3 | Obrazovanje i afilijacije | E-E-A-T sa SAMO potvrđenim podacima: master reproduktivne embriologije (potvrđeno), član tima SB Ferona (potvrđeno), projekat "Moj ginekolog" DZ Novi Sad (potvrđeno iz IG bio). Medicinski fakultet Novi Sad ide kao "prema javno dostupnim izvorima, u postupku potvrde" dok `ALUMNI_NOVISAD=False` | `[omeni.education]` | `.steps` vertikalna lista (bez datuma koji nisu potvrđeni) |
| 4 | Pristup radu | Empatičan, edukativan ton — parafraza IG citata, ne copy-paste | `[omeni.approach]`: "Nije garancija trudnoće, ali može sačuvati važnu šansu za budućnost." / "Infertilitet nije samo stres — i niko ne treba da nosi osećaj krivice." | `brend-vizual-01.webp` (`.frame--halo--portrait`) — vidi 2.9.3 |
| 5 | Konferencije i predavanja (teaser) | Kredibilitet bez brojki | `[omeni.talks]` kratak izvod (Thrombosis Days, ESHRE, GIGANODE, Divčibare, Bio Save, SPRING Fertility) + link "Sve konferencije i mediji →" | mini `.pair`: `konferencija-01` + `konferencija-03` |
| 6 | CTA traka | | `[global.cta]` | `.seal` dekor |

`Person` JSON-LD (seo.md 6.2) ide na `/` i `/o-meni/` — `jobTitle: "Lekar"`, bez `alumniOf` dok `ALUMNI_NOVISAD=False`, bez `award`.

```
NAVY HERO: H1 + credential + CTA (6 kol)  |  portret-01 (frame--halo--portrait, 6 kol)
KO SAM JA (krem):  uska kolona tekst (7 kol, centrirano ili levo poravnato)
OBRAZOVANJE (bela):  .steps vertikalna lista, naslov levo / opis desno
PRISTUP (navy):  brend-vizual-01 (4 kol) | veliki citat + 2 pasusa (7 kol)
KONFERENCIJE (krem):  H2 + lead + mini pair grid + link
CTA -> FOOTER
```

### 3.3 Hub „Oblasti rada" `/oblasti-rada/`

| # | Sekcija | Tekst | Slike |
|---|---|---|---|
| 1 | Hero kompaktan (krem), H1 "Oblasti rada" | `[oblasti.hero]`: kratak uvod + napomena "Postupci se sprovode u okviru SB Ferona" (`.venue`) | — |
| 2 | Grid 5 kartica (`.badge` + naslov + 1 rečenica + link) | `[oblasti.<slug>.short]` × 5 | ikone linijske po temi |
| 3 | `.venue-card` | Institucionalna napomena | tipografski panel |
| 4 | CTA traka | `[global.cta]` | — |

Layout: grid 2×3 desktop (poslednja kartica puna širina ili centrirana), 1 kolona mobilni; svaka kartica ima suptilan hover (blaga senka + `.frame--halo` linija se "pojavi").

### 3.4 `/oblasti-rada/vantelesna-oplodnja-ivf/`

| # | Sekcija | Tekst | Slike |
|---|---|---|---|
| 1 | Hero + `.badge` "IVF / ICSI" + `.venue`, H1 (seo.md) | `[oblast.ivf.hero]` | `edukacija-ivf-proces-02.webp` kao teaser (`.pair`, link ka blog članku "Šta se zaista dešava tokom IVF postupka") |
| 2 | Šta je IVF/ICSI | `[oblast.ivf.what]` | — |
| 3 | Dijagnostika steriliteta — prvi koraci | `[oblast.ivf.dijagnostika]` | — |
| 4 | Priprema za prvu konsultaciju | `[oblast.ivf.priprema]` + link na `/blog/prva-konsultacija-sta-poneti/` | `.checklist` mini-verzija (3 stavke) |
| 5 | Emotivna strana puta | `[oblast.ivf.emocije]`: "nije garancija", "nije samo stres" | — |
| 6 | Mini FAQ (2–3 pitanja: "Da li IVF garantuje trudnoću?", "Koja je razlika između IVF i ICSI?") | `[oblast.ivf.faq]` | `.faq` + `FAQPage` (mini) |
| 7 | Ko se ovim bavi (`.credential`) + `.venue` puna | `[global.credential]` | — |
| 8 | Povezano (Muški faktor, Blog članci o IVF-u) + CTA | `[oblast.ivf.cta]` | — |

### 3.5 `/oblasti-rada/zamrzavanje-jajnih-celija/`

| # | Sekcija | Tekst | Slike |
|---|---|---|---|
| 1 | Hero + `.badge` "Social freezing" + `.venue`, H1 | `[oblast.freezing.hero]` | `edukacija-social-freezing-01.webp` (`.frame--halo--wide`, idealna hero-ilustracija — bez lica, bez teksta-problema) |
| 2 | Šta je zamrzavanje jajnih ćelija | `[oblast.freezing.what]` | — |
| 3 | Kada razmišljati o ovoj opciji (starost/okolnosti, informativno) | `[oblast.freezing.kada]` | — |
| 4 | Šta postupak obuhvata | `[oblast.freezing.proces]` | `.steps` |
| 5 | "Nije garancija trudnoće, ali može sačuvati važnu šansu" | `[oblast.freezing.poruka]` (citat blok, navy) | `.seal` |
| 6 | Mini FAQ + `.credential`/`.venue` + povezano + CTA | `[oblast.freezing.faq]`, `[oblast.freezing.cta]` | — |

### 3.6 `/oblasti-rada/pcos-i-neplodnost/`

| # | Sekcija | Tekst | Slike |
|---|---|---|---|
| 1 | Hero + `.badge` "PCOS", H1 | `[oblast.pcos.hero]` | `edukacija-pcos-01.webp` (`.pair`, infografika checklist) |
| 2 | Šta je PCOS | `[oblast.pcos.what]` | — |
| 3 | Dijagnostika i hormonske analize | `[oblast.pcos.dijagnostika]` | — |
| 4 | Praćenje ovulacije | `[oblast.pcos.ovulacija]` | — |
| 5 | Najčešće zablude o PCOS-u (kratko, 2–3 — puna verzija čeka više IG materijala, `BLOG_EXPANDED`) | `[oblast.pcos.zablude]` | — |
| 6 | Mini FAQ + `.credential`/`.venue` + povezano + CTA | `[oblast.pcos.faq]`, `[oblast.pcos.cta]` | — |

### 3.7 `/oblasti-rada/muski-faktor-neplodnosti/`

Nema slike u manifestu — rešeno ilustracijom (2.8).

| # | Sekcija | Tekst | Slike |
|---|---|---|---|
| 1 | Hero + `.badge` "Muški faktor", H1 | `[oblast.muski.hero]` | `.illo--spermogram` (desno, u `.frame--halo--wide` okviru) |
| 2 | Šta je spermogram i šta pokazuje (WHO 6. izdanje referentnih vrednosti — pomenuto opisno, bez tabele brojeva ako nisu potvrđeni) | `[oblast.muski.sta]` | — |
| 3 | Kada se preporučuje analiza | `[oblast.muski.kada]` | — |
| 4 | Sledeći korak nakon rezultata | `[oblast.muski.sledeci]` | — |
| 5 | Mini FAQ + `.credential`/`.venue` + povezano (IVF/ICSI) + CTA | `[oblast.muski.faq]`, `[oblast.muski.cta]` | — |

### 3.8 `/oblasti-rada/redovni-ginekoloski-pregledi/`

Nema slike u manifestu — rešeno ilustracijom (2.8). Ovde se referiše Mondo.rs intervju.

| # | Sekcija | Tekst | Slike |
|---|---|---|---|
| 1 | Hero + `.badge` "Redovni pregledi", H1 | `[oblast.pregledi.hero]` | `.illo--pregled` |
| 2 | Zašto su redovni pregledi važni | `[oblast.pregledi.zasto]`: bez senzacionalizma referiše Mondo.rs slučaj (link ka izvoru, ne prepisan tekst) | — |
| 3 | Šta je PAPA test i skrining grlića materice | `[oblast.pregledi.papa]` | — |
| 4 | Koliko često na pregled (opšte preporuke, ne lični protokol) | `[oblast.pregledi.ucestalost]` | — |
| 5 | Mini FAQ + `.credential`/`.venue` + CTA | `[oblast.pregledi.faq]`, `[oblast.pregledi.cta]` | — |

### 3.9 `/pitanja-i-odgovori/` (FAQ hub)

| # | Sekcija | Tekst | Slike |
|---|---|---|---|
| 1 | Hero | H1 "Pitanja i odgovori" (seo.md), lead | `edukacija-simptomi-01.webp` (`.frame--halo--wide`, "Da li je ovo normalno?" — jak vizuelni uvod za FAQ format) |
| 2 | Akordeon grupisan po `.badge` temi (IVF, Zamrzavanje, PCOS, Muški faktor, Redovni pregledi, Opšte) | `[faq.<tema>.<n>]` — sva pitanja iz seo.md 1.4 + dodatna kad klijent dostavi IG Q&A highlight sadržaj (odeljak 9) | — |
| 3 | CTA traka | `[global.cta]` | — |

`FAQPage` JSON-LD — glavni nosač (seo.md 6.3). Svi odgovori uslovni ton, bez brojki.

### 3.10 `/blog/` i podstranice

**Hub `/blog/`:** H1 "Blog" (seo.md formulacija), lead, 3 kartice (`.frame--halo--square` + naslov + 1 rečenica), `[blog.hero]`.

#### `/blog/koliko-jajnih-celija-je-potrebno-za-embrion/`

| # | Sekcija | Tekst | Slika (redosled fiksан, celina) |
|---|---|---|---|
| 1 | Naslovna | `[blog.embrioni.intro]` | `edukacija-embrioni-01.webp` (1/5, naslovna kartica) |
| 2 | Zašto godine menjaju šansu | `[blog.embrioni.godine]` | `edukacija-embrioni-02.webp` (2/5, tabela) |
| 3 | Koliko ćelija je potrebno po starosnim grupama | `[blog.embrioni.tabela]` | `edukacija-embrioni-03.webp` (3/5) |
| 4 | Šta ovo znači u praksi | `[blog.embrioni.praksa]` | `edukacija-embrioni-04.webp` (4/5) |
| 5 | Važna poruka za kraj | `[blog.embrioni.zakljucak]` (citat, `.seal`) | `edukacija-embrioni-05.webp` (5/5) |

Article JSON-LD (seo.md 6.4). Svaka slika prikazana uz tekst koji je **prepisan** sa kartice (Copywriter), ne samo alt tekst — SEO i čitljivost.

#### `/blog/sta-se-zaista-desava-tokom-ivf-postupka/`

Isti obrazac, 5 sekcija prati `edukacija-ivf-proces-01.webp` → `05.webp` (1/5–5/5), teme: biologija/selekcija embriona → individualni pristup → kvalitet nad kvantitetom → niz odluka, ne pokušaj → transfer i priprema pre njega.

#### `/blog/prva-konsultacija-sta-poneti/`

| # | Sekcija | Tekst | Vizuel |
|---|---|---|---|
| 1 | Uvod | `[blog.konsultacija.intro]` | — |
| 2 | Checklist (hormonske analize, spermogram, prethodna medicinska dokumentacija, terapija, pitanja koja želite da postavite) | `[blog.konsultacija.checklist]` | `.checklist` komponenta (tipografska, nema izvorne slike) |
| 3 | Šta se dešava na samoj konsultaciji | `[blog.konsultacija.tok]` | `.steps` |
| 4 | Zaključak/CTA | `[blog.konsultacija.zakljucak]` | `.seal` |

Article JSON-LD; `image` polje u schema koristi OG placeholder (navy/krem tipografska slika, ne fotografija — generiše se kao statička grafika sa citatom, u istom stilu kao IG "premium kartica").

### 3.11 `/mediji-i-predavanja/`

| # | Sekcija | Tekst | Slike |
|---|---|---|---|
| 1 | Hero | H1 "Mediji i predavanja" (seo.md) | `portret-01.webp` (manji, `.frame--halo`) |
| 2 | Medijski nastupi (Mondo.rs, Popodne sa Tanjom ×2, Selfnest) — svaka kao kartica sa ikonom izvora + kratak opis + spoljni link (`rel="noopener"`) | `[mediji.nastupi.<n>]` | tekstualne kartice, bez dedikovane slike (NOTES.md) |
| 3 | Stručne konferencije — galerija 4 slike | `[mediji.konferencije]` | `konferencija-01` (ESHRE), `konferencija-02` (Divčibare, **kropovano po 0.2**), `konferencija-03`, `konferencija-04` (Bio Save) — `.pair`/grid, lightbox |
| 4 | CTA traka | `[global.cta]` | — |

Alt tekstovi: "dr Filip Katanić sa kolegama na ESHRE kongresu", "dr Filip Katanić kao predavač na stručnom skupu u Divčibarama" (BEZ prepisivanja naslova slajda sa "Specialist"), "dr Filip Katanić na predavanju u okviru Bio Save programa" (×2).

### 3.12 `/kontakt/`

Bez CTA trake — cela stranica je poziv na akciju.

| # | Sekcija | Tekst | Slike |
|---|---|---|---|
| 1 | Hero (navy): H1 "Kontakt i zakazivanje" (seo.md), dve akcione pločice: **Zakažite u SB Feroni** (`tel:+381213000220`) i **Poruka na Instagramu** (IG DM, jasno označeno kao "pitanje pre zakazivanja", ne formalni kanal zakazivanja) | `[kontakt.hero]` | — |
| 2 | Napomena o instituciji (seo.md 0.3, obavezan tekst): "Kontakt centar SB Ferona — za zakazivanje pregleda kod dr Filipa Katanića. Telefon i email pripadaju ustanovi." | `[kontakt.napomena]` | — |
| 3 | Gde se postupci sprovode: `.venue-card` (SB Ferona, adresa) | `[global.divina]`-ekvivalent → `[global.ferona]` | `.venue-card` |
| 4 | Mapa: Google Maps iframe (facade "Učitaj mapu" na klik, `loading="lazy"`, `title`) | — | — |
| 5 | Radno vreme — `hidden` dok `RADNO_VREME=False` | `[kontakt.radno_vreme]` `[potvrditi]` | — |

```
NAVY HERO:  Kontakt i zakazivanje (H1)
            [ Zakažite u SB Feroni ]   [ Poruka na Instagramu ]   (velike plocice, 6+6 kol)
            napomena o instituciji (manji tekst, uvek vidljiva ispod plocica)
KREM: .venue-card (5 kol) | adresa/tekst (7 kol)
MAPA (12 kol, 380px / 260px mobilni)
```
Mobilni: pločice jedna ispod druge; sticky bar uvek prikazan (redundantno ali dosledno).

### 3.13 `/politika-privatnosti/`

H1 "Politika privatnosti" (seo.md). Sadržaj: standardna politika (kolačići/analitika ako se koriste, kontakt kanali, čuvanje podataka) + **eksplicitan pasus**: "Testimonijali i iskustva pacijentkinja objavljuju se isključivo uz pisanu saglasnost, sa napomenom 'Objavljeno uz saglasnost pacijentkinje', u skladu sa praksom koju autor već primenjuje na svojim društvenim mrežama." Bez slika.

---

## 4. Ne postoji / odluke o izostavljanju

- **Cenovnik** — ne postoji nigde (seo.md 0.4, 0.5).
- **Testimonijali/iskustva pacijentkinja** — ne postoji komponenta dok ne stignu pisane saglasnosti (odeljak 1.1).
- **Radno vreme** — strukturno predviđeno, sadržajno skriveno (`RADNO_VREME`).
- **Google ocena/recenzije** — nigde, nijedan broj (seo.md 0.5).
- **Dodatnih 2–4 blog članka** (PCOS zablude, social freezing, muški faktor/spermogram, "da li stres utiče na plodnost") — odloženi do dodatnog IG materijala (`BLOG_EXPANDED`), vidi odeljak 9.
- **Poseban GBP profil za doktora** — van obima prve faze (seo.md 7, `GBP_SEPARATE`).
- **Zaseban "/novi-sad/" ili slična lokalna stranica** — nepotrebno, adresa SB Ferona je već jasno prikazana svuda kroz `.venue`/footer.

---

## 5. Šablon oblasti rada (3.4–3.8, sažeto)

```
breadcrumb (Pocetna / Oblasti rada / <oblast>)
HERO krem/bela (7/5): .badge + H1 + lead + CTA  |  slika/.pair ili .illo (5 kol)
.venue (tanka traka: "Postupci se sprovode u okviru SB Ferona, Sarplaninska 19, Novi Sad.")
[Sta je]                     uska kolona 65ch
[Za koga / kada]             redovi, bez kartica
[Tok / proces]                .steps
[Emotivni pasus]              istaknuti citat (navy blok + .seal), gde je relevantno
[Mini FAQ]                    .faq (2-3 pitanja) + FAQPage (mini)
[Ko se ovim bavi]             .credential + link /o-meni/  ;  [Gde] .venue puna
[Povezano]                    2 .link reda (druge oblasti / blog clanci)
CTA TRAKA -> FOOTER
```

---

## 6. Tehnički zahtevi (iz seo.md, za Developera)

- `<html lang="sr-Latn-RS">`, jedan H1, title/meta doslovno iz seo.md, canonical, OG (`og:locale sr_RS`), Twitter `summary_large_image`, favicon set baziran na FK pečatu (0.1.A).
- JSON-LD tačno po seo.md odeljku 6: `Person` (jobTitle "Lekar", worksFor `MedicalOrganization` Ferona, BEZ `alumniOf`/`award`/`aggregateRating`), `FAQPage` na `/pitanja-i-odgovori/` i mini na oblastima rada, `Article` na blog postovima. **Ne** koristiti `Physician`, `LocalBusiness`, `MedicalBusiness` za dr Katanića lično.
- Performanse: cilj LCP < 2.5s; hero slika `fetchpriority="high"`, preload, WebP; sve ostale slike `loading="lazy"` + `width`/`height`; fontovi Fraunces + Karla (0.4 dole), `font-display: swap`, preconnect Google Fonts, max 3–4 težine po fontu.
- Pristupačnost: kontrast po brand.md odeljku 3 (šalvija/zlato samo u potamnjenoj varijanti za tekst); fokus prsten vidljiv; `prefers-reduced-motion`; sav interaktivni sadržaj (dropdown, akordeon, carousel, lightbox) dostupan tastaturom; `tel:` linkovi ispravni; dugmad ≥ 44px.
- Sitemap: svih 15 URL-ova iz odeljka 1, `robots.txt` sa `Allow: /`.
- **`build.py --lint`** mora uključiti i proveru iz 0.2 (da se `hero.webp`/`konferencija-02.webp` koriste samo kroz definisane CSS krop-klase, ne kao pune/pozadinske slike).

---

## 7. Tipografija — odabir i obrazloženje

**Odabrano: Opcija A — Fraunces (naslovi) + Karla (telo)**, u skladu sa preporukom iz `brand.md` odeljka 4.

Obrazloženje za ovog klijenta (ne generičko): brend zahteva **mekoću i zaobljenost** kao dominantan vizuelni jezik (brand.md 5: "dosledno zaobljeni uglovi... zaobljenost signalizira mekoću i smirenost, važno za osetljivu temu steriliteta"). Fraunces je varijabilni serif sa "soft"/optical-size osobinama — same krivine slova su zaobljenije i toplije od Lorine klasične, oštrije "knjiške" forme, pa se bolje uklapa u sistem `.frame--halo`/`.seal`/`.badge` koji je ceo baziran na ovalima i zaobljenim linijama. Karla ima blago zaobljene završetke slova (human sans) koji vizuelno "rukuju se" sa Fraunces-ovom mekoćom bolje nego Mulish-ov nešto neutralniji/geometrijskiji rez. Kurziv (Fraunces Italic) nosi lični/citatni ton (citati, `.credential`, potpis) — bez uvođenja trećeg, dekorativnog script fonta (brand.md 4 eksplicitno savetuje protiv toga).

---

## 8. Redosled gradnje

1. **Osnova:** `tokens.css` (brand.md), `base.css` (reset, tipografija, container, fokus, reveal), `.seal` SVG, `.frame--halo` + CSS krop-preseti za `hero.webp`/`konferencija-02.webp` (0.2 — pre bilo čega drugog, jer je ovo pravilo koje ne sme da promakne u kasnijoj fazi), `.badge`.
2. **Shell:** partials (header + dropdown + mobilni meni, footer, cta-band, sticky-bar, `credential`, `venue`, `venue-card`), `main.js`, `build.py` (+ flagovi iz odeljka 1 + `--lint`), `404.html`.
3. **SVG ilustracije:** `.illo--spermogram`, `.illo--pregled`, `venue-card` skica.
4. **Komponente:** `.steps`, `.faq`, `.checklist`, `.pair`, `.edu-carousel`, lightbox.
5. **Početna** (hero prvo — testirati krop pravilo 0.2 odmah, mobilni + desktop).
6. **Oblasti rada:** hub → IVF/ICSI (najbogatiji, koristi sve komponente) → Zamrzavanje → PCOS → Muški faktor (ilustracija) → Redovni pregledi (ilustracija).
7. **O meni.**
8. **Blog:** hub → embrioni članak → ivf-proces članak → prva konsultacija (checklist).
9. **Pitanja i odgovori.**
10. **Mediji i predavanja** (galerija, lightbox sa kropovanom `konferencija-02`).
11. **Kontakt** (mapa facade).
12. **Politika privatnosti.**
13. **SEO sloj:** head po stranici, JSON-LD, sitemap, robots, alt tekstovi (provera 0.2/2.9 ručno, ne samo lint).
14. **QA:** 320/375/768/1024/1440, tastatura, Lighthouse (LCP < 2.5s, CLS < 0.1), `build.py --lint`, `tel:`/IG linkovi, provera da se nigde ne vidi "specijalista"/"specialist" (uključujući zumiranu `konferencija-02.webp` u lightboxu), reduced-motion, kontrast.

Copywriter piše `copy.md` po ključevima iz kolone "Tekst" (`[home.*]`, `[omeni.*]`, `[oblasti.*]`, `[oblast.<slug>.*]` sa slug: ivf, freezing, pcos, muski, pregledi; `[faq.*]`, `[blog.<slug>.*]`, `[mediji.*]`, `[kontakt.*]`, `[global.*]`) pre koraka 5; Developer paralelno kreće od koraka 1–4.

**Ton za Copywritera** (seo.md 0.6): empatičan, uzdržan, edukativan; jezik uslovan ("može", "plan", "nije garancija"), nikad definitivan ("izlečićemo", "garantujemo"). Zabranjeno: "specijalista"/"specialist" (nigde, ni u internim draftovima), % uspešnosti, poređenje sa drugim lekarima/klinikama, "najbolji", agresivan CTA, konkretne cene, konkretno radno vreme.

---

## 9. Otvorena pitanja za klijenta (spojeno iz seo.md odeljka 9 + zapažanja iz ovog dokumenta)

Redosled po prioritetu:

1. **TITULA** — da li je dr Katanić zvanično položio specijalistički ispit (status "specijalista") ili je trenutno specijalizant/doktorand? Bez pismene potvrde, pravilo 0.1 (nigde "specijalista"/"specialist") ostaje na snazi neograničeno — ovo utiče i na `konferencija-02.webp` (vidi tačku 12 dole).
2. **Status zaposlenja u SB Ferona** — zaposlen, spoljni saradnik, ili drugo? Utiče na formulacije u `.credential`/footeru.
3. **Radno vreme** — nije potvrđeno ni na jednom izvoru; sekcija na `/kontakt/` ostaje skrivena dok se ne dostavi.
4. **Cenovnik** — sajt trenutno ne pominje cene uopšte; potvrditi da klijent ovo želi da ostane tako (preporuka: da).
5. **Google recenzije** — ne prikazuju se; potrebna ručna provera na Google Maps ako se ikad odluči da se koriste (trenutno se ne koriste na sajtu dr Katanića, izvori se ne slažu).
6. **Domen** — koji domen se kupuje (`.rs` preporučeno).
7. **Testimonijali** — da li postoje već prikupljene pisane saglasnosti pacijentkinja (van IG)? Bez toga sekcija ostaje nepostojeća (ne samo skrivena).
8. **Čist portret bez utisnutog teksta i/ili alternativni kadar sa konferencije u Divčibarama** — `hero.webp` i `konferencija-02.webp` moraju se kadrirati da izbegnu reč "specijalista"/"specialist" (0.2); trenutno rešenje (krop) je funkcionalno ali nije idealno dugoročno — zatražiti od klijenta: (a) 1–2 studijska portreta bez teksta/grafike, (b) alternativni kadar sa Divčibara bez čitljivog slajda, ili pisanu dozvolu/kontekst da se slajd prikaže čitljivo kao istorijski dokument (nije preporučeno dok se ne razjasni tačka 1).
9. **Fotografije prostora SB Ferona** — nema nijedne čiste slike ordinacije/lab/OR; `.venue-card` je privremeno tipografsko rešenje (0.3); zatražiti od bolnice (@bolnica.ferona highlight "Iz ordinacije") ili direktno od klijenta, uz odobrenje ustanove.
10. **Vektorska verzija FK monograma** — da li postoji, ili treba redizajnirati minimalno (brand.md 8) za favicon/`.seal`.
11. **Dodatni sadržaj za blog** — trenutno samo 3 članka (2 iz punih carousel serija + 1 checklist). Za članke "PCOS — najčešće zablude", "Da li stres utiče na plodnost", "Zamrzavanje jajnih ćelija — kada ima smisla", "Spermogram — osnovni pojmovi" potreban je dodatni izvorni materijal (pune IG karusel serije ili tekst od klijenta) — trenutno postoje samo pojedinačne kartice, nedovoljno za pun članak bez izmišljanja sadržaja.
12. **Sadržaj IG Q&A highlightova (Part 3–7)** — video sadržaj nije bilo moguće pročitati (research.md); ako klijent može da dostavi transkript ili tekst pitanja/odgovora, `/pitanja-i-odgovori/` se može značajno proširiti stvarnim, već postavljenim pitanjima pratilaca.
13. **Obrazovanje (Medicinski fakultet Novi Sad)** — pisana potvrda ustanove/godine radi bezbednog dodavanja u tekst i schema `alumniOf`.
14. **Google Business Profil** — da li klijent želi zaseban GBP kao lekar, usaglašeno sa upravom SB Ferona (van obima prve faze).
15. **Autorska prava na konferencijske fotografije** — moguće je da su fotograf/organizator događaja treća strana; potvrditi pravo korišćenja pre finalne objave (NOTES.md).
16. **Originalne IG objave / rezolucija** — poželjno je dobiti fajlove u većoj rezoluciji direktno od klijenta (trenutne slike su kompresovane sa IG-a), posebno za `hero.webp` gde je krop presudan za zaobilaženje problema iz 0.2.

---

## Sažetak za sledeće agente

- **Arhitektura:** lični brend/portfolio, 15 statičkih URL-ova, "Oblasti rada" umesto "Usluge", bez cenovnika, CTA vodi ka SB Feroni ("Zakažite u SB Feroni"), sve institucionalne kontakt podatke prati jasna napomena da su podaci ustanove.
- **Potpisni element:** `.seal` (FK pečat u krugu) + `.frame--halo` (zaobljeni zlatni ram sa uvučenom linijom) + `.badge` (oval pill-bedž) — sva tri izvedena direktno iz postojećeg IG vizuelnog jezika, bez kosih/dijagonalnih dekorativnih elemenata (brend nema tu osnovu; sve je ovalno/zaobljeno).
- **Tipografija:** Fraunces (naslovi) + Karla (telo) — odabrano zbog mekoće/zaobljenosti koja se poklapa sa `.frame--halo`/`.seal` sistemom.
- **Kritično tehničko zapažanje:** `hero.webp` i `konferencija-02.webp` imaju reč "Specijalista"/"Specialist" ugraviranu u samu sliku — obe se koriste isključivo kroz definisane CSS krop-presete (0.2); `portret-01.webp` je jedina potpuno čista slika i ide na `/o-meni/` hero.
- **Sadržajna ograničenja:** bez testimonijala (nema saglasnosti), bez cenovnika, bez brojki uspešnosti, bez radnog vremena — sve po seo.md odeljku 0. Samo 3 blog članka u prvoj fazi (materijal za više postoji samo delimično).
- **Otvorena pitanja:** 16 stavki u odeljku 9, prioritetno pitanje titule (0.1) i čistih fotografija (portret + prostor SB Ferona).
