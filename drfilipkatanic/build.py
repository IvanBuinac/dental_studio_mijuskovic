#!/usr/bin/env python3
"""Mini static builder: dr Filip Katanić (bez zavisnosti, Python 3.8+; Pillow opciono za favicon/og-image).

    python build.py          gradi sve stranice iz src/pages u site/
    python build.py --lint   gradi i proverava izlaz (zabranjeni izrazi, flagovi, krop-pravila); exit 1 ako padne
    python build.py --kit    gradi src/pages/_kit.html u _preview/index.html (lokalni pregled komponenti, NE ide u site/)

Struktura (ista arhitektura kao kod ostalih klijenata, CSS/komponente su nove — brand.md/structure.md ovog klijenta):
  src/layout.html          okvir stranice ({{title}}, {{meta}}, {{content}} ...)
  src/partials/*.html      header, footer, cta-band, sticky-bar, seal, credential, venue, venue-card ...
                           ({{> ime}} ih ubacuje bilo gde)
  src/pages/**/*.html      stranice: front matter (--- ... ---) + sadrzaj
  src/data/site.json       globalni kljucevi ({{g.tel}}, {{g.ferona}}, {{g.adresa}} ...)
  src/data/jsonld/*.json   opciono, front matter `jsonld: ime1,ime2` ubacuje 1+ <script type=application/ld+json>
                           (ime "auto-faq" generise FAQPage direktno iz {{faq}} blokova na stranici, bez dupliranja teksta)
  src/static/**            kopira se 1:1 u site/ (assets/css/, assets/js/, favicon.svg, site.webmanifest ...)

Putanje stranica:
  pages/index.html                   -> site/index.html
  pages/404.html                     -> site/404.html
  pages/o-meni.html                  -> site/o-meni/index.html
  pages/oblasti-rada/pcos-i-neplodnost.html -> site/oblasti-rada/pcos-i-neplodnost/index.html
  fajlovi koji pocinju sa "_" se preskacu (osim _kit.html uz --kit)

Front matter (svi opcioni):
  title, description, og_image, body_class, nav (kljuc aktivne stavke), cta: none, cta_title, cta_text,
  preload (slika za <link rel=preload>, relativno od site/), robots (npr. noindex), root (npr. "/" za 404),
  scripts (dodatni js iz assets/js/, zarezom), jsonld (ime fajla iz src/data/jsonld/)

U stranicama/partial-ima:
  {{root}} {{site_url}} {{year}}     {{g.kljuc}}      {{> partial}}
  {{gen:illo_spermogram}} {{gen:illo_pregled}} {{gen:venue_map}}
  {{cur:oblasti-rada}} / {{cur:oblasti-rada/pcos-i-neplodnost}}  aria-current za meni
  {{if FLAG}}...{{/if}}   {{if !FLAG}}...{{/if}}   (flagovi ispod)
  {{faq [open]}} P:/O: blokovi {{/faq}}   (akordeon + izvor za FAQPage)

KRITICNO (structure.md 0.2): hero.webp i konferencija-02.webp imaju utisnut tekst
"Specijalista ginekologije i akušerstva" / "Ob/Gyn Specialist" u samoj slici. Ove dve slike se SMEJU
koristiti iskljucivo kroz CSS klase .crop-hero / .crop-konferencija02 (components.css) na <img> tagu
— nikad puna/nekropovana slika. --lint ovo proverava masinski (CROP_REQUIRED nize) i puca ako fali.
"""
import html
import json
import re
import shutil
import sys
from datetime import date
from pathlib import Path

if hasattr(sys.stdout, "reconfigure"):
    sys.stdout.reconfigure(encoding="utf-8")
    sys.stderr.reconfigure(encoding="utf-8")

ROOT = Path(__file__).resolve().parent
SRC = ROOT / "src"
OUT = ROOT / "site"
PREVIEW = ROOT / "_preview"

# ---------------------------------------------------------------- konfiguracija
SITE_URL = "https://drfilipkatanic.cvijanovic-dent.workers.dev"    # demo; zameniti kad klijent odabere pravi domen (seo.md, otvoreno pitanje 6)
DEMO = True                      # demo verzija: noindex svuda + Disallow u robots.txt; False pri objavi na pravom domenu
DEFAULT_OG = "assets/img/og-image.jpg"  # 1200x630, generise build (make_assets) — tipografska navy/krem karta, NE fotografija

