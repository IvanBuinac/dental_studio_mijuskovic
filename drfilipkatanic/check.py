#!/usr/bin/env python3
"""QA provera za izgradjeni site/ (dr Filip Katanic) — dopuna build.py --lint (koji proverava
sadrzajna/brend pravila). Ovaj skript proverava tehnicku ispravnost izlaza:

    python check.py

Provere:
  1. Interni linkovi (href/src) — da li ciljni fajl/direktorijum postoji na disku (bez potrebe za
     pokrenutim http serverom); eksterni linkovi (http/https/mailto/tel) se preskacu.
  2. Svaka <img> ima alt, width i height; sve osim hero/LCP slika (fetchpriority=high) imaju
     loading="lazy".
  3. Tacno jedan <h1> po stranici.
  4. <title>, <meta name="description">, <link rel="canonical"> prisutni (kad stranica nije 404).
  5. Svaki <script type="application/ld+json"> je validan JSON.
  6. sitemap.xml postoji, valjan XML, i sadrzi bar toliko <url> koliko ima html stranica
     (osim 404 i eksplicitno noindex-ovanih).

Exit kod 1 ako ima gresaka, 0 ako je sve u redu (upozorenja ne menjaju exit kod).
"""
import glob
import re
import sys
import xml.etree.ElementTree as ET
from pathlib import Path

ROOT = Path(__file__).resolve().parent
SITE = ROOT / "site"


def read(p: Path) -> str:
    return p.read_text(encoding="utf-8")


def check_links(errors, warns):
    for f in sorted(SITE.rglob("*.html")):
        txt = read(f)
        page_dir = f.parent
        for m in re.finditer(r'(?:href|src)="([^"]+)"', txt):
            u = m.group(1)
            if u.startswith(("http://", "https://", "mailto:", "tel:", "#", "data:")):
                continue
            target = u.split("#")[0].split("?")[0]
            if not target:
                continue
            if target.startswith("/"):
                resolved = SITE / target.lstrip("/")
            else:
                resolved = (page_dir / target).resolve()
            if resolved.is_dir():
                resolved = resolved / "index.html"
            if not resolved.exists():
                errors.append(f"{f.relative_to(SITE)}: mrtav link '{u}' -> {resolved}")


def check_images(errors, warns):
    for f in sorted(SITE.rglob("*.html")):
        txt = read(f)
        for m in re.finditer(r"<img\b[^>]*>", txt):
            tag = m.group(0)
            if 'alt="' not in tag:
                errors.append(f"{f.relative_to(SITE)}: <img> bez alt  ...{tag[:90]}...")
            if "width=" not in tag or "height=" not in tag:
                errors.append(f"{f.relative_to(SITE)}: <img> bez width/height  ...{tag[:90]}...")
            if 'loading="lazy"' not in tag and 'fetchpriority="high"' not in tag:
                warns.append(f"{f.relative_to(SITE)}: <img> bez loading=lazy i bez fetchpriority=high (proveriti da li je namerno)  ...{tag[:90]}...")


def check_h1(errors):
    for f in sorted(SITE.rglob("*.html")):
        txt = read(f)
        n = len(re.findall(r"<h1[\s>]", txt))
        if n != 1:
            errors.append(f"{f.relative_to(SITE)}: {n} h1 tagova (ocekivano tacno 1)")


def check_seo_tags(errors, warns):
    for f in sorted(SITE.rglob("*.html")):
        txt = read(f)
        if not re.search(r"<title>.*?</title>", txt, re.S):
            errors.append(f"{f.relative_to(SITE)}: nema <title>")
        if not re.search(r'<meta name="description" content="[^"]+"', txt):
            warns.append(f"{f.relative_to(SITE)}: nema meta description")
        if f.name != "404.html" and not re.search(r'<link rel="canonical"', txt):
            warns.append(f"{f.relative_to(SITE)}: nema canonical (ocekivano ako je noindex namerno)")


def check_jsonld(errors):
    import json
    for f in sorted(SITE.rglob("*.html")):
        txt = read(f)
        for m in re.finditer(r'<script type="application/ld\+json">(.*?)</script>', txt, re.S):
            try:
                json.loads(m.group(1))
            except Exception as e:
                errors.append(f"{f.relative_to(SITE)}: nevalidan JSON-LD: {e}")


def check_sitemap(errors, warns):
    sm = SITE / "sitemap.xml"
    if not sm.exists():
        errors.append("sitemap.xml ne postoji")
        return
    try:
        tree = ET.parse(sm)
    except ET.ParseError as e:
        errors.append(f"sitemap.xml nije valjan XML: {e}")
        return
    ns = {"s": "http://www.sitemaps.org/schemas/sitemap/0.9"}
    urls = tree.getroot().findall("s:url/s:loc", ns)
    n_sitemap = len(urls)
    html_pages = [f for f in SITE.rglob("*.html") if f.name != "404.html"]
    n_pages = len(html_pages)
    if n_sitemap < n_pages:
        warns.append(f"sitemap.xml ima {n_sitemap} URL-ova, a postoji {n_pages} html stranica (osim 404) — proveriti da li su razlike namerne (npr. noindex)")


def main():
    if not SITE.exists():
        print("site/ ne postoji — prvo pokreni: python build.py")
        return 1
    errors, warns = [], []
    check_links(errors, warns)
    check_images(errors, warns)
    check_h1(errors)
    check_seo_tags(errors, warns)
    check_jsonld(errors)
    check_sitemap(errors, warns)

    print(f"CHECK: {len(errors)} gresaka, {len(warns)} upozorenja")
    for e in errors:
        print("  GRESKA    ", e)
    for w in warns:
        print("  upozorenje", w)
    return 1 if errors else 0


if __name__ == "__main__":
    sys.exit(main())
