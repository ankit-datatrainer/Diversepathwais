# Diverse Pathwais — Laravel website + Super Admin

Laravel 12 (PHP 8.2+, MySQL/MariaDB). The public site keeps the original design,
animations and 3D flight layer; SEO, blog and form submissions are managed from
the super admin panel at `/admin`.

## Run locally (XAMPP)

1. Start **MySQL** in XAMPP (phpMyAdmin: http://localhost/phpmyadmin/). The app uses
   database `diverse_pathwais` on `127.0.0.1:3307`, user `root` (see `.env`).
2. Double-click `start-server.bat`, or run `php artisan serve --port=8000`.
3. Website: http://127.0.0.1:8000 · Admin: http://127.0.0.1:8000/admin

Fresh machine: `composer install`, copy `.env.example` to `.env`, set DB values,
`php artisan key:generate`, `php artisan migrate --seed`.
The admin login comes from `ADMIN_EMAIL` / `ADMIN_PASSWORD` in `.env` (never committed).

## Deploy to Hostinger (shared hosting)

The project root is the web root: upload everything into `public_html`. The root
`.htaccess` sends all traffic to `public/` and returns 403 for `.env`, `vendor/`,
`storage/`, source code and other internals.

1. **hPanel → Advanced → PHP Configuration**: select **PHP 8.2 or newer**.
2. **hPanel → Databases**: create the MySQL database + user, then open phpMyAdmin
   and **Import** the SQL export (all tables, pages SEO, blog posts, admin user).
3. **File Manager → public_html**: delete the old files, upload the deployment zip,
   **Extract** it in place (`.htaccess`, `.env`, `app/`, `public/`, `vendor/` … must
   sit directly inside `public_html`).
4. Make sure `storage/` and `bootstrap/cache/` are writable (755 folders is normal on Hostinger).
5. Open the site. Admin is at `/admin`.

A deployment build is made by copying the tracked files, adding the production
`.env`, and running `composer install --no-dev --optimize-autoloader`
(`composer.json` pins `platform.php` to 8.2 so the vendor folder runs on PHP 8.2+).

### If you see “HTTP ERROR 500”

- PHP version below 8.2 → switch it in hPanel.
- Wrong DB values in `.env` (on Hostinger `DB_HOST=localhost`, port `3306`).
- `.env` missing or `APP_KEY` empty.
- Check `storage/logs/laravel-*.log` in File Manager for the exact error.

## What the admin panel does

- **Dashboard**: KPIs, 14-day enquiries chart, SEO health, latest enquiries.
- **SEO Dashboard**: every page and post scored out of 100 with fixes.
- **Pages SEO**: title, description, keywords, Open Graph, robots, canonical, JSON-LD, sitemap.
- **Blogs**: rich-text editor, slugs, categories, scheduling, per-post SEO.
- **Enquiries**: every website form submission.
- **Global SEO Settings**: canonical domain, verification codes, GA4, robots.txt.
- `Ctrl+K` opens quick search from any admin screen.

## Notes

- Page bodies: `resources/views/pages/*.blade.php`; header/footer/loader: `resources/views/partials/`.
- `public/assets/css/responsive.css` must stay the **last** stylesheet.
- Admin CSS/JS live in `public/assets/admin/`. Never create a `public/admin/` folder:
  it would shadow the `/admin` route.
- Tests: `php artisan test` (in-memory SQLite, never touches MySQL).
