# Copy: dr Filip Katanić (@drfilipkatanic), ginekologija / IVF, Novi Sad

Jezik: srpski (latinica, sa dijakriticima). Ton: empatičan, uzdržan, edukativan — nastavak postojećeg IG glasa. Obraćanje "Vi" u kontekstu para/pacijenta, prvo lice kad govori o sebi. Kratke rečenice. Jezik uslovan ("može", "plan", "nije garancija"), nikad definitivan ("izlečićemo", "garantujemo"). Bez emoji-ja u tekstu sajta. Bez procenata uspešnosti, bez poređenja sa drugim lekarima/klinikama, bez agresivnog CTA-a.

**NIGDE reč "specijalista"/"specijalistkinja"/"specialist"** — vidi seo.md odeljak 0.1 i structure.md odeljak 0.2. Umesto zvanja koristi se oblast rada i afilijacija: "dr Filip Katanić", "doktor medicine", "master reproduktivne embriologije", "član tima SB Ferona".

Ključevi su tačno iz kolone "Tekst" u structure.md (`[home.*]`, `[omeni.*]`, `[oblasti.*]`, `[oblast.<slug>.*]` sa slug: ivf, freezing, pcos, muski, pregledi; `[faq.*]`, `[blog.<slug>.*]`, `[mediji.*]`, `[kontakt.*]`, `[privatnost.*]`, `[global.*]`). Title (≤60) i meta (≤155) su iz seo.md doslovno gde postoje; za dve blog stranice koje seo.md nije doslovno predvideo (stvarni slugovi iz structure.md), title/meta su napisani po istom obrascu i proverenoj dužini.

## Konvencije za Developera

- `### [ključ]` je blok za mapiranje. `H1`, `H2`, `Lead`, `Pasus`, `Citat`, `CTA`, `P:` (pitanje), `O:` (odgovor), `Alt` su oznake uloge unutar bloka.
- `{link: /putanja/}` je interni link; spoljni linkovi su označeni "(spoljni link, rel=\"noopener\")".
- `[POTVRDITI SA KLIJENTOM: ...]` — tekst se NE objavljuje dok klijent ne potvrdi. Sve stavke su sabrane na kraju fajla.
- FAQ tekst na `/pitanja-i-odgovori/` je identičan onome u `FAQPage` JSON-LD; mini-FAQ na `/oblasti-rada/*` stranicama koristi identičnu formulaciju pitanja/odgovora kao odgovarajuća stavka u hubu (konzistentnost sheme).
- Cene, radno vreme, tačan status titule/zaposlenja, Google recenzije — nigde na sajtu (seo.md 0.5, 0.6).
- Sve institucionalne kontakt podatke (telefon, email, adresa) prati napomena da pripadaju SB Feroni, ne ličnoj liniji dr Katanića.

---

## GLOBALNO

### [global.credential]
Lekar · Master reproduktivne embriologije · Član tima SB Ferona

### [global.ferona]
```
SB "Ferona"
Šarplaninska 19, 21000 Novi Sad
Tel: +381 21 3000 220 (tel:+381213000220)
Email: office@ferona.rs
```
Napomena (obavezna svuda gde se ovaj blok prikazuje): Kontakt centar ustanove — za zakazivanje pregleda kod dr Filipa Katanića. Telefon i email pripadaju SB Feroni, ne ličnoj liniji dr Katanića.

### [global.venue]
Tanka traka ispod hero-a na svakoj `/oblasti-rada/*` stranici:
Postupci se sprovode u okviru SB Ferona, Šarplaninska 19, Novi Sad.

### [global.cta]
Seal: (dekorativni FK pečat, `aria-hidden`, opacity .06)
H2: Sledeći korak je razgovor
Lead: Za zakazivanje pregleda obratite se kontakt centru SB Ferona — ustanove u kojoj dr Filip Katanić radi.
CTA 1 (primarno): Zakažite u SB Feroni (`tel:+381213000220`)
CTA 2 (sekundarno): Poruka na Instagramu (`https://instagram.com/drfilipkatanic`)
Red: +381 21 3000 220 · Šarplaninska 19, Novi Sad
Citat: "Ne možemo kontrolisati baš sve, ali možemo napraviti najbolji plan."

### [global.nav]
O meni · Oblasti rada · Pitanja i odgovori · Blog · Mediji i predavanja · Kontakt
Dugme: Zakažite u SB Feroni
Skip link: Preskoči na sadržaj
Mikro-linija ispod logotipa (header): GINEKOLOGIJA · IVF

Dropdown "Oblasti rada" (naslov · jedna rečenica, isti tekst kao `[oblast.<slug>.short]`):
- IVF / ICSI — Dijagnostika i edukacija o postupku vantelesne oplodnje.
- Zamrzavanje jajnih ćelija — Kada ova opcija ima smisla i šta obuhvata.
- PCOS i neplodnost — Dijagnostika, praćenje ovulacije i najčešće zablude.
- Muški faktor neplodnosti — Tumačenje spermograma i sledeći koraci.
- Redovni ginekološki pregledi — PAPA test i redovna kontrola kod ginekologa.

Mobilni meni, dno: Zakažite u SB Feroni (`tel:+381213000220`) · Poruka dr Kataniću na Instagramu (@drfilipkatanic) · SB Ferona, Šarplaninska 19, Novi Sad

### [global.sticky]
[ Zakažite u SB Feroni ] (`tel:+381213000220`) · [ Poruka na Instagramu ]

### [global.footer]
Brend: dr Filip Katanić
Credential: `[global.credential]`
Citat: "Ne možemo kontrolisati baš sve, ali možemo napraviti najbolji plan."
Kolona "Oblasti rada": IVF / ICSI · Zamrzavanje jajnih ćelija · PCOS i neplodnost · Muški faktor neplodnosti · Redovni ginekološki pregledi
Kolona "Sajt": O meni · Pitanja i odgovori · Blog · Mediji i predavanja · Kontakt
Kolona "Kontakt / Ustanova": `[global.ferona]` (NAP) + Instagram @drfilipkatanic
Donja traka: © 2026 dr Filip Katanić · Politika privatnosti · Nazad na vrh
Napomena (13px): `[global.disclaimer]`

### [global.disclaimer]
Sadržaj sajta je informativan i edukativan i ne zamenjuje pregled ili konsultaciju lekara. Postupci se sprovode u okviru Specijalne bolnice Ferona. Svaki slučaj se procenjuje individualno.

### [global.breadcrumb]
Početna / Oblasti rada / [naziv oblasti]

### [global.404]
H1: Stranica nije pronađena
Tekst: Stranica koju tražite ne postoji ili je premeštena. Vratite se na početnu ili pogledajte oblasti rada.
CTA: Na početnu · Oblasti rada

### [global.alt]
- Header/footer FK pečat: dekorativni element, `alt=""` (`aria-hidden`)
- Mapa na `/kontakt/`: Mapa: SB Ferona, Šarplaninska 19, Novi Sad

---

## 1. POČETNA `/`

