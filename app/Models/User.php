<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Str;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'api_key',
        'avatar',
        'bio',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'api_key',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ── JWT ──────────────────────────────────────────────────────
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    // ── Generate API Key ─────────────────────────────────────────
    public static function generateApiKey(): string
    {
        return 'ml_' . Str::random(40);
    }

    // ── Relasi ───────────────────────────────────────────────────
    public function journals()
    {
        return $this->hasMany(Journal::class);
    }

    public function streak()
    {
        return $this->hasOne(Streak::class);
    }
}
