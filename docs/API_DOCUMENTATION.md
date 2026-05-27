# MindLog Smart Education API Documentation

Swagger UI tersedia di `/api/documentation`. Dokumentasi ringkas berikut mengikuti endpoint wajib mata kuliah.

## Authentication

Semua endpoint privat memakai header:

```http
Authorization: Bearer {token}
```

Endpoint:

- `POST /api/register`
- `POST /api/login`
- `POST /api/logout`
- `POST /api/refresh`
- `GET /api/profile`

## Journal

- `GET /api/journals`
- `POST /api/journals`
- `PUT /api/journals/{id}`
- `DELETE /api/journals/{id}`

Body create:

```json
{
  "mood_id": 4,
  "title": "Belajar Literasi Digital",
  "content": "Saya membaca artikel keamanan digital.",
  "daily_activities": "Membaca artikel dan membuat rangkuman.",
  "productivity_score": 85,
  "activity_minutes": 45,
  "journal_date": "2026-05-27",
  "is_private": true
}
```

## Education

- `GET /api/education`
- `POST /api/education`

`POST /api/education` hanya untuk Admin/Educator yang memiliki permission `article.create`.

## Analytics

- `GET /api/statistics`
- `GET /api/impact`
- `GET /api/leaderboard`

Data impact dihitung dari tabel database: `users`, `journals`, `statistics`, `articles`, `education_contents`, `streaks`, dan disimpan sebagai snapshot di `impact_metrics`.

## Basic Auth

Gunakan Basic Auth email/password pada endpoint:

- `GET /api/basic/statistics`
- `GET /api/basic/journals`
- `POST /api/basic/journals`

## API Key Auth

Generate key:

- `POST /api/api-keys`

Gunakan header:

```http
X-API-Key: ml_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

Endpoint validasi dan konsumsi:

- `GET /api/key/validate`
- `GET /api/key/education`
- `GET /api/key/impact`
- `GET /api/key/leaderboard`

Revoke key:

- `DELETE /api/api-keys/{id}`
