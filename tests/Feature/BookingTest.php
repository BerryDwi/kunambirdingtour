<?php

namespace Tests\Feature;

use Tests\TestCase;

class BookingTest extends TestCase
{
    public function test_booking_page_can_be_rendered(): void
    {
        $response = $this->get('/booking');

        $response->assertStatus(200);
        $response->assertSee('Booking with Birdtour Asia');
        $response->assertSee('Scheduled Tours Flowchart');
        $response->assertSee('Custom Tours Flowchart');
        $response->assertSee('Online Booking &amp; Reservation Form', false);
        $response->assertSee('Official Bank Payment Sheets');
        $response->assertSee('Birdtour%20Asia%20Limited%20bank%20details%20GBP.pdf', false);
        $response->assertSee('Birdtour%20Asia%20Limited%20bank%20details%20USD.pdf', false);
    }

    public function test_booking_aliases_can_be_rendered(): void
    {
        $responseForm = $this->get('/bookingform');
        $responseForm->assertStatus(200);

        $responseConfirm = $this->get('/confirm');
        $responseConfirm->assertStatus(200);
    }

    public function test_booking_form_submission_stores_and_redirects_with_flash(): void
    {
        $payload = [
            'tour_type' => 'scheduled',
            'tour_name' => 'Borneo: Sabah & Sarawak (Jul - Aug 2027)',
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

        $response = $this->post('/booking', $payload);

        $response->assertRedirect('/booking');
        $response->assertSessionHas('booking_success');

        $followUp = $this->get('/booking');
        $followUp->assertSee('Booking Inquiry Received!');
        $followUp->assertSee('David Attenborough');
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

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $response->assertJsonStructure([
            'success',
            'message',
            'reference_code',
            'booking',
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
    }
}
