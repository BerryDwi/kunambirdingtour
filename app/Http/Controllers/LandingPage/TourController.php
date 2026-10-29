<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class TourController extends Controller
{
    public function home(): View
    {
        return view('landing_page.home');
    }

    public function tours(): View
    {
        return view('landing_page.tours');
    }
}
