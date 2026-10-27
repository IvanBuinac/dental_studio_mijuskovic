# SEO plan — Dr Nada Bojić, parodontolog (Hope Dental, Beograd)

**Verzija:** 2.0 — 27.10.2026. (u celosti prepisano)
**Klijent:** @dmd.nadabojic — Dr Nada Bojić, Spec. dr parodontologije i oralne medicine, ordinacija Hope Dental, Beograd
**Status sajta:** greenfield (sajt ne postoji), demo režim
**Izvori:** `research.md` (DEO A — potvrđeno sa profila), `web-research.md` (analiza konkurencije, obrasci pretrage), WebSearch provere 27.10.2026.

---

## 0. Upozorenje — šta je u ovom dokumentu podatak, a šta nije

Prethodna verzija ovog dokumenta (18.10.2026.) sadržala je **izmišljene podatke** (adresa, telefon, cene, domeni). Oni su u celosti izbačeni i **ne smeju se vratiti ni u jedan fajl, template ni schema blok**.

| Podatak | Status u ovoj verziji |
|---|---|
| Adresa ordinacije | **NEPOZNATO** → `[POTVRDITI SA KLIJENTOM]` |
| Telefon | **NEPOZNATO** → `[POTVRDITI SA KLIJENTOM]` |
| Mejl | **NEPOZNATO** → `[POTVRDITI SA KLIJENTOM]` |
| Radno vreme | **NEPOZNATO** → `[POTVRDITI SA KLIJENTOM]` |
| Cene / cenovnik | **NEPOZNATO** → ne objavljuje se, nema `priceRange` u schemi |
| Domen | **NEPOZNATO** → ne postoji kupljen domen; u kodu koristiti relativne URL-ove ili `https://PLACEHOLDER-DOMEN` |
| Opština (Voždovac) | **NEPOTVRĐENA HIPOTEZA** — potvrđeno je samo „Beograd“. U tekstu sajta koristiti „Beograd“. Voždovac se ubacuje **tek posle potvrde**. |
| Formalni status (specijalista vs. specijalizant) | **[POTVRDITI]** — iz bio-a: „Spec. dr parodontologije i oralne medicine“. Dok se ne potvrdi pisano, u tekstu se citira formulacija iz njenog bio-a, bez samostalne tvrdnje „specijalista“ u title/H1. |
| Ocene, broj recenzija, godine iskustva, fakultet, tim | **NEPOZNATO** → ne pominju se, nema `aggregateRating` |

**Pravilo za Copywritera i Developera:** ako podatak nije u ovom dokumentu označen kao poznat, ne izmišlja se — ostaje `[POTVRDITI SA KLIJENTOM]` i vidljiv je u demo verziji kao takav.

### Pravila za medicinsku nišu (obavezno)
- Bez obećanja ishoda („izlečenje garantovano“, „trajno rešenje“, „100%“, „bez bola“ kao garancija).
- Bez „najbolji“, „vodeći“, „broj 1“ i bez poređenja sa konkurencijom po imenu.
- Bez pre/posle fotografija dok ne postoji **pisana saglasnost pacijenta** (nije potvrđeno da postoji).
- Na svakoj stranici usluge: napomena da je sadržaj informativan i da ne zamenjuje pregled.
- Reč „specijalista“ i broj licence Stomatološke komore samo posle pisane potvrde.

---

## 1. Pozicioniranje i SEO strategija

**Niša 1 (glavna): parodontologija i oralna medicina.**
Iz `web-research.md` (sekcija 5.7): nijedna ordinacija u analiziranom beogradskom okruženju ne gradi brend oko parodontologije — svi je nude kao jednu od deset usluga. Nijedan konkurent nema zasebne stranice po simptomu (krvarenje desni, povlačenje desni, klimavi zubi).

Provera 27.10.2026. (WebSearch) potvrđuje obrazac: za upite `krvarenje desni`, `lečenje parodontopatije`, `povlačenje desni` prvu stranu drže **medijski/zdravstveni portali** (n1info, 021.rs, index.hr, novilist.hr, haleonhealthpartner) i **akademski izvori** (Stomatološki fakultet, PDF-ovi), a ne privatne ordinacije. Za `povlačenje desni` ni jedna beogradska ordinacija nije se pojavila u rezultatima — kategoriju drži agregator `whatclinic.com` na engleskom.
→ **Zaključak: simptomske stranice su realno osvojive sa malim sajtom, jer ozbiljnu srpsku stranicu ordinacije na te upite praktično nema. Ovo je jezgro strategije.** (Procena, bez podataka o obimu pretrage.)

**Niša 2 (sekundarna): estetska medicina lica kod stomatologa** (botoks, fileri, PRP, skinbooster). Po `web-research.md` 5.7, konkurencija za te upite dolazi iz estetskih klinika i dermatologije, ne iz stomatoloških ordinacija. Ugao: lekar koji već radi u predelu lica i poznaje anatomiju perioralne regije.

**Niša 3 (podrška konverziji): fiksna protetika i oralna hirurgija** — zatvaraju putanju pacijenta (parodontološka terapija → sanacija → protetika) i hvataju komercijalne upite.

**Čega se NE radi:** opšta stomatologija kao glavna poruka — „stomatolog Beograd“ je najzasićeniji upit, a konkurent sa domenom tipa `stomatologvozdovac.rs` ima strukturnu prednost. Na tom terenu se ne takmičimo frontalno.

---

## 2. Ključne reči

> **Nema podataka o obimu pretrage** (Keyword Planner / Search Console nisu dostupni). Svaka ocena ispod je **procena**, izvedena iz strukture SERP-a, naslova indeksiranih stranica i URL matrica srpskih imenika (planplus.rs, mirandre.com), kako je dokumentovano u `web-research.md`.

### 2.1 Primarna
**`parodontolog Beograd`**

Obrazloženje: tačno odgovara njenom bio-u („Parodontolog Beograd“), nosi i uslugu i grad, a konkurencija je slaba (SERP drže fakultetska klinika i akademski izvori, ne privatne ordinacije). Jasna namera: pacijent traži specijalistu, ne opšteg stomatologa. (procena)

