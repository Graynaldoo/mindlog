# MindLog EduSmart

## Daftar Perubahan Pengembangan

Fitur lama yang dipertahankan:
- Register, login, logout dari Laravel Breeze.
- Jurnal harian pengguna dengan mood.
- Streak harian pengguna.
- Dashboard dasar dan API jurnal JWT yang sudah ada.
- Repository jurnal sebagai dasar penerapan Repository Pattern.

Fitur baru yang ditambahkan:
- Role Admin, Educator, dan User.
- Permission, middleware role, policy, dan Gate.
- Artikel edukasi, kategori pembelajaran, literasi digital, dan fokus SDGs.
- Statistik perkembangan pengguna dan dashboard dampak penggunaan berbasis database.
- API lengkap untuk auth, jurnal, artikel, kategori, dan statistik.
- JWT Authorization, Basic Auth, dan API Key.
- L5 Swagger, Postman collection, dan Postman environment.
- Blade Component: Navbar, Sidebar, Dashboard Card, Statistics Card, Alert, Form Input.
- Repository Pattern dengan folder `app/Interfaces` dan `app/Repositories`.
- Tabel `roles`, `permissions`, `activity_logs`, `articles`, `categories`, dan `statistics`.

## Struktur Folder Penting

```text
app/
  Http/Controllers/Api/
  Http/Controllers/Web/
  Http/Controllers/Web/Admin/
  Http/Middleware/
  Interfaces/
  Models/
  Policies/
  Repositories/
config/
  l5-swagger.php
database/
  migrations/
  seeders/
resources/views/
  admin/
  articles/
  components/
  journal/
  statistics/
routes/
  api.php
  web.php
docs/
  LAPORAN_MINDLOG_EDUSMART.md
postman_collection.json
postman_environment.json
```

## BAB 1 Pendahuluan

MindLog EduSmart adalah pengembangan dari aplikasi MindLog yang sebelumnya berfokus pada jurnal dan refleksi mood. Pengembangan ini mengubah MindLog menjadi platform jurnal dan literasi digital yang membantu masyarakat Indonesia meningkatkan pengetahuan, kebiasaan belajar, dan kesadaran penggunaan TIK.

Tema aplikasi adalah pemanfaatan TIK untuk mencerdaskan masyarakat Indonesia dan mendukung SDGs. Fokus utama aplikasi berkaitan dengan SDG 4, yaitu pendidikan berkualitas, melalui artikel edukasi, kategori pembelajaran, jurnal harian, dan statistik perkembangan pengguna.

Tujuan aplikasi:
- Membantu pengguna menulis jurnal belajar harian.
- Menyediakan artikel edukasi dan literasi digital.
- Mengelompokkan materi berdasarkan kategori pembelajaran.
- Menampilkan statistik perkembangan pengguna.
- Menampilkan dashboard dampak penggunaan berbasis data dari database.
- Mengatur hak akses Admin, Educator, dan User.

## BAB 2 Instalasi

Persyaratan:
- PHP sesuai versi `composer.json`.
- Composer.
- Node.js dan npm.
- Database MySQL atau SQLite.

Langkah instalasi:

