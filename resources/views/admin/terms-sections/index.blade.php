@extends('admin.layouts.app')

@section('title', 'Terms & Conditions')

@section('content')
    <x-admin.page-header title="Terms & Conditions" description="Manage the numbered booking terms shown on the website.">
        <x-slot:actions>
            <a href="{{ route('admin.terms-sections.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-green px-3 py-2 text-sm font-semibold text-white transition hover:bg-brand-green/90">
                <span class="text-base leading-none">+</span>
                Add section
            </a>
        </x-slot:actions>
    </x-admin.page-header>

    <form method="GET" action="{{ route('admin.terms-sections.index') }}" class="mb-5 flex flex-col gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row sm:items-end">
        <div class="flex-1">
            <label for="search" class="block text-xs font-medium text-slate-500">Search</label>
            <input id="search" name="search" type="search" value="{{ $filters['search'] ?? '' }}" placeholder="Title or body text" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20">
        </div>

        <div class="flex gap-2">
            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-brand-navy px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-navy/90">Filter</button>
            <a href="{{ route('admin.terms-sections.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50">Reset</a>
        </div>
    </form>

    @if ($sections->isEmpty())
        <x-admin.empty-state title="No terms sections found" description="Try adjusting the search, or add your first section." />
    @else
        <x-admin.table :headings="['No.', 'Title', 'Body preview', 'Order', 'Actions']">
            @foreach ($sections as $section)
                <tr class="align-middle transition hover:bg-slate-50/70">
                    <td class="px-4 py-3">
                        <span class="grid size-9 place-items-center rounded-full bg-brand-navy/5 text-sm font-semibold text-brand-navy">{{ $section->number }}</span>
                    </td>

                    <td class="px-4 py-3">
                        <p class="font-semibold text-slate-800">{{ $section->title }}</p>
                    </td>

                    <td class="px-4 py-3">
                        <p class="max-w-md truncate text-sm text-slate-500">{{ \Illuminate\Support\Str::limit(strip_tags($section->body), 90) }}</p>
                    </td>

                    <td class="px-4 py-3 text-slate-600">{{ $section->sort_order }}</td>

                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.terms-sections.edit', $section) }}" class="rounded-md border border-slate-300 px-2.5 py-1.5 text-xs font-medium text-slate-700 transition hover:bg-slate-50">Edit</a>

                            <form method="POST" action="{{ route('admin.terms-sections.destroy', $section) }}" onsubmit="return confirm('Delete this terms section?');">
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
            <p class="text-sm text-slate-500">Showing {{ $sections->firstItem() }}-{{ $sections->lastItem() }} of {{ $sections->total() }} sections</p>
            {{ $sections->links() }}
        </div>
    @endif
@endsection
