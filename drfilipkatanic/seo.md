# SEO plan — dr Filip Katanić (ginekologija / IVF, Novi Sad)

Datum: 2026-09-25
Izvori: `research.md`, `web-research.md`, `brand.md`. Sve kljucne reci bez broja pretrage su oznacene "procena" — nema pristupa alatu za obim pretrage (Google Keyword Planner i sl.), procene su bazirane na WebSearch uzorku i logici niše.

Domen sajta NIJE potvrđen/kupljen u trenutku pisanja ovog dokumenta — u primerima ispod koristi se placeholder `[DOMEN]` (npr. `drfilipkatanic.rs`). Zameniti pre implementacije.

---

## 0. OBAVEZNA PRAVILA (čitaju Copywriter, Architect, Developer — bez izuzetka)

### 0.1 TITULA — najvažnije pravilo na celom sajtu
Postoji nerešena kontradikcija u izvorima:
- Instagram bio: "Specijalista ginekologije i akušerstva" + "Master reproduktivni embriolog".
- Akademski profili (sciprofiles.com, ResearchGate — čitano iz search-snippet-a, direktan pristup blokiran 403): "gynecology and obstetrics **resident**" (specijalizant) i "**second-year PhD student**" (doktorand 2. godine).

**Dok klijent pismeno ne potvrdi tačan i trenutni status, na sajtu se NIGDE ne koristi reč "specijalista" (ni "specijalistkinja", ni engleski "specialist") u vezi sa dr Kataničem.** Ovo važi za:
- sav vidljiv tekst (naslovi, meta description, alt tekst, FAQ, blog),
- schema.org markup (`jobTitle` NIKAD "Specijalista ginekologije i akušerstva"),
- Open Graph/Twitter opise,
- interne dokumente koje koriste Copywriter/Architect/Developer za dalji rad.

**Dozvoljene neutralne formulacije** (koristiti ove, ne izmišljati nove bez istog principa):
- "dr Filip Katanić"
- "doktor medicine" / "lekar"
- "član tima Specijalne bolnice Ferona" (uz gore pomenutu napomenu o statusu zaposlenja — takođe nepotvrđeno, vidi 0.2)
- Fokus na **oblast rada** umesto na zvanje: "bavi se ginekologijom i oblašću vantelesne oplodnje (IVF)", "u okviru tima SB Ferona radi na dijagnostici i lečenju steriliteta"
- "master reproduktivne embriologije" (ovo JE potvrđeno na dva nezavisna mesta — IG bio i konferencijski slajd — može se koristiti)

**Ako se status razjasni sa klijentom pre lansiranja:** ažurirati ovaj odeljak i sve stranice odjednom (jedan find-and-replace prolaz, ne parcijalno). Do tada — nijedna stranica, čak ni draft, ne sme sadržati reč "specijalista" vezanu za njega.

### 0.2 STATUS ZAPOŠLJENJA U FERONI — nepotvrđeno
Zvanični sajt Ferone (feronaivf.rs/tim-ferona/) navodi dr Katanića na listi tima, ali ne kaže da li je zaposlen ili spoljni saradnik. Koristiti samo "član tima SB Ferona" — ne "zaposlen u", ne "vlasnik/osnivač", ne "radi isključivo u".

### 0.3 KONTAKT PODACI — institucija, ne lična linija
Telefon `+381 21 3000 220` i email `office@ferona.rs` su **brojevi/adresa ustanove SB Ferona**, ne lična linija dr Katanića (koji na IG koristi isključivo "Zakazivanje u DM", nema objavljen lični broj/mejl). Svuda na sajtu gde se ovi podaci prikazuju, mora stojati jasna napomena tipa: *"Kontakt centra za zakazivanje SB Ferona"* — nikad implicirati da je to njegova privatna ordinacija/broj.

### 0.4 ARHITEKTONSKA ODLUKA — lični brend/portfolio, NE sajt klinike
Vidi detaljno obrazloženje u odeljku 3. Ukratko: dr Katanić **nema sopstvenu privatnu praksu** — IVF/ginekološke usluge formalno pruža SB Ferona kao ustanova, koja već ima razvijen sajt (feronaivf.rs) koji dominira Google rezultatima za glavne transakcione ključne reči ("vantelesna oplodnja Novi Sad", "IVF Novi Sad"). Sajt dr Katanića se pravi kao **lični brend/portfolio + edukativni sadržaj**, sa jasnim, nenametljivim CTA ka SB Ferona za zakazivanje. Sajt ne treba da se predstavlja kao "klinika" niti da nudi sopstveni cenovnik usluga.

