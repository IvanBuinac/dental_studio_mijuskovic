# Napomene — Asset Collector (dr Filip Katanić / @drfilipkatanic)

## Preskočeno — NE koristiti bez saglasnosti

1. **`629474218_17854269492656310_7943828583015098938_n.jpg`** — crno-bela fotografija bebe (stopalo) sa bolničkom identifikacionom trakom, deo edukativne kartice "Šta radimo kada ovulacije nema?". Ovo je fotografija novorođenčeta/pacijenta (ili deteta pacijentkinje) — na samoj slici/kartici **nema vidljive napomene "Objavljeno uz saglasnost pacijentkinje"**. Prema pravilu: ne koristiti dok se saglasnost ne potvrdi. **Status: čeka saglasnost.** Nije optimizovana niti kopirana u `site/assets/img/`.

2. **`671176208_17866482735656310_5566449748335552910_n.jpg`** — kolaž "JA SAM I..." (supruga, dete/toddler, dr Katanić sa gitarom). Ovo je **lična porodica doktora** (supruga i dete), ne pacijent, ali pravilo o oprezu i dalje važi: lica deteta i supruge ne treba javno koristiti na sajtu bez izričite saglasnosti klijenta za svaku osobu posebno. **Status: pitanje za klijenta** — pre bilo kakve javne upotrebe pisano potvrditi (a) da li klijent želi ovaj sadržaj na sajtu, i (b) da li supruga i/ili predstavnik deteta daju saglasnost. Nije optimizovana niti kopirana u `site/assets/img/`.

Oba originalna fajla ostaju netaknuta u `Assets/Raw/` — nisu obrisana, samo isključena iz javnog seta slika.

## Poznata lica trećih strana (informativno, ne blokira upotrebu)

- **`652554894` (ESHRE grupna fotografija)** — na slici su i tri nepoznate/neidentifikovane kolege (verovatno lekari/koleginica sa kongresa). Nisu javne ličnosti niti su prepoznatljivi kao brend treće strane; profesionalni kongresni kontekst. Preporuka: ako klijent može da potvrdi imena i saglasnost kolega, dodati u alt tekst; u suprotnom koristiti kao "grupna fotografija sa ESHRE kongresa" bez imenovanja trećih lica.
- **`706744858` i `718138967` (Bio Save predavanja)** — u prvom planu se vidi publika iz leđa (glave/kosa), lica nisu prepoznatljiva/okrenuta ka kameri — nema problema sa privatnošću.

## Nedostaci u dostupnom materijalu (za parent agenta / klijenta)

