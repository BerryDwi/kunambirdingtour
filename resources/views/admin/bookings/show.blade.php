@extends('admin.layouts.app')

@section('title', 'Booking '.$booking->reference_code)

@section('content')
    <x-admin.page-header :title="'Booking '.$booking->reference_code" :description="$booking->tour_name">
        <x-slot:actions>
            <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">Back to bookings</a>
        </x-slot:actions>
    </x-admin.page-header>

    <div class="grid gap-5 lg:grid-cols-3">
        <div class="space-y-5 lg:col-span-2">
            <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-700">Customer</h2>

                <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Full name</dt>
                        <dd class="mt-1 text-sm font-medium text-slate-800">{{ $booking->full_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Email</dt>
                        <dd class="mt-1 text-sm text-slate-800"><a href="mailto:{{ $booking->email }}" class="text-brand-green underline-offset-2 hover:underline">{{ $booking->email }}</a></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Phone</dt>
                        <dd class="mt-1 text-sm text-slate-800">{{ $booking->phone }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Country</dt>
                        <dd class="mt-1 text-sm text-slate-800">{{ $booking->country }}</dd>
                    </div>
                </dl>
            </section>

            <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-700">Tour details</h2>

                <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Tour</dt>
                        <dd class="mt-1 text-sm font-medium text-slate-800">{{ $booking->tour_name }}</dd>
                        @if ($booking->tour)
                            <p class="text-xs text-slate-400">{{ $booking->tour->name }} (linked tour)</p>
                        @endif
                    </div>
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Year</dt>
                        <dd class="mt-1 text-sm text-slate-800">{{ $booking->tour_year ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Tour type</dt>
                        <dd class="mt-1 text-sm text-slate-800">{{ $booking->tour_type?->label() }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Participants</dt>
                        <dd class="mt-1 text-sm text-slate-800">{{ $booking->participants_count }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Room preference</dt>
                        <dd class="mt-1 text-sm text-slate-800">{{ $booking->room_preference?->label() }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Currency</dt>
                        <dd class="mt-1 text-sm text-slate-800">{{ $booking->currency?->label() }}</dd>
                    </div>
                </dl>
            </section>

            <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-700">Additional information</h2>

                <dl class="mt-4 space-y-4">
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Birding experience</dt>
                        <dd class="mt-1 whitespace-pre-line text-sm text-slate-800">{{ $booking->birding_experience ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Dietary / medical</dt>
                        <dd class="mt-1 whitespace-pre-line text-sm text-slate-800">{{ $booking->dietary_medical ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Special notes</dt>
                        <dd class="mt-1 whitespace-pre-line text-sm text-slate-800">{{ $booking->special_notes ?: '-' }}</dd>
                    </div>
                </dl>
            </section>
        </div>

        <div class="space-y-5">
            <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-700">Status</h2>

                <div class="mt-3 flex flex-wrap gap-2">
                    <x-admin.status-badge :status="$booking->status" />
                    <x-admin.status-badge :status="$booking->payment_status" />
                </div>

                <form method="POST" action="{{ route('admin.bookings.update', $booking) }}" class="mt-4 space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="status" class="block text-xs font-medium text-slate-500">Booking status</label>
                        <select id="status" name="status" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20">
                            @foreach ($statuses as $status)
                                <option value="{{ $status->value }}" @selected($booking->status === $status)>{{ $status->label() }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="payment_status" class="block text-xs font-medium text-slate-500">Payment status</label>
                        <select id="payment_status" name="payment_status" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20">
                            @foreach ($paymentStatuses as $paymentStatus)
                                <option value="{{ $paymentStatus->value }}" @selected($booking->payment_status === $paymentStatus)>{{ $paymentStatus->label() }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-brand-green px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-green/90">Update status</button>
                </form>
            </section>

            <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-700">Metadata</h2>

                <dl class="mt-4 space-y-3 text-sm">
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-slate-500">Received</dt>
                        <dd class="text-slate-800">{{ $booking->created_at?->format('d M Y H:i') }}</dd>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-slate-500">Terms accepted</dt>
                        <dd class="text-slate-800">{{ $booking->terms_accepted_at?->format('d M Y H:i') ?? '-' }}</dd>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-slate-500">IP address</dt>
                        <dd class="text-slate-800">{{ $booking->ip_address ?: '-' }}</dd>
                    </div>
                </dl>
            </section>

            <section class="rounded-xl border border-red-200 bg-white p-5 shadow-sm">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-red-600">Danger zone</h2>
                <p class="mt-2 text-sm text-slate-500">Deleting a booking hides it from the inbox. It can be restored from the database.</p>

                <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}" onsubmit="return confirm('Delete this booking?');" class="mt-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg border border-red-300 px-4 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-50">Delete booking</button>
                </form>
            </section>
        </div>
    </div>
@endsection