# Build flagovi (structure.md 1): sve "samo uz potvrdu" je iza flaga, ne obrisano.
TITULA_SPECIJALISTA = False        # NIKAD True dok klijent pismeno ne potvrdi (seo.md 0.1) — lint pada BEZ OBZIRA na flag
STATUS_ZAPOSLENJA_POTVRDJEN = False  # dok False: samo "clan tima SB Ferona", nikad "zaposlen/vlasnik"
RADNO_VREME = False                # sekcija na /kontakt/ hidden dok se ne potvrdi
CENOVNIK = False                   # nema cenovnika nigde; flag postoji samo da spreci slucajno dodavanje
ALUMNI_NOVISAD = False             # "Medicinski fakultet Novi Sad" van schema alumniOf i van vidljivog teksta kao cinjenica dok se ne potvrdi
GALERIJA_PROSTORA = False          # sekcija za prave fotografije SB Ferona, sakrivena dok ne stignu
TESTIMONIALS = False               # komponenta ne postoji u kodu dok ne stignu pisane saglasnosti
BLOG_EXPANDED = False              # dodatni clanci (PCOS zablude, social freezing, muski faktor...) cekaju vise IG materijala
GBP_SEPARATE = False               # zaseban Google Business Profil za doktora — van obima prve faze (seo.md 7)

FLAGS = {
    "TITULA_SPECIJALISTA": TITULA_SPECIJALISTA, "STATUS_ZAPOSLENJA_POTVRDJEN": STATUS_ZAPOSLENJA_POTVRDJEN,
    "RADNO_VREME": RADNO_VREME, "CENOVNIK": CENOVNIK, "ALUMNI_NOVISAD": ALUMNI_NOVISAD,
    "GALERIJA_PROSTORA": GALERIJA_PROSTORA, "TESTIMONIALS": TESTIMONIALS, "BLOG_EXPANDED": BLOG_EXPANDED,
    "GBP_SEPARATE": GBP_SEPARATE,
}

NAV_KEYS = {"o-meni", "oblasti-rada", "pitanja-i-odgovori", "blog", "mediji-i-predavanja", "kontakt"}

DEFAULTS = {
    "title": "dr Filip Katanić",
    "description": "",
    "body_class": "",
    "cta_title": "Sledeći korak je razgovor",
    "cta_text": "Za zakazivanje pregleda obratite se kontakt centru SB Ferona — ustanove u kojoj dr Filip Katanić radi.",
    "preload": "",
    "robots": "",
    "scripts": "",
    "jsonld": "",
}

NL = chr(10)
BUILT_URLS = []
PLACEHOLDER = re.compile(r"\{\{\s*([^{}]+?)\s*\}\}")
IF_RE = re.compile(r"\{\{if (!?)(\w+)\}\}((?:(?!\{\{if ).)*?)\{\{/if\}\}", re.S)


def read(path: Path) -> str:
    return path.read_text(encoding="utf-8").replace("\r\n", "\n")


def load_json(rel):
    p = SRC / "data" / rel
    return json.loads(read(p)) if p.exists() else {}


SITE_DATA = {}


def parse_page(text: str):
    """Front matter (--- ... ---) + telo."""
    meta = {}
    m = re.match(r"^---\n(.*?)\n---\n?", text, re.S)
    if m:
        for line in m.group(1).split("\n"):
            if ":" in line and not line.lstrip().startswith("#"):
                k, v = line.split(":", 1)
                meta[k.strip()] = v.strip()
        text = text[m.end():]
    return meta, text


# ---------------------------------------------------------------- SVG generatori (structure.md 2.8, korak 3)
def gen_illo_spermogram(_arg=""):
    """.illo--spermogram: minimalisticka linijska epruveta + mikroskop, bez tela/lica (structure.md 2.8)."""
    return (
        '<svg class="illo illo--spermogram" viewBox="0 0 220 220" role="img" focusable="false" '
        'aria-label="Linijska ilustracija epruvete i mikroskopa">'
        '<path class="illo__l" d="M90 30h30 M96 30v70c0 22 -14 34 -14 54c0 18 14 30 33 30s33 -12 33 -30c0 -20 -14 -32 -14 -54V30"/>'
        '<path class="illo__l" d="M96 108h58"/>'
        '<circle class="illo__dot" cx="115" cy="150" r="4"/>'
        '<circle class="illo__dot" cx="128" cy="168" r="3"/>'
        '<path class="illo__l" d="M40 190h50 M46 190v-18a20 20 0 0 1 40 0v18 M66 172v-40 M50 132h32"/>'
        '</svg>'
    )


