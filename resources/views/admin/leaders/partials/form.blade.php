@php
    $leader = $leader ?? null;
    $inputClass = 'block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20';
    $externalPhoto = filled($leader?->photo) && \Illuminate\Support\Str::startsWith($leader->photo, ['http://', 'https://', '//']) ? $leader->photo : '';
@endphp

<div class="space-y-6">
    <div class="grid gap-4 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <x-admin.form.field label="Leader name" name="name">
                <input id="name" name="name" type="text" value="{{ old('name', $leader?->name) }}" required class="{{ $inputClass }}">
            </x-admin.form.field>
        </div>

        <div class="sm:col-span-2">
            <x-admin.form.field label="Slug" name="slug" hint="Leave blank to generate from the leader name.">
                <input id="slug" name="slug" type="text" value="{{ old('slug', $leader?->slug) }}" class="{{ $inputClass }}">
            </x-admin.form.field>
        </div>

        <x-admin.form.field label="Region" name="region" hint="e.g. Throughout the region, Southeast Asia">
            <input id="region" name="region" type="text" value="{{ old('region', $leader?->region) }}" class="{{ $inputClass }}">
        </x-admin.form.field>

        <x-admin.form.field label="Badge style" name="badge_style" hint="Colour used for the region badge on the public site.">
            <select id="badge_style" name="badge_style" class="{{ $inputClass }}">
                @foreach (['success' => 'Green (default)', 'info' => 'Blue (office/role)', 'warning' => 'Amber (guest/special)'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('badge_style', $leader?->badge_style ?? 'success') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </x-admin.form.field>

        <x-admin.form.field label="Email" name="email">
            <input id="email" name="email" type="email" value="{{ old('email', $leader?->email) }}" class="{{ $inputClass }}">
        </x-admin.form.field>

        <div class="sm:col-span-2">
            <x-admin.form.field label="Photo URL" name="photo" hint="Paste an external image URL, or upload a file below.">
                <input id="photo" name="photo" type="text" value="{{ old('photo', $externalPhoto) }}" placeholder="https://..." class="{{ $inputClass }}">
            </x-admin.form.field>
        </div>

        <div class="sm:col-span-2">
            <x-admin.form.field label="Upload photo" name="photo_file" hint="JPG, PNG or WebP, max 4 MB. Saved to public/uploads/leaders.">
                <input id="photo_file" name="photo_file" type="file" accept="image/jpeg,image/png,image/webp" class="block w-full cursor-pointer rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-brand-navy file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white">
            </x-admin.form.field>
        </div>

        @if ($leader?->photoUrl())
            <div class="sm:col-span-2">
                <p class="text-sm font-medium text-slate-700">Current photo</p>
                <img src="{{ $leader->photoUrl() }}" alt="{{ $leader->name }}" class="mt-2 size-24 rounded-full border border-slate-200 object-cover">

                <label class="mt-3 flex items-center gap-2 text-sm text-slate-600">
                    <input type="hidden" name="remove_image" value="0">
                    <input type="checkbox" name="remove_image" value="1" class="size-4 rounded border-slate-300 text-brand-green focus:ring-brand-green/30" @checked(old('remove_image'))>
                    Remove current photo
                </label>
            </div>
        @endif

        <div class="sm:col-span-2">
            <x-admin.form.field label="Biography" name="bio">
                <textarea id="bio" name="bio" rows="8" class="{{ $inputClass }}">{{ old('bio', $leader?->bio) }}</textarea>
            </x-admin.form.field>
        </div>

        <x-admin.form.field label="Sort order" name="sort_order" hint="Lower numbers appear first.">
            <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $leader?->sort_order ?? 0) }}" class="{{ $inputClass }}">
        </x-admin.form.field>

        <div class="flex items-end">
            <label class="flex items-center gap-2 pb-2 text-sm text-slate-700">
                <input type="hidden" name="is_published" value="0">
                <input type="checkbox" name="is_published" value="1" class="size-4 rounded border-slate-300 text-brand-green focus:ring-brand-green/30" @checked(old('is_published', $leader?->is_published ?? true))>
                Published
            </label>
        </div>
    </div>
</div>
