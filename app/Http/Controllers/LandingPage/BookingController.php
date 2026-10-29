<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        return view('landing_page.booking');
    }

    public function confirm(): View
    {
        return view('landing_page.booking', ['activeTab' => 'payment-info']);
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'tour_type' => ['required', 'string', 'in:scheduled,custom'],
            'tour_name' => ['required', 'string', 'max:255'],
            'tour_year' => ['nullable', 'string', 'max:50'],
            'currency' => ['required', 'string', 'in:GBP,USD'],
            'room_preference' => ['required', 'string', 'in:twin_share,single_supplement'],
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'country' => ['required', 'string', 'max:100'],
            'participants_count' => ['required', 'integer', 'min:1', 'max:20'],
            'birding_experience' => ['nullable', 'string', 'max:100'],
            'dietary_medical' => ['nullable', 'string', 'max:1000'],
            'special_notes' => ['nullable', 'string', 'max:2000'],
            'terms_accepted' => ['required', 'accepted'],
        ]);

        $referenceCode = 'BTA-'.date('Y').'-'.strtoupper(substr(md5(uniqid((string) mt_rand(), true)), 0, 6));

        $bookingData = array_merge($validated, [
            'reference_code' => $referenceCode,
            'submitted_at' => now()->toFormattedDateString(),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you for your booking inquiry! Your request has been received.',
                'reference_code' => $referenceCode,
                'booking' => $bookingData,
            ]);
        }

        return redirect()->route('booking')->with('booking_success', $bookingData);
    }
}