### 0.5 ZABRANJEN SADRŽAJ (nulta tolerancija)
- Bilo kakav % uspešnosti IVF postupka (izmišljen ili "generalno poznat") — ne postoji ni u jednom izvoru i ne treba ga izmišljati.
- Poređenje sa drugim lekarima/klinikama (uključujući koleginicu iz iste ustanove ili konkurentske klinike).
- Agresivni CTA: "Zakažite ODMAH", countdown, "poslednja šansa", pop-up pritisak.
- Konkretne cene bez pismene potvrde klijenta (jedini pominjan broj — "500+ €" — je generički i NE SME se prikazati kao cena na sajtu).
- Konkretno radno vreme bez potvrde (whatclinic.com podatak "5:00–23:45" je nepouzdan/generički, ne koristiti).
- `aggregateRating` schema ili bilo koji prikaz Google ocene — izvori se ne slažu (4.0/203 vs 3.9/217), potrebna ručna provera na Google Maps neposredno pre lansiranja.
- Testimonijali/iskustva pacijentkinja BEZ propratne napomene **"Objavljeno uz saglasnost pacijentkinje"** — ako se testimonial koristi, napomena je obavezna, tekst anonimizovan (samo ime/inicijal + eventualno godina), bez fotografija bez posebne pismene saglasnosti.
- Stock fotografije trudnica/beba, before/after vizuali — nisu primenljivi za IVF nišu i ne odgovaraju obazrivom tonu brenda (vidi `brand.md` odeljak 7).

### 0.6 TON
Empatičan, uzdržan, edukativan — nastaviti postojeći IG obrazac (vidi `research.md` odeljak 4): normalizovati bez krivice ("infertilitet nije samo stres"), jezik uslovan ("može", "plan", "nije garancija"), nikad definitivan ("izlečićemo", "garantujemo").

---

## 1. Ključne reči

### 1.1 Zašto NE ciljati direktno glavni transakcioni termin
WebSearch provera (2026-09-25) za "vantelesna oplodnja Novi Sad" i "ginekolog Novi Sad zamrzavanje jajnih ćelija" pokazuje da **feronaivf.rs već dominira** te rezultate (sopstvene stranice `/ivf-vto/`, `/zamrzavanje-jajnih-celija-iz-socijalnih-razloga/`, `/krioprezervacija/`), uz konkurenciju Perinatal, Genesis, Poliklinika Novakov, Poliklinika Anđelić, Gemma Clinic (Beograd), MediGroup. Pošto je dr Katanić član tima iste ustanove (Ferona), nema smisla da njegov lični sajt konkuriše sajtu sopstvene ustanove za isti termin (kanibalizacija + gubljena bitka protiv već indeksiranog institucionalnog sadržaja). Umesto toga, lični sajt cilja **branding + long-tail + informativne/FAQ upite** gde institucionalni sajt ne pokriva dubinu (edukativni ton, lična priča, Q&A format — tačno ono što dr Katanić već radi na IG-u).

### 1.2 Primarna ključna reč
**"dr Filip Katanić ginekolog Novi Sad"** (brand + usluga + grad) — brendirani upit, štiti prisustvo na Google-u za sopstveno ime (trenutno bez sajta, sav trag je samo IG) i pokriva "ginekolog Novi Sad" long-tail varijantu. Procena obima: nizak do umeren (brendirani upiti rastu srazmerno rastu IG pratilaca — 7.102 pratioca, procena).

### 1.3 Sekundarne ključne reči (5–10, po uslugama/temama)
1. IVF Novi Sad (informativno, ne transakciono — ustupljeno Feroni za transakciono, ali korisno za "o oblastima rada")
2. vantelesna oplodnja Novi Sad iskustva (long-tail, informativno)
3. zamrzavanje jajnih ćelija Novi Sad
4. PCOS Novi Sad / PCOS dijagnostika
5. spermogram tumačenje / muški faktor neplodnosti
6. dijagnostika steriliteta Novi Sad
7. ginekolog za neplodnost Novi Sad
8. PAPA test Novi Sad
9. redovni ginekološki pregled Novi Sad
10. prva konsultacija IVF šta poneti (FAQ/long-tail)

### 1.4 Pitanja koja ljudi postavljaju (FAQ izvor)
Iz WebSearch "People also ask"-tipa rezultata i postojećeg IG Q&A formata (research.md odeljak "Highlights"):
- Da li stres utiče na plodnost / da li stres sprečava trudnoću?
- Šta je zamrzavanje jajnih ćelija i kada ima smisla (koje godine)?
- Koliko košta zamrzavanje jajnih ćelija? (odgovor na sajtu: bez konkretne cene, uputiti na kontakt SB Ferona)
- Šta je PCOS i kako se dijagnostikuje?
- Šta je muški faktor neplodnosti / kako se čita spermogram?
- Šta poneti na prvu konsultaciju za IVF/dijagnostiku steriliteta?
- Kada da se javim ginekologu ako ne mogu da ostanem u drugom stanju?
- Da li je vantelesna oplodnja garancija trudnoće? (odgovor: eksplicitno NE, u skladu sa postojećim tonom "nije garancija")
- Šta je razlika između IVF i ICSI?
- Koliko traje IVF postupak (faze, ne uspešnost)?

---

## 2. Konkurencija — pregled

