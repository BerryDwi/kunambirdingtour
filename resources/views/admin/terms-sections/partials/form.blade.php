@php
    $section = $section ?? null;
    $inputClass = 'block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20';
@endphp

<div class="space-y-6">
    <div class="grid gap-4 sm:grid-cols-6">
        <div class="sm:col-span-2">
            <x-admin.form.field label="Section number" name="number">
                <input id="number" name="number" type="number" min="1" max="999" value="{{ old('number', $section?->number ?? 1) }}" required class="{{ $inputClass }}">
            </x-admin.form.field>
        </div>

        <div class="sm:col-span-4">
            <x-admin.form.field label="Title" name="title">
                <input id="title" name="title" type="text" value="{{ old('title', $section?->title) }}" required class="{{ $inputClass }}">
            </x-admin.form.field>
        </div>

        <div class="sm:col-span-6">
            <x-admin.form.field label="Navigation title" name="nav_title" hint="Optional. Label shown in the public quick navigation sidebar. Defaults to the title.">
                <input id="nav_title" name="nav_title" type="text" value="{{ old('nav_title', $section?->nav_title) }}" class="{{ $inputClass }}">
            </x-admin.form.field>
        </div>

        <div class="sm:col-span-6">
            <x-admin.form.field label="Anchor" name="anchor" hint="Optional. URL anchor for public links, e.g. payment. Defaults to a slug of the title.">
                <input id="anchor" name="anchor" type="text" value="{{ old('anchor', $section?->anchor) }}" class="{{ $inputClass }}">
            </x-admin.form.field>
        </div>

        <div class="sm:col-span-6">
            <x-admin.form.field label="Body" name="body" hint="Plain text or basic HTML.">
                <textarea id="body" name="body" rows="12" required class="{{ $inputClass }}">{{ old('body', $section?->body) }}</textarea>
            </x-admin.form.field>
        </div>

        <div class="sm:col-span-2">
            <x-admin.form.field label="Sort order" name="sort_order" hint="Defaults to the section number.">
                <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $section?->sort_order) }}" class="{{ $inputClass }}">
            </x-admin.form.field>
        </div>
    </div>
</div>
