<?php

namespace App\Http\Controllers\LandingPage;

use App\Actions\Bookings\CreateBooking;
use App\Actions\Bookings\SendBookingNotifications;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Models\HeroSlide;
use App\Models\Tour;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        return view('landing_page.booking', $this->viewData());
    }

    public function confirm(): View
    {
        return view('landing_page.booking', $this->viewData() + ['activeTab' => 'payment-info']);
    }

    public function store(
        StoreBookingRequest $request,
        CreateBooking $createBooking,
        SendBookingNotifications $sendNotifications,
    ): JsonResponse|RedirectResponse {
        $booking = $createBooking->handle($request);

        $sendNotifications->handle($booking);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you for your booking inquiry! Your request has been received.',
                'reference_code' => $booking->reference_code,
                'booking' => $booking->toArray(),
            ]);
        }

        return redirect()->route('booking')->with('booking_success', [
            'reference_code' => $booking->reference_code,
            'full_name' => $booking->full_name,
            'tour_name' => $booking->tour_name,
            'email' => $booking->email,
            'submitted_at' => $booking->created_at->toFormattedDateString(),
        ]);
    }

    /**
     * Data shared by the booking form and confirmation tabs.
     *
     * @return array<string, mixed>
     */
    private function viewData(): array
    {
        return [
            'slides' => HeroSlide::query()->onPage('booking')->active()->ordered()->get(),
            'tourGroups' => Tour::query()->published()->ordered()->get()->groupBy('year')->sortKeys(),
        ];
    }
}