def gen_illo_pregled(_arg=""):
    """.illo--pregled: linijski kalendar sa jednom zlatnom kvackicom (eho .badge/checkmark jezika, structure.md 2.8)."""
    return (
        '<svg class="illo illo--pregled" viewBox="0 0 220 220" role="img" focusable="false" '
        'aria-label="Linijska ilustracija kalendara">'
        '<rect class="illo__l" x="40" y="50" width="140" height="130" rx="14"/>'
        '<path class="illo__l" d="M40 88h140"/>'
        '<path class="illo__l" d="M76 38v24 M144 38v24"/>'
        '<path class="illo__l" d="M92 138l16 16 32 -36" stroke="currentColor"/>'
        '</svg>'
    )


def gen_venue_map(_arg=""):
    """Skica mape: 2-3 linije ulica + zlatna tacka (tipografski venue-card, bez fotografije, structure.md 0.3)."""
    return (
        '<svg class="venue-map" viewBox="0 0 240 150" aria-hidden="true" focusable="false">'
        '<line class="venue-map__st" x1="0" y1="112" x2="240" y2="52"/>'
        '<line class="venue-map__st" x1="70" y1="0" x2="118" y2="150"/>'
        '<line class="venue-map__st venue-map__st--minor" x1="0" y1="34" x2="240" y2="132"/>'
        '<circle class="venue-map__ring" cx="102" cy="82" r="13"/>'
        '<circle class="venue-map__dot" cx="102" cy="82" r="4.5"/>'
        '</svg>'
    )


GENERATORS = {
    "illo_spermogram": gen_illo_spermogram,
    "illo_pregled": gen_illo_pregled,
    "venue_map": gen_venue_map,
}


# ---------------------------------------------------------------- mini DSL ({{faq}})
DSL_RE = re.compile(r"\{\{(faq)([^}\n]*)\}\}\n(.*?)\n?\{\{/\1\}\}", re.S)
_faq_n = [0]


def expand_dsl(text: str) -> str:
    """{{faq [open]}} P:/O: blokovi {{/faq}} -> .faq akordeon (isti tekst se koristi za FAQPage)."""
    def sub(m):
        kind, arg, body = m.group(1), m.group(2).split(), m.group(3).strip()
        out = ['<div class="faq reveal">']
        for i, blk in enumerate(re.split(r"\n\s*\n", body)):
            q = a = None
            for ln in blk.split("\n"):
                ln = ln.strip()
                if ln.startswith("P:"):
                    q = ln[2:].strip()
                elif ln.startswith("O:"):
                    a = ln[2:].strip()
                elif a is not None:
                    a += " " + ln
                elif q is not None:
                    q += " " + ln
            if not q or not a:
                raise ValueError("faq: blok bez P:/O:  -> " + blk[:60])
            _faq_n[0] += 1
            n = _faq_n[0]
            op = i == 0 and "open" in arg
            out.append(
                f'<div class="faq__item{" is-open" if op else ""}"><h3 class="faq__q"><button type="button" aria-expanded="{"true" if op else "false"}" '
                f'aria-controls="f{n}" id="q{n}">{q}<span class="faq__ico" aria-hidden="true"></span></button></h3>'
                f'<div class="faq__a" id="f{n}" role="region" aria-labelledby="q{n}"><div><p>{a}</p></div></div></div>')
        out.append("</div>")
        return "".join(out)
    return DSL_RE.sub(sub, text)


def faq_from_html(text):
    """Q/A iz vec generisanog HTML-a stranice: isti tekst kao vidljivi (FAQPage)."""
    body = re.sub(r"<!--.*?-->", "", text, flags=re.S)
    qs = re.findall(r'<h3 class="faq__q"><button[^>]*>(.*?)<span class="faq__ico"', body, re.S)
    ans = re.findall(r'<div class="faq__a"[^>]*><div><p>(.*?)</p></div></div>', body, re.S)

    def plain(h):
        h = re.sub(r"<[^>]+>", "", h)
        return re.sub(r"\s+", " ", html.unescape(h)).strip()
    return [(plain(q), plain(a)) for q, a in zip(qs, ans)]


