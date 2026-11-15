<?php

namespace Database\Factories;

use App\Enums\BookingStatus;
use App\Enums\Currency;
use App\Enums\PaymentStatus;
use App\Enums\RoomPreference;
use App\Enums\TourType;
use App\Models\Booking;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reference_code' => strtoupper(fake()->unique()->bothify('BTA-####-??????')),
            'tour_id' => Tour::factory(),
            'tour_type' => TourType::Scheduled,
            'tour_name' => fake()->words(3, true),
            'tour_year' => (string) fake()->numberBetween(2027, 2030),
            'currency' => Currency::Gbp,
            'room_preference' => RoomPreference::TwinShare,
            'full_name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'country' => fake()->country(),
            'participants_count' => fake()->numberBetween(1, 6),
            'birding_experience' => fake()->randomElement(['Beginner', 'Intermediate', 'Advanced']),
            'dietary_medical' => null,
            'special_notes' => null,
            'terms_accepted_at' => now(),
            'status' => BookingStatus::Pending,
            'payment_status' => PaymentStatus::Unpaid,
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
        ];
    }

    /**
     * Indicate that the booking has been confirmed.
     */
    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => BookingStatus::Confirmed,
        ]);
    }

    /**
     * Indicate that the booking has been paid in full.
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => BookingStatus::Confirmed,
            'payment_status' => PaymentStatus::Paid,
        ]);
    }

    /**
     * Indicate that the booking was cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => BookingStatus::Cancelled,
        ]);
    }
}
