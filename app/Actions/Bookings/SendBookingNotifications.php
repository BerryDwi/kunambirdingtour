<?php

namespace App\Actions\Bookings;

use App\Mail\Bookings\BookingAutoReply;
use App\Mail\Bookings\NewBookingReceived;
use App\Models\Booking;
use App\Models\Setting;
use Closure;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendBookingNotifications
{
    /**
     * Email the office and the traveller about a new booking inquiry.
     */
    public function handle(Booking $booking): void
    {
        $this->send(fn () => Mail::to(Setting::officeEmail())->send(new NewBookingReceived($booking)));
        $this->send(fn () => Mail::to($booking->email)->send(new BookingAutoReply($booking)));
    }

    /**
     * Deliver a notification without failing the booking already persisted.
     */
    private function send(Closure $callback): void
    {
        try {
            $callback();
        } catch (Throwable $exception) {
            report($exception);
        }
    }
}
