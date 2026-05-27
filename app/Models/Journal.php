<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mood_id',
        'title',
        'content',
        'daily_activities',
        'productivity_score',
        'activity_minutes',
        'journal_date',
        'is_private',
    ];

    protected $casts = [
        'journal_date' => 'date',
        'is_private'   => 'boolean',
    ];

    // ── Relasi ───────────────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mood()
    {
        return $this->belongsTo(Mood::class);
    }

    // ── Scope ────────────────────────────────────────────────────
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('journal_date', [
            now()->startOfWeek(),
            now()->endOfWeek(),
        ]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('journal_date', now()->month)
                     ->whereYear('journal_date', now()->year);
    }
}
