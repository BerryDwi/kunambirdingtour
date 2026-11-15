<?php

namespace Tests\Feature;

use App\Models\TermsSection;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TermsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    public function test_terms_page_renders_the_seeded_sections(): void
    {
        $response = $this->get('/terms');

        $response->assertOk();
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

    public function test_terms_sidebar_renders_the_stored_navigation_labels_and_anchors(): void
    {
        $response = $this->get('/terms');

        $response->assertOk();
        $response->assertSee('1. Financial Security (IPP London)');
        $response->assertSee('3. Payment &amp; Currencies', false);
        $response->assertSee('14. Complaints &amp; Governing Law', false);
        $response->assertSee('href="#financial-security"', false);
        $response->assertSee('href="#passports-visas"', false);
        $response->assertSee('id="complaints"', false);
        $response->assertSee('Birdtour Asia Limited Terms &amp; Conditions', false);
    }

    public function test_terms_sections_fall_back_to_a_slug_anchor_and_title_when_blank(): void
    {
        $section = TermsSection::factory()->create([
            'number' => 99,
            'title' => 'Extra Clause Marker',
            'nav_title' => null,
            'anchor' => null,
        ]);

        $this->assertSame('extra-clause-marker', $section->anchorId());
        $this->assertSame('Extra Clause Marker', $section->navTitle());

        $response = $this->get('/terms');

        $response->assertOk();
        $response->assertSee('99. Extra Clause Marker');
        $response->assertSee('id="extra-clause-marker"', false);
    }

    public function test_terms_alias_route_redirects_permanently(): void
    {
        $response = $this->get('/terms-and-conditions');

        $response->assertStatus(301);
        $response->assertRedirect('/terms');
    }
}