```bash
git clone https://github.com/Graynaldoo/mindlog.git
cd mindlog
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

Atur koneksi database di file `.env`.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mindlog
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan migration dan seeder:

```bash
php artisan migrate:fresh --seed
npm install
npm run build
php artisan serve
```

Akun default hasil seeder:
- Admin: `admin@mindlog.test` / `password`
- Educator: `educator@mindlog.test` / `password`
- User: `user@mindlog.test` / `password`

## BAB 3 Penggunaan Web

Register, login, dan logout:
- User baru dapat mendaftar melalui halaman register.
- Setelah login, user diarahkan ke dashboard.
- Tombol logout tersedia di navbar.

Hak akses:
- Admin dapat mengelola user, artikel, kategori, dan melihat statistik.
- Educator dapat menambah dan mengedit artikel miliknya.
- User dapat mengelola jurnal pribadi dan melihat statistik.

Jurnal harian:
- Masuk ke menu Jurnal Harian.
- Klik Tulis Jurnal.
- Pilih mood, isi judul, konten, tanggal, dan status privasi.
- Data jurnal tersimpan di tabel `journals`.

Artikel edukasi:
- Masuk ke menu Artikel Edukasi.
- User dapat membaca artikel yang sudah published.
- Saat artikel dibaca, `read_count` bertambah dan statistik user diperbarui.

Kategori pembelajaran:
- Admin membuka menu Kelola Kategori.
- Admin dapat menambah, mengedit, menghapus, dan mengaktifkan kategori.

Dashboard dampak:
- Dashboard menampilkan jumlah jurnal mingguan, artikel dibaca, durasi belajar, peningkatan aktivitas, dan grafik Chart.js.
- Contoh laporan otomatis: "Dalam 30 hari aktivitas pengguna meningkat 35%".
- Data dihitung dari tabel `statistics`, `journals`, dan `articles`.

## BAB 4 Penggunaan API

Base URL lokal:

```text
http://localhost:8000/api
```

Endpoint Auth:

```text
POST /api/register
POST /api/login
POST /api/logout
GET  /api/profile
```

Endpoint Journal:

```text
GET    /api/journals
POST   /api/journals
GET    /api/journals/{id}
PUT    /api/journals/{id}
DELETE /api/journals/{id}
```

Endpoint Article:

```text
GET    /api/articles
POST   /api/articles
GET    /api/articles/{id}
PUT    /api/articles/{id}
DELETE /api/articles/{id}
```

Endpoint Category:

```text
GET    /api/categories
POST   /api/categories
GET    /api/categories/{id}
PUT    /api/categories/{id}
DELETE /api/categories/{id}
```

Endpoint Statistics:

```text
GET /api/statistics
```

JWT Authorization:

```http
Authorization: Bearer <token>
```

Basic Auth:

```text
GET /api/basic/statistics
Username: admin@mindlog.test
Password: password
```

API Key:

```http
GET /api/key/articles
X-API-Key: <api_key>
```

Contoh request login:

```json
{
  "email": "admin@mindlog.test",
  "password": "password"
}
```

Contoh response login:

```json
{
  "success": true,
  "message": "Login berhasil.",
  "data": {
    "access_token": "jwt-token",
    "token_type": "Bearer"
  }
}
```

## BAB 5 Testing API

File Postman:
- `postman_collection.json`
- `postman_environment.json`

Cara testing:
1. Buka Postman.
2. Import collection dan environment.
3. Pilih environment "MindLog EduSmart Local".
4. Jalankan request Login.
5. Token JWT otomatis disimpan ke variabel `token`.
6. Jalankan request Profile, Journal, Article, Category, dan Statistics.

Testing manual dengan cURL:

```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d "{\"email\":\"admin@mindlog.test\",\"password\":\"password\"}"
```

## BAB 6 Swagger

Paket yang digunakan:

```text
darkaonline/l5-swagger
```

Konfigurasi tersedia di:

```text
config/l5-swagger.php
```

Generate dokumentasi:

```bash
php artisan l5-swagger:generate
```

Buka dokumentasi:

```text
http://localhost:8000/api/documentation
```

Swagger memuat:
- Endpoint auth, journal, article, category, statistics.
- Contoh request dan response.
- JWT Bearer Auth.
- Basic Auth.
- API Key header `X-API-Key`.

## BAB 7 Deployment

Langkah deployment:

```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
php artisan key:generate
php artisan jwt:secret
php artisan migrate --force
php artisan db:seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Pastikan environment production:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-aplikasi
```

Folder `storage` dan `bootstrap/cache` harus writable oleh web server.

## BAB 8 Kesimpulan

MindLog EduSmart berhasil mengembangkan MindLog menjadi platform jurnal dan literasi digital berbasis Laravel. Aplikasi mendukung register, login, logout, role Admin/Educator/User, authorization menggunakan middleware, Gate, dan Policy, serta API dengan JWT, Basic Auth, dan API Key.

Aplikasi juga memiliki artikel edukasi, kategori pembelajaran, statistik perkembangan pengguna, dashboard dampak berbasis database, Chart.js, Swagger, Postman, migration, seeder, model, controller, repository, dan dokumentasi instalasi. Dengan fitur tersebut, MindLog EduSmart mendukung pemanfaatan TIK untuk mencerdaskan masyarakat Indonesia dan mendukung SDGs.
