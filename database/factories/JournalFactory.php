<?php

namespace Database\Factories;

use App\Models\Journal;
use App\Models\Mood;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Journal>
 */
class JournalFactory extends Factory
{
    protected $model = Journal::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'mood_id' => Mood::query()->inRandomOrder()->value('id') ?? Mood::create([
                'name' => 'Netral',
                'emoji' => ':|',
                'color' => '#64748b',
                'score' => 3,
            ])->id,
            'title' => fake()->sentence(4),
            'content' => fake()->paragraph(),
            'daily_activities' => fake()->sentence(8),
            'productivity_score' => fake()->numberBetween(45, 95),
            'activity_minutes' => fake()->numberBetween(15, 180),
            'journal_date' => fake()->dateTimeBetween('-30 days', 'now')->format('Y-m-d'),
            'is_private' => true,
        ];
    }
}
