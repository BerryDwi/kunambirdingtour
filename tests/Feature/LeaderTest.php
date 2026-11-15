<?php

namespace Tests\Feature;

use App\Models\Leader;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeaderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    public function test_leaders_page_renders_seeded_leaders(): void
    {
        $response = $this->get('/leaders');

        $response->assertOk();
        $response->assertSee('Our Leaders');
        $response->assertSee('James Eaton');
        $response->assertSee('Rob Hutchinson');
        $response->assertSee('Bob Natural');
        $response->assertSee('Prof. Frank Rheindt');
        $response->assertSee('bg-info-subtle text-info', false);
        $response->assertSee('bg-warning-subtle text-warning', false);
        $response->assertSee('bg-success-subtle text-success', false);
    }

    public function test_leaders_page_only_shows_published_leaders(): void
    {
        Leader::factory()->create(['name' => 'Visible Guide Marker']);
        Leader::factory()->draft()->create(['name' => 'Hidden Guide Marker']);

        $response = $this->get('/leaders');

        $response->assertOk();
        $response->assertSee('Visible Guide Marker');
        $response->assertDontSee('Hidden Guide Marker');
    }
}
