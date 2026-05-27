<?php

namespace Database\Factories;

use App\Models\EducationContent;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<EducationContent>
 */
class EducationContentFactory extends Factory
{
    protected $model = EducationContent::class;

    public function definition(): array
    {
        $title = fake()->sentence(5);

        return [
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::lower(Str::random(5)),
            'type' => fake()->randomElement(['article', 'video', 'tip']),
            'excerpt' => fake()->sentence(12),
            'content' => fake()->paragraphs(3, true),
            'video_url' => null,
            'status' => 'published',
            'read_count' => fake()->numberBetween(0, 50),
            'estimated_minutes' => fake()->numberBetween(3, 15),
            'published_at' => now()->subDays(fake()->numberBetween(1, 20)),
        ];
    }
}
