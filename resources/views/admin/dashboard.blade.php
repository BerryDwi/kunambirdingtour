@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="space-y-6">
        <section class="rounded-2xl bg-gradient-to-br from-brand-navy to-brand-navy/90 px-6 py-7 text-white shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-brand-green">Welcome back</p>
            <h2 class="mt-2 text-2xl font-semibold">{{ auth()->user()?->name }}</h2>
            <p class="mt-2 max-w-2xl text-sm text-slate-300">
                A snapshot of your content, inbox, and upcoming tours.
            </p>
        </section>

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($stats as $card)
                <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">{{ $card['label'] }}</p>
                    <p class="mt-2 text-3xl font-semibold text-brand-navy">{{ number_format($card['value']) }}</p>
                    <p class="mt-2 text-xs text-slate-400">{{ $card['note'] }}</p>
                </article>
            @endforeach
        </section>

        <section class="grid gap-4 lg:grid-cols-3">
            <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <h3 class="text-base font-semibold text-brand-navy">Tours per year</h3>
                <p class="mt-1 text-xs text-slate-500">Published tours grouped by calendar year.</p>
                <div class="mt-4 h-64">
                    <canvas id="tours-by-year-chart" data-chart="{{ json_encode($toursByYear) }}"></canvas>
                </div>
            </article>

            <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm lg:col-span-2">
                <h3 class="text-base font-semibold text-brand-navy">Inbox activity</h3>
                <p class="mt-1 text-xs text-slate-500">Bookings and contact messages over the last six months.</p>
                <div class="mt-4 h-64">
                    <canvas id="inbox-trend-chart" data-chart="{{ json_encode($inboxTrend) }}"></canvas>
                </div>
            </article>
        </section>

        <section class="grid gap-4 lg:grid-cols-3">
            <article class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm lg:col-span-2">
                <header class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-200 bg-slate-50/70 px-5 py-3">
                    <div>
                        <h3 class="text-base font-semibold text-brand-navy">New tours</h3>
                        <p class="text-xs text-slate-500">The five nearest departures on the calendar.</p>
                    </div>
                    <a href="{{ route('admin.tours.index') }}" class="text-sm font-semibold text-brand-green transition hover:text-brand-green/80">View all</a>
                </header>

                @if ($newTours->isEmpty())
                    <p class="px-5 py-6 text-sm text-slate-500">No upcoming tours yet.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 text-sm">
                            <thead class="bg-slate-50">
                                <tr>
                                    @foreach (['Tour', 'Year', 'Status', 'Published', 'Departure'] as $heading)
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $heading }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($newTours as $tour)
                                    <tr class="transition hover:bg-slate-50/60">
                                        <td class="px-4 py-3">
                                            <a href="{{ route('admin.tours.edit', $tour) }}" class="font-medium text-brand-navy transition hover:text-brand-green">{{ $tour->name }}</a>
                                            <p class="text-xs text-slate-400">{{ $tour->country }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-slate-600">{{ $tour->year }}</td>
                                        <td class="px-4 py-3">
                                            <x-admin.status-badge :status="$tour->status" />
                                        </td>
                                        <td class="px-4 py-3">
                                            <x-admin.status-badge :status="$tour->is_published ? 'published' : 'draft'" />
                                        </td>
                                        <td class="px-4 py-3 text-slate-600">
                                            @if ($tour->start_date)
                                                {{ $tour->start_date->format('d M Y') }}
                                            @elseif ($tour->date_label)
                                                {{ \Illuminate\Support\Str::limit($tour->date_label, 45) }}
                                            @else
                                                —
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </article>

            <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <h3 class="text-base font-semibold text-brand-navy">Tour status</h3>
                <p class="mt-1 text-xs text-slate-500">Distribution across published tours.</p>
                <div class="mt-4 h-64">
                    <canvas id="tour-status-chart" data-chart="{{ json_encode($tourStatus) }}"></canvas>
                </div>
            </article>
        </section>
    </div>
@endsection
