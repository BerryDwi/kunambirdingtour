<?php

namespace Tests\Feature;

use App\Models\Setting;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    public function test_booking_page_renders_successfully_with_faqs_and_direct_contact(): void
    {
        $response = $this->get('/booking');

        $response->assertOk();
        $response->assertSee('Booking with Kunam Birding Tours');
        $response->assertSee('Booking FAQs');
        $response->assertSee('How much is the deposit and when is it required?');
        $response->assertDontSee('Scheduled Tours Flowchart');
        $response->assertDontSee('Custom Tours Flowchart');
        $response->assertDontSee('Online Booking &amp; Reservation Form', false);
        $response->assertDontSee('Official Bank Payment Sheets');
        $response->assertDontSee('Financial Consumer Protection (IPP London)', false);
    }

    public function test_booking_contact_links_follow_the_settings(): void
    {
        Setting::where('key', 'contact_email')->firstOrFail()->update(['value' => 'bookings@example.com']);
        Setting::where('key', 'whatsapp_primary_number')->firstOrFail()->update(['value' => '+441234567890']);

        $response = $this->get('/booking');

        $response->assertOk();
        $response->assertSee('bookings@example.com');
        $response->assertSee('WhatsApp (+441234567890)');
        $response->assertSee('https://wa.me/441234567890', false);
    }

    public function test_booking_aliases_are_handled(): void
    {
        $this->get('/bookingform')->assertStatus(301)->assertRedirect('/booking');

        $this->get('/confirm')->assertStatus(301)->assertRedirect('/booking');
    }

    public function test_booking_form_endpoint_is_removed(): void
    {
        $this->post('/booking')->assertStatus(405);
    }
}
