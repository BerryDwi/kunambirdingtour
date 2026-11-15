<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use App\Models\TourReport;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Display the tour reports page.
     */
    public function index(): View
    {
        return view('landing_page.tour_reports', [
            'slides' => HeroSlide::query()->onPage('reports')->active()->ordered()->get(),
            'categories' => TourReport::query()->categories()->published()->ordered()->get(),
        ]);
    }
}
