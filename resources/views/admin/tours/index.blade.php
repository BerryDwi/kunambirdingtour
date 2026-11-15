@extends('admin.layouts.app')

@section('title', 'Tours')

@section('content')
    <x-admin.page-header title="Tours" description="Manage scheduled departures, pricing, and visibility.">
        <x-slot:actions>
            <a href="{{ route('admin.tours.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-green px-3 py-2 text-sm font-semibold text-white transition hover:bg-brand-green/90">
                <span class="text-base leading-none">+</span>
                Add tour
            </a>
        </x-slot:actions>
    </x-admin.page-header>

    <form method="GET" action="{{ route('admin.tours.index') }}" class="mb-5 grid gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:grid-cols-2 lg:grid-cols-6">
        <div class="lg:col-span-2">
            <label for="search" class="block text-xs font-medium text-slate-500">Search</label>
            <input
                id="search"
                name="search"
                type="search"
                value="{{ $filters['search'] ?? '' }}"
                placeholder="Name, slug or country"
                class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20"
            >
        </div>

        <div>
            <label for="year" class="block text-xs font-medium text-slate-500">Year</label>
            <select id="year" name="year" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20">
                <option value="">All years</option>
                @foreach ($years as $year)
                    <option value="{{ $year }}" @selected((string) ($filters['year'] ?? '') === (string) $year)>{{ $year }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="status" class="block text-xs font-medium text-slate-500">Status</label>
            <select id="status" name="status" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20">
                <option value="">All statuses</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status->value }}" @selected(($filters['status'] ?? null) === $status->value)>{{ $status->label() }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="published" class="block text-xs font-medium text-slate-500">Visibility</label>
            <select id="published" name="published" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20">
                <option value="">All</option>
                <option value="1" @selected(($filters['published'] ?? null) === '1')>Published</option>
                <option value="0" @selected(($filters['published'] ?? null) === '0')>Draft</option>
            </select>
        </div>

        <div class="flex items-end gap-2">
            <button type="submit" class="inline-flex flex-1 items-center justify-center rounded-lg bg-brand-navy px-3 py-2 text-sm font-semibold text-white transition hover:bg-brand-navy/90">
                Filter
            </button>
            <a href="{{ route('admin.tours.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                Reset
            </a>
        </div>
    </form>

    @if ($tours->isEmpty())
        <x-admin.empty-state title="No tours found" description="Try adjusting the filters, or create your first tour.">
            <x-slot:action>
                <a href="{{ route('admin.tours.create') }}" class="inline-flex items-center rounded-lg bg-brand-green px-3 py-2 text-sm font-semibold text-white transition hover:bg-brand-green/90">
                    Add tour
                </a>
            </x-slot:action>
        </x-admin.empty-state>
    @else
        <x-admin.table :headings="['Tour', 'Year', 'Dates', 'Status', 'Visibility', 'Actions']">
            @foreach ($tours as $tour)
                <tr class="align-middle transition hover:bg-slate-50/70">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            @if ($tour->imageUrl())
                                <img src="{{ $tour->imageUrl() }}" alt="{{ $tour->name }}" class="size-12 shrink-0 rounded-lg object-cover" loading="lazy">
                            @else
                                <span class="grid size-12 shrink-0 place-items-center rounded-lg bg-slate-100 text-[10px] font-semibold text-slate-400">N/A</span>
                            @endif

                            <div class="min-w-0">
                                <p class="truncate font-semibold text-slate-800">{{ $tour->name }}</p>
                                <p class="truncate text-xs text-slate-400">{{ $tour->slug }}</p>
                            </div>
                        </div>
                    </td>

                    <td class="px-4 py-3 text-slate-600">{{ $tour->year }}</td>

                    <td class="px-4 py-3 text-slate-600">
                        <p class="max-w-[18rem]">{{ $tour->date_label ?: '-' }}</p>
                        @if ($tour->start_date)
                            <p class="max-w-[18rem] text-xs text-slate-400">
                                {{ $tour->start_date->format('d M Y') }}@if ($tour->end_date) - {{ $tour->end_date->format('d M Y') }}@endif
                            </p>
                        @endif
                    </td>

                    <td class="px-4 py-3">
                        <x-admin.status-badge :status="$tour->status" />
                    </td>

                    <td class="px-4 py-3">
                        <x-admin.status-badge :status="$tour->is_published ? 'published' : 'draft'" />
                    </td>

                    <td class="w-px whitespace-nowrap px-4 py-3">
                        <div class="flex items-center justify-end gap-2">
                            <button
                                type="button"
                                data-modal-target="tour-details-modal"
                                data-modal-url="{{ route('admin.tours.show', $tour) }}"
                                data-modal-title="{{ $tour->name }}"
                                class="rounded-md border border-brand-green/30 bg-brand-green/5 px-2.5 py-1.5 text-xs font-semibold text-brand-green transition hover:bg-brand-green/10"
                            >
                                View all
                            </button>

                            <a href="{{ route('admin.tours.edit', $tour) }}" class="rounded-md border border-slate-300 px-2.5 py-1.5 text-xs font-medium text-slate-700 transition hover:bg-slate-50">
                                Edit
                            </a>

                            <form method="POST" action="{{ route('admin.tours.destroy', $tour) }}" onsubmit="return confirm('Delete this tour?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-md border border-red-200 px-2.5 py-1.5 text-xs font-medium text-red-600 transition hover:bg-red-50">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-admin.table>

        <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-slate-500">
                Showing {{ $tours->firstItem() }}-{{ $tours->lastItem() }} of {{ $tours->total() }} tours
            </p>

            {{ $tours->links() }}
        </div>
    @endif

    <x-admin.modal id="tour-details-modal" title="Tour details">
        <div data-modal-loading class="flex flex-col items-center justify-center gap-3 py-12 text-sm text-slate-500">
            <span class="size-6 animate-spin rounded-full border-2 border-slate-200 border-t-brand-green" aria-hidden="true"></span>
            Loading tour details…
        </div>

        <x-slot:footer>
            <button type="button" data-modal-close class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-3.5 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                Close
            </button>
        </x-slot:footer>
    </x-admin.modal>
@endsection
