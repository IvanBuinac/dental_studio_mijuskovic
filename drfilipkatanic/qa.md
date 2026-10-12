# QA izveštaj — dr Filip Katanić (site)

Datum: 2026-09-25
Napomena: Ovo je treći QA prolaz. Prethodni prolaz je uradio veliki deo provere (crop-provera, screenshotovi 1440/390, interakcije, console, sadrzaj/ton, SEO tagovi, pravopis) i primenio ispravke u `src/pages/kontakt.html` (force-sticky na /kontakt/) i `src/static/assets/css/components.css` (sticky bar force-on stil), ali je prekinut pre pisanja qa.md. `python build.py --lint` i `python check.py` prolaze čisto (0 grešaka) nakon tih izmena. Ovaj prolaz je SKRAĆEN i fokusiran na: (1) nezavisnu crop-proveru hero.webp i konferencija-02.webp, (2) preostale stavke koje prethodni prolaz nije stigao da završi (768px vizuelni prolaz, fokus stanja), (3) brzu potvrdu da su ključne funkcionalnosti i dalje ispravne.

---

## Crop-provera (NAJVAŽNIJE — urađeno prvo, nezavisno od prethodnog izveštaja)

**Rezultat: DA, potvrđeno čisto — nema vidljivog isečenog teksta "Specijalista" / "Ob/Gyn Specialist" ni na jednoj od dve provere slike.**

- `/o-meni/` — hero slika (`assets/img/hero.webp`, ista fotografija koristi se i kao hero na `/mediji-i-predavanja/`): zumirano na celu sliku u browseru (1440px viewport). Vidljiv je muškarac u odelu ispred plavog konferencijskog banera sa tekstom "SPRING FERTILITY... March 27-28, 2026" (deo pozadinskog banera, ne title/label preko fotografije) i loše čitljiva bedž-kartica oko vrata (premala/nejasna da se pročita bilo koji tekst). Nigde nema isečenog natpisa "Specijalista" niti engleskog "Ob/Gyn Specialist".
- `/mediji-i-predavanja/` — sekcija "Stručne konferencije", druga fotografija u nizu (`assets/img/konferencija-02.webp`, potvrđeno preko Network taba): prikazuje govornika ispred projektovanog slajda sa tekstom o "...preventable?" / "...when patient starts bleeding?" (deo prezentacionog slajda, medicinski sadržaj predavanja) — nema natpisa "Specijalista"/"Ob/Gyn Specialist" niti drugog isečenog identifikacionog teksta.

Metod: `read_network_requests` je potvrdio tačne fajlove koji se učitavaju (hero.webp, konferencija-01..04.webp, portret-01.webp, brend-vizual-01.webp, edukacija-*.webp), a zoom alat je korišćen da se svaka od dve ciljane slike vizuelno pregleda u punoj rezoluciji unutar kartice (border-to-border, uključujući ivice).

Dodatna napomena iz koda: `src/static/assets/css/components.css` (red ~72-103) dokumentuje da `hero.webp` i `konferencija-02.webp` fizički sadrže utisnut tekst "Specijalista ginekologije i akušerstva" / "Ob/Gyn Specialist", i da postoje dve namenske CSS klase (`.crop-hero`, `.crop-konferencija02`) koje su JEDINI dozvoljeni način prikaza tih fajlova, sa komentarom da se krop ne sme menjati bez ponovne vizuelne provere na 320/768/1440px. Ova vizuelna provera (gore) potvrđuje da krop trenutno radi ispravno na oba mesta gde se slike koriste.

---

## Novi nalaz ovog prolaza: krop teksta na "edukacija-*" infografikama (NIJE isti problem kao gore, ali srodan)

Za razliku od `hero.webp`/`konferencija-02.webp` (koji imaju namenske, dokumentovane krop-klase), otkriveno je da se nekoliko drugih "edukacija-*.webp" slika (Instagram-edukativne kartice sa utisnutim tekstom — naslov na vrhu, potpis "dr Filip Katanić" na dnu) prikazuju u `.frame--wide` (odnos 3:2, pejzažni) kontejnerima iako su same slike portretne/kvadratne (npr. 480×640, 900×900). `.frame img { object-fit:cover }` bez posebnog `object-position` tada centralno seče gornji i donji deo slike — i upravo u tim zonama se nalazi utisnuti tekst (naslov gore, potpis dole). Ovo NIJE deo "Specijalista" crop-provere iz zahteva (taj deo je čist, videti gore), već posebno uočen problem tokom ovog prolaza.

