@extends('admin.layouts.app')

@section('title', $page->label())

@section('content')
    <x-admin.page-header :title="$page->label()" description="Hero slides and hero text for this public page.">
        <x-slot:actions>
            <a href="{{ route($page->publicRoute()) }}" target="_blank" rel="noopener" class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">View page</a>
            <a href="{{ route('admin.hero-slides.create', ['page' => $page->value]) }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-green px-3 py-2 text-sm font-semibold text-white transition hover:bg-brand-green/90">
                <span class="text-base leading-none">+</span>
                Add slide
            </a>
        </x-slot:actions>
    </x-admin.page-header>

    <section class="mb-6 rounded-xl border border-slate-200 bg-white shadow-sm">
        <header class="border-b border-slate-100 px-5 py-4">
            <h3 class="text-sm font-semibold text-brand-navy">Hero slides</h3>
            <p class="mt-0.5 text-xs text-slate-500">Only slides assigned to {{ $page->label() }} are shown here.</p>
        </header>

        @if ($slides->isEmpty())
            <x-admin.empty-state title="No hero slides yet" description="Add a slide to give this page its own hero image." />
        @else
            <x-admin.table :headings="['Slide', 'Order', 'Status', 'Actions']">
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
                        <td class="px-4 py-3 text-slate-600">{{ $slide->sort_order }}</td>
                        <td class="px-4 py-3">
                            <x-admin.status-badge :status="$slide->is_active ? 'active' : 'inactive'" />
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.hero-slides.edit', [$slide, 'page' => $page->value]) }}" class="rounded-md border border-slate-300 px-2.5 py-1.5 text-xs font-medium text-slate-700 transition hover:bg-slate-50">Edit</a>

                                <form method="POST" action="{{ route('admin.hero-slides.destroy', [$slide, 'page' => $page->value]) }}" onsubmit="return confirm('Delete this hero slide?');">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="return_page" value="{{ $page->value }}">
                                    <button type="submit" class="rounded-md border border-red-200 px-2.5 py-1.5 text-xs font-medium text-red-600 transition hover:bg-red-50">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-admin.table>
        @endif
    </section>

    <section class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <header class="border-b border-slate-100 px-5 py-4">
            <h3 class="text-sm font-semibold text-brand-navy">Page text</h3>
            <p class="mt-0.5 text-xs text-slate-500">These values are used by {{ $page->label() }} only.</p>
        </header>

        @if ($settings->isEmpty())
            <x-admin.empty-state title="No text settings yet" description="Add a setting in this group to make it editable here." />
        @else
            <form method="POST" action="{{ route('admin.pages.update', $page->value) }}" class="divide-y divide-slate-100">
                @csrf
                @method('PUT')

                <div class="grid gap-4 p-5 sm:grid-cols-2">
                    @foreach ($settings as $setting)
                        <div class="{{ $setting->type === 'text' ? 'sm:col-span-2' : '' }}">
                            <label for="setting-{{ $setting->id }}" class="text-sm font-medium text-slate-700">{{ $setting->key }}</label>

                            @if ($setting->type === 'text')
                                <textarea id="setting-{{ $setting->id }}" name="values[{{ $setting->id }}]" rows="4" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20">{{ old('values.'.$setting->id, $setting->value) }}</textarea>
                            @else
                                <input id="setting-{{ $setting->id }}" name="values[{{ $setting->id }}]" type="text" value="{{ old('values.'.$setting->id, $setting->value) }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20">
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="px-5 py-4">
                    <button type="submit" class="inline-flex items-center rounded-lg bg-brand-navy px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-navy/90">Save {{ $page->label() }} settings</button>
                </div>
            </form>
        @endif
    </section>
@endsection
