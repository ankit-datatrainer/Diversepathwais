# Diverse Pathwais — Laravel website + Super Admin

Laravel 12 port of the static site in the parent folder. Every page renders the
same markup, CSS, animations and 3D flight layer as the original; the SEO tags,
blog and form submissions now come from MySQL.

## Run it locally

1. Start **MySQL** in the XAMPP control panel (phpMyAdmin: http://localhost/phpmyadmin/).
   The app uses database `diverse_pathwais` on `127.0.0.1:3307`, user `root`, no password (see `.env`).
2. Double-click `start-server.bat`, or run:

   ```bash
   php artisan serve --port=8000
   ```

3. Website: http://127.0.0.1:8000 · Admin: http://127.0.0.1:8000/admin

Fresh install on another machine: `composer install`, copy `.env.example` to `.env`,
set the DB values, then `php artisan key:generate` and `php artisan migrate --seed`.
The seeders are safe to run again, because they never overwrite SEO you have edited.

## Super admin login

The seeder creates the super admin from `ADMIN_EMAIL` and `ADMIN_PASSWORD` in `.env`.
These values are never committed. If `ADMIN_PASSWORD` is empty, `php artisan db:seed`
generates a random password and prints it once. After that, change the password in
Admin → My Account. Re-seeding never resets an existing admin's password.

## What the admin panel does

- **Dashboard**: SEO score, page/blog/enquiry counts, latest enquiries, setup checklist.
- **SEO Dashboard**: every page and blog post scored out of 100, with the top issue and a “Fix” link.
- **Pages SEO**: per page, you can edit the SEO title, meta description, keywords, focus keyword,
  Open Graph/Twitter title, description and image, robots (index/noindex), canonical URL,
  JSON-LD structured data, and the sitemap priority and frequency. A live Google and social preview is included.
- **Blogs**: create, edit and delete posts with a rich-text editor (inline image upload), slug,
  excerpt, category, tags, featured image, draft/published/scheduled status, and the same full SEO
  fields as pages. BlogPosting and Breadcrumb schema are generated automatically.
- **Enquiries**: every website form (home, contact, eligibility, feedback, refer a friend) is saved
  here. You can mark entries read or unread, reply by email or WhatsApp, or delete them.
- **Global SEO Settings**: site name, canonical domain, default share image, Google/Bing
  verification, GA4 ID, robots.txt, and custom head/body code.

When you're logged in as admin, every public page shows an **Edit SEO** button in the bottom-left corner.

## Public URLs

`/`, `/about-us`, `/student-visa`, … (the old `*.html` URLs 301-redirect to these) ·
`/blog`, `/blog/{slug}` · `/sitemap.xml` and `/robots.txt` (both generated) · `/enquiry` (form POST).

## Tests

```bash
php artisan test
```

Tests run on an in-memory SQLite database and never touch MySQL.

## Notes

- Page bodies live in `resources/views/pages/*.blade.php`; header, footer and loader live in `resources/views/partials/`.
- `public/assets/css/responsive.css` must stay the **last** stylesheet (see `layouts/site.blade.php`).
- Admin CSS/JS live in `public/assets/admin/`. Never create a `public/admin/` folder:
  it would shadow the `/admin` route.
- Before going live: set `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL`, and set the canonical domain in Global SEO Settings.
