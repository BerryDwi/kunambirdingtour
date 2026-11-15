<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use App\Models\Leader;
use Illuminate\View\View;

class LeaderController extends Controller
{
    /**
     * Display the tour leaders page.
     */
    public function index(): View
    {
        return view('landing_page.leaders', [
            'slides' => HeroSlide::query()->onPage('leaders')->active()->ordered()->get(),
            'leaders' => Leader::query()->published()->ordered()->get(),
        ]);
    }
}
