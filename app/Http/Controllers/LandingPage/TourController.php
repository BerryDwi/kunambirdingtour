<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use App\Models\Product;
use App\Models\Tour;
use App\Models\TourReport;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class TourController extends Controller
{
    /**
     * Display the home page.
     */
    public function home(): View
    {
        return view('landing_page.home', [
            'slides' => $this->heroSlides('home'),
            'latestReports' => TourReport::query()
                ->latestCards()
                ->published()
                ->ordered()
                ->limit(21)
                ->get(),
            'product' => Product::query()->active()->ordered()->first(),
        ]);
    }

    /**
     * Display the scheduled tours calendar.
     */
    public function tours(): View
    {
        $tourGroups = Tour::query()
            ->published()
            ->ordered()
            ->get()
            ->groupBy('year')
            ->sortKeys();

        $calendarCutoffYear = now()->year + 2;

        $calendarGroups = $tourGroups->filter(
            fn (Collection $yearTours, int|string $year): bool => (int) $year <= $calendarCutoffYear,
        );

        $futureTours = $tourGroups
            ->filter(fn (Collection $yearTours, int|string $year): bool => (int) $year > $calendarCutoffYear)
            ->flatten(1)
            ->values();

        return view('landing_page.tours', [
            'hero' => $this->heroSlides('tours')->first(),
            'calendarGroups' => $calendarGroups,
            'futureTours' => $futureTours,
            'lastCalendarYear' => $calendarGroups->keys()->map(fn (int|string $year): int => (int) $year)->max() ?? now()->year,
        ]);
    }

    /**
     * Load the active hero slides for a page.
     *
     * @return Collection<int, HeroSlide>
     */
    private function heroSlides(string $page): Collection
    {
        return HeroSlide::query()->onPage($page)->active()->ordered()->get();
    }
}
