# Dopunsko WEB istraživanje (van Instagrama) — @dmd.nadabojic

**Datum istraživanja / pristupa svim izvorima:** 15. oktobar 2026.
**Istraživač:** web-researcher agent (paralelno sa IG istraživanjem — ovaj dokument NE koristi Instagram kao izvor)
**Metod:** WebSearch (više jezičkih i geografskih varijanti) + WebFetch
**Pretpostavljena osoba:** "Nada Bojić", DMD (doctor of dental medicine)

> **TEHNIČKO OGRANIČENJE OVOG ISTRAŽIVANJA — pročitati pre svega ostalog**
> 1. `instagram.com` nije dostupan iz ovog okruženja (DNS/egress blokada) — Instagram podaci dolaze iz `research.md` drugog agenta.
> 2. Direktan `WebFetch`/`curl` na većinu srpskih `.rs` domena je blokiran politikom proxy-ja u ovoj sesiji
>    (`CONNECT tunnel failed, response 403` za `stomatologvozdovac.rs`, `ordinacijavukovic.rs`, `philiadental.com`, `mirandre.com`).
>    Zbog toga podaci o konkurenciji dolazе iz **indeksiranih izvoda pretraživača**, a ne iz direktnog čitanja sajtova → sve takve podatke tretirati kao **"verovatno"**, ne "potvrđeno".
> 3. Google Maps / Google Business Profile i Facebook nisu bili direktno dostupni → ocene i broj recenzija nisu mogli biti pročitani iz primarnog izvora.

---

## 0. REZIME ZA NESTRPLJIVE

| Pitanje | Odgovor | Pouzdanost |
|---|---|---|
| Da li ime "Nada Bojić" + stomatologija postoji na webu? | **Praktično NE.** Jedan jedini pronađeni web pomen. | potvrđeno (odsustvo) |
| Jedini pronađeni pomen | GitHub repo `plavitommy-gas/hope-dental` → "**Hope Dental — dr Nada Bojić**", "Voždovac, Beograd", "parodontologija i opšta stomatologija + estetska medicina" | potvrđeno da repo tako piše |
| Grad / država | **Beograd, opština Voždovac, Srbija** | verovatno (jedan izvor) |
| Zvanični sajt ordinacije | **NE POSTOJI** (nijedan pronađen) | verovatno |
| Google Maps / Business profil | **Nije pronađen** nijednom pretragom | verovatno |
| Direktorijumi (hipokratija.rs, planplus.rs, 011info, mirandre, doktor.rs) | **Nema upisa** za Nada Bojić ni za "Hope Dental" | verovatno |
| Mediji, predavanja, stručni radovi | **Nijedan pronađen** | verovatno |
| Stepen sigurnosti u identifikaciju osobe | **NIZAK-SREDNJI (~40-50%)** — vidi sekciju 1.4 | — |

**Glavni poslovni zaključak:** osoba/ordinacija ima **nulto digitalno prisustvo van Instagrama**. To je istovremeno i najveća prodajna prilika (sajt + Google Business Profile + lokalni SEO su "greenfield"), i najveći rizik za projekat (ništa se ne može proveriti bez klijenta).

---

## 1. IDENTITET

### 1.1 Šta je pronađeno

**Izvor A (jedini direktan pomen imena u stomatološkom kontekstu):**
- **URL:** https://github.com/plavitommy-gas/hope-dental
- **Datum pristupa:** 15.10.2026.
- **Sadržaj (citati iz README-a, pročitano direktno):**
  - `"Hope Dental — dr Nada Bojić"`
  - `"Jednostranični demo sajt za stomatološku ordinaciju **Hope Dental** (Voždovac, Beograd)"`
  - `"parodontologija i opšta stomatologija"` + estetska medicina: `botox, filleri, PRP, skinbooster`
- **Šta repo NE sadrži:** adresu, telefon, mejl, radno vreme, cene, imena drugih zaposlenih.
- **Pouzdanost: NEPOUZDANO KAO NEZAVISAN IZVOR.**
  Obrazloženje: ovo je demo/"redesign proposal" repozitorijum, tj. najverovatnije **materijal nastao u okviru iste agencijske/ličне aktivnosti kojoj i ovaj projekat pripada** (ili ranijeg pokušaja za istog klijenta). Dakle on **potvrđuje da neko već povezuje ime "dr Nada Bojić" sa nazivom "Hope Dental" i lokacijom Voždovac**, ali nije nezavisna potvrda postojanja ordinacije.
  **Ovo je i jedini razlog zašto imamo ikakvu hipotezu o gradu — mora se potvrditi sa klijentom.**

### 1.2 Šta NIJE pronađeno (negativni nalazi — sve pretrage 15.10.2026.)

Sve sledeće pretrage dale su **nulti rezultat** za ciljanu osobu:

