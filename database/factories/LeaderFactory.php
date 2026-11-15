<?php

namespace Database\Factories;

use App\Models\Leader;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Leader>
 */
class LeaderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->name();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'region' => fake()->randomElement(['Throughout the region', 'Southeast Asia', 'South Asia', 'East Asia']),
            'badge_style' => 'success',
            'bio' => fake()->paragraphs(2, true),
            'photo' => fake()->imageUrl(400, 400),
            'email' => fake()->unique()->safeEmail(),
            'sort_order' => fake()->numberBetween(0, 30),
            'is_published' => true,
        ];
    }

    /**
     * Indicate that the leader is not published.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
        ]);
    }
}
