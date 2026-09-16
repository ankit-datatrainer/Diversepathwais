"""Wires the responsive layer into every static page (idempotent).

 * links assets/css/responsive.css last, after flight.css
 * wraps the secondary topbar phone number so it can be hidden on phones
"""
import io, os, re

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
LINK = '<link rel="stylesheet" href="assets/css/responsive.css"/>\n'

# " / <a href="tel:...">+91 ...</a>"  ->  wrapped in a hideable span
ALT_TEL = re.compile(r'(\s*/\s*)(<a href="tel:[^"]+">[^<]+</a>)(?!</span>)')

changed, tel_wrapped = [], []
for name in sorted(os.listdir(ROOT)):
    if not name.endswith('.html'):
        continue
    path = os.path.join(ROOT, name)
    s = io.open(path, encoding='utf-8').read()
    orig = s

    if 'assets/css/responsive.css' not in s:
        if '<link rel="stylesheet" href="assets/css/flight.css"/>\n' in s:
            s = s.replace('<link rel="stylesheet" href="assets/css/flight.css"/>\n',
                          '<link rel="stylesheet" href="assets/css/flight.css"/>\n' + LINK, 1)
        else:  # fall back to after award-motion
            s = s.replace('<link rel="stylesheet" href="assets/css/award-motion.css"/>\n',
                          '<link rel="stylesheet" href="assets/css/award-motion.css"/>\n' + LINK, 1)

    if 'tel-alt' not in s:
        new, n = ALT_TEL.subn(lambda m: '<span class="tel-alt">%s%s</span>' % (m.group(1), m.group(2)), s, count=1)
        if n:
            s = new
            tel_wrapped.append(name)

    if s != orig:
        io.open(path, 'w', encoding='utf-8', newline='\n').write(s)
        changed.append(name)

print('linked responsive.css / updated:', len(changed))
print('secondary tel wrapped in:', len(tel_wrapped), tel_wrapped[:5])