| Pretraga | Rezultat |
|---|---|
| `"Nada Bojić" stomatolog` | 0 relevantnih; pretraživač eksplicitno: "didn't turn up any dentist named Nada Bojić" |
| `"Nada Bojić" "dr" stomatološka ordinacija Srbija` | 0; samo druge "Bojić"/"Božić" ordinacije (vidi 1.3) |
| `"dr Nada Bojić"` | samo GitHub repo iz 1.1 |
| `"Nada Bojić" stomatolog Crna Gora Podgorica` | 0 |
| `"Nada Bojić" zubar ordinacija Banja Luka Bijeljina` | 0 (provereno i BiH / Republika Srpska) |
| `"nada bojic" dentist botox filleri PRP skinbooster Beograd` | 0 |
| `"Nada Bojić" facebook / "Hope Dental" linktree tiktok` | 0 |
| `"Hope Dental" Beograd ordinacija parodontologija` | 0 realnih listinga; samo isti GitHub repo |
| `"Hope Dental" stomatologija Beograd Voždovac` | 0 u planplus.rs imeniku Voždovca |
| `site:hipokratija.rs Bojić stomatolog` | 0 |

**Zaključak (pouzdanost: potvrđeno):** Nada Bojić **nema indeksirano profesionalno web prisustvo** — ni sajt, ni direktorijumski upis, ni Google Business, ni portal lekara/stomatologa, ni medijski pomen, ni stručni rad.

### 1.3 RAZDVAJANJE KANDIDATA — osobe/firme sa sličnim imenom koje NISU ona

Da se podaci ne pomešaju, sledeće je **eksplicitno isključeno**:

| # | Subjekt | Podatak | Zašto NIJE ona | Izvor (pristup 15.10.2026.) |
|---|---|---|---|---|
| K1 | **Stomatološka ordinacija Bojić**, Beograd | Durmitorska 3A, Savski venac, tel. 011/413-5131 (takođe se navodi i Višegradska 6a) | Druga opština (Savski venac, ne Voždovac); listing ne navodi ime doktora; opšta stomatologija bez parodontologije | https://hipokratija.rs/ustanove/stomatoloska-ordinacija-bojic/stomatologija ; https://www.planplus.rs/beograd/stomatoloske-ordinacije/4 |
| K2 | **Bojić Stomatološka Ordinacija** (zubarinadlanu) | Mileve Marić Ajnštajn 28, Beograd (Novi Beograd); preventivna i restaurativna stomatologija; listing star ~700 dana | Druga lokacija i profil usluga; nema imena doktora | https://www.zubarinadlanu.rs/stomatoloske-ordinacije/bojic-stomatoloska-ordinacija |
| K3 | **Specijalistička ordinacija Dr Bojić**, Račkoga 7, Beograd | **dermatologija i seksualno zdravlje** | Nije stomatologija | https://drbojic.com/kontakt ; https://www.stetoskop.info/ordinacija/dr-bojic |
| K4 | **Stomatološka ordinacija Božić** | drugi prezime (Božić ≠ Bojić) | Različito prezime | https://ordinacija-bozic.com/en/ |
| K5 | **"Stomatološka ordinacija dr Nada", Bor** | stomatološka praksa u Boru | Ime "Nada" se poklapa, **prezime nije Bojić** | https://www.kompanije.net/Srbija/l632_Stomatolo%C5%A1ka-praksa.html |
| K6 | **Nada Cindrić**, dr dent. med., Rijeka (HR) | Poliklinika za parodontologiju i endodonciju, u penziji | Hrvatska, drugo prezime; **ali pažnja: i ona je parodontolog**, pa se lako pomeša u pretragama | https://www.novilist.hr/?p=460330 |
| K7 | **Nada Vučković** | koautor udžbenika patologije za studente stomatologije, Med. fakultet Novi Sad | Patolog, ne stomatolog; drugo prezime | https://cris.cobiss.net/ecris/sr/en/researcher/23963 |
| K8 | **Milovan Bojić** | kardiolog / bivši ministar zdravlja Srbije | Drugo ime i specijalnost; dominira pretragama za "Bojić" + zdravstvo | https://en.wikipedia.org/wiki/Milovan_Boji%C4%87 |
| K9 | **Hope Dental Clinic**, Hope, Derbyshire, UK (dr Sophie A. Mitchell) | britanska ordinacija | Ista reč u nazivu, druga država/osoba — **ne koristiti nijedan njihov podatak** | https://www.cqc.org.uk/location/1-414301852 |

### 1.4 NAJVEROVATNIJA IDENTIFIKACIJA + nivo sigurnosti

**Najverovatnija hipoteza (H1):**
> **Dr Nada Bojić**, doktor dentalne medicine (DMD), Beograd — opština **Voždovac**, Srbija. Fokus: **parodontologija + opšta stomatologija**, uz **estetsku medicinu** (botoks, filleri, PRP, skinbooster). Radi pod/unutar brenda **"Hope Dental"**.

**Zašto H1:**
- Jedini web pomen imena u stomatološkom kontekstu daje tačno taj spoj (ime + titula "dr" + grad + opština + profil usluga).
- Profil usluga (parodontologija + estetika lica) je karakterističan i neslučajan — teško da bi se pogodio.
- Nijedan konkurentski kandidat (K1-K9) ne pokriva kombinaciju "Nada" + "Bojić" + stomatologija.

