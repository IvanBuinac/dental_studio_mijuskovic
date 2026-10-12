# dr Filip Katanić — sajt (build sistem i objava)

Statičan sajt (čist HTML5 + CSS + malo vanilla JS, bez frameworka i bez build koraka u produkciji). Izvor je u `src/` (partial-i, stranice, podaci), generisani izlaz koji se objavljuje je `site/`.

## 1. Kako se gradi

Preduslov: Python 3.8+ (opciono `pip install pillow` — bez toga se `favicon.ico/-32/-180.png` i `assets/img/og-image.jpg` preskaču uz upozorenje, ali su već generisani u repou).

```
python build.py            # gradi src/ -> site/
python build.py --lint     # gradi + provera zabranjenih izraza/pravila (exit 1 ako padne)
python build.py --kit      # gradi src/pages/_kit.html -> _preview/ (interni pregled komponenti, NE ide u site/)
python check.py            # dodatna tehnička QA provera (linkovi, alt/width/height, H1, SEO tagovi, JSON-LD, sitemap)
```

`build.py --lint` mora proći bez **grešaka** pre svake objave (upozorenja o `[POTVRDITI SA KLIJENTOM]`, `DEMO=True` i placeholder domenu su očekivana i OK). `check.py` mora vratiti 0 grešaka.

## 2. Lokalna provera pre objave

```
cd site
python -m http.server 8000
```
Otvoriti `http://localhost:8000/` i proći kroz meni, mobilni prikaz (< 1024px), FAQ akordeone, edukativni karusel, lightbox galerije i kontakt stranicu.

## 3. Objava (bilo koji free/static hosting)

1. U `build.py` promeniti:
   - `SITE_URL = "https://DOMEN.rs"` → pravi domen (bez trailing slash).
   - `DEMO = True` → `DEMO = False` (uklanja `noindex` i menja `robots.txt` u `Allow: /`).
2. Pokrenuti `python build.py --lint` — mora proći bez grešaka.
3. Otpremiti **sadržaj** foldera `site/` (ne sam folder) na hosting (Netlify/Vercel/GitHub Pages/Cloudflare Pages/bilo koji statički host) — `index.html` mora biti u korenu.
4. Ako se hostuje na podputanji (npr. `nekihosting.com/katanic/`), sve interne putanje su relativne (`{{root}}` sistem) pa rade i tako — **izuzetak je `404.html`**, koji koristi `root: /` (apsolutne putanje) jer većina statičkih hostova servira taj fajl za bilo koju nepostojeću putanju; ako se sajt hostuje na podputanji, front matter `root:` u `src/pages/404.html` treba ručno podesiti na tu podputanju pre builda.
5. Proveriti da `sitemap.xml` i `robots.txt` na živom sajtu pokazuju pravi domen i `Allow: /`.

## 4. Struktura

```
site/
  index.html                                            /
  o-meni/                                                /o-meni/
  oblasti-rada/                                          /oblasti-rada/  (+ 5 podstranica)
  pitanja-i-odgovori/                                    /pitanja-i-odgovori/
  blog/                                                  /blog/  (+ 3 članka)
  mediji-i-predavanja/                                   /mediji-i-predavanja/
  kontakt/                                               /kontakt/
  politika-privatnosti/                                  /politika-privatnosti/
  404.html, sitemap.xml, robots.txt, favicon*, site.webmanifest
  assets/css/ (tokens/base/components/pages) assets/js/ (main/lightbox/carousel/map) assets/img/
src/
  layout.html, partials/*.html, pages/**/*.html, data/site.json, data/jsonld/*.json
build.py    — builder + --lint (sadržajna/brend pravila iz structure.md/seo.md)
check.py    — tehnička QA (linkovi, alt/width/height, H1, SEO tagovi, JSON-LD, sitemap)
```

16 objavljenih URL-ova (sitemap.xml) + `404.html` (noindex).

### JSON-LD