# ---------------------------------------------------------------- obrada
def resolve_includes(text: str, depth=0) -> str:
    if depth > 6:
        raise RuntimeError("Previse ugnjezdenih partial-a")

    def sub(m):
        expr = m.group(1)
        if expr.startswith(">"):
            name = expr[1:].strip()
            p = SRC / "partials" / f"{name}.html"
            if not p.exists():
                raise FileNotFoundError(f"partial ne postoji: {name}")
            return resolve_includes(read(p), depth + 1)
        if expr.startswith("gen:"):
            parts = expr[4:].split(None, 1)
            fn = GENERATORS.get(parts[0])
            if not fn:
                raise KeyError(f"nepoznat generator: {parts[0]}")
            return fn(parts[1] if len(parts) > 1 else "")
        return m.group(0)

    return PLACEHOLDER.sub(sub, text)


def resolve_conditionals(text: str) -> str:
    """{{if FLAG}}..{{/if}} / {{if !FLAG}}..{{/if}}; ugnjezdavanje razlicitih flagova dozvoljeno."""
    def sub(m):
        neg, name, body = m.groups()
        if name not in FLAGS:
            raise KeyError(f"nepoznat flag: {name}")
        return body if (FLAGS[name] != bool(neg)) else ""
    prev = None
    while prev != text:
        prev = text
        text = IF_RE.sub(sub, text)
    if "{{if " in text or "{{/if}}" in text:
        raise RuntimeError("neuparen {{if}} / {{/if}}")
    return text


def out_path_for(rel: Path) -> Path:
    if rel.name in ("index.html", "404.html"):
        return rel
    return rel.with_suffix("") / "index.html"


def build_meta(v: dict, url_path, robots: str) -> str:
    esc = lambda s: html.escape(s, quote=True)
    lines = []
    if v["description"]:
        lines.append(f'<meta name="description" content="{esc(v["description"])}">')
    if robots:
        lines.append(f'<meta name="robots" content="{esc(robots)}">')
    elif DEMO:
        lines.append('<meta name="robots" content="noindex, nofollow">')
    if url_path is not None and "noindex" not in robots:
        canon = SITE_URL + url_path
        og_img = SITE_URL + "/" + v.get("og_image", DEFAULT_OG)
        lines += [
            f'<link rel="canonical" href="{esc(canon)}">',
            '<meta property="og:type" content="website">',
            f'<meta property="og:title" content="{esc(v["title"])}">',
            f'<meta property="og:description" content="{esc(v["description"])}">',
            f'<meta property="og:url" content="{esc(canon)}">',
            f'<meta property="og:image" content="{esc(og_img)}">',
            '<meta property="og:locale" content="sr_RS">',
            '<meta property="og:site_name" content="dr Filip Katanić">',
            '<meta name="twitter:card" content="summary_large_image">',
            f'<meta name="twitter:title" content="{esc(v["title"])}">',
            f'<meta name="twitter:description" content="{esc(v["description"])}">',
            f'<meta name="twitter:image" content="{esc(og_img)}">',
        ]
    return "\n".join(lines)