| Sajt | Tip | Zapažanja |
|---|---|---|
| feronaivf.rs | Institucionalni (ustanova) | Dominira Google za transakcione termine; ima stranice po uslugama (`/ivf-vto/`, `/krioprezervacija/`, `/zamrzavanje-jajnih-celija-iz-socijalnih-razloga/`); tim-stranica postoji ali BEZ bio/CV po lekaru — praznina koju lični sajt dr Katanića može popuniti. |
| @dr_trninic_ferona (IG, nema sajt) | Lični brend, ista ustanova | Gradi autoritet brojkama ("25+ god, 1000+ beba") — dr Katanić svesno ne koristi brojke (nema ih), pa lični sajt treba da gradi autoritet kroz edukaciju/medije/konferencije, ne brojke. |
| gemmaclinic.rs | Institucionalni (Beograd) | Šira ponuda (estetska ginekologija, laser), cenovnik delimično javan (npr. `/zamrzavanje-cena/`) — dr Katanić NE treba da ide u tom pravcu (nema cenovnik, nema estetske usluge). |
| Poliklinika Novakov, Perinatal, Genesis, Poliklinika Anđelić | Institucionalni (Novi Sad) | Slična struktura kao Ferona — usluge/vto stranice. Potvrđuje da su transakcioni termini "vantelesna oplodnja Novi Sad" institucionalno zasićeni; nema smisla da lični sajt ulazi u tu bitku. |

**Zaključak:** nedostaje **lični, edukativni, čovečan** sadržaj u ovoj niši u Novom Sadu — tačno ono što dr Katanić već radi na Instagramu. Lični sajt treba da bude prvi koji to prenese na web u ovom lokalnom tržištu.

---

## 3. Arhitektonska odluka — lični brend/portfolio vs. sajt klinike (OBRAZLOŽENJE)

**Odluka: lični brend/portfolio sajt, više stranica, sa jasnim, nenametljivim linkom ka SB Ferona za zakazivanje.**

Razlozi:
1. **Nema sopstvene privatne prakse.** Sve IVF/ginekološke usluge formalno pruža SB Ferona kao pravno lice. Sajt koji bi se predstavljao kao "klinika dr Katanića" bi bio netačan i potencijalno zbunjujući za pacijente (gde se tačno zakazuje, ko izdaje račun, ko je pravno odgovoran).
2. **Izbegavanje kanibalizacije.** feronaivf.rs već ima razvijene stranice po uslugama i dominira Google-om za glavne termine. Lični sajt koji bi dupliranje pravio "svoje" /usluge/vantelesna-oplodnja/ stranice sa istim ključnim recima bi se borio (i gubio) protiv sopstvene ustanove — bez ikakve poslovne logike, jer krajnji cilj (zakazivanje kod dr Katanića u Feroni) je isti.
3. **Diferencijacija kroz ono što Ferona nema:** ličnu priču, edukativni ton, Q&A/FAQ format, medijske nastupe i konferencije (Thrombosis Days, ESHRE, GIGANODE, Mondo.rs, Selfnest) — ovo Ferona sajt ne pokriva po lekaru (tim-stranica je samo ime + slika, bez bio).
4. **Pravno/etički rizik minimizovan.** Portfolio format prirodno izbegava obećanja uspešnosti i cenovnik (jer to nije "njegova" usluga da je cenovno oglašava) — usklađeno sa 0.5.
5. **SEO korist za samu Feronu takođe.** Lični sajt sa jakim autoritetom (backlink, brend pretrage) prirodno linkuje ka feronaivf.rs kao mestu zakazivanja — win-win, ne konkurencija.

**Praktična posledica za strukturu:** stranice o uslugama se ne zovu "Usluge" i ne sadrže cenovnik/rezervacioni sistem — zovu se **"Oblasti rada"** i imaju edukativni, informativni karakter (kao produžetak IG carousela), sa CTA "Za zakazivanje kontaktirajte SB Ferona" (telefon/email/link, uz napomenu iz 0.3).

---

## 4. Struktura sajta i URL-ovi

Više stranica (ne one-page) — opravdano jer: (a) 5 jasno odvojenih tematskih oblasti sa različitim ključnim recima (IVF, social freezing, PCOS, muški faktor, redovni pregledi) profitiraju od posebnih indeksiranih URL-ova; (b) postojeći IG sadržaj je dovoljno obiman da popuni blog/FAQ sekcije; (c) YMYL/E-E-A-T logika (medicinska tema) nagrađuje dubinu i jasnu autorsku strukturu (bio stranica, izvori, mediji) više nego kompresovan one-pager.

```
/                                          Početna
/o-meni/                                  O meni (bio, obrazovanje, afilijacije)
/oblasti-rada/                            Hub — pregled oblasti rada
/oblasti-rada/vantelesna-oplodnja-ivf/    IVF / ICSI — edukativno
/oblasti-rada/zamrzavanje-jajnih-celija/  Social freezing
/oblasti-rada/pcos-i-neplodnost/          PCOS, hormonske analize, ovulacija
/oblasti-rada/muski-faktor-neplodnosti/   Spermogram / muški faktor
/oblasti-rada/redovni-ginekoloski-pregledi/  PAPA test, redovni pregledi, skrining
/pitanja-i-odgovori/                      FAQ hub (Q&A format sa IG)
/blog/                                    Edukativni tekstovi (lista)
/blog/prva-konsultacija-sta-poneti/
/blog/pcos-najcesce-zablude/
/blog/da-li-stres-utice-na-plodnost/
/blog/kada-razmisljati-o-zamrzavanju-jajnih-celija/
/blog/spermogram-osnovni-pojmovi/
/mediji-i-predavanja/                     Mediji, konferencije, gostovanja
/kontakt/                                 Kontakt / zakazivanje (SB Ferona)
/politika-privatnosti/                    Privatnost podataka pacijenata (GDPR)
```