**Zašto sigurnost nije visoka (~40-50%):**
- Izvor je **jedan jedini**, i to **ne-nezavisan** (demo repo verovatno iz istog kruga kao i ovaj projekat) → nema cirkularne potvrde.
- **Nula** potvrda iz APR-a, Stomatološke komore Srbije, Google Maps-a, lokalnih imenika ili medija.
- Nije isključeno da je "Hope Dental" bio samo **predlog naziva** u demo-u, a ne stvarni naziv ordinacije.
- Nije isključeno da osoba radi u **drugom gradu/državi** (Crna Gora i BiH su proverene i daju nulu, ali odsustvo rezultata nije dokaz).
- Titula "DMD" u Instagram handle-u može značiti i da je **mlađi doktor bez sopstvene ordinacije** (zaposlena), što bi objasnilo nulto prisustvo u registrima ordinacija.

**Alternativne hipoteze koje ostaju otvorene:**
- **H2 (verovatno, ~25%):** Nada Bojić je **zaposleni/saradnik doktor u tuđoj ordinaciji** u Beogradu — otuda nulto prisustvo kao "ordinacija". Brend je lični (Instagram), ne firmin.
- **H3 (nepouzdano, ~10-15%):** osoba je **van Srbije** (Crna Gora / BiH / dijaspora) i radi kao zaposleni doktor.
- **H4 (nepouzdano, ~10%):** "Hope Dental" je tek **planirani** brend / ordinacija u otvaranju → nema ničega u registrima jer još ne postoji.

### 1.5 Vlasnik ili zaposlena?
**Nepoznato — nije moguće utvrditi sa weba.** Nema upisa u APR-u, nema ordinacije pod njenim imenom, nema listinga. Nagoveštaj: lični handle (`dmd.nadabojic`, ime+titula, a ne naziv ordinacije) tipičan je za **doktora koji gradi ličnu marku**, što se sreće i kod vlasnika i kod zaposlenih.

### 1.6 Fakultet / specijalizacija
**Nije pronađeno ništa.** (pouzdanost: potvrđeno odsustvo)
- Nije pronađena na listama zaposlenih/saradnika Stomatološkog fakulteta u Beogradu (`stomf.bg.ac.rs`).
- Nije pronađena u bibliografskim bazama (COBISS/CRIS, enauka.gov.rs) → **nema indeksiranih stručnih radova**.
- Titula "DMD" (doctor of dental medicine) je engleski ekvivalent domaćeg "doktor stomatologije / doktor dentalne medicine" — na Zapadnom Balkanu je koriste i diplomci domaćih fakulteta radi internacionalnog zvuka. **Ne implicira studij u inostranstvu.**
- Profil usluga (parodontologija) **ne znači automatski specijalizaciju** — u Srbiji je "specijalista parodontologije i oralne medicine" zvanična specijalizacija i to se mora proveriti, jer je to **pravno osetljiva tvrdnja za sajt**.

---

## 2. ORDINACIJA / KLINIKA

| Podatak | Nalaz | Pouzdanost |
|---|---|---|
| Naziv | "Hope Dental" (samo iz GitHub demo repo-a) | nepouzdano |
| Adresa | **nepoznata** — nigde nije pronađena | — |
| Grad / opština | Beograd / Voždovac | verovatno (1 izvor) |
| Država | Srbija | verovatno |
| Telefon | **nepoznat** | — |
| Mejl | **nepoznat** | — |
| Radno vreme | **nepoznato** | — |
| Zvanični sajt | **NE POSTOJI nijedan pronađen** | verovatno |
| Google Maps / Business Profile | **nije pronađen** | verovatno |
| Ocena / broj recenzija | **nema** (nema profila) | — |
| Facebook stranica | **nije pronađena** | verovatno |
| Cene usluga | **nisu javne** | — |

**Napomena o metodu:** proverena su tri srpska imenika (planplus.rs lista ordinacija po opštinama, hipokratija.rs, mirandre.com lista za Voždovac) i u nijednom se "Hope Dental" ni "Bojić" na Voždovcu ne pojavljuju. Imenik `planplus.rs/vozdovac` i `mirandre.com/stomatoloske-ordinacije/vozdovac` izlistavaju više ordinacija Voždovca (Donna Dent, Unident, Vuković, Cvejanović, Dental Studio 32, DentalMark, Philia Dental, Dentina, Dentib, Dental Family, Razić, Biodent) — **nijedna nije Hope Dental**.

---

## 3. REPUTACIJA

