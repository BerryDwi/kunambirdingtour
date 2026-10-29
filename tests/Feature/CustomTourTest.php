<?php

namespace Tests\Feature;

use Tests\TestCase;

class CustomTourTest extends TestCase
{
    public function test_custom_tours_page_can_be_rendered(): void
    {
        $response = $this->get('/custom-tours');

        $response->assertStatus(200);
        $response->assertSee('Custom Tours');
        $response->assertSee('Custom tours looking for participants');
        $response->assertSee('Catch-up tours');
        $response->assertSee('maps/d/embed?mid=10uk_1wHhHBosIlnUn81u8kgeqUI');
    }

    public function test_custom_tours_alias_route_works(): void
    {
        $response = $this->get('/customtours');

        $response->assertStatus(200);
    }
}
