<?php

namespace Tests\Feature;

use App\Models\TourReport;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TourReportTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    public function test_tour_reports_page_renders_seeded_categories(): void
    {
        $response = $this->get('/tour-reports');

        $response->assertOk();
        $response->assertSee('Tour Reports');
        $response->assertSee('200 tour reports');
        $response->assertSee('Borneo');
        $response->assertSee('Indian subcontinent');
        $response->assertSee('Newsletters');
    }

    public function test_tour_reports_page_only_shows_published_categories(): void
    {
        TourReport::factory()->create(['title' => 'Visible Category Marker']);
        TourReport::factory()->draft()->create(['title' => 'Hidden Category Marker']);

        $response = $this->get('/tour-reports');

        $response->assertOk();
        $response->assertSee('Visible Category Marker');
        $response->assertDontSee('Hidden Category Marker');
    }

    public function test_tour_reports_alias_route_redirects_permanently(): void
    {
        $response = $this->get('/tourreports');

        $response->assertStatus(301);
        $response->assertRedirect('/tour-reports');
    }
}
