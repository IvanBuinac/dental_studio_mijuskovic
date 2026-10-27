# NOTES — obrada slika @dmd.nadabojic (27.10.2026.)

Ulaz: 16 fotografija u `Assets/Raw/` (ručno obezbedio korisnik). Izlaz: 31 WebP fajl u `site/assets/img/`.
Sve slike su pregledane pojedinačno pre obrade.

---

## 1. BLOKIRANO — ne koristiti

| Raw fajl | Šta je na slici | Razlog |
|---|---|---|
| `491414133_18018871118651179_7614683932815451667_n.jpg` | Selfi doktorke sa **detetom-pacijentom u stolici**, lice deteta jasno vidljivo i prepoznatljivo | **Maloletno lice.** Ne sme se koristiti ni u kropovanom obliku. Blokirano do **pismene saglasnosti roditelja/staratelja**. Ako saglasnost stigne, i dalje preporučujem da se ne objavljuje — za sajt nema sadržajnu vrednost koju druge slike ne pokrivaju. |

Ni jedna druga slika nije u potpunosti odbačena.

## 2. Privatnost — provereno i rešeno

- **`503984767` (oralno-hirurški zahvat)** — provereno uvećanjem originala: pacijentu se vidi **samo usna duplja i deo donjeg lica**, oči nisu u kadru i lice nije prepoznatljivo. Kadar je dodatno kropovan (`proces-hirurgija.webp`).
  - Na istoj slici, na **ekranu laptopa u pozadini vidi se lice treće osobe** (muzički snimak). Taj deo je **zamućen** mekim, feder-maskiranim zamućenjem.
  - Na slici se vide i reklamni posteri proizvođača (parodontax / Sensodyne) u pozadini — pravno bezopasno, ali nije idealno za brend; zameniti kada stignu nove fotografije ordinacije.
- **`661899857` (rendgen)** — u kadru je **osoba iz tima snimljena s leđa/u profilu**, vide se samo kosa, uvo i deo obraza; lice nije prepoznatljivo. Nema pacijenta u kadru. Na rendgenskom snimku nema identifikacionih podataka (ime pacijenta nije čitljivo). Korišćeno.
- Svi ostali intraoralni i makro kadrovi su **usta bez lica** — u skladu sa pravilom, ali **i dalje traže saglasnost pacijenta** (vidi tačku 5).
- `513974491` i `622161443` prikazuju usne i deo brade/obraza. Nije prepoznatljivo lice, ali je blizu granice — ako klijent nema saglasnost, ove dve prvo izbaciti.

## 3. Vodeni žigovi i utisnuti tekst — šta je urađeno

Brend-žig „DMD Nada Bojić“ / „dmd Nada Bojić“ **ostaje netaknut** na spojenim (rezervnim) varijantama `ba-*.webp`. Nijedan žig nije presečen na pola.

Kod deljenja kolaža na pre/posle parove žig i oznake „Pre“/„Posle“ su uklonjeni, jer ih sajt prikazuje svojim UI-jem:

| Raw | Metod | Detalj |
|---|---|---|
| `510877184` | retuš (OpenCV inpaint, maska po glifovima) | uklonjeni „Pre“, „Posle“ i žig u sredini kolaža |
| `513974491` | retuš (inpaint) | uklonjen žig na spoju panela |
| `622161443` | krop | žig i oznake su na crnoj podlozi **van** foto-panela, pa su samo odsečeni |
| `621843876` | krop | žig je u gornjem delu donjeg panela; kadar je pomeren ispod njega, bez retuša. Takođe odsečene bele ivice i kosi spoj. Vertikalni natpisi „PRE“/„POSLE“ su bili van panela. |
| `622896017` | retuš (inpaint po lokalnom kontrastu) | sivo-bele oznake „Pre“/„Posle“ preko desni |
| `625968056` | krop | velike oznake „Pre“/„Posle“ i žig su na ivicama panela, odsečeni; par je dodatno sužen po širini da ne bude previše izdužen |
| `656013334` | krop | beli natpisi „Pre operacije“ i „Odmah nakon operacije…“ odsečeni |
| `661899857` | krop | utisnut tekst „ŠTA SVE STOMATOLOG MOŽE VIDETI NA SNIMKU??“ odsečen |

