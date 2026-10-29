<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class LeaderController extends Controller
{
    public function index(): View
    {
        return view('landing_page.leaders');
    }
}
