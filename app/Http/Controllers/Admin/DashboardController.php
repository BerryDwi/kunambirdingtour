<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BookingStatus;
use App\Enums\MessageStatus;
use App\Enums\TourStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\Tour;
use App\Models\TourReport;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        $toursByYear = Tour::query()
            ->where('is_published', true)
            ->selectRaw('year, count(*) as aggregate')
            ->groupBy('year')
            ->orderBy('year')
            ->pluck('aggregate', 'year');

        $statusCounts = Tour::query()
            ->where('is_published', true)
            ->selectRaw('status, count(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        $tourStatusLabels = [];
        $tourStatusValues = [];

        foreach (TourStatus::cases() as $status) {
            $tourStatusLabels[] = $status->label();
            $tourStatusValues[] = (int) ($statusCounts[$status->value] ?? 0);
        }

        $months = collect(range(5, 0))
            ->map(fn (int $monthsAgo) => now()->subMonths($monthsAgo)->startOfMonth());

        $bookings = Booking::query()
            ->where('created_at', '>=', $months->first())
            ->get(['created_at']);

        $messages = ContactMessage::query()
            ->where('created_at', '>=', $months->first())
            ->get(['created_at']);

        $bookingCounts = $months
            ->map(fn ($month) => $bookings->filter(fn (Booking $booking): bool => $booking->created_at->isSameMonth($month))->count())
            ->all();

        $messageCounts = $months
            ->map(fn ($month) => $messages->filter(fn (ContactMessage $message): bool => $message->created_at->isSameMonth($month))->count())
            ->all();

        $newTours = Tour::query()
            ->orderByRaw('case when start_date is null then 1 else 0 end')
            ->orderBy('start_date')
            ->orderBy('year')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'stats' => [
                [
                    'label' => 'Tours',
                    'value' => Tour::query()->where('is_published', true)->count(),
                    'note' => Tour::query()->count().' total',
                ],
                [
                    'label' => 'Bookings',
                    'value' => Booking::query()->count(),
                    'note' => Booking::query()->where('status', BookingStatus::Pending)->count().' pending',
                ],
                [
                    'label' => 'Messages',
                    'value' => ContactMessage::query()->count(),
                    'note' => ContactMessage::query()->where('status', MessageStatus::New)->count().' new',
                ],
                [
                    'label' => 'Tour Reports',
                    'value' => TourReport::query()->count(),
                    'note' => 'All records',
                ],
            ],
            'toursByYear' => [
                'labels' => $toursByYear->keys()->map(fn ($year): string => (string) $year)->all(),
                'values' => $toursByYear->values()->map(fn ($total): int => (int) $total)->all(),
            ],
            'tourStatus' => [
                'labels' => $tourStatusLabels,
                'values' => $tourStatusValues,
            ],
            'inboxTrend' => [
                'labels' => $months->map(fn ($month): string => $month->format('M Y'))->all(),
                'bookings' => $bookingCounts,
                'messages' => $messageCounts,
            ],
            'newTours' => $newTours,
        ]);
    }
}
