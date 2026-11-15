<?php

namespace Database\Seeders;

use App\Models\CustomTour;
use Illuminate\Database\Seeder;

class CustomTourSeeder extends Seeder
{
    /**
     * Seed demo custom tours that are looking for participants.
     *
     * These entries are placeholders so the public page and admin list have
     * realistic content to review. Replace or delete them from the admin panel
     * once real catch-up tours are available.
     */
    public function run(): void
    {
        foreach ($this->customTours() as $customTour) {
            CustomTour::updateOrCreate(
                ['slug' => $customTour['slug']],
                $customTour,
            );
        }
    }

    /**
     * The demo custom tours shown on the public custom tours page.
     *
     * @return array<int, array<string, mixed>>
     */
    private function customTours(): array
    {
        return [
            [
                'title' => 'Sulawesi Endemics & Wallacean Specialities',
                'slug' => 'sulawesi-endemics-2027',
                'destination' => 'Sulawesi, Indonesia',
                'date_label' => 'September 2027',
                'description' => 'A two-week small-group tour targeting Sulawesi\'s endemic kingfishers, mynas, and raptors, including Maleo and Knobbed Hornbill.',
                'status' => 'open',
                'contact_email' => 'info@birdtourasia.com',
                'sort_order' => 1,
                'is_published' => true,
            ],
            [
                'title' => 'Western Himalaya: Ibisbill & Himalayan Monal',
                'slug' => 'western-himalaya-ibisbill-2027',
                'destination' => 'Uttarakhand, India',
                'date_label' => 'March 2027',
                'description' => 'A spring itinerary through the Himalayan foothills for Ibisbill, Himalayan Monal, Cheer Pheasant, and other high-altitude specialists.',
                'status' => 'open',
                'contact_email' => 'info@birdtourasia.com',
                'sort_order' => 2,
                'is_published' => true,
            ],
            [
                'title' => 'Taiwan Endemics & Spring Migration',
                'slug' => 'taiwan-endemics-2027',
                'destination' => 'Taiwan',
                'date_label' => 'April 2027',
                'description' => 'A focused extension covering Taiwan\'s endemic pheasants and babblers, plus the spring migrant wave along the west coast.',
                'status' => 'confirmed',
                'contact_email' => 'info@birdtourasia.com',
                'sort_order' => 3,
                'is_published' => true,
            ],
        ];
    }
}