def build_page(page: Path, kit=False):
    rel = page.relative_to(SRC / "pages")
    out_rel = out_path_for(rel)
    fm, body = parse_page(read(page))
    v = {**DEFAULTS, **fm}
    _faq_n[0] = 0
    body = expand_dsl(body)

    parts = out_rel.parent.parts
    url_path = "/" + "/".join(parts) + "/" if parts else "/"
    if out_rel.name == "404.html":
        url_path = None
    depth = len(parts)
    root = v.get("root") or ("../" * depth if depth else "./")
    if kit:
        root = "../site/"
        url_path = None

    robots = v["robots"]
    if kit:
        robots = "noindex, nofollow"

    nav_key = v.get("nav") or (parts[0] if parts and parts[0] in NAV_KEYS else "")
    cur_url = url_path

    def cur(key):
        if "/" in key:
            return ' aria-current="page"' if cur_url == f"/{key}/" else ""
        if key != nav_key:
            return ""
        return ' aria-current="page"' if cur_url == f"/{key}/" else ' aria-current="true"'

    page_scripts = "".join(
        f'<script src="{{{{root}}}}assets/js/{s.strip()}.js" defer></script>\n'
        for s in v["scripts"].split(",") if s.strip()
    )
    preload = (
        f'<link rel="preload" as="image" href="{{{{root}}}}{v["preload"]}" fetchpriority="high">'
        if v["preload"] else ""
    )
    jsonld_parts = []
    for name in [x.strip() for x in v["jsonld"].split(",") if x.strip()]:
        if name == "auto-faq":
            qas = faq_from_html(body)
            if not qas:
                raise ValueError(f"{rel}: jsonld 'auto-faq' trazen ali nema {{faq}} blokova na stranici")
            jsonld_parts.append(json.dumps({
                "@context": "https://schema.org",
                "@type": "FAQPage",
                "mainEntity": [
                    {"@type": "Question", "name": q, "acceptedAnswer": {"@type": "Answer", "text": a}}
                    for q, a in qas
                ],
            }, ensure_ascii=False, indent=2))
        else:
            jp = SRC / "data" / "jsonld" / f"{name}.json"
            if not jp.exists():
                raise FileNotFoundError(f"jsonld ne postoji: {name}")
            jsonld_parts.append(read(jp).strip())
    jsonld = NL.join('<script type="application/ld+json">' + NL + part + NL + "</script>" for part in jsonld_parts)
    slots = {
        "title": html.escape(v["title"]),
        "meta": build_meta(v, url_path, robots),
        "preload": preload,
        "jsonld": jsonld or "<!--LD-->",
        "body_class": (v["body_class"] + (" is-" + nav_key if nav_key else "")).strip(),
        "content": body,
        "cta": "{{> cta-band}}" if v.get("cta") != "none" else "",
        "scripts": page_scripts,
    }
    text = read(SRC / "layout.html")
    text = PLACEHOLDER.sub(lambda m: slots.get(m.group(1), m.group(0)), text)
    text = resolve_includes(text)
    text = resolve_conditionals(text)
    values = {
        "root": root,
        "site_url": SITE_URL,
        "year": str(date.today().year),
        "cta_title": html.escape(v["cta_title"]),
        "cta_text": html.escape(v["cta_text"]),
    }

    def var(m):
        k = m.group(1)
        if k.startswith("cur:"):
            return cur(k[4:])
        if k.startswith("g."):
            if k[2:] not in SITE_DATA:
                raise KeyError(f"site.json: nema kljuca '{k[2:]}'")
            return SITE_DATA[k[2:]]
        return values.get(k, m.group(0))

    for _ in range(2):
        text = PLACEHOLDER.sub(var, text)
    if "<!--LD-->" in text:
        text = text.replace("<!--LD-->", "")
    left = PLACEHOLDER.findall(text)
    if left:
        print(f"  ! {rel}: neresen placeholder {sorted(set(left))}")
    dest = (PREVIEW / "index.html") if kit else (OUT / out_rel)
    dest.parent.mkdir(parents=True, exist_ok=True)
    dest.write_text(text, encoding="utf-8", newline="\n")
    if not kit and url_path is not None and "noindex" not in robots:
        BUILT_URLS.append(url_path)
    print(f"  {rel.as_posix():40s} -> {dest.relative_to(ROOT).as_posix()}")


# ---------------------------------------------------------------- SEO / brend fajlovi
def make_sitemap_robots():
    urls = sorted(set(BUILT_URLS), key=lambda u: (u != "/", u))
    body = "".join("  <url><loc>%s</loc></url>" % html.escape(SITE_URL + u) + NL for u in urls)
    (OUT / "sitemap.xml").write_text(
        '<?xml version="1.0" encoding="UTF-8"?>' + NL
        + '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' + NL + body + "</urlset>" + NL,
        encoding="utf-8", newline=NL)
    (OUT / "robots.txt").write_text(
        "User-agent: *" + NL + ("Disallow: /" if DEMO else "Allow: /") + NL + NL + "Sitemap: " + SITE_URL + "/sitemap.xml" + NL,
        encoding="utf-8", newline=NL)
    print(f"  sitemap.xml ({len(urls)} URL), robots.txt ({'Disallow' if DEMO else 'Allow'})")


