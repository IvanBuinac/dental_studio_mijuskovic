# Slike sajta (`site/assets/img/`)

Sajt prikazuje placeholder (ime fajla + opis) na svakom mestu gde fajl ne postoji. Kada se ovde doda fajl **sa tačnim imenom**, slika se prikazuje sama, bez izmene HTML-a.

- Format: WebP, kvalitet 80–85 (og-cover i kao `.jpg` za društvene mreže).
- Pre/posle se uvek isporučuje kao par `-pre` / `-posle` istog kadra, odnosa i veličine (3:2).
- `width`/`height` u HTML-u su upisani prema stvarnim dimenzijama postojećih fajlova (vidi `assets/manifest.md`); za nove fajlove važe dimenzije iz tabele. Ako se doda fajl drugačijih dimenzija istog odnosa, prikaz je ispravan (CSS `aspect-ratio` + `object-fit: cover`).
- Slučaj na `/rezultati/` za koji nema fotografija treba ukloniti iz HTML-a pre objave (u demu se prikazuje placeholder).

Stanje na dan izrade: 24 od 43 očekivanih fajlova postoji.

| Fajl | Stranica | Dimenzije (Mapa slika) | Šta prikazuje | Stanje |
|---|---|---|---|---|
| `logo.webp` | sve (header, footer) | visina 48px, izvoz 2× (96px), providna pozadina | Logo „Dental Studio Mijušković“; bez njega ostaje tekstualni wordmark | ima (168×96) |
| `og-cover.jpg (+ og-cover.webp)` | og:image / twitter:image, sve stranice | 1200×630 | Doktor ili osmeh + logo na #0B3B46 podlozi | ima (1200×630) |
| `hero.webp` | / (hero) | 4:5, 1200×1500 | Dr Mijušković u ordinaciji: radni portret, mantil, svetao prostor | ima (1200×1500) |
| `doctor-portrait.webp` | / (Specijalista), /o-nama/ (hero) | 4:5, 1000×1250 | Profesionalni portret u belom mantilu, svetla pozadina | ima (900×1125) |
| `doctor-konsultacija.webp` | /o-nama/ (Kako radimo) | 16:9, 1920×1080 | Doktor u razgovoru sa pacijentom / pregled snimka | ima (1440×810) |
| `tim.webp (opciono)` | /o-nama/ (Tim) | 3:2, 1600×1067 | Tim ordinacije | ima (900×600) |
| `usluga-lumineeri.webp` | /, /usluge/, /usluge/lumineeri/ | 4:3, 1600×1200 (na početnoj isečeno 3:4) | Makro osmeh sa lumineerima (posle) | ima (956×717) |
| `usluga-protetika.webp` | /, /usluge/, /usluge/protetika/ | 4:3, 1600×1200 | Bezmetalne krunice ili most, makro | ima (1600×1200) |
| `usluga-implanti.webp` | /, /usluge/, /usluge/implanti/ | 4:3, 1600×1200 | Završen rad na implantu ili fiksni rad, makro | **nedostaje** |
| `usluga-izbeljivanje.webp` | /, /usluge/, /usluge/izbeljivanje/ | 4:3, 1600×1200 | Svetao osmeh ili lampa za izbeljivanje | ima (1265×949) |
| `detalj-fasete.webp` | / (galerija, 1:1), /usluge/lumineeri/ | 4:5, 1200×1500 | Gotove keramičke fasete na modelu, makro | **nedostaje** |
| `detalj-boja.webp` | / (galerija, 1:1; skriveno na mobilnom), /usluge/protetika/, /usluge/izbeljivanje/ | 4:5, 1200×1500 | Ključ boja pored zuba pacijenta | **nedostaje** |
| `detalj-preciznost.webp` | /o-nama/, /usluge/implanti/ | 4:5, 1200×1500 | Ruke doktora sa instrumentima ili lupama | ima (900×1125) |
| `ordinacija-stolica.webp` | / (galerija), /o-nama/ | 3:2, 1600×1067 | Glavna stomatološka jedinica | **nedostaje** |
| `ordinacija-prostor.webp` | / (galerija), /o-nama/ | 3:2, 1600×1067 | Širi kadar radnog prostora | **nedostaje** |
| `ordinacija-prijem.webp` | /o-nama/, /kontakt/ (hero, 4:3) | 3:2, 1600×1067 | Prijemni pult ili čekaonica | **nedostaje** |
| `ordinacija-sterilizacija.webp` | /o-nama/ | 3:2, 1600×1067 | Sterilizacija i sterilni instrumenti | **nedostaje** |
| `ba-lumineeri-01-pre.webp` | /, /usluge/lumineeri/, /rezultati/ | 3:2, 1200×800 (par identičnog kadra) | PRE: Lumineeri, slučaj 1; makro osmeha, bez očiju i lica | ima (796×531) |
| `ba-lumineeri-01-posle.webp` | /, /usluge/lumineeri/, /rezultati/ | 3:2, 1200×800 (par identičnog kadra) | POSLE: Lumineeri, slučaj 1; makro osmeha, bez očiju i lica | ima (796×531) |
| `ba-lumineeri-02-pre.webp` | /usluge/lumineeri/, /rezultati/ | 3:2, 1200×800 (par identičnog kadra) | PRE: Lumineeri, slučaj 2; makro osmeha, bez očiju i lica | ima (801×534) |
| `ba-lumineeri-02-posle.webp` | /usluge/lumineeri/, /rezultati/ | 3:2, 1200×800 (par identičnog kadra) | POSLE: Lumineeri, slučaj 2; makro osmeha, bez očiju i lica | ima (801×534) |
| `ba-lumineeri-03-pre.webp` | /rezultati/ | 3:2, 1200×800 (par identičnog kadra) | PRE: Lumineeri, slučaj 3; makro osmeha, bez očiju i lica | ima (900×600) |
| `ba-lumineeri-03-posle.webp` | /rezultati/ | 3:2, 1200×800 (par identičnog kadra) | POSLE: Lumineeri, slučaj 3; makro osmeha, bez očiju i lica | ima (900×600) |
| `ba-lumineeri-04-pre.webp` | /rezultati/ | 3:2, 1200×800 (par identičnog kadra) | PRE: Lumineeri, slučaj 4; makro osmeha, bez očiju i lica | ima (796×531) |
| `ba-lumineeri-04-posle.webp` | /rezultati/ | 3:2, 1200×800 (par identičnog kadra) | POSLE: Lumineeri, slučaj 4; makro osmeha, bez očiju i lica | ima (796×531) |
| `ba-lumineeri-05-pre.webp` | /rezultati/ | 3:2, 1200×800 (par identičnog kadra) | PRE: Lumineeri, slučaj 5; makro osmeha, bez očiju i lica | ima (796×531) |
| `ba-lumineeri-05-posle.webp` | /rezultati/ | 3:2, 1200×800 (par identičnog kadra) | POSLE: Lumineeri, slučaj 5; makro osmeha, bez očiju i lica | ima (796×531) |
| `ba-lumineeri-06-pre.webp` | /rezultati/ | 3:2, 1200×800 (par identičnog kadra) | PRE: Lumineeri, slučaj 6; makro osmeha, bez očiju i lica | **nedostaje** |
| `ba-lumineeri-06-posle.webp` | /rezultati/ | 3:2, 1200×800 (par identičnog kadra) | POSLE: Lumineeri, slučaj 6; makro osmeha, bez očiju i lica | **nedostaje** |
| `ba-protetika-01-pre.webp` | /, /usluge/protetika/, /rezultati/ | 3:2, 1200×800 (par identičnog kadra) | PRE: Cirkonijum krunice: stari metalokeramički rad → bezmetalna keramika; makro osmeha, bez očiju i lica | ima (801×534) |
| `ba-protetika-01-posle.webp` | /, /usluge/protetika/, /rezultati/ | 3:2, 1200×800 (par identičnog kadra) | POSLE: Cirkonijum krunice: stari metalokeramički rad → bezmetalna keramika; makro osmeha, bez očiju i lica | ima (801×534) |
| `ba-protetika-02-pre.webp` | /usluge/protetika/, /rezultati/ | 3:2, 1200×800 (par identičnog kadra) | PRE: Cirkonijum ili E.max, slučaj 2; makro osmeha, bez očiju i lica | ima (796×531) |
| `ba-protetika-02-posle.webp` | /usluge/protetika/, /rezultati/ | 3:2, 1200×800 (par identičnog kadra) | POSLE: Cirkonijum ili E.max, slučaj 2; makro osmeha, bez očiju i lica | ima (796×531) |
| `ba-protetika-03-pre.webp` | /rezultati/ | 3:2, 1200×800 (par identičnog kadra) | PRE: Bezmetalni most; makro osmeha, bez očiju i lica | **nedostaje** |
| `ba-protetika-03-posle.webp` | /rezultati/ | 3:2, 1200×800 (par identičnog kadra) | POSLE: Bezmetalni most; makro osmeha, bez očiju i lica | **nedostaje** |
| `ba-protetika-04-pre.webp` | /rezultati/ | 3:2, 1200×800 (par identičnog kadra) | PRE: Kompletna rekonstrukcija zagrižaja; makro osmeha, bez očiju i lica | **nedostaje** |
| `ba-protetika-04-posle.webp` | /rezultati/ | 3:2, 1200×800 (par identičnog kadra) | POSLE: Kompletna rekonstrukcija zagrižaja; makro osmeha, bez očiju i lica | **nedostaje** |
| `ba-implanti-01-pre.webp` | /usluge/implanti/, /rezultati/ | 3:2, 1200×800 (par identičnog kadra) | PRE: Jedan zub u estetskoj zoni (implant + bezmetalna krunica); makro osmeha, bez očiju i lica | **nedostaje** |
| `ba-implanti-01-posle.webp` | /usluge/implanti/, /rezultati/ | 3:2, 1200×800 (par identičnog kadra) | POSLE: Jedan zub u estetskoj zoni (implant + bezmetalna krunica); makro osmeha, bez očiju i lica | **nedostaje** |
| `ba-implanti-02-pre.webp` | /usluge/implanti/, /rezultati/ | 3:2, 1200×800 (par identičnog kadra) | PRE: Fiksni rad All-on-4 / All-on-6; makro osmeha, bez očiju i lica | **nedostaje** |
| `ba-implanti-02-posle.webp` | /usluge/implanti/, /rezultati/ | 3:2, 1200×800 (par identičnog kadra) | POSLE: Fiksni rad All-on-4 / All-on-6; makro osmeha, bez očiju i lica | **nedostaje** |
| `ba-izbeljivanje-01-pre.webp` | /usluge/izbeljivanje/, /rezultati/ | 3:2, 1200×800 (par identičnog kadra) | PRE: Pre i posle ordinacijskog izbeljivanja (opciono); makro osmeha, bez očiju i lica | **nedostaje** |
| `ba-izbeljivanje-01-posle.webp` | /usluge/izbeljivanje/, /rezultati/ | 3:2, 1200×800 (par identičnog kadra) | POSLE: Pre i posle ordinacijskog izbeljivanja (opciono); makro osmeha, bez očiju i lica | **nedostaje** |

Dodatni fajl koji postoji, a sajt ga ne koristi direktno: `logo.png` (izvor/rezerva logotipa).