Napomena: `/blog/` slugove tretirati kao predlog — Copywriter može dodati/preimenovati, ali treba da ostane pattern `/blog/kratka-kebab-case-fraza/` bez dijakritika.

---

## 5. Plan po stranici

### 5.1 Početna — `/`
- **Title:** `dr Filip Katanić – ginekolog, IVF i vantelesna oplodnja | Novi Sad` (58 zn.)
- **Meta description:** `Dr Filip Katanić, doktor medicine, član tima SB Ferona u Novom Sadu. Edukacija o IVF-u, PCOS-u i putu ka roditeljstvu — bez obećanja, sa razumevanjem.` (153 zn.)
- **H1:** `dr Filip Katanić — ginekologija i put ka roditeljstvu`
- **H2/H3 plan:**
  - H2 Oblasti rada (kratke kartice → linkovi na 5 `/oblasti-rada/*` stranica)
  - H2 Zašto edukacija (kratak uvod, ton empatije, citat "Nije garancija, ali može sačuvati važnu šansu")
  - H2 Mediji i konferencije (kratki izvod → link na `/mediji-i-predavanja/`)
  - H2 Najčešća pitanja (3-4 FAQ stavke → link na `/pitanja-i-odgovori/`)
  - H2 Zakazivanje (CTA blok, ne agresivan — vidi 0.3, 0.5)
- **Interni linkovi:** ka svim 5 `/oblasti-rada/*`, `/o-meni/`, `/pitanja-i-odgovori/`, `/mediji-i-predavanja/`, `/kontakt/`
- **Alt tekst plan:** `dr Filip Katanić, doktor medicine, portret` (hero slika); `dr Filip Katanić na konferenciji Thrombosis Days` (ako se koristi)
- **OG:** `og:type=website`, `og:title` = title, `og:description` = meta description, `og:image` = portret (min 1200×630), `og:locale=sr_RS`

### 5.2 O meni — `/o-meni/`
- **Title:** `O meni – dr Filip Katanić, doktor medicine | SB Ferona, Novi Sad` (59 zn.)
- **Meta description:** `Doktor medicine, master reproduktivne embriologije, član tima Specijalne bolnice Ferona u Novom Sadu. Obrazovanje, afilijacije i pristup radu.` (150 zn.)
- **H1:** `dr Filip Katanić`
- **H2/H3:**
  - H2 Obrazovanje i afilijacije (koristi SAMO potvrđene podatke: master reproduktivne embriologije; član tima SB Ferona; napomena o statusu se NE navodi dok se ne potvrdi — vidi 0.2)
  - H2 Pristup radu (edukativan, empatičan ton — parafraza IG citata bez copy-paste)
  - H2 Konferencije i predavanja (kratak izvod, link na `/mediji-i-predavanja/`)
  - H3 Napomena o tituli — **ne prikazivati kao vidljiv naslov na sajtu**, ali interno svi tekstovi na ovoj stranici moraju proći 0.1 filter (nema "specijalista")
- **Interni linkovi:** `/mediji-i-predavanja/`, `/oblasti-rada/`, `/kontakt/`
- **Alt tekst:** `dr Filip Katanić, portret u ordinaciji`; `dr Filip Katanić predaje na stručnoj konferenciji`
- **OG:** `og:type=profile` (ako platforma podržava) ili `website`; slika portret

### 5.3 Hub — `/oblasti-rada/`
- **Title:** `Oblasti rada – ginekologija i IVF | dr Filip Katanić` (52 zn.)
- **Meta description:** `Pregled oblasti rada dr Filipa Katanića: IVF/ICSI, zamrzavanje jajnih ćelija, PCOS, muški faktor neplodnosti, redovni ginekološki pregledi.` (147 zn.)
- **H1:** `Oblasti rada`
- **H2:** kratki uvod po kartici (5 kartica → 5 podstranica)
- **Interni linkovi:** ka svih 5 podstranica + `/pitanja-i-odgovori/`

### 5.4 `/oblasti-rada/vantelesna-oplodnja-ivf/`
- **Title:** `Vantelesna oplodnja (IVF/ICSI) – edukacija | dr Filip Katanić` (58 zn.)
- **Meta description:** `Šta je IVF/ICSI postupak, kako izgleda dijagnostika steriliteta i priprema. Edukativni sadržaj dr Filipa Katanića, bez obećanja ishoda.` (140 zn.)
- **H1:** `Vantelesna oplodnja (IVF) i ICSI`
- **H2/H3:**
  - H2 Šta je IVF/ICSI (opšte, informativno)
  - H2 Dijagnostika steriliteta — prvi koraci
  - H2 Priprema za prvu konsultaciju (link na blog checklist)
  - H2 Emotivna strana puta (empatičan pasus — "nije garancija", "nije samo stres")
  - H3 Napomena: "Postupak se sprovodi u okviru SB Ferona; za zakazivanje pogledajte Kontakt."
