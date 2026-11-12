#!/bin/bash
# Builds the Home hero carousel images (desktop 1920w + mobile 1000w portrait-friendly) from originals.
# Usage: tools/make_hero_images.sh <folder-with-originals>
set -e
SRC="${1:-Claude outputs/carousel-candidates}"
OUT=docs/assets/img/hero
mkdir -p "$OUT"
# Livelier photos (Paul, 12 Nov 2026): a little brighter, more colour, gentle contrast, light sharpening
ENH="-modulate 107,118,100 -sigmoidal-contrast 2.5x42% -unsharp 0x0.8+0.6+0.02"
mk(){ # name source
  convert "$2" -strip -resize '1920x>' $ENH -interlace Plane -sampling-factor 4:2:0 -quality 80 "$OUT/hero-$1.jpg"
  convert "$2" -strip -resize "1200x>" $ENH -interlace Plane -quality 78 "$OUT/hero-$1-m.jpg"   # mobile: full photo, framed in CSS (--pos-m/--size-m)
}
mk essex          "$SRC/beaufort-hero-2022-chelmsford2.png" center
mk bristol        "$SRC/beaufort-hero-bristol01.jpg" center
mk north-london   "$SRC/beaufort-hero-2022-north-london1.png" west
mk leicestershire "docs/assets/img/hero-industrial.jpg" west
mk hertfordshire  "$SRC/beaufort-hero-cheshunt01.jpg" center
mkdir -p assets/img/hero && cp "$OUT"/* assets/img/hero/
ls -la "$OUT"
