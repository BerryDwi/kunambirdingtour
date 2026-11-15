<?php

namespace App\Actions\Bookings;

use App\Models\Booking;
use Illuminate\Support\Str;
use RuntimeException;

class GenerateBookingReference
{
    /**
     * Maximum number of attempts before giving up.
     */
    private const MAX_ATTEMPTS = 5;

    /**
     * Generate a unique booking reference in the BTA-YYYY-XXXXXX format.
     */
    public function handle(): string
    {
        for ($attempt = 0; $attempt < self::MAX_ATTEMPTS; $attempt++) {
            $reference = sprintf('BTA-%s-%s', now()->format('Y'), Str::upper(Str::random(6)));

            if (! Booking::withTrashed()->where('reference_code', $reference)->exists()) {
                return $reference;
            }
        }

        throw new RuntimeException('Unable to generate a unique booking reference.');
    }
}
