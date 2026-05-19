<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $moods = [
            ['name' => 'Sangat Sedih', 'emoji' => '😢', 'color' => '#EF4444', 'score' => 1],
            ['name' => 'Sedih', 'emoji' => '🙁', 'color' => '#F87171', 'score' => 2],
            ['name' => 'Biasa', 'emoji' => '😐', 'color' => '#FBBF24', 'score' => 3],
            ['name' => 'Senang', 'emoji' => '🙂', 'color' => '#34D399', 'score' => 4],
            ['name' => 'Sangat Senang', 'emoji' => '😊', 'color' => '#10B981', 'score' => 5],
        ];

        foreach ($moods as $mood) {
            \App\Models\Mood::firstOrCreate(['name' => $mood['name']], $mood);
        }
    }
}