**Title:** dr Filip Katanić – ginekolog, IVF i vantelesna oplodnja | Novi Sad (58)
**Meta:** Dr Filip Katanić, doktor medicine, član tima SB Ferona u Novom Sadu. Edukacija o IVF-u, PCOS-u i putu ka roditeljstvu — bez obećanja, sa razumevanjem. (153)
**H1:** dr Filip Katanić — ginekologija i put ka roditeljstvu

### [home.hero]
Eyebrow: GINEKOLOGIJA · IVF · NOVI SAD
H1: dr Filip Katanić — ginekologija i put ka roditeljstvu
Podnaslov: Edukacija i podrška na putu ka roditeljstvu — bez obećanja, sa razumevanjem.
Credential: `[global.credential]` + link "Saznajte više o meni →" {link: /o-meni/}
CTA primarno: Zakažite u SB Feroni
CTA sekundarno: Pogledajte oblasti rada ↓
Venue red: SB Ferona · Šarplaninska 19, Novi Sad
Alt (hero.webp, kropovano po pravilu 0.2, samo gornjih ~55%): dr Filip Katanić, doktor medicine, portret

### [home.philosophy]
Eyebrow: PRISTUP
Citat: "Ne možemo kontrolisati baš sve, ali možemo napraviti najbolji plan."
Pasus 1: Put ka roditeljstvu retko je pravolinijski, i to je u redu. Svaki razgovor počinje od Vaše situacije, ne od šablona.
Pasus 2: Nijedan medicinski postupak ne može garantovati ishod. Ono što možemo jeste da informišemo jasno, bez ulepšavanja, i da zajedno napravimo plan koji ima smisla za Vas.
(potpis element: `.seal` na kraju citata)

### [home.areas]
Eyebrow: OBLASTI RADA
H2: Čime se bavim
Uvod: Pet oblasti u kojima dr Filip Katanić radi u okviru tima SB Ferona — od dijagnostike steriliteta do redovnih pregleda.

### [oblast.ivf.short]
Naslov: IVF / ICSI
Tekst: Dijagnostika steriliteta i edukacija o postupku vantelesne oplodnje, korak po korak.
Link: Saznajte više →

### [oblast.freezing.short]
Naslov: Zamrzavanje jajnih ćelija
Tekst: Kada ova opcija ima smisla i šta zamrzavanje jajnih ćelija zapravo obuhvata.
Link: Saznajte više →

### [oblast.pcos.short]
Naslov: PCOS i neplodnost
Tekst: Dijagnostika, praćenje ovulacije i razbijanje najčešćih zabluda o PCOS-u.
Link: Saznajte više →

### [oblast.muski.short]
Naslov: Muški faktor neplodnosti
Tekst: Tumačenje spermograma i uloga muškog faktora u dijagnostici steriliteta.
Link: Saznajte više →

### [oblast.pregledi.short]
Naslov: Redovni ginekološki pregledi
Tekst: PAPA test, skrining grlića materice i zašto redovna kontrola nije nešto što treba odlagati.
Link: Saznajte više →

### [home.about]
Eyebrow: O MENI
H2: Ko sam ja
Pasus: dr Filip Katanić, doktor medicine i master reproduktivne embriologije, deo je tima SB Ferona u Novom Sadu. Bavi se ginekologijom i oblašću vantelesne oplodnje, uz naglasak na edukaciji i razumljivom objašnjavanju svakog koraka.
Credential: `[global.credential]`
Link: Saznajte više o meni → {link: /o-meni/}
Alt (brend-vizual-01.webp): dr Filip Katanić, portret

### [home.media]
Eyebrow: MEDIJI I PREDAVANJA
H2: Van ordinacije
Uvod: dr Filip Katanić govorio je na stručnim skupovima poput Thrombosis Days (Švajcarska), ESHRE i GIGANODE (Švajcarska), i gostovao u medijima poput Mondo.rs i Selfnest.
Link: Svi mediji i predavanja → {link: /mediji-i-predavanja/}
Alt mini-grid: dr Filip Katanić sa kolegama na ESHRE kongresu · dr Filip Katanić kao predavač na stručnom skupu u Divčibarama · dr Filip Katanić na predavanju u okviru Bio Save programa

### [home.edu]
Eyebrow: IZ EDUKACIJE
H2: Znanje pre razgovora
Uvod: Kratki edukativni tekstovi o tome kako IVF postupak zaista izgleda, korak po korak.
Naslovi kartica u karuselu: Koliko ćelija je potrebno za embrion · Šta se zaista dešava tokom IVF postupka · PCOS i neplodnost · Da li je ovo normalno?
Link: Sve iz edukacije → {link: /blog/}

### [home.faq]
H2: Najčešća pitanja
(4 stavke, isti tekst kao `[faq.ivf.1]`, `[faq.freezing.1]`, `[faq.opste.1]`, `[faq.opste.3]` iz FAQ huba — skraćeni odgovori na naslovnoj)
Link: Sva pitanja → {link: /pitanja-i-odgovori/}

### [home.cta]
`[global.cta]`

---

## 2. O MENI `/o-meni/`

**Title:** O meni – dr Filip Katanić, doktor medicine | SB Ferona, Novi Sad (59)
**Meta:** Doktor medicine, master reproduktivne embriologije, član tima Specijalne bolnice Ferona u Novom Sadu. Obrazovanje, afilijacije i pristup radu. (150)
**H1:** dr Filip Katanić

### [omeni.hero]
H1: dr Filip Katanić
Credential: `[global.credential]`
Lead: Ginekologija i vantelesna oplodnja zahtevaju strpljenje, jasnoću i razumevanje. Ovde možete pročitati nešto više o tome kako radim i gde.
CTA: Zakažite u SB Feroni
Alt (portret-01.webp, čista slika bez utisnutog teksta): dr Filip Katanić, portret

### [omeni.who]
Eyebrow: KO SAM JA
H2: Ko sam ja
Pasus 1: Ja sam Filip Katanić, doktor medicine. Bavim se ginekologijom, sa fokusom na dijagnostiku i lečenje steriliteta i vantelesnu oplodnju, u okviru tima SB Ferona u Novom Sadu.
Pasus 2: Deo mog rada odvija se i kroz projekat "Moj ginekolog" Doma zdravlja Novi Sad — verujem da informisanost i dostupnost idu zajedno.
Pasus 3: Sterilitet je za mnoge parove tema koja nosi tišinu, pa i stid. U razgovorima trudim se da to ne bude tako — informacije treba da budu jasne, a briga ljudska.

### [omeni.education]
H2: Obrazovanje i afilijacije
Stavke (`.steps`, bez datuma koji nisu potvrđeni):
- Master reproduktivne embriologije
- Član tima SB Ferona, Novi Sad
- Projekat "Moj ginekolog", Dom zdravlja Novi Sad
Napomena: Prema javno dostupnim izvorima, obrazovanje je povezano sa Medicinskim fakultetom u Novom Sadu — ova informacija je u postupku potvrde. [POTVRDITI SA KLIJENTOM: tačna ustanova i godina diplomiranja, radi bezbednog dodavanja u tekst i u `alumniOf` shemu]