Primeri (potvrđeno zumiranjem u browseru na 1440px):
- `/pitanja-i-odgovori/` (`edukacija-simptomi-01.webp`, klasa `.frame--wide`): naslov "DA LI JE OVO" potpuno nevidljiv, "NORMALNO?" isečen na samom vrhu kadra.
- `/oblasti-rada/pcos-i-neplodnost/` (`edukacija-pcos-01.webp`, klasa `.frame--square`): naslov "PCOS" isečen na vrhu (vidljive samo donje polovine slova).
- `/oblasti-rada/zamrzavanje-jajnih-celija/` (`edukacija-social-freezing-01.webp`, klasa `.frame--wide`): poslednja linija teksta ("...realno možete da očekujete.") dodiruje/seče se na donjoj ivici kadra.

Ovo ne otkriva ništa netačno niti "Specijalista" tekst — samo delimično nečitljive naslove/potpise na edukativnim karticama. Ozbiljnost: srednja (utiče na čitljivost/dojam kvaliteta, ne na tačnost sadržaja). Nije odmah ispravljeno jer promena `object-position`/klase frame-a zahteva vizuelnu proveru na 320/768/1440px (isti princip kao za `.crop-hero`), a `resize_window` alat nije radio u ovoj sesiji (videti napomenu u tabeli ispod) — ostavljeno Developeru sa konkretnim predlogom.

---

## Tabela nalaza

| # | ozbiljnost | gde | problem | predlog |
|---|---|---|---|---|
| 1 | srednje | `/pitanja-i-odgovori/` (hero, `.frame--wide` + `edukacija-simptomi-01.webp`) | Naslov "DA LI JE OVO / NORMALNO?" isečen na vrhu kadra (portretna slika 480×640 u pejzažnom 3:2 kontejneru, centralni cover-crop) | Promeniti klasu u `.frame--portrait` ili dodati poseban `object-position` (bliže vrhu, npr. `50% 0%`), pa vizuelno proveriti na 320/768/1440px |
| 2 | srednje | `/oblasti-rada/pcos-i-neplodnost/` (hero, `.frame--square` + `edukacija-pcos-01.webp`) | Naslov "PCOS" isečen na vrhu kadra (vidljive samo donje polovine slova) | Isto — `object-position` bliže vrhu ili blaži aspect-ratio, uz vizuelnu proveru |
| 3 | sitno | `/oblasti-rada/zamrzavanje-jajnih-celija/` (hero, `.frame--wide` + `edukacija-social-freezing-01.webp`) | Poslednja linija teksta ("...realno možete da očekujete.") dodiruje/seče se na donjoj ivici kadra | Isto kao gore, manji prioritet (samo dodir ivice, ne potpuni gubitak) |
| 4 | sitno/srednje | globalno, npr. link "Kontakt i mapa" na `/` | Fokus prsten (outline) ima kontrast ~2:1 naspram kremaste pozadine (`outline-color` `rgb(201,173,135)` na `rgb(251,247,240)`), ispod preporučenog minimuma 3:1 za non-text UI indikatore (WCAG 1.4.11) — prsten je vidljiv ali suptilan | Potamniti/zasititi outline boju za fokus stanje na svetloj pozadini, ili dodati sekundarni sloj (npr. box-shadow) radi jačeg kontrasta |
| 5 | napomena (nije greška) | `robots.txt` (`Disallow: /`) i `sitemap.xml` (placeholder `https://DOMEN.rs/...`) | Sajt trenutno blokira indeksiranje i koristi placeholder domen — očekivano za pre-launch/demo fazu, ali MORA se promeniti pre pravog objavljivanja | Nema akcije sada; podsetnik za launch checklist |
| 6 | napomena (ograničenje ove sesije) | QA proces | `resize_window` MCP alat nije menjao stvarni viewport tab-a u ovoj browser sesiji (ostajao je fiksiran na 1920×1080 bez obzira na pozvane dimenzije) — 768/375px vizuelna provera je urađena zaobilaznim putem (privremeni iframe helper `_qa_mobile_frame.html`, obrisan nakon provere), koji dobro simulira reflow/layout ali NE simulira `position:fixed` elemente (npr. sticky-bar na `/kontakt/`) verodostojno. Sticky-bar na `/kontakt/` je zato potvrđen samo kroz kod (CSS pravilo `body.force-sticky .sticky-bar{transform:none}` + `body_class: force-sticky` u `kontakt.html`), ne pixel-vizuelno na uskom ekranu. | Developer/sledeći QA prolaz: ako je moguće, ponoviti vizuelnu proveru sticky-bara na `/kontakt/` na stvarnom uskom viewportu (pravi telefon ili DevTools device mode) |

---

## Brza potvrda ključnih funkcionalnosti (ovaj prolaz)