Varijante koje pokriva ista stranica: `parodontologija Beograd`, `specijalista parodontologije Beograd`, `parodontolog blizu mene`.

### 2.2 Sekundarne (12)

| # | Ključna reč | Namera | Odredišna stranica | Prioritet (procena) |
|---|---|---|---|---|
| 1 | `lečenje parodontopatije` | informativno-komercijalna | `/usluge/parodontologija/` | visok |
| 2 | `krvarenje desni` | simptom | `/parodontopatija/krvarenje-desni/` | **najviši** (slaba konkurencija ordinacija) |
| 3 | `povlačenje desni` | simptom | `/parodontopatija/povlacenje-desni/` | **najviši** (SERP prazan na srpskom) |
| 4 | `upala desni` / `gingivitis` | simptom | `/parodontopatija/upala-desni/` | visok |
| 5 | `klimavi zubi` | simptom, visoka hitnost | `/parodontopatija/klimavi-zubi/` | visok |
| 6 | `zubni kamenac` / `uklanjanje kamenca` | komercijalna, ulazna | `/usluge/parodontologija/` (H2 sekcija) | srednji |
| 7 | `kiretaža desni` | komercijalna, specifična | `/usluge/parodontologija/` (H2) | srednji |
| 8 | `hirurška parodontologija` / `operacija desni` | komercijalna | `/usluge/parodontoloska-hirurgija/` | srednji |
| 9 | `oralna medicina` / `rane u ustima` | informativna | `/usluge/oralna-medicina/` | srednji |
| 10 | `fiksna proteza` / `fiksna protetika Beograd` | komercijalna | `/usluge/protetika/` | visok |
| 11 | `oralna hirurgija Beograd` / `vađenje zuba` | komercijalna | `/usluge/oralna-hirurgija/` | srednji |
| 12 | `botoks Beograd` / `fileri Beograd` / `PRP lice` / `skinbooster` | komercijalna | `/usluge/estetska-medicina/` | visok (druga niša) |

**Long-tail dodaci** (ulaze u tekst, ne dobijaju svoju stranicu): `loš zadah uzrok`, `zubno meso boli`, `paradentoza simptomi`, `krvarenje desni pri pranju zuba`, `bol u desnima`, `pregled desni Beograd`, `profesionalno čišćenje zuba`.

**Rezervisano za fazu 2 (posle potvrde opštine):** `parodontolog Voždovac`, `stomatolog Voždovac`. Ne ubacivati dok klijentkinja ne potvrdi adresu.

### 2.3 Negativne / izbegavati
`najbolji stomatolog Beograd`, `najpovoljniji stomatolog`, `stomatolog cene` — niska marža, pogrešna publika, a za medicinsku nišu „najbolji“ je i rizična tvrdnja.

---

## 3. Analiza konkurencije (sinteza iz `web-research.md`)

> Podaci su iz indeksiranih izvoda pretraživača, ne iz direktnog čitanja sajtova → pouzdanost „verovatno“. Ne citirati tuđe telefone/adrese nigde u našem sadržaju.

**Top 3 relevantna konkurenta:**

| Konkurent | Struktura | Dužina/dubina | Šta im nedostaje → naša prilika |
|---|---|---|---|
| **Donna Dent** (`stomatologvozdovac.rs`) | Domen = ključna reč, fokus implantologija + oralna hirurgija, ima schema | srednja, orijentisana na usluge | Nema parodontološki sadržaj; dva paralelna domena kanibalizuju autoritet; nekonzistentan NAP (različiti telefoni po imenicima); gmail adresa. → Mi radimo **konzistentan NAP od prvog dana** i jedan domen. |
| **Unident** (`unident.rs`) | Zasebna `/stomatoloske-usluge/` stranica, parodontologija je **jedan stav u listi** | kratko, bez dubine po usluzi | Nema HTTPS (SEO i signal poverenja); nema stranica po simptomu; brend kolizija sa `unidentstomatologija.com`. → Mi radimo **jednu stranicu po simptomu, dubinski**. |
| **Vuković** (`ordinacijavukovic.rs`) | Brend oko prezimena doktora, najsvežije nezavisne recenzije (planplus.rs, mart 2026.) | plitko po uslugama | Nema usluge-stranice u indeksu, nema geo ključne reči u brendu. → Potvrđuje da **lična marka doktora konvertuje na ovom tržištu** — što je tačno Nadin model (`dmd.nadabojic`). |

**Opšti obrazac koji svi propuštaju:** nijedan ne piše za pacijenta koji tek ima simptom i još ne zna da mu treba parodontolog. Svi pišu za pacijenta koji već zna uslugu. Tu je ceo prostor.

**Format pobedničke stranice (iz analize SERP-a za simptomske upite):** ~900–1400 reči, H2 struktura „šta je → zašto se javlja → kada je ozbiljno → kako se leči kod nas → šta možete sami → kada doći“, FAQ blok na dnu, jedan jasan CTA (telefon). Medijski članci koji trenutno drže te upite nemaju CTA ni lokalni signal — to je naša prednost u konverziji, ne u autoritetu.

---

## 4. Struktura sajta i URL-ovi

**Odluka: višestranični sajt.** Obrazloženje: četiri usluge sa jakim nezavisnim ključnim rečima + simptomski klaster koji je jezgro strategije. One-page bi sve to sabio u jedan `<title>` i ubio simptomske upite.

**Konvencija URL-ova:** mala slova, bez dijakritika, crtice kao separator, trailing slash, bez datuma, bez ID-jeva, maks. 2 nivoa dubine.

```
/                                        Naslovna
/o-meni/                                 Dr Nada Bojić — biografija, pristup
/usluge/                                 Pregled svih usluga (hub)
/usluge/parodontologija/                 GLAVNA stranica usluge
/usluge/parodontoloska-hirurgija/        Hirurška parodontologija
/usluge/oralna-medicina/                 Bolesti usta, promene na sluznici
/usluge/oralna-hirurgija/
/usluge/protetika/                       Fiksna protetika
/usluge/estetska-medicina/               Botoks, fileri, PRP, skinbooster
/parodontopatija/                        Vodič — hub simptomskog klastera
/parodontopatija/krvarenje-desni/
/parodontopatija/povlacenje-desni/
/parodontopatija/upala-desni/
/parodontopatija/klimavi-zubi/
/pitanja-i-odgovori/                     FAQ (FAQPage schema)
/kontakt/                                NAP, mapa, forma
/politika-privatnosti/                   noindex
```

