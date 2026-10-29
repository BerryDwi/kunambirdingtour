<?php

namespace Tests\Feature;

use Tests\TestCase;

class TermsTest extends TestCase
{
    public function test_terms_page_can_be_rendered(): void
    {
        $response = $this->get('/terms');

        $response->assertStatus(200);
        $response->assertSee('Terms and Conditions');
        $response->assertSee('Financial Security &amp; Insolvency Protection', false);
        $response->assertSee('The Package Travel and Linked Travel Arrangements Regulations 2018');
        $response->assertSee('International Passenger Protection');
        $response->assertSee('Payment &amp; Currency Policy', false);
        $response->assertSee('120 days before');
        $response->assertSee('Cancellations &amp; Refunds', false);
        $response->assertSee('Travel &amp; Medical Insurance', false);
        $response->assertSee('Sharing Rooms &amp; Single Supplements', false);
        $response->assertSee('Group Sizes &amp; Leadership Ratios', false);
        $response->assertSee('Company Registration Number 6383052');
    }

    public function test_terms_alias_route_works(): void
    {
        $response = $this->get('/terms-and-conditions');

        $response->assertStatus(200);
        $response->assertSee('Terms and Conditions');
    }
}
