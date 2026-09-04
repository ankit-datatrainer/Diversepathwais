"""One-off helper: wires the flight layer into every static page.

Adds (idempotently) to each *.html at the repo root:
  * the three.js import map + module preload in <head>
  * assets/css/flight.css after award-motion.css
  * the take-off preloader markup right after <body>
  * the flight.js module script before main.js
"""
import io, os, re, sys

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
THREE = "https://cdn.jsdelivr.net/npm/three@0.170.0/build/three.module.js"

HEAD = (
    '<link rel="stylesheet" href="assets/css/flight.css"/>\n'
    '<script type="importmap">{"imports":{"three":"%s"}}</script>\n'
    '<link rel="modulepreload" href="%s" crossorigin/>\n'
) % (THREE, THREE)

LOADER = '''<div class="flight-loader" id="flight-loader" aria-hidden="true">
<span class="flight-loader__corner flight-loader__corner--tl">DEL &rarr; YYZ &middot; Boarding</span>
<div class="flight-loader__inner">
<svg class="flight-loader__sky" viewBox="0 0 680 230" aria-hidden="true">
<path class="flight-loader__route" d="M28 186 C 150 60, 330 40, 470 96 S 640 170, 654 150"/>
<path class="flight-loader__flown" d="M28 186 C 150 60, 330 40, 470 96 S 640 170, 654 150"/>
<circle class="flight-loader__pin" cx="28" cy="186" r="4"/>
<circle class="flight-loader__pin flight-loader__pin--end" cx="654" cy="150" r="5"/>
<g class="flight-loader__jet-group" transform="translate(28 186)">
<circle class="flight-loader__jet-glow" r="22"/>
<path class="flight-loader__jet" transform="rotate(90) translate(-12 -12) scale(1.15)" d="M21 16v-2l-8-5V3.5a1.5 1.5 0 0 0-3 0V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5z"/>
</g>
</svg>
<div class="flight-loader__brand"><span>Diverse <em>Pathwais</em></span></div>
<div class="flight-loader__meta"><span class="flight-loader__count">00</span><span>Preparing your journey</span></div>
<div class="flight-loader__bar"><i></i></div>
</div>
<span class="flight-loader__corner flight-loader__corner--br">Global mobility<br/>Est. 2025</span>
</div>
<noscript><style>.flight-loader{display:none}</style></noscript>
'''

MODULE = '<script type="module" src="assets/js/flight.js"></script>\n'

changed = []
for name in sorted(os.listdir(ROOT)):
    if not name.endswith('.html'):
        continue
    path = os.path.join(ROOT, name)
    s = io.open(path, encoding='utf-8').read()
    orig = s
    if 'assets/css/flight.css' not in s:
        s = s.replace('<link rel="stylesheet" href="assets/css/award-motion.css"/>\n',
                      '<link rel="stylesheet" href="assets/css/award-motion.css"/>\n' + HEAD, 1)
    if 'id="flight-loader"' not in s:
        s = re.sub(r'(<body[^>]*>\n)', lambda m: m.group(1) + LOADER, s, count=1)
    if 'assets/js/flight.js' not in s:
        s = s.replace('<script src="assets/js/main.js" defer></script>', MODULE + '<script src="assets/js/main.js" defer></script>', 1)
    if s != orig:
        io.open(path, 'w', encoding='utf-8', newline='\n').write(s)
        changed.append(name)
print('updated:', len(changed), changed)
