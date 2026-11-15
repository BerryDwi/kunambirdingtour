@extends('admin.layouts.app')

@section('title', 'Hero Slides')

@section('content')
    <x-admin.page-header title="Hero Slides" description="Manage the rotating hero images shown at the top of public pages.">
        <x-slot:actions>
            <a href="{{ route('admin.hero-slides.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-green px-3 py-2 text-sm font-semibold text-white transition hover:bg-brand-green/90">
                <span class="text-base leading-none">+</span>
                Add slide
            </a>
        </x-slot:actions>
    </x-admin.page-header>

    <form method="GET" action="{{ route('admin.hero-slides.index') }}" class="mb-5 grid gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:grid-cols-2 lg:grid-cols-5">
        <div class="lg:col-span-2">
            <label for="search" class="block text-xs font-medium text-slate-500">Search</label>
            <input id="search" name="search" type="search" value="{{ $filters['search'] ?? '' }}" placeholder="Alt text, title or text" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20">
        </div>

        <div>
            <label for="hero_page" class="block text-xs font-medium text-slate-500">Page</label>
            <select id="hero_page" name="hero_page" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20">
                <option value="">All pages</option>
                @foreach ($pages as $page)
                    <option value="{{ $page }}" @selected(($filters['hero_page'] ?? null) === $page)>{{ ucfirst(str_replace('-', ' ', $page)) }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="active" class="block text-xs font-medium text-slate-500">Status</label>
            <select id="active" name="active" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20">
                <option value="">All</option>
                <option value="1" @selected(($filters['active'] ?? null) === '1')>Active</option>
                <option value="0" @selected(($filters['active'] ?? null) === '0')>Inactive</option>
            </select>
        </div>

        <div class="flex items-end gap-2">
            <button type="submit" class="inline-flex flex-1 items-center justify-center rounded-lg bg-brand-navy px-3 py-2 text-sm font-semibold text-white transition hover:bg-brand-navy/90">Filter</button>
            <a href="{{ route('admin.hero-slides.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50">Reset</a>
        </div>
    </form>

    @if ($slides->isEmpty())
        <x-admin.empty-state title="No hero slides found" description="Try adjusting the filters, or add your first slide." />
    @else
        <x-admin.table :headings="['Slide', 'Page', 'Order', 'Status', 'Actions']">
            @foreach ($slides as $slide)
                <tr class="align-middle transition hover:bg-slate-50/70">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            @if ($slide->imageUrl())
                                <img src="{{ $slide->imageUrl() }}" alt="{{ $slide->alt ?: 'Hero slide' }}" class="h-12 w-20 shrink-0 rounded-lg object-cover" loading="lazy">
                            @else
                                <span class="grid h-12 w-20 shrink-0 place-items-center rounded-lg bg-slate-100 text-[10px] font-semibold text-slate-400">N/A</span>
                            @endif

                            <div class="min-w-0">
                                <p class="truncate font-semibold text-slate-800">{{ $slide->title ?: $slide->alt ?: 'Untitled slide' }}</p>
                                <p class="truncate text-xs text-slate-400">{{ \Illuminate\Support\Str::limit($slide->text, 60) }}</p>
                            </div>
                        </div>
                    </td>

                    <td class="px-4 py-3 text-slate-600">{{ ucfirst(str_replace('-', ' ', $slide->page)) }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $slide->sort_order }}</td>
                    <td class="px-4 py-3">
                        <x-admin.status-badge :status="$slide->is_active ? 'active' : 'inactive'" />
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.hero-slides.edit', $slide) }}" class="rounded-md border border-slate-300 px-2.5 py-1.5 text-xs font-medium text-slate-700 transition hover:bg-slate-50">Edit</a>

                            <form method="POST" action="{{ route('admin.hero-slides.destroy', $slide) }}" onsubmit="return confirm('Delete this hero slide?');">
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
            <p class="text-sm text-slate-500">Showing {{ $slides->firstItem() }}-{{ $slides->lastItem() }} of {{ $slides->total() }} slides</p>
            {{ $slides->links() }}
        </div>
    @endif
@endsection
