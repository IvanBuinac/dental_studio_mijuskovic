# SEO — Dental Studio Mijušković, Nikšić

Demo je noindex/nofollow (robots meta + robots.txt Disallow) dok klijent ne prihvati. Struktura ispod je spremna za indeksiranje čim se to ukloni.

## Ključne reči (lokalno, crnogorsko tržište)

| Stranica | Primarni upit | Sporedni |
|---|---|---|
| Početna | stomatolog Nikšić | stomatološka ordinacija Nikšić, Dental Studio Mijušković |
| Lumineeri | lumineeri Nikšić | keramičke fasete Crna Gora, fasete za zube Nikšić |
| Protetika | cirkonijum krunice Nikšić | bezmetalna keramika, zubni mostovi Nikšić |
| Implanti | zubni implanti Nikšić | implanti Crna Gora, fiksni rad na implantima |
| Izbeljivanje | izbeljivanje zuba Nikšić | beljenje zuba ordinacija |
| O nama | specijalista stomatološke protetike Nikšić | dr Žarko Mijušković |
| Kontakt | stomatolog Nikšić telefon | zakazivanje pregleda Nikšić |

## Naslovi i opisi (do 60 / 155 znakova)

- Početna — „Dental Studio Mijušković, Nikšić | Lumineeri, implanti, protetika" / „Ordinacija dr Žarka Mijuškovića, specijaliste stomatološke protetike. Lumineeri, cirkonijum krunice, implanti i izbeljivanje u Nikšiću."
- Lumineeri — „Lumineeri i keramičke fasete | Dental Studio Mijušković" / „Osmeh bez brušenja ili uz minimalno brušenje zuba. Prirodna boja, oblik i translucencija — Nikšić."
- Protetika — „Cirkonijum krunice i mostovi | Dental Studio Mijušković" / „Bezmetalna keramika i specijalistička protetika u Nikšiću. Funkcija zagrižaja i prirodan izgled."
- Implanti — „Zubni implanti Nikšić | Dental Studio Mijušković" / „Zamena izgubljenog zuba bez brušenja susednih. Fiksni radovi na implantima, Nikšić."
- Izbeljivanje — „Izbeljivanje zuba Nikšić | Dental Studio Mijušković" / „Ordinacijsko izbeljivanje pod kontrolom stomatologa. Rezultat istog dana, bez oštećenja gleđi."
- O nama — „Dr Žarko Mijušković, specijalista protetike | Nikšić" / „Specijalista stomatološke protetike i tim Dental Studija Mijušković u Nikšiću."
- Rezultati — „Rezultati: pre i posle | Dental Studio Mijušković" / „Stvarni radovi ordinacije: lumineeri, fasete i bezmetalna keramika. Nikšić."
- Kontakt — „Kontakt i zakazivanje | Dental Studio Mijušković, Nikšić" / „Pozovite 067 440 414 ili pišite na Viber i WhatsApp. Nikšić, Crna Gora."

## Schema.org

- Početna: `Dentist` (name, telephone, addressLocality Nikšić, addressCountry ME, areaServed).
- O nama: `Person` za dr Žarka Mijuškovića (jobTitle: Specijalista stomatološke protetike).
- Svaka usluga: `MedicalProcedure` sa `procedureType`.
- Bez izmišljenih ocena, broja recenzija i adrese ulice — ta polja se ne stavljaju dok klijent ne potvrdi.

## URL struktura

`/` · `/o-nama/` · `/usluge/` · `/usluge/lumineeri/` · `/usluge/protetika/` · `/usluge/implanti/` · `/usluge/izbeljivanje/` · `/rezultati/` · `/kontakt/`

## Tehnički

- Jedan H1 po stranici, hijerarhija H2/H3 bez preskakanja.
- Slike: WebP, width/height, opisni alt na srpskom, lazy ispod pregiba.
- Interno povezivanje: svaka usluga linkuje na rezultate i kontakt, početna na sve usluge.
- sitemap.xml + robots.txt (Disallow: / dok traje demo).
