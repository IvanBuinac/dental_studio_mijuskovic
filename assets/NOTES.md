# NOTES: slike za Dental Studio Mijušković

**Datum:** 12. oktobar 2026.

## Neiskorišćene raw slike

| Raw fajl | Šta je na slici | Zašto nije iskorišćena |
|---|---|---|
| `651934138_18073124828193552_6973992523363613263_n.webp` | Dr Mijušković privatno, u beloj košulji, sa naočarima za sunce i čašom vina na vidikovcu iznad Boke | Privatna slika, ne profesionalna. Vino i naočare ne odgovaraju tonu medicinskog sajta. |
| `652734725_18119239246620704_2074376585232623955_n.webp` | Isto okruženje, doktor stoji uz ogradu, panorama Boke kotorske | Isti razlog. Može da posluži samo za neformalnu „o meni“ priču ako to klijent izričito želi. |
| `800449748_18093442499450514_1434166533784504876_n.jpg` | Studijski portret pacijentkinje posle lumineera, crna pozadina, celo lice | Lice pacijentkinje se jasno prepoznaje. Nijedno mesto u Mapi ne traži ovakav kadar. Može kasnije za `/rezultati/` ili za svedočanstvo, ali **samo uz pisanu saglasnost pacijentkinje**. |

## Mesta iz Mape slika koja su ostala bez slike (placeholder ostaje)

| Fajl | Razlog | Šta tražiti od klijenta |
|---|---|---|
| `usluga-implanti.webp` | Nema nijedne slike implanta ni All-on-X rada | Makro završenog rada na implantu, model implanta ili RTG |
| `detalj-fasete.webp` | Nema faseta na modelu. Model na `629750…` je premali za isečak. | Makro gotovih faseta na modelu pre cementiranja |
| `detalj-boja.webp` | Nema kadra sa ključem boja | Ključ boja (shade guide) pored zuba |
| `ordinacija-stolica.webp`, `ordinacija-prostor.webp`, `ordinacija-prijem.webp`, `ordinacija-sterilizacija.webp` | Nijedna slika ne prikazuje prazan prostor. Sve su radne scene. | **Prioritet:** 3–4 fotografije enterijera (stolica, širi kadar, čekaonica i prijem, sterilizacija). Po `structure.md` su deo minimuma za lansiranje. |
| `ba-lumineeri-06-*` | Ima samo 5 slučajeva lumineera | Još jedan slučaj, po želji |
| `ba-protetika-03-*`, `ba-protetika-04-*` | Ima samo 2 slučaja protetike | Bezmetalni most i kompletna rekonstrukcija |
| `ba-implanti-01-*`, `ba-implanti-02-*` | Nema pre/posle za implante | Pojedinačni implant u estetskoj zoni, All-on-4/6 |
| `ba-izbeljivanje-01-*` *(opciono)* | Nema pre/posle izbeljivanja | Osmeh pre i posle ordinacijskog izbeljivanja |

## Kompromisi koje treba proveriti

- **Nema klasičnog portreta doktora** (neutralna pozadina, pogled u kameru). `doctor-portrait.webp` je radni kadar u mantilu (`631798…`), a `hero.webp` je rad sa lupama (`481386…`). Preporuka: profesionalni portret, a zatim zamena `doctor-portrait.webp`.
- **`hero.webp`**: na slici se vidi deo lica pacijentkinje (oči zatvorene, glava naopako, delimično prekrivena rukama doktora). Kadar deluje kao promotivni, ali treba potvrditi da je pacijentkinja saglasna. Isto važi za `og-cover`, koji je napravljen iz iste slike.
- **`doctor-konsultacija.webp`** (`649237…`): lice pacijentkinje se jasno vidi i nasmejana je. Očigledno je promotivna, postavljena fotografija, i objavljena je na IG profilu ordinacije. Ipak treba potvrditi saglasnost. Vodeni žig dole desno je odsečen kropom.
- **`tim.webp`**: nije prava timska fotografija. To je doktor sa asistentkinjom, koju ivica kadra delimično preseca, a lice pacijentkinje je van kadra. Ako klijent pošalje grupnu fotografiju, treba je zameniti.
- **`detalj-preciznost.webp`** (`629750…`): u kadru su doktor i asistentkinja, a pacijent se ne prepoznaje.
- **`usluga-lumineeri.webp`** je „posle“ polovina slučaja `ba-lumineeri-03`. Na `/rezultati/` se zato isti osmeh pojavljuje kao hero lumineera i kao slučaj 3. Na početnoj i na `/usluge/lumineeri/` nema ponavljanja, jer su tamo slučajevi 01 i 02.
- **`usluga-izbeljivanje.webp`** prikazuje lampu za izbeljivanje (Philips/„fläsh“) i pacijenta sa zaštitnim naočarima, pa se ne prepoznaje. Na slici nema osmeha. Alt tekst iz copy.md treba prilagoditi (vidi manifest).
- **Klasifikacija pre/posle** je urađena po izgledu i treba je potvrditi sa doktorom:
  - `ba-protetika-01` (`807682…`) na „pre“ snimku ima tamne rubove uz desni, što liči na stare metalokeramičke krunice.
  - `ba-protetika-02` (`828810…`) prikazuje radove u obe vilice.
  - `ba-lumineeri-05` (`481782…`) je intraoralni snimak sa retraktorom. Može biti i protetika.
- **Vodeni žig** sa logom je retušom uklonjen sa svih pre/posle kolaža (stajao je preko linije spoja). Klinički sadržaj nije menjan.
- B/A parovi su oko 800×534 umesto 1200×800, zbog izvorne rezolucije sa Instagrama. Za oštrije slike treba tražiti originale iz fotoaparata.
- Logo postoji samo kao mali JPG (495×404). `logo.png` i `logo.webp` su oštri samo do 96px visine (header 48px pri 2×). Za oštar prikaz na većim veličinama, i za favicon 512×512, treba tražiti SVG ili veliki PNG.

## Podsetnik: saglasnost pacijenata

Pre objave sajta treba od klijenta dobiti **pisanu potvrdu da postoji saglasnost svakog pacijenta** čije su fotografije u `ba-*` parovima, kao i pacijentkinja na `hero.webp` i `doctor-konsultacija.webp`. Saglasnost treba da važi za objavu na veb-sajtu, a ne samo na Instagramu. Ako za neki slučaj saglasnost ne postoji, taj par treba ukloniti iz `site/assets/img/` i placeholder će se vratiti sam. Treba tražiti i originalne fajlove u punoj rezoluciji, bez vodenog žiga.
