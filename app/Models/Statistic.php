<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Statistic extends Model
{
    protected $fillable = [
        'user_id',
        'activity_date',
        'journals_count',
        'articles_read',
        'learning_minutes',
        'digital_literacy_score',
        'metadata',
    ];

    protected $casts = [
        'activity_date' => 'date',
        'metadata' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
