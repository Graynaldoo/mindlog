<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'role_id',
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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [
            'role' => $this->role?->name,
        ];
    }

    public static function generateApiKey(): string
    {
        return 'ml_' . Str::random(40);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function journals(): HasMany
    {
        return $this->hasMany(Journal::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'author_id');
    }

    public function statistics(): HasMany
    {
        return $this->hasMany(Statistic::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function streak(): HasOne
    {
        return $this->hasOne(Streak::class);
    }

    public function hasRole(string|array $roles): bool
    {
        return in_array($this->role?->name, (array) $roles, true);
    }

    public function hasPermission(string $permission): bool
    {
        return $this->role?->permissions()
            ->where('name', $permission)
            ->exists() ?? false;
    }
}