**Ukupno: 17 stranica** — 16 indeksabilnih + `/politika-privatnosti/` (noindex).

**Odloženo do potvrde klijenta:**
- `/rezultati/` — pre/posle galerija. **NE pravi se** dok ne postoji pisana saglasnost pacijenata.
- `/cenovnik/` — cene nisu poznate; javni cenovnik bi bio diferencijator (`web-research.md` 5.6), ali je odluka klijentkinje.
- `/en/` — samo ako cilja dentalni turizam. Za sada **ne**.

**Faza 2 (posle potvrde adrese):** `/parodontolog-vozdovac/` kao lokalna landing stranica. Ne pre toga.

---

## 5. Specifikacija po stranici

> `<title>` ≤ 60 znakova, meta description ≤ 155 znakova, tačno jedan `<h1>` po stranici. Brojevi u zagradama su dužine u znakovima.

### 5.1 `/` — Naslovna
- **title:** `Parodontolog Beograd — dr Nada Bojić | Hope Dental` (50)
- **description:** `Terapija obolelog zubnog mesa, parodontopatije i oralne medicine u Beogradu. Pregled i jasan plan terapije. Zakažite pregled.` (128)
- **H1:** `Parodontolog u Beogradu — zdravo zubno meso kao osnova zdravih zuba`
- **H2 plan:**
  1. `Kada je vreme za parodontologa` — 4 simptoma, svaki linkuje na svoju simptomsku stranicu
  2. `Usluge` — 6 kartica → stranice usluga
  3. `Dr Nada Bojić` — kratko bio + foto → `/o-meni/`
  4. `Kako izgleda prvi pregled` — 3 koraka (pregled → nalaz → plan terapije)
  5. `Česta pitanja` — 4 pitanja → `/pitanja-i-odgovori/`
  6. `Kontakt i lokacija` — NAP + mapa → `/kontakt/`
- **Interni linkovi (izlazni):** 4 simptomske, 6 usluga, `/o-meni/`, `/pitanja-i-odgovori/`, `/kontakt/`
- **alt tekstovi:** `Dr Nada Bojić, parodontolog, Hope Dental Beograd` · `Ordinacija Hope Dental — sala za preglede` · `Parodontološki pregled — instrumenti`
- **CTA:** telefon (`tel:`) u headeru, sticky na mobilnom

### 5.2 `/o-meni/`
- **title:** `Dr Nada Bojić — parodontolog, Beograd | Hope Dental` (51)
- **description:** `Dr Nada Bojić, spec. dr parodontologije i oralne medicine. Parodontologija, oralna medicina i estetska medicina lica u Beogradu.` (131)
- **H1:** `Dr Nada Bojić`
- **H2:** `Obrazovanje i stručno usmerenje` `[POTVRDITI: fakultet, godina, status specijalizacije]` · `Oblasti rada` · `Pristup pacijentu` · `Dodatne edukacije i sertifikati` `[POTVRDITI]`
- **Napomena za Copywritera:** titulu pisati kako stoji u njenom bio-u („Spec. dr parodontologije i oralne medicine“). Ne proširivati u „specijalista parodontologije“ bez pisane potvrde — to je u Srbiji zvanična specijalizacija i pravno osetljiva tvrdnja (`web-research.md` 1.6, 7.5).
- **Interni linkovi:** `/usluge/parodontologija/`, `/usluge/estetska-medicina/`, `/kontakt/`
- **alt:** `Dr Nada Bojić u ordinaciji Hope Dental`

### 5.3 `/usluge/` — hub
- **title:** `Usluge — parodontologija, hirurgija, protetika` (45)
- **description:** `Parodontološka terapija, oralna medicina, oralna hirurgija, fiksna protetika i estetska medicina lica. Pregled i plan terapije u Beogradu.` (140)
- **H1:** `Usluge`
- **H2:** jedan po usluzi (6), svaki sa 2–3 rečenice + link na punu stranicu
- **Interni linkovi:** sve 6 stranica usluga + `/parodontopatija/`

### 5.4 `/usluge/parodontologija/` — GLAVNA stranica usluge
- **title:** `Parodontologija Beograd — lečenje parodontopatije` (48)
- **description:** `Lečenje parodontopatije i upale desni: uklanjanje kamenca, kiretaža, terapija održavanja. Parodontolog u Beogradu. Zakažite pregled.` (133)
- **H1:** `Parodontologija — lečenje obolelog zubnog mesa`
- **H2/H3 plan:**
  - `Šta je parodontopatija` → H3: `Gingivitis i parodontitis — u čemu je razlika`
  - `Znaci na koje treba obratiti pažnju` (linkovi na sve 4 simptomske stranice)
  - `Kako teče terapija` → H3: `Pregled i parodontalni status` / `Uklanjanje zubnog kamenca i poliranje` / `Kiretaža i obrada korenova` / `Terapija održavanja (kontrole)`
  - `Kada je potrebna parodontološka hirurgija` → link `/usluge/parodontoloska-hirurgija/`
  - `Kako sami održavate rezultat`
  - `Česta pitanja o parodontopatiji` (4, iz sekcije 7)
- **Interni linkovi:** 4 simptomske, `/usluge/parodontoloska-hirurgija/`, `/usluge/protetika/`, `/pitanja-i-odgovori/`, `/kontakt/`
- **alt:** `Uklanjanje zubnog kamenca ultrazvučnim aparatom` · `Merenje dubine parodontalnog džepa sondom` · `Zdravo zubno meso — prikaz`
- **Obavezno:** napomena da je tekst informativan i da terapija zavisi od nalaza na pregledu.

