<?php

namespace Database\Factories;

use App\Models\HeroSlide;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HeroSlide>
 */
class HeroSlideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'page' => fake()->randomElement(['home', 'tours', 'custom-tours', 'reports', 'leaders', 'booking', 'contact', 'terms']),
            'image' => fake()->imageUrl(1920, 800),
            'alt' => fake()->sentence(4),
            'title' => fake()->sentence(4),
            'text' => fake()->sentence(12),
            'sort_order' => fake()->numberBetween(0, 20),
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the slide is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
