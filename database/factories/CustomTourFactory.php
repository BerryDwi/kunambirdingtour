<?php

namespace Database\Factories;

use App\Models\CustomTour;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<CustomTour>
 */
class CustomTourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = Str::title(fake()->unique()->words(3, true));

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'destination' => fake()->country(),
            'date_label' => fake()->words(4, true),
            'description' => fake()->paragraphs(2, true),
            'status' => fake()->randomElement(['open', 'confirmed']),
            'contact_email' => fake()->safeEmail(),
            'sort_order' => fake()->numberBetween(0, 20),
            'is_published' => true,
        ];
    }

    /**
     * Indicate that the custom tour is not published.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
        ]);
    }
}
