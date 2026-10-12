# Copy v2 — dr Filip Katanić (lični sajt) — 2026-10-12

Autor: copywriter. Izvori po prioritetu: `brief-v2.md` → `structure-v2.md` → `brand.md` (v2) → `research.md` → `web-research.md` → `seo.md` → stari `copy.md` → `_reference/referenca-dizajn.webp`.
Stari `copy.md` ostaje kao arhiva. **Gde se razlikuju, važi ovaj fajl.** (Izuzetak: tekstovi podstranica oblasti rada, FAQ-a i bloga ostaju iz `copy.md` — menjaju se samo stavke iz tabele u §5 ovog fajla.)

## Pravila ovog fajla

- Srpski, latinica, ekavica, sa dijakriticima.
- Obraćanje: **"Vi" sa velikim slovom** (Vi, Vas, Vam, Vaš, Vaša…) dosledno, kao postojeći sajt (`src/pages/**` koristi veliko V). Doktor o sebi govori u prvom licu jednine ("moj pristup", "pomažem"); kada se govori o zajedničkom radu sa pacijentom — "mi" ("napravimo plan", "analiziramo").
- Bez obećanja uspeha, bez procenata i brojki (godine iskustva, broj pacijenata, beba, uspešnost), bez cena, bez recenzija.
- Ferona = **samo mesto ordiniranja** ("Ordinira u SB Ferona, Novi Sad"). Nikad kao vlasnik, kontakt ili brend sajta.
- Titula "Specijalista ginekologije i akušerstva" se **sme** koristiti (brief-v2 §3), ali svuda gde se pojavi u kodu ide HTML komentar `<!-- [POTVRDITI SA KLIJENTOM: pismena potvrda titule pre objave] -->`.
- `[POTVRDITI SA KLIJENTOM: …]` = u kod ide kao HTML komentar uz bezbednu vidljivu formulaciju (structure-v2 §0). Ako je cela stavka nepotvrđena, napisano je šta se prikazuje DO potvrde.
- Oznake: `H1`, `H2`, `Eyebrow`, `Lead`, `Pasus`, `CTA`, `Link`, `Alt`, `Hint` (pomoćni tekst ispod polja), `Placeholder`, `Greška`. `{{…}}` = podatak iz `site.json`; `{…}` = placeholder u mejlu/adminu.

---

# 1. GLOBALNO

## 1.1 Header

| Element | Tekst |
|---|---|
| Monogram (SVG) | FK — `aria-hidden="true"` |
| Wordmark, red 1 | dr Filip Katanić |
| Wordmark, red 2 | Reproduktivna medicina |
| `aria-label` linka brenda | dr Filip Katanić, početna |
| Dugme (desktop) | Zakaži konsultaciju → `/zakazivanje/` |
| Dugme (tablet 768–1119, kratko) | Zakaži → `/zakazivanje/` (`aria-label="Zakaži konsultaciju"`) |
| Burger `aria-label` | Otvori meni / Zatvori meni |
| Skip link | Preskoči na sadržaj |
| `aria-label` navigacije | Glavna navigacija |

## 1.2 Glavni meni (desktop)

Početna · O meni · Oblasti rada ▾ · Konsultacija · Blog · Kontakt · [Zakaži konsultaciju]

(“Konsultacija” → `/zakazivanje/`)

**Dropdown "Oblasti rada"**

Kolona 1 — eyebrow: OBLASTI RADA

| Stavka | Mikro-opis (opciono, 13px) |
|---|---|
| Vantelesna oplodnja (IVF/ICSI) | Dijagnostika, plan i vođenje postupka |
| Zamrzavanje jajnih ćelija | Kada ima smisla i šta obuhvata |
| PCOS i neplodnost | Dijagnostika i praćenje ovulacije |
| Muški faktor neplodnosti | Spermogram i sledeći koraci |
| Redovni ginekološki pregledi | PAPA test i redovna kontrola |
| Sve oblasti rada → | — |

Kolona 2 — eyebrow: KORISNO
- Pitanja i odgovori →
- Mediji i predavanja →
- Prva konsultacija — šta poneti →
- (linija)
- Drugo mišljenje → (`/zakazivanje/?usluga=drugo-misljenje`)

## 1.3 Mobilni meni

- `aria-label` dijaloga: Meni
- Stavke (serif): Početna · O meni · Oblasti rada (+) · Konsultacija · Blog · Kontakt
- Akordeon "Oblasti rada": Vantelesna oplodnja (IVF/ICSI) · Zamrzavanje jajnih ćelija · PCOS i neplodnost · Muški faktor neplodnosti · Redovni ginekološki pregledi · Sve oblasti rada
- Sekundarno: Pitanja i odgovori · Mediji i predavanja
- Dugme: **Zakaži konsultaciju** → `/zakazivanje/`
- Link: Instagram @drfilipkatanic
- Sitno (informacija, ne kontakt): Ordinira u SB Ferona, Novi Sad

## 1.4 CTA labele (jedinstven rečnik — koristiti svuda isto)

| Upotreba | Labela |
|---|---|
| Glavni CTA (header, hero, trake, kartice) | Zakaži konsultaciju |
| Kratki CTA (tablet header, mikro-link na kartici) | Zakaži → |
| Sekundarni hero | Oblasti rada |
| Tekst-link članka | Pročitaj više → |
| Link ka bio stranici | Više o meni → |
| Link ka blogu | Svi članci → |
| Link ka FAQ | Pitanja i odgovori → |
| Link ka mapi | Otvori u Google mapama → |
| Instagram | Pišite na Instagramu |
| Dugme forme | Pošalji zahtev |
| Drugo mišljenje (kartica / dropdown) | Zatražite drugo mišljenje → |

## 1.5 Mobilna sticky traka (< 768px)

- Dugme: **Zakaži konsultaciju** → `/zakazivanje/`
- IG dugme (ikona): `aria-label="Instagram @drfilipkatanic"`
- `aria-label` regiona: Brzo zakazivanje
- Ne prikazuje se na `/zakazivanje/` i `/admin/`.

## 1.6 CTA traka pre footera (`partials/cta-band.html` — prepisuje se)

- Znak: `logo-znak` u zlatnom okviru — `alt=""` (dekorativno)
- H2: **Zakažite konsultaciju i napravimo plan koji je pravi za Vas.**
- Pasus: Individualna konsultacija, jasni koraci i plan koji odgovara Vašoj situaciji.
- CTA: Zakaži konsultaciju → `/zakazivanje/`
- Sitno ispod dugmeta: ili pišite na Instagramu **@drfilipkatanic**
- (Citat se seli u footer; Ferona telefon i adresa se uklanjaju iz trake.)

Varijante za `cta_title` / `cta_text` (front matter) — ako developer zadrži promenljive po stranici:

| Stranica | `cta_title` | `cta_text` |
|---|---|---|
| podrazumevano (`build.py` default) | Zakažite konsultaciju i napravimo plan koji je pravi za Vas. | Individualna konsultacija, jasni koraci i plan koji odgovara Vašoj situaciji. |
| oblasti rada (IVF, PCOS, muški faktor) | IVF se ne radi po šablonu. IVF se radi po Vama. | Zakažite konsultaciju — prvo razumemo Vašu situaciju, pa pravimo plan. |
| zamrzavanje jajnih ćelija | Odluka koja zaslužuje dobar razgovor. | Nije garancija trudnoće, ali može sačuvati važnu šansu za budućnost. Razgovarajmo o tome šta ima smisla za Vas. |
| redovni pregledi | Redovan pregled je najbolji plan. | Zakažite pregled — bez odlaganja „dok nešto ne zaboli“. |
| blog / FAQ / mediji / o meni | podrazumevano | podrazumevano |

> `build.py:88–89` sada ima: `"Sledeći korak je razgovor"` / `"Za zakazivanje pregleda obratite se kontakt centru SB Ferona — ustanove u kojoj dr Filip Katanić radi."` → zameniti podrazumevanim redom iz tabele.

## 1.7 Footer (navy)

**Brend blok**
- dr Filip Katanić
- Reproduktivna medicina
- Linija ispod (sitno, zlatno): Reproduktivna medicina · IVF · Klinička istraživanja

**Kontakt red** (stavke telefon/mejl se renderuju samo ako `g.tel` / `g.email` nisu prazni)
- Telefon: `{{g.tel}}` `<!-- [POTVRDITI SA KLIJENTOM: lični telefon za sajt] -->`
- E-mail: `{{g.email}}` `<!-- [POTVRDITI SA KLIJENTOM: lični mejl za sajt] -->`
- Instagram: @drfilipkatanic
- Zakazivanje: Zakaži online → `/zakazivanje/` (prikazuje se uvek; zamenjuje telefon dok ga nema)
- Lokacija: Ordinira u SB Ferona, Šarplaninska 19, Novi Sad → Google mape

**Kolone**
- OBLASTI RADA: Vantelesna oplodnja (IVF/ICSI) · Zamrzavanje jajnih ćelija · PCOS i neplodnost · Muški faktor neplodnosti · Redovni ginekološki pregledi
- SAJT: O meni · Konsultacija · Blog · Pitanja i odgovori · Mediji i predavanja · Kontakt
- ZAKAZIVANJE: Zakaži konsultaciju → · citat (serif italic): „Ne možemo kontrolisati baš sve, ali možemo napraviti najbolji plan.“

**Pravna napomena** (`site.json` → `disclaimer`, 12px):
> Sadržaj ovog sajta je informativan i edukativan i ne zamenjuje lekarski pregled ni konsultaciju. Svaki slučaj se procenjuje individualno, a nijedan medicinski postupak ne može garantovati ishod. Konsultacije i postupci obavljaju se u SB Ferona, Novi Sad, gde dr Filip Katanić ordinira.

**Donja traka:** © {{year}} dr Filip Katanić · Politika privatnosti · Nazad na vrh ↑

`aria-label` mobilnih akordeona: koristiti naslov kolone ("Oblasti rada", "Sajt", "Zakazivanje").

## 1.8 Ostalo globalno

