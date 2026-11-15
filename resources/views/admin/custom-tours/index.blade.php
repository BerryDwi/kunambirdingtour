@extends('admin.layouts.app')

@section('title', 'Custom Tours')

@section('content')
    <x-admin.page-header title="Custom Tours" description="Manage tailor-made itineraries and departures.">
        <x-slot:actions>
            <a href="{{ route('admin.custom-tours.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-green px-3 py-2 text-sm font-semibold text-white transition hover:bg-brand-green/90">
                <span class="text-base leading-none">+</span>
                Add custom tour
            </a>
        </x-slot:actions>
    </x-admin.page-header>

    <form method="GET" action="{{ route('admin.custom-tours.index') }}" class="mb-5 grid gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:grid-cols-2 lg:grid-cols-4">
        <div class="lg:col-span-2">
            <label for="search" class="block text-xs font-medium text-slate-500">Search</label>
            <input id="search" name="search" type="search" value="{{ $filters['search'] ?? '' }}" placeholder="Title, destination or status" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20">
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
            <button type="submit" class="inline-flex flex-1 items-center justify-center rounded-lg bg-brand-navy px-3 py-2 text-sm font-semibold text-white transition hover:bg-brand-navy/90">Filter</button>
            <a href="{{ route('admin.custom-tours.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50">Reset</a>
        </div>
    </form>

    @if ($customTours->isEmpty())
        <x-admin.empty-state title="No custom tours found" description="Try adjusting the filters, or add your first custom tour." />
    @else
        <x-admin.table :headings="['Custom tour', 'Destination', 'Dates', 'Status', 'Visibility', 'Actions']">
            @foreach ($customTours as $customTour)
                <tr class="align-middle transition hover:bg-slate-50/70">
                    <td class="px-4 py-3">
                        <p class="font-semibold text-slate-800">{{ $customTour->title }}</p>
                        <p class="text-xs text-slate-400">{{ $customTour->slug }}</p>
                    </td>

                    <td class="px-4 py-3 text-slate-600">{{ $customTour->destination ?: '-' }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $customTour->date_label ?: '-' }}</td>
                    <td class="px-4 py-3">
                        <x-admin.status-badge :status="$customTour->status" />
                    </td>
                    <td class="px-4 py-3">
                        <x-admin.status-badge :status="$customTour->is_published ? 'published' : 'draft'" />
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.custom-tours.edit', $customTour) }}" class="rounded-md border border-slate-300 px-2.5 py-1.5 text-xs font-medium text-slate-700 transition hover:bg-slate-50">Edit</a>

                            <form method="POST" action="{{ route('admin.custom-tours.destroy', $customTour) }}" onsubmit="return confirm('Delete this custom tour?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-md border border-red-200 px-2.5 py-1.5 text-xs font-medium text-red-600 transition hover:bg-red-50">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-admin.table>

        <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-slate-500">Showing {{ $customTours->firstItem() }}-{{ $customTours->lastItem() }} of {{ $customTours->total() }} custom tours</p>
            {{ $customTours->links() }}
        </div>
    @endif
@endsection