### [omeni.approach]
Eyebrow: PRISTUP RADU
H2: Kako pristupam radu
Citat: "Nije garancija trudnoće, ali može sačuvati važnu šansu za budućnost."
Pasus 1: Infertilitet nije samo stres, i niko ne treba da nosi osećaj krivice zbog toga. Stres može uticati na hormone i ciklus, ali uzroci steriliteta su po pravilu složeniji i zaslužuju ozbiljnu medicinsku procenu.
Pasus 2: Ne pobeđuje onaj ko uradi najviše analiza — pobeđuje onaj ko uradi prave. Zato svaki plan počinje razgovorom, a ne šablonom.
Alt (brend-vizual-01.webp): dr Filip Katanić, portret

### [omeni.talks]
Eyebrow: KONFERENCIJE I PREDAVANJA
H2: Van ordinacije
Uvod: Predavanja i učešća na stručnim skupovima — Thrombosis Days (Švajcarska), ESHRE, GIGANODE (Švajcarska), Divčibare, Bio Save i SPRING Fertility — deo su kontinuiranog praćenja struke.
Link: Sve konferencije i mediji → {link: /mediji-i-predavanja/}
Alt mini-pair: dr Filip Katanić sa kolegama na ESHRE kongresu · dr Filip Katanić kao predavač na stručnom skupu u Divčibarama

### [omeni.cta]
`[global.cta]`

---

## 3. HUB „Oblasti rada" `/oblasti-rada/`

**Title:** Oblasti rada – ginekologija i IVF | dr Filip Katanić (52)
**Meta:** Pregled oblasti rada dr Filipa Katanića: IVF/ICSI, zamrzavanje jajnih ćelija, PCOS, muški faktor neplodnosti, redovni ginekološki pregledi. (147)
**H1:** Oblasti rada

### [oblasti.hero]
H1: Oblasti rada
Lead: Pregled oblasti u kojima dr Filip Katanić radi, u okviru tima SB Ferona.
Venue traka: `[global.venue]`

### [oblasti.grid]
5 kartica — tekst identičan `[oblast.<slug>.short]` iz `[home.areas]` (IVF/ICSI, Zamrzavanje jajnih ćelija, PCOS i neplodnost, Muški faktor neplodnosti, Redovni ginekološki pregledi)

### [oblasti.cta]
`[global.cta]`

---

## 4. `/oblasti-rada/vantelesna-oplodnja-ivf/`

**Title:** Vantelesna oplodnja (IVF/ICSI) – edukacija | dr Filip Katanić (58)
**Meta:** Šta je IVF/ICSI postupak, kako izgleda dijagnostika steriliteta i priprema. Edukativni sadržaj dr Filipa Katanića, bez obećanja ishoda. (140)
**H1:** Vantelesna oplodnja (IVF) i ICSI

### [oblast.ivf.hero]
Breadcrumb: Početna / Oblasti rada / IVF i ICSI
Badge: IVF / ICSI
H1: Vantelesna oplodnja (IVF) i ICSI
Lead: IVF i ICSI su postupci asistirane reprodukcije koji se razmatraju nakon dijagnostike steriliteta. Ovde je kratak, edukativan pregled — bez obećanja ishoda, jer svaki slučaj je drugačiji.
CTA: Zakažite u SB Feroni
Venue: `[global.venue]`
Alt teaser (edukacija-ivf-proces-02.webp): kartica iz edukativne serije o IVF postupku

### [oblast.ivf.what]
H2: Šta je IVF/ICSI
Pasus 1: IVF (in vitro fertilizacija) je postupak u kome se jajna ćelija i spermatozoid spajaju van tela, u laboratorijskim uslovima. ICSI je varijanta postupka u kojoj se jedan spermatozoid direktno ubrizgava u jajnu ćeliju — najčešće se koristi kada postoji muški faktor neplodnosti.
Pasus 2: Oba postupka su deo šireg plana koji uključuje dijagnostiku, stimulaciju jajnika, punkciju, oplodnju, razvoj embriona u laboratoriji i, ako je moguće, transfer.

### [oblast.ivf.dijagnostika]
H2: Dijagnostika steriliteta — prvi koraci
Pasus 1: Pre bilo kakvog postupka, prvi korak je razgovor i dijagnostika — hormonske analize, praćenje ciklusa, po potrebi spermogram partnera i uvid u prethodnu medicinsku dokumentaciju.
Pasus 2: Cilj dijagnostike nije da se što pre dođe do postupka, već da se razume šta zaista stoji iza steriliteta kod konkretnog para.

### [oblast.ivf.priprema]
H2: Priprema za prvu konsultaciju
Tekst: Konsultacija ide lakše kada donesete nalaze koje već imate. Pripremili smo kratak vodič: {link: /blog/prva-konsultacija-sta-poneti/}
Checklist mini (3 stavke): Hormonske analize, ako ih imate · Nalaz spermograma partnera, ako postoji · Prethodna medicinska dokumentacija i terapija

### [oblast.ivf.emocije]
H2: Emotivna strana puta
Pasus 1: Sterilitet je za mnoge parove izvor bola i, često, stida — iako ne bi trebalo da bude. Infertilitet nije samo stres, i niko ne treba da nosi osećaj krivice zbog toga.
Pasus 2: "Nije garancija trudnoće, ali može sačuvati važnu šansu za budućnost" — ova rečenica važi i za IVF: postupak povećava šansu u zavisnosti od individualnih faktora, ali nijedan medicinski postupak ne može garantovati ishod.

### [oblast.ivf.faq]
H2: Najčešća pitanja o IVF-u i ICSI-ju
(vidi `[faq.ivf.1]` i `[faq.ivf.2]`)

### [oblast.ivf.credential]
`[global.credential]` + link {link: /o-meni/} ; Venue puna: `[global.ferona]`

### [oblast.ivf.cta]
`[global.cta]`
Povezano: Muški faktor neplodnosti → {link: /oblasti-rada/muski-faktor-neplodnosti/} · Blog: Šta se zaista dešava tokom IVF postupka → {link: /blog/sta-se-zaista-desava-tokom-ivf-postupka/}

---

## 5. `/oblasti-rada/zamrzavanje-jajnih-celija/`

**Title:** Zamrzavanje jajnih ćelija (social freezing) | dr Filip Katanić (58)
**Meta:** Kada zamrzavanje jajnih ćelija ima smisla i šta postupak obuhvata. Edukativan pregled dr Filipa Katanića — bez garancija, sa realnim očekivanjima. (150)
**H1:** Zamrzavanje jajnih ćelija

### [oblast.freezing.hero]
Breadcrumb: Početna / Oblasti rada / Zamrzavanje jajnih ćelija
Badge: SOCIAL FREEZING
H1: Zamrzavanje jajnih ćelija
Lead: Zamrzavanje jajnih ćelija je opcija za one koji žele da sačuvaju plodnost za kasniji period života. Nije garancija trudnoće, ali može biti smislen korak — u zavisnosti od okolnosti.
CTA: Zakažite u SB Feroni
Venue: `[global.venue]`
Alt hero (edukacija-social-freezing-01.webp): infografika o zamrzavanju jajnih ćelija

### [oblast.freezing.what]
H2: Šta je zamrzavanje jajnih ćelija
Pasus: Postupak podrazumeva stimulaciju jajnika, punkciju i zamrzavanje (krioprezervaciju) jajnih ćelija radi kasnije upotrebe. Ćelije se čuvaju do trenutka kada osoba odluči da ih koristi, ako do toga dođe.

