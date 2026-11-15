<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use App\Models\TermsSection;
use Illuminate\View\View;

class TermsController extends Controller
{
    /**
     * Display the terms and conditions page.
     */
    public function index(): View
    {
        return view('landing_page.terms', [
            'slides' => HeroSlide::query()->onPage('terms')->active()->ordered()->get(),
            'sections' => TermsSection::query()->ordered()->get(),
        ]);
    }
}