- **Interni linkovi:** `/blog/prva-konsultacija-sta-poneti/`, `/pitanja-i-odgovori/`, `/kontakt/`, `/oblasti-rada/muski-faktor-neplodnosti/`
- **Alt tekst:** `Ilustracija faza IVF postupka`; `dr Filip Katanić objašnjava dijagnostiku steriliteta`
- **FAQPage (mini, 2-3 pitanja):** "Da li IVF garantuje trudnoću?", "Kolika je razlika između IVF i ICSI?"

### 5.5 `/oblasti-rada/zamrzavanje-jajnih-celija/`
- **Title:** `Zamrzavanje jajnih ćelija (social freezing) | dr Filip Katanić` (58 zn.)
- **Meta description:** `Kada zamrzavanje jajnih ćelija ima smisla i šta postupak obuhvata. Edukativan pregled dr Filipa Katanića — bez garancija, sa realnim očekivanjima.` (150 zn.)
- **H1:** `Zamrzavanje jajnih ćelija`
- **H2/H3:** Šta je social freezing / Kada razmišljati o ovoj opciji (starost, okolnosti — informativno) / Šta postupak obuhvata / "Nije garancija trudnoće, ali može sačuvati važnu šansu" (citat prilagođen tonu)
- **Interni linkovi:** `/blog/kada-razmisljati-o-zamrzavanju-jajnih-celija/`, `/kontakt/`
- **Alt tekst:** `Dijagram postupka zamrzavanja jajnih ćelija`

### 5.6 `/oblasti-rada/pcos-i-neplodnost/`
- **Title:** `PCOS i neplodnost – dijagnostika i praćenje | dr Filip Katanić` (58 zn.)
- **Meta description:** `Šta je PCOS, kako se dijagnostikuje i kako se prati ovulacija. Edukativan sadržaj i najčešće zablude o PCOS-u.` (114 zn.)
- **H1:** `PCOS i neplodnost`
- **H2/H3:** Šta je PCOS / Dijagnostika i hormonske analize / Praćenje ovulacije / 5 zabluda o PCOS-u (link na blog)
- **Interni linkovi:** `/blog/pcos-najcesce-zablude/`
- **Alt tekst:** `Infografika – simptomi i dijagnostika PCOS-a`

### 5.7 `/oblasti-rada/muski-faktor-neplodnosti/`
- **Title:** `Muški faktor neplodnosti – spermogram | dr Filip Katanić` (56 zn.)
- **Meta description:** `Tumačenje spermograma i uloga muškog faktora u dijagnostici steriliteta parova. Edukativan sadržaj dr Filipa Katanića.` (117 zn.)
- **H1:** `Muški faktor neplodnosti`
- **H2/H3:** Šta je spermogram i šta pokazuje / Kada se preporučuje analiza / Sledeći korak nakon rezultata
- **Interni linkovi:** `/blog/spermogram-osnovni-pojmovi/`, `/oblasti-rada/vantelesna-oplodnja-ivf/`

### 5.8 `/oblasti-rada/redovni-ginekoloski-pregledi/`
- **Title:** `Redovni ginekološki pregledi i PAPA test | dr Filip Katanić` (58 zn.)
- **Meta description:** `Zašto su redovni ginekološki pregledi i PAPA test važni za rano otkrivanje promena. Edukativan pregled dr Filipa Katanića.` (122 zn.)
- **H1:** `Redovni ginekološki pregledi i PAPA test`
- **H2/H3:** Zašto su redovni pregledi važni / Šta je PAPA test i skrining grlića materice / Koliko često na pregled (informativno, opšte preporuke, ne lični protokol)
- **Napomena za copywriter-a:** ovde se može referisati Mondo.rs intervju (o slučaju propuštenog karcinoma uprkos urednom PAPA testu) kao ilustraciju važnosti redovnih pregleda — bez senzacionalizma, uz link na izvor.

### 5.9 `/pitanja-i-odgovori/` (FAQ hub)
- **Title:** `Pitanja i odgovori – IVF, PCOS, plodnost | dr Filip Katanić` (58 zn.)
- **Meta description:** `Odgovori na najčešća pitanja o IVF-u, PCOS-u, zamrzavanju jajnih ćelija i muškom faktoru neplodnosti — jasno i bez obećanja.` (128 zn.)
- **H1:** `Pitanja i odgovori`
- Sadržaj: sva pitanja iz odeljka 1.4 + dodatna iz IG Q&A highlighta (kada se dobiju od klijenta/Asset Collector-a)
- **FAQPage schema** (glavni nosač ove sheme, vidi 6.3)
- **Interni linkovi:** ka relevantnim `/oblasti-rada/*` stranicama po pitanju