Retuš je vizuelno proveren na svakoj izlaznoj slici — nema vidljivih ostataka slova ni mrlja.

## 4. Kvalitet — ograničenja koja treba znati

- Sve slike su **Instagram kopije**, ne originali. Rezolucije su 720–3464 px, većina 1440 px. Specifikacija iz `image-shortlist.md` traži min. 2000 px (3000 px za hero) — **to nijedna slika osim `625968056` ne ispunjava.** Nije rađeno veštačko uvećavanje.
- `ordinacija-01.webp` je izvučen iz pozadine hero fotografije i zato je **neoštar (bokeh)**. Koristiti malo i sitno, ili zameniti čim stigne prava fotografija ordinacije.
- `detalj-implant.webp` je najmanji fajl u setu (720×900) i blago mutan — ne koristiti preko cele širine ekrana.
- Nema nijedne horizontalne fotografije. Hero je dobijen kropovanjem kvadrata u 3:2, zato je visina 960 px (nije bilo moguće doći do 1600×900 bez uvećavanja).

## 5. Saglasnost pacijenata — OBAVEZNO pre objave

**Pre nego što sajt ode u produkciju, od klijentkinje treba pribaviti pismenu saglasnost pacijenata za svaku sledeću sliku:**

- svih 7 pre/posle slučajeva (`ba-estetika-01..03`, `ba-protetika-01..03`, `ba-hirurgija-01`) — i parove i spojene varijante
- `proces-hirurgija.webp` (hirurški zahvat na pacijentu)
- `detalj-implant.webp` i `osmeh-rezultat.webp` (intraoralni snimci)
- `proces-rtg.webp` (rendgenski snimak je medicinski podatak pacijenta)

Činjenica da su fotografije već objavljene na Instagramu **ne znači** da postoji saglasnost za objavu na sajtu. Dok saglasnost ne stigne, pre/posle sekciju držati isključenu ili sa placeholderima. Preporuka: tražiti potpisan obrazac po pacijentu, sa naznakom „objava na internet stranici ordinacije“.

## 6. Šta nedostaje za kompletan sajt — tražiti od klijentkinje

**Blokirajuće:**
1. **Logo** — ne postoji nijedan logotip u materijalu (ni u vektoru ni u PNG-u). Postoji samo mali beli znak zuba na uniformi na `491414133`, koji je blokiran. Bez logotipa radi se tipografsko rešenje.
2. **Čist portret bez maske i kape** — jedini portret (`629986735`) je selfi u hirurškoj maski; lice se ne vidi. Kod ličnog brenda to je ozbiljan nedostatak. Potrebno: portret do pojasa u mantilu, gleda u objektiv, i jedan širok horizontalni kadar sa praznim prostorom za tekst.
3. **Oštra, horizontalna fotografija ordinacije** (16:9, stolica u centru) — postojeća je samo mutna pozadina.
4. **Fotografija ulaza u zgradu / table sa natpisom** — pacijenti je traže da bi našli ordinaciju; ne postoji.

**Važno ali ne blokirajuće:**
5. Čekaonica i recepcija — **nijedna fotografija**.
6. Sterilizacija (autoklav), rendgen aparat kao celina, eventualni skener — nema.
7. Tim — nema nijedne fotografije tima (na `503984767` se vidi kolega, ali s leđa i bez imena). Nepoznato je da li tim uopšte postoji.
8. Estetska medicina lica (botoks, fileri, PRP, skinbooster) je u bio-u kao usluga, a **u materijalu nema nijedne slike za tu celu kategoriju**. Trenutno se ta sekcija ne može ilustrovati.
9. Diplome / sertifikati, brend detalji (vizit karta, mantil sa logom) — nema.

## 7. Nepromenjeno iz `NAPOMENA-TACNOST.md`

Slike ne rešavaju problem izmišljenih podataka: adresa, telefon, radno vreme, cene i domen i dalje **moraju doći od klijentkinje**. Ništa u ovom setu slika ne potvrđuje lokaciju ni NAP podatke.
