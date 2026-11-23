<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Tour;
use App\Models\TourReport;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TourTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    public function test_home_page_renders_seeded_content(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Kunam Birding Tours');
        $response->assertSee('Latest news 14/10');
        $response->assertSee('Plover_Oriental', false);
        $response->assertSee('Selected Latest Tour Reports');
        $response->assertSee('Lesser Florican &amp; Western Himalaya', false);
        $response->assertSee('Leech Socks');
        $response->assertSee('Visit Facebook Page');
    }

    public function test_home_page_hides_the_product_section_when_no_product_is_active(): void
    {
        Product::query()->update(['is_active' => false]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertDontSee('Leech Socks');
    }

    public function test_home_page_only_shows_published_latest_reports(): void
    {
        TourReport::factory()->latest()->create(['title' => 'Visible Latest Dispatch', 'sort_order' => 0]);
        TourReport::factory()->latest()->draft()->create(['title' => 'Hidden Latest Dispatch']);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Visible Latest Dispatch');
        $response->assertDontSee('Hidden Latest Dispatch');
    }

    public function test_scheduled_tours_page_lists_published_tours_with_their_badges(): void
    {
        $response = $this->get('/tours');

        $response->assertOk();
        $response->assertSee('Scheduled Tours');
        $response->assertSee('2027 tours');
        $response->assertSee('2028 tours');
        $response->assertSee('href="#2027-tours"', false);
        $response->assertSee('href="#2028-tours"', false);
        $response->assertSee('href="#future-tours"', false);
        $response->assertSee('id="future-tours"', false);
        $response->assertSee('<span class="badge bg-success">'.Tour::query()->published()->where('year', 2027)->count().' Departures</span>', false);
        $response->assertSee('<span class="badge bg-success">'.Tour::query()->published()->where('year', 2028)->count().' Departures</span>', false);
        $response->assertSee('China in winter');
        $response->assertSee('Cambodia and Laos');
        $response->assertSee('One space available');
        $response->assertSee('Tour is full');
        $response->assertSee('Tour is provisionally full');
        $response->assertSee('bta-badge-full', false);
        $response->assertSee('bta-badge-provisional', false);
    }

    public function test_scheduled_tours_departure_badge_follows_the_published_tour_count(): void
    {
        $year = 2027;
        $before = Tour::query()->published()->where('year', $year)->count();

        Tour::factory()->create(['name' => 'Extra Departure Tour', 'year' => $year]);
        Tour::factory()->draft()->create(['name' => 'Draft Departure Tour', 'year' => $year]);

        $response = $this->get('/tours');

        $response->assertOk();
        $response->assertSee('<span class="badge bg-success">'.($before + 1).' Departures</span>', false);
    }

    public function test_scheduled_tours_departure_badge_uses_the_singular_for_one_tour(): void
    {
        $year = now()->year - 1;

        Tour::factory()->create(['name' => 'Solo Departure Tour', 'year' => $year]);

        $response = $this->get('/tours');

        $response->assertOk();
        $response->assertSee('<span class="badge bg-success">1 Departure</span>', false);
        $response->assertDontSee('<span class="badge bg-success">1 Departures</span>', false);
    }

    public function test_scheduled_tours_page_generates_a_tab_and_section_for_a_new_year(): void
    {
        $year = now()->year - 1;

        Tour::factory()->create(['name' => 'Dynamic Calendar Tour', 'year' => $year]);

        $response = $this->get('/tours');

        $response->assertOk();
        $response->assertSee('href="#'.$year.'-tours"', false);
        $response->assertSee('id="'.$year.'-tours"', false);
        $response->assertSee($year.' Tours');
        $response->assertSee('Dynamic Calendar Tour');
    }

    public function test_scheduled_tours_page_groups_years_outside_the_calendar_window_as_future_tours(): void
    {
        $cutoffYear = now()->year + 2;
        $futureYear = $cutoffYear + 2;

        Tour::factory()->create(['name' => 'Far Future Tour', 'year' => $futureYear]);

        $response = $this->get('/tours');

        $response->assertOk();
        $response->assertSee('href="#future-tours"', false);
        $response->assertSee('id="future-tours"', false);
        $response->assertSee('Beyond '.Tour::query()->published()->where('year', '<=', $cutoffYear)->max('year'));
        $response->assertSee('Far Future Tour');
        $response->assertDontSee('id="'.$futureYear.'-tours"', false);
    }

    public function test_scheduled_tours_page_hides_future_navigation_without_future_tours(): void
    {
        Tour::query()->where('year', '>', now()->year + 2)->update(['is_published' => false]);

        $response = $this->get('/tours');

        $response->assertOk();
        $response->assertDontSee('Future tours');
        $response->assertDontSee('id="future-tours"', false);
    }

    public function test_scheduled_tours_page_hides_draft_tours(): void
    {
        $draftYear = now()->year + 5;

        Tour::factory()->draft()->create(['name' => 'Secret Draft Departure', 'year' => $draftYear]);

        $response = $this->get('/tours');

        $response->assertOk();
        $response->assertDontSee('Secret Draft Departure');
        $response->assertDontSee('href="#'.$draftYear.'-tours"', false);
    }
}
