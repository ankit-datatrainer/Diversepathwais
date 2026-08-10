# Diverse Pathwais PVT LTD. — Website

Static marketing site for Diverse Pathwais PVT LTD., a global immigration and
visa consultancy. Plain HTML, CSS and JavaScript — no build step, no framework,
no runtime dependencies.

## Stack

- **HTML** — 20 hand-generated static pages
- **CSS** — one stylesheet, custom properties for the design tokens
- **JS** — one vanilla file (~10 KB), no libraries
- **Fonts** — Inter, self-hosted as a variable font (no third-party requests)

Total payload is about 1.2 MB including every image.

## Local preview

Any static server works:

```bash
python -m http.server 8000
# then open http://localhost:8000
```

Opening `index.html` directly from disk also works.

## Deploying to Vercel

The repo is deploy-ready with no configuration:

1. Import the repository in Vercel.
2. Framework preset: **Other**. Leave build command and output directory empty.
3. Deploy.

`vercel.json` sets:

- long-lived immutable caching for `/assets/img` and `/assets/fonts`
- security headers (HSTS, `X-Content-Type-Options`, `Referrer-Policy`, …)
- a rewrite so `/about-us` serves `about-us.html`, which keeps the previous
  WordPress URLs (`/about-us/`, `/student-visa/`, …) working after the switch
- short redirects: `/about`, `/contact`, `/careers`, `/reviews`

`404.html` is picked up automatically by Vercel for unknown paths.

## Structure

```
├── index.html                  home
├── about-us.html
├── skilled-worker-visa.html    student-visa.html     family-visa.html
├── visitor-visa.html           work-permit.html
├── consultation.html           eligibility-assessment.html
├── application-processing.html
├── contact-us.html
├── disclaimers.html   privacy-policy.html   terms-and-conditions.html
├── feedback.html      refer-a-friend.html   careers-at-diverse-pathwais.html
├── diverse-pathwais-reviews.html            corporate-emails.html
├── 404.html
├── robots.txt         sitemap.xml           vercel.json
└── assets/
    ├── css/style.css
    ├── js/main.js
    ├── fonts/         Inter variable woff2 (latin, latin-ext)
    └── img/           logos, flags, visa and article imagery
```

## Design tokens

All colours, spacing, radii, shadows and the type scale live in the `:root`
block at the top of `assets/css/style.css`. The two brand hues are:

```css
--navy: #14396f;   /* primary */
--gold: #f0a500;   /* accent  */
```

Typography is Inter throughout, with near-black headings (`--heading`) and
muted grey body copy (`--muted`).

## Motion

Scroll reveals are driven by a single `IntersectionObserver`. Add
`data-anim="up|down|left|right|zoom|pop|mask|reveal"` to any element to opt it
in, and wrap a group in `data-anim-group="90"` to stagger its children by 90 ms
each. Every animation is disabled automatically under
`prefers-reduced-motion: reduce`.

## Known limitation — forms

The enquiry, feedback, referral and eligibility forms are **front-end only**.
They validate input and show a confirmation, but nothing is transmitted
anywhere. Before launch, point each `<form>` at a real handler (Formspree, a
Vercel serverless function, or your CRM). Each form is marked with an HTML
comment at the point where the endpoint belongs.

## Changing the domain

Canonical URLs, Open Graph tags, the JSON-LD block and `sitemap.xml` all
reference `https://diversepathwais.com`. If the site is served from a different
origin, update that value and regenerate, or search and replace across the HTML
files, `sitemap.xml` and `robots.txt`.