### 5.10 `/blog/` i podstranice
- **Title (hub):** `Blog – edukacija o IVF-u i ginekologiji | dr Filip Katanić` (56 zn.)
- **Meta description (hub):** `Edukativni tekstovi dr Filipa Katanića o IVF-u, PCOS-u, zamrzavanju jajnih ćelija i muškom faktoru neplodnosti.` (112 zn.)
- Podstranice — Copywriter piše title/meta po tekstu koristeći isti obrazac (usluga/tema + "objašnjeno" ili pitanje kao title); primer:
  - `/blog/prva-konsultacija-sta-poneti/` — Title: `Prva konsultacija za IVF – šta poneti | dr Filip Katanić` (56 zn.); H1: `Prva konsultacija — šta poneti`
  - `/blog/da-li-stres-utice-na-plodnost/` — Title: `Da li stres utiče na plodnost? | dr Filip Katanić` (48 zn.); H1 kao pitanje (dobro za PAA snippet)
- **Svaka objava:** Article schema (vidi 6.4), autor Person (dr Filip Katanić), datum objave/izmene

### 5.11 `/mediji-i-predavanja/`
- **Title:** `Mediji i predavanja – dr Filip Katanić` (39 zn.)
- **Meta description:** `Medijski nastupi i stručna predavanja dr Filipa Katanića: Mondo.rs, Selfnest, Thrombosis Days, ESHRE, GIGANODE.` (109 zn.)
- **H1:** `Mediji i predavanja`
- **H2/H3:** Medijski nastupi (Mondo.rs intervju, Popodne sa Tanjom, Selfnest) / Stručne konferencije (Thrombosis Days, ESHRE, GIGANODE, Divčibare, Bio Save, SPRING Fertility)
- **Napomena:** linkovati direktno na izvore (mondo.rs članak, YouTube epizode) — ne prepisivati tuđi sadržaj, samo referisati/citirati kratko uz link.
- **Alt tekst:** `dr Filip Katanić predaje na konferenciji Thrombosis Days, Švajcarska`; `dr Filip Katanić gost u intervjuu za Mondo.rs`

### 5.12 `/kontakt/`
- **Title:** `Kontakt i zakazivanje – dr Filip Katanić, SB Ferona` (52 zn.)
- **Meta description:** `Zakazivanje pregleda kod dr Filipa Katanića u SB Ferona, Šarplaninska 19, Novi Sad. Telefon +381 21 3000 220, office@ferona.rs.` (126 zn.)
- **H1:** `Kontakt i zakazivanje`
- **H2/H3:**
  - H2 Zakazivanje pregleda (jasna napomena: "Zakazivanje se vrši preko kontakt centra SB Ferona" — vidi 0.3)
  - H2 Lokacija (embed Google mape, adresa)
  - H3 Napomena o kontaktu (kontakt podaci su ustanove, ne lična linija — transparentno navesti)
- **Sadržaj kontakt bloka:**
  ```
  SB "Ferona"
  Šarplaninska 19, 21000 Novi Sad
  Tel: +381 21 3000 220
  Email: office@ferona.rs
  (Kontakt centar ustanove — za zakazivanje pregleda kod dr Filipa Katanića)
  ```
- **Interni linkovi:** link na feronaivf.rs (spoljni, `rel="noopener"`, ne nužno "nofollow" — legitiman partner/matična ustanova)
- **NEMA cenovnika, NEMA radnog vremena** dok se ne potvrdi (vidi odeljak 8)

### 5.13 `/politika-privatnosti/`
- **Title:** `Politika privatnosti | dr Filip Katanić` (39 zn.)
- **Meta description:** `Kako se štite podaci posetitelja sajta i pacijenata. Testimonijali se objavljuju isključivo uz saglasnost pacijentkinje.` (120 zn.)
- **H1:** `Politika privatnosti`
- Sadržaj: standardna politika (kolačići/analitika, kontakt formular, čuvanje podataka) + eksplicitna napomena o pravilu "Objavljeno uz saglasnost pacijentkinje" za svaki testimonial na sajtu.

---

## 6. Tehničko SEO

### 6.1 Osnovno
- `<html lang="sr-Latn-RS">` (ili "sr" ako se koristi ćirilica negde — ovaj sajt je latinica po uputstvu, koristiti `sr-Latn-RS`)
- Nema drugih jezičkih verzija u planu → nema hreflang-a (dodati ako klijent kasnije traži englesku verziju za medicinski turizam)
- `canonical` na svakoj stranici (self-referencing, `https://[DOMEN]/putanja/`)
- `sitemap.xml` — auto-generisan, uključuje sve stranice iz odeljka 4
- `robots.txt`:
  ```
  User-agent: *
  Allow: /
  Sitemap: https://[DOMEN]/sitemap.xml
  ```
- Favicon: bazirati na FK monogramu iz `brand.md` (odeljak 8) — ako ne postoji vektorska verzija, redizajnirati minimalno (krug + inicijali) pre generisanja seta veličina (16/32/180/512px + `site.webmanifest`)

### 6.2 Person schema (sitewide — homepage + `/o-meni/`)
**NAPOMENA:** ne koristiti `Physician` tip (implicira formalnu medicinsku praksu/ustanovu kao samostalan entitet) niti `LocalBusiness`/`MedicalBusiness` za dr Katanića lično — on nema sopstvenu registrovanu praksu (vidi odeljak 3). Koristi se `Person` sa `worksFor` koji upućuje na Feronu kao organizaciju.