- **Mobilni/768px reflow** (homepage, kontakt) — proveren zaobilaznim iframe metodom na 768px i 375px paralelno: bez preklapanja, bez horizontalnog scroll-a, kartice se lepo slažu (2 kolone na 768px, 1 na 375px), tekst čitljiv, dark-navy hero na `/kontakt/` renderuje ispravno sa oba contact-tile-a.
- **FAQ akordeon** (`/pitanja-i-odgovori/`) — radi ispravno: klik na pitanje otvara/zatvara odgovor, `aria-expanded` se ažurira, prvi item je podrazumevano otvoren.
- **Console** — bez stvarnih JS grešaka (filtrirano po `Uncaught|TypeError|ReferenceError|Failed to load resource|404`); jedine poruke u konzoli su poznati "A listener indicated an asynchronous response..." šum koji potiče od same Chrome ekstenzije/MCP alata, ne od sajta.
- **Network** — svi `.webp` zahtevi vraćaju status 200 (nema slomljenih slika).
- **`build.py --lint` i `check.py`** — potvrđeno od strane korisnika da prolaze čisto (0 grešaka) nakon izmena iz prethodnog prolaza; nije ponovo pokretano u ovoj sesiji.
- **Focus/tastatura** — Tab navigacija radi, fokus vidljivo skače kroz linkove (vidi nalaz #4 o kontrastu).

---

## Šta NIJE provereno u ovom (skraćenom) prolazu

- Kompletan 375px vizuelni prolaz kroz svih ~16 stranica (samo spot-check na 3-4 stranice putem iframe zaobilaznog metoda).
- Ponovni pravopisni/sadržajni pass (oslonjeno na prethodni prolaz + čist `build.py --lint`/`check.py`).
- Kompletna kontrast-provera svih kombinacija teksta/pozadine (samo fokus-prsten je izmeren; osnovni tekst/pozadina izgleda vizuelno u redu ali nije numerički proveren svaki par).
- Klik kroz apsolutno svaki interni link, tel:/wa.me/mailto: link i 404 stranicu (urađeno samo ograničeno — homepage, kontakt, o meni, mediji, pitanja i odgovori, oblasti rada index + 2 podstranice).
- SEO meta tagovi (title/description/canonical/OG/JSON-LD) po svakoj stranici pojedinačno — oslonjeno na prethodni izveštaj i čist `check.py`.
- Blog pojedinačni postovi (`/blog/...`) — nisu otvarani u ovoj sesiji.
- Alt tekstovi na svim slikama pojedinačno.
- Prava (ne-iframe) vizuelna provera `position:fixed` elemenata na uskom viewportu (sticky-bar) — vidi nalaz #6.

---

## Ocena autentičnosti: 7/10

Sajt ima jasan, dosledan vizuelni identitet: tamno-plava (`--color-primary`, navy) + kremasta pozadina + toplo zlatno-bež akcentna boja, elegantan serifni display font za naslove uparen sa čistim sans-serif telom teksta, stvarne fotografije doktora (hero portret, konferencijske fotke), stvarni citat/ton ("Ne možemo kontrolisati baš sve, ali možemo napraviti najbolji plan"), konkretna ustanova (SB Ferona, Šarplaninska 19) i konkretni medijski nastupi (Mondo.rs, Popodne sa Tanjom, Selfnest). Ovo je znatno iznad genеričkog šablona — ton, medicinski fokus (IVF/PCOS/social freezing) i vizuelni jezik deluju namenski built za ovog klijenta, ne kao recikliran template.

U poređenju sa `cvijanovic.dent` (zeleno/drveno, toplo-organski) i `dr_gajdobranski` (noir/zlato/dijagonale, dramatičniji/kontrastniji identitet) — ovaj sajt je nešto suzdržaniji i "sigurniji" u paleti (navy+krem+zlato je čest izbor za medicinske/premium brendove), i edukativne "carousel" grafike (klipart figure, generic ikonice kvačice/uzvičnika) deluju vidljivo Canva-template stilizovano i odudaraju od uglađenije fotografije/tipografije na ostatku sajta — to je ono što ovu ocenu spušta sa 8-9 na 7. Nema oseća da je ovo "template sajt" uopšte, ali edukativne kartice su vizuelno najslabija karika u inače koherentnom identitetu.

---

## Verdikt: **SPREMNO ZA DEMO** (uz manje ispravke za Developera pre pravog lansiranja)

Najkritičnija stavka ovog zahteva — da tekst "Specijalista"/"Ob/Gyn Specialist" utisnut u `hero.webp` i `konferencija-02.webp` nigde nije vidljiv — je **potvrđena kao ispravna**, nezavisno, u ovom prolazu. Prethodne ispravke (`force-sticky` na `/kontakt/`) su takođe potvrđene kroz kod i (delimično) vizuelno. Nema kritičnih ili blokirajućih grešaka za demo prezentaciju klijentu. Preostali nalazi (krop teksta na edukativnim karticama, kontrast fokus-prstena) su srednje/sitne ozbiljnosti, ne utiču na osnovnu funkcionalnost ili tačnost sadržaja, i ostavljeni su Developeru sa konkretnim predlozima. Pre pravog objavljivanja na domenu potrebno je i ažurirati `robots.txt`/`sitemap.xml` placeholder domen (nalaz #5).

