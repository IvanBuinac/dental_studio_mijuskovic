# Image shortlist — @dmd.nadabojic

- Datum: 15.10.2026.
- Namena: ulazni dokument za Asset Collector

## Zasto je ovo specifikacija, a ne lista URL-ova

Uloga nalaze da ovde stoje URL-ovi 15–25 najboljih IG objava. **To u ovoj sesiji nije bilo moguce:** nije bio dostupan alat za pregledac, a `WebFetch` nije mogao da resolvuje nijedan domen (ni `instagram.com`, ni ogledala tipa picuki/imginn/pixwox). Dakle nijedna objava nije videna i nijedan URL se ne moze navesti bez izmisljanja.

Zato je dokument napisan kao **specifikacija materijala** — sta tacno treba isporuciti.

## Gde se slike ostavljaju

Sve slike idu u:

```
/home/user/nadabojic/dmd.nadabojic/assets/raw/
```

**Pravila za fajlove:**
- Originalna rezolucija, bez kompresije i bez Instagram crop-a. Ako postoje fajlovi direktno iz fotoaparata/telefona — ti su prioritet nad onim sto je skinuto sa Instagrama (IG unistava kvalitet i reze format).
- Naziv fajla po semi: `kategorija-opis-broj.jpg` (npr. `portret-ordinacija-01.jpg`, `prostor-cekaonica-03.jpg`).
- Bez screenshot-ova, bez slika sa vodenim znakom druge osobe.
- JPG ili PNG; HEIC konvertovati.

---

## Pregled — koliko ukupno

| Kategorija | Min | Idealno | Prioritet |
|---|---|---|---|
| 1. Portret lekara | 3 | 6 | **Kriticno** |
| 2. Ordinacija / prostor | 4 | 8 | **Kriticno** |
| 3. Tim | 0 | 3 | Srednji |
| 4. Procedure / makro / oprema | 3 | 6 | Visok |
| 5. Pre–posle | 0 | 5 parova | Visok (uz saglasnost) |
| 6. Logo i brending | 1 | 4 | **Kriticno** |
| 7. Detalji / atmosfera | 2 | 5 | Nizak |
| **Ukupno** | **13** | **~35** | |

---

## 1. Portret lekara — min 3, idealno 6

Najvaznija kategorija. Kod licnog brenda lice nosi poverenje.

| # | Sta prikazuje | Odnos stranica | Min rezolucija | Gde se koristi |
|---|---|---|---|---|
| 1.1 | Portret do pojasa, u mantilu, gleda u objektiv, prijateljski izraz, neutralna ili svetla pozadina | 4:5 vertikalno | 2000×2500 px | Sekcija "O meni" na naslovnoj |
| 1.2 | Isti setup, **siroki kadar sa prostorom levo ili desno** (za tekst preko slike) | 16:9 horizontalno | 3000×1688 px | Hero banner naslovne |
| 1.3 | Portret u ordinaciji, pored stolice, opusten, ne mora da gleda u objektiv | 3:2 horizontalno | 2400×1600 px | Stranica "O nama" |
| 1.4 | Glava i ramena, tesno kadrirano, cista pozadina | 1:1 kvadrat | 1200×1200 px | Autor teksta, footer, Google Business, favicon-okruzenje |
| 1.5 | U radu — nagnuta nad pacijentom, sa maskom i rukavicama, fokus na lekaru | 4:5 vertikalno | 2000×2500 px | Sekcija usluga, "Kako radimo" |
| 1.6 | U razgovoru sa pacijentom koji sedi — konsultacija, ne intervencija | 3:2 horizontalno | 2400×1600 px | Stranica "Prvi pregled" / kontakt |

Napomene: mantil cist i bez gužvi; nakit minimalan; izbegavati pozadinu sa reklamnim materijalom proizvodjaca; dnevno svetlo ili difuzno — bez direktnog blica.

---

## 2. Ordinacija / prostor — min 4, idealno 8