- 404 — H1: Stranica nije pronađena · Tekst: Stranica koju tražite ne postoji ili je premeštena. Vratite se na početnu ili zakažite konsultaciju. · CTA: Na početnu · Zakaži konsultaciju
- `<noscript>` (samo na `/zakazivanje/`, ako backend ne podrži slanje bez JS-a): Za slanje forme potreban je JavaScript. Možete nam pisati i na Instagramu @drfilipkatanic.
- Bočna CTA kartica podstranica (`partials/aside-cta.html`): H3 Zakažite konsultaciju · Pasus: Individualni plan za Vašu situaciju — bez šablona. · Dugme: Zakaži konsultaciju · Sitno: Ordinira u SB Ferona, Novi Sad
- Blog autor-boks: dr Filip Katanić · Reproduktivna medicina · Više o meni →
- Credential linija (`partials/credential.html`): Specijalista ginekologije i akušerstva · Master reproduktivni embriolog `<!-- [POTVRDITI SA KLIJENTOM: pismena potvrda titule pre objave] -->` · O meni →
- Venue traka (`partials/venue.html`): Konsultacije i postupci obavljaju se u SB Ferona, Šarplaninska 19, Novi Sad. · Link: Lokacija i mapa

---

# 2. POČETNA `/`

**Title:** dr Filip Katanić – Reproduktivna medicina, IVF i sterilitet | Novi Sad
**Meta description:** dr Filip Katanić — reproduktivna medicina, IVF i lečenje steriliteta u Novom Sadu. Individualizovan plan, jasna komunikacija i online zakazivanje konsultacije. (≈155)
**OG title:** dr Filip Katanić — Reproduktivna medicina
**OG description:** Individualizovan pristup lečenju steriliteta. Zakažite konsultaciju online.

## 2.1 Hero

- H1: **dr Filip Katanić**
- Podnaslov (zlatni serif): Reproduktivna medicina • IVF • Klinička istraživanja
- Uvod: Individualizovan pristup lečenju steriliteta zasnovan na savremenoj reproduktivnoj medicini, embriologiji i kliničkom iskustvu.
- Linija sa pin ikonom (14px): Ordinira u SB Ferona, Novi Sad
- CTA 1 (navy): Zakaži konsultaciju → `/zakazivanje/`
- CTA 2 (zlatni outline): Oblasti rada → `#oblasti`
- Kredencijali (3):
  1. Specijalista ginekologije i akušerstva `<!-- [POTVRDITI SA KLIJENTOM: pismena potvrda titule pre objave] -->`
  2. Master reproduktivni embriolog `<!-- [POTVRDITI SA KLIJENTOM: tačan naziv mastera — referenca kaže "Master reproduktivne biologije i kliničke embriologije", IG bio "Master reproduktivni embriolog"] -->`
  3. Doktorske studije — klinička istraživanja `<!-- [POTVRDITI SA KLIJENTOM: doktorske studije, Medicinski fakultet Novi Sad, prediktivno modelovanje ovarijalnog odgovora] -->`
- `aria-label` liste kredencijala: Kvalifikacije
- Alt (`hero-portret.webp` / `-mobile`): dr Filip Katanić u belom mantilu, u ordinaciji

## 2.2 Moj pristup

- Eyebrow: MOJ PRISTUP
- H2: **Ne postoji univerzalni IVF protokol.**
- Pasus: Lečenje steriliteta ne počinje istom terapijom za svakog pacijenta, već razumevanjem kompletne kliničke slike — ovarijalne rezerve, prethodnog odgovora na stimulaciju, embrioloških faktora i realne prognoze. Moj pristup zasniva se na individualizovanim terapijskim odlukama, jasnoj komunikaciji i realnom planu. IVF se ne radi po šablonu — IVF se radi po Vama.

> Napomena: sa reference je izbačena reč "Uspešno" na početku ("Uspešno lečenje steriliteta…") — bez implicitnog obećanja ishoda. Završna rečenica je njegova IG fraza.

## 2.3 Kada ima smisla da se javite?

- Eyebrow / H2 (vizuelno eyebrow): KADA IMA SMISLA DA SE JAVITE?
- `aria-label` liste: Situacije

| # | Naslov (H3) | Opis | Mikro-link | Cilj |
|---|---|---|---|---|
| 1 | Ako tek počinjete obradu steriliteta | Pravi plan od početka štedi vreme i daje jasan pravac. | Zakaži → | `?usluga=prva-konsultacija` |
| 2 | Ako imate neuspešne pokušaje iza sebe | Analiziramo prethodne cikluse i menjamo ono što je važno. | Zakaži → | `?usluga=drugo-misljenje` |
| 3 | Ako imate nizak AMH ili slab odgovor | Prilagođena strategija i realna očekivanja — bez ulepšavanja. | Zakaži → | `?usluga=ivf` |
| 4 | Ako niste sigurni da li je IVF sledeći korak | Pomažem Vam da donesete sigurnu i informisanu odluku. | Zakaži → | `?usluga=prva-konsultacija` |

> Kartica 3: referenca kaže "Strategije za poboljšanje ishoda" — preformulisano jer "poboljšanje ishoda" zvuči kao obećanje.

## 2.4 Oblasti rada (`id="oblasti"`)

- Eyebrow / H2: OBLASTI RADA

| # | Naslov (H3) | Opis | Link | Napomena |
|---|---|---|---|---|
| 1 | Sterilitet i IVF | Individualizovan pristup od dijagnostike do transfera embriona. | `/oblasti-rada/vantelesna-oplodnja-ivf/` | |
| 2 | Drugo mišljenje | Nezavisna procena dosadašnjeg lečenja i preporuka zasnovana na dokazima. | `/zakazivanje/?usluga=drugo-misljenje` | |
| 3 | Jednodnevna dijagnostika steriliteta | Ključne analize i ultrazvučni pregled organizovani u jednom danu. | `/zakazivanje/?usluga=prva-konsultacija` | `<!-- [POTVRDITI SA KLIJENTOM: da li se jednodnevna dijagnostika nudi kao poseban paket] -->` — DO potvrde developer može zameniti karticom **"Prva konsultacija" — "Razgovor, pregled i jasan plan narednih koraka."** |
| 4 | Slab odgovor na stimulaciju | Prilagođene strategije za pacijentkinje sa slabijim odgovorom jajnika. | `/oblasti-rada/vantelesna-oplodnja-ivf/#slab-odgovor` | Naslov na srpskom umesto "Poor responders" (razumljivije); u opisu može ostati u zagradi: (poor responders) |
| 5 | PCOS i poremećaji ovulacije | Dijagnostika i terapija sa fokusom na metaboličko i hormonsko zdravlje. | `/oblasti-rada/pcos-i-neplodnost/` | |
| 6 | Histeroskopija | Dijagnostička i operativna histeroskopija. | `/zakazivanje/?usluga=ginekoloski-pregled` | `<!-- [POTVRDITI SA KLIJENTOM: da li dr Katanić radi histeroskopije i da li ambulantno] -->` — DO potvrde zameniti karticom **"Redovni ginekološki pregledi" — "PAPA test, ultrazvuk i redovna kontrola — bez odlaganja."** → `/oblasti-rada/redovni-ginekoloski-pregledi/` |

- Red "Takođe": Takođe: Zamrzavanje jajnih ćelija · Muški faktor neplodnosti · Redovni ginekološki pregledi · Sve oblasti rada →
- `aria-label` reda: Ostale oblasti rada

## 2.5 Proces konsultacije 01–05

- H2 (stil eyebrow sa linijama): **Konsultacija nije samo pregled. Konsultacija je plan.**

| Br. | Naslov | Opis |
|---|---|---|
| 01 | Analiza dokumentacije | Detaljan uvid u Vašu medicinsku istoriju, prethodne nalaze i dosadašnje lečenje. |
| 02 | Ultrazvučna procena | Procena ovarijalne rezerve i reproduktivne anatomije. |
| 03 | Procena prethodnog odgovora | Razumevanje kako ste do sada odgovarali na terapiju, ako ste je imali. |
| 04 | Individualizovana strategija | Plan lečenja ili sledećeg dijagnostičkog koraka, prilagođen Vama. |
| 05 | Jasni naredni koraci | Precizan plan i preporuke za sledeće korake. `<!-- [POTVRDITI SA KLIJENTOM: da li pacijent dobija pismeni zaključak — ako da: "Pismeni zaključak sa jasnim preporukama za sledeće korake."] -->` |

- Link: Kako izgleda prva konsultacija → `/blog/prva-konsultacija-sta-poneti/`
- Dugme (outline): Zakaži konsultaciju
- Ispod (opciono, sitni serif italic): „Ne možemo kontrolisati baš sve, ali možemo napraviti najbolji plan.“

## 2.6 O meni

- Eyebrow: O MENI
- H2: **Klinička praksa, embriologija i istraživanje — povezani u jednom pristupu.**
- Pasus: Specijalista ginekologije i akušerstva sa fokusom na reproduktivnu medicinu i IVF `<!-- [POTVRDITI SA KLIJENTOM: pismena potvrda titule] -->`. Povezujem klinički rad, embriologiju i istraživanje kako bih svakoj pacijentkinji i svakom paru ponudio preciznu dijagnostiku, jasno objašnjenje i individualizovan plan lečenja.

3 kolone:

| Ikona | H3 | Tekst |
|---|---|---|
| stetoskop | Klinički rad | Lečenje steriliteta, IVF i ginekologija. Ordinira u SB Ferona, Novi Sad. `<!-- [POTVRDITI SA KLIJENTOM: "višegodišnje iskustvo" i "histeroskopska hirurgija" sa reference — ne pisati do potvrde] -->` |
| akademska kapa | Akademski rad | Master reproduktivne embriologije. Doktorske studije na Medicinskom fakultetu u Novom Sadu — prediktivno modelovanje ovarijalnog odgovora. `<!-- [POTVRDITI SA KLIJENTOM: naziv mastera i doktorske studije] -->` |
| globus | Edukacija i međunarodni rad | Predavanja i učešće na stručnim skupovima u zemlji i inostranstvu (ESHRE, GIGANODE, Thrombosis Days) i edukacija pacijenata. |

- Link: Više o meni → `/o-meni/`
- Alt (`o-meni.webp`): dr Filip Katanić za radnim stolom u ordinaciji

## 2.7 Navy traka (vrednosti) — bez brojki

- `aria-label`: Vrednosti

