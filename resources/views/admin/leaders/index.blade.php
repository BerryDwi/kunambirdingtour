@extends('admin.layouts.app')

@section('title', 'Leaders')

@section('content')
    <x-admin.page-header title="Leaders" description="Manage tour leaders, photos and visibility.">
        <x-slot:actions>
            <a href="{{ route('admin.leaders.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-green px-3 py-2 text-sm font-semibold text-white transition hover:bg-brand-green/90">
                <span class="text-base leading-none">+</span>
                Add leader
            </a>
        </x-slot:actions>
    </x-admin.page-header>

    <form method="GET" action="{{ route('admin.leaders.index') }}" class="mb-5 grid gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:grid-cols-2 lg:grid-cols-4">
        <div class="lg:col-span-2">
            <label for="search" class="block text-xs font-medium text-slate-500">Search</label>
            <input id="search" name="search" type="search" value="{{ $filters['search'] ?? '' }}" placeholder="Name, region or email" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20">
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
            <a href="{{ route('admin.leaders.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50">Reset</a>
        </div>
    </form>

    @if ($leaders->isEmpty())
        <x-admin.empty-state title="No leaders found" description="Try adjusting the filters, or add your first leader." />
    @else
        <x-admin.table :headings="['Leader', 'Region', 'Email', 'Order', 'Visibility', 'Actions']">
            @foreach ($leaders as $leader)
                <tr class="align-middle transition hover:bg-slate-50/70">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            @if ($leader->photoUrl())
                                <img src="{{ $leader->photoUrl() }}" alt="{{ $leader->name }}" class="size-10 shrink-0 rounded-full object-cover" loading="lazy">
                            @else
                                <span class="grid size-10 shrink-0 place-items-center rounded-full bg-slate-100 text-[10px] font-semibold text-slate-400">N/A</span>
                            @endif

                            <div class="min-w-0">
                                <p class="truncate font-semibold text-slate-800">{{ $leader->name }}</p>
                                <p class="truncate text-xs text-slate-400">{{ $leader->slug }}</p>
                            </div>
                        </div>
                    </td>

                    <td class="px-4 py-3 text-slate-600">{{ $leader->region ?: '-' }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $leader->email ?: '-' }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $leader->sort_order }}</td>
                    <td class="px-4 py-3">
                        <x-admin.status-badge :status="$leader->is_published ? 'published' : 'draft'" />
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.leaders.edit', $leader) }}" class="rounded-md border border-slate-300 px-2.5 py-1.5 text-xs font-medium text-slate-700 transition hover:bg-slate-50">Edit</a>

                            <form method="POST" action="{{ route('admin.leaders.destroy', $leader) }}" onsubmit="return confirm('Delete this leader?');">
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
            <p class="text-sm text-slate-500">Showing {{ $leaders->firstItem() }}-{{ $leaders->lastItem() }} of {{ $leaders->total() }} leaders</p>
            {{ $leaders->links() }}
        </div>
    @endif
@endsection
