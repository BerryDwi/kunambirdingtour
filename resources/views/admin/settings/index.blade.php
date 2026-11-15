@extends('admin.layouts.app')

@section('title', 'Settings')

@section('content')
    <x-admin.page-header title="Settings" description="Site-wide configuration values grouped by area." />

    @if ($groups->isEmpty())
        <x-admin.empty-state title="No settings yet" description="Add your first setting to start configuring the site." />
    @else
        <div class="flex flex-col gap-5 lg:grid lg:grid-cols-[220px_minmax(0,1fr)] lg:items-start">
            <nav class="flex gap-2 overflow-x-auto rounded-xl border border-slate-200 bg-white p-2 shadow-sm lg:flex-col lg:gap-1 lg:overflow-visible" aria-label="Setting groups">
                @foreach ($groups as $group)
                    <a
                        href="{{ route('admin.settings.index', ['group' => $group['key']]) }}"
                        @class([
                            'flex items-center justify-between gap-2 whitespace-nowrap rounded-lg px-3 py-2 text-sm font-medium transition',
                            'bg-brand-navy text-white' => $group['key'] === $activeGroup,
                            'text-slate-600 hover:bg-slate-50 hover:text-brand-navy' => $group['key'] !== $activeGroup,
                        ])
                    >
                        <span>{{ $group['label'] }}</span>
                        <span @class([
                            'rounded-full px-2 py-0.5 text-[10px] font-semibold',
                            'bg-white/15 text-white' => $group['key'] === $activeGroup,
                            'bg-slate-100 text-slate-500' => $group['key'] !== $activeGroup,
                        ])>{{ $group['count'] }}</span>
                    </a>
                @endforeach
            </nav>

            <section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                <header class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-200 bg-slate-50/70 px-5 py-3">
                    <div>
                        <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-700">{{ $activeLabel }}</h2>
                        <p class="text-xs text-slate-500">{{ $activeSettings->count() }} {{ \Illuminate\Support\Str::plural('setting', $activeSettings->count()) }}</p>
                    </div>

                    <a
                        href="{{ route('admin.settings.create', ['group' => $activeGroup]) }}"
                        class="inline-flex items-center gap-1.5 rounded-lg border border-slate-300 bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-50"
                        title="Add a new configuration key to the {{ $activeLabel }} group"
                    >
                        <span class="text-sm leading-none">+</span>
                        Add setting
                    </a>
                </header>

                <form method="POST" action="{{ route('admin.settings.update-group', $activeGroup) }}" class="divide-y divide-slate-100">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-4 p-5 sm:grid-cols-2">
                        @foreach ($activeSettings as $setting)
                            <div class="{{ $setting->type === 'text' ? 'sm:col-span-2' : '' }}">
                                <div class="flex items-start justify-between gap-2">
                                    <label for="setting-{{ $setting->id }}" class="text-sm font-medium text-slate-700">{{ $setting->key }}</label>
                                    <span class="rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-slate-500">{{ $setting->type }}</span>
                                </div>

                                @if ($setting->type === 'text')
                                    <textarea id="setting-{{ $setting->id }}" name="values[{{ $setting->id }}]" rows="4" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20">{{ old('values.'.$setting->id, $setting->value) }}</textarea>
                                @elseif ($setting->type === 'boolean')
                                    <div class="mt-2">
                                        <input type="hidden" name="values[{{ $setting->id }}]" value="0">
                                        <label class="flex items-center gap-2 text-sm text-slate-600">
                                            <input type="checkbox" id="setting-{{ $setting->id }}" name="values[{{ $setting->id }}]" value="1" class="size-4 rounded border-slate-300 text-brand-green focus:ring-brand-green/30" @checked((string) old('values.'.$setting->id, $setting->value) === '1')>
                                            Enabled
                                        </label>
                                    </div>
                                @elseif ($setting->type === 'number')
                                    <input id="setting-{{ $setting->id }}" name="values[{{ $setting->id }}]" type="number" step="any" value="{{ old('values.'.$setting->id, $setting->value) }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20">
                                @else
                                    <input id="setting-{{ $setting->id }}" name="values[{{ $setting->id }}]" type="text" value="{{ old('values.'.$setting->id, $setting->value) }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20">
                                @endif

                                <div class="mt-2 flex items-center justify-between gap-2">
                                    <p class="text-xs text-slate-400">{{ $setting->key }}</p>

                                    <button type="submit" form="delete-setting-{{ $setting->id }}" class="text-xs font-medium text-red-600 transition hover:text-red-700">Delete</button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex items-center justify-end gap-3 bg-slate-50/60 px-5 py-3">
                        <button type="submit" class="inline-flex items-center rounded-lg bg-brand-navy px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-navy/90">Save {{ $activeLabel }} settings</button>
                    </div>
                </form>
            </section>
        </div>

        {{-- Standalone delete forms for the active group. --}}
        @foreach ($activeSettings as $setting)
            <form id="delete-setting-{{ $setting->id }}" method="POST" action="{{ route('admin.settings.destroy', $setting) }}" onsubmit="return confirm('Delete the {{ $setting->key }} setting?');" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    @endif
@endsection