| Ikona | Tekst (2 reda) |
|---|---|
| kalendar | Individualni / plan |
| dve osobe | Vreme za razgovor / i pitanja |
| embrion | Embriološka / perspektiva |
| materica | Odluke zasnovane / na dokazima |
| knjiga | Edukacija / pacijenata |

## 2.8 Nauka i edukacija

- Eyebrow / H2: NAUKA I EDUKACIJA
- Pločice (sve → `/mediji-i-predavanja/#konferencije`):

| Naziv | Podnaslov | Napomena |
|---|---|---|
| ESHRE | Evropski kongres reproduktivne medicine | potvrđeno (prisustvo) |
| GIGANODE | Međunarodni panel, Švajcarska | potvrđeno |
| Thrombosis Days | Predavanje, Švajcarska | potvrđeno |
| SPRING Fertility | Stručna konferencija | `<!-- [POTVRDITI SA KLIJENTOM: status i datum učešća] -->` |
| Bio Save | Predavanja za buduće mame | potvrđeno (bedž na IMG_1740) |
| Divčibare | Predavanje, stručni seminar | potvrđeno |

- HTML komentar (ne vidljivo): `<!-- [POTVRDITI SA KLIJENTOM: učešće na Weill Cornell Seminar Salzburg, LH in ART Sorrento, MSRM Bari — sa reference; dodati pločice tek po potvrdi] -->`
- Link: Mediji i predavanja →
- Opciona slika: Alt (`konferencija-panel.webp`): dr Filip Katanić kao panelista na edukativnom skupu Bio Save — Bebologijini krugovi · Natpis: Bio Save, Bebologijini krugovi

## 2.9 Journal

- Eyebrow / H2: JOURNAL

| # | Naslov kartice | Jedna rečenica (opciono, ispod naslova; na desktopu može da se sakrije) | Link | Alt slike |
|---|---|---|---|---|
| 1 | Koliko jajnih ćelija je potrebno za embrion? | Zašto broj ćelija prirodno opada od punkcije do blastociste — i zašto to nije razlog za paniku. | `/blog/koliko-jajnih-celija-je-potrebno-za-embrion/` | Naslovna kartica članka: Koliko jajnih ćelija je potrebno za embrion |
| 2 | Šta se zaista dešava tokom IVF postupka? | IVF nije jedan pokušaj, već niz odluka — korak po korak, bez ulepšavanja. | `/blog/sta-se-zaista-desava-tokom-ivf-postupka/` | Naslovna kartica članka: Šta se zaista dešava tokom IVF postupka |
| 3 | Prva konsultacija — šta poneti | Kratak checklist da prvi razgovor bude konkretan i bez stresa. | `/blog/prva-konsultacija-sta-poneti/` | Naslovna kartica članka: Pre straha — činjenice. Pre odluke — plan. |

- Linkovi ispod: Svi članci → · Pitanja i odgovori →
- Labela na kartici: Pročitaj više →

## 2.10 CTA traka
Vidi §1.6.

---

# 3. `/zakazivanje/`

**Title:** Zakažite konsultaciju – dr Filip Katanić | Novi Sad
**Meta description:** Pošaljite zahtev za konsultaciju kod dr Filipa Katanića — reproduktivna medicina, IVF i sterilitet. Potvrdu termina dobijate mejlom. Ordinira u Novom Sadu. (≈150)
**Breadcrumb:** Početna / Zakazivanje

## 3.1 Zaglavlje stranice

- Eyebrow: ZAKAZIVANJE
- H1: **Zakažite konsultaciju**
- Lead: Pošaljite zahtev za termin — javiću Vam se sa potvrdom ili predlogom drugog termina. Popunjavanje traje oko dva minuta.
- Napomena iznad forme (12px): Polja označena * su obavezna.
- Oznaka predizbora (kad postoji `?usluga=`): Izabrano: {labela usluge} · promeni

> Alternativa za lead, ako klijent želi "mi" formu (tim/asistent odgovara): "…javićemo Vam se sa potvrdom…". `[POTVRDITI SA KLIJENTOM: ko odgovara na zahteve — lično doktor ili asistent]`

## 3.2 Forma — fieldset naslovi

1. VAŠI PODACI
2. TERMIN I RAZLOG
3. DODATNO (opciono)

## 3.3 Polja (tačno po API ugovoru, brief-v2 §4)

| `name` | Labela | Placeholder | Hint (ispod polja) | Greška (klijent / server `fields`) |
|---|---|---|---|---|
| `ime_prezime` * | Ime i prezime | npr. Jelena Petrović | — | Prazno: Unesite ime i prezime. · Prekratko: Ime mora imati bar 2 znaka. · Predugo: Ime može imati najviše 100 znakova. |
| `email` * | E-mail | ime@primer.rs | Na ovu adresu stiže potvrda termina. | Prazno: Unesite e-mail adresu. · Format: E-mail adresa nije ispravna — proverite da li sadrži @ i domen. |
| `telefon` * | Telefon | 06x xxx xxxx | Za slučaj da je potrebno da Vas kontaktiramo pre potvrde. | Prazno: Unesite broj telefona. · Format: Broj telefona nije ispravan — unesite 6 do 20 cifara. |
| `kontakt_kanal` * (legend) | Kako da Vas kontaktiramo? | — | Izaberite kanal koji Vam najviše odgovara. | Izaberite način kontakta. |
| `tip_usluge` * | Razlog konsultacije | (prva opcija, disabled) Izaberite… | — | Izaberite razlog konsultacije. |
| `zeljeni_datum` * | Željeni datum | — | Okvirni datum — tačan termin potvrđujemo mejlom. | Prazno: Izaberite željeni datum. · Prošlost: Datum ne može biti u prošlosti. · Predaleko: Izaberite datum u narednih 6 meseci. |
| `doba_dana` (legend) | Doba dana | — | — | Izaberite jednu od ponuđenih opcija. |
| `partner_ime` | Ime partnera (opciono) | — | Ako na konsultaciju dolazite zajedno. | Ime partnera može imati najviše 100 znakova. |
| `dokumentacija_status` (legend) | Da li imate prethodne nalaze? (opciono) | — | Hormonske analize, ultrazvuk, spermogram, izveštaji o ranijim postupcima. | Izaberite jednu od ponuđenih opcija. |
| `napomena` | Napomena (opciono) | Npr. prethodni postupci, AMH, pitanja koja želite da postavite… | Ne morate slati detaljne medicinske podatke — o tome razgovaramo na konsultaciji. | Napomena može imati najviše 2000 znakova. |
| brojač napomene | `{n} / 2000` · `aria-live` tekst posle 1800: Preostalo je još {2000-n} znakova. | | | |
| `saglasnost` * | (tekst u §3.5) | — | — | Za slanje zahteva potrebna je Vaša saglasnost. |
| `website` (honeypot) | Ne popunjavati | — | — | (server tiho odbacuje; korisniku ništa) |
| `csrf_token` | hidden | — | — | Server: vidi §3.7 "Sesija je istekla" |

## 3.4 Opcije

**`kontakt_kanal`** (chip-ovi, bez predizbora)
| Vrednost | Labela |
|---|---|
| `telefon` | Telefonski poziv |
| `viber` | Viber |
| `whatsapp` | WhatsApp |
| `email` | E-mail |

**`tip_usluge`** (select; `?usluga=` predizbor)
| Vrednost | Labela |
|---|---|
| `prva-konsultacija` | Prva konsultacija |
| `drugo-misljenje` | Drugo mišljenje (analiza dokumentacije) |
| `ivf` | Sterilitet i vantelesna oplodnja (IVF/ICSI) |
| `zamrzavanje-jajnih-celija` | Zamrzavanje jajnih ćelija |
| `pcos` | PCOS i poremećaji ovulacije |
| `muski-faktor` | Muški faktor neplodnosti |
| `ginekoloski-pregled` | Ginekološki pregled |
| `ostalo` | Nešto drugo |

> Backend `helpers.php` ima kraće labele (npr. "IVF / vantelesna oplodnja", "PCOS", "Ostalo") — preporuka: uskladiti sa ovom tabelom da mejl i admin govore istim jezikom kao forma.

**`doba_dana`** (segment, default `svejedno`)
| `pre-podne` | Pre podne |
| `posle-podne` | Posle podne |
| `svejedno` | Svejedno |

**`dokumentacija_status`** (segment, bez defaulta)
| `imam` | Imam |
| `delimicno` | Delimično |
| `nemam` | Nemam |

(U adminu i mejlu duža forma: Imam nalaze / Delimično / Nemam nalaze.)

## 3.5 Saglasnost

☐ Saglasan/na sam da se moji podaci koriste isključivo za zakazivanje konsultacije, u skladu sa [Politikom privatnosti](/politika-privatnosti/). *

(Link otvara u novom tabu: `target="_blank" rel="noopener"`; `aria-describedby` na hint ispod dugmeta.)

## 3.6 Dugme i stanja

- Dugme: **Pošalji zahtev** →
- Ispod dugmeta (lokot ikona, 13px): Podaci se koriste samo za zakazivanje i ne dele se sa trećim licima.
- Slanje: dugme → "Šaljem…" (spinner), `aria-busy`.

**Uspeh** (panel menja formu, `role="status"`)
- H2: **Hvala, zahtev je primljen.**
- Pasus: Ovo još nije potvrđen termin. Potvrdu termina — ili predlog drugog, ako željeni nije slobodan — dobijate mejlom na **{email}**.
- Sitno: Ako ne vidite poruku u narednih nekoliko minuta, proverite i folder za neželjenu poštu (spam). · Broj zahteva: **#{id}**
- Dugmad: Nazad na početnu · Pročitajte: Prva konsultacija — šta poneti

**Uspeh bez JS-a** (`?poslato=1`): isti tekst, bez broja zahteva i bez adrese.

## 3.7 Greške

