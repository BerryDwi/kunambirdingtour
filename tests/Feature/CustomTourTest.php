<?php

namespace Tests\Feature;

use App\Models\CustomTour;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomTourTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    public function test_custom_tours_page_renders_the_empty_state_without_participant_tours(): void
    {
        CustomTour::query()->update(['is_published' => false]);

        $response = $this->get('/custom-tours');

        $response->assertOk();
        $response->assertSee('Custom Tours');
        $response->assertSee('Custom tours looking for participants');
        $response->assertSee('At the moment there are no custom tours looking for additional');
        $response->assertSee('Catch-up tours');
        $response->assertSee('maps/d/embed?mid=10uk_1wHhHBosIlnUn81u8kgeqUI');
    }

    public function test_custom_tours_page_lists_published_custom_tours(): void
    {
        CustomTour::factory()->create([
            'title' => 'Visible Participant Tour',
            'destination' => 'Sulawesi',
        ]);
        CustomTour::factory()->draft()->create(['title' => 'Hidden Participant Tour']);

        $response = $this->get('/custom-tours');

        $response->assertOk();
        $response->assertSee('Visible Participant Tour');
        $response->assertSee('Sulawesi Endemics');
        $response->assertSee('Sulawesi, Indonesia');
        $response->assertDontSee('At the moment there are no custom tours looking for additional');
        $response->assertDontSee('Hidden Participant Tour');
    }

    public function test_custom_tours_alias_route_redirects_permanently(): void
    {
        $response = $this->get('/customtours');

        $response->assertStatus(301);
        $response->assertRedirect('/custom-tours');
    }
}