def make_assets():
    """favicon.ico, favicon-32.png, favicon-180.png (FK pecat, programatski, brand.md 8) i
    assets/img/og-image.jpg (1200x630, navy/krem tipografska karta, NE fotografija — seo.md 6.5).
    Trazi Pillow; bez njega se preskace uz upozorenje. favicon.svg je vec u src/static (kopiran 1:1)."""
    try:
        from PIL import Image, ImageDraw, ImageFont
    except ImportError:
        print("  ! Pillow nije instaliran: preskacem favicon/og-image (pip install pillow)")
        return
    img_dir = OUT / "assets" / "img"
    img_dir.mkdir(parents=True, exist_ok=True)
    CREAM, NAVY, GOLD = (251, 247, 240), (16, 40, 74), (201, 173, 135)

    def font(size, italic=False):
        names = (["georgiai.ttf", "georgia.ttf"] if italic else ["georgia.ttf"])
        for n in names:
            try:
                return ImageFont.truetype(str(Path("C:/Windows/Fonts") / n), size)
            except OSError:
                continue
        return ImageFont.load_default()

    # favicon: krug (krem) + tanka navy linija + "FK" (echo favicon.svg)
    fav = Image.new("RGB", (256, 256), CREAM)
    d = ImageDraw.Draw(fav)
    d.ellipse((10, 10, 246, 246), outline=NAVY, width=7)
    f = font(96)
    tb = d.textbbox((0, 0), "FK", font=f)
    d.text(((256 - (tb[2] - tb[0])) / 2 - tb[0], (256 - (tb[3] - tb[1])) / 2 - tb[1] - 6), "FK", font=f, fill=NAVY)
    fav.resize((32, 32), Image.LANCZOS).save(OUT / "favicon-32.png")
    fav.resize((180, 180), Image.LANCZOS).save(OUT / "favicon-180.png")
    fav.resize((48, 48), Image.LANCZOS).save(OUT / "favicon.ico")

    # og-image: navy karta, krem tekst, tanka zlatna linija (frame--halo eho), BEZ fotografije/teksta sa "specijalista"
    W, H = 1200, 630
    og = Image.new("RGB", (W, H), NAVY)
    d = ImageDraw.Draw(og)
    d.rectangle((40, 40, W - 40, H - 40), outline=GOLD, width=2)
    f1 = font(64)
    f2 = font(26)
    d.text((88, 250), "dr Filip Katanić", font=f1, fill=CREAM)
    d.text((90, 336), "GINEKOLOGIJA  ·  IVF  ·  NOVI SAD", font=f2, fill=GOLD)
    og.save(img_dir / "og-image.jpg", quality=88, optimize=True)
    print("  favicon.ico, favicon-32.png, favicon-180.png, assets/img/og-image.jpg")


# ---------------------------------------------------------------- lint
# Slike koje SMEJU da se koriste iskljucivo kroz definisanu CSS krop-klasu na <img> tagu (structure.md 0.2).
CROP_REQUIRED = {
    "hero.webp": "crop-hero",
    "konferencija-02.webp": "crop-konferencija02",
}

# (regex nad tekstom bez dijakritika i malim slovima, opis) — structure.md 1 (Build lint), doslovno + task FAZA1
LINT_ALWAYS = [
    (r"specijalist", "titula: 'specijalista/specijalistkinja' (seo.md 0.1 — nepotvrdjeno, NIKAD dok klijent ne potvrdi)"),
    (r"specialist", "titula (eng.): 'specialist'"),
    (r"najbolj(?!i plan\b)", "superlativ 'najbolj*' (izuzetak: odobreni citat 'najbolji plan', structure.md 1)"),
    (r"aggregaterating", "'aggregateRating' (schema, zabranjeno — Google ocena se ne prikazuje, seo.md 0.5)"),
    (r"5:00.{0,3}23:45", "nepouzdano radno vreme 'whatclinic' (5:00-23:45)"),
    (r"4\.0\s*/\s*5|3\.9\s*/\s*5|203 verified|217 reviews", "nepotvrdjena Google ocena/broj recenzija"),
    (r"cena od\s*\d|\d\s*(eur|din|rsd|€)\b.{0,15}(cena|cenovnik)", "konkretna cena bez potvrde (seo.md 0.5)"),
    (r"zaposlen u feroni|vlasnik ordinacije|privatna ordinacija dr katanic", "status zaposlenja/vlasnistva (nepotvrdjeno, seo.md 0.2)"),
    (r"trninic|gemma clinic|kalember", "ime konkurencije u poredbenom kontekstu (seo.md 0.5)"),
    (r"plasticni hirurg", "zvanje: 'plasticni hirurg' (irelevantno, safety-net)"),
]
# broj/% u blizini reci "uspe*" (uspesnost/uspeh) — bilo kojim redosledom, do ~30 znakova razmaka
LINT_USPESNOST = re.compile(r"(\d{1,3}\s?%[^.]{0,30}uspe\w*|uspe\w*[^.]{0,30}\d{1,3}\s?%)")
# "garantov*" je dozvoljeno SAMO u negiranom, uslovnom tonu koji seo.md 0.6/6.3 eksplicitno trazi
# ("ne moze garantovati ishod", "nije garancija") — pozitivno obecanje ("garantujemo trudnocu") ostaje zabranjeno.
LINT_GARANTOV = re.compile(r"garantov\w*")
LINT_GARANTOV_NEG = re.compile(r"\bne\b|\bnije\b|\bnikad\w*\b|\bbez\b")

