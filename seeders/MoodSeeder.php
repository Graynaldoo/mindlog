<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mood;

class MoodSeeder extends Seeder
{
    public function run(): void
    {
        $moods = [
            ['name' => 'Bahagia',   'emoji' => '😊', 'color' => '#F59E0B', 'score' => 5],
            ['name' => 'Semangat',  'emoji' => '🔥', 'color' => '#EF4444', 'score' => 5],
            ['name' => 'Tenang',    'emoji' => '😌', 'color' => '#10B981', 'score' => 4],
            ['name' => 'Biasa',     'emoji' => '😐', 'color' => '#6B7280', 'score' => 3],
            ['name' => 'Lelah',     'emoji' => '😴', 'color' => '#8B5CF6', 'score' => 2],
            ['name' => 'Cemas',     'emoji' => '😰', 'color' => '#F97316', 'score' => 2],
            ['name' => 'Sedih',     'emoji' => '😢', 'color' => '#3B82F6', 'score' => 1],
            ['name' => 'Marah',     'emoji' => '😤', 'color' => '#DC2626', 'score' => 1],
        ];

        foreach ($moods as $mood) {
            Mood::firstOrCreate(['name' => $mood['name']], $mood);
        }
    }
}
