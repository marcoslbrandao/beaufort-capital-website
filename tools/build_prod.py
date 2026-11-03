#!/usr/bin/env python3
"""Build the production package for beaufortcapital.co.uk (123Reg / Apache).

Source: docs/ (exactly what the client approved on GitHub Pages).
Output: dist/public_html/  +  dist/beaufort-site-<date>.zip

What it changes compared with docs/:
  * clean URLs: internal links "about-us.html" -> "/about-us", "index.html" -> "/"
  * <link rel="canonical"> + og:url pointing at https://www.beaufortcapital.co.uk
  * meta description on Home (the only page without one)
  * a real 404 page (docs/404.html is the GitHub "in development" holding page)
  * leaves out holding pages and unused files (awards.html, assets/css, assets/js)
  * adds .htaccess (HTTPS, clean URLs, 301s from the old site), robots.txt, sitemap.xml
"""
import datetime, pathlib, re, shutil, sys, time, zipfile

REPO = pathlib.Path(__file__).resolve().parent.parent
SRC = REPO / "docs"
DIST = REPO / "dist"
OUT = DIST / "public_html"
SITE = "https://www.beaufortcapital.co.uk"

PAGES = ["index", "about-us", "development-finance", "equity-investment", "asset-classes",
         "transactions", "news", "contact", "esg", "legal-information", "cookie-policy"]
SKIP_PAGES = {"awards.html", "404.html"}          # holding pages on the preview
SKIP_ASSET_DIRS = {"css", "js"}                   # placeholders, not referenced by any page

HOME_DESCRIPTION = ("Award-winning UK development finance. Senior and Stretched Senior "
                    "development finance from £10m to £150m, mezzanine facilities from £3m "
                    "and equity investment up to £30m.")

LINK_RE = re.compile(r'(?<=["\'])(' + "|".join(map(re.escape, PAGES)) + r')\.html(?=[#"\'])')


PREVIEW_NOINDEX_RE = re.compile(r'<meta name="robots" content="noindex, nofollow"><!-- preview only[^>]*-->\n?')


def clean_links(text):
    return LINK_RE.sub(lambda m: "/" if m.group(1) == "index" else "/" + m.group(1), text)


def add_head_tags(html, page):
    url = SITE + ("/" if page == "index" else "/" + page)
    tags = f'<link rel="canonical" href="{url}">\n<meta property="og:url" content="{url}">\n'
    if page == "index" and 'name="description"' not in html:
        tags += f'<meta name="description" content="{HOME_DESCRIPTION}">\n'
    return html.replace("</head>", tags + "</head>", 1)


def build_404(template):
    """Use the Legal Information page as the shell (same header/footer), swap the content."""
    html = template
    start = html.index("<!-- PAGE HEADER -->")
    end = html.index("<!-- FOOTER -->")
    body = """<!-- PAGE HEADER -->
<section class="page-header">
  <div class="wrap">
    <h1>Page not found.</h1>
    <p>The page you were looking for has moved or no longer exists.</p>
  </div>
</section>

<section class="prose-section">
  <div class="wrap">
    <p>You can find our development finance, equity investment, transactions and news using the menu above, or go back to the <a href="/">home page</a>.</p>
    <p>If you need to speak to us, please visit the <a href="/contact">Contact</a> page.</p>
  </div>
</section>

"""
    html = html[:start] + body + html[end:]
    html = re.sub(r"<title>.*?</title>", "<title>Page not found — Beaufort Capital</title>", html, count=1, flags=re.S)
    html = re.sub(r'<meta name="description"[^>]*>', '<meta name="robots" content="noindex">', html, count=1)
    # served from any depth (e.g. /news/old-post/): make relative asset paths resolve from the root
    html = html.replace("<head>", '<head>\n<base href="/">', 1)
    html = html.replace(' aria-current="page"', "")
    return html