### [oblast.freezing.kada]
H2: Kada razmišljati o ovoj opciji
Pasus: Razlozi su različiti — od želje da se odloži roditeljstvo do medicinskih okolnosti koje mogu uticati na plodnost. Godine su jedan od faktora koji utiču na broj i kvalitet jajnih ćelija, pa je razgovor koji uzima u obzir Vašu trenutnu situaciju bolji od uopštenih preporuka.

### [oblast.freezing.proces]
H2: Šta postupak obuhvata
Koraci (`.steps`):
1. Konsultacija i dijagnostika: razgovor, hormonske analize, procena rezerve jajnika.
2. Stimulacija jajnika: kratkotrajna hormonska terapija radi podsticanja razvoja više jajnih ćelija.
3. Punkcija: postupak kojim se jajne ćelije uzimaju iz jajnika.
4. Zamrzavanje: jajne ćelije se zamrzavaju i čuvaju do eventualne kasnije upotrebe.
[POTVRDITI SA KLIJENTOM: tačan tok i trajanje postupka zamrzavanja jajnih ćelija u SB Feroni]

### [oblast.freezing.poruka]
Citat (navy blok, `.seal`): "Nije garancija trudnoće, ali može sačuvati važnu šansu za budućnost."

### [oblast.freezing.faq]
H2: Najčešća pitanja o zamrzavanju jajnih ćelija
(vidi `[faq.freezing.1]` i `[faq.freezing.2]`)

### [oblast.freezing.credential]
`[global.credential]` + link {link: /o-meni/} ; Venue puna: `[global.ferona]`

### [oblast.freezing.cta]
`[global.cta]`
Povezano: PCOS i neplodnost → {link: /oblasti-rada/pcos-i-neplodnost/}

---

## 6. `/oblasti-rada/pcos-i-neplodnost/`

**Title:** PCOS i neplodnost – dijagnostika i praćenje | dr Filip Katanić (58)
**Meta:** Šta je PCOS, kako se dijagnostikuje i kako se prati ovulacija. Edukativan sadržaj i najčešće zablude o PCOS-u. (114)
**H1:** PCOS i neplodnost

### [oblast.pcos.hero]
Breadcrumb: Početna / Oblasti rada / PCOS i neplodnost
Badge: PCOS
H1: PCOS i neplodnost
Lead: PCOS (sindrom policističnih jajnika) jedan je od čestih uzroka nepravilnog ciklusa i oteženog začeća. Dijagnostika i praćenje pomažu da se razume šta se zapravo dešava u organizmu.
CTA: Zakažite u SB Feroni
Venue: `[global.venue]`
Alt (edukacija-pcos-01.webp): infografika o PCOS-u

### [oblast.pcos.what]
H2: Šta je PCOS
Pasus: PCOS je hormonski poremećaj koji može uticati na ovulaciju, ciklus i, kod nekih žena, na plodnost. Simptomi i njihova izraženost razlikuju se od osobe do osobe, pa se i dijagnoza postavlja individualno.

### [oblast.pcos.dijagnostika]
H2: Dijagnostika i hormonske analize
Pasus: Dijagnostika obično obuhvata razgovor o ciklusu i simptomima, hormonske analize i, po potrebi, ultrazvučni pregled. Cilj je da se dobije jasna slika pre nego što se razgovara o daljim koracima.

### [oblast.pcos.ovulacija]
H2: Praćenje ovulacije
Pasus: Kod PCOS-a ovulacija često nije pravilna ili izostaje. Praćenje ciklusa i ovulacije pomaže da se proceni pravi trenutak za dalje korake, ako su potrebni.

### [oblast.pcos.zablude]
H2: Nekoliko zabluda o PCOS-u
Zabluda 1: "PCOS znači da ne mogu da zatrudnim." — Ne nužno. PCOS otežava, ali ne isključuje trudnoću kod svih žena; mnogo zavisi od individualne slike.
Zabluda 2: "Ako imam PCOS, kriva sam što nisam smršala." — Telesna težina može biti povezana sa simptomima, ali PCOS nije posledica ličnog propusta.
Napomena: Dodatne zablude i detaljnija objašnjenja pripremaju se za narednu fazu sadržaja (flag `BLOG_EXPANDED`).

### [oblast.pcos.faq]
H2: Najčešća pitanja o PCOS-u
(vidi `[faq.pcos.1]`)

### [oblast.pcos.credential]
`[global.credential]` + link {link: /o-meni/} ; Venue puna: `[global.ferona]`

### [oblast.pcos.cta]
`[global.cta]`
Povezano: IVF / ICSI → {link: /oblasti-rada/vantelesna-oplodnja-ivf/}

---

## 7. `/oblasti-rada/muski-faktor-neplodnosti/`

**Title:** Muški faktor neplodnosti – spermogram | dr Filip Katanić (56)
**Meta:** Tumačenje spermograma i uloga muškog faktora u dijagnostici steriliteta parova. Edukativan sadržaj dr Filipa Katanića. (117)
**H1:** Muški faktor neplodnosti

### [oblast.muski.hero]
Breadcrumb: Početna / Oblasti rada / Muški faktor neplodnosti
Badge: MUŠKI FAKTOR
H1: Muški faktor neplodnosti
Lead: Sterilitet nije samo "ženska tema" — u značajnom broju slučajeva na plodnost para utiče i muški faktor. Spermogram je osnovna analiza koja pomaže da se to proceni.
CTA: Zakažite u SB Feroni
Venue: `[global.venue]`
Alt (`.illo--spermogram`): linijska ilustracija epruvete i mikroskopa

### [oblast.muski.sta]
H2: Šta je spermogram i šta pokazuje
Pasus: Spermogram je laboratorijska analiza koja ocenjuje broj, pokretljivost i oblik spermatozoida, prema referentnim vrednostima Svetske zdravstvene organizacije (WHO, 6. izdanje). Nalaz je jedan deo slike, ne konačna presuda o plodnosti.

### [oblast.muski.kada]
H2: Kada se preporučuje analiza
Pasus: Spermogram se najčešće radi kada par duže vreme bezuspešno pokušava da začne dete, kao deo šire dijagnostike steriliteta oba partnera.

### [oblast.muski.sledeci]
H2: Sledeći korak nakon rezultata
Pasus: Ako nalaz odstupa od referentnih vrednosti, to ne znači automatski da trudnoća nije moguća — razgovor sa lekarom pomaže da se rezultat stavi u kontekst i da se, ako je potrebno, dogovori dalja dijagnostika ili plan lečenja.

### [oblast.muski.faq]
H2: Najčešća pitanja o muškom faktoru neplodnosti
(vidi `[faq.muski.1]`)

### [oblast.muski.credential]
`[global.credential]` + link {link: /o-meni/} ; Venue puna: `[global.ferona]`

### [oblast.muski.cta]
`[global.cta]`
Povezano: IVF / ICSI → {link: /oblasti-rada/vantelesna-oplodnja-ivf/}

---