| Situacija | Tekst |
|---|---|
| Error summary naslov (1 polje) | Proverite jedno polje: |
| Error summary naslov (više) | Proverite {n} polja: |
| Opšta (server `error` bez detalja / 500) | Zahtev trenutno nije moguće poslati. Pokušajte ponovo za nekoliko minuta ili nam pišite na Instagramu @drfilipkatanic. |
| Mreža / offline | Zahtev nije poslat — proverite internet vezu i pokušajte ponovo. Podaci koje ste uneli su sačuvani u formi. |
| 429 (rate limit) | Previše pokušaja u kratkom roku. Pokušajte ponovo za nekoliko minuta ili nam pišite na Instagramu. |
| CSRF / istekla sesija | Sesija je istekla. Osvežili smo formu — kliknite ponovo na „Pošalji zahtev“. (podaci ostaju) |
| Honeypot popunjen | (bez poruke korisniku — server vraća generički uspeh ili opštu grešku, po izboru backenda) |
| Server greška po polju | Prikazati tekst iz `fields.{polje}` ispod polja; ako je prazan → tekst iz tabele §3.3 |

Predlog srpskih poruka koje backend vraća u `fields` (da front i back budu isti): koristiti tačno tekstove iz kolone "Greška" u §3.3.

## 3.8 Bočni panel "Šta očekivati"

**Kartica 1 — doktor**
- Alt (`portret-mantil.webp`, oval): dr Filip Katanić
- dr Filip Katanić
- Reproduktivna medicina

**Kartica 2 — ŠTA OČEKIVATI**
1. 01 Analiza dokumentacije
2. 02 Ultrazvučna procena
3. 03 Procena prethodnog odgovora
4. 04 Individualizovana strategija
5. 05 Jasni naredni koraci
- Link: Prva konsultacija — šta poneti →

**Kartica 3 — MESTO ORDINIRANJA**
- SB Ferona
- Šarplaninska 19, 21000 Novi Sad
- Otvori u Google mapama →

**Kartica 4 — info (ikona i)**
- Ovo je zahtev, ne potvrđen termin. Potvrdu dobijate mejlom.

**Telefon (`<details>`):** summary: Šta očekivati? — sadržaj kartica 2 i 3. Ispod forme: lokacija + Instagram @drfilipkatanic.

## 3.9 Mini FAQ o zakazivanju (ispod forme ili posle panela)

- H2: Pitanja o zakazivanju

**P: Kada ću dobiti potvrdu termina?**
O: Zahtev pregledam lično i odgovaram što pre. Potvrdu sa tačnim datumom i vremenom — ili predlog drugog termina — dobijate mejlom. `[POTVRDITI SA KLIJENTOM: okvirni rok odgovora, npr. "u roku od 1–2 radna dana" — do potvrde bez roka]`

**P: Šta ako mi željeni datum ne odgovara kasnije?**
O: Željeni datum je okviran. Ako Vam se planovi promene, samo odgovorite na mejl koji dobijete posle slanja zahteva i dogovorićemo drugi termin.

**P: Da li moram da imam nalaze da bih zakazala konsultaciju?**
O: Ne. Ako ih imate, ponesite ih — razgovor je tada konkretniji. Ako ih nemate, na konsultaciji dogovaramo koje analize ima smisla uraditi.

**P: Koliko košta konsultacija?**
O: Cena zavisi od vrste konsultacije i individualnog plana — informaciju dobijate pri potvrdi termina. `[POTVRDITI SA KLIJENTOM: da li se cena navodi u mejlu potvrde ili usmeno]`

> Napomena za rod: pitanje 3 je u ženskom rodu ("zakazala") jer su pacijentkinje većina čitalaca; neutralna alternativa: "Da li su mi potrebni nalazi pre zakazivanja?"

---

# 4. `/kontakt/` i `/o-meni/`

## 4.1 `/kontakt/`

**Title:** Kontakt – dr Filip Katanić | Novi Sad
**Meta description:** Zakažite konsultaciju kod dr Filipa Katanića online ili preko Instagrama. Ordinira u SB Ferona, Šarplaninska 19, Novi Sad.
**Breadcrumb:** Početna / Kontakt

- Eyebrow: KONTAKT
- H1: **Kontakt**
- Lead: Najbrži put do termina je online zahtev. Za kratko pitanje pre zakazivanja možete mi pisati i na Instagramu.

**Navy kartica (glavna)**
- Eyebrow: ZAKAZIVANJE
- H2: Zakažite konsultaciju online
- Pasus: Popunite kratak zahtev — potvrdu ili predlog termina dobijate mejlom.
- Dugme (zlatno): Zakaži konsultaciju →

**Kanali (desno)**
- Instagram — @drfilipkatanic → · sitno: Za kratka pitanja pre zakazivanja.
- Telefon — `{{g.tel}}` (render samo ako postoji) `<!-- [POTVRDITI SA KLIJENTOM: lični telefon] -->`
- E-mail — `{{g.email}}` (render samo ako postoji) `<!-- [POTVRDITI SA KLIJENTOM: lični mejl] -->`

**Sekcija lokacija**
- Eyebrow / H2: MESTO ORDINIRANJA
- SB Ferona
- Šarplaninska 19
- 21000 Novi Sad
- Pasus: Konsultacije i postupci obavljaju se u SB Ferona.
- Link: Otvori u Google mapama →
- Opciono sitno (samo ako klijent odobri): Termin možete zakazati i preko kontakt centra SB Ferona: +381 21 3000 220. `[POTVRDITI SA KLIJENTOM: da li želi ovu sekundarnu opciju]`
- Mapa — dugme fasade: Učitaj mapu · `title` iframe-a: Mapa: SB Ferona, Šarplaninska 19, Novi Sad
- Sitno ispod dugmeta mape: Mapa se učitava sa Google servisa tek kada kliknete.

**Napomena (sitno, ispod svega):** Za hitna stanja obratite se najbližoj hitnoj službi — forma i poruke nisu namenjene hitnim slučajevima.

## 4.2 `/o-meni/`

**Title:** O meni – dr Filip Katanić | Reproduktivna medicina, Novi Sad
**Meta description:** dr Filip Katanić — specijalista ginekologije i akušerstva, master reproduktivni embriolog. Klinički rad, istraživanje i edukacija. Ordinira u SB Ferona u Novom Sadu. (≈155) `<!-- [POTVRDITI: titula] -->` — do potvrde rezervna meta: "dr Filip Katanić — reproduktivna medicina, embriologija i klinička istraživanja. Pristup, obrazovanje i predavanja. Ordinira u SB Ferona u Novom Sadu."
**Breadcrumb:** Početna / O meni

### Hero
- Eyebrow: O MENI
- H1: **dr Filip Katanić**
- Podnaslov (zlatni): Specijalista ginekologije i akušerstva · Master reproduktivni embriolog `<!-- [POTVRDITI SA KLIJENTOM: pismena potvrda titule i naziv mastera] -->`
- Lead: Reproduktivna medicina traži strpljenje, jasnoću i razumevanje. Ovde možete pročitati ko sam, kako radim i zašto verujem da je dobar plan važniji od obećanja.
- CTA: Zakaži konsultaciju
- Alt (`portret-mantil.webp`): dr Filip Katanić u belom mantilu, portret

### Ko sam ja
- Eyebrow: KO SAM JA
- H2: Lekar koji razume da je put do roditeljstva retko pravolinijski.
- Pasus 1: Ja sam Filip Katanić. Bavim se reproduktivnom medicinom — dijagnostikom i lečenjem steriliteta, vantelesnom oplodnjom i ginekologijom. Ordiniram u SB Ferona u Novom Sadu.
- Pasus 2: Kao master reproduktivni embriolog, IVF posmatram i iz ugla laboratorije: šta se dešava sa svakom ćelijom i embrionom, i zašto se brojevi kroz postupak prirodno menjaju. To mi pomaže da pacijentima objasnim ne samo šta radimo, već i zašto.
- Pasus 3: Sterilitet je za mnoge parove tema koja nosi tišinu, pa i krivicu. Infertilitet nije „samo stres“ i niko ne treba da nosi osećaj krivice jer „nije bio dovoljno opušten“. Moj posao je da informacije budu jasne, a briga ljudska.
- Pasus 4: Deo mog rada odvija se i kroz projekat „Moj ginekolog“ Doma zdravlja Novi Sad — verujem da informisanost i dostupnost idu zajedno.
- Alt (`o-meni.webp`): dr Filip Katanić za radnim stolom u ordinaciji

### Obrazovanje i rad (vertikalni timeline)
- Eyebrow: OBRAZOVANJE I AFILIJACIJE
- H2: Obrazovanje i rad
1. **Doktor medicine** — Medicinski fakultet `<!-- [POTVRDITI SA KLIJENTOM: ustanova i godina] -->` (vidljivo do potvrde samo: "Doktor medicine")
2. **Specijalista ginekologije i akušerstva** `<!-- [POTVRDITI SA KLIJENTOM: pismena potvrda titule; javni akademski profili navode status specijalizanta] -->`
3. **Master reproduktivne embriologije** — MSc in Reproductive Embryology `<!-- [POTVRDITI: tačan naziv i ustanova] -->`
4. **Doktorske studije** — Medicinski fakultet Univerziteta u Novom Sadu; istraživanje u oblasti prediktivnog modelovanja ovarijalnog odgovora `<!-- [POTVRDITI SA KLIJENTOM] -->`
5. **Ordinira u SB Ferona, Novi Sad** — reproduktivna medicina i IVF `<!-- [POTVRDITI SA KLIJENTOM: status — zaposlen / saradnik; vidljiva formulacija "ordinira" je neutralna] -->`
6. **Projekat „Moj ginekolog“** — Dom zdravlja Novi Sad

### Kako radim
- Eyebrow: PRISTUP
- H2: IVF se ne radi po šablonu. IVF se radi po Vama.
- Citat: „Ne možemo kontrolisati baš sve, ali možemo napraviti najbolji plan.“
- Pasus 1: Svaki plan počinje razgovorom, ne protokolom. Ovarijalna rezerva, prethodni odgovor na terapiju, nalazi partnera i Vaša očekivanja — sve to ulazi u odluku.
- Pasus 2: Ne pobeđuje onaj ko uradi najviše analiza. Pobeđuje onaj ko uradi prave. Zato predlažem samo ono što ima smisla za Vašu situaciju — i objašnjavam zašto.
- Pasus 3: Nijedan medicinski postupak ne može garantovati ishod. Ono što mogu da obećam jeste jasan plan, iskrene informacije i vreme za Vaša pitanja.

