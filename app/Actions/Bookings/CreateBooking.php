<?php

namespace App\Actions\Bookings;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Tour;

class CreateBooking
{
    public function __construct(private GenerateBookingReference $generateReference) {}

    /**
     * Persist a booking inquiry submitted through the public form.
     */
    public function handle(StoreBookingRequest $request): Booking
    {
        $data = $request->validated();

        unset($data['website'], $data['terms_accepted']);

        $tour = $this->resolveTour($data);

        return Booking::create([
            ...$data,
            'reference_code' => $this->generateReference->handle(),
            'tour_id' => $tour?->id,
            'terms_accepted_at' => now(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }

    /**
     * Match the selected scheduled departure to a published tour when possible.
     *
     * @param  array<string, mixed>  $data
     */
    private function resolveTour(array $data): ?Tour
    {
        if (($data['tour_type'] ?? null) !== 'scheduled') {
            return null;
        }

        $name = (string) $data['tour_name'];
        $year = $data['tour_year'] ?? null;

        if (preg_match('/^(.*) \((\d{4})\)$/', $name, $matches) === 1) {
            $name = $matches[1];
            $year = $matches[2];
        }

        return Tour::query()
            ->where('name', $name)
            ->when($year, fn ($query) => $query->where('year', $year))
            ->first();
    }
}