## 8. `/oblasti-rada/redovni-ginekoloski-pregledi/`

**Title:** Redovni ginekološki pregledi i PAPA test | dr Filip Katanić (58)
**Meta:** Zašto su redovni ginekološki pregledi i PAPA test važni za rano otkrivanje promena. Edukativan pregled dr Filipa Katanića. (122)
**H1:** Redovni ginekološki pregledi i PAPA test

### [oblast.pregledi.hero]
Breadcrumb: Početna / Oblasti rada / Redovni ginekološki pregledi
Badge: REDOVNI PREGLEDI
H1: Redovni ginekološki pregledi i PAPA test
Lead: Redovan ginekološki pregled nije nešto što treba odlagati "dok nešto ne zaboli". Rano otkrivanje promena često pravi razliku.
CTA: Zakažite u SB Feroni
Venue: `[global.venue]`
Alt (`.illo--pregled`): linijska ilustracija kalendara sa zlatnom kvačicom

### [oblast.pregledi.zasto]
H2: Zašto su redovni pregledi važni
Pasus 1: Redovan pregled omogućava da se promene uoče rano, dok su mogućnosti za reakciju najveće. To ne znači da je svaki uredan nalaz konačna garancija — u intervjuu za Mondo.rs dr Filip Katanić je govorio o slučaju u kome je, uprkos urednom PAPA testu, kasnije otkriven karcinom grlića materice u uznapredovalom stadijumu. [POTVRDITI SA KLIJENTOM: pisana dozvola da se ovaj slučaj referiše na sajtu, uz link ka izvornom članku]
Pasus 2: Poruka iz tog razgovora nije da su pregledi beskorisni, već da nijedna analiza sama po sebi nije apsolutna — zato je važno da pregled bude kontinuiran, ne jednokratan.
Link ka izvoru: Pročitajte intervju na Mondo.rs → (spoljni link, rel="noopener")

### [oblast.pregledi.papa]
H2: Šta je PAPA test i skrining grlića materice
Pasus: PAPA test je citološki pregled kojim se prati zdravlje grlića materice i rano uočavaju ćelijske promene. Deo je standardnog skrininga koji se preporučuje ženama u reproduktivnom periodu.

### [oblast.pregledi.ucestalost]
H2: Koliko često na pregled
Pasus: Opšta preporuka je redovan godišnji ginekološki pregled, uz PAPA test prema smernicama koje lekar predlaže na osnovu Vaše anamneze. Ovo su opšte preporuke — konkretan raspored za Vas dogovara se na pregledu. [POTVRDITI SA KLIJENTOM: da li postoji specifičan protokol učestalosti koji se primenjuje u SB Feroni]

### [oblast.pregledi.faq]
H2: Najčešća pitanja o redovnim pregledima
(vidi `[faq.pregledi.1]`)

### [oblast.pregledi.credential]
`[global.credential]` + link {link: /o-meni/}

### [oblast.pregledi.cta]
`[global.cta]`

---

## 9. `/pitanja-i-odgovori/` (FAQ hub)

**Title:** Pitanja i odgovori – IVF, PCOS, plodnost | dr Filip Katanić (58)
**Meta:** Odgovori na najčešća pitanja o IVF-u, PCOS-u, zamrzavanju jajnih ćelija i muškom faktoru neplodnosti — jasno i bez obećanja. (128)
**H1:** Pitanja i odgovori

### [faq.hero]
H1: Pitanja i odgovori
Lead: Pitanja koja najčešće čujemo, sa iskrenim odgovorima — bez obećanja ishoda.
Alt (edukacija-simptomi-01.webp): infografika "Da li je ovo normalno?"

**Grupa: IVF / ICSI**

### [faq.ivf.1]
P: Da li vantelesna oplodnja garantuje trudnoću?
O: Ne. IVF postupak povećava šansu u zavisnosti od individualnih faktora, ali nijedan medicinski postupak ne može garantovati ishod. Svaki slučaj se procenjuje individualno.

### [faq.ivf.2]
P: Koja je razlika između IVF-a i ICSI-ja?
O: Kod IVF-a se jajna ćelija i spermatozoidi spajaju u laboratorijskim uslovima i oplodnja se dešava prirodnim putem, van tela. Kod ICSI-ja se jedan spermatozoid direktno ubrizgava u jajnu ćeliju, i najčešće se bira kada postoji muški faktor neplodnosti.

### [faq.ivf.3]
P: Koliko traje IVF postupak?
O: Jedan ciklus, od početka stimulacije do transfera, okvirno traje nekoliko nedelja. Tačan tok i trajanje zavise od individualnog plana i procenjuju se na konsultaciji.

### [faq.ivf.4]
P: Šta ako IVF ne uspe iz prvog pokušaja?
O: Nije redak slučaj da prvi pokušaj ne dovede do trudnoće, i to ne znači da naredni koraci nisu mogući. Nakon svakog postupka analizira se tok, a plan se po potrebi prilagođava. Šta je realno očekivati u Vašoj situaciji, razgovara se pojedinačno, na konsultaciji.

**Grupa: Zamrzavanje jajnih ćelija**

### [faq.freezing.1]
P: Šta je zamrzavanje jajnih ćelija i kada ima smisla?
O: To je postupak kojim se jajne ćelije čuvaju za kasniju upotrebu. Ima smisla razmotriti ga kada želite da sačuvate opciju za kasnije, iz ličnih ili medicinskih razloga — ali odluka zavisi od Vaše situacije i najbolje je doneti je nakon razgovora. Nije garancija trudnoće, ali može sačuvati važnu šansu za budućnost.

### [faq.freezing.2]
P: Koliko košta zamrzavanje jajnih ćelija?
O: Cenu ne objavljujemo na sajtu jer zavisi od individualnog plana. Za konkretne informacije obratite se kontakt centru SB Ferona.

**Grupa: PCOS**

### [faq.pcos.1]
P: Šta je PCOS i kako se dijagnostikuje?
O: PCOS je hormonski poremećaj koji može uticati na ciklus, ovulaciju i plodnost. Dijagnostika obično obuhvata razgovor o simptomima, hormonske analize i, po potrebi, ultrazvučni pregled.

**Grupa: Muški faktor**

### [faq.muski.1]
P: Šta je muški faktor neplodnosti i kako se čita spermogram?
O: Muški faktor podrazumeva da uzrok oteženog začeća delimično ili u potpunosti leži na strani muškarca. Spermogram, analiziran prema referentnim vrednostima Svetske zdravstvene organizacije, jedna je od osnovnih analiza kojima se to procenjuje.

**Grupa: Redovni pregledi**

### [faq.pregledi.1]
P: Koliko često treba ići na ginekološki pregled?
O: Opšta preporuka je redovan godišnji pregled, uz PAPA test prema smernicama koje lekar predlaže na osnovu Vaše anamneze. Konkretan raspored za Vas dogovara se na pregledu.

**Grupa: Opšte**

### [faq.opste.1]
P: Šta poneti na prvu konsultaciju?
O: Ako ih imate, ponesite hormonske analize, nalaz spermograma partnera, prethodnu medicinsku dokumentaciju i podatke o terapiji koju trenutno koristite. Dobro je da unapred zapišete i pitanja koja Vas zanimaju. Detaljan vodič: {link: /blog/prva-konsultacija-sta-poneti/}

