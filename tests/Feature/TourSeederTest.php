<?php

namespace Tests\Feature;

use App\Models\Tour;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\TourSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TourSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_reseeding_preserves_administrator_edits(): void
    {
        $this->seed(DatabaseSeeder::class);

        $tour = Tour::query()->where('slug', 'china-in-winter-2027')->firstOrFail();
        $tour->update([
            'name' => 'Admin renamed tour',
            'summary' => 'Admin written summary',
            'status_label' => 'Admin status label',
            'group_size' => '4',
            'sort_order' => 999,
            'is_published' => false,
        ]);

        $this->seed(TourSeeder::class);

        $tour->refresh();

        $this->assertSame('Admin renamed tour', $tour->name);
        $this->assertSame('Admin written summary', $tour->summary);
        $this->assertSame('Admin status label', $tour->status_label);
        $this->assertSame('4', $tour->group_size);
        $this->assertSame(999, $tour->sort_order);
        $this->assertFalse($tour->is_published);
    }

    public function test_reseeding_backfills_only_empty_content_fields(): void
    {
        $this->seed(DatabaseSeeder::class);

        $tour = Tour::query()->where('slug', 'bangladesh-2027')->firstOrFail();
        $tour->update([
            'description' => null,
            'itinerary' => 'Admin written itinerary',
            'group_size' => null,
        ]);

        $this->seed(TourSeeder::class);

        $tour->refresh();

        $this->assertStringContainsString('Critically Endangered', (string) $tour->description);
        $this->assertSame('Admin written itinerary', $tour->itinerary);
        $this->assertSame('7-8', $tour->group_size);
    }

    public function test_reseeding_recreates_a_missing_tour(): void
    {
        $this->seed(DatabaseSeeder::class);

        Tour::query()->where('slug', 'vietnam-2027')->forceDelete();

        $this->seed(TourSeeder::class);

        $tour = Tour::query()->where('slug', 'vietnam-2027')->firstOrFail();

        $this->assertSame('Vietnam', $tour->name);
        $this->assertSame(21, $tour->duration_days);
    }

    public function test_seeded_tours_have_a_description_and_an_itinerary(): void
    {
        $this->seed(DatabaseSeeder::class);

        $slugs = [
            'southern-india-and-andamans-2027',
            'japan-classic-winter-2027',
            'southern-india-and-andamans-2028',
            'japan-classic-winter-2028',
            'banda-sea-liveaboard-cruise-tanimbars-2028',
        ];

        foreach ($slugs as $slug) {
            $tour = Tour::query()->where('slug', $slug)->firstOrFail();

            $this->assertNotNull($tour->description, $slug);
            $this->assertNotNull($tour->itinerary, $slug);
        }
    }

    public function test_reseeding_does_not_restore_a_soft_deleted_tour(): void
    {
        $this->seed(DatabaseSeeder::class);

        Tour::query()->where('slug', 'vietnam-2027')->firstOrFail()->delete();

        $this->seed(TourSeeder::class);

        $this->assertSame(0, Tour::query()->where('slug', 'vietnam-2027')->count());
        $this->assertNotNull(Tour::query()->withTrashed()->where('slug', 'vietnam-2027')->value('deleted_at'));
    }
}
