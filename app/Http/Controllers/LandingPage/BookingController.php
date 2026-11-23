<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        return view('landing_page.booking', [
            'slides' => HeroSlide::query()->onPage('booking')->active()->ordered()->get(),
        ]);
    }
}
