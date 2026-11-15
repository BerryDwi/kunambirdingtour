<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BookingRequest;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BookingController extends Controller
{
    /**
     * Display a filtered listing of bookings.
     */
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'string', 'max:50'],
            'payment_status' => ['nullable', 'string', 'max:50'],
        ]);

        $bookings = $this->filteredQuery($request)
            ->with('tour')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.bookings.index', [
            'bookings' => $bookings,
            'filters' => $filters,
            'statuses' => BookingStatus::cases(),
            'paymentStatuses' => PaymentStatus::cases(),
        ]);
    }

    /**
     * Display the given booking.
     */
    public function show(Booking $booking): View
    {
        return view('admin.bookings.show', [
            'booking' => $booking->load('tour'),
            'statuses' => BookingStatus::cases(),
            'paymentStatuses' => PaymentStatus::cases(),
        ]);
    }

    /**
     * Update the booking status and payment status.
     */
    public function update(BookingRequest $request, Booking $booking): RedirectResponse
    {
        $booking->update($request->validated());

        return redirect()
            ->route('admin.bookings.show', $booking)
            ->with('status', 'Booking updated successfully.');
    }

    /**
     * Soft delete the given booking.
     */
    public function destroy(Booking $booking): RedirectResponse
    {
        $booking->delete();

        return redirect()
            ->route('admin.bookings.index')
            ->with('status', 'Booking deleted successfully.');
    }

    /**
     * Export the filtered bookings as CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        $bookings = $this->filteredQuery($request)->latest()->get();

        return response()->streamDownload(function () use ($bookings): void {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Reference',
                'Tour',
                'Customer',
                'Email',
                'Phone',
                'Country',
                'Participants',
                'Status',
                'Payment status',
                'Created at',
            ]);

            foreach ($bookings as $booking) {
                fputcsv($handle, [
                    $booking->reference_code,
                    $booking->tour_name,
                    $booking->full_name,
                    $booking->email,
                    $booking->phone,
                    $booking->country,
                    $booking->participants_count,
                    $booking->status?->label(),
                    $booking->payment_status?->label(),
                    $booking->created_at?->format('Y-m-d H:i'),
                ]);
            }

            fclose($handle);
        }, 'bookings-'.now()->format('Y-m-d').'.csv');
    }

    /**
     * Build the filtered booking query shared by the listing and export.
     */
    private function filteredQuery(Request $request): Builder
    {
        return Booking::query()
            ->when($request->string('search')->trim()->toString(), function (Builder $query, string $search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('reference_code', 'like', "%{$search}%")
                        ->orWhere('full_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('tour_name', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), fn (Builder $query) => $query->where('status', $request->input('status')))
            ->when($request->filled('payment_status'), fn (Builder $query) => $query->where('payment_status', $request->input('payment_status')));
    }
}