### Nauka i edukacija / van ordinacije
- Eyebrow: NAUKA I EDUKACIJA
- H2: Van ordinacije
- Pasus: Predavanja i učešće na stručnim skupovima deo su stalnog praćenja struke — od međunarodnih kongresa do edukacije budućih mama.
- Pločice: iste kao §2.8
- Lista (kratko):
  - Thrombosis Days, Švajcarska — predavanje iz ugla IVF-a
  - GIGANODE International Panel, Švajcarska — „Infertility and Indications for Assisted Reproduction“
  - ESHRE — kongres Evropskog udruženja za humanu reprodukciju i embriologiju
  - Stručni seminar, Divčibare — predavanje o peripartalnom krvarenju iz akušerske perspektive
  - Bio Save — serija predavanja za buduće mame (Bebologijini krugovi)
  - SPRING Fertility `<!-- [POTVRDITI SA KLIJENTOM: status i datum] -->`
- Edukacija pacijentkinja (pasus): Na Instagramu @drfilipkatanic redovno objavljujem edukativni sadržaj — o IVF-u, PCOS-u, zamrzavanju jajnih ćelija i muškom faktoru — jer verujem da informisan pacijent donosi mirnije i sigurnije odluke.
- Link: Mediji i predavanja →
- Alt (`konferencija-panel.webp`): dr Filip Katanić kao panelista na skupu Bio Save — Bebologijini krugovi `<!-- [POTVRDITI: titula na bedžu] -->`

### Lični deo ("Ja sam i…")
- Eyebrow: JA SAM I…
- H2: Iza mantila
- Pasus: Van ordinacije sam suprug, otac i neko ko rado uzme gitaru u ruke. Možda baš zato dobro razumem koliko porodica znači — i koliko je važno da put do nje bude vođen sa pažnjom.
- (Bez imena, fotografija porodice i drugih detalja. `[POTVRDITI SA KLIJENTOM: da li želi lični deo na sajtu]`)

### CTA
- §1.6 (podrazumevana CTA traka).

---

# 5. Zamene "Ferona kao vlasnik → lični brend" (za developera)

Pravilo: interne HTML komentare `[POTVRDITI…]` koji pominju Feronu NE menjati. Sve zamene ispod su vidljivi tekst, front matter ili podaci. Ako stari tekst više ne postoji jer se sekcija briše (početna, booking), stoji "UKLONITI".

## 5.1 Partiali

| Fajl | Stari tekst | Novi tekst |
|---|---|---|
| `src/partials/header.html:5` | `<span class="brand__sub">Ginekologija · IVF</span>` | `<span class="brand__sub">Reproduktivna medicina</span>` |
| `src/partials/header.html:27` | `href="{{root}}kontakt/#zakazivanje">Zakažite u SB Feroni</a>` | `href="{{root}}zakazivanje/">Zakaži konsultaciju</a>` |
| `src/partials/header.html:28` | `<a class="hdr-tel" href="{{g.tel_href}}" aria-label="Pozovite {{g.tel}}">…</a>` | UKLONITI (ili render samo ako `g.tel` doktora postoji; `aria-label="Pozovite {{g.tel}}"`) |
| `src/partials/header.html:54` | `<a class="btn btn--gold" href="{{g.tel_href}}">Zakažite u SB Feroni</a>` | `<a class="btn btn--gold" href="{{root}}zakazivanje/">Zakaži konsultaciju</a>` |
| `src/partials/header.html:55` | `Poruka dr Kataniću na Instagramu` | `Instagram @drfilipkatanic` |
| `src/partials/header.html:56` | `{{g.ferona}} · {{g.adresa}} · {{g.tel}}` | `Ordinira u SB Ferona, Novi Sad` (ili `{{g.ordinira}}`) |
| `src/partials/sticky-bar.html:2` | `<a class="btn btn--gold" href="{{g.tel_href}}">Zakažite u SB Feroni</a>` | `<a class="btn btn--gold" href="{{root}}zakazivanje/">Zakaži konsultaciju</a>` |
| `src/partials/sticky-bar.html:3` | `Poruka na Instagramu` | (ikona) `aria-label="Instagram @drfilipkatanic"` |
| `src/partials/sticky-bar.html:1` | `aria-label="Brzi kontakt"` | `aria-label="Brzo zakazivanje"` |
| `src/partials/cta-band.html:7` | `href="{{root}}kontakt/#zakazivanje">Zakažite u SB Feroni</a>` | `href="{{root}}zakazivanje/">Zakaži konsultaciju</a>` |
| `src/partials/cta-band.html:8` | `Poruka na Instagramu` (dugme) | sitno ispod dugmeta: `ili pišite na Instagramu @drfilipkatanic` |
| `src/partials/cta-band.html:10` | `<a href="{{g.tel_href}}">{{g.tel}}</a> · {{g.ferona}}, {{g.adresa}}` | UKLONITI |
| `src/partials/cta-band.html:11` | `{{g.citat}}` | UKLONITI iz trake (citat ide u footer) |
| `src/partials/footer.html:6` | `Kontakt / Ustanova` | UKLONITI naslov (kontakt red iz §1.7) |
| `src/partials/footer.html:8` | `{{g.ferona}}<br>{{g.adresa}}` | `Ordinira u SB Ferona, Šarplaninska 19, Novi Sad` (link na `{{g.maps_url}}`) |
| `src/partials/footer.html:9` | Ferona tel + mejl | `{{g.tel}}` / `{{g.email}}` doktora — render samo ako nisu prazni; inače `Zakaži online →` (`/zakazivanje/`) |
| `src/partials/footer.html:10` | `Kontakt centar ustanove — za zakazivanje pregleda kod dr Filipa Katanića.` | UKLONITI |
| `src/partials/footer.html:11` | `Instagram {{g.ig_handle}}` | `Instagram {{g.ig_handle}}` (ostaje) |
| `src/partials/footer.html:16` | `Lekar · Master reproduktivne embriologije · Član tima SB Ferona` | `Reproduktivna medicina · IVF · Klinička istraživanja` |
| `src/partials/footer.html:25–26` | `Muški faktor` / `Redovni pregledi` | `Muški faktor neplodnosti` / `Redovni ginekološki pregledi` (opciono, kao §1.7) |
| `src/partials/footer.html:31–37` (kolona Sajt) | O meni · Pitanja i odgovori · Blog · Mediji i predavanja · Kontakt | O meni · Konsultacija (`/zakazivanje/`) · Blog · Pitanja i odgovori · Mediji i predavanja · Kontakt |
| `src/partials/credential.html:1` | `Lekar · Master reproduktivne embriologije · Član tima SB Ferona` | `Specijalista ginekologije i akušerstva · Master reproduktivni embriolog` + `<!-- [POTVRDITI SA KLIJENTOM: pismena potvrda titule pre objave] -->` |
| `src/partials/venue.html:1` | `Postupci se sprovode u okviru {{g.ferona}}, {{g.adresa}}.` · `Kontakt i mapa` | `Konsultacije i postupci obavljaju se u SB Ferona, Šarplaninska 19, Novi Sad.` · `Lokacija i mapa` |
| `src/partials/venue-card.html:3` | `{{g.ferona}}` (eyebrow) | eyebrow `Mesto ordiniranja` + ispod `SB Ferona` |

## 5.2 Stranice

