<?php

namespace Database\Factories;

use App\Models\TourReport;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<TourReport>
 */
class TourReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = Str::title(fake()->unique()->words(4, true));

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'region' => fake()->randomElement(['China', 'Vietnam', 'Philippines', 'India', 'Cambodia']),
            'kind' => 'category',
            'summary' => fake()->sentence(14),
            'cover_image' => fake()->imageUrl(800, 600),
            'report_url' => fake()->url(),
            'published_at' => fake()->dateTimeBetween('-3 years', 'now'),
            'is_featured' => false,
            'sort_order' => fake()->numberBetween(0, 30),
            'is_published' => true,
        ];
    }

    /**
     * Indicate that the report is a latest-trip card shown on the home page.
     */
    public function latest(): static
    {
        return $this->state(fn (array $attributes) => [
            'kind' => 'latest',
            'is_featured' => true,
        ]);
    }

    /**
     * Indicate that the report is featured on the home page.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    /**
     * Indicate that the report is not published.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
        ]);
    }
}