### 5.5 `/usluge/parodontoloska-hirurgija/`
- **title:** `Parodontološka hirurgija — operacija desni` (41)
- **description:** `Hirurška parodontologija u Beogradu: režanj operacije, prekrivanje ogoljenih korenova, hirurgija zubnog mesa. Pregled i plan terapije.` (135)
- **H1:** `Parodontološka hirurgija`
- **H2:** `Kada nehirurška terapija nije dovoljna` · `Vrste zahvata` (H3: `Režanj operacija` / `Prekrivanje ogoljenog korena` / `Gingivektomija i estetska korekcija desni`) · `Kako se pripremate` · `Posle zahvata — oporavak i kontrole` · `Česta pitanja`
- **Interni linkovi:** `/usluge/parodontologija/`, `/parodontopatija/povlacenje-desni/`, `/kontakt/`
- **alt:** `Parodontološki hirurški zahvat — sterilni instrumenti`

### 5.6 `/usluge/oralna-medicina/`
- **title:** `Oralna medicina Beograd — bolesti usne duplje` (45)
- **description:** `Dijagnostika i terapija promena na oralnoj sluznici: afte, rane u ustima, suva usta, pečenje jezika. Oralna medicina u Beogradu.` (130)
- **H1:** `Oralna medicina`
- **H2:** `Šta obuhvata oralna medicina` · `Promene zbog kojih treba doći` (H3: `Afte i rane koje ne prolaze` / `Beli i crveni plakovi na sluznici` / `Suva usta` / `Pečenje jezika i usta`) · `Kako se postavlja dijagnoza` · `Kada je promena razlog za hitan pregled`
- **Interni linkovi:** `/usluge/parodontologija/`, `/kontakt/`
- **alt:** `Pregled oralne sluznice`

### 5.7 `/usluge/oralna-hirurgija/`
- **title:** `Oralna hirurgija Beograd — vađenje zuba` (39)
- **description:** `Oralna hirurgija u Beogradu: vađenje zuba, hirurško vađenje umnjaka, apikotomija, priprema za protetiku. Pregled i plan terapije.` (131)
- **H1:** `Oralna hirurgija`
- **H2:** `Zahvati koje radimo` (H3: `Vađenje zuba` / `Hirurško vađenje umnjaka` / `Apikotomija` / `Priprema ležišta za protetiku`) · `Kako se pripremate za zahvat` · `Oporavak i uputstva posle intervencije`
- **Interni linkovi:** `/usluge/protetika/`, `/usluge/parodontologija/`, `/kontakt/`
- **alt:** `Oralnohirurška intervencija u ordinaciji`

### 5.8 `/usluge/protetika/`
- **title:** `Fiksna protetika Beograd — krunice i mostovi` (43)
- **description:** `Fiksna protetika u Beogradu: krunice, mostovi, nadogradnje. Protetska sanacija posle parodontološke terapije. Zakažite pregled.` (128)
- **H1:** `Fiksna protetika`
- **H2:** `Kada se radi fiksna proteza` · `Vrste fiksnih nadoknada` (H3: `Krunice` / `Mostovi`) · `Zašto zdravo zubno meso dolazi pre protetike` · `Koliko traje izrada` · `Održavanje fiksne nadoknade`
- **Interni linkovi:** `/usluge/parodontologija/` (jak kontekstualni link — parodontološka priprema pre protetike), `/usluge/oralna-hirurgija/`, `/kontakt/`
- **alt:** `Fiksna proteza — keramička krunica`

### 5.9 `/usluge/estetska-medicina/`
- **title:** `Botoks, fileri, PRP i skinbooster — Beograd` (42)
- **description:** `Estetska medicina lica u Beogradu: botoks, hijaluronski fileri, PRP i skinbooster. Konsultacija i individualni plan tretmana.` (126)
- **H1:** `Estetska medicina lica`
- **H2:** `Tretmani` (H3: `Botoks` / `Hijaluronski fileri` / `PRP` / `Skinbooster`) · `Kako teče konsultacija` · `Zašto kod stomatologa` (anatomija perioralne regije — bez poređenja sa drugim profesijama) · `Za koga tretman nije preporučljiv` · `Česta pitanja`
- **Interni linkovi:** `/o-meni/`, `/pitanja-i-odgovori/`, `/kontakt/`
- **alt:** `Konsultacija pre tretmana estetske medicine lica`
- **Napomena:** `[POTVRDITI]` — potrebna edukacija/dozvola za estetske intervencije lica; tekst ne objavljuje nijednu tvrdnju o sertifikatu dok se ne potvrdi (`web-research.md` 7.6). Bez pre/posle fotografija bez saglasnosti.

### 5.10 `/parodontopatija/` — hub simptomskog klastera
- **title:** `Parodontopatija — simptomi, lečenje i prevencija` (47)
- **description:** `Vodič kroz bolesti zubnog mesa: krvarenje desni, povlačenje desni, upala i klimavi zubi. Kada treba kod parodontologa.` (120)
- **H1:** `Parodontopatija — vodič za pacijente`
- **H2:** `Kako bolest napreduje` · `Simptomi po fazama` (4 linka na pojedinačne stranice) · `Faktori rizika` · `Šta možete sami, a šta ne` · `Kada kod parodontologa`
- **Interni linkovi:** sve 4 simptomske + `/usluge/parodontologija/`

### 5.11–5.14 Simptomske stranice — zajednički šablon

Svaka: ~900–1400 reči, H2 skelet identičan, CTA telefon posle 2. sekcije i na dnu.

**H2 šablon:** `Šta znači [simptom]` · `Najčešći uzroci` · `Kada je razlog za pregled` · `Kako se leči` · `Šta možete sami` · `Česta pitanja (3)`

| Stranica | title (dužina) | description (dužina) | H1 |
|---|---|---|---|
| `/parodontopatija/krvarenje-desni/` | `Krvarenje desni — uzroci i lečenje \| Beograd` (44) | `Zašto krvare desni pri pranju zuba, kada je to znak parodontopatije i kako se leči. Pregled kod parodontologa u Beogradu.` (121) | `Krvarenje desni` |
| `/parodontopatija/povlacenje-desni/` | `Povlačenje desni — uzroci i lečenje \| Beograd` (45) | `Povlačenje desni i ogoljeni koreni zuba: uzroci, kada je potrebna hirurgija i kako se zaustavlja napredovanje. Beograd.` (119) | `Povlačenje desni i ogoljeni korenovi` |
| `/parodontopatija/upala-desni/` | `Upala desni (gingivitis) — simptomi i terapija` (46) | `Upala desni: crvenilo, oteklina i osetljivost. Kako se razlikuje gingivitis od parodontitisa i kako se leči. Beograd.` (118) | `Upala desni (gingivitis)` |
| `/parodontopatija/klimavi-zubi/` | `Klimavi zubi — uzroci i šta se može uraditi` (43) | `Zub se klati: uzroci, kada se zub može sačuvati i koje su opcije terapije. Pregled kod parodontologa u Beogradu.` (113) | `Klimavi zubi` |