Prostor prodaje higijenu i ozbiljnost. Fotografisati **prazan, pospreman prostor**, ukljucena sva svetla.

| # | Sta prikazuje | Odnos | Min rezolucija | Gde |
|---|---|---|---|---|
| 2.1 | Glavna ordinacija, siroki kadar, stolica u centru, vidi se ceo prostor | 16:9 | 3000×1688 px | Hero / galerija |
| 2.2 | Stomatoloska stolica iz ugla, sa lampom i instrumentima postavljenim | 3:2 | 2400×1600 px | Galerija |
| 2.3 | Cekaonica — sedista, sto, biljke, atmosfera | 3:2 | 2400×1600 px | Stranica "Ordinacija" |
| 2.4 | Recepcija / ulaz iznutra | 3:2 | 2400×1600 px | Stranica kontakt |
| 2.5 | **Ulaz u zgradu izvana, sa tablom/natpisom i brojem** — pacijenti ovo traze da bi nasli ordinaciju | 4:3 ili 3:2 | 2000×1500 px | Stranica kontakt, pored mape |
| 2.6 | Druga ordinacija / posebna soba ako postoji | 3:2 | 2400×1600 px | Galerija |
| 2.7 | Sterilizacija — autoklav i radna povrsina | 4:5 ili 3:2 | 2000×2000 px | Sekcija "Higijena i sterilizacija" |
| 2.8 | Rendgen / CBCT / skener na svom mestu | 4:5 | 2000×2500 px | Sekcija "Oprema" |

---

## 3. Tim — 0 ako radi sama, inace do 3

| # | Sta prikazuje | Odnos | Min rezolucija | Gde |
|---|---|---|---|---|
| 3.1 | Grupna fotografija celog tima u mantilima, u ordinaciji ili cekaonici | 16:9 | 3000×1688 px | Sekcija "Nas tim" |
| 3.2 | Pojedinacni portreti svakog clana, **isti kadar i ista pozadina za sve** | 1:1 | 1200×1200 px | Kartice clanova tima |
| 3.3 | Tim u radu / neformalno, u pokretu | 3:2 | 2400×1600 px | "O nama" |

Za svakog clana treba i: ime, titula, uloga. [POTVRDITI SA KLIJENTOM]

---

## 4. Procedure / makro / oprema — min 3, idealno 6

Cilj je da svaka glavna usluga ima svoju sliku. Broj zavisi od liste usluga, koja je trenutno nepoznata.

| # | Sta prikazuje | Odnos | Min rezolucija | Gde |
|---|---|---|---|---|
| 4.1 | Ruke u rukavicama sa instrumentom, makro, plitka dubina polja | 3:2 | 2400×1600 px | Zaglavlje stranice usluge |
| 4.2 | Instrumenti slozeni na sterilnoj podlozi, odozgo | 1:1 ili 3:2 | 1600×1600 px | Deliteljske sekcije, pozadine |
| 4.3 | Intraoralni skener / CAD-CAM u upotrebi, ekran vidljiv | 3:2 | 2400×1600 px | Stranica "Digitalna stomatologija" |
| 4.4 | Model zuba / navlaka / folija za ispravljanje u ruci | 4:5 | 2000×2500 px | Stranica proteticke usluge |
| 4.5 | Rendgen snimak ili 3D prikaz na ekranu | 16:9 | 2400×1350 px | Stranica implantologije / dijagnostike |
| 4.6 | Po jedna karakteristicna slika za svaku glavnu uslugu | 3:2 | 2400×1600 px | Po jedna po stranici usluge |

Napomena: na slikama procedura **ne sme biti prepoznatljivo lice pacijenta** bez saglasnosti. Najsigurniji kadrovi su ruke, instrumenti i usna duplja bez sireg lica.

---

## 5. Pre–posle — idealno 5 parova

Najmocniji sadrzaj na sajtu stomatologa, ali i najosetljiviji.

**Uslov: potpisana saglasnost pacijenta za objavu. Bez saglasnosti — slika se ne koristi, bez izuzetka.** [POTVRDITI SA KLIJENTOM]