| Kanal | Nalaz | Pouzdanost |
|---|---|---|
| Google recenzije | profil nije pronađen → **0 recenzija dostupno** | verovatno |
| hipokratija.rs | nema upisa | verovatno |
| doktor.rs / stetoskop.info | nema upisa pod njenim imenom (stetoskop ima samo dermatološku "Dr Bojić", K3) | verovatno |
| imenik.rs / 011info / planplus.rs / zubarinadlanu.rs / mirandre.com | **nema upisa** | verovatno |
| 021.rs i drugi lokalni/medijski portali | **nijedan pomen**; 021.rs ima članke o dentalnom turizmu u Novom Sadu i o stanju stomatologije u Srbiji, ali bez pomena ove osobe | potvrđeno |
| Medijski nastupi / intervjui | **nijedan pronađen** | verovatno |
| Predavanja / kongresi | **nijedno pronađeno** | verovatno |
| Članstva u komorama/udruženjima | **nije moguće proveriti** — Stomatološka komora Srbije **nema javno indeksiran registar licenciranih stomatologa** dostupan kroz pretragu (potvrđeno pretragom 15.10.2026.). Postojanje komore je zakonska obaveza (Zakon o komorama zdravstvenih radnika), ali javna provera licence online nije pronađena. | potvrđeno (о nedostupnosti registra) |
| Stručni radovi | **nijedan** u COBISS/CRIS i enauka.gov.rs | verovatno |

**Interpretacija:** reputacija osobe živi **isključivo na Instagramu**. Van IG-a ne postoji nijedan društveni dokaz (social proof) koji bi novi pacijent mogao da nađe kada "guglja" ime. To je direktna rupa u konverziji: pacijent koji vidi IG, pa proveri ime na Google-u, ne nalazi **ništa** — što za skupe zahvate (implanti, estetika, parodontološka terapija) obara poverenje.

---

## 4. DIGITALNO PRISUSTVO

| Kanal | Stanje | Pouzdanost |
|---|---|---|
| **Sajt** | **NE POSTOJI** → **najveća prilika projekta** | verovatno |
| Google Business Profile | nije pronađen → **druga najveća prilika** (lokalni SEO, Maps, recenzije) | verovatno |
| Facebook | nije pronađena stranica | verovatno |
| Linktree / bio-link | nije pronađen | verovatno |
| TikTok | nije pronađen | verovatno |
| YouTube | nije pronađen | verovatno |
| LinkedIn | nije pronađen | verovatno |
| Instagram | postoji (`@dmd.nadabojic`) — **vidi `research.md`**, nije predmet ovog dokumenta | — |
| GitHub demo (`hope-dental`) | postoji jednostranični demo/predlog redizajna, bez podataka o kontaktu | potvrđeno |

**Ocena kvaliteta postojećeg sajta:** nema sajta → nema šta da se ocenjuje (responsive/brzina/modernost). Startuje se od nule, što je povoljnije od zatečenog lošeg sajta: nema tehničkog dugа, nema starih URL-ova za redirekciju, nema zatečenog lošeg sadržaja u Google indeksu.

**Ključne posledice nepostojanja sajta:**
1. Nulta vidljivost za pretrage tipa "stomatolog Voždovac", "parodontolog Beograd" — koje konkurenti aktivno ciljaju (vidi sekciju 5).
2. Nema odredišta za IG bio link → sav saobraćaj sa IG-a staje na DM-u.
3. Nema strukturiranih podataka (`LocalBusiness`/`Dentist` schema) → nema prikaza u Google lokalnom paketu.
4. Nema stranica po uslugama → nema rangiranja za visoko-vredne upite (implanti, estetika, paradentoza).

---

## 5. KONKURENCIJA (Voždovac, Beograd) — 5 ordinacija

> Svi podaci u ovoj sekciji su iz **indeksiranih izvoda pretraživača** (direktan pristup domenima blokiran) → **pouzdanost: verovatno**. Telefone i adrese obavezno reverifikovati pre upotrebe u tekstu sajta.

### 5.1 Donna Dent — najjači lokalni igrač
- **Sajt:** https://www.stomatologvozdovac.rs/ (+ stariji http://donnadent.rs/)
- **Adresa:** Braće Jerković 71, Voždovac
- **Telefon:** 064 203 89 35 (sajt); 011info listing navodi i 064 1277 217, 064 3194 724, mejl `drnevenagolub@gmail.com`
- **Izvori:** https://www.stomatologvozdovac.rs/ ; http://donnadent.rs/onama.html ; https://www.011info.com/en/dental-surgery/donna-dent-plus ; https://tob.co.rs/beograd/evo-koje-su-najbolje-stomatoloske-ordinacije-u-beogradu/
- **Šta rade DOBRO:**
  - **Domen je sam ključna reč:** `stomatologvozdovac.rs` → ogromna prednost za lokalnu pretragu "stomatolog Voždovac". Ovo je njihov najjači SEO potez.
  - Fokus na **implantologiju i oralnu hirurgiju** (najskuplje usluge) + **garancija na trajnost implanta** kao diferencijator.
  - Pominju se na portalu TOB kao "najbolja ordinacija u Beogradu" (PR/listicle plasman).
  - Imaju strukturirane podatke (schema) na sajtu.