### [faq.opste.2]
P: Kada da se javim ginekologu ako ne mogu da ostanem u drugom stanju?
O: Prema opšte prihvaćenim smernicama, ženama mlađim od 35 godina se obično savetuje da se jave nakon 12 meseci bezuspešnih pokušaja, a ženama starijim od 35 nakon 6 meseci. Ovo su opšte smernice, ne pravilo bez izuzetaka — ako imate bilo kakvu nedoumicu, razumno je zakazati razgovor i ranije. [POTVRDITI SA KLIJENTOM: da li se ova smernica koristi u praksi SB Ferona ili je treba formulisati drugačije]

### [faq.opste.3]
P: Da li stres utiče na plodnost?
O: Stres može uticati na hormone, ciklus i organizam, ali infertilitet nije "samo stres". Ako se suočavate sa neplodnošću, to nije znak da niste bili dovoljno opušteni — uzroci su po pravilu složeniji i zaslužuju medicinsku procenu, ne krivicu.

### [faq.cta]
`[global.cta]`

---

## 10. BLOG

**Title (hub):** Blog – edukacija o IVF-u i ginekologiji | dr Filip Katanić (56)
**Meta (hub):** Edukativni tekstovi dr Filipa Katanića o IVF-u, PCOS-u, zamrzavanju jajnih ćelija i muškom faktoru neplodnosti. (112)
**H1 (hub):** Blog

### [blog.hero]
H1: Blog
Lead: Edukativni tekstovi o tome kako IVF postupak zaista izgleda — bez ulepšavanja, korak po korak.
3 kartice: Koliko ćelija je potrebno za embrion · Šta se zaista dešava tokom IVF postupka · Prva konsultacija — šta poneti

### 10.1 `/blog/koliko-jajnih-celija-je-potrebno-za-embrion/`

**Title:** Koliko ćelija je potrebno za embrion? | dr Katanić (51)
**Meta:** Zašto broj jajnih ćelija prirodno opada kroz faze IVF postupka do blastociste — edukativno objašnjenje dr Filipa Katanića, bez obećanja ishoda. (148)
**H1:** Koliko jajnih ćelija je potrebno za embrion?

### [blog.embrioni.intro]
Pasus: Jedno od pitanja koje parovi najčešće postavljaju na početku IVF postupka jeste: "Koliko jajnih ćelija je dovoljno?" Odgovor nije jednostavan broj — put od punkcije do embriona spremnog za transfer prirodno se smanjuje kroz nekoliko faza, i to je uobičajeno, ne razlog za brigu.
Alt (edukacija-embrioni-01.webp, 1/5): naslovna kartica edukativne serije o razvoju embriona

### [blog.embrioni.godine]
H2: Zašto godine menjaju šansu
Pasus: Broj i kvalitet jajnih ćelija prirodno opadaju sa godinama, pa se i broj ćelija koje uspešno prođu kroz sve faze — od punkcije do zrele jajne ćelije, oplodnje i razvoja do blastociste — razlikuje od osobe do osobe. Ovo je biološki proces, ne pokazatelj greške u postupku.
Alt (edukacija-embrioni-02.webp, 2/5): ilustracija smanjenja broja ćelija kroz faze IVF postupka

### [blog.embrioni.tabela]
H2: Zašto se broj ćelija smanjuje kroz faze
Pasus: Nisu sve punktirane ćelije zrele. Od zrelih ćelija, nisu sve uspešno oplođene. Od oplođenih, nisu sve embrioni koji stignu do faze blastociste, koja se smatra povoljnijom za transfer. Svaki od ovih koraka je selekcija — prirodna, ne proizvoljna.
Napomena: Konkretni brojevi razlikuju se od para do para i zavise od mnogo faktora; ne postoji univerzalan "dovoljan broj" za sve. [POTVRDITI SA KLIJENTOM: da li klijent želi da doda orijentacione opsege brojeva na osnovu sopstvenog iskustva — do potvrde, tekst ostaje opisni, bez konkretnih brojeva]
Alt (edukacija-embrioni-03.webp, 3/5): ilustracija faza od punkcije do blastociste

### [blog.embrioni.praksa]
H2: Šta ovo znači u praksi
Pasus: U praksi to znači da je manji broj ćelija u kasnijoj fazi (na primer, na nivou blastociste) normalan deo procesa, a ne signal da nešto nije u redu. Zato se tokom postupka prati razvoj u svakoj fazi, a ne samo početni broj.
Alt (edukacija-embrioni-04.webp, 4/5): ilustracija praćenja razvoja embriona u laboratoriji

### [blog.embrioni.zakljucak]
H2: Važna poruka za kraj
Citat: "Ne pobeđuje onaj ko uradi najviše analiza. Pobeđuje onaj ko uradi prave."
Pasus: Veći broj punktiranih ćelija ne znači automatski veću šansu — kvalitet i praćenje procesa igraju veću ulogu od same količine. Razgovor o Vašoj konkretnoj situaciji uvek je bolji vodič od opštih brojeva.
Alt (edukacija-embrioni-05.webp, 5/5): zaključna kartica edukativne serije, citat

### 10.2 `/blog/sta-se-zaista-desava-tokom-ivf-postupka/`

**Title:** Šta se zaista dešava tokom IVF postupka? | dr Katanić (54)
**Meta:** Edukativan pregled faza IVF postupka — od selekcije embriona do transfera — bez obećanja ishoda i uz uslovan, realan ton. (121)
**H1:** Šta se zaista dešava tokom IVF postupka?

### [blog.ivfproces.intro]
H2: Biologija i selekcija embriona
Pasus: IVF postupak nije jedan događaj, već niz koraka u kojima se, na svakom nivou, prirodno "filtrira" broj ćelija i embriona. To je biološki proces koji se dešava i u prirodnom začeću, samo je ovde vidljiviji jer se prati u laboratoriji.
Alt (edukacija-ivf-proces-01.webp, 1/5): naslovna kartica serije o IVF postupku

### [blog.ivfproces.individualni]
H2: Individualni pristup
Pasus: Plan stimulacije, broj kontrola i odluke tokom postupka prilagođavaju se svakoj osobi posebno — istoj dozi ili istom protokolu ne reaguju svi organizmi jednako. Zato se tok postupka prati i po potrebi menja u hodu.
Alt (edukacija-ivf-proces-02.webp, 2/5): ilustracija individualnog praćenja stimulacije

### [blog.ivfproces.kvalitet]
H2: Kvalitet nad kvantitetom
Pasus: Veći broj jajnih ćelija ili embriona ne znači automatski bolji ishod. Embriolozi prate kvalitet — izgled, tempo deobe, razvoj do blastociste — jer se pokazalo da je to relevantnije od same količine.
Alt (edukacija-ivf-proces-03.webp, 3/5): ilustracija procene kvaliteta embriona

