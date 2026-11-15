<?php

namespace Tests\Feature\Admin;

use App\Enums\BookingStatus;
use App\Enums\MessageStatus;
use App\Enums\PaymentStatus;
use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InboxManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_users_cannot_access_the_inbox(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.bookings.index'))
            ->assertForbidden();

        $this->actingAs(User::factory()->create())
            ->get(route('admin.contact-messages.index'))
            ->assertForbidden();
    }

    public function test_admin_can_see_bookings_and_filter_by_status(): void
    {
        $pending = Booking::factory()->create([
            'full_name' => 'Pending Customer',
            'status' => BookingStatus::Pending,
        ]);
        $confirmed = Booking::factory()->create([
            'full_name' => 'Confirmed Customer',
            'status' => BookingStatus::Confirmed,
        ]);

        $this->actingAs($this->admin())
            ->get(route('admin.bookings.index'))
            ->assertOk()
            ->assertSee($pending->reference_code)
            ->assertSee($confirmed->reference_code);

        $this->actingAs($this->admin())
            ->get(route('admin.bookings.index', ['status' => BookingStatus::Confirmed->value]))
            ->assertOk()
            ->assertSee('Confirmed Customer')
            ->assertDontSee('Pending Customer');
    }

    public function test_admin_can_view_a_booking(): void
    {
        $booking = Booking::factory()->create([
            'full_name' => 'Jane Birder',
            'special_notes' => 'Keen photographer.',
        ]);

        $this->actingAs($this->admin())
            ->get(route('admin.bookings.show', $booking))
            ->assertOk()
            ->assertSee($booking->reference_code)
            ->assertSee('Jane Birder')
            ->assertSee('Keen photographer.');
    }

    public function test_admin_can_update_a_booking_status(): void
    {
        $booking = Booking::factory()->create([
            'status' => BookingStatus::Pending,
            'payment_status' => PaymentStatus::Unpaid,
        ]);

        $this->actingAs($this->admin())
            ->put(route('admin.bookings.update', $booking), [
                'status' => BookingStatus::Confirmed->value,
                'payment_status' => PaymentStatus::DepositPaid->value,
            ])
            ->assertRedirect(route('admin.bookings.show', $booking));

        $booking->refresh();

        $this->assertSame(BookingStatus::Confirmed, $booking->status);
        $this->assertSame(PaymentStatus::DepositPaid, $booking->payment_status);
    }

    public function test_admin_can_soft_delete_a_booking(): void
    {
        $booking = Booking::factory()->create();

        $this->actingAs($this->admin())
            ->delete(route('admin.bookings.destroy', $booking))
            ->assertRedirect(route('admin.bookings.index'));

        $this->assertSoftDeleted($booking);
    }

    public function test_bookings_can_be_exported_as_csv(): void
    {
        $booking = Booking::factory()->create(['full_name' => 'Export Customer']);

        $response = $this->actingAs($this->admin())
            ->get(route('admin.bookings.export'))
            ->assertOk();

        $content = $response->streamedContent();

        $this->assertStringContainsString('Reference', $content);
        $this->assertStringContainsString($booking->reference_code, $content);
        $this->assertStringContainsString('Export Customer', $content);
    }

    public function test_admin_can_see_contact_messages_and_filter_by_status(): void
    {
        $new = ContactMessage::factory()->create([
            'first_name' => 'New',
            'last_name' => 'Sender',
            'status' => MessageStatus::New,
        ]);
        $replied = ContactMessage::factory()->replied()->create([
            'first_name' => 'Replied',
            'last_name' => 'Sender',
        ]);

        $this->actingAs($this->admin())
            ->get(route('admin.contact-messages.index'))
            ->assertOk()
            ->assertSee('New Sender')
            ->assertSee('Replied Sender');

        $this->actingAs($this->admin())
            ->get(route('admin.contact-messages.index', ['status' => MessageStatus::Replied->value]))
            ->assertOk()
            ->assertSee('Replied Sender')
            ->assertDontSee('New Sender');
    }

    public function test_viewing_a_new_message_marks_it_as_read(): void
    {
        $message = ContactMessage::factory()->create(['status' => MessageStatus::New]);

        $this->actingAs($this->admin())
            ->get(route('admin.contact-messages.show', $message))
            ->assertOk()
            ->assertSee($message->message);

        $this->assertSame(MessageStatus::Read, $message->refresh()->status);
    }

    public function test_admin_can_update_a_message_status(): void
    {
        $message = ContactMessage::factory()->create(['status' => MessageStatus::Read]);

        $this->actingAs($this->admin())
            ->put(route('admin.contact-messages.update', $message), [
                'status' => MessageStatus::Replied->value,
            ])
            ->assertRedirect(route('admin.contact-messages.show', $message));

        $this->assertSame(MessageStatus::Replied, $message->refresh()->status);
    }

    public function test_admin_can_delete_a_contact_message(): void
    {
        $message = ContactMessage::factory()->create();

        $this->actingAs($this->admin())
            ->delete(route('admin.contact-messages.destroy', $message))
            ->assertRedirect(route('admin.contact-messages.index'));

        $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
    }

    public function test_contact_messages_can_be_exported_as_csv(): void
    {
        $message = ContactMessage::factory()->create([
            'first_name' => 'Export',
            'last_name' => 'Sender',
        ]);

        $response = $this->actingAs($this->admin())
            ->get(route('admin.contact-messages.export'))
            ->assertOk();

        $content = $response->streamedContent();

        $this->assertStringContainsString('Export Sender', $content);
        $this->assertStringContainsString($message->email, $content);
    }

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->forceFill(['is_admin' => true])->save();

        return $user;
    }
}