- **Interni linkovi sa svake:** `/parodontopatija/` (nadređena), `/usluge/parodontologija/` (terapija), 1–2 srodne simptomske, `/kontakt/`
- **alt tekstovi:** opisni, bez keyword stuffinga — npr. `Krvarenje desni pri pranju zuba — ilustracija`, `Ogoljen koren zuba zbog povlačenja desni`
- **Obavezno na svakoj:** `Ovaj tekst je informativan i ne zamenjuje pregled. Za procenu stanja potreban je klinički pregled.`

### 5.15 `/pitanja-i-odgovori/`
- **title:** `Česta pitanja — parodontologija i estetika lica` (46)
- **description:** `Odgovori na najčešća pitanja pacijenata o lečenju desni, zubnom kamencu, parodontološkoj hirurgiji i tretmanima estetske medicine lica.` (138)
- **H1:** `Česta pitanja`
- **H2:** `Parodontologija` · `Pregled i terapija` · `Oralna hirurgija i protetika` · `Estetska medicina lica` · `Zakazivanje i organizacija` `[POTVRDITI: način zakazivanja]`
- **schema:** `FAQPage` (samo pitanja koja su i vidljiva na stranici)

### 5.16 `/kontakt/`
- **title:** `Kontakt — Hope Dental, Beograd` (29)
- **description:** `Zakažite pregled kod dr Nade Bojić. Kontakt podaci i lokacija ordinacije Hope Dental u Beogradu.` (99)
- **H1:** `Kontakt`
- **H2:** `Kontakt podaci` · `Lokacija` (Google Maps embed) · `Radno vreme` · `Zakazivanje pregleda`
- **Sadržaj:** svi NAP elementi su `[POTVRDITI SA KLIJENTOM]` — vidi sekciju 8.
- **alt:** `Ulaz u ordinaciju Hope Dental` `[foto nije potvrđena]`

### 5.17 Interno povezivanje — pravila
1. **Simptom → usluga → kontakt** je glavna putanja. Svaka simptomska stranica mora imati link na `/usluge/parodontologija/` u sekciji „Kako se leči“.
2. Svaka stranica usluge linkuje na **najmanje 2** druge usluge kontekstualno (ne u podnožju).
3. `/parodontopatija/` je hub — linkuje na sve 4 simptomske, i svaka od njih vraća link na hub (breadcrumb + kontekstualno).
4. Anchor tekst = ciljna ključna reč stranice, ne „klikni ovde“; identičan anchor ne ponavljati više od 2× po stranici.
5. Breadcrumbs na svim stranicama dubine 2 (`BreadcrumbList` schema).
6. Nijedna indeksabilna stranica ne sme biti dalje od 2 klika od naslovne.
7. Podnožje: usluge + kontakt + politika privatnosti. Bez linkovanja svih 17 stranica iz podnožja.

---

## 6. Tehnički SEO

### 6.1 Osnovno
- `<html lang="sr-Latn-RS">`
- Jedan `<h1>` po stranici, hijerarhija H2→H3 bez preskakanja
- `<link rel="canonical">` samoreferencijalan na svakoj stranici, apsolutni URL
- Bez `hreflang` (jedna jezička verzija). Ako se doda `/en/`: `hreflang="sr-Latn-RS"` / `hreflang="en"` / `x-default`
- Jedna kanonska varijanta hosta: `https://` + `www` ili bez `www` (odluka pri kupovini domena), 301 sa ostalih
- Trailing slash konzistentno, 301 sa varijante bez
- Favicon: `favicon.ico` + `apple-touch-icon.png` 180×180 + `site.webmanifest`
- Custom 404 sa linkovima na usluge i kontakt
- HTTPS obavezno (konkurent Unident je na HTTP-u — to je greška koju ne ponavljamo)

### 6.2 Open Graph / Twitter (svaka stranica)
```html
<meta property="og:type" content="website">
<meta property="og:locale" content="sr_RS">
<meta property="og:site_name" content="Hope Dental — dr Nada Bojić">
<meta property="og:title" content="<isti kao title, bez brend sufiksa>">
<meta property="og:description" content="<ista meta description>">
<meta property="og:url" content="<canonical>">
<meta property="og:image" content="<apsolutni URL, 1200x630, JPG/PNG>">
<meta property="og:image:alt" content="<opis slike>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="...">
<meta name="twitter:description" content="...">
<meta name="twitter:image" content="...">
```
OG slika: jedna generička za sajt + po jedna za 4 simptomske stranice (najviše se dele). **Ne stavljati telefon ni adresu u OG sliku** dok nisu potvrđeni.

### 6.3 Schema.org JSON-LD

**A) `Dentist` — na naslovnoj i `/kontakt/`.**
Bez `address` (nije poznata), bez `telephone`, bez `openingHoursSpecification`, bez `priceRange`, **bez `aggregateRating`** i bez `review`.

```json
{
  "@context": "https://schema.org",
  "@type": "Dentist",
  "@id": "https://PLACEHOLDER-DOMEN/#ordinacija",
  "name": "Hope Dental",
  "alternateName": "Hope Dental — dr Nada Bojić",
  "url": "https://PLACEHOLDER-DOMEN/",
  "image": "https://PLACEHOLDER-DOMEN/img/ordinacija.jpg",
  "medicalSpecialty": "https://schema.org/Dentistry",
  "areaServed": { "@type": "City", "name": "Beograd" },
  "availableLanguage": "sr",
  "employee": { "@id": "https://PLACEHOLDER-DOMEN/#dr-nada-bojic" },
  "sameAs": ["https://www.instagram.com/dmd.nadabojic/"]
}
```

