# Brand: dr Filip Katanić — ginekologija / IVF (vantelesna oplodnja)

Datum: 2026-09-25
Izvor: 23 slike iz `Assets/Raw/` (IG @drfilipkatanic), `research.md`. Nema zvaničnog logotipa — postoji neformalni "FK" monogram (krug, tanka linija) koji se koristi kao potpis na edukativnim grafikama i može poslužiti kao osnova za favicon/monogram na sajtu.

## 0. Šta pokazuju slike (metoda)

Pregledano 20 od 23 slike (portreti, konferencije, porodica, i tri ponavljajuća **edukativna template stila** koja dizajner/klijent već koristi na IG-u):

1. **Krem/polaroid stil** — topla bež pozadina (`#FDFAF5`–`#FFFCF7`), polaroid okviri sa portretom, potpis rukopisom ("suprug", "otac", "gitarista"), taman toplo-smeđi tekst.
2. **Crna school-board grafika** — crna tabla u drvenom ramu na zidu od cigle, beli serifni citat — koristi se za "teže" edukativne poruke (biologija, selekcija embriona).
3. **Tamno-teget "premium" kartica** — duboko teget/antracit pozadina, tanka zlatna (šampanj) linija/okvir, zlatni serifni naslov, potpis "dr Filip Katanić" u kurzivnom rukopisu — koristi se za brojčane tabele (godine/broj ćelija) i "važne poruke za kraj".
4. **Krem + teget + zlato + FK monogram** — najčistiji, najbrendiraniji template (npr. "Social freezing" carousel): krem pozadina, teget serifni naslov, kurzivni teget podnaslov, tanke zlatne linije/grančice, FK monogram u krugu kao potpis.

Ova četiri stila već dele **istu paletu i istu logiku** (topao krem + duboki teget + zlato/šampanj + povremeno šalvija zelena za "zeleno = umirujuće/potvrđeno") — to je čvrsta osnova za sajt, nije potrebno izmišljati novu paletu, samo je konsolidovati i proveriti kontrast.

Boje su izvučene programski (Python + Pillow, median-cut kvantizacija + ciljano uzorkovanje piksela iz tekstualnih/akcentnih regiona), ne procenjene vizuelno.

## 1. Paleta

| Uloga | Hex | Izvor / gde se koristi |
|---|---|---|
| **Primarna** (Navy) | `#10284A` | Izvučeno iz navy naslova na "Social freezing" carouselu (sirovi uzorak `#06224a`, blago posvetljeno radi upotrebljivosti). Naslovi, primarna dugmad, navigacija, ikonice — nosi stručnost i poverenje bez "bolničkog" hladnog plavo-belog. |
| **Sekundarna** (Šalvija zelena) | `#4E6B54` (tekst/ikone) / `#7A9885` (dekorativno, veći elementi) | Izvučeno iz "zeleno = potvrđeno/umirujuće" checkmark elemenata (PCOS/ovulacija grafike, sirovi uzorak `#7a9885`, potamnjeno za AA tekst). Sekundarna dugmad, potvrde, "zelene zastavice", linkovi, tagovi. Namerno *nije* plava (izbegava klinički osećaj) niti roze/lila (izbegava doslovan "beba" kliše) — zemljano-zelena nosi nadu i smirenost bez patetike. |
| **Akcent** (Šampanj zlato) | `#8C7355` (tekst-bezbedno) / `#C9AD87` (dekorativno na tamnim pozadinama) | Izvučeno iz zlatnog teksta na teget "premium" karticama (sirovi uzorak `#bda78c`). Tanke linije, okviri, ikonice, citati, hover stanja — daje toplinu i diskretnu premium notu bez "spa/wellness" utiska. |
| **Pozadina** (Krem) | `#FBF7F0` | Prosek dominantnih pozadina sa gotovo svih carousela (`#FDFAF5`, `#FFFCF7`, `#FCF9F4`). Glavna pozadina sajta umesto klinički hladnog belog. |
| **Površina / kartice** | `#FFFFFF` ili `#FFFDF9` | Kartice, forme, elevated elementi na krem pozadini — blago hladnija/svetlija od pozadine radi razlikovanja slojeva. |
| **Tamna površina** (za "važne poruke") | `#10284A` (ista kao primarna) ili `#14181F` | Za povremene "premium citat" sekcije koje repliciraju postojeći teget/crni template (npr. istaknuta izjava lekara, "važna poruka za kraj") — koristiti retko, za naglasak, ne kao dominantnu pozadinu. |
| **Tekst** | `#2E2A26` | Potamnjeno iz uzorka tamnog teksta na krem karticama (sirovi `#494742`) radi AA/AAA kontrasta. Toplo ugljen-smeđa, ne čisto crna — mekši je i topliji od `#000000`. |
| **Tekst na tamnoj površini** | `#FBF7F0` (krem) + `#C9AD87` (zlato za naglaske) | Za tekst na navy/tamnim karticama. |

