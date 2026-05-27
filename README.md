# MindLog Smart Education

MindLog Smart Education adalah platform Laravel untuk jurnal harian, konten edukasi, analitik produktivitas, dan pengukuran dampak TIK terhadap masyarakat. Project ini dikembangkan dari repository yang sudah ada, jadi tidak perlu membuat project Laravel baru.

## Fitur Utama

- Authentication web: register, login, logout, forgot password, remember me.
- Authorization role: Admin, User, Educator dengan middleware dan policy.
- Daily Journal: mood tracker, aktivitas harian, catatan, skor produktivitas, durasi aktivitas.
- Edu Content Center: artikel, video, dan tips produktivitas melalui endpoint `/api/education`.
- Smart Analytics Dashboard: statistik jurnal, mood mingguan, produktivitas, aktivitas, dan ChartJS pada dashboard web.
- Social Impact Measurement: tabel `impact_metrics` dihitung dari query database.
- Leaderboard edukasi: user paling aktif, jurnal terbanyak, dan konsistensi tertinggi.
- API auth: JWT, Basic Auth, dan API Key berbasis tabel `api_keys`.
- Repository pattern: User, Journal, Education, Analytics, Article, Category, Statistics.

## Instalasi Lokal

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
php artisan migrate --seed
npm run build
php artisan serve
```

Default akun seeder:

- Admin: `admin@mindlog.test` / `password`
- Educator: `educator@mindlog.test` / `password`
- User: `user@mindlog.test` / `password`

## Endpoint API Wajib

Base URL lokal: `http://localhost:8000/api`

- `POST /register`
- `POST /login`
- `POST /logout`
- `POST /refresh`
- `GET /profile`
- `GET /journals`
- `POST /journals`
- `PUT /journals/{id}`
- `DELETE /journals/{id}`
- `GET /education`
- `POST /education`
- `GET /statistics`
- `GET /impact`
- `GET /leaderboard`

API Key:

- `POST /api-keys`
- `DELETE /api-keys/{id}`
- `GET /key/validate` dengan header `X-API-Key`

Swagger tersedia di `/api/documentation`. Postman collection tersedia di `postman_collection.json`.

## Deployment Ringkas

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Pastikan `APP_KEY`, `JWT_SECRET`, konfigurasi database, mail, dan web server document root mengarah ke folder `public`.