**NE DODAVATI dok klijent ne potvrdi** (svako polje zahteva pisanu potvrdu):
```
"address": { "@type": "PostalAddress",
             "streetAddress": "[POTVRDITI SA KLIJENTOM]",
             "addressLocality": "Beograd",
             "addressRegion":  "[POTVRDITI SA KLIJENTOM — opština]",
             "postalCode":     "[POTVRDITI SA KLIJENTOM]",
             "addressCountry": "RS" }
"telephone": "[POTVRDITI SA KLIJENTOM]"
"email":     "[POTVRDITI SA KLIJENTOM]"
"geo": { "@type": "GeoCoordinates",
         "latitude": "[POTVRDITI]", "longitude": "[POTVRDITI]" }
"openingHoursSpecification": "[POTVRDITI SA KLIJENTOM]"
"hasMap": "[POTVRDITI — Google Business Profile URL]"
"founder": "[POTVRDITI — da li je vlasnica ili zaposlena]"
```
**Nikada bez osnova:** `priceRange`, `aggregateRating`, `review`.

**B) `Person` — na `/o-meni/`**
```json
{
  "@context": "https://schema.org",
  "@type": "Person",
  "@id": "https://PLACEHOLDER-DOMEN/#dr-nada-bojic",
  "name": "Nada Bojić",
  "honorificPrefix": "dr",
  "jobTitle": "Spec. dr parodontologije i oralne medicine",
  "description": "Parodontologija, oralna medicina i estetska medicina lica, Beograd.",
  "knowsAbout": ["Parodontologija", "Oralna medicina", "Parodontološka hirurgija", "Fiksna protetika", "Estetska medicina lica"],
  "worksFor": { "@id": "https://PLACEHOLDER-DOMEN/#ordinacija" },
  "url": "https://PLACEHOLDER-DOMEN/o-meni/",
  "sameAs": ["https://www.instagram.com/dmd.nadabojic/"]
}
```
`[POTVRDITI SA KLIJENTOM]` pre dodavanja:
- `alumniOf` — fakultet i godina diplomiranja: **nepoznato**
- `hasCredential` — formalni status specijalista vs. specijalizant: **NEPOTVRĐEN**. `jobTitle` gore je citat iz njenog javnog bio-a. Dok ne stigne pisana potvrda, ne dodavati `hasCredential` i ne pisati „specijalista“ u title/H1 tagovima.
- `memberOf` — Stomatološka komora Srbije, broj licence: **nepoznato**
- `telephone`, `email` — **nepoznato**

**C) `MedicalProcedure` — po jedna na svakoj stranici usluge**
```json
{
  "@context": "https://schema.org",
  "@type": "MedicalProcedure",
  "name": "Lečenje parodontopatije",
  "alternateName": "Parodontološka terapija",
  "procedureType": "https://schema.org/TherapeuticProcedure",
  "bodyLocation": "Zubno meso i parodoncijum",
  "howPerformed": "Pregled i parodontalni status, uklanjanje zubnog kamenca i naslaga, kiretaža i obrada korenova, terapija održavanja.",
  "preparation": "Klinički pregled i, po potrebi, radiografska dijagnostika.",
  "followup": "Kontrolni pregledi i terapija održavanja po planu.",
  "url": "https://PLACEHOLDER-DOMEN/usluge/parodontologija/",
  "provider": { "@id": "https://PLACEHOLDER-DOMEN/#ordinacija" }
}
```
Analogno: `Parodontološka hirurgija` (`SurgicalProcedure`), `Oralna hirurgija` (`SurgicalProcedure`), `Fiksna protetika`, `Oralna medicina` (`DiagnosticProcedure`), i po jedna za botoks / filere / PRP / skinbooster na `/usluge/estetska-medicina/`.
**Bez `cost` i `offers` polja — cene nisu poznate.**

**D) `FAQPage`** — na `/pitanja-i-odgovori/`, i `FAQPage` blokovi na stranicama koje imaju vidljiv FAQ (parodontologija, 4 simptomske, estetska medicina). Pravilo: schema sadrži **samo** pitanja koja su vidljiva korisniku na istoj stranici.

**E) `BreadcrumbList`** na svim stranicama dubine 2.

**F) `WebSite`** na naslovnoj (`name`, `url`, `inLanguage: "sr-RS"`, `publisher` → `@id` ordinacije). Bez `SearchAction` (nema pretrage na sajtu).

**Validacija pre objave:** Google Rich Results Test + Schema Markup Validator, nula grešaka. Proveriti da u izlazu nigde nema reči `PLACEHOLDER` ni `[POTVRDITI`.

### 6.4 `robots.txt`

**Demo režim (važi odmah):**
```
User-agent: *
Disallow: /
```

**Posle prihvatanja (produkcija):**
```
User-agent: *
Allow: /
Disallow: /politika-privatnosti/

Sitemap: https://DOMEN/sitemap.xml
```

### 6.5 `sitemap.xml`
- Sve 16 indeksabilnih stranica, apsolutni canonical URL-ovi, `<lastmod>` iz realnog datuma izmene.
- **Ne uključivati:** `/politika-privatnosti/`, 404, bilo koju `noindex` stranicu.
- Bez `<priority>` i `<changefreq>` (Google ih ignoriše).
- U demo režimu sitemap postoji u repozitorijumu ali se **ne prijavljuje** u Search Console.

### 6.6 Demo režim — tačna lista izmena pri objavi

Dok klijentkinja ne prihvati sajt, obavezno:
1. `<meta name="robots" content="noindex, nofollow">` u `<head>` **svake** stranice
2. `robots.txt` = `Disallow: /`
3. Sitemap nije prijavljen u Search Console
4. HTTP header `X-Robots-Tag: noindex` na nivou servera (dvostruka zaštita; obavezno ako je demo na poddomenu tipa `demo.*`)
5. Bazična HTTP autentifikacija na demo URL-u, ako je okruženje podržava
6. Svi `[POTVRDITI SA KLIJENTOM]` placeholderi **vidljivi u tekstu**, da ih klijentkinja primeti pri pregledu
7. Bez `tel:` i `mailto:` linkova sa izmišljenim vrednostima — dugme postoji, vrednost je `[POTVRDITI SA KLIJENTOM]`
8. Bez pre/posle fotografija i bez stock fotografija koje izgledaju kao njena ordinacija

