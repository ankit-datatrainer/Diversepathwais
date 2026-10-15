@echo off
REM Starts the Diverse Pathwais Laravel site at http://127.0.0.1:8000
REM Requires XAMPP MySQL running (phpMyAdmin: http://localhost/phpmyadmin/)
cd /d "%~dp0"
php artisan serve --host=127.0.0.1 --port=8000