## 2. CSS varijable

```css
:root {
  /* Primarna paleta */
  --color-primary: #10284A;       /* deep navy — stručnost, poverenje */
  --color-primary-light: #2C4B78; /* hover/active varijanta */
  --color-primary-tint: #E7ECF2;  /* svetla pozadina sekcija, badge-ovi */

  --color-secondary: #4E6B54;     /* šalvija zelena — nada, smirenost */
  --color-secondary-light: #7A9885;
  --color-secondary-tint: #E9F0EA;

  --color-accent: #8C7355;        /* šampanj zlato — tekst-bezbedna varijanta */
  --color-accent-decorative: #C9AD87; /* svetlija, samo za dekor/tamne pozadine */
  --color-accent-tint: #F3EAD9;

  --color-bg: #FBF7F0;            /* topao krem — glavna pozadina */
  --color-surface: #FFFFFF;       /* kartice, forme */
  --color-surface-dark: #10284A;  /* "premium" kartice / istaknuti citati */

  --color-text: #2E2A26;          /* topao ugljen — telo teksta */
  --color-text-muted: #6B655D;    /* sekundarni tekst, meta info */
  --color-text-on-dark: #FBF7F0;  /* tekst na tamnoj površini */
  --color-text-on-primary: #FFFFFF;

  --color-border: #E3DCD1;        /* suptilne linije, razdelnici */

  /* Zaobljenja i senke — "mek" osećaj, ne oštar/klinički */
  --radius-sm: 10px;
  --radius-md: 16px;
  --radius-lg: 24px;
  --radius-pill: 999px;
  --shadow-soft: 0 8px 24px rgba(16, 40, 74, 0.08);
  --shadow-card: 0 4px 16px rgba(46, 42, 38, 0.06);
}
```

## 3. Kontrast (WCAG AA, min 4.5:1 za tekst)

| Kombinacija | Odnos | Status |
|---|---|---|
| Tekst `#2E2A26` na pozadini `#FBF7F0` | 13.33:1 | Prolazi AAA |
| Primarna `#10284A` kao tekst na `#FBF7F0` | 13.81:1 | Prolazi AAA |
| Bela `#FFFFFF` na primarnoj `#10284A` (dugmad) | 14.74:1 | Prolazi AAA |
| Krem tekst `#FBF7F0` na primarnoj pozadini `#10284A` | 13.81:1 | Prolazi AAA |
| Sekundarna (tamnija) `#4E6B54` na `#FBF7F0` | 5.53:1 | Prolazi AA (normalan tekst) |
| Sirova šalvija `#7A9885` na `#FBF7F0` | 3.47:1 | **Ne prolazi** za tekst — koristiti samo dekorativno/za velike naslove ili ikone |
| Akcent (tamniji) `#8C7355` na `#FBF7F0` | 4.19:1 | Prolazi AA samo za veliki tekst (≥18px / bold ≥14px) — **ne koristiti za sitan telesni tekst** |
| Zlato `#C9AD87` na tamnoj `#10284A` | 6.89:1 | Prolazi AA — bezbedno za tekst/naslove na tamnim karticama |