_TRANS = str.maketrans({"č": "c", "ć": "c", "š": "s", "ž": "z", "đ": "dj", "Č": "c", "Ć": "c", "Š": "s", "Ž": "z", "Đ": "dj"})


def norm(s: str) -> str:
    return s.translate(_TRANS).lower()


def lint() -> int:
    errors, warns = [], []
    for f in sorted(OUT.rglob("*.html")):
        rel = f.relative_to(OUT).as_posix()
        raw = read(f)
        raw_nc = re.sub(r"<!--.*?-->", "", raw, flags=re.S)   # komentari koji objasnjavaju krop-pravilo (0.2) su izuzeti
        n = norm(raw_nc)

        for rx, what in LINT_ALWAYS:
            m = re.search(rx, n)
            if m:
                ctx = raw_nc[max(0, m.start() - 40):m.end() + 40].replace(NL, " ")
                errors.append(f"{rel}: {what}  ...{ctx.strip()}...")

        for m in LINT_USPESNOST.finditer(n):
            ctx = raw_nc[max(0, m.start() - 20):m.end() + 20].replace(NL, " ")
            errors.append(f"{rel}: broj/% uz 'uspesnost/uspeh' (seo.md 0.5, brand.md 7 — zabranjeno)  ...{ctx.strip()}...")

        for m in LINT_GARANTOV.finditer(n):
            pre = n[max(0, m.start() - 25):m.start()]
            if not LINT_GARANTOV_NEG.search(pre):
                ctx = raw_nc[max(0, m.start() - 30):m.end() + 30].replace(NL, " ")
                errors.append(f"{rel}: 'garantov*' bez negacije u blizini — moguce pozitivno obecanje ishoda (seo.md 0.5)  ...{ctx.strip()}...")

        # --- KRITICNO: hero.webp / konferencija-02.webp SAMO kroz propisanu CSS krop-klasu na <img> tagu ---
        for tag in re.finditer(r"<img\b[^>]*>", raw_nc):
            t = tag.group(0)
            src_m = re.search(r'src="([^"]+)"', t)
            if not src_m:
                continue
            src = src_m.group(1)
            for fname, req_cls in CROP_REQUIRED.items():
                if fname in src:
                    cls_m = re.search(r'class="([^"]*)"', t)
                    classes = cls_m.group(1).split() if cls_m else []
                    if req_cls not in classes:
                        errors.append(
                            f"{rel}: '{fname}' korišćen BEZ obavezne krop-klase '{req_cls}' na <img> "
                            f"(structure.md 0.2 — tekst 'specijalista'/'Specialist' ostaje u kadru)  ...{t[:140]}..."
                        )
        # lightbox: ova dva fajla se ne smeju linkovati kao puna/nekropovana slika u [data-lightbox] href
        for a in re.finditer(r'<a\b[^>]*data-lightbox[^>]*>', raw_nc):
            t = a.group(0)
            href_m = re.search(r'href="([^"]+)"', t)
            href = href_m.group(1) if href_m else ""
            for fname in CROP_REQUIRED:
                if fname in href:
                    errors.append(
                        f"{rel}: lightbox href vodi na sirovu '{fname}' — puno/nekropovano uvecanje otkriva zabranjen tekst "
                        f"(structure.md 0.2, mora linkovati na vec bezbednu/kropovanu verziju)  ...{t[:140]}..."
                    )

        # JSON-LD specificne provere
        for m in re.finditer(r'<script type="application/ld\+json">(.*?)</script>', raw, re.S):
            block = m.group(1)
            try:
                data = json.loads(block)
            except Exception as e:
                errors.append(f"{rel}: JSON-LD nevalidan: {e}")
                continue
            blob = json.dumps(data, ensure_ascii=False)
            if "aggregateRating" in blob:
                errors.append(f"{rel}: JSON-LD sadrzi 'aggregateRating' (mora biti odsutan, seo.md 0.5/6.6)")
            if not ALUMNI_NOVISAD and '"alumniOf"' in blob:
                errors.append(f"{rel}: JSON-LD sadrzi 'alumniOf' bez flaga ALUMNI_NOVISAD (structure.md 1)")

        # flagovane sekcije
        if not RADNO_VREME and "radno vreme" in n and 'data-flag="radno_vreme"' not in raw_nc:
            warns.append(f"{rel}: pominje 'radno vreme' — proveriti da je iza {{if RADNO_VREME}} (flag je False)")
        if not TESTIMONIALS and re.search(r"testimonijal|iskustv\w* pacijent", n):
            warns.append(f"{rel}: pominje testimonijale — komponenta ne sme postojati dok TESTIMONIALS=False")
        if TITULA_SPECIJALISTA:
            errors.append(f"{rel}: TITULA_SPECIJALISTA=True — zabranjeno dok klijent pismeno ne potvrdi (seo.md 0.1)")

        if len(re.findall(r"<h1[\s>]", raw_nc)) != 1:
            errors.append(f"{rel}: broj H1 != 1 ({len(re.findall(r'<h1[\\s>]', raw_nc))})")
        if re.search(r"\{\{|\}\}", raw_nc):
            errors.append(f"{rel}: neresen placeholder")
        for m in re.finditer(r'\balt="([^"]*)"', raw_nc):
            alt_n = norm(m.group(1))
            if "specijalist" in alt_n or "specialist" in alt_n:
                errors.append(f"{rel}: alt tekst sadrzi 'specijalista/specialist': {m.group(1)!r}")
            if len(m.group(1)) > 160:
                warns.append(f"{rel}: predugacak alt ({len(m.group(1))} zn.)")
        if "[POTVRDITI" in raw:
            warns.append(f"{rel}: {raw.count('[POTVRDITI')} x [POTVRDITI SA KLIJENTOM] u komentarima")

    if TITULA_SPECIJALISTA:
        errors.append("build.py: TITULA_SPECIJALISTA=True u kodu — vratiti na False (seo.md 0.1)")
    if DEMO:
        warns.append("DEMO=True (noindex + Disallow); pri objavi DEMO=False i pravi SITE_URL")
    if "DOMEN.rs" in SITE_URL:
        warns.append("SITE_URL je placeholder (https://DOMEN.rs) — zameniti pravim domenom pre objave")

    print(f"\nLINT: {len(errors)} gresaka, {len(warns)} upozorenja")
    for e in errors:
        print("  GRESKA    ", e)
    for w in warns:
        print("  upozorenje", w)
    return 1 if errors else 0


