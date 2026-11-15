<?php

namespace Database\Seeders;

use App\Enums\Currency;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Seed the field gear products replicated from the public home page.
     */
    public function run(): void
    {
        foreach ($this->products() as $product) {
            Product::updateOrCreate(
                ['slug' => $product['slug']],
                $product,
            );
        }
    }

    /**
     * The products replicated from the public home page.
     *
     * @return array<int, array<string, mixed>>
     */
    private function products(): array
    {
        return [
            [
                'name' => 'Leech Socks',
                'slug' => 'leech-socks',
                'description' => 'Our leech socks are designed and field-tested by birders, for birders. These are no ordinary Leech Socks - using 100% very thin, lightweight cotton, we\'ve specifically designed them for comfort, meaning a flat sole (no stitching down the middle of the sole!), tapered at the ankle to avoid being baggy and hanging over your shoes, and in forest green. Simple and effective.

Available in two sizes: Small (<40 / UK6) and Large (40-45 / UK7-11), at only £18 / $22 per pair including VAT and worldwide postage.',
                'price' => 18,
                'currency' => Currency::Gbp,
                'image' => 'https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/66a4c39855cf7f0134ec13d8_leech%20socks.avif',
                'purchase_url' => 'https://www.birdtourasia.com/leechsocks',
                'is_active' => true,
            ],
        ];
    }
}
