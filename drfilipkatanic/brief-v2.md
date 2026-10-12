# Brief v2 — dorada sajta dr Filip Katanić (2026-10-12)

Ovo je nadogradnja postojećeg sajta (src/ → build.py → site/). Svi agenti čitaju ovaj fajl PRE ostalih dokumenata; gde se ovaj brief razlikuje od structure.md / brand.md / copy.md / README.md, **ovaj brief ima prednost**.

## 1. Zahtevi korisnika (doslovno preneto)
1. Klijent uzima sajt, ali sajt **mora imati formu za zakazivanje**.
2. **Ovo je LIČNI sajt dr Filipa Katanića, ne sajt SB Ferona.** Ispraviti sve što sajt predstavlja kao Ferona sajt: CTA "Zakažite u SB Feroni", Ferona telefon/mejl kao glavni kontakt, footer sa Feronom kao vlasnikom, schema, tekstovi. Ferona ostaje SAMO kao informacija gde radi / gde se obavljaju postupci (npr. "Ordinira u SB Ferona, Novi Sad"), nikad kao brend sajta.
3. **PHP backend**: doktor u admin panelu vidi sva zakazivanja, može da **potvrdi ili odbije**, i pacijent automatski dobija **mejl** o potvrdi ili odbijanju.
4. Dizajn nije završen — treba da izgleda **otprilike kao referenca** `_reference/referenca-dizajn.webp` (pogledaj je Read alatom!). Korisnik traži da sajt izgleda **dizajnerski lepo, složeno, premium**, i da bude **savršeno prilagođen telefonu**.
5. **Nove slike dr Katanića** su dodate u `Assets/Raw/` — koristiti ih svuda gde se on prikazuje: `IMG_1626.jpg` (landscape, beli mantil, ordinacija — idealan za hero), `IMG_4642.jpg` i `IMG_4641.JPG` (portret, beli mantil — na majici se vidi mali "Ferona" logo; kropovati/retuširati da se ne vidi), `IMG_4647.JPG` (nasmejan za stolom — "O meni"), `IMG_1740.JPG` (panel na konferenciji, odelo — mediji/predavanja), `Logo.PNG` (zvanični logo: navy pozadina, zlatni krug, ruke + beba, "FK" u srcu, script "Dr Filip Katanić").

