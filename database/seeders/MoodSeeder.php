<?php

namespace Database\Seeders;

use App\Models\Mood;
use Illuminate\Database\Seeder;

class MoodSeeder extends Seeder
{
    public function run(): void
    {
        $moods = [
            ['name' => 'Sangat Sedih', 'emoji' => ':(', 'color' => '#EF4444', 'score' => 1],
            ['name' => 'Sedih', 'emoji' => ':/', 'color' => '#F87171', 'score' => 2],
            ['name' => 'Biasa', 'emoji' => ':|', 'color' => '#FBBF24', 'score' => 3],
            ['name' => 'Senang', 'emoji' => ':)', 'color' => '#34D399', 'score' => 4],
            ['name' => 'Sangat Senang', 'emoji' => ':D', 'color' => '#10B981', 'score' => 5],
        ];

        foreach ($moods as $mood) {
            Mood::updateOrCreate(['name' => $mood['name']], $mood);
        }
    }
}