```json
{
  "@context": "https://schema.org",
  "@type": "Person",
  "name": "dr Filip Katanić",
  "url": "https://[DOMEN]/",
  "image": "https://[DOMEN]/assets/filip-katanic-portret.jpg",
  "jobTitle": "Lekar",
  "description": "Doktor medicine, master reproduktivne embriologije, član tima Specijalne bolnice Ferona u Novom Sadu.",
  "worksFor": {
    "@type": "MedicalOrganization",
    "name": "Specijalna bolnica \"Ferona\"",
    "url": "https://feronaivf.rs/",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "Šarplaninska 19",
      "addressLocality": "Novi Sad",
      "postalCode": "21000",
      "addressCountry": "RS"
    }
  },
  "sameAs": [
    "https://www.instagram.com/drfilipkatanic/"
  ]
}
```
- `jobTitle` je namerno "Lekar" (neutralno, činjenično tačno bez obzira na ishod pitanja o specijalizaciji) — NIKAD "Specijalista ginekologije i akušerstva".
- `alumniOf` (Medicinski fakultet Novi Sad) je namerno IZOSTAVLJEN — podatak je posredan/nepotvrđen (vidi web-research.md tačka 6), dodati samo uz pismenu potvrdu klijenta.
- Ne dodavati `award` bez konkretne, potvrđene nagrade (konferencije/predavanja nisu formalne nagrade — mogu ići kroz `Person.knowsAbout` ili opisno u tekstu, ne kao `award`).

### 6.3 FAQPage schema (na `/pitanja-i-odgovori/` i mini-verzije po `/oblasti-rada/*`)
```json
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "Da li vantelesna oplodnja garantuje trudnoću?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Ne. IVF postupak povećava šansu u zavisnosti od individualnih faktora, ali nijedan medicinski postupak ne može garantovati ishod. Svaki slučaj se procenjuje individualno."
      }
    }
  ]
}
```
Sve odgovore piše Copywriter u skladu sa 0.5/0.6 — bez brojki, bez obećanja.

### 6.4 Article schema (blog postovi)
```json
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "[naslov teksta]",
  "author": { "@type": "Person", "name": "dr Filip Katanić" },
  "publisher": {
    "@type": "Organization",
    "name": "dr Filip Katanić",
    "logo": { "@type": "ImageObject", "url": "https://[DOMEN]/assets/favicon-512.png" }
  },
  "datePublished": "YYYY-MM-DD",
  "dateModified": "YYYY-MM-DD",
  "image": "https://[DOMEN]/assets/[slika-clanka].jpg",
  "mainEntityOfPage": "https://[DOMEN]/blog/[slug]/"
}
```
Ne koristiti `MedicalWebPage` tip osim ako se sav sadržaj dodatno medicinski recenzira/cita izvore — za sada `Article` je bezbedniji (manji rizik pogrešne implikacije formalnog medicinskog autoritativnog sadržaja bez recenzije).

### 6.5 Open Graph / Twitter (template, primenjuje se po stranici sa vrednostima iz odeljka 5)
```html
<meta property="og:type" content="website">
<meta property="og:site_name" content="dr Filip Katanić">
<meta property="og:title" content="[Title stranice]">
<meta property="og:description" content="[Meta description stranice]">
<meta property="og:image" content="https://[DOMEN]/assets/og-[stranica].jpg">
<meta property="og:url" content="https://[DOMEN]/[putanja]/">
<meta property="og:locale" content="sr_RS">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="[Title stranice]">
<meta name="twitter:description" content="[Meta description stranice]">
<meta name="twitter:image" content="https://[DOMEN]/assets/og-[stranica].jpg">
```
OG slike: 1200×630px, isti topao krem/navy vizuelni stil iz `brand.md` (ne stock fotografije, ne pre/posle).

### 6.6 Šta se NE implementira (eksplicitno)
- `AggregateRating` / `Review` schema — dok se Google ocena ne potvrdi ručno (vidi odeljak 8).
- `LocalBusiness` / `MedicalBusiness` / `Physician` sa sopstvenom adresom/telefonom za dr Katanića kao samostalan biznis-entitet.
- `PriceSpecification` / cenovnik u bilo kom obliku.

---

## 7. Lokalni SEO (Novi Sad)

- **NAP konzistentnost:** svuda gde se prikazuje adresa/telefon/email (Kontakt stranica, footer, schema), koristiti IDENTIČAN format:
  `SB "Ferona", Šarplaninska 19, 21000 Novi Sad · +381 21 3000 220 · office@ferona.rs`
  — uz napomenu da su to podaci ustanove (0.3).
- **Google mapa:** embed iframe na `/kontakt/` sa lokacijom Šarplaninska 19, Novi Sad (koristiti Ferona-inu tačku na mapi, ne kreirati novi pin za "kliniku dr Katanića" jer takva samostalna lokacija ne postoji).
- **Google Business Profile — preporuka:** ako klijent i ustanova žele, moguće je otvoriti **poseban GBP profil za dr Katanića kao lekara na istoj adresi** (praksa koju mnogi individualni lekari u zdravstvenim ustanovama koriste), ali to zahteva: (a) pismenu saglasnost/koordinaciju sa upravom SB Ferona (ne otvarati samostalno bez njihovog znanja — adresa je njihova), (b) potvrđen status zaposlenja (0.2). Ovo NE raditi u prvoj fazi lansiranja sajta — staviti kao odvojen naredni korak nakon pravne provere.
- Ne kreirati duplikat/konkurentski GBP unos za samu ustanovu — Ferona već ima svoj.
- Lokalni signali na sajtu: pominjanje "Novi Sad" prirodno u H1/H2/tekstu (ne keyword-stuffing), embed mape, NAP u footeru svake stranice.

