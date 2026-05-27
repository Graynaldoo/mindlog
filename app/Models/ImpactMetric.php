<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImpactMetric extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_user',
        'total_journal',
        'average_productivity',
        'education_content_read',
        'engagement_rate',
        'calculated_at',
    ];

    protected $casts = [
        'average_productivity' => 'float',
        'engagement_rate' => 'float',
        'calculated_at' => 'datetime',
    ];
}