- **Šta rade LOŠE:**
  - **Dva paralelna domena** (`stomatologvozdovac.rs` i `donnadent.rs`) → razvodnjen brend i kanibalizacija SEO autoriteta.
  - **Nekonzistentni NAP podaci** (različiti telefoni na sajtu i u imenicima) → šteti lokalnom SEO-u.
  - Mejl je **gmail**, ne domenski → slabiji signal profesionalnosti.
  - U schema podacima cena stoji kao besmisleno "10+ €".
  - PR članak koji ih hvali je **star ~6 godina**.

### 5.2 Unident — Voždovac (Stepa Stepanović)
- **Sajt:** http://unident.rs/ , https://unident.rs/stomatoloske-usluge/
- **Adresa:** Generala Ljubomira Milića 13/2, naselje Stepa Stepanović, Voždovac
- **Izvori:** http://unident.rs/ ; https://unident.rs/stomatoloske-usluge/
- **Šta rade DOBRO:** široka lista usluga sa **zasebnom stranicom za usluge** (implanti, ortodoncija, **parodontologija**, beljenje, endodoncija, oralna hirurgija, protetika); pozicioniranje na novo, gusto naseljeno naselje Stepa Stepanović; recenzije pacijenata objavljene na sajtu.
- **Šta rade LOŠE:** sajt radi na **HTTP-u, bez HTTPS-a** (ozbiljan signal nepoverenja i SEO minus); **kolizija brenda** — postoji drugi, nepovezan sajt `unidentstomatologija.com` (all-on-4/all-on-6), što zbunjuje pacijente i pretraživače; recenzije na sopstvenom sajtu nisu nezavisno proverljive.
- **Direktan konkurent za H1:** jedini iz ovog spiska koji eksplicitno reklamira **parodontologiju** → najbliži konkurent Nadinom glavnom fokusu.

### 5.3 Stomatološka ordinacija Vuković
- **Sajt:** https://www.ordinacijavukovic.rs/
- **Adresa:** Triše Kaclerovića 10, Voždovac
- **Izvori:** https://www.ordinacijavukovic.rs/ ; https://www.planplus.rs/en/vukovic-dental-clinic-vozdovac/33806
- **Šta rade DOBRO:** **najsvežije nezavisne recenzije** iz pronađenih (na planplus.rs recenzija iz marta 2026.); recenzije imenom hvale **dr Mariju Vuković** → dokaz da lična marka doktora funkcioniše na ovom tržištu; diferencijator **ozonoterapija** + poruka "bez bola".
- **Šta rade LOŠE:** nema jasne usluge-stranice u indeksu; brend vezan za prezime bez geo-ključne reči; ne vidi se cenovnik.
- **Lekcija za Nadu:** "bezbolno" i ime doktora u recenzijama su ono što ovde pokreće odluku — upravo ono što IG lična marka može da pojača.

### 5.4 Stomatološka ordinacija Cvejanović
- **Sajt:** https://ordinacijacvejanovic.com/ (ima i /en/ verziju)
- **Adresa:** Triše Kaclerovića 6a, Voždovac
- **Izvor:** https://ordinacijacvejanovic.com/en/
- **Šta rade DOBRO:** **višejezičnost (EN verzija)** → ciljaju dentalni turizam i strance u Beogradu; preporuke pacijenata za implantologiju i oralnu hirurgiju.
- **Šta rade LOŠE:** sajt je **vidno zastareo** (po indeksu), informacije moguće netačne; `.com` bez lokalne geo-optimizacije.

### 5.5 Philia Dental
- **Sajt:** https://philiadental.com/ (pozicionira se kao "Stomatološka ordinacija Voždovac")
- **Izvor:** https://philiadental.com/en/
- **Šta rade DOBRO:** title tag direktno cilja "**Stomatološka ordinacija Voždovac**"; EN verzija sajta; moderniji brend-naziv.
- **Šta rade LOŠE:** **sami se nazivaju "najbolja u Beogradu"** bez ikakvog nezavisnog dokaza → slab, lako obrnut argument; nisu pronađene nezavisne recenzije.