def main():
    if OUT.exists():
        shutil.rmtree(OUT)
    OUT.mkdir(parents=True)

    # pages
    for page in PAGES:
        html = (SRC / f"{page}.html").read_text(encoding="utf-8")
        html = PREVIEW_NOINDEX_RE.sub("", html)          # the GitHub preview is noindex; the live site is not
        html = add_head_tags(clean_links(html), page)
        (OUT / f"{page}.html").write_text(html, encoding="utf-8")
    legal = (OUT / "legal-information.html").read_text(encoding="utf-8")
    legal = re.sub(r'<link rel="canonical"[^>]*>\n<meta property="og:url"[^>]*>\n', "", legal)
    (OUT / "404.html").write_text(build_404(legal), encoding="utf-8")

    # assets
    for item in (SRC / "assets").iterdir():
        if item.is_dir() and item.name in SKIP_ASSET_DIRS:
            continue
        dest = OUT / "assets" / item.name
        if item.is_dir():
            shutil.copytree(item, dest, ignore=shutil.ignore_patterns(".DS_Store"))
        else:
            dest.parent.mkdir(parents=True, exist_ok=True)
            shutil.copy2(item, dest)
    for js in (OUT / "assets" / "data").glob("*.js"):
        js.write_text(clean_links(js.read_text(encoding="utf-8")), encoding="utf-8")
    for fav in ("favicon.ico",):
        shutil.copy2(SRC / "assets" / "img" / fav, OUT / fav)   # browsers ask for /favicon.ico

    # server files
    shutil.copy2(REPO / "tools" / "htaccess.prod", OUT / ".htaccess")
    (OUT / "robots.txt").write_text(f"User-agent: *\nDisallow:\n\nSitemap: {SITE}/sitemap.xml\n")
    today = datetime.date.today().isoformat()
    urls = "".join(
        f"  <url><loc>{SITE}{'/' if p == 'index' else '/' + p}</loc><lastmod>{today}</lastmod></url>\n"
        for p in PAGES)
    (OUT / "sitemap.xml").write_text(
        '<?xml version="1.0" encoding="UTF-8"?>\n'
        '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n' + urls + "</urlset>\n")

    # leftover check: no internal *.html links should remain
    left = []
    for f in list(OUT.glob("*.html")) + list((OUT / "assets" / "data").glob("*.js")):
        for m in re.finditer(r'(?<=["\'])[a-z-]+\.html(?=[#"\'])', f.read_text(encoding="utf-8")):
            left.append(f"{f.name}: {m.group(0)}")
    if left:
        print("WARNING internal .html links left:", *left[:20], sep="\n  ")
    noindex = [f.name for f in OUT.glob("*.html") if f.name != "404.html" and "noindex" in f.read_text(encoding="utf-8")]
    if noindex:
        sys.exit("ERROR: noindex left in production pages: " + ", ".join(noindex))

    zpath = DIST / f"beaufort-site-{today}.zip"
    # Fixed permissions inside the zip: 644 files, 755 folders. Files on the Mac are 600/700 and
    # cPanel keeps the zip's permissions when extracting -> 403 on the whole site (go-live, 3 Nov 2026).
    with zipfile.ZipFile(zpath, "w", zipfile.ZIP_DEFLATED) as z:
        for f in sorted(OUT.rglob("*")):
            rel = f.relative_to(OUT).as_posix()
            if f.is_dir():
                zi = zipfile.ZipInfo(rel + "/", date_time=time.localtime(f.stat().st_mtime)[:6])
                zi.external_attr = (0o40755 << 16) | 0x10
                z.writestr(zi, b"")
            elif f.is_file():
                zi = zipfile.ZipInfo.from_file(f, rel)
                zi.external_attr = 0o100644 << 16
                zi.compress_type = zipfile.ZIP_DEFLATED
                z.writestr(zi, f.read_bytes())
    n = sum(1 for f in OUT.rglob("*") if f.is_file())
    size = sum(f.stat().st_size for f in OUT.rglob("*") if f.is_file())
    print(f"Built {OUT} — {n} files, {size/1e6:.1f} MB -> {zpath.name} ({zpath.stat().st_size/1e6:.1f} MB)")


if __name__ == "__main__":
    sys.exit(main())