| Zahtev | Detalj |
|---|---|
| Format | Parovi: `prepsle-01-pre.jpg` i `prepsle-01-posle.jpg` |
| Kadriranje | **Identican kadar, isto osvetljenje, isti ugao** na obe slike — inace par nije verodostojan |
| Odnos stranica | 1:1 kvadrat (najbolje za slider pre/posle) ili 4:3 |
| Rezolucija | min 1600×1600 px po slici |
| Anonimizacija | kadrirati na usta i zube; bez ociju; bez tetovaza, nakita i drugih prepoznatljivih detalja |
| Uz svaki par | kratak opis: koja usluga, koliko je trajalo, poteskoca slucaja — za tekst ispod slike |
| Gde se koristi | sekcija "Rezultati" na naslovnoj (2–3 para) + galerija po uslugama |

---

## 6. Logo i brending — min 1, idealno 4

| # | Sta | Format | Gde |
|---|---|---|---|
| 6.1 | Logo, **vektor** (`.svg`, `.ai`, `.eps`) ili PNG sa providnom pozadinom min 2000 px sirine | SVG / PNG | Header, footer |
| 6.2 | Logo u svetloj verziji (za tamnu pozadinu) | SVG / PNG | Footer, hero preko slike |
| 6.3 | Kvadratna / skracena verzija logotipa (monogram) | SVG / PNG 512×512 | Favicon, Google Business, drustvene mreze |
| 6.4 | Brend boje (HEX kodovi) i nazivi fontova, ako postoje | tekst / PDF | Celokupan dizajn |

Ako logo ne postoji: naznaciti, pa se radi tipografsko resenje na osnovu imena. [POTVRDITI SA KLIJENTOM]

---

## 7. Detalji / atmosfera — min 2, idealno 5

Popunjavaju prazne sekcije i daju sajtu "dah". Niska prioritet, ali korisno.

| # | Sta | Odnos | Min rezolucija |
|---|---|---|---|
| 7.1 | Diplome i sertifikati na zidu (citljivi ili namerno necitljivi) | 3:2 | 2000×1333 px |
| 7.2 | Detalj interijera — biljka, lampa, tekstura zida | 1:1 | 1600×1600 px |
| 7.3 | Ruke koje pisu / tastatura — za sekciju zakazivanja | 16:9 | 2400×1350 px |
| 7.4 | Nasmejan pacijent posle intervencije (uz saglasnost) | 4:5 | 2000×2500 px |
| 7.5 | Sitni brend detalji — vizit karta, kesica, mantil sa logom | 1:1 | 1600×1600 px |

---

## Tehnicki minimum (vazi za sve)

- Najmanja duza strana: **2000 px**. Za hero slike: **3000 px**.
- Bez vodenog znaka, bez Instagram okvira, bez teksta utisnutog u sliku.
- Bez filtera sa jakim obojenjem — obrada ide u fazi dizajna.
- Horizontalne slike snimati horizontalno, ne rotirati vertikalne.
- Ako se slika koristi kao hero, mora imati **mirnu zonu** (zid, pod) gde moze da legne tekst.

## Sta je blokirajuce ako ne dodje

1. Portret 1.1 i 1.2 — bez njih nema naslovne strane.
2. Siroki kadar ordinacije 2.1.
3. Fotografija ulaza 2.5.
4. Logo 6.1 (ili potvrda da ne postoji).

## Nereseno

- Konkretni URL-ovi najuspesnijih IG objava — **nepoznato**, zahteva sesiju sa pristupom Instagramu ili da klijent sam posalje linkove 15–25 objava koje smatra najboljim.
- Lista usluga nije poznata, pa se broj slika u kategoriji 4 ne moze finalizovati. [POTVRDITI SA KLIJENTOM]
- Postojanje before/after materijala i saglasnosti. [POTVRDITI SA KLIJENTOM]
- Da li postoji profesionalna fotosesija ili se sve snima telefonom. [POTVRDITI SA KLIJENTOM]
