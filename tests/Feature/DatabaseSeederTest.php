<?php

namespace Tests\Feature;

use App\Enums\BookingStatus;
use App\Enums\Currency;
use App\Enums\TourStatus;
use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\CustomTour;
use App\Models\HeroSlide;
use App\Models\Leader;
use App\Models\Product;
use App\Models\Setting;
use App\Models\TermsSection;
use App\Models\Tour;
use App\Models\TourReport;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\DemoInboxSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_default_seeding_replicates_the_public_content(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(57, Setting::count());
        $this->assertSame(30, HeroSlide::count());
        $this->assertSame(16, Tour::count());
        $this->assertSame(15, Leader::count());
        $this->assertSame(20, TourReport::categories()->count());
        $this->assertSame(21, TourReport::latestCards()->count());
        $this->assertSame(14, TermsSection::count());
        $this->assertSame(1, Product::count());
        $this->assertSame(3, CustomTour::count());
        $this->assertSame(3, CustomTour::where('is_published', true)->count());
        $this->assertDatabaseHas('custom_tours', [
            'slug' => 'sulawesi-endemics-2027',
            'status' => 'open',
            'is_published' => true,
        ]);

        $aboutBody = (string) Setting::where('key', 'home_about_body')->value('value');

        $this->assertStringContainsString('Kunam Birding Tours are the specialists in birding tours', $aboutBody);
        $this->assertStringNotContainsString('<', $aboutBody);
    }

    public function test_default_seeding_creates_the_admin_without_an_inbox(): void
    {
        $this->seed(DatabaseSeeder::class);

        $admin = User::where('email', config('admin.email'))->first();

        $this->assertNotNull($admin);
        $this->assertTrue($admin->is_admin);
        $this->assertDatabaseMissing('users', ['email' => 'test@example.com']);
        $this->assertSame(0, Booking::count());
        $this->assertSame(0, ContactMessage::count());
    }

    public function test_content_seeding_is_idempotent(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(57, Setting::count());
        $this->assertSame(30, HeroSlide::count());
        $this->assertSame(16, Tour::count());
        $this->assertSame(15, Leader::count());
        $this->assertSame(41, TourReport::count());
        $this->assertSame(14, TermsSection::count());
        $this->assertSame(1, Product::count());
        $this->assertSame(3, CustomTour::count());
        $this->assertSame(1, User::count());
    }

    public function test_hero_slides_are_grouped_by_page(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(4, HeroSlide::where('page', 'home')->count());
        $this->assertSame(1, HeroSlide::where('page', 'tours')->count());
        $this->assertSame(5, HeroSlide::where('page', 'custom-tours')->count());
        $this->assertSame(5, HeroSlide::where('page', 'reports')->count());
        $this->assertSame(5, HeroSlide::where('page', 'leaders')->count());
        $this->assertSame(4, HeroSlide::where('page', 'booking')->count());
        $this->assertSame(3, HeroSlide::where('page', 'contact')->count());
        $this->assertSame(3, HeroSlide::where('page', 'terms')->count());
        $this->assertSame(30, HeroSlide::where('is_active', true)->count());
    }

    public function test_tours_match_the_published_calendar(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(16, Tour::where('is_published', true)->count());
        $this->assertSame(9, Tour::where('status', TourStatus::Full)->count());
        $this->assertSame(5, Tour::where('status', TourStatus::Available)->count());
        $this->assertSame(2, Tour::where('status', TourStatus::Provisional)->count());
        $this->assertSame(11, Tour::where('year', 2027)->count());
        $this->assertSame(4, Tour::where('year', 2028)->count());

        $this->assertDatabaseHas('tours', [
            'slug' => 'cambodia-and-laos-2027',
            'status' => TourStatus::Available->value,
            'is_published' => true,
            'status_label' => 'One space available',
        ]);
        $this->assertDatabaseHas('tours', [
            'slug' => 'eastern-polynesia',
            'status_label' => 'Waiting list available',
        ]);
        $this->assertDatabaseHas('tours', [
            'slug' => 'banda-sea-liveaboard-cruise-tanimbars-2028',
            'status_label' => 'Tour is provisionally full',
        ]);
        $this->assertSame(7, Tour::whereNotNull('status_label')->count());

        $fullTour = Tour::where('slug', 'china-in-winter-2027')->firstOrFail();

        $this->assertNull($fullTour->status_label);
        $this->assertSame('Tour is full', $fullTour->statusLabel());
    }

    public function test_leaders_keep_their_badge_styles(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(15, Leader::where('is_published', true)->count());
        $this->assertDatabaseHas('leaders', ['slug' => 'bob-natural', 'badge_style' => 'info']);
        $this->assertDatabaseHas('leaders', ['slug' => 'prof-frank-rheindt', 'badge_style' => 'warning']);
        $this->assertSame(13, Leader::where('badge_style', 'success')->count());
    }

    public function test_tour_reports_are_split_into_categories_and_latest_cards(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(20, TourReport::where('kind', 'category')->count());
        $this->assertSame(21, TourReport::where('kind', 'latest')->count());
        $this->assertSame(21, TourReport::where('is_featured', true)->count());
        $this->assertSame(41, TourReport::where('is_published', true)->count());

        $this->assertDatabaseHas('tour_reports', [
            'slug' => 'borneo',
            'kind' => 'category',
            'report_url' => 'https://www.birdtourasia.com/borneoreports',
        ]);
        $this->assertDatabaseHas('tour_reports', [
            'slug' => 'lesser-florican-western-himalaya',
            'kind' => 'latest',
            'summary' => 'July - August 2026',
        ]);
    }

    public function test_terms_sections_are_numbered_in_order(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(range(1, 14), TermsSection::ordered()->pluck('number')->all());
        $this->assertSame(
            'Financial Security & Insolvency Protection',
            TermsSection::where('number', 1)->value('title'),
        );
        $this->assertStringContainsString(
            'Package Travel and Linked Travel Arrangements Regulations 2018',
            TermsSection::where('number', 1)->value('body'),
        );
        $this->assertSame(0, TermsSection::where('body', '')->count());
        $this->assertSame(
            'Financial Security (IPP London)',
            TermsSection::where('number', 1)->value('nav_title'),
        );
        $this->assertSame(
            'Liability & Land Only Terms',
            TermsSection::where('number', 13)->value('nav_title'),
        );
        $this->assertSame(
            'Complaints & Governing Law',
            TermsSection::where('number', 14)->firstOrFail()->navTitle(),
        );
        $this->assertSame(
            'financial-security',
            TermsSection::where('number', 1)->firstOrFail()->anchorId(),
        );
        $this->assertSame(
            'complaints',
            TermsSection::where('number', 14)->firstOrFail()->anchorId(),
        );
        $this->assertSame(14, TermsSection::whereNotNull('anchor')->count());
    }

    public function test_the_leech_socks_product_is_seeded(): void
    {
        $this->seed(DatabaseSeeder::class);

        $product = Product::where('slug', 'leech-socks')->firstOrFail();

        $this->assertSame('Leech Socks', $product->name);
        $this->assertSame(18, $product->price);
        $this->assertSame(Currency::Gbp, $product->currency);
        $this->assertTrue($product->is_active);
    }

    public function test_demo_inbox_seeder_adds_realistic_inbox_data_idempotently(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->seed(DemoInboxSeeder::class);
        $this->seed(DemoInboxSeeder::class);

        $this->assertSame(4, Booking::count());
        $this->assertSame(4, ContactMessage::count());
        $this->assertSame(1, Booking::where('status', BookingStatus::Pending)->count());
        $this->assertDatabaseHas('bookings', [
            'reference_code' => 'BTA-DEMO-1001',
            'full_name' => 'James Whitfield',
        ]);
        $this->assertDatabaseHas('contact_messages', [
            'email' => 'elena.petrova@example.com',
            'status' => 'new',
        ]);
    }
}
