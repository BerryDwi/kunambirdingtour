@extends('admin.layouts.app')

@section('title', 'Bookings')

@section('content')
    <x-admin.page-header title="Bookings" description="Review and manage tour booking requests.">
        <x-slot:actions>
            <a href="{{ route('admin.bookings.export', request()->query()) }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                Export CSV
            </a>
        </x-slot:actions>
    </x-admin.page-header>

    <form method="GET" action="{{ route('admin.bookings.index') }}" class="mb-5 grid gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:grid-cols-2 lg:grid-cols-6">
        <div class="lg:col-span-2">
            <label for="search" class="block text-xs font-medium text-slate-500">Search</label>
            <input id="search" name="search" type="search" value="{{ $filters['search'] ?? '' }}" placeholder="Reference, name, email or tour" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20">
        </div>

        <div>
            <label for="status" class="block text-xs font-medium text-slate-500">Booking status</label>
            <select id="status" name="status" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20">
                <option value="">All</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status->value }}" @selected(($filters['status'] ?? null) === $status->value)>{{ $status->label() }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="payment_status" class="block text-xs font-medium text-slate-500">Payment</label>
            <select id="payment_status" name="payment_status" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20">
                <option value="">All</option>
                @foreach ($paymentStatuses as $paymentStatus)
                    <option value="{{ $paymentStatus->value }}" @selected(($filters['payment_status'] ?? null) === $paymentStatus->value)>{{ $paymentStatus->label() }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-end gap-2 lg:col-span-2">
            <button type="submit" class="inline-flex flex-1 items-center justify-center rounded-lg bg-brand-navy px-3 py-2 text-sm font-semibold text-white transition hover:bg-brand-navy/90">Filter</button>
            <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50">Reset</a>
        </div>
    </form>

    @if ($bookings->isEmpty())
        <x-admin.empty-state title="No bookings found" description="New booking requests from the website will appear here." />
    @else
        <x-admin.table :headings="['Reference', 'Customer', 'Tour', 'Participants', 'Status', 'Payment', 'Received', 'Actions']">
            @foreach ($bookings as $booking)
                <tr class="align-middle transition hover:bg-slate-50/70">
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.bookings.show', $booking) }}" class="font-semibold text-brand-navy underline-offset-2 hover:underline">{{ $booking->reference_code }}</a>
                        <p class="text-xs text-slate-400">{{ $booking->tour_type?->label() }}</p>
                    </td>

                    <td class="px-4 py-3">
                        <p class="font-medium text-slate-800">{{ $booking->full_name }}</p>
                        <p class="text-xs text-slate-400">{{ $booking->email }}</p>
                    </td>

                    <td class="px-4 py-3">
                        <p class="text-sm text-slate-700">{{ $booking->tour_name }}</p>
                        <p class="text-xs text-slate-400">{{ $booking->tour_year ?: '-' }}</p>
                    </td>

                    <td class="px-4 py-3 text-slate-600">{{ $booking->participants_count }}</td>

                    <td class="px-4 py-3">
                        <x-admin.status-badge :status="$booking->status" />
                    </td>

                    <td class="px-4 py-3">
                        <x-admin.status-badge :status="$booking->payment_status" />
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-500">{{ $booking->created_at?->format('d M Y') }}</td>

                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end">
                            <a href="{{ route('admin.bookings.show', $booking) }}" class="rounded-md border border-slate-300 px-2.5 py-1.5 text-xs font-medium text-slate-700 transition hover:bg-slate-50">View</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-admin.table>

        <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-slate-500">Showing {{ $bookings->firstItem() }}-{{ $bookings->lastItem() }} of {{ $bookings->total() }} bookings</p>
            {{ $bookings->links() }}
        </div>
    @endif
@endsection
