<?php

namespace Tests\Feature;

use App\Enums\MessageStatus;
use App\Mail\Contact\ContactAutoReply;
use App\Mail\Contact\NewContactMessageReceived;
use App\Models\ContactMessage;
use App\Models\Setting;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);

        Mail::fake();
    }

    public function test_contact_page_renders_the_seeded_contact_details(): void
    {
        $response = $this->get('/contact');

        $response->assertOk();
        $response->assertSee('Contact Birdtour Asia');
        $response->assertSee('info@birdtourasia.com');
        $response->assertSee('office@birdtourasia.com');
        $response->assertSee('+60142234220');
        $response->assertSee('+63 920 831 6564');
        $response->assertSee('James Eaton');
        $response->assertSee('Rob Hutchinson');
        $response->assertSee('26 Sutton Avenue, Derby, DE73 6RJ, United Kingdom');
        $response->assertSee('Send Us a Message');
    }

    public function test_contact_details_follow_the_settings(): void
    {
        Setting::where('key', 'contact_email')->firstOrFail()->update(['value' => 'hello@example.com']);
        Setting::where('key', 'office_email')->firstOrFail()->update(['value' => 'backoffice@example.com']);
        Setting::where('key', 'facebook_url')->firstOrFail()->update(['value' => 'https://www.facebook.com/example']);

        $response = $this->get('/contact');

        $response->assertOk();
        $response->assertSee('hello@example.com');
        $response->assertSee('backoffice@example.com');
        $response->assertSee('https://www.facebook.com/example', false);
    }

    public function test_contactus_alias_route_redirects_permanently(): void
    {
        $response = $this->get('/contactus');

        $response->assertStatus(301);
        $response->assertRedirect('/contact');
    }

    public function test_contact_form_submission_redirects_with_success_message(): void
    {
        $response = $this->post('/contact', $this->contactPayload());

        $response->assertRedirect('/contact');
        $response->assertSessionHas('contact_success');

        $followUp = $this->get('/contact');
        $followUp->assertSee('Thank you! Your submission has been received!');
    }

    public function test_contact_form_submission_persists_the_message_and_notifies_both_parties(): void
    {
        $response = $this->withHeader('User-Agent', 'ContactTest/1.0')
            ->post('/contact', $this->contactPayload());

        $response->assertRedirect('/contact');

        $contactMessage = ContactMessage::query()->firstOrFail();

        $this->assertSame('Alice', $contactMessage->first_name);
        $this->assertSame('Smith', $contactMessage->last_name);
        $this->assertSame('alice@example.com', $contactMessage->email);
        $this->assertSame(MessageStatus::New, $contactMessage->status);
        $this->assertSame('127.0.0.1', $contactMessage->ip_address);
        $this->assertSame('ContactTest/1.0', $contactMessage->user_agent);

        Mail::assertSent(NewContactMessageReceived::class, function (NewContactMessageReceived $mail) use ($contactMessage): bool {
            return $mail->hasTo('office@birdtourasia.com')
                && $mail->contactMessage->is($contactMessage);
        });

        Mail::assertSent(ContactAutoReply::class, function (ContactAutoReply $mail) use ($contactMessage): bool {
            return $mail->hasTo('alice@example.com')
                && $mail->contactMessage->is($contactMessage);
        });

        $this->assertStringContainsString('Alice Smith', (new NewContactMessageReceived($contactMessage))->render());
        $this->assertStringContainsString($contactMessage->message, (new ContactAutoReply($contactMessage))->render());
    }

    public function test_contact_notification_uses_the_office_email_setting(): void
    {
        Setting::where('key', 'office_email')->firstOrFail()->update(['value' => 'enquiries@example.com']);

        $this->post('/contact', $this->contactPayload())->assertRedirect('/contact');

        Mail::assertSent(NewContactMessageReceived::class, fn (NewContactMessageReceived $mail): bool => $mail->hasTo('enquiries@example.com'));
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

        $response->assertOk();
        $response->assertJson([
            'success' => true,
        ]);
        $response->assertJsonStructure([
            'success',
            'message',
            'data',
        ]);

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'bob.miller@example.com',
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

        $this->assertDatabaseCount('contact_messages', 0);
        Mail::assertNothingSent();
    }

    public function test_contact_form_rejects_honeypot_submissions(): void
    {
        $response = $this->from('/contact')->post('/contact', [
            ...$this->contactPayload(),
            'website' => 'https://spam.example',
        ]);

        $response->assertRedirect('/contact');
        $response->assertSessionHasErrors('website');

        $this->assertDatabaseCount('contact_messages', 0);
        Mail::assertNothingSent();
    }

    public function test_contact_form_is_rate_limited(): void
    {
        for ($attempt = 1; $attempt <= 5; $attempt++) {
            $this->post('/contact', $this->contactPayload())->assertRedirect('/contact');
        }

        $this->post('/contact', $this->contactPayload())->assertStatus(429);

        $this->assertDatabaseCount('contact_messages', 5);
    }

    /**
     * A valid contact message payload.
     *
     * @return array<string, mixed>
     */
    private function contactPayload(): array
    {
        return [
            'first_name' => 'Alice',
            'last_name' => 'Smith',
            'email' => 'alice@example.com',
            'phone' => '+44 7700 900077',
            'message' => 'I would like to inquire about the Bhutan tour in April 2027.',
        ];
    }
}