**Pravilo:** primarna navy i osnovni tekst su bezbedni svuda. Sekundarna (šalvija) i akcent (zlato) koristiti za tekst samo u potamnjenoj varijanti ili u velikim/bold naslovima; svetlije, dekorativne varijante (`--color-secondary-light`, `--color-accent-decorative`) rezervisati za ikone, linije, pozadine tagova i tamne kartice — nikad za sitan tekst na krem pozadini.

## 4. Tipografija

Stil sa IG-a: elegantan, visoko-kontrastan serif za naslove (vidljivo na gotovo svim edukativnim karticama — "PCOS", "JEDINSTVENOST", "Kada zamrzavanje jajnih ćelija") u kombinaciji sa čistim, toplim sans-serifom za telo i liste, plus kurzivna serifna varijanta za lični potpis ("dr Filip Katanić"). Ovo NIJE dekorativan/luksuzan display font (izbegava "spa" utisak) niti hladan geometrijski sans poput Montserrat/Poppins (izbegava generički "estetska klinika" template izgled).

Oba predložena para su proverena na fonts.google.com (Glyphs & languages) za puni **latin-ext** set (č ć š ž đ Č Ć Š Ž Đ) — oba prolaze.

### Opcija A (preporučeno)
- **Naslovi:** [Fraunces](https://fonts.google.com/specimen/Fraunces) — varijabilni serif sa "soft"/optical-size osobinama, topao i savremen, najbliži postojećem IG stilu naslova.
- **Telo:** [Karla](https://fonts.google.com/specimen/Karla) — human sans, blago zaobljeni završeci, topliji od Inter/Roboto, odličan za dugačke edukativne tekstove.

```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;1,9..144,500&family=Karla:wght@400;500;600;700&display=swap" rel="stylesheet">
```
```css
--font-heading: 'Fraunces', Georgia, 'Times New Roman', serif;
--font-body: 'Karla', -apple-system, Segoe UI, sans-serif;
```

### Opcija B (alternativa)
- **Naslovi:** [Lora](https://fonts.google.com/specimen/Lora) — klasičniji, "knjiški" topao serif, vrlo blizak fontu korišćenom u postojećim carousel grafikama.
- **Telo:** [Mulish](https://fonts.google.com/specimen/Mulish) — čist, topao sans, širok raspon težina, dobra čitljivost na malim ekranima.

```html
<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..600&family=Mulish:wght@400;500;600;700&display=swap" rel="stylesheet">
```
```css
--font-heading: 'Lora', Georgia, serif;
--font-body: 'Mulish', -apple-system, Segoe UI, sans-serif;
```

**Kurziv za lični ton** (citati, potpis "dr Filip Katanić", istaknute rečenice poput "Ne možemo kontrolisati baš sve, ali možemo napraviti najbolji plan"): koristiti italic rez naslovnog fonta (Fraunces Italic / Lora Italic) — ne uvoditi treći, dekorativni script font. Dva porodice fontova su dovoljna i lakša za održavanje.

## 5. Vizuelni stil

- **Fotografija:** svetla, prirodno/meko osvetljenje, portreti dr Katanića u belom mantilu ili smart-casual, direktan pogled u kameru, topao ali ozbiljan izraz. Pozadine blago zamućene (ordinacija, konferencijska sala) — nikad fluorescentno-hladan "bolnički" izgled. Nema pre/posle slika (nije primenljivo za IVF), nema close-up stock fotografija trudničkih stomaka ili beba — ton ostaje dostojanstven i fokusiran na lekara/proces, ne na senzacionalizovan "rezultat".
- **Prostor/kompozicija:** izdašan negativni prostor, jedna centralna poruka po sekciji/slajdu (kao u IG carouselima) — izbegavati zbijene, "dashboard" gust raspored informacija.
- **Oblici:** dosledno **zaobljeni** uglovi (polaroid okviri, pill-bedž "SOCIAL FREEZING", zaobljene teget kartice) — nikad oštri/pravougaoni "klinički" blokovi. Zaobljenost signalizira mekoću i smirenost, važno za osetljivu temu steriliteta.
- **Gustina:** nizak do srednji — puno vazduha oko teksta, kratki pasusi, liste sa ikonama umesto zidova teksta.
- **Ikonografija:** jednostavne linijske ikone; šalvija-zeleni check za "normalno/umirujuće/potvrđeno" (već ustaljen obrazac na IG-u); crvena/upozoravajuća ikonografija koristiti izuzetno retko i samo tamo gde je medicinski opravdano (npr. "kada se javiti lekaru" vodič), nikad kao marketinški alarm.
- **Animacije:** suptilne, spore (fade/slide na scroll, 300-500ms), bez "bouncy" ili igrivih mikro-animacija, bez countdown tajmera ili "urgency" elemenata — tema zahteva mirnoću, ne pritisak.

## 6. UI smernice

- **Dugmad:** meko zaobljena (`--radius-pill` ili `--radius-md`), primarna = navy pozadina + beli/krem tekst; sekundarna = outline navy ili puna šalvija-zelena; hover = blago potamnjenje boje (bez skaliranja/bounce efekta koji deluje neozbiljno za ovu temu).
- **Kartice:** zaobljeni uglovi (`--radius-lg`), meka topla senka (`--shadow-card`), generozan padding (min 24-32px). Povremena "premium" varijanta kartice (teget pozadina + zlatni tekst) za istaknute citate lekara ili ključne poruke — direktno replicira postojeći IG stil i daje sajtu prepoznatljivost.
- **Forme (zakazivanje/kontakt):** mirni, jednostavni inputi sa tankim toplim border-om (`--color-border`), bez agresivnih multi-step funnela ili "poslednja šansa" formulacija — u duhu postojećeg "Zakazivanje u DM" pristupa, samo formalizovanog kroz formu/telefon/email.
- **Svedočanstva:** samo tekstualna, anonimizovana, sa jasnom napomenom o saglasnosti pacijentkinje (već praksa na IG-u) — nikad izmišljena, nikad sa brojkama uspešnosti.
- **Statistike/tabele:** kada se prikazuju medicinski podaci (npr. tabele godine/broj ćelija iz IG grafika), koristiti mirnu tabelarnu prezentaciju sa neutralnim tonom — ne kao "marketing" grafikon uspeha.

## 7. Raspoloženje

**5 prideva:** stručno · toplo · smireno · poverljivo · obazrivo (pažljivo/empatično)

**Čega se klonimo:**
- Stock fotografija trudnica/beba, generički "srećna porodica" klišei
- Roze/lila kao doslovna "beba/plodnost" simbolika
- Hladno kliničko plavo-belo (bolnički, sterilan utisak)
- Jarke, neonske ili previše saturisane boje
- Bilo kakvo obećanje uspeha — velike brojke "% uspešnosti", "garantovano", poređenje sa konkurencijom
- Agresivni marketinški jezik i UI (countdown tajmeri, "ZAKAŽITE ODMAH", pop-up pritisak, pre/posle vizuali)
- Previše dekorativan/luksuzan "wellness-spa" vizuelni jezik (svileni tekstovi, cveće, previše zlata) — ravnoteža mora ostati na strani struke, ne estetike
- Oštri, pravougaoni, "korporativno-hladni" UI elementi bez zaobljenja

## 8. Napomena za sledeće agente

- FK monogram (krug + tanka linija, viđen u "Social freezing" carouselu) je neformalan i može se koristiti kao osnova za favicon/watermark, ali nije zvaničan logotip — proveriti sa klijentom da li postoji vektorska verzija ili ga treba redizajnirati.
- Paleta i tipografija su namerno usklađene sa postojećim IG vizuelnim identitetom (nije nova/izmišljena paleta) kako bi sajt delovao kao prirodni nastavak brenda koji klijent već gradi, ne kao generički template.
