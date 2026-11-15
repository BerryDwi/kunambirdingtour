<?php

namespace Database\Factories;

use App\Models\TermsSection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TermsSection>
 */
class TermsSectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $number = fake()->numberBetween(1, 14);

        return [
            'number' => $number,
            'title' => fake()->sentence(3),
            'nav_title' => null,
            'anchor' => null,
            'body' => fake()->paragraphs(3, true),
            'sort_order' => $number,
        ];
    }
}
