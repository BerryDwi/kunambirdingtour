<?php

namespace Tests\Feature;

use Tests\TestCase;

class TourTest extends TestCase
{
    public function test_home_page_can_be_rendered(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Birdtour Asia');
        $response->assertSee('Selected Latest Tour Reports');
        $response->assertSee('Leech Socks');
    }

    public function test_scheduled_tours_page_can_be_rendered(): void
    {
        $response = $this->get('/tours');

        $response->assertStatus(200);
        $response->assertSee('Scheduled Tours');
        $response->assertSee('2027 tours');
        $response->assertSee('2028 tours');
    }
}