1. **Nema nijedne "čiste" slike ordinacije, operacione sale ili laboratorije bez prisustva teksta/grafike.** Shortlist stavke #6–#9 (ordinacija za radnim stolom, ultrazvučni aparat, operaciona sala/lab sa monitorom, krupni plan sa hirurškom maskom) **nisu sačuvane** među 23 preuzeta fajla — verovatno nisu ručno skinute od strane korisnika ili originalne objave više nisu dostupne. **Ovo je značajan nedostatak** za sekcije sajta koje bi trebalo da prikažu prostor/opremu SB "Ferona" bez pacijenata. Preporuka: ili ponovo pokušati preuzimanje tih konkretnih objava, ili tražiti od klijenta/bolnice @bolnica.ferona dodatne "čiste" fotografije prostora (highlight "Iz ordinacije" pominje se u research.md kao mogući izvor, uz odobrenje).
2. **Nema posebne "medijske" fotografije** (npr. iz intervjua za Mondo.rs ili najave Selfnest epizode, shortlist #21–22) — te objave nisu među sačuvanim fajlovima. Za "Mediji o nama" sekciju trenutno nema dedikovane slike; može se privremeno koristiti `portret-01.webp` (konferencijski portret) uz tekstualni link ka članku/epizodi.
3. **Samo jedan potpuno "čist" portret bez teksta/grafike** (`654319078` — konferencijski, plavo osvetljenje, odelo, ne beli mantil). Sve ostale portretne fotografije dr Katanića iz ovog seta dolaze sa baziranim tekstom/citatom/uokvirenjem (brend karuseli). Preporuka: zatražiti od klijenta 1-2 studijska/klinička portreta bez teksta (beli mantil, neutralna pozadina) — idealno za "O meni" i vizit-kartu na sajtu, jer trenutni `hero.webp` ima citat urezan u sliku ("Ne možemo kontrolisati baš sve...") što ograničava fleksibilnost dizajna.
4. Tačan URL izvorne IG objave nije mogao da se sa sigurnošću potvrdi za svih 21 iskorišćenih slika samo na osnovu naziva fajla (IG media ID) — u manifestu je za svaku sliku navedena najbolja moguća pretpostavka na osnovu poređenja sadržaja sa `image-shortlist.md`. Preporuka: pre finalne objave na sajtu, poželjno je da klijent/korisnik potvrdi originalne linkove radi internog arhiviranja.

## Podsetnik pre objave na sajtu

- **Sve slike u ovom setu su javne IG objave dr Filipa Katanića**, prikupljene isključivo za potrebe izrade demo/ponude. Pre finalnog objavljivanja na sajtu **obavezno tražiti od klijenta**:
  1. Potvrdu da sme da koristi identičan vizuelni materijal sa svog IG naloga na sajtu (autorska prava/vlasništvo nad fotografijama, posebno konferencijske fotografije gde je moguće da je fotograf treća strana/organizator događaja).
  2. Originale u većoj rezoluciji ako su dostupni (trenutne slike su preuzete sa IG-a pa je rezolucija ograničena kompresijom platforme).
  3. Pisanu saglasnost za dve isključene slike (baby foto i porodični kolaž) ukoliko klijent želi da ih ipak koristi.
  4. Potvrdu tačnog statusa zaposlenja u SB "Ferona" i afilijacija pre nego što se konferencijske/institucionalne slike vežu za konkretne tvrdnje o zaposlenju (pomenuto već u research.md kao otvoreno pitanje).

## v2 — obrada novih fotografija (2026-10-12)

Izvorni fajlovi u `Assets/Raw/` nisu menjani; svi izlazi su u `src/static/assets/img/` (postojeće slike nisu brisane niti prepisane).

### Retuš
- **IMG_4642.jpg i IMG_4641.JPG — uklonjen plavi natpis "Ferona"** (izvezen na tamnoj majici, levo ispod kragne, kod ivice mantila) i sitni roze/crveni delovi znaka uz ivicu mantila. Postupak: maska po boji (plavi/roze pikseli samo u tamnom području majice; beli mantil isključen iz maske), dilatacija, OpenCV inpaint (Telea) uz privremenu neutralizaciju belog mantila da se ispuna uzima samo iz tamne tkanine, pa fini šum za teksturu tkanine. Kropovanje nije bilo opcija jer je natpis na sredini grudi. Rezultat: natpis se ne vidi u izlaznim dimenzijama; ivica mantila na mestu slova "e" ima minimalnu, neprimetnu neravninu. Važi za `hero-portret-mobile.webp`, `portret-mantil.webp`, `portret-mantil-2.webp`.
- Bežični mikrofon (lavalier) na majici IMG_4641/4642 i bedž/lanyard na IMG_1740 ("Bebologijini krugovi") **nisu** uklanjani — neutralni su (i na referentnom dizajnu se vidi mikrofon). Po želji klijenta mikrofon može da se retušira naknadno.
- **IMG_1626.jpg** — uklonjena siva isprekidana crtica (artefakt iz izvora, levo ~y 155). Slika je mala (814×690) — nije uvećavana; za veće ekrane hero treba da se prikazuje maks. ~814 px širine ili da se od klijenta traži original veće rezolucije.
- Sve fotografije: blago toplije ujednačenje (R +~1.8 %, B −~3.5 %, jače u svetlim tonovima → zidovi/mantil ka krem), bez filtera, Lanczos + blagi unsharp.
- **IMG_4647** ima jarko žut pult u donjem delu kadra; u `o-meni.webp` (4:5) ostaje uzan pojas žutog, `o-meni-kvadrat.webp` je kropovan iznad pulta — za krem/navy paletu preporučen kvadrat ili CSS `object-position: top`.
- **IMG_1740** — u pozadini je zamućen veliki plakat sa licem žene (reklamni vizual događaja, nije prepoznatljiva osoba) — prihvatljivo; fotografija sa skupa je verovatno delo fotografa organizatora → potvrditi pravo korišćenja.

### Logo
- Znak (krug) izdvojen iz `Logo.PNG` po zlatnom prstenu. `logo-znak.png/.webp` = navy disk + zlatni prsten, providno van kruga. `logo-znak-providni.png` = navy pretvoren u providnost (color-to-alpha + prag da se ukloni šum/tekstura navy pozadine). `logo-znak-krem.png` = bele linije prebojene u navy #14213D, zlato zadržano (blago tamnije, #B08A46) za kontrast na krem pozadini.
- Logo je raster 1024 px (verovatno AI/generisan) — znak je ~440 px; `favicon-v2-512.png` je blago uvećan (440→512). Na 32 px detalji bebe se gube — za favicon možda bolje jednostavan "FK" monogram. **Zatražiti od klijenta vektorski logo (SVG/AI/PDF).**
- `og-image-v2.jpg` je složen sa sistemskim fontovima (FreeSerif / Liberation Sans) jer Fraunces/Karla nisu bili dostupni offline — ako treba identična tipografija sa sajtom, regenerisati sa Fraunces.
