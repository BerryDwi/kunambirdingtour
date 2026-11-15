<?php

namespace Tests\Feature;

use App\Models\Setting;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);

        Mail::fake();
    }

    public function test_public_pages_expose_canonical_and_social_meta_tags(): void
    {
        $pages = ['/', '/tours', '/custom-tours', '/tour-reports', '/leaders', '/booking', '/contact', '/terms'];

        foreach ($pages as $path) {
            $response = $this->get($path);

            $response->assertOk();
            $response->assertSee('<link rel="canonical" href="'.url($path).'">', false);
            $response->assertSee('<meta property="og:title"', false);
            $response->assertSee('<meta property="og:description"', false);
            $response->assertSee('<meta property="og:image"', false);
            $response->assertSee('<meta property="og:url" content="'.url($path).'">', false);
            $response->assertSee('<meta name="twitter:card" content="summary_large_image">', false);
        }
    }

    public function test_page_meta_title_and_description_come_from_settings(): void
    {
        Setting::where('key', 'meta_title_tours')->firstOrFail()->update(['value' => 'Configured Tours Title']);
        Setting::where('key', 'meta_description_tours')->firstOrFail()->update(['value' => 'Configured tours description.']);

        $response = $this->get('/tours');

        $response->assertOk();
        $response->assertSee('<title>Configured Tours Title</title>', false);
        $response->assertSee('<meta name="description" content="Configured tours description.">', false);
        $response->assertSee('<meta property="og:title" content="Configured Tours Title">', false);
        $response->assertSee('<meta property="og:description" content="Configured tours description.">', false);
    }

    public function test_sitemap_lists_every_public_page_without_aliases(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
        $response->assertSee('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', false);

        foreach (['/', '/tours', '/custom-tours', '/tour-reports', '/leaders', '/booking', '/contact', '/terms'] as $path) {
            $response->assertSee('<loc>'.url($path).'</loc>', false);
        }

        $response->assertDontSee('/admin', false);
        $response->assertDontSee('/customtours', false);
        $response->assertDontSee('/bookingform', false);
    }

    public function test_robots_txt_disallows_admin_and_references_the_sitemap(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
        $response->assertSee('User-agent: *');
        $response->assertSee('Disallow: /admin');
        $response->assertSee('Sitemap: '.url('/sitemap.xml'));
    }

    public function test_legacy_aliases_redirect_permanently(): void
    {
        $aliases = [
            '/customtours' => '/custom-tours',
            '/tourreports' => '/tour-reports',
            '/bookingform' => '/booking',
            '/terms-and-conditions' => '/terms',
            '/contactus' => '/contact',
        ];

        foreach ($aliases as $from => $to) {
            $this->get($from)->assertStatus(301)->assertRedirect($to);
        }
    }

    public function test_legacy_contactus_alias_still_accepts_form_submissions(): void
    {
        $this->post('/contactus', [
            'first_name' => 'Legacy',
            'last_name' => 'Sender',
            'email' => 'legacy@example.com',
            'message' => 'Legacy contact endpoint test.',
        ])->assertRedirect('/contact');

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'legacy@example.com',
            'status' => 'new',
        ]);
    }
}
