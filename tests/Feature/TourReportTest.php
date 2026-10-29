<?php

namespace Tests\Feature;

use Tests\TestCase;

class TourReportTest extends TestCase
{
    public function test_tour_reports_page_can_be_rendered(): void
    {
        $response = $this->get('/tour-reports');

        $response->assertStatus(200);
        $response->assertSee('Tour Reports');
        $response->assertSee('200 tour reports');
        $response->assertSee('Borneo');
        $response->assertSee('Newsletters');
    }

    public function test_tour_reports_alias_route_works(): void
    {
        $response = $this->get('/tourreports');

        $response->assertStatus(200);
    }
}
