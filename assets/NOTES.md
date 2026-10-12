# NOTES: slike za Dental Studio Mijušković

**Datum:** 12. oktobar 2026.

## Neiskorišćene raw slike

| Raw fajl | Šta je na slici | Zašto nije iskorišćena |
|---|---|---|
| `651934138_18073124828193552_6973992523363613263_n.webp` | Dr Mijušković privatno, u beloj košulji, sa naočarima za sunce i čašom vina na vidikovcu iznad Boke | Privatna slika, ne profesionalna. Vino i naočare ne odgovaraju tonu medicinskog sajta. |
| `652734725_18119239246620704_2074376585232623955_n.webp` | Isto okruženje, doktor stoji uz ogradu, panorama Boke kotorske | Isti razlog. Može da posluži samo za neformalnu „o meni“ priču ako to klijent izričito želi. |
| `800449748_18093442499450514_1434166533784504876_n.jpg` | Studijski portret pacijentkinje posle lumineera, crna pozadina, celo lice | Lice pacijentkinje se jasno prepoznaje. Nijedno mesto u Mapi ne traži ovakav kadar. Može kasnije za `/rezultati/` ili za svedočanstvo, ali **samo uz pisanu saglasnost pacijentkinje**. |

## Mesta iz Mape slika bez fotografije: kako su rešena (12. 10. 2026)

Odluka klijenta: „Slike implantata nemam niti ću ih imati… Slike ordinacije i čekaonice imam jednu, tako da koristi to što imaš, a da ostane struktura sajta ista.“ Na sajtu više nema nijednog placeholdera.

| Fajl iz Mape | Rešenje |
|---|---|
| `ordinacija-prijem.webp` | **Popunjeno** novom slikom `images.jpg` (čekaonica, hodnik, recepcija, logo na zidu). Koristi se na početnoj (galerija), na `/o-nama/` (galerija) i kao hero na `/kontakt/` (okvir 3:4, najviše 400px širine, da mala slika ne bude razvučena). |
| `ordinacija-stolica.webp`, `ordinacija-prostor.webp`, `ordinacija-sterilizacija.webp` | **Uklonjeno.** Galerija na početnoj je sa 4 na 3 polja: `ordinacija-prijem` (visoka) + `tim` + `detalj-preciznost`. Galerija na `/o-nama/` je sa 4 (2×2) na 3 polja u redu: `ordinacija-prijem` + `usluga-izbeljivanje` (lampa i stolica u ordinaciji) + `hero` (rad sa lupama). Nijedna slika se ne ponavlja u istoj sekciji. Sekcije i naslovi su ostali. |
| `usluga-implanti.webp` | **Zamenjeno SVG ilustracijom** `usluga-implanti.svg`: linijski implant, abatment i krunica u brend paleti. Klijent neće imati fotografije. |
| `detalj-fasete.webp` | **Zamenjeno SVG ilustracijom** `detalj-fasete.svg` (prednji zubi + tanka faseta), isti stil kao implant. |
| `detalj-boja.webp` | **Zamenjeno SVG ilustracijom** `detalj-boja.svg` (ključ boja, A1–C1). Na početnoj ga više nema, jer je galerija ordinacije preuređena. |
| `ba-implanti-01/02` | **Uklonjeno** sa `/rezultati/` i sa `/usluge/implanti/`. Na implantima je umesto „Pre i posle“ sekcija „Konsultacija: prvi korak“ (šta dobijate na pregledu + CTA „Zakažite konsultaciju“). Tab „Implanti“ u filteru je uklonjen. |
| `ba-izbeljivanje-01` | **Uklonjeno** sa `/rezultati/`, uz tab „Izbeljivanje“. Sekcija „Pre i posle“ na `/usluge/izbeljivanje/` je uklonjena; stranica ide Postupak → Pitanja. |
| `ba-lumineeri-06`, `ba-protetika-03/04` | **Uklonjeno** sa `/rezultati/`. Ostaje 7 slučajeva (5 lumineera, 2 protetike), brojač se računa sam. |

Ako klijent kasnije pošalje fotografije enterijera ili nove slučajeve, dodaju se kao novi fajlovi i ubacuju u HTML (sajt više ne prikazuje prazna mesta sam od sebe).

## Kompromisi koje treba proveriti

- **`ordinacija-prijem.webp`** je mala (387×516). Na ekranima visoke rezolucije je blago meka. Za oštriji prikaz treba tražiti original iz telefona (bez kompresije iz poruke/IG-a).
- **`hero.webp`** se sada pojavljuje i u galeriji na `/o-nama/`, a `usluga-izbeljivanje.webp` i u galeriji ordinacije na `/o-nama/`. To su radni kadrovi iz ordinacije, ne fotografije enterijera.

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

Pre objave sajta treba od klijenta dobiti **pisanu potvrdu da postoji saglasnost svakog pacijenta** čije su fotografije u `ba-*` parovima, kao i pacijentkinja na `hero.webp` i `doctor-konsultacija.webp`. Saglasnost treba da važi za objavu na veb-sajtu, a ne samo na Instagramu. Ako za neki slučaj saglasnost ne postoji, treba ukloniti i par iz `site/assets/img/` i njegov `<li class="case">` iz HTML-a (placeholdera više nema). Treba tražiti i originalne fajlove u punoj rezoluciji, bez vodenog žiga.