| Fajl | Stari tekst | Novi tekst |
|---|---|---|
| `src/pages/index.html:2` (title) | `dr Filip Katanić – Reproduktivna medicina · IVF · Klinička istraživanja \| Novi Sad` | `dr Filip Katanić – Reproduktivna medicina, IVF i sterilitet \| Novi Sad` |
| `src/pages/index.html:3` (description) | `Dr Filip Katanić, doktor medicine, master reproduktivne embriologije i član tima SB Ferona u Novom Sadu. Racionalna dijagnostika, individualni IVF protokoli i podrška bez obećanja.` | `dr Filip Katanić — reproduktivna medicina, IVF i lečenje steriliteta u Novom Sadu. Individualizovan plan, jasna komunikacija i online zakazivanje konsultacije.` |
| `src/pages/index.html:13` | `Fokus na preciznu dijagnostiku, individualizovane protokole stimulacije i racionalan pristup lečenju steriliteta u okviru tima Specijalne bolnice Ferona.` | `Individualizovan pristup lečenju steriliteta zasnovan na savremenoj reproduktivnoj medicini, embriologiji i kliničkom iskustvu.` + red `Ordinira u SB Ferona, Novi Sad` |
| `src/pages/index.html:15–18` | pill `SB Ferona, Novi Sad` | UKLONITI (zamenjuju ga 3 kredencijala §2.1) |
| `src/pages/index.html:80` | `Ključna polja kliničkog i stručnog delovanja u okviru tima Specijalne bolnice Ferona.` | UKLONITI pasus |
| `src/pages/index.html:171` | `Rad u okviru tima Specijalne bolnice Ferona u Novom Sadu — praćenje stimulacije ovulacije, ultrazvučna dijagnostika i individualizovano vođenje postupka.` | `Lečenje steriliteta, IVF i ginekologija. Ordinira u SB Ferona, Novi Sad.` |
| `src/pages/index.html:233–439` | booking sekcija (`Konsultacije se obavljaju u Specijalnoj bolnici Ferona…`, `Zainteresovani smo za jednodnevnu dijagnostiku u SB Ferona`, `{{g.tel}} (SB Ferona)`, WA/Viber broj) | UKLONITI celu sekciju (forma → `/zakazivanje/`) |
| `src/pages/kontakt.html:2` (title) | `Kontakt i zakazivanje – dr Filip Katanić, SB Ferona` | `Kontakt – dr Filip Katanić \| Novi Sad` |
| `src/pages/kontakt.html:3` (description) | `Zakazivanje pregleda kod dr Filipa Katanića u SB Ferona, Šarplaninska 19, Novi Sad. Telefon +381 21 3000 220, office@ferona.rs.` | `Zakažite konsultaciju kod dr Filipa Katanića online ili preko Instagrama. Ordinira u SB Ferona, Šarplaninska 19, Novi Sad.` |
| `src/pages/kontakt.html:11` | `Kontakt i zakazivanje` (H1) | `Kontakt` |
| `src/pages/kontakt.html:13–16` | tile `Zakažite u SB Feroni` / `{{g.tel}} · kontakt centar ustanove` | navy kartica §4.1: `Zakažite konsultaciju online` / `Popunite kratak zahtev — potvrdu ili predlog termina dobijate mejlom.` / dugme `Zakaži konsultaciju →` (`/zakazivanje/`) |
| `src/pages/kontakt.html:18–19` | `Poruka na Instagramu` / `Za pitanje pre zakazivanja — neformalni kanal zakazivanja` | `Instagram` / `@drfilipkatanic — za kratka pitanja pre zakazivanja` |
| `src/pages/kontakt.html:22` | `Kontakt centar SB Ferona — za zakazivanje pregleda kod dr Filipa Katanića. Telefon i email pripadaju ustanovi.` | UKLONITI |
| `src/pages/kontakt.html:29` | `SB Ferona` (skriveni H2) | `Mesto ordiniranja` (vidljiv eyebrow/H2) |
| `src/pages/kontakt.html:34` | `{{g.tel}}` / `{{g.email}}` (Ferona) | UKLONITI; umesto: `Konsultacije i postupci obavljaju se u SB Ferona.` |
| `src/pages/kontakt.html:35` | `Za pitanja možete pisati i na {{g.email}} (email ustanove).` | UKLONITI |
| `src/pages/o-meni.html:2` (title) | `O meni – dr Filip Katanić, doktor medicine \| SB Ferona, Novi Sad` | `O meni – dr Filip Katanić \| Reproduktivna medicina, Novi Sad` |
| `src/pages/o-meni.html:3` (description) | `Doktor medicine, master reproduktivne embriologije, član tima Specijalne bolnice Ferona u Novom Sadu. Obrazovanje, afilijacije i pristup radu.` | vidi §4.2 meta |
| `src/pages/o-meni.html:13` | `Ginekologija i vantelesna oplodnja zahtevaju strpljenje, jasnoću i razumevanje. Ovde možete pročitati nešto više o tome kako radim i gde.` | §4.2 hero lead |
| `src/pages/o-meni.html:15` | `href="{{root}}kontakt/#zakazivanje">Zakažite u SB Feroni</a>` | `href="{{root}}zakazivanje/">Zakaži konsultaciju</a>` |
| `src/pages/o-meni.html:32` | `Ja sam Filip Katanić, doktor medicine. Bavim se ginekologijom, sa fokusom na dijagnostiku i lečenje steriliteta i vantelesnu oplodnju, u okviru tima SB Ferona u Novom Sadu.` | `Ja sam Filip Katanić. Bavim se reproduktivnom medicinom — dijagnostikom i lečenjem steriliteta, vantelesnom oplodnjom i ginekologijom. Ordiniram u SB Ferona u Novom Sadu.` |
| `src/pages/o-meni.html:44` | `Član tima SB Ferona, Novi Sad` | `Ordinira u SB Ferona, Novi Sad` |
| `src/pages/o-meni.html:48` | `Prema javno dostupnim izvorima, obrazovanje je povezano sa Medicinskim fakultetom u Novom Sadu — ova informacija je u postupku potvrde.` | UKLONITI (zamenjuje timeline §4.2) |
| `src/pages/oblasti-rada/vantelesna-oplodnja-ivf.html:19` | `href="{{root}}kontakt/#zakazivanje">Zakažite u SB Feroni</a>` | `href="{{root}}zakazivanje/?usluga=ivf">Zakaži konsultaciju</a>` |
| `src/pages/oblasti-rada/zamrzavanje-jajnih-celija.html:19` | isto | `href="{{root}}zakazivanje/?usluga=zamrzavanje-jajnih-celija">Zakaži konsultaciju</a>` |
| `src/pages/oblasti-rada/pcos-i-neplodnost.html:19` | isto | `href="{{root}}zakazivanje/?usluga=pcos">Zakaži konsultaciju</a>` |
| `src/pages/oblasti-rada/muski-faktor-neplodnosti.html:19` | isto | `href="{{root}}zakazivanje/?usluga=muski-faktor">Zakaži konsultaciju</a>` |
| `src/pages/oblasti-rada/redovni-ginekoloski-pregledi.html:19` | isto | `href="{{root}}zakazivanje/?usluga=ginekoloski-pregled">Zakaži konsultaciju</a>` |
| `src/pages/oblasti-rada/index.html:9` | `Pregled oblasti u kojima dr Filip Katanić radi, u okviru tima SB Ferona.` | `Pregled oblasti u kojima dr Filip Katanić radi — od dijagnostike steriliteta do redovnih pregleda.` |
| `src/pages/oblasti-rada/index.html:51` | `aria-label="SB Ferona"` | `aria-label="Mesto ordiniranja"`; tekst sekcije: `Konsultacije i postupci obavljaju se u SB Ferona, Šarplaninska 19, Novi Sad.` |
| `src/pages/oblasti-rada/zamrzavanje-jajnih-celija.html:74` | `Cenu ne objavljujemo na sajtu jer zavisi od individualnog plana. Za konkretne informacije obratite se kontakt centru SB Ferona.` | `Cenu ne objavljujemo na sajtu jer zavisi od individualnog plana. Informacije o ceni dobijate pri zakazivanju konsultacije.` |
| `src/pages/pitanja-i-odgovori.html:49` | isto kao gore | isto kao gore (tekst mora biti identičan i u FAQPage JSON-LD) |
| `src/pages/blog/prva-konsultacija-sta-poneti.html:53` | `href="{{root}}kontakt/#zakazivanje">Zakažite u SB Feroni</a>` | `href="{{root}}zakazivanje/?usluga=prva-konsultacija">Zakaži konsultaciju</a>` |
| `src/pages/politika-privatnosti.html:3` (description) | `Kako se štite podaci posetilaca sajta i pacijenata. Testimonijali se objavljuju isključivo uz saglasnost pacijentkinje.` | `Kako se obrađuju podaci iz forme za zakazivanje i podaci posetilaca sajta dr Filipa Katanića.` |
| `src/pages/politika-privatnosti.html:11` | `Ne prikupljamo medicinske podatke putem sajta.` | `Analitika ne prikuplja Vaše ime, kontakt ni medicinske podatke.` |
| `src/pages/politika-privatnosti.html:14–15` | H2 `Kontakt i poruke` + `Poruke poslate putem Instagrama ili telefonskog poziva ka kontakt centru SB Ferona obrađuju se u skladu sa praksom te ustanove. Ovaj sajt trenutno ne sadrži kontakt formular sa ličnim/medicinskim podacima.` | Nova sekcija — vidi §5.4 |
| `src/pages/politika-privatnosti.html:22` | `Ovaj sajt je informativnog karaktera i ne predstavlja elektronski karton pacijenta. Za pitanja o čuvanju medicinskih podataka obratite se direktno SB Feroni.` | `Sajt ne predstavlja elektronski karton pacijenta. Podaci iz forme čuvaju se samo onoliko koliko je potrebno za zakazivanje (vidi gore). Medicinska dokumentacija nastala tokom lečenja vodi se u ustanovi u kojoj se lečenje obavlja, u skladu sa propisima.` |
| `src/pages/_kit.html:44` | `Zakažite u SB Feroni` | `Zakaži konsultaciju` |

## 5.3 Podaci i build

| Fajl | Stari tekst | Novi tekst |
|---|---|---|
| `src/data/site.json` `tel` | `+381 21 3000 220` | `""` (+ `"_napomena": "[POTVRDITI] lični telefon/mejl dr Katanića — prazno = ne prikazuje se"`) |
| `src/data/site.json` `tel_href` | `tel:+381213000220` | `""` |
| `src/data/site.json` `email` | `office@ferona.rs` | `""` |
| `src/data/site.json` `disclaimer` | `Sadržaj sajta je informativan i edukativan i ne zamenjuje pregled ili konsultaciju lekara. Postupci se sprovode u okviru Specijalne bolnice Ferona. Svaki slučaj se procenjuje individualno.` | `Sadržaj ovog sajta je informativan i edukativan i ne zamenjuje lekarski pregled ni konsultaciju. Svaki slučaj se procenjuje individualno, a nijedan medicinski postupak ne može garantovati ishod. Konsultacije i postupci obavljaju se u SB Ferona, Novi Sad, gde dr Filip Katanić ordinira.` |
| `src/data/site.json` `napomena_institucija` | `Kontakt centar SB Ferona — za zakazivanje pregleda kod dr Filipa Katanića. Telefon i email pripadaju ustanovi.` | UKLONITI ključ |
| `src/data/site.json` (novi ključevi) | — | `"ordinira": "Ordinira u SB Ferona, Novi Sad"`, `"lokacija": "SB Ferona, Šarplaninska 19, 21000 Novi Sad"`, `"ferona_tel": "+381 21 3000 220"` (samo za opcionu napomenu §4.1) |
| `src/data/jsonld/person.json:8` `description` | `Doktor medicine, master reproduktivne embriologije, član tima Specijalne bolnice Ferona u Novom Sadu.` | `Reproduktivna medicina, IVF i lečenje steriliteta, Novi Sad.` |
| `src/data/jsonld/person.json` `jobTitle` | `Lekar` | `Specijalista ginekologije i akušerstva` (posle pismene potvrde; do tada `Lekar`) |
| `build.py:88` `cta_title` | `Sledeći korak je razgovor` | `Zakažite konsultaciju i napravimo plan koji je pravi za Vas.` |
| `build.py:89` `cta_text` | `Za zakazivanje pregleda obratite se kontakt centru SB Ferona — ustanove u kojoj dr Filip Katanić radi.` | `Individualna konsultacija, jasni koraci i plan koji odgovara Vašoj situaciji.` |
| `build.py` OG tekst | `GINEKOLOGIJA · IVF · NOVI SAD` | `REPRODUKTIVNA MEDICINA · IVF · NOVI SAD` |
| `src/static/lib/templates/*` (pošiljalac) | — | Ime pošiljaoca: `dr Filip Katanić` (nikad "Ferona") |

## 5.4 Politika privatnosti — nova sekcija o formi (umesto "Kontakt i poruke")

