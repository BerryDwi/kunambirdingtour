@php
    $slide = $slide ?? null;
    $pages = $pages ?? \App\Http\Requests\Admin\HeroSlideRequest::PAGES;
    $inputClass = 'block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20';
    $externalImage = filled($slide?->image) && \Illuminate\Support\Str::startsWith($slide->image, ['http://', 'https://', '//']) ? $slide->image : '';
@endphp

<div class="space-y-6">
    <div class="grid gap-4 sm:grid-cols-2">
        <x-admin.form.field label="Page" name="page">
            <select id="page" name="page" class="{{ $inputClass }}">
                @foreach ($pages as $page)
                    <option value="{{ $page }}" @selected(old('page', $slide?->page ?? 'home') === $page)>{{ ucfirst(str_replace('-', ' ', $page)) }}</option>
                @endforeach
            </select>
        </x-admin.form.field>

        <x-admin.form.field label="Sort order" name="sort_order" hint="Lower numbers appear first.">
            <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $slide?->sort_order ?? 0) }}" class="{{ $inputClass }}">
        </x-admin.form.field>

        <div class="sm:col-span-2">
            <x-admin.form.field label="Image URL" name="image" hint="Paste an external image URL, or upload a file below.">
                <input id="image" name="image" type="text" value="{{ old('image', $externalImage) }}" placeholder="https://..." class="{{ $inputClass }}">
            </x-admin.form.field>
        </div>

        <div class="sm:col-span-2">
            <x-admin.form.field label="Upload image" name="image_file" hint="JPG, PNG or WebP, max 4 MB. Saved to public/uploads/hero-slides.">
                <input id="image_file" name="image_file" type="file" accept="image/jpeg,image/png,image/webp" class="block w-full cursor-pointer rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-brand-navy file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white">
            </x-admin.form.field>
        </div>

        @if ($slide?->imageUrl())
            <div class="sm:col-span-2">
                <p class="text-sm font-medium text-slate-700">Current image</p>
                <img src="{{ $slide->imageUrl() }}" alt="{{ $slide->alt ?: 'Hero slide' }}" class="mt-2 h-32 w-auto rounded-lg border border-slate-200 object-cover">

                <label class="mt-3 flex items-center gap-2 text-sm text-slate-600">
                    <input type="hidden" name="remove_image" value="0">
                    <input type="checkbox" name="remove_image" value="1" class="size-4 rounded border-slate-300 text-brand-green focus:ring-brand-green/30" @checked(old('remove_image'))>
                    Remove current image
                </label>
            </div>
        @endif

        <x-admin.form.field label="Alt text" name="alt" hint="Describe the image for accessibility and SEO.">
            <input id="alt" name="alt" type="text" value="{{ old('alt', $slide?->alt) }}" class="{{ $inputClass }}">
        </x-admin.form.field>

        <x-admin.form.field label="Title" name="title" hint="Optional overlay title.">
            <input id="title" name="title" type="text" value="{{ old('title', $slide?->title) }}" class="{{ $inputClass }}">
        </x-admin.form.field>

        <div class="sm:col-span-2">
            <x-admin.form.field label="Overlay text" name="text" hint="Optional text shown over the image.">
                <textarea id="text" name="text" rows="4" class="{{ $inputClass }}">{{ old('text', $slide?->text) }}</textarea>
            </x-admin.form.field>
        </div>

        <div class="flex items-end">
            <label class="flex items-center gap-2 pb-2 text-sm text-slate-700">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" class="size-4 rounded border-slate-300 text-brand-green focus:ring-brand-green/30" @checked(old('is_active', $slide?->is_active ?? true))>
                Active
            </label>
        </div>
    </div>
</div>