### 5.6 Benchmark za cene (nije Voždovac, ali koristan referentni okvir)
- **Simdent cenovnik** (https://www.simdent.rs/cenovnik/, pristup 15.10.2026.) — **jedini pronađeni javni cenovnik**: 1 implant **66.000 RSD**, hirurška ekstrakcija **6.000 RSD**, metalokeramička krunica **9.600 RSD**. Pouzdanost: verovatno (iz izvoda pretrage, nije direktno pročitan sajt).
- Klinika za parodontologiju i oralnu medicinu (Stomatološki fakultet), Dr Subotića starijeg 4, Savski venac, tel. 011/3629-200 — državni referentni centar za parodontologiju, bez javnih cena (https://www.planplus.rs/klinika-za-parodontologiju-i-oralnu-medicinu-beograd/34440).
- **Javni cenovnik je retkost na ovom tržištu → objava cenovnika (ili "od X dinara") je realan diferencijator.**

### 5.7 Sinteza: koje ključne reči konkurencija cilja
Iz naslova, domena i title tagova konkurenata jasno se vidi obrazac:
1. `stomatolog Voždovac` / `stomatološka ordinacija Voždovac` — **najtraženija lokalna fraza** (Donna Dent je uzeo ceo domen za nju; Philia je uzela title tag)
2. `stomatolog Beograd` / `zubar Beograd`
3. `zubni implanti Beograd` / `implantologija Voždovac`
4. `oralna hirurgija Voždovac`
5. `parodontologija` / `paradentoza` / `lečenje desni` / `krvarenje desni` (ciljaju Unident, dental-clinic.rs, dentalprotect.rs, dedent.rs, amedordinacija.com, dentalplaza.rs)
6. `all-on-4` / `all-on-6` (unidentstomatologija.com)
7. `cenovnik` / `cene` (Simdent, mirandre.com)
8. `dečija stomatologija Voždovac`
9. `najbolji stomatolog` / `najpovoljniji stomatolog Beograd Voždovac` (moja-delatnost.rs, tob.co.rs)

**Prazne niše koje niko na Voždovcu ne pokriva jako:**
- **estetska medicina lica kod stomatologa** (botoks, filleri, PRP, skinbooster) — Nadina kombinacija; na Voždovcu je nisam našao ni kod jednog konkurenta. Konkurencija za te upite dolazi iz **estetskih klinika** (npr. Atlas klinika, dr Miljana Stojanović — https://atlasklinika.com/en/eksperti/dr-miljana-stojanovic/), a ne iz stomatoloških ordinacija.
- **parodontologija kao glavna specijalnost u opštini** — niko na Voždovcu nije "parodontolog" brend; svi je nude kao jednu od 10 usluga.

---

## 6. TRŽIŠTE — kako ljudi traže stomatologa

### 6.1 Obrasci pretrage (izvedeni iz strukture rezultata i imenika, pristup 15.10.2026.)
Pouzdanost: **verovatno** (izvedeno iz naslova indeksiranih stranica i strukture direktorijuma, ne iz Google Keyword Planner-a / Search Console-a — pravi podaci o obimu pretrage nisu bili dostupni).

**A) Lokacijske pretrage (dominantne):**
- `stomatolog + [opština]` → `stomatolog Voždovac`, `stomatolog Vračar`, `stomatolog Novi Beograd`
- `stomatološka ordinacija Beograd`, `zubar Beograd`, `zubar blizu mene`
- Imenici (planplus.rs, mirandre.com) imaju **zasebne stranice po opštini za svaku uslugu** (`/vozdovac/decija-stomatologija`, `/vracar/zubni-implanti-i-protetika`, `/implantologija/vozdovac`, `/oralna-hirurgija/vozdovac`) — to je najjači dokaz da **ljudi traže "usluga + opština"**, i da sajt mora imati stranice po toj matrici.

**B) Pretrage po usluzi + cena (visoka komercijalna namera):**
- `cena implanta Beograd`, `zubni implanti cena`, `cenovnik stomatologa`
- `implantologija Voždovac cene`, `oralna hirurgija Voždovac cene` (mirandre.com ima tačno takve URL-ove)
- `all-on-4 cena`
- `kiretaža cena`, `lečenje paradentoze cena`

**C) Pretrage po simptomu (najveći neiskorišćeni potencijal za parodontologa):**
- `krvarenje desni`, `krvarenje zuba i desni` (dentalprotect.rs ima tačno taj naslov stranice)
- `paradentoza`, `lečenje desni`, `klimavi zubi`
- `bol u zubu`, `zubobolja`

**D) Pretrage poverenja / "ljudi takođe pitaju" obrazac:**
- `najbolji stomatolog Beograd` / `najbolje stomatološke ordinacije u Beogradu` → generiše listicle PR članke (tob.co.rs)
- `najpovoljniji stomatolog Beograd` (moja-delatnost.rs)
- `stomatolog bez bola`, `stomatolog za decu`, `strah od zubara`
- `provera licence stomatologa` → **ovo je pitanje na koje u Srbiji nema lakog javnog odgovora** (vidi 3.), što znači da pacijenti poverenje grade iz recenzija i Instagrama

