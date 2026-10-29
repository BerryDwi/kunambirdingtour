<?php

namespace Tests\Feature;

use Tests\TestCase;

class ContactTest extends TestCase
{
    public function test_contact_page_can_be_rendered(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('Contact Birdtour Asia');
        $response->assertSee('info@birdtourasia.com');
        $response->assertSee('office@birdtourasia.com');
        $response->assertSee('+60142234220');
        $response->assertSee('+63 920 831 6564');
        $response->assertSee('Send Us a Message');
    }

    public function test_contactus_alias_route_works(): void
    {
        $response = $this->get('/contactus');

        $response->assertStatus(200);
        $response->assertSee('Contact Birdtour Asia');
    }

    public function test_contact_form_submission_redirects_with_success_message(): void
    {
        $payload = [
            'first_name' => 'Alice',
            'last_name' => 'Smith',
            'email' => 'alice@example.com',
            'phone' => '+44 7700 900077',
            'message' => 'I would like to inquire about the Bhutan tour in April 2027.',
        ];

        $response = $this->post('/contact', $payload);

        $response->assertRedirect('/contact');
        $response->assertSessionHas('contact_success');

        $followUp = $this->get('/contact');
        $followUp->assertSee('Thank you! Your submission has been received!');
    }

    public function test_contact_form_json_submission(): void
    {
        $payload = [
            'first_name' => 'Bob',
            'last_name' => 'Miller',
            'email' => 'bob.miller@example.com',
            'phone' => '+1 415 555 2671',
            'message' => 'Interested in a custom tour to West Papua.',
        ];

        $response = $this->postJson('/contact', $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
    }

    public function test_contact_form_validation_rejects_missing_fields(): void
    {
        $response = $this->post('/contact', []);

        $response->assertSessionHasErrors([
            'first_name',
            'last_name',
            'email',
            'message',
        ]);
    }
}
