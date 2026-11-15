<?php

namespace Database\Factories;

use App\Enums\TourStatus;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Tour>
 */
class TourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = Str::title(fake()->unique()->words(3, true));
        $startDate = fake()->dateTimeBetween('+1 month', '+2 years');
        $endDate = (clone $startDate)->modify('+'.fake()->numberBetween(5, 25).' days');

        return [
            'name' => $name,
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(1, 999999),
            'year' => (int) $startDate->format('Y'),
            'country' => fake()->country(),
            'summary' => fake()->sentence(14),
            'description' => fake()->paragraphs(3, true),
            'itinerary' => fake()->paragraphs(4, true),
            'duration_days' => fake()->numberBetween(5, 25),
            'date_label' => fake()->words(5, true),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'price_gbp' => fake()->numberBetween(150000, 800000),
            'price_usd' => fake()->numberBetween(200000, 1000000),
            'single_supplement_gbp' => fake()->numberBetween(20000, 120000),
            'single_supplement_usd' => fake()->numberBetween(25000, 150000),
            'status' => TourStatus::Available,
            'status_label' => null,
            'image' => fake()->imageUrl(800, 600),
            'external_url' => fake()->url(),
            'is_featured' => false,
            'is_published' => true,
            'sort_order' => fake()->numberBetween(0, 50),
            'meta_title' => $name,
            'meta_description' => fake()->sentence(18),
        ];
    }

    /**
     * Indicate that the tour is still a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
        ]);
    }

    /**
     * Indicate that the tour is featured on the home page.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    /**
     * Indicate that the tour is fully booked.
     */
    public function full(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => TourStatus::Full,
        ]);
    }
}