## 2. Referentni dizajn (šta se vidi na `_reference/referenca-dizajn.webp`)
- Paleta: krem/topla bela pozadina, duboki navy (#14213D-ish) za naslove, dugmad i trake, šampanj-zlato za tanke linije, eyebrow natpise i ikone. Elegantni serifni naslovi (klasičan, visok kontrast), čist sans za tekst.
- Header: FK monogram u zlatnom kvadratnom okviru + "dr Filip Katanić" / "Reproduktivna medicina", meni (Početna, O meni, Oblasti rada, Konsultacija, Journal/Blog, Kontakt), navy dugme "Zakaži konsultaciju". Aktivna stavka podvučena zlatnom linijom.
- Hero: veliki serifni H1 "dr Filip Katanić", zlatni podnaslov "Reproduktivna medicina • IVF • Klinička istraživanja", kratak uvod, dva dugmeta (navy puno + zlatni outline), red od 3 kredencijala sa tankim linijskim ikonama; desno velika fotografija u belom mantilu koja se pretapa (gradient) u krem pozadinu.
- "MOJ PRISTUP" — centriran serifni naslov ("Ne postoji univerzalni IVF protokol.") + pasus.
- "KADA IMA SMISLA DA SE JAVITE?" — 4 kartice sa tankim zlatnim linijskim ikonama.
- "OBLASTI RADA" — grid 2×3 kartica (ikona levo, naslov, opis).
- "KONSULTACIJA NIJE SAMO PREGLED. KONSULTACIJA JE PLAN." — 5 numerisanih koraka (01–05) sa strelicama.
- "O MENI" — fotografija levo, naslov + pasus + 3 kolone (Klinički rad / Akademski rad / Edukacija i međunarodni rad).
- Navy traka sa ikonama (statistika/vrednosti), "NAUKA I EDUKACIJA" — red pločica sa konferencijama (GIGANODE, Weill Cornell Seminar Salzburg, LH in ART Sorrento, MSRM Bari, ESHRE, Naučni radovi i predavanja), "JOURNAL" — 3 kartice članaka sa slikom, CTA traka "Zakažite konsultaciju i napravimo plan koji je pravi za vas." sa FK pečatom, navy footer.
- Referenca je orijentir za kompoziciju i osećaj, NE izvor činjenica: telefon/mejl na njoj su izmišljeni; konferencije sa reference koristiti samo ako ih potvrđuju research.md/web-research.md, ostalo označiti [POTVRDITI SA KLIJENTOM].

## 3. Činjenice / pravila sadržaja
- Titula: klijent na svom IG bio-u navodi "Specijalista ginekologije i akušerstva" i "Master reproduktivni embriolog", i ista titula je na referentnom dizajnu koji je klijent odobrio smer → titula SME da se koristi. Ukloniti blokadu (`TITULA_SPECIJALISTA`/lint) u build.py, ali ostaviti HTML komentar [POTVRDITI SA KLIJENTOM: pismena potvrda titule pre objave].
- Doktorske studije (Medicinski fakultet Novi Sad, prediktivno modelovanje ovarijalnog odgovora) — iz web-research.md, sme se pomenuti uz [POTVRDITI].
- Kontakt: glavni kanal je **forma za zakazivanje** + Instagram @drfilipkatanic. Lični telefon i mejl doktora NISU poznati → u kodu ostaviti placeholder koji se lako menja (jedno mesto u src/data/site.json) i [POTVRDITI]; ne koristiti Ferona telefon kao "njegov". Lokacija: "SB Ferona, Šarplaninska 19, Novi Sad" kao mesto ordiniranja.
- Bez izmišljenih brojki, recenzija, cena, garancija uspeha.

## 4. Zakazivanje — dogovoreni API ugovor (frontend ↔ backend)
- Stranica: `/zakazivanje/` (+ CTA "Zakaži konsultaciju" svuda vodi tamo). Forma se može prikazati i kao sekcija na /kontakt/.
- Frontend prvo radi `GET api/csrf.php` → `{"token":"..."}`, pa šalje `POST api/zakazi.php` (multipart/form-data) sa poljima:
  `csrf_token`, `ime_prezime`* , `email`*, `telefon`*, `kontakt_kanal`* (telefon|viber|whatsapp|email), `tip_usluge`* (prva-konsultacija|drugo-misljenje|ivf|zamrzavanje-jajnih-celija|pcos|muski-faktor|ginekoloski-pregled|ostalo), `zeljeni_datum`* (YYYY-MM-DD, ne u prošlosti), `doba_dana` (pre-podne|posle-podne|svejedno), `partner_ime`, `dokumentacija_status` (imam|nemam|delimicno), `napomena` (max 2000), `saglasnost`* (=1, privatnost), `website` (honeypot, mora ostati prazno).
- Odgovor: `200 {"ok":true,"id":N}` ili `4xx {"ok":false,"error":"poruka na srpskom","fields":{"email":"..."}}`; `429` kod rate limita.
- Admin: `/admin/` (login), lista zahteva sa filterima (novo/potvrđeno/odbijeno/otkazano), detalji, akcije **Potvrdi** (sa poljima: potvrđen datum, vreme, poruka pacijentu) i **Odbij** (sa razlogom / predlogom drugog termina) → mejl pacijentu. Na novi zahtev — mejl obaveštenje doktoru.
- Hosting: običan deljeni PHP hosting (PHP 8.x, SQLite/PDO). Bez Composer-a. Mejl preko SMTP-a (konfiguracija u `config.php` van webroot-a ili zaštićeno), fallback na `mail()`.
