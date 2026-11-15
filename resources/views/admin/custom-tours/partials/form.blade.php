@php
    $customTour = $customTour ?? null;
    $inputClass = 'block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20';
    $statuses = ['open' => 'Open', 'confirmed' => 'Confirmed', 'waitlist' => 'Waitlist', 'closed' => 'Closed'];
@endphp

<div class="space-y-6">
    <div class="grid gap-4 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <x-admin.form.field label="Tour title" name="title">
                <input id="title" name="title" type="text" value="{{ old('title', $customTour?->title) }}" required class="{{ $inputClass }}">
            </x-admin.form.field>
        </div>

        <div class="sm:col-span-2">
            <x-admin.form.field label="Slug" name="slug" hint="Leave blank to generate from the tour title.">
                <input id="slug" name="slug" type="text" value="{{ old('slug', $customTour?->slug) }}" class="{{ $inputClass }}">
            </x-admin.form.field>
        </div>

        <x-admin.form.field label="Destination" name="destination">
            <input id="destination" name="destination" type="text" value="{{ old('destination', $customTour?->destination) }}" class="{{ $inputClass }}">
        </x-admin.form.field>

        <x-admin.form.field label="Dates label" name="date_label" hint="Free text, e.g. Flexible dates throughout 2027.">
            <input id="date_label" name="date_label" type="text" value="{{ old('date_label', $customTour?->date_label) }}" class="{{ $inputClass }}">
        </x-admin.form.field>

        <x-admin.form.field label="Status" name="status">
            <select id="status" name="status" class="{{ $inputClass }}">
                @foreach ($statuses as $value => $label)
                    <option value="{{ $value }}" @selected(old('status', $customTour?->status ?? 'open') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </x-admin.form.field>

        <x-admin.form.field label="Contact email" name="contact_email">
            <input id="contact_email" name="contact_email" type="email" value="{{ old('contact_email', $customTour?->contact_email) }}" class="{{ $inputClass }}">
        </x-admin.form.field>

        <div class="sm:col-span-2">
            <x-admin.form.field label="Description" name="description">
                <textarea id="description" name="description" rows="8" class="{{ $inputClass }}">{{ old('description', $customTour?->description) }}</textarea>
            </x-admin.form.field>
        </div>

        <x-admin.form.field label="Sort order" name="sort_order" hint="Lower numbers appear first.">
            <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $customTour?->sort_order ?? 0) }}" class="{{ $inputClass }}">
        </x-admin.form.field>

        <div class="flex items-end">
            <label class="flex items-center gap-2 pb-2 text-sm text-slate-700">
                <input type="hidden" name="is_published" value="0">
                <input type="checkbox" name="is_published" value="1" class="size-4 rounded border-slate-300 text-brand-green focus:ring-brand-green/30" @checked(old('is_published', $customTour?->is_published ?? true))>
                Published
            </label>
        </div>
    </div>
</div>
