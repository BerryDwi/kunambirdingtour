<?php

namespace Tests\Feature;

use App\Models\Tour;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TourDetailTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    public function test_published_tour_detail_renders_successfully(): void
    {
        $tour = Tour::factory()->create([
            'name' => 'Borneo Classic Birding',
            'slug' => 'borneo-classic-birding-2027',
            'country' => 'Malaysia',
            'year' => 2027,
            'date_label' => '10 - 24 Jul 2027',
            'duration_days' => 15,
            'price_gbp' => 4500,
            'price_usd' => 5800,
            'is_published' => true,
            'summary' => 'Spectacular endemic birding in Sabah and Danum Valley.',
            'itinerary' => "Day 1: Arrival in Kota Kinabalu\nDay 2-4: Mount Kinabalu\nDay 5-8: Danum Valley",
        ]);

        $response = $this->get(route('tours.show', $tour));

        $response->assertOk();
        $response->assertSee('Borneo Classic Birding');
        $response->assertSee('Malaysia');
        $response->assertSee('10 - 24 Jul 2027');
        $response->assertSee('15 Days');
        $response->assertSee('4,500');
        $response->assertSee('5,800');
        $response->assertSee('Danum Valley');
        $response->assertSee('Enquire via WhatsApp');
        $response->assertSee('Enquire via Email');
        $response->assertDontSee('View Official Itinerary');
        $response->assertDontSee('Full Itinerary Document');
    }

    public function test_seeded_tour_detail_renders_stored_itinerary_without_external_links(): void
    {
        $tour = Tour::query()->where('slug', 'china-in-winter-2027')->firstOrFail();

        $response = $this->get(route('tours.show', $tour));

        $response->assertOk();
        $response->assertSee('Tour Itinerary');
        $response->assertSee('Arrival into Beijing International Airport');
        $response->assertSee('Max 8 Birders');
        $response->assertDontSee('View Official Itinerary');
        $response->assertDontSee('Full Itinerary Document');
        $response->assertDontSee('birdtourasia.com/china');
    }

    public function test_tour_detail_uses_the_default_group_size_when_none_is_stored(): void
    {
        $tour = Tour::factory()->create([
            'group_size' => null,
            'is_published' => true,
        ]);

        $this->get(route('tours.show', $tour))
            ->assertOk()
            ->assertSee('Max 6–8 Birders');
    }

    public function test_tour_detail_escapes_stored_description_and_itinerary(): void
    {
        $tour = Tour::factory()->create([
            'description' => '<script>alert(1)</script>',
            'itinerary' => "Day 1: <b>Bold</b> start\nDay 2: Plain day",
            'is_published' => true,
        ]);

        $this->get(route('tours.show', $tour))
            ->assertOk()
            ->assertDontSee('<script>alert(1)</script>', false)
            ->assertDontSee('<b>Bold</b>', false)
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
            ->assertSee('Day 2: Plain day');
    }

    public function test_draft_tour_detail_returns_404(): void
    {
        $tour = Tour::factory()->draft()->create([
            'slug' => 'secret-unannounced-tour',
        ]);

        $response = $this->get(route('tours.show', $tour));

        $response->assertNotFound();
    }

    public function test_tour_card_on_tours_index_links_to_tour_detail(): void
    {
        $tour = Tour::factory()->create([
            'name' => 'Himalayan Foothills Tour',
            'slug' => 'himalayan-foothills-2027',
            'year' => 2027,
            'is_published' => true,
        ]);

        $response = $this->get(route('tours'));

        $response->assertOk();
        $response->assertSee(route('tours.show', $tour), false);
        $response->assertSee('View Details &rarr;', false);
    }
}