**E) Dentalni turizam (sekundarno za Beograd, primarno za Novi Sad):**
- 021.rs beleži Novi Sad kao rastuću destinaciju dentalnog turizma (https://www.021.rs/novi-sad/vesti/317528/...). Za Beograd se signal vidi kroz EN verzije sajtova (Cvejanović, Philia, unidentstomatologija).

### 6.2 Kontekst tržišta (potvrđeno, 021.rs, pristup 15.10.2026.)
- U Srbiji ima **više od 3.000 privatnih stomatoloških ordinacija** → tržište je izuzetno fragmentisano i prezasićeno; diferencijacija (niša + lična marka) je jedini izlaz za malu ordinaciju.
  Izvor: https://www.021.rs/info/srbija/358503/cak-700000-gradjana-srbije-nema-nijedan-zub-koliko-smo-daleko-od-besplatnih-drzavnih-zubara
- **Oko 700.000 građana Srbije nema nijedan zub**, a državna stomatologija je praktično nedostupna odraslima → ogromna neuslužena potreba za **protetikom i implantima**, ali i jaka cenovna osetljivost.
  Izvor: isto kao gore.
- Cenovna osetljivost je realna i medijski eksploatisana (npr. članak o niskim cenama na fakultetskoj klinici: https://biznis.kurir.rs/novcanik/4356878/cenovnik-stomatoloskog-fakulteta — **naslov je obmanjujuć**, sadržaj se odnosi na Kliniku za stomatologiju Vojvodine, ne na beogradski fakultet; pouzdanost: nepouzdano).

### 6.3 Preporučeni SEO prioriteti (izvedeno iz 5. i 6.)
1. Home + title koji nosi `stomatolog Voždovac` / `stomatološka ordinacija Voždovac` (ili tačnu potvrđenu opštinu).
2. **Zasebna stranica po usluzi** × ključne usluge: parodontologija, opšta stomatologija, estetska stomatologija, botoks/filleri/PRP/skinbooster.
3. **Stranice po simptomu** za parodontologiju (`krvarenje desni`, `paradentoza`) — konkurencija je slabija nego na `implanti`.
4. **Google Business Profile** + aktivno prikupljanje recenzija — jedini kanal gde konkurenti (Vuković) imaju merljivu prednost.
5. Upis u imenike (planplus.rs, hipokratija.rs, 011info, mirandre.com, zubarinadlanu.rs) sa **identičnim NAP podacima** — konkurenti tu greše (Donna Dent).
6. Transparentan cenovnik ili "cene od" — javni cenovnik je retkost.
7. `LocalBusiness`/`Dentist` schema + HTTPS + brzina (Unident je još na HTTP-u).
8. EN verzija samo ako klijent zaista cilja dentalni turizam.

---

## 7. OTVORENA PITANJA / ŠTA MORA DA POTVRDI KLIJENT

> **Ovo je blokirajuća lista.** Dok se tačke 1-6 ne potvrde, sadržaj sajta se ne može pisati bez rizika od netačnih tvrdnji (a za zdravstvene usluge netačne tvrdnje nose i pravni rizik).

### KRITIČNO (blokira pisanje sadržaja)
1. **Puno zvanično ime i tačna titula** — "dr Nada Bojić"? Da li je zvanično "doktor stomatologije" ili "doktor dentalne medicine"? Da li se "DMD" sme koristiti u zvaničnom tekstu?
2. **Da li je "Hope Dental" stvarni naziv ordinacije?** Ili je to bio samo predlog iz starog demo-a? Koji je **tačan pravni naziv** (kako stoji u APR-u)?
3. **Tačan grad i adresa.** Da li je zaista Voždovac, Beograd? (Ovo imamo iz **jednog, ne-nezavisnog** izvora. Crna Gora i BiH su proverene i daju nulu, ali to nije dokaz.)
4. **Da li je vlasnik ili zaposlena?** Ako je zaposlena — u kojoj ordinaciji, i šta sme da se predstavi kao "njena" praksa?
5. **Da li ima zvaničnu specijalizaciju iz parodontologije** (specijalista parodontologije i oralne medicine), ili je parodontologija oblast interesovanja/užeg rada? **Reč "specijalista" se ne sme napisati bez potvrde.**
6. **Da li zaista pruža estetsku medicinu lica** (botoks, filleri, PRP, skinbooster) i **ima li potrebnu dozvolu/edukaciju** za to? (U Srbiji je nadležnost stomatologa za estetske intervencije lica regulatorno osetljiva — mora se potvrditi.)

### VAŽNO (blokira kontakt sekciju i Google Business)
7. **Telefon(i)** za objavu — fiksni i/ili mobilni, Viber/WhatsApp?
8. **Mejl** — domenski ili gmail? (preporuka: domenski)
9. **Radno vreme** po danima + da li se radi subotom.
10. **Da li već postoji Google Business Profile** (možda postoji ali nije indeksiran kroz pretragu koju sam mogao da uradim)? Ako postoji — link; ako ne — otvoriti ga, to je prioritet #1 posle sajta.
11. **Da li postoji Facebook stranica / TikTok / Linktree** koje nisam našao?
12. **Da li je domen već kupljen?** Ako nije — preporučujem domen sa geo/uslugom u imenu (po modelu Donna Dent-a, koji je time preuzeo lokalnu pretragu).

### POSLOVNO (utiče na strategiju sajta)
13. **Tačna lista usluga + prioritet** — šta su najprofitabilnije usluge koje treba staviti u prvi plan?
14. **Da li cene smeju da se objave** (cenovnik ili "od X dinara")? Na ovom tržištu je to realan diferencijator.
15. **Da li cilja dentalni turizam / strane pacijente** → odlučuje da li radimo EN verziju.
16. **Fakultet i godina diplomiranja** + eventualne dodatne edukacije/kursevi/sertifikati (za "O meni" stranicu — jedini način da nadoknadimo nulto prisustvo stručnih referenci na webu).
17. **Članstvo u Stomatološkoj komori Srbije + broj licence** — vredi navesti na sajtu kao signal poverenja, posebno jer pacijent licencu ne može sam online da proveri.
18. **Da li ima pacijentske recenzije/zahvalnice** (čak i screenshot-ove iz DM-a) koje smeju da se objave — van IG-a **ne postoji nijedan društveni dokaz**, a to je najveća rupa u konverziji.
19. **Da li postoje tim/saradnici** koje treba predstaviti.
20. **Da li je GitHub repo `plavitommy-gas/hope-dental` nastao za ovog klijenta?** Ako da — treba preuzeti sadržaj/dizajn kao polaznu osnovu i izbeći duplikat rada. Ako ne — treba razumeti zašto postoji i da li tu ima konflikta brenda.

---

## 8. SPISAK SVIH KORIŠĆENIH IZVORA (pristup: 15. oktobar 2026.)

**Identitet / jedini direktan nalaz**
- https://github.com/plavitommy-gas/hope-dental — "Hope Dental — dr Nada Bojić", Voždovac Beograd (pročitano direktno)

**Isključeni kandidati**
- https://hipokratija.rs/ustanove/stomatoloska-ordinacija-bojic/stomatologija
- https://www.zubarinadlanu.rs/stomatoloske-ordinacije/bojic-stomatoloska-ordinacija
- https://drbojic.com/kontakt
- https://www.stetoskop.info/ordinacija/dr-bojic
- https://ordinacija-bozic.com/en/
- https://www.kompanije.net/Srbija/l632_Stomatolo%C5%A1ka-praksa.html
- https://www.novilist.hr/?p=460330
- https://cris.cobiss.net/ecris/sr/en/researcher/23963
- https://en.wikipedia.org/wiki/Milovan_Boji%C4%87
- https://www.cqc.org.uk/location/1-414301852

**Konkurencija (Voždovac)**
- https://www.stomatologvozdovac.rs/
- http://donnadent.rs/onama.html
- https://www.011info.com/en/dental-surgery/donna-dent-plus
- http://unident.rs/
- https://unident.rs/stomatoloske-usluge/
- https://unidentstomatologija.com/en/home-en/
- https://www.ordinacijavukovic.rs/
- https://www.planplus.rs/en/vukovic-dental-clinic-vozdovac/33806
- https://ordinacijacvejanovic.com/en/
- https://philiadental.com/en/
- https://www.moja-delatnost.rs/najpovoljniji-stomatolog-beograd-vozdovac/stomatoloska-ordinacija-dentina/MMxB4_oW
- https://tob.co.rs/beograd/evo-koje-su-najbolje-stomatoloske-ordinacije-u-beogradu/

**Imenici / tržište / ključne reči**
- https://www.planplus.rs/beograd/stomatoloske-ordinacije/4 (i paginacija /7 /9 /20 /22 /23 /24 /25)
- https://www.planplus.rs/vozdovac/decija-stomatologija
- https://www.planplus.rs/beograd/zubni-implanti-i-protetika/8
- https://www.planplus.rs/vracar/zubni-implanti-i-protetika
- https://www.planplus.rs/klinika-za-parodontologiju-i-oralnu-medicinu-beograd/34440
- https://www.mirandre.com/stomatoloske-ordinacije/vozdovac
- https://www.mirandre.com/implantologija/vozdovac
- https://www.mirandre.com/oralna-hirurgija/vozdovac
- https://www.simdent.rs/cenovnik/
- https://dentalprotect.rs/paradontologija-i-oralna-medicina/
- https://dental-clinic.rs/dentalclinic/21/parodontologija
- https://www.dedent.rs/usluge/parodontologija
- https://amedordinacija.com/en/stomatologija/parodontologija/
- https://www.dentalplaza.rs/parodontologija
- https://emmedent.rs/paradontologija/

**Kontekst tržišta**
- https://www.021.rs/info/srbija/358503/cak-700000-gradjana-srbije-nema-nijedan-zub-koliko-smo-daleko-od-besplatnih-drzavnih-zubara
- https://www.021.rs/novi-sad/vesti/317528/dentalni-turizam-novi-sad-sve-popularnija-destinacija-a-jedna-ordinacija-se-narocito-istice
- https://biznis.kurir.rs/novcanik/4356878/cenovnik-stomatoloskog-fakulteta (naslov obmanjujuć — pouzdanost nepouzdano)
- https://www.stomf.bg.ac.rs/wp-content/uploads/students/Cenovnik-usluga_202122.pdf
- https://vreme.com/?p=4505948 (zakonski okvir komora zdravstvenih radnika)

**Estetska medicina — indirektna konkurencija**
- https://atlasklinika.com/en/eksperti/dr-miljana-stojanovic/
- https://previous.atlasklinika.com/?p=24289