- `Person` (jobTitle "Lekar", `worksFor` → `MedicalOrganization` SB Ferona, **bez** `alumniOf`/`award`/`aggregateRating`) na `/` i `/o-meni/` — `src/data/jsonld/person.json`.
- `BreadcrumbList` na 5 `/oblasti-rada/*` podstranica i 3 `/blog/*` članka — `src/data/jsonld/breadcrumb-*.json`.
- `FAQPage` — generiše se **automatski** iz `{{faq}}` blokova na stranici (front matter `jsonld: auto-faq`), tako da se pitanja/odgovori nikad ne dupliraju/razilaze između vidljivog teksta i schema-e. Koristi se na `/pitanja-i-odgovori/` (glavni nosač) i na mini-FAQ delu svake `/oblasti-rada/*` podstranice.
- `Article` na 3 blog članka — `src/data/jsonld/article-*.json`.

## 5. Kritično pravilo — `hero.webp` i `konferencija-02.webp`

Obe slike imaju utisnut/vidljiv tekst sa rečju "Specijalista"/"Ob/Gyn Specialist" (jedna u samoj fotografiji, druga na slajdu u pozadini konferencijske fotografije) — dok titula dr Katanića nije pismeno potvrđena (stavka 1 ispod), ova reč se ne sme prikazati posetiocu ni u jednom obliku. Zato:

- Obe slike se koriste **isključivo** kroz CSS klase `.crop-hero` / `.crop-konferencija02` na `<img>` tagu (nikad puna slika, nikad kao lightbox/uvećanje).
- `build.py --lint` ovo proverava mašinski (`CROP_REQUIRED`) i **pada** ako neko doda ove slike bez odgovarajuće klase ili ih poveže kao lightbox trigger — namerno, da buduće izmene layout-a ne vrate zabranjen tekst u kadar.
- Ručno je dodatno potvrđeno (grep) da se reč "specijalista/specialist" u `site/` pojavljuje **samo jednom**, i to unutar HTML komentara u `mediji-i-predavanja/index.html` koji objašnjava pravilo o kropovanju — nije vidljiva posetiocu.

## 6. QA rezultati (poslednji build)

- `python build.py --lint` → **0 grešaka**, 11 upozorenja (sva očekivana: `[POTVRDITI SA KLIJENTOM]` komentari, napomena o testimonijalima na `/politika-privatnosti/`, `DEMO=True`, placeholder `SITE_URL`).
- `python check.py` → **0 grešaka, 0 upozorenja** (linkovi, alt/width/height, jedan H1 po stranici, title/meta/canonical, validan JSON-LD, sitemap).
- Ručni `grep -rniE "specijalist|specialist"` u `site/` → 1 pogodak, isključivo u HTML komentaru (vidi tačku 5).
- Ručni `grep -rn "%"` u `site/` → 0 pogodaka.
- Lokalni server + provera svih 16 stranica + statičkih fajlova (CSS/JS/favicon/sitemap/robots) → svi `200 OK`, 0 mrtvih internih linkova (automatska provera 60 unikatnih putanja).

## 7. Stavke za potvrdu sa klijentom

Sve stavke ostaju vidljivo označene u kodu kao HTML komentar `<!-- [POTVRDITI SA KLIJENTOM: ...] -->` na tačnom mestu u `src/pages/**`, pored opšte/bezbedne formulacije koja je vidljiva posetiocu. Pregled (prioritetno):