**Pri objavi (checklist, po ovom redu):**

| # | Akcija |
|---|---|
| 1 | Dobijena pisana potvrda: ime, titula/status, naziv ordinacije, adresa, telefon, mejl, radno vreme |
| 2 | Svi `[POTVRDITI SA KLIJENTOM]` zamenjeni stvarnim vrednostima — pretraga po repozitorijumu mora vratiti 0 rezultata |
| 3 | `PLACEHOLDER-DOMEN` zamenjen stvarnim domenom u svim canonical, OG i `@id` poljima |
| 4 | Uklonjen `noindex` meta tag sa svih stranica osim `/politika-privatnosti/` |
| 5 | Uklonjen `X-Robots-Tag` header i HTTP autentifikacija |
| 6 | `robots.txt` prebačen na produkcijsku verziju |
| 7 | `address`, `telephone`, `email`, `openingHoursSpecification`, `geo` dodati u `Dentist` schemu |
| 8 | Schema revalidirana (Rich Results Test) |
| 9 | 301 redirekcije: HTTP→HTTPS, non-www→www (ili obrnuto), bez slash→sa slash |
| 10 | Search Console: verifikacija domena, prijava `sitemap.xml`, provera indeksiranja |
| 11 | Google Business Profile otvoren, verifikovan i povezan sa sajtom |
| 12 | Core Web Vitals izmereni na produkciji (PageSpeed Insights, mobilni) |

---

## 7. FAQ — pitanja za `/pitanja-i-odgovori/` i `FAQPage` schema

Izvedeno iz obrazaca pretrage po simptomu (`web-research.md` 6.1-C) i iz tema koje dominiraju SERP-om za `krvarenje desni` i `lečenje parodontopatije` (WebSearch, 27.10.2026.). **Odgovore piše Copywriter — bez obećanja ishoda, bez cena, bez poređenja.**

**Parodontologija**
1. Zašto mi krvare desni kada perem zube?
2. Da li se parodontopatija može izlečiti? *(odgovor: zavisi od faze — cilj terapije je zaustavljanje napredovanja i održavanje; bez tvrdnje o izlečenju)*
3. Koja je razlika između gingivitisa i parodontopatije?
4. Koliko često treba uklanjati zubni kamenac?
5. Boli li kiretaža i koliko traje oporavak? *(bez tvrdnje „bezbolno“)*
6. Da li se povučene desni mogu vratiti?
7. Mogu li da izgubim zub zbog bolesti desni?
8. Zašto imam loš zadah i ima li to veze sa desnima?
9. Mogu li da se rade implanti ili fiksna proteza ako imam parodontopatiju?
10. Da li pušenje utiče na zdravlje desni?

**Pregled i organizacija** `[POTVRDITI: način zakazivanja, trajanje pregleda]`
11. Šta obuhvata prvi pregled kod parodontologa?
12. Koliko traje kompletna parodontološka terapija? *(okvirno, bez obećanja)*

**Estetska medicina lica**
13. Zašto bi estetske tretmane lica radio stomatolog?
14. Koliko traje efekat botoksa i filera?
15. Ko ne bi trebalo da radi ove tretmane?

**Pravilo:** po stranici usluge biraju se 3–4 najrelevantnija pitanja i markiraju `FAQPage`; na `/pitanja-i-odgovori/` idu sva. Isto pitanje se ne markira `FAQPage` na dve stranice.

---

## 8. Lokalni SEO — NAP i preporuke klijentkinji

### 8.1 NAP (Name, Address, Phone) — kanonski zapis

> **Ovo je šablon, ne podatak.** Nijedno polje ispod nije poznato osim imena i grada. Jednom potvrđen zapis koristi se **identično, znak za znak**, na sajtu, u Google Business Profile-u i u svakom imeniku.

| Polje | Vrednost |
|---|---|
| Naziv (Name) | `Hope Dental` — **[POTVRDITI: tačan pravni naziv iz APR-a; „Hope Dental“ je iz njenog bio-a, nije provereno kao registrovan naziv]** |
| Doktor | Dr Nada Bojić (**potvrđeno**) |
| Ulica i broj | `[POTVRDITI SA KLIJENTOM]` |
| Poštanski broj | `[POTVRDITI SA KLIJENTOM]` |
| Grad | Beograd (**potvrđeno**) |
| Opština | `[POTVRDITI SA KLIJENTOM]` — Voždovac je **nepotvrđena hipoteza** iz jednog ne-nezavisnog izvora |
| Država | Srbija |
| Telefon | `[POTVRDITI SA KLIJENTOM]` — format `+381 ...` |
| Viber / WhatsApp | `[POTVRDITI SA KLIJENTOM]` |
| Mejl | `[POTVRDITI SA KLIJENTOM]` — preporuka: adresa na sopstvenom domenu, ne gmail (konkurent Donna Dent tu gubi signal) |
| Radno vreme | `[POTVRDITI SA KLIJENTOM]` po danima + subota |
| Geo koordinate | `[POTVRDITI]` — preuzeti iz Google Business Profile-a posle verifikacije |
| Domen | `[POTVRDITI]` — nije kupljen; nijedan domen nije potvrđen kao njen |

**Google Maps embed** na `/kontakt/`: ubacuje se **tek po potvrdi adrese**, sa `loading="lazy"`, u `<iframe>` sa `title` atributom. U demo verziji na tom mestu stoji vidljiv blok `[MAPA — POTVRDITI ADRESU]`, nikako mapa druge lokacije.

### 8.2 Preporuke klijentkinji (akcije koje ona mora da uradi)

Iz `web-research.md`: ne postoji nijedan Google Business Profile, nijedan imenički upis, nijedna indeksirana recenzija. To je, pored sajta, najveća rupa u konverziji — pacijent koji vidi Instagram i „gugla“ ime ne nalazi ništa.

