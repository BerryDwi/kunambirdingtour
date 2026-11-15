<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use App\Models\CustomTour;
use App\Models\HeroSlide;
use Illuminate\View\View;

class CustomTourController extends Controller
{
    /**
     * Display the custom tours page.
     */
    public function index(): View
    {
        return view('landing_page.custom_tours', [
            'slides' => HeroSlide::query()->onPage('custom-tours')->active()->ordered()->get(),
            'customTours' => CustomTour::query()->published()->ordered()->get(),
        ]);
    }
}