1. **Titula** — da li je dr Katanić zvanično položio specijalistički ispit. Dok se pismeno ne potvrdi, "specijalista"/"specialist" se ne sme pojaviti nigde (ni u tekstu, ni u alt tekstu, ni u schema — `TITULA_SPECIJALISTA` flag u `build.py` ostaje `False`, lint pada bez obzira na flag ako bi neko to promenio).
2. **Status zaposlenja u SB Feroni** (zaposlen / spoljni saradnik) — do potvrde, svuda piše samo "član tima SB Ferona".
3. **Obrazovanje** — tačna ustanova (verovatno Medicinski fakultet Novi Sad) i godina diplomiranja (`/o-meni/`, sekcija "Obrazovanje i afilijacije") — trenutno opisano kao "prema javno dostupnim izvorima, u postupku potvrde", van JSON-LD `alumniOf`.
4. **Dozvola za referisanje Mondo.rs slučaja** (propušten karcinom uprkos urednom PAPA testu) — koristi se na `/oblasti-rada/redovni-ginekoloski-pregledi/` i `/mediji-i-predavanja/`. Link trenutno vodi na **potvrđenu Instagram objavu** o tom intervjuu (`instagram.com/p/Da--zRCAmLE/`), ne na sam mondo.rs članak — pravi URL članka treba dostaviti/potvrditi.
5. **Link ka Selfnest epizodi** — link trenutno vodi na potvrđenu Instagram najavu epizode (`instagram.com/p/Dck_2NAIe1l/`); pravi URL Selfnest platforme/epizode treba dostaviti.
6. **Link ka "Popodne sa Tanjom"** — trenutno vodi na jedan od pronađenih YouTube snimaka (`youtube.com/watch?v=ezpNsb1puQU`); postoji više kandidata (videti `web-research.md`) — potvrditi tačan snimak.
7. **Tačan tok i trajanje postupka zamrzavanja jajnih ćelija** u SB Feroni (`/oblasti-rada/zamrzavanje-jajnih-celija/`).
8. **Smernica "12/6 meseci pokušaja"** — da li se koristi u praksi SB Ferona (`/pitanja-i-odgovori/`, grupa Opšte).
9. **Tačan tok prve konsultacije** u SB Feroni (`/blog/prva-konsultacija-sta-poneti/`).
10. **Protokol učestalosti redovnih pregleda** u SB Feroni, ako postoji poseban (`/oblasti-rada/redovni-ginekoloski-pregledi/`).
11. **Status i datum učešća na SPRING Fertility konferenciji** (`/mediji-i-predavanja/`).
12. **Alat za analitiku** na sajtu, ako se koristi (`/politika-privatnosti/`).
13. **Kontakt formular** — da li se dodaje u narednoj fazi (trenutno nema forme; kontakt je isključivo `tel:`/Instagram/`mailto:`, sve podaci institucije SB Ferona).
14. **Orijentacioni opsezi brojeva ćelija/embriona** za `/blog/koliko-jajnih-celija-je-potrebno-za-embrion/` — opciono, tekst ostaje opisni dok se ne potvrdi.
15. **Čist portret bez utisnutog teksta i/ili alternativni kadar sa Divčibara** — trenutno rešeno kropovanjem (tačka 5), nije trajno idealno rešenje.
16. **Fotografije prostora SB Ferona** — nema nijedne; `.venue-card` je privremeno tipografsko rešenje.
17. **Radno vreme** — nije potvrđeno nigde; sekcija na `/kontakt/` postoji u kodu ali je sakrivena (`RADNO_VREME=False` u `build.py`).
18. **Cenovnik** — potvrđeno da se ne objavljuje nigde (preporuka: ostati tako).
19. **Domen** — koji domen se kupuje (`.rs` preporučeno) — trenutno placeholder `https://DOMEN.rs` u `build.py`.
20. **Google mapa na `/kontakt/`** — trenutno koristi search-query embed (`SB Ferona Šarplaninska 19 Novi Sad`); ako klijent/Ferona ima tačan Google Maps Place ID/link, zameniti u `src/pages/kontakt.html` (`data-src` na dugmetu "Učitaj mapu").

## 8. Poznata ograničenja / dizajnerske odluke

- Testimonijali i cenovnik namerno ne postoje nigde (nema pisanih saglasnosti pacijentkinja, odluka iz `structure.md`/`seo.md`).
- Samo 3 blog članka u prvoj fazi (dovoljno izvornog IG materijala postoji samo za ove teme) — `BLOG_EXPANDED=False` u `build.py`.
- `/kontakt/` nema CTA traku (cela stranica je poziv na akciju) i mobilni sticky bar je na njoj uvek prikazan (bez CTA trake nema IntersectionObserver okidača za automatsko sakrivanje — rešeno CSS klasom `body.force-sticky`).
- Google Maps se učitava tek na klik ("Učitaj mapu") radi performansi — pre klika nema mrežnog zahteva ka Google-u.
