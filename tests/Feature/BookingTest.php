<?php

namespace Tests\Feature;

use App\Enums\Currency;
use App\Enums\TourType;
use App\Mail\Bookings\BookingAutoReply;
use App\Mail\Bookings\NewBookingReceived;
use App\Models\Booking;
use App\Models\Setting;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);

        Mail::fake();
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

        $this->get('/confirm')->assertOk();
    }

    public function test_booking_form_submission_stores_and_redirects_with_flash(): void
    {
        $response = $this->post('/booking', $this->bookingPayload());

        $response->assertRedirect('/booking');
        $response->assertSessionHas('booking_success');

        $followUp = $this->get('/booking');
        $followUp->assertSee('Booking Inquiry Received!');
        $followUp->assertSee('David Attenborough');
    }

    public function test_booking_form_submission_persists_the_booking_and_notifies_both_parties(): void
    {
        $response = $this->withHeader('User-Agent', 'BookingTest/1.0')
            ->post('/booking', $this->bookingPayload());

        $response->assertRedirect('/booking');

        $booking = Booking::query()->firstOrFail();

        $this->assertMatchesRegularExpression('/^BTA-\d{4}-[A-Z0-9]{6}$/', $booking->reference_code);
        $this->assertSame('David Attenborough', $booking->full_name);
        $this->assertSame('china-in-winter-2027', $booking->tour?->slug);
        $this->assertSame(TourType::Scheduled, $booking->tour_type);
        $this->assertSame(Currency::Gbp, $booking->currency);
        $this->assertSame(2, $booking->participants_count);
        $this->assertNotNull($booking->terms_accepted_at);
        $this->assertSame('127.0.0.1', $booking->ip_address);
        $this->assertSame('BookingTest/1.0', $booking->user_agent);

        Mail::assertSent(NewBookingReceived::class, function (NewBookingReceived $mail) use ($booking): bool {
            return $mail->hasTo('office@birdtourasia.com')
                && $mail->booking->is($booking);
        });

        Mail::assertSent(BookingAutoReply::class, function (BookingAutoReply $mail) use ($booking): bool {
            return $mail->hasTo('david@example.com')
                && $mail->booking->is($booking);
        });

        $this->assertStringContainsString($booking->reference_code, (new NewBookingReceived($booking))->render());
        $this->assertStringContainsString($booking->reference_code, (new BookingAutoReply($booking))->render());
    }

    public function test_booking_notification_uses_the_office_email_setting(): void
    {
        Setting::where('key', 'office_email')->firstOrFail()->update(['value' => 'bookings@example.com']);

        $this->post('/booking', $this->bookingPayload())->assertRedirect('/booking');

        Mail::assertSent(NewBookingReceived::class, fn (NewBookingReceived $mail): bool => $mail->hasTo('bookings@example.com'));
    }

    public function test_booking_form_json_submission_returns_success_and_code(): void
    {
        $payload = [
            'tour_type' => 'custom',
            'tour_name' => 'Custom Itinerary - Indonesia',
            'currency' => 'USD',
            'room_preference' => 'single_supplement',
            'full_name' => 'Sarah Connor',
            'email' => 'sarah@example.com',
            'phone' => '+1 555 123 4567',
            'country' => 'United States',
            'participants_count' => 1,
            'terms_accepted' => 1,
        ];

        $response = $this->postJson('/booking', $payload);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'reference_code' => Booking::query()->value('reference_code'),
        ]);
        $response->assertJsonStructure([
            'success',
            'message',
            'reference_code',
            'booking',
        ]);

        $this->assertDatabaseHas('bookings', [
            'email' => 'sarah@example.com',
            'currency' => Currency::Usd->value,
            'tour_type' => TourType::Custom->value,
        ]);
    }

    public function test_booking_form_validation_rejects_missing_required_fields(): void
    {
        $response = $this->post('/booking', []);

        $response->assertSessionHasErrors([
            'tour_type',
            'tour_name',
            'currency',
            'room_preference',
            'full_name',
            'email',
            'phone',
            'country',
            'participants_count',
            'terms_accepted',
        ]);

        $this->assertDatabaseCount('bookings', 0);
        Mail::assertNothingSent();
    }

    public function test_booking_form_rejects_honeypot_submissions(): void
    {
        $response = $this->from('/booking')->post('/booking', [
            ...$this->bookingPayload(),
            'website' => 'https://spam.example',
        ]);

        $response->assertRedirect('/booking');
        $response->assertSessionHasErrors('website');

        $this->assertDatabaseCount('bookings', 0);
        Mail::assertNothingSent();
    }

    public function test_booking_form_is_rate_limited(): void
    {
        for ($attempt = 1; $attempt <= 5; $attempt++) {
            $this->post('/booking', $this->bookingPayload())->assertRedirect('/booking');
        }

        $this->post('/booking', $this->bookingPayload())->assertStatus(429);

        $this->assertDatabaseCount('bookings', 5);
    }

    /**
     * A valid scheduled booking payload.
     *
     * @return array<string, mixed>
     */
    private function bookingPayload(): array
    {
        return [
            'tour_type' => 'scheduled',
            'tour_name' => 'China in winter (2027)',
            'tour_year' => '2027',
            'currency' => 'GBP',
            'room_preference' => 'twin_share',
            'full_name' => 'David Attenborough',
            'email' => 'david@example.com',
            'phone' => '+44 7123 456789',
            'country' => 'United Kingdom',
            'participants_count' => 2,
            'birding_experience' => 'Keen birder / enthusiast',
            'dietary_medical' => 'None',
            'special_notes' => 'Looking forward to Bornean Bristlehead',
            'terms_accepted' => 1,
        ];
    }
}