- H2: Forma za zakazivanje
- Pasus 1: Kada pošaljete zahtev za konsultaciju, prikupljamo podatke koje unesete: ime i prezime, e-mail, telefon, željeni način kontakta, razlog konsultacije, željeni datum i doba dana, i — ako ih navedete — ime partnera, informaciju o postojanju nalaza i napomenu.
- Pasus 2: Podaci se koriste isključivo za obradu Vašeg zahteva: potvrdu ili predlog termina i kontakt u vezi sa zakazivanjem. Ne koriste se za marketing i ne dele se sa trećim licima, osim sa ustanovom u kojoj se konsultacija obavlja, u meri potrebnoj za termin. `[POTVRDITI SA KLIJENTOM: da li se podaci prosleđuju SB Feroni]`
- Pasus 3: Rukovalac podacima je dr Filip Katanić. `[POTVRDITI SA KLIJENTOM: pravni oblik / ko je rukovalac]` Podaci se čuvaju najduže {rok} od poslednjeg kontakta, a zatim se brišu. `[POTVRDITI SA KLIJENTOM: rok čuvanja, npr. 12 meseci]`
- Pasus 4: U napomeni ne morate navoditi detaljne medicinske podatke — o tome razgovaramo na konsultaciji.
- Pasus 5: Imate pravo da zatražite uvid, ispravku ili brisanje svojih podataka i da povučete saglasnost. Zahtev možete poslati na {mejl za zahteve} ili porukom na Instagramu @drfilipkatanic. `[POTVRDITI SA KLIJENTOM: mejl za zahteve u vezi sa podacima]`
- Pasus 6 (Instagram): Poruke poslate preko Instagrama obrađuju se u okviru te platforme, prema njenim pravilima.

---

# 6. MEJLOVI

Ton: topao, profesionalan, prvo lice doktora (potpis "dr Filip Katanić"). Pošiljalac: **dr Filip Katanić**. Placeholderi:

