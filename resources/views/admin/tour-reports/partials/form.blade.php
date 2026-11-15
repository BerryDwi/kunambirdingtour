@php
    $report = $report ?? null;
    $inputClass = 'block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20';
    $externalCover = filled($report?->cover_image) && \Illuminate\Support\Str::startsWith($report->cover_image, ['http://', 'https://', '//']) ? $report->cover_image : '';
@endphp

<div class="space-y-6">
    <div class="grid gap-4 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <x-admin.form.field label="Report title" name="title">
                <input id="title" name="title" type="text" value="{{ old('title', $report?->title) }}" required class="{{ $inputClass }}">
            </x-admin.form.field>
        </div>

        <div class="sm:col-span-2">
            <x-admin.form.field label="Slug" name="slug" hint="Leave blank to generate from the report title.">
                <input id="slug" name="slug" type="text" value="{{ old('slug', $report?->slug) }}" class="{{ $inputClass }}">
            </x-admin.form.field>
        </div>

        <x-admin.form.field label="Region" name="region">
            <input id="region" name="region" type="text" value="{{ old('region', $report?->region) }}" class="{{ $inputClass }}">
        </x-admin.form.field>

        <x-admin.form.field label="Report kind" name="kind" hint="Categories appear on the reports page; latest reports appear on the home page.">
            <select id="kind" name="kind" class="{{ $inputClass }}">
                @foreach (['category' => 'Category (reports page)', 'latest' => 'Latest trip (home page)'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('kind', $report?->kind ?? 'category') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </x-admin.form.field>

        <x-admin.form.field label="Published date" name="published_at">
            <input id="published_at" name="published_at" type="date" value="{{ old('published_at', $report?->published_at?->format('Y-m-d')) }}" class="{{ $inputClass }}">
        </x-admin.form.field>

        <div class="sm:col-span-2">
            <x-admin.form.field label="Summary" name="summary" hint="Short excerpt shown in listings.">
                <textarea id="summary" name="summary" rows="3" class="{{ $inputClass }}">{{ old('summary', $report?->summary) }}</textarea>
            </x-admin.form.field>
        </div>

        <div class="sm:col-span-2">
            <x-admin.form.field label="Report URL" name="report_url" hint="External or PDF link for the full report.">
                <input id="report_url" name="report_url" type="url" value="{{ old('report_url', $report?->report_url) }}" placeholder="https://..." class="{{ $inputClass }}">
            </x-admin.form.field>
        </div>

        <div class="sm:col-span-2">
            <x-admin.form.field label="Cover image URL" name="cover_image" hint="Paste an external image URL, or upload a file below.">
                <input id="cover_image" name="cover_image" type="text" value="{{ old('cover_image', $externalCover) }}" placeholder="https://..." class="{{ $inputClass }}">
            </x-admin.form.field>
        </div>

        <div class="sm:col-span-2">
            <x-admin.form.field label="Upload cover image" name="cover_image_file" hint="JPG, PNG or WebP, max 4 MB. Saved to public/uploads/reports.">
                <input id="cover_image_file" name="cover_image_file" type="file" accept="image/jpeg,image/png,image/webp" class="block w-full cursor-pointer rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-brand-navy file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white">
            </x-admin.form.field>
        </div>

        @if ($report?->coverImageUrl())
            <div class="sm:col-span-2">
                <p class="text-sm font-medium text-slate-700">Current cover image</p>
                <img src="{{ $report->coverImageUrl() }}" alt="{{ $report->title }}" class="mt-2 h-24 w-auto rounded-lg border border-slate-200 object-cover">

                <label class="mt-3 flex items-center gap-2 text-sm text-slate-600">
                    <input type="hidden" name="remove_image" value="0">
                    <input type="checkbox" name="remove_image" value="1" class="size-4 rounded border-slate-300 text-brand-green focus:ring-brand-green/30" @checked(old('remove_image'))>
                    Remove current cover image
                </label>
            </div>
        @endif

        <x-admin.form.field label="Sort order" name="sort_order" hint="Lower numbers appear first.">
            <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $report?->sort_order ?? 0) }}" class="{{ $inputClass }}">
        </x-admin.form.field>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:gap-6">
            <label class="flex items-center gap-2 pb-2 text-sm text-slate-700">
                <input type="hidden" name="is_featured" value="0">
                <input type="checkbox" name="is_featured" value="1" class="size-4 rounded border-slate-300 text-brand-green focus:ring-brand-green/30" @checked(old('is_featured', $report?->is_featured ?? false))>
                Featured
            </label>

            <label class="flex items-center gap-2 pb-2 text-sm text-slate-700">
                <input type="hidden" name="is_published" value="0">
                <input type="checkbox" name="is_published" value="1" class="size-4 rounded border-slate-300 text-brand-green focus:ring-brand-green/30" @checked(old('is_published', $report?->is_published ?? true))>
                Published
            </label>
        </div>
    </div>
</div>