### [blog.ivfproces.odluke]
H2: Niz odluka, ne jedan pokušaj
Pasus: IVF nije "sve ili ništa" u jednom trenutku — to je niz odluka: kada stimulisati, kada punktirati, koji embrion transferisati, kada sačekati sledeći ciklus. Svaka odluka se donosi na osnovu onoga što se vidi u tom trenutku, ne unapred zacrtanog scenarija.
Alt (edukacija-ivf-proces-04.webp, 4/5): ilustracija koraka odlučivanja tokom postupka

### [blog.ivfproces.transfer]
H2: Transfer i priprema pre njega
Pasus: Transfer embriona je poslednji vidljiv korak, ali je pripremljen svim prethodnim fazama — kvalitetom embriona, stanjem endometrijuma i vremenskim planom. Sam čin transfera je kratak; ono što mu prethodi je ono što najviše određuje dalji tok.
Napomena: Ishod transfera ne može se garantovati — svaki slučaj je individualan.
Alt (edukacija-ivf-proces-05.webp, 5/5): zaključna kartica serije o IVF postupku, transfer

### 10.3 `/blog/prva-konsultacija-sta-poneti/`

**Title:** Prva konsultacija za IVF – šta poneti | dr Filip Katanić (56)
**Meta:** Šta poneti na prvu konsultaciju za IVF ili dijagnostiku steriliteta — praktičan checklist dr Filipa Katanića. (110)
**H1:** Prva konsultacija — šta poneti

### [blog.konsultacija.intro]
Pasus: Prva konsultacija je razgovor, ne ispit. Ipak, ako ponesete postojeću medicinsku dokumentaciju, razgovor je konkretniji i brži. Evo kratkog vodiča šta je korisno poneti.

### [blog.konsultacija.checklist]
H2: Checklist za prvu konsultaciju
(`.checklist`, oval pill-red)
- Hormonske analize, ako ih imate
- Nalaz spermograma partnera, ako postoji
- Prethodna medicinska dokumentacija (nalazi, ultrazvuk, prethodni postupci)
- Podaci o terapiji koju trenutno koristite
- Pitanja koja želite da postavite — zapisana unapred, da ništa ne zaboravite

### [blog.konsultacija.tok]
H2: Šta se dešava na samoj konsultaciji
Koraci (`.steps`):
1. Razgovor: o Vašoj situaciji, ciklusu, prethodnim pokušajima i eventualnoj dokumentaciji.
2. Pregled i, po potrebi, dodatna dijagnostika.
3. Objašnjenje mogućih narednih koraka — uslovno, u zavisnosti od nalaza.
4. Prostor za pitanja — konsultacija je i prilika da postavite sve što Vas brine.
[POTVRDITI SA KLIJENTOM: tačan tok konsultacije u SB Feroni — ovo je uobičajen opšti tok]

### [blog.konsultacija.zakljucak]
Citat: "Ne možemo kontrolisati baš sve, ali možemo napraviti najbolji plan."
Pasus: Dolazak na prvu konsultaciju često je najteži korak — i to je razumljivo. Cilj razgovora je da dobijete jasne informacije, ne pritisak.
CTA: Zakažite u SB Feroni

---

## 11. `/mediji-i-predavanja/`

**Title:** Mediji i predavanja – dr Filip Katanić (39)
**Meta:** Medijski nastupi i stručna predavanja dr Filipa Katanića: Mondo.rs, Selfnest, Thrombosis Days, ESHRE, GIGANODE. (109)
**H1:** Mediji i predavanja

### [mediji.hero]
H1: Mediji i predavanja
Lead: Pregled medijskih nastupa i stručnih skupova na kojima je dr Filip Katanić učestvovao.
Alt (portret-01.webp): dr Filip Katanić, portret

### [mediji.nastupi.1]
Naslov: Mondo.rs
Tekst: Intervju o slučaju u kome je, uprkos urednom PAPA testu, kasnije otkriven karcinom grlića materice u uznapredovalom stadijumu — povod za razgovor o granicama skrininga i važnosti redovnih pregleda.
Link: Pročitajte na Mondo.rs → (spoljni link, rel="noopener")

### [mediji.nastupi.2]
Naslov: Popodne sa Tanjom
Tekst: Gostovanje u lokalnoj TV emisiji, na temu zajedničke onlajn platforme za pitanja i odgovore o neplodnosti.
Link: Pogledajte na YouTube-u → (spoljni link, rel="noopener")

### [mediji.nastupi.3]
Naslov: Selfnest
Tekst: Gostovanje na edukativnoj platformi Selfnest, o toku vantelesne oplodnje i psihološkom pritisku koji ovaj proces nosi za parove.
Link: Pogledajte epizodu → (spoljni link, rel="noopener")

### [mediji.konferencije]
H2: Stručne konferencije
Uvod: Predavanja i učešća na domaćim i međunarodnim stručnim skupovima.
- Thrombosis Days, Švajcarska — predavanje o IVF perspektivi.
- ESHRE (European Society of Human Reproduction and Embryology) — stručni kongres.
- GIGANODE International Panel, Švajcarska — panel o neplodnosti i indikacijama za asistiranu reprodukciju.
- Stručni skup, Divčibare — predavanje o perioperativnom krvarenju, iz akušerske perspektive.
- Bio Save — serija predavanja u okviru edukativnog programa za buduće mame.
- SPRING Fertility — stručna konferencija. [POTVRDITI SA KLIJENTOM: tačan status i datum učešća]
Alt galerija: dr Filip Katanić sa kolegama na ESHRE kongresu (konferencija-01.webp; treća lica se ne imenuju) · dr Filip Katanić kao predavač na stručnom skupu u Divčibarama (konferencija-02.webp, kropovano po pravilu 0.2) · dr Filip Katanić na predavanju u okviru Bio Save programa ×2 (konferencija-03.webp, konferencija-04.webp)

### [mediji.cta]
`[global.cta]`

---

## 12. `/kontakt/`

**Title:** Kontakt i zakazivanje – dr Filip Katanić, SB Ferona (52)
**Meta:** Zakazivanje pregleda kod dr Filipa Katanića u SB Ferona, Šarplaninska 19, Novi Sad. Telefon +381 21 3000 220, office@ferona.rs. (126)
**H1:** Kontakt i zakazivanje

### [kontakt.hero]
H1: Kontakt i zakazivanje
Pločica 1 (primarna): Zakažite u SB Feroni (`tel:+381213000220`)
Pločica 2: Poruka na Instagramu — za pitanje pre zakazivanja, ne formalni kanal zakazivanja (`https://instagram.com/drfilipkatanic`)

### [kontakt.napomena]
Tekst: Kontakt centar SB Ferona — za zakazivanje pregleda kod dr Filipa Katanića. Telefon i email pripadaju ustanovi.

### [kontakt.ferona]
`[global.ferona]`
`.venue-card`: SB FERONA · Šarplaninska 19 · Novi Sad
Link: Otvori u Google mapama → (spoljni link)

### [kontakt.mapa]
Google Maps iframe (facade "Učitaj mapu", `loading="lazy"`), `title`="Mapa: SB Ferona, Šarplaninska 19, Novi Sad"

### [kontakt.radno_vreme]
(hidden, flag `RADNO_VREME=False`)
[POTVRDITI SA KLIJENTOM: radno vreme SB Ferona i/ili termini kod dr Filipa Katanića — nije javno potvrđeno ni na jednom izvoru]

