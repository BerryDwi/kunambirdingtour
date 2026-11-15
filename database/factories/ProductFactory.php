<?php

namespace Database\Factories;

use App\Enums\Currency;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = Str::title(fake()->unique()->words(2, true));

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraphs(2, true),
            'price' => fake()->numberBetween(500, 5000),
            'currency' => Currency::Gbp,
            'image' => fake()->imageUrl(600, 600),
            'purchase_url' => fake()->url(),
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the product is not available for sale.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
