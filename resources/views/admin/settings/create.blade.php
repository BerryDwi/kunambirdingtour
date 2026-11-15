@extends('admin.layouts.app')

@section('title', 'Add setting')

@section('content')
    @php
        $inputClass = 'block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20';
    @endphp

    <x-admin.page-header title="Add setting to {{ $groupLabel }}" description="Create a new configuration key inside the {{ $groupLabel }} group.">
        <x-slot:actions>
            <a href="{{ route('admin.settings.index', ['group' => $group]) }}" class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">Back to {{ $groupLabel }}</a>
        </x-slot:actions>
    </x-admin.page-header>

    <form method="POST" action="{{ route('admin.settings.store') }}">
        @csrf
        <input type="hidden" name="group" value="{{ $group }}">

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="mb-5 flex flex-wrap items-center gap-2 border-b border-slate-100 pb-4">
                <span class="text-sm font-medium text-slate-600">Group</span>
                <span class="rounded-full bg-brand-navy/5 px-2.5 py-1 text-xs font-semibold text-brand-navy">{{ $groupLabel }}</span>
                <span class="text-xs text-slate-400">New keys are only added to this group.</span>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <x-admin.form.field label="Key" name="key" hint="Lowercase letters, numbers, dashes and underscores.">
                    <input id="key" name="key" type="text" value="{{ old('key') }}" required placeholder="contact_email" class="{{ $inputClass }}">
                </x-admin.form.field>

                <x-admin.form.field label="Type" name="type">
                    <select id="type" name="type" class="{{ $inputClass }}">
                        @foreach ($types as $type)
                            <option value="{{ $type }}" @selected(old('type', 'string') === $type)>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </x-admin.form.field>

                <div class="sm:col-span-2">
                    <x-admin.form.field label="Value" name="value">
                        <textarea id="value" name="value" rows="4" class="{{ $inputClass }}">{{ old('value') }}</textarea>
                    </x-admin.form.field>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-3">
            <a href="{{ route('admin.settings.index', ['group' => $group]) }}" class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">Cancel</a>
            <button type="submit" class="inline-flex items-center rounded-lg bg-brand-green px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-green/90">Save setting</button>
        </div>
    </form>
@endsection
