#!/bin/bash
# Builds the Home hero carousel images (desktop 1920w + mobile 1000w portrait-friendly) from originals.
# Usage: tools/make_hero_images.sh <folder-with-originals>
set -e
SRC="${1:-Claude outputs/carousel-candidates}"
OUT=docs/assets/img/hero
mkdir -p "$OUT"
mk(){ # name source
  convert "$2" -strip -resize '1920x>' -interlace Plane -sampling-factor 4:2:0 -quality 80 "$OUT/hero-$1.jpg"
  convert "$2" -strip -resize "1200x>" -interlace Plane -quality 78 "$OUT/hero-$1-m.jpg"   # mobile: full photo, framed in CSS (--pos-m/--size-m)
}
mk essex          "$SRC/beaufort-hero-2022-chelmsford2.png" center
mk bristol        "$SRC/beaufort-hero-bristol01.jpg" center
mk north-london   "$SRC/beaufort-hero-2022-north-london1.png" west
mk leicestershire "docs/assets/img/hero-industrial.jpg" west
mk hertfordshire  "$SRC/beaufort-hero-cheshunt01.jpg" center
mkdir -p assets/img/hero && cp "$OUT"/* assets/img/hero/
ls -la "$OUT"
