<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Activity>
 */
class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(3),
            'description' => fake()->sentence(8),
            'category' => fake()->randomElement(['learning', 'work', 'community', 'wellbeing']),
            'activity_date' => fake()->dateTimeBetween('-30 days', 'now')->format('Y-m-d'),
            'duration_minutes' => fake()->numberBetween(10, 180),
            'productivity_score' => fake()->numberBetween(40, 95),
        ];
    }
}
