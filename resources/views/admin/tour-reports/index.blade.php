@extends('admin.layouts.app')

@section('title', 'Tour Reports')

@section('content')
    <x-admin.page-header title="Tour Reports" description="Manage trip reports, regions and featured entries.">
        <x-slot:actions>
            <a href="{{ route('admin.tour-reports.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-green px-3 py-2 text-sm font-semibold text-white transition hover:bg-brand-green/90">
                <span class="text-base leading-none">+</span>
                Add report
            </a>
        </x-slot:actions>
    </x-admin.page-header>

    <form method="GET" action="{{ route('admin.tour-reports.index') }}" class="mb-5 grid gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:grid-cols-2 lg:grid-cols-6">
        <div class="lg:col-span-2">
            <label for="search" class="block text-xs font-medium text-slate-500">Search</label>
            <input id="search" name="search" type="search" value="{{ $filters['search'] ?? '' }}" placeholder="Title or region" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20">
        </div>

        <div>
            <label for="featured" class="block text-xs font-medium text-slate-500">Featured</label>
            <select id="featured" name="featured" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20">
                <option value="">All</option>
                <option value="1" @selected(($filters['featured'] ?? null) === '1')>Featured</option>
                <option value="0" @selected(($filters['featured'] ?? null) === '0')>Not featured</option>
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

        <div class="flex items-end gap-2 lg:col-span-2">
            <button type="submit" class="inline-flex flex-1 items-center justify-center rounded-lg bg-brand-navy px-3 py-2 text-sm font-semibold text-white transition hover:bg-brand-navy/90">Filter</button>
            <a href="{{ route('admin.tour-reports.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50">Reset</a>
        </div>
    </form>

    @if ($reports->isEmpty())
        <x-admin.empty-state title="No tour reports found" description="Try adjusting the filters, or add your first report." />
    @else
        <x-admin.table :headings="['Report', 'Region', 'Published', 'Featured', 'Visibility', 'Actions']">
            @foreach ($reports as $report)
                <tr class="align-middle transition hover:bg-slate-50/70">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            @if ($report->coverImageUrl())
                                <img src="{{ $report->coverImageUrl() }}" alt="{{ $report->title }}" class="size-12 shrink-0 rounded-lg object-cover" loading="lazy">
                            @else
                                <span class="grid size-12 shrink-0 place-items-center rounded-lg bg-slate-100 text-[10px] font-semibold text-slate-400">N/A</span>
                            @endif

                            <div class="min-w-0">
                                <p class="truncate font-semibold text-slate-800">{{ $report->title }}</p>
                                <p class="truncate text-xs text-slate-400">{{ $report->slug }} · {{ ucfirst($report->kind) }}</p>
                            </div>
                        </div>
                    </td>

                    <td class="px-4 py-3 text-slate-600">{{ $report->region ?: '-' }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $report->published_at?->format('d M Y') ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <x-admin.status-badge :status="$report->is_featured ? 'featured' : 'standard'" />
                    </td>
                    <td class="px-4 py-3">
                        <x-admin.status-badge :status="$report->is_published ? 'published' : 'draft'" />
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.tour-reports.edit', $report) }}" class="rounded-md border border-slate-300 px-2.5 py-1.5 text-xs font-medium text-slate-700 transition hover:bg-slate-50">Edit</a>

                            <form method="POST" action="{{ route('admin.tour-reports.destroy', $report) }}" onsubmit="return confirm('Delete this report?');">
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
            <p class="text-sm text-slate-500">Showing {{ $reports->firstItem() }}-{{ $reports->lastItem() }} of {{ $reports->total() }} reports</p>
            {{ $reports->links() }}
        </div>
    @endif
@endsection