### [kontakt.email]
Napomena: Za pitanja možete pisati i na office@ferona.rs (email ustanove).

---

## 13. `/politika-privatnosti/`

**Title:** Politika privatnosti | dr Filip Katanić (39)
**Meta:** Kako se štite podaci posetilaca sajta i pacijenata. Testimonijali se objavljuju isključivo uz saglasnost pacijentkinje. (120)
**H1:** Politika privatnosti

### [privatnost.intro]
Pasus: Ova stranica objašnjava kako se sajt dr Filipa Katanića odnosi prema podacima posetilaca i pacijenata.

### [privatnost.kolacici]
H2: Kolačići i analitika
Pasus: Sajt može koristiti osnovnu analitiku posete radi razumevanja kako se sadržaj koristi. Ne prikupljamo medicinske podatke putem sajta. [POTVRDITI SA KLIJENTOM: tačan alat za analitiku, ako se koristi]

### [privatnost.kontakt]
H2: Kontakt i poruke
Pasus: Poruke poslate putem Instagrama ili telefonskog poziva ka kontakt centru SB Ferona obrađuju se u skladu sa praksom te ustanove. Ovaj sajt trenutno ne sadrži kontakt formular sa ličnim/medicinskim podacima. [POTVRDITI SA KLIJENTOM: da li se kontakt formular dodaje u narednoj fazi]

### [privatnost.testimonijali]
H2: Testimonijali i iskustva pacijentkinja
Pasus: Testimonijali i iskustva pacijentkinja objavljuju se isključivo uz pisanu saglasnost, sa napomenom "Objavljeno uz saglasnost pacijentkinje", u skladu sa praksom koju autor već primenjuje na svojim društvenim mrežama. Sajt trenutno ne sadrži testimonijale.

### [privatnost.cuvanje]
H2: Čuvanje podataka
Pasus: Ovaj sajt je informativnog karaktera i ne predstavlja elektronski karton pacijenta. Za pitanja o čuvanju medicinskih podataka obratite se direktno SB Feroni.

---

## 14. 404

`[global.404]`

---

## Alt tekstovi — zbirni pregled

- `hero.webp` (kropovano, samo gornjih ~55%): dr Filip Katanić, doktor medicine, portret
- `portret-01.webp` (čista slika, koristi se na `/o-meni/` hero i `/mediji-i-predavanja/`): dr Filip Katanić, portret
- `brend-vizual-01.webp` (koristi se samo jednom po stranici — `/` home.about i `/o-meni/` pristup radu): dr Filip Katanić, portret
- `edukacija-social-freezing-01.webp`: infografika o zamrzavanju jajnih ćelija
- `edukacija-pcos-01.webp`: infografika o PCOS-u
- `edukacija-simptomi-01.webp`: infografika "Da li je ovo normalno?"
- `edukacija-embrioni-01.webp` do `05.webp` (1/5–5/5, u tačnom redosledu): naslovna kartica / ilustracija smanjenja broja ćelija kroz faze / ilustracija faza od punkcije do blastociste / ilustracija praćenja razvoja embriona u laboratoriji / zaključna kartica, citat
- `edukacija-ivf-proces-01.webp` do `05.webp` (1/5–5/5, u tačnom redosledu): naslovna kartica serije o IVF postupku / ilustracija individualnog praćenja stimulacije / ilustracija procene kvaliteta embriona / ilustracija koraka odlučivanja tokom postupka / zaključna kartica, transfer
- `konferencija-01.webp`: dr Filip Katanić sa kolegama na ESHRE kongresu (treća lica se ne imenuju)
- `konferencija-02.webp` (kropovano po pravilu 0.2, bez čitljivog teksta na slajdu): dr Filip Katanić kao predavač na stručnom skupu u Divčibarama
- `konferencija-03.webp`, `konferencija-04.webp`: dr Filip Katanić na predavanju u okviru Bio Save programa
- `.illo--spermogram`: linijska ilustracija epruvete i mikroskopa (dekorativno, `alt=""`, tekst pored)
- `.illo--pregled`: linijska ilustracija kalendara sa zlatnom kvačicom (dekorativno, `alt=""`, tekst pored)
- `.venue-card` skica: dekorativna, `alt=""` (tekst NAP je u pratećem sadržaju, ne u slici)
- Mapa na `/kontakt/`: Mapa: SB Ferona, Šarplaninska 19, Novi Sad
- FK pečat (header/footer/dekor): dekorativno, `alt=""`, `aria-hidden`

---

## POTVRDITI SA KLIJENTOM — zbirni spisak

1. **Titula** — da li je dr Katanić zvanično položio specijalistički ispit ("specijalista") ili je trenutno specijalizant/doktorand. Dok se pismeno ne potvrdi, na celom sajtu se koristi samo "dr Filip Katanić" / "doktor medicine" / opis oblasti rada — bez izuzetka (seo.md 0.1, structure.md 0.2).
2. **Status zaposlenja u SB Feroni** (zaposlen / spoljni saradnik) — do potvrde koristi se isključivo "član tima SB Ferona".
3. **Radno vreme** SB Ferona i/ili termina kod dr Katanića — `[kontakt.radno_vreme]`, sekcija ostaje skrivena.
4. **Obrazovanje** — tačna ustanova (verovatno Medicinski fakultet Novi Sad) i godina diplomiranja — `[omeni.education]`.
5. **Dozvola za referisanje Mondo.rs slučaja** (propušten karcinom uprkos urednom PAPA testu) na sajtu — `[oblast.pregledi.zasto]`.
6. **Tačan tok i trajanje postupka zamrzavanja jajnih ćelija** u SB Feroni — `[oblast.freezing.proces]`.
7. **Da li se smernica "12/6 meseci pokušaja"** koristi u praksi SB Ferona ili treba drugačiju formulaciju — `[faq.opste.2]`.
8. **Tačan tok prve konsultacije** u SB Feroni — `[blog.konsultacija.tok]`.
9. **Protokol učestalosti redovnih pregleda** u SB Feroni, ako postoji poseban — `[oblast.pregledi.ucestalost]`.
10. **Status i datum učešća na SPRING Fertility konferenciji** — `[mediji.konferencije]`.
11. **Alat za analitiku** na sajtu, ako se koristi — `[privatnost.kolacici]`.
12. **Kontakt formular** — da li se dodaje u narednoj fazi ili sve ostaje preko kontakt centra SB Ferona — `[privatnost.kontakt]`.
13. **Orijentacioni opsezi brojeva ćelija/embriona** za `[blog.embrioni.tabela]` — opciono; do potvrde tekst ostaje opisni, bez konkretnih brojeva.
14. **Čist portret bez utisnutog teksta** i/ili alternativni kadar sa Divčibara bez čitljivog slajda — podsetnik iz structure.md 0.2/9, relevantan za `hero.webp` i `konferencija-02.webp`.
15. **Cenovnik** — potvrđeno da se ne objavljuje nigde (preporuka: da ostane tako).
16. **Google recenzije** — ne prikazuju se na sajtu (izvori se ne slažu, nije potrebna dalja akcija u copy-ju).