---

## 8. Performanse

- **Cilj LCP < 2.5s** — hero slika na početnoj mora biti optimizovana (WebP/AVIF, `fetchpriority="high"`, bez lazy-load na above-the-fold slici).
- **Lazy-loading** (`loading="lazy"`) za sve slike ispod prvog ekrana (portreti sa konferencija, blog ilustracije, infografike).
- **Dimenzije slika** — svaka `<img>` mora imati `width`/`height` atribute (ili `aspect-ratio` u CSS-u) radi izbegavanja CLS-a.
- **Fontovi** (`brand.md` odeljak 4 — Fraunces + Karla ili Lora + Mulish): `font-display: swap`, preconnect na Google Fonts, ograničiti broj težina (max 3-4 po fontu) radi manjeg payload-a.
- **JSON-LD** i ostali skriptovi — inline za kritični schema markup, ostatak (analytics) učitavati `defer`/`async`.
- Slike carousela/infografika (ako se re-koriste iz IG asset-a) — re-export u WebP, ne direktno JPEG export iz IG-a (loš kompresija).

---

## 9. Otvorena pitanja za klijenta (redosled po prioritetu)

1. **TITULA** — da li je dr Katanić zvanično položio specijalistički ispit iz ginekologije i akušerstva (status "specijalista") ili je trenutno specijalizant/doktorand? Potrebna pismena potvrda (npr. skenirano uverenje ili jasna izjava) pre nego što se bilo koja formulacija o zvanju stavi na sajt. **Bez ovog odgovora, pravilo iz 0.1 ostaje na snazi neograničeno.**
2. **Status zaposlenja u SB Ferona** — zaposlen, spoljni saradnik, ili nešto treće? Da li postoji ugovorno ograničenje o tome kako se sme predstavljati afilijacija na sopstvenom sajtu?
3. **Radno vreme** — ni na jednom izvoru nije potvrđeno; da li postoji fiksni raspored za preglede kod dr Katanića (čak i ako je opšte radno vreme Ferone drugačije)?
4. **Cenovnik** — da li klijent želi da se na sajtu pomene bilo kakav okvirni raspon cena (npr. "cena se određuje individualno, kontaktirajte Feronu"), ili potpuno izbegavati temu cene?
5. **Google recenzije** — potrebna ručna provera direktno na Google Maps (trenutni izvori se ne slažu: 4.0/203 vs 3.9/217) neposredno pre lansiranja; da li klijent/ustanova želi da se ocena uopšte prikazuje na sajtu dr Katanića (koji nije nosilac tog GBP profila)?
6. **Domen** — koji domen se kupuje (`.rs` preporučeno za lokalni SEO; provera dostupnosti `drfilipkatanic.rs`)?
7. **Testimonijali** — da li postoje već prikupljene pisane saglasnosti pacijentkinja za korišćenje na sajtu (van IG), i da li klijent može da dostavi tekst tih iskustava sa saglasnošću?
8. **Fotografije/portreti** — koje fotografije klijent ima u visokoj rezoluciji za hero/OG slike (van IG kompresije)? Da li postoji vektorska verzija FK monograma za favicon?
9. **Google Business Profile** — da li klijent želi poseban GBP profil kao lekar (odvojeno od Ferone), i da li je to usaglašeno sa upravom ustanove?
10. **Obrazovanje (Medicinski fakultet Novi Sad)** — da li klijent može pismeno potvrditi ustanovu i godinu diplomiranja, kako bi se `alumniOf` mogao bezbedno dodati u schema markup?
11. **Kontakt formular vs. samo telefon/email** — da li klijent želi formular na `/kontakt/` koji šalje upit direktno njemu (a ne u Feronin kontakt centar), ili sve usmeriti na postojeći kontakt centar ustanove?

---

## Sažetak za sledeće agente

- **Primarna ključna reč:** "dr Filip Katanić ginekolog Novi Sad" (brend + long-tail; glavni transakcioni termin "vantelesna oplodnja Novi Sad" svesno ustupljen feronaivf.rs).
- **Struktura:** više stranica (~15), lični brend/portfolio format — "Oblasti rada" umesto "Usluge", FAQ hub, blog, Mediji i predavanja, Kontakt sa jasnom napomenom da su podaci institucionalni.
- **Arhitektonska odluka:** NE sajt klinike — lični brend koji vodi ka SB Ferona za zakazivanje, izbegava kanibalizaciju i pravni rizik samostalne prakse koja ne postoji.
- **Titula:** dok se ne potvrdi pismeno, reč "specijalista" se NIGDE ne koristi — ovo pravilo je apsolutni prioritet za sve dalje faze (copywriting, dizajn, razvoj).
