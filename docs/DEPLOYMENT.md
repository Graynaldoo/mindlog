# Deployment MindLog Smart Education

1. Siapkan server PHP 8.2+, Composer, Node.js, database, dan web server.
2. Clone repository dan arahkan document root ke folder `public`.
3. Jalankan dependency production:

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
```

4. Set environment production:

```bash
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

5. Isi konfigurasi database, mail, `APP_URL`, dan `APP_ENV=production`.
6. Migrasi dan optimasi:

```bash
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

7. Pastikan permission folder `storage` dan `bootstrap/cache` dapat ditulis oleh web server.