1. **Google Business Profile — prioritet #1 posle sajta.** Otvoriti i verifikovati. Kategorija: *Periodontist* (primarna), *Dentist* i *Oral surgeon* (sekundarne). Uneti NAP identično kanonskom zapisu, povezati sa sajtom, dodati fotografije ordinacije, popuniti sekciju usluga, uključiti poruke.
2. **Recenzije.** Zamoliti zadovoljne pacijente da ostave Google recenziju; odgovarati na svaku. U analizi konkurencije (`web-research.md` 5.3) recenzije sa imenom doktora bile su najjači konverzioni signal na ovom tržištu. Ne kupovati recenzije i ne podsticati ih nagradom.
3. **Imenici — jednaki NAP podaci svuda:** planplus.rs, hipokratija.rs, 011info.com, mirandre.com, zubarinadlanu.rs, doktor.rs, stetoskop.info. Konkurent sa nekonzistentnim telefonima po imenicima tu gubi — mi od starta radimo konzistentno.
4. **Instagram bio link** → naslovna sajta (sada sav saobraćaj staje na DM-u).
5. **Facebook stranica** sa istim NAP podacima.
6. **Domen:** kupiti pre objave. Opcije: naziv ordinacije (jači za brend) ili usluga+grad (jači za lokalnu pretragu, po modelu konkurenta koji je domenom preuzeo lokalni upit). **Proveriti dostupnost pre bilo kakvog pominjanja u materijalima.**
7. **Mejl na sopstvenom domenu**, ne gmail.
8. **Pisane saglasnosti pacijenata** pre bilo koje pre/posle fotografije.
9. **Broj licence Stomatološke komore Srbije** — vredi navesti na `/o-meni/`, jer pacijent licencu ne može sam online da proveri (`web-research.md` 3).

---

## 9. Performanse

**Ciljevi (mobilni, 4G, PageSpeed Insights):**

| Metrika | Cilj |
|---|---|
| LCP | < 2.5 s |
| INP | < 200 ms |
| CLS | < 0.1 |
| TTFB | < 0.8 s |
| Ukupna težina stranice | < 1.2 MB |
| Broj zahteva | < 40 |

**Slike**
- Formati: AVIF → WebP → JPG fallback, preko `<picture>`
- **Obavezni `width` i `height` atributi na svakoj slici** (sprečava CLS)
- `loading="lazy"` na svemu osim na hero slici naslovne (ona je `loading="eager"` + `fetchpriority="high"`)
- `decoding="async"`
- `srcset` širine: 480 / 768 / 1200 / 1600 px
- Maks. težina: hero ≤ 180 KB, sadržajne slike ≤ 100 KB, OG slika 1200×630
- Portret dr Nade: maks. 800 px širine na mobilnom
- Alt tekst na svakoj sadržajnoj slici; dekorativne `alt=""`

**Font**
- Maks. 2 familije, maks. 4 fajla (`.woff2`)
- `font-display: swap`
- `<link rel="preload" as="font" type="font/woff2" crossorigin>` za primarni font
- Self-hosting (bez Google Fonts CDN-a — bolji TTFB i GDPR)

**Ostalo**
- Kritični CSS inline, ostatak odloženo; bez CSS framework-a za sajt od 17 stranica
- Minimalan JS, bez jQuery; `defer` na svemu
- Google Maps iframe: `loading="lazy"` + click-to-load (teži je od cele stranice)
- Brotli/gzip kompresija, HTTP/2, `Cache-Control: max-age=31536000, immutable` za statiku sa heš imenima
- Bez analitike u demo režimu; po objavi — GA4 ili lakša alternativa (Plausible/Umami), uz cookie napomenu
- Bez embedovanih Instagram widgeta (teški su); ručno uvezene slike + link na profil

---

## 10. Merenje uspeha (po objavi)

| Period | Šta se meri |
|---|---|
| Nedelja 1 | Search Console verifikovan, sitemap prijavljen, 0 grešaka u indeksiranju, Rich Results bez grešaka |
| Mesec 1 | Sve 16 indeksabilnih stranica indeksirano; Google Business Profile verifikovan; Core Web Vitals u „Good“ |
| Mesec 3 | Pozicije za `parodontolog Beograd` i 4 simptomska upita u Search Console; prvih 5–10 Google recenzija |
| Mesec 6 | Organski klikovi po stranici; koje simptomske stranice donose upite; odluka o fazi 2 (lokalne stranice po opštini, cenovnik, EN verzija) |

Bez ciljanih brojeva pozicija ili saobraćaja — za novi domen bez istorije svaka takva prognoza bila bi izmišljena.

---

## 11. Otvorena pitanja koja blokiraju objavu

| # | Pitanje | Blokira |
|---|---|---|
| 1 | Tačna adresa ordinacije (ulica, broj, poštanski broj, opština) | `/kontakt/`, schema `address`, mapa, Google Business Profile, lokalni SEO u celosti |
| 2 | Telefon (i Viber/WhatsApp) | glavni CTA na svakoj stranici |
| 3 | Mejl | `/kontakt/`, forma |
| 4 | Radno vreme po danima | `/kontakt/`, schema `openingHoursSpecification` |
| 5 | Formalni status: specijalista ili specijalizant parodontologije i oralne medicine (pisano) | `/o-meni/`, `Person` schema, formulacije u title/H1 |
| 6 | Tačan pravni naziv ordinacije (APR) i da li je vlasnica ili zaposlena | `name` i `founder` u schemi, celo brendiranje |
| 7 | Edukacija/dozvola za estetsku medicinu lica | `/usluge/estetska-medicina/` |
| 8 | Fakultet, godina diplomiranja, godine iskustva, sertifikati | `/o-meni/` |
| 9 | Broj licence Stomatološke komore | `/o-meni/` (opciono, ali vredno) |
| 10 | Domen (koji, i da li je kupljen) | canonical, OG, schema `@id`, sitemap, robots |
| 11 | Pisane saglasnosti pacijenata za pre/posle fotografije | `/rezultati/` (do tada se stranica ne pravi) |
| 12 | Da li se objavljuje cenovnik i u kom obliku | `/cenovnik/`, `offers` u schemi |
| 13 | Način zakazivanja (telefon / forma / WhatsApp / kalendar) | CTA strategija, FAQ pitanja 11–12 |
| 14 | Cilja li dentalni turizam / dijasporu | odluka o `/en/` i `hreflang` |
| 15 | Postoji li već Google Business Profile ili Facebook stranica koju nismo našli | lokalni SEO plan, izbegavanje duplikata |