# ---------------------------------------------------------------- main
def main():
    global FLAGS
    kit = "--kit" in sys.argv
    do_lint = "--lint" in sys.argv
    SITE_DATA.update({k: html.escape(v, quote=False) for k, v in load_json("site.json").items()})
    if kit:
        FLAGS = {k: True for k in FLAGS}   # kit prikazuje sve (i sto je iza flagova)
        print("Kit (svi flagovi ukljuceni):")
        build_page(SRC / "pages" / "_kit.html", kit=True)
        print("Otvori: python -m http.server u ovom folderu, pa /_preview/")
        return 0
    OUT.mkdir(exist_ok=True)
    static = SRC / "static"
    if static.exists():
        for f in static.rglob("*"):
            rel = f.relative_to(static)
            # backend: nikad ne kopiraj tajne/lokalne podatke (config.php, baza, logovi, test .eml)
            if f.name in ("config.php", "fk-config.php") or f.suffix in (".db", ".sqlite", ".sqlite3", ".log", ".eml") \
                    or f.name.endswith(("-journal", "-wal", "-shm")) or rel.parts[:2] == ("data", "mail"):
                continue
            if f.is_file():
                dst = OUT / f.relative_to(static)
                dst.parent.mkdir(parents=True, exist_ok=True)
                shutil.copy2(f, dst)
    print("Stranice:")
    for page in sorted((SRC / "pages").rglob("*.html")):
        if page.name.startswith("_"):
            continue
        build_page(page)
    print("SEO / brend:")
    make_sitemap_robots()
    make_assets()
    print("Gotovo.")
    return lint() if do_lint else 0


if __name__ == "__main__":
    sys.exit(main())
