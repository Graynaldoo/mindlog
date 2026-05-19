# MindLog 🧠
> Platform Journaling & Mental Health Tracker
> UAS Pemrograman API + Web Lanjut

---

## 🚀 Cara Setup dari Nol

### 1. Buat project Laravel baru
```bash
composer create-project laravel/laravel mindlog
cd mindlog
```

### 2. Install dependencies
```bash
# Laravel Breeze (auth)
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run dev

# JWT Auth
composer require tymon/jwt-auth
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
php artisan jwt:secret
```

### 3. Setup database
Edit file `.env`:
```
DB_DATABASE=mindlog
DB_USERNAME=root
DB_PASSWORD=
```

Buat database di MySQL:
```sql
CREATE DATABASE mindlog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4. Copy semua file dari projek ini ke folder Laravel

Struktur penempatan file:

```
mindlog/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── AuthController.php      ← dari controllers/Api/
│   │   │   │   └── JournalController.php
│   │   │   └── Web/
│   │   │       ├── DashboardController.php ← dari controllers/Web/
│   │   │       └── JournalController.php
│   │   └── Middleware/
│   │       └── ApiKeyMiddleware.php        ← dari middleware/
│   ├── Models/
│   │   ├── User.php                        ← dari models/ (replace yang ada)
│   │   ├── Journal.php
│   │   ├── Mood.php
│   │   └── Streak.php
│   ├── Providers/
│   │   └── AppServiceProvider.php          ← dari config/ (replace yang ada)
│   └── Repositories/
│       ├── JournalRepositoryInterface.php  ← dari repositories/
│       ├── JournalRepository.php
│       └── StreakRepository.php
├── database/
│   ├── migrations/                         ← dari migrations/ (semua 4 file)
│   └── seeders/
│       └── MoodSeeder.php                  ← dari seeders/
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php                   ← dari views/layouts/
│   ├── components/
│   │   ├── mood-picker.blade.php           ← dari views/components/
│   │   ├── streak-card.blade.php
│   │   └── journal-card.blade.php
│   ├── dashboard.blade.php                 ← dari views/
│   └── journal/
│       ├── index.blade.php                 ← dari views/journal/
│       ├── create.blade.php
│       ├── show.blade.php
│       └── edit.blade.php
└── routes/
    ├── api.php                             ← dari routes/ (replace yang ada)
    └── web.php                             ← dari routes/ (replace yang ada)
```

### 5. Daftarkan Middleware di bootstrap/app.php
```php
// bootstrap/app.php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'api.key' => \App\Http\Middleware\ApiKeyMiddleware::class,
    ]);
})
```

### 6. Setup JWT di config/auth.php
```php
'guards' => [
    'api' => [
        'driver'   => 'jwt',
        'provider' => 'users',
    ],
],
```

### 7. Jalankan migrasi & seeder
```bash
php artisan migrate
php artisan db:seed --class=MoodSeeder
```

### 8. Jalankan server
```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

Buka: http://localhost:8000

---

## 📮 Postman Collection — Cara Testing API

### Base URL
```
http://localhost:8000/api
```

### 1. Register
```
POST /api/auth/register
Content-Type: application/json

{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```
Response akan mengembalikan `access_token` dan `api_key`.

### 2. Login (Basic Auth → JWT)
```
POST /api/auth/login
Content-Type: application/json

{
    "email": "test@example.com",
    "password": "password123"
}
```
Simpan `access_token` sebagai Bearer Token di Postman.

### 3. Buat Jurnal (JWT)
```
POST /api/journals
Authorization: Bearer {token}
Content-Type: application/json

{
    "mood_id": 1,
    "title": "Hari yang menyenangkan",
    "content": "Hari ini saya merasa sangat produktif...",
    "journal_date": "2024-01-15",
    "is_private": true
}
```

### 4. Lihat Jurnal (API Key)
```
GET /api/v2/journals
X-API-Key: ml_xxxxxxxxxxxxxxxxxxxxxxxx
```

### 5. Statistik Mingguan
```
GET /api/journals/stats/weekly
Authorization: Bearer {token}
```

---

## 🔗 SDGs yang Dipenuhi
- **SDG 3: Good Health & Well-being** — Platform mendukung kesehatan mental masyarakat
- **SDG 4: Quality Education** — Literasi kesehatan mental melalui journaling
- **SDG 10: Reduced Inequalities** — Akses gratis untuk semua kalangan

---

## 📋 Checklist Fitur UAS

### Pemrograman API ✅
- [x] Framework Laravel
- [x] Migrasi & relasi antar tabel (4 tabel)
- [x] JWT Authorization (Basic Auth + API Key)
- [x] Testing API dengan Postman
- [x] Dokumentasi API (README ini)
- [ ] OAuth2 (opsional)

### Web Lanjut ✅
- [x] Laravel Breeze (Authentication & Authorization)
- [x] Blade Components (mood-picker, streak-card, journal-card)
- [x] Repository Pattern (JournalRepository + StreakRepository)
- [x] Tema: Inovasi TIK untuk mencerdaskan masyarakat
- [x] Dampak terukur (mood score analytics)
- [x] Screenshot mockup interface
