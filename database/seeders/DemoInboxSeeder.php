<?php

namespace Database\Seeders;

use App\Enums\BookingStatus;
use App\Enums\Currency;
use App\Enums\MessageStatus;
use App\Enums\PaymentStatus;
use App\Enums\RoomPreference;
use App\Enums\TourType;
use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\Tour;
use Illuminate\Database\Seeder;

class DemoInboxSeeder extends Seeder
{
    /**
     * Seed demo bookings and contact messages for local exploration.
     *
     * This seeder is never called from DatabaseSeeder. Run it manually with
     * `php artisan db:seed --class=DemoInboxSeeder` when you want realistic
     * inbox data to click through in the admin panel.
     */
    public function run(): void
    {
        if (app()->environment('production')) {
            $this->command?->warn('DemoInboxSeeder is disabled in production. Skipping.');

            return;
        }

        $this->seedBookings();
        $this->seedContactMessages();
    }

    /**
     * Seed a small spread of bookings across the status and payment states.
     */
    private function seedBookings(): void
    {
        $bookings = [
            [
                'reference_code' => 'BTA-DEMO-1001',
                'tour_slug' => 'vietnam-2027',
                'tour_name' => 'Vietnam',
                'tour_year' => '2027',
                'currency' => Currency::Gbp,
                'room_preference' => RoomPreference::TwinShare,
                'full_name' => 'James Whitfield',
                'email' => 'james.whitfield@example.com',
                'phone' => '+44 7700 900112',
                'country' => 'United Kingdom',
                'participants_count' => 2,
                'birding_experience' => 'Experienced - 15+ years and 4,000+ world species',
                'dietary_medical' => null,
                'special_notes' => 'Please pair us with non-smokers where possible.',
                'days_ago' => 2,
                'status' => BookingStatus::Pending,
                'payment_status' => PaymentStatus::Unpaid,
            ],
            [
                'reference_code' => 'BTA-DEMO-1002',
                'tour_slug' => 'southern-india-and-andamans-2027',
                'tour_name' => 'Southern India and Andamans',
                'tour_year' => '2027',
                'currency' => Currency::Gbp,
                'room_preference' => RoomPreference::SingleSupplement,
                'full_name' => 'Priya Raman',
                'email' => 'priya.raman@example.com',
                'phone' => '+91 98765 43210',
                'country' => 'India',
                'participants_count' => 1,
                'birding_experience' => 'Intermediate - 200 to 500 species',
                'dietary_medical' => 'Vegetarian. Mild peanut allergy, carries antihistamines.',
                'special_notes' => 'Interested in the Andaman endemics extension if available.',
                'days_ago' => 9,
                'status' => BookingStatus::Confirmed,
                'payment_status' => PaymentStatus::DepositPaid,
            ],
            [
                'reference_code' => 'BTA-DEMO-1003',
                'tour_slug' => 'japan-classic-winter-2027',
                'tour_name' => 'Japan: Classic Winter',
                'tour_year' => '2027',
                'currency' => Currency::Usd,
                'room_preference' => RoomPreference::TwinShare,
                'full_name' => 'Tomasz Kowalski',
                'email' => 'tomasz.kowalski@example.com',
                'phone' => '+48 601 234 567',
                'country' => 'Poland',
                'participants_count' => 1,
                'birding_experience' => 'Advanced - 1,000 to 3,000 species',
                'dietary_medical' => 'No dietary requirements.',
                'special_notes' => 'Main targets are Blakiston\'s Fish Owl and Steller\'s Sea Eagle.',
                'days_ago' => 21,
                'status' => BookingStatus::Completed,
                'payment_status' => PaymentStatus::Paid,
            ],
            [
                'reference_code' => 'BTA-DEMO-1004',
                'tour_slug' => 'borneo-sabah-and-sarawak-2027',
                'tour_name' => 'Borneo: Sabah & Sarawak',
                'tour_year' => '2027',
                'currency' => Currency::Gbp,
                'room_preference' => RoomPreference::TwinShare,
                'full_name' => 'Sarah Bennett',
                'email' => 'sarah.bennett@example.com',
                'phone' => '+61 412 345 678',
                'country' => 'Australia',
                'participants_count' => 2,
                'birding_experience' => 'Beginner - under 200 species',
                'dietary_medical' => null,
                'special_notes' => 'Had to withdraw due to a family commitment.',
                'days_ago' => 35,
                'status' => BookingStatus::Cancelled,
                'payment_status' => PaymentStatus::Refunded,
            ],
        ];

        foreach ($bookings as $booking) {
            $createdAt = now()->subDays($booking['days_ago']);

            $record = Booking::updateOrCreate(
                ['reference_code' => $booking['reference_code']],
                [
                    'tour_id' => Tour::where('slug', $booking['tour_slug'])->value('id'),
                    'tour_type' => TourType::Scheduled,
                    'tour_name' => $booking['tour_name'],
                    'tour_year' => $booking['tour_year'],
                    'currency' => $booking['currency'],
                    'room_preference' => $booking['room_preference'],
                    'full_name' => $booking['full_name'],
                    'email' => $booking['email'],
                    'phone' => $booking['phone'],
                    'country' => $booking['country'],
                    'participants_count' => $booking['participants_count'],
                    'birding_experience' => $booking['birding_experience'],
                    'dietary_medical' => $booking['dietary_medical'],
                    'special_notes' => $booking['special_notes'],
                    'terms_accepted_at' => $createdAt,
                    'status' => $booking['status'],
                    'payment_status' => $booking['payment_status'],
                    'ip_address' => '127.0.0.1',
                    'user_agent' => 'Mozilla/5.0 (DemoInboxSeeder)',
                ],
            );

            // Backdate the inbox entry so it sorts like a real stream of enquiries.
            Booking::whereKey($record->getKey())->update([
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }

    /**
     * Seed a small spread of contact messages across the inbox states.
     */
    private function seedContactMessages(): void
    {
        $messages = [
            [
                'first_name' => 'Elena',
                'last_name' => 'Petrova',
                'email' => 'elena.petrova@example.com',
                'phone' => '+7 916 123 4567',
                'message' => 'Hello, we are two birders from Moscow looking at the Cambodia and Laos departure in March 2027. Could you confirm whether the Cambodian Laughingthrush extension can be added after the main tour? Thank you.',
                'days_ago' => 1,
                'status' => MessageStatus::New,
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Okafor',
                'email' => 'david.okafor@example.com',
                'phone' => null,
                'message' => 'I would like to order two pairs of leech socks, one small and one large, and have them delivered to London. What is the best way to pay in GBP?',
                'days_ago' => 4,
                'status' => MessageStatus::Read,
            ],
            [
                'first_name' => 'Mei',
                'last_name' => 'Tan',
                'email' => 'mei.tan@example.com',
                'phone' => '+65 8123 4567',
                'message' => 'We are planning a private family trip to Sabah in July and would love to include Sepilok, Kinabalu and the Kinabatangan. Could you send an outline itinerary and an idea of costs for four people?',
                'days_ago' => 12,
                'status' => MessageStatus::Replied,
            ],
            [
                'first_name' => 'Robert',
                'last_name' => 'Hughes',
                'email' => 'robert.hughes@example.com',
                'phone' => '+1 415 555 0132',
                'message' => 'Thank you for the prompt reply about the Japan winter tour. I have decided to postpone until 2028 and will be in touch later in the year.',
                'days_ago' => 40,
                'status' => MessageStatus::Archived,
            ],
        ];

        foreach ($messages as $message) {
            $createdAt = now()->subDays($message['days_ago']);

            $record = ContactMessage::updateOrCreate(
                ['email' => $message['email']],
                [
                    'first_name' => $message['first_name'],
                    'last_name' => $message['last_name'],
                    'phone' => $message['phone'],
                    'message' => $message['message'],
                    'status' => $message['status'],
                    'ip_address' => '127.0.0.1',
                    'user_agent' => 'Mozilla/5.0 (DemoInboxSeeder)',
                ],
            );

            // Backdate the inbox entry so it sorts like a real stream of enquiries.
            ContactMessage::whereKey($record->getKey())->update([
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }
}