| Placeholder u ovom tekstu | Promenljiva u `notify.php` |
|---|---|
| `{ime}` | `$v['ime']` |
| `{broj}` | `$v['ref']` (npr. #0128) |
| `{usluga}` | `$v['usluga']` |
| `{zeljeni_datum}` | `$v['zeljeni']` |
| `{doba_dana}` | `$v['doba']` |
| `{kanal}` | `$v['kanal']` |
| `{datum}` | `$v['termin_datum']` |
| `{vreme}` | `$v['termin_vreme']` |
| `{adresa}` | `$v['loc_name'] . ', ' . $v['loc_address']` → "SB Ferona, Šarplaninska 19, Novi Sad" |
| `{mapa}` | `$v['map_url']` |
| `{poruka}` | `$a['poruka_pacijentu']` |
| `{razlog}` | `$a['razlog_odbijanja']` |
| `{predlog_termina}` | `$v['predlog']` |
| `{link_zakazivanje}` | `$v['booking_url']` |
| `{link_admin}` | `$v['admin_link']` |

Blokovi u `[ako …]` se prikazuju samo ako vrednost postoji.

## 6.1 Pacijentu — zahtev primljen

- **Subject:** Primili smo Vaš zahtev za konsultaciju {broj}
- **Preheader:** Ovo još nije potvrda termina — potvrdu dobijate u posebnom mejlu.
- **Eyebrow:** Zahtev {broj}
- **Naslov:** Zahtev je primljen

Telo:
> Poštovani/a {ime},
>
> hvala Vam na poverenju. Vaš zahtev za konsultaciju je primljen i pregledaću ga u najkraćem roku.
>
> **Ovo još nije potvrda termina.** Tačan datum i vreme — ili predlog drugog termina, ako željeni nije slobodan — dobićete u posebnom mejlu. Po potrebi ću Vas kontaktirati i putem kanala koji ste izabrali ({kanal}).
>
> **Rezime zahteva**
> Broj zahteva: {broj} · Razlog: {usluga} · Željeni datum: {zeljeni_datum} · Doba dana: {doba_dana} · Kontakt: {kanal} [+ telefon, e-mail, partner, nalazi, napomena ako postoje]
>
> Ako ste nešto pogrešno uneli ili želite da dopunite zahtev, samo odgovorite na ovaj mejl.
>
> Do konsultacije, ako imate prethodne nalaze (hormonske analize, ultrazvuk, spermogram partnera, izveštaje o ranijim postupcima), pripremite ih — razgovor će biti konkretniji. Ako ih nemate, nema problema: zajedno ćemo videti šta ima smisla uraditi.
>
> Srdačno,
> dr Filip Katanić
> Reproduktivna medicina

Sitno (footer mejla): Ovaj mejl ste dobili jer ste poslali zahtev za konsultaciju preko sajta dr Filipa Katanića. Za hitna stanja obratite se najbližoj hitnoj službi.

## 6.2 Pacijentu — termin potvrđen

- **Subject:** Vaš termin je potvrđen: {datum} u {vreme} h
- **Preheader:** Vidimo se {datum} u {vreme} h — {adresa}.
- **Eyebrow:** Potvrda termina
- **Naslov:** Vaš termin je potvrđen

Telo:
> Poštovani/a {ime},
>
> sa zadovoljstvom Vam potvrđujem termin konsultacije.
>
> **Datum:** {datum}
> **Vreme:** {vreme} h
> **Mesto:** {adresa}
> [ako {mapa}] Otvori u Google mapama → {mapa}
>
> [ako {poruka}] **Poruka za Vas**
> {poruka}
>
> **Šta poneti**
> – Hormonske analize, ako ih imate
> – Nalaz spermograma partnera, ako postoji
> – Prethodnu medicinsku dokumentaciju (nalaze, ultrazvuk, izveštaje o ranijim postupcima)
> – Spisak terapije koju trenutno koristite
> – Pitanja koja želite da postavite — zapisana unapred, da ništa ne zaboravite
>
> Ako ste sprečeni ili želite da pomerite termin, javite mi se odgovorom na ovaj mejl što ranije, kako bi termin mogao da se ustupi nekom drugom.
>
> Ne možemo kontrolisati baš sve, ali možemo napraviti najbolji plan. Vidimo se.
>
> Srdačno,
> dr Filip Katanić
>
> Razlog: {usluga} · Broj zahteva: {broj}

> Napomene za backend: postojeći šablon traži "ličnu kartu i zdravstvenu knjižicu / karticu osiguranja" i "dođite 10 minuta ranije" — `[POTVRDITI SA KLIJENTOM]` pre nego što se zadrže. Lista "Šta poneti" iznad je iz njegovog IG checklista ("Prva konsultacija – šta poneti").

## 6.3 Pacijentu — termin nije moguć (odbijanje / predlog)

**Varijanta A — sa predlogom drugog termina**
- **Subject:** Vaš zahtev za konsultaciju — predlog drugog termina
- **Preheader:** Traženi termin nije slobodan — predlažem {predlog_termina}.
- **Naslov:** Predlažem drugi termin

**Varijanta B — bez predloga**
- **Subject:** Vaš zahtev za konsultaciju — termin nije dostupan
- **Preheader:** Traženi termin nažalost nije moguć — evo kako da zakažete drugi.
- **Naslov:** Termin nažalost nije moguć

Telo:
> Poštovani/a {ime},
>
> hvala Vam na zahtevu i poverenju. Nažalost, termin koji ste tražili ({zeljeni_datum}) trenutno nije moguć.
>
> [ako {razlog}] **Obrazloženje**
> {razlog}
>
> [ako {predlog_termina}] **Predlog drugog termina:** {predlog_termina}, {adresa}
> Ako Vam ovaj termin odgovara, samo odgovorite na ovaj mejl i potvrdiću ga.
>
> **Kako zakazati drugi termin**
> Novi zahtev možete poslati bilo kada, sa drugim željenim datumom: {link_zakazivanje}
> Možete i odgovoriti na ovaj mejl — rado ćemo pronaći termin koji Vam odgovara.
>
> Srdačno,
> dr Filip Katanić

Dugme: Pošaljite novi zahtev

**Predlošci "Poruka pacijentu" po razlogu (admin ih predpopunjava, doktor može da izmeni):**

| Razlog (radio) | Predložen tekst za `{razlog}` |
|---|---|
| Termin nije dostupan | Željeni termin je već popunjen. Predlažem drugi termin u nastavku — ili pošaljite novi zahtev sa datumom koji Vam odgovara. |
| Potrebna je druga vrsta pregleda | Na osnovu onoga što ste naveli, smatram da bi za Vas bio korisniji drugačiji pregled. Javite mi se odgovorom na ovaj mejl, pa ćemo zajedno dogovoriti najbolji sledeći korak. |
| Drugo | (prazno — doktor piše) |

## 6.4 Pacijentu — termin otkazan (postojeći tip `otkazivanje`, opciono)

- **Subject:** Termin {datum} u {vreme} h je otkazan
- **Preheader:** Izvinjavam se zbog promene — evo kako da zakažete novi termin.
- **Naslov:** Termin je otkazan

> Poštovani/a {ime},
>
> obaveštavam Vas da je termin konsultacije zakazan za **{datum} u {vreme} h** nažalost otkazan. Izvinjavam se zbog neprijatnosti.
>
> [ako {razlog}] **Obrazloženje** {razlog}
>
> Odgovorite na ovaj mejl ili pošaljite novi zahtev — rado ćemo pronaći novi termin što pre: {link_zakazivanje}
>
> Srdačno,
> dr Filip Katanić

## 6.5 Doktoru — novi zahtev

- **Subject:** Novi zahtev {broj} — {ime}, {usluga}
- **Preheader:** Željeni datum {zeljeni_datum} ({doba_dana}) · kontakt: {kanal}
- **Eyebrow:** Admin · zahtev {broj}
- **Naslov:** Novi zahtev za konsultaciju

Telo:
> Stigao je novi zahtev preko sajta.
>
> Pacijent: {ime} · Partner: {partner} · Razlog: {usluga} · Željeni datum: {zeljeni_datum} · Doba dana: {doba_dana} · Kontakt putem: {kanal} · Telefon: {telefon} · E-mail: {email} · Nalazi: {dokumentacija} · Napomena: {napomena} · Primljeno: {primljeno}
>
> [Dugme] Otvori zahtev → {link_admin}
>
> Iz admin panela možete potvrditi termin ili predložiti drugi — pacijent automatski dobija mejl.
> Odgovor na ovaj mejl ide direktno pacijentu.

---

# 7. ADMIN PANEL — mikrokopija

## 7.1 Login
- `<title>`: Prijava — Zakazivanja | dr Filip Katanić
- Naslov: dr Filip Katanić
- Podnaslov: Zakazivanja — admin
- Labela: Korisničko ime
- Labela: Lozinka · dugme oka: Prikaži lozinku / Sakrij lozinku
- Checkbox: Zapamti me na ovom uređaju
- Dugme: Prijava · u toku: Prijavljujem…
- Greška (pogrešni podaci): Pogrešno korisničko ime ili lozinka.
- Greška (rate limit): Previše neuspelih pokušaja. Pokušajte ponovo za {n} minuta.
- Greška (CSRF / sesija): Sesija je istekla. Osvežite stranicu i pokušajte ponovo.
- Flash posle odjave: Odjavljeni ste.
- Flash (auto-odjava): Iz bezbednosnih razloga ste odjavljeni. Prijavite se ponovo.

## 7.2 Top bar i navigacija
- Naslov: Zakazivanja
- Badge: {n} novih (`aria-label="{n} novih zahteva"`)
- Dugmad: Osveži · Odjava
- Meni (⋯): Promena lozinke · Odjava

## 7.3 Lista
- `<title>`: Zakazivanja ({n} novih) | Admin
- H1: Zahtevi za konsultaciju
- Tabovi filtera: Novo ({n}) · Potvrđeno · Odbijeno · Otkazano · Sve
- Pretraga — labela (vizuelno skrivena): Pretraga · placeholder: Ime, telefon ili e-mail
- Sort: Najnovije prvo · Po željenom datumu
- Kolone tabele: Status · Primljeno · Ime i prezime · Razlog · Željeni datum · Doba · Kanal · Telefon · Akcije
- Status čipovi: Novo · Potvrđeno · Odbijeno · Otkazano
- Relativno vreme: upravo sada · pre {n} min · pre {n} h · juče · {datum}
- Brze akcije na kartici: Potvrdi · Odbij · (strelica) Detalji
- Paginacija: Prethodna · Sledeća · Strana {x} od {y}

**Prazna stanja**
| Filter | Tekst |
|---|---|
| Novo | Nema novih zahteva. Kada stigne novi, dobićete mejl. |
| Potvrđeno | Još nema potvrđenih termina. |
| Odbijeno | Nema odbijenih zahteva. |
| Otkazano | Nema otkazanih termina. |
| Sve | Još nema nijednog zahteva. Kada pacijent pošalje formu, pojaviće se ovde. |
| Pretraga bez rezultata | Nema rezultata za „{upit}“. · Link: Obriši pretragu |

## 7.4 Detalj zahteva
- Nazad: ‹ Svi zahtevi
- Zaglavlje: {broj} · status čip · H1 {ime}
- Podnaslov: Primljeno {datum} u {vreme}
- Oznake (dt): Razlog · Željeni datum · Doba dana · Partner · Nalazi · Kontakt putem · Telefon · E-mail · Napomena · Potvrđen termin · Razlog odbijanja · Predlog termina
- Prazna vrednost: —
- Dugmad kontakta: Pozovi · Viber · WhatsApp · Pošalji mejl
- Sekcija: ISTORIJA
  - Zahtev primljen — {datum vreme}
  - Mejl „Zahtev primljen“ poslat ✓ / nije poslat ✗
  - Obaveštenje doktoru poslato ✓ / nije poslato ✗
  - Termin potvrđen ({korisnik}) — {datum vreme}
  - Zahtev odbijen ({korisnik}) — {datum vreme}
  - Označeno kao otkazano — {datum vreme}
- Glavna dugmad: **Potvrdi** · **Odbij**
- Meni ⋯: Označi kao otkazano · Ponovo pošalji mejl
- Za potvrđene: dugme Otkaži termin · za odbijene/otkazane: info "Zahtev je zatvoren."

## 7.5 Modal / bottom sheet — Potvrdi
- Naslov: Potvrda termina
- Zatvori: `aria-label="Zatvori"`
- Datum * (hint: Predpopunjeno željenim datumom pacijenta.)
- Vreme * (hint: Korak 15 minuta.)
- Poruka pacijentu (opciono) · placeholder/predlog: Molim Vas da ponesete dosadašnje nalaze, ako ih imate.
- `<details>`: Pregled mejla
- Dugme: **Potvrdi i pošalji mejl** · u toku: Šaljem…
- Sekundarno: Odustani
- Greške: Izaberite datum. · Izaberite vreme. · Datum ne može biti u prošlosti.

## 7.6 Modal / bottom sheet — Odbij
- Naslov: Odbijanje / predlog termina
- Razlog * (radio): Termin nije dostupan · Potrebna je druga vrsta pregleda · Drugo
- Predlog drugog termina (opciono): Datum · Vreme
- Poruka pacijentu * (predpopunjava se po razlogu — tabela §6.3)
- `<details>`: Pregled mejla
- Dugme: **Pošalji odgovor** · u toku: Šaljem…
- Sekundarno: Odustani
- Greške: Izaberite razlog. · Napišite kratku poruku pacijentu. · Unesite i datum i vreme predloga, ili ostavite oba prazna.

## 7.7 Otkazivanje
- Naslov: Označi kao otkazano
- Razlog (opciono)
- Checkbox: Pošalji mejl pacijentu o otkazivanju
- Dugme: Označi kao otkazano · Odustani
- Potvrda: Da li ste sigurni? Ova radnja menja status zahteva.

## 7.8 Flash / toast poruke
| Situacija | Tekst |
|---|---|
| Potvrđeno + mejl OK | Termin je potvrđen — mejl je poslat pacijentu. |
| Odbijeno + mejl OK | Odgovor je poslat pacijentu. |
| Otkazano + mejl OK | Termin je otkazan — pacijent je obavešten mejlom. |
| Otkazano bez mejla | Termin je označen kao otkazan. Mejl nije slat. |
| Akcija OK, mejl NIJE poslat | Sačuvano, ali mejl NIJE poslat (greška pri slanju). Kontaktirajte pacijenta direktno: [Pozovi] |
| Ponovo poslat mejl | Mejl je ponovo poslat. |
| Status se u međuvremenu promenio | Ovaj zahtev je u međuvremenu izmenjen. Osvežite stranicu. |
| Zahtev ne postoji | Zahtev nije pronađen. |
| CSRF | Sesija je istekla. Osvežite stranicu i pokušajte ponovo. |
| Opšta greška | Došlo je do greške. Pokušajte ponovo. |
| Lozinka promenjena | Lozinka je promenjena. |

## 7.9 Promena lozinke
- Naslov: Promena lozinke
- Labele: Trenutna lozinka · Nova lozinka · Ponovite novu lozinku
- Hint: Najmanje 12 znakova.
- Greške: Trenutna lozinka nije ispravna. · Nova lozinka mora imati najmanje 12 znakova. · Lozinke se ne poklapaju.
- Dugme: Sačuvaj

---

# 8. Alt tekstovi (nove slike)

| Fajl | Alt |
|---|---|
| `hero-portret.webp` / `hero-portret-mobile.webp` | dr Filip Katanić u belom mantilu, u ordinaciji |
| `portret-mantil.webp` | dr Filip Katanić u belom mantilu, portret |
| `portret-mantil-2.webp` | dr Filip Katanić, portret |
| `o-meni.webp` | dr Filip Katanić za radnim stolom u ordinaciji |
| `konferencija-panel.webp` | dr Filip Katanić kao panelista na skupu Bio Save — Bebologijini krugovi |
| `logo-znak.png` (dekor) | `alt=""` |
| `logo-pun.png` (OG) | dr Filip Katanić — logo |
| `edukacija-ivf-proces-04.webp` (Journal 3) | Naslovna kartica članka: Pre straha — činjenice. Pre odluke — plan. |

---

# 9. [POTVRDITI SA KLIJENTOM] — zbirni spisak (v2)

1. **Titula** "Specijalista ginekologije i akušerstva" — pismena potvrda pre objave (javni akademski profili navode status specijalizanta). Pogađa: hero kredencijal, O meni, credential partial, meta /o-meni/, `jobTitle`.
2. **Tačan naziv mastera** — "Master reproduktivni embriolog" (IG) vs. "Master reproduktivne biologije i kliničke embriologije" (referenca); ustanova.
3. **Doktorske studije** — MF Novi Sad, prediktivno modelovanje ovarijalnog odgovora.
4. **Osnovne studije** — ustanova i godina (za timeline i `alumniOf`).
5. **Status u SB Feroni** (zaposlen / saradnik) — vidljivo se koristi neutralno "ordinira".
6. **Lični telefon i mejl** za sajt (do tada prazno u `site.json`, ne prikazuje se).
7. **Jednodnevna dijagnostika steriliteta** — da li se nudi (do tada zamenska kartica "Prva konsultacija").
8. **Histeroskopija** — da li je radi, i ambulantno (do tada zamenska kartica "Redovni ginekološki pregledi").
9. **"Višegodišnje iskustvo" / "histeroskopska hirurgija"** sa reference — ne koristi se do potvrde.
10. **Pismeni zaključak** posle konsultacije (korak 05).
11. **Weill Cornell Seminar Salzburg, LH in ART Sorrento, MSRM Bari** — učešće i godina (do tada samo HTML komentar).
12. **SPRING Fertility** — status i datum učešća.
13. **Ko odgovara na zahteve** (lično doktor ili asistent) — utiče na "javiću" / "javićemo".
14. **Okvirni rok odgovora** na zahtev (mini FAQ).
15. **Cena konsultacije** — kako se saopštava (mejl potvrde ili usmeno).
16. **Ferona kontakt centar** kao sekundarna opcija zakazivanja na /kontakt/ — da ili ne.
17. **Rukovalac podacima, rok čuvanja, mejl za zahteve o podacima**, prosleđivanje podataka SB Feroni (politika privatnosti).
18. **Mejl potvrde**: da li tražiti ličnu kartu/zdravstvenu knjižicu i "dođite 10 minuta ranije" (postojeći backend šablon).
19. **Lični deo "Ja sam i…"** na /o-meni/ — da li ga želi (bez porodičnih detalja).
20. **Radni dani** — da li forma dozvoljava vikend kao željeni datum.
21. **Titula na bedžu** na `konferencija-panel.webp` i odobrenje kropa/retuša portreta sa Ferona logom.
