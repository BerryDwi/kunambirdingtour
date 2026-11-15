<?php

namespace App\Http\Controllers\LandingPage;

use App\Actions\Contact\SendContactMessageNotifications;
use App\Actions\Contact\StoreContactMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Models\HeroSlide;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('landing_page.contact', [
            'slides' => HeroSlide::query()->onPage('contact')->active()->ordered()->get(),
        ]);
    }

    public function send(
        StoreContactRequest $request,
        StoreContactMessage $storeContactMessage,
        SendContactMessageNotifications $sendNotifications,
    ): JsonResponse|RedirectResponse {
        $contactMessage = $storeContactMessage->handle($request);

        $sendNotifications->handle($contactMessage);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you! Your submission has been received! We will be in touch shortly.',
                'data' => $contactMessage->toArray(),
            ]);
        }

        return redirect()->route('contact')->with('contact_success', 'Thank you! Your submission has been received! We will get back to you shortly.');
    }
}
