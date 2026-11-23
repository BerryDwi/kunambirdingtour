@php
    $tour = $tour ?? null;

    $inputClass = 'block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20';
    $moneyValue = fn (?int $value): string => $value === null ? '' : number_format($value / 100, 2, '.', '');

    $externalImage = filled($tour?->image) && \Illuminate\Support\Str::startsWith($tour->image, ['http://', 'https://', '//'])
        ? $tour->image
        : '';

    $steps = [
        1 => ['label' => 'Basic info', 'description' => 'Name, slug, year and a short summary.'],
        2 => ['label' => 'Content', 'description' => 'Full description and day-by-day itinerary.'],
        3 => ['label' => 'Dates & pricing', 'description' => 'Departure dates, duration and prices.'],
        4 => ['label' => 'Media', 'description' => 'Upload a new image or use an external URL.'],
        5 => ['label' => 'Publishing & SEO', 'description' => 'Visibility and search metadata.'],
    ];

    $stepFields = [
        1 => ['name', 'slug', 'year', 'country', 'summary'],
        2 => ['description', 'itinerary'],
        3 => ['duration_days', 'group_size', 'date_label', 'start_date', 'end_date', 'price_gbp', 'price_usd', 'single_supplement_gbp', 'single_supplement_usd'],
        4 => ['image', 'image_file', 'remove_image'],
        5 => ['status', 'sort_order', 'is_featured', 'is_published', 'meta_title', 'meta_description'],
    ];

    $errorSteps = [];

    foreach ($errors->keys() as $field) {
        foreach ($stepFields as $step => $fields) {
            if (in_array($field, $fields, true)) {
                $errorSteps[$field] = $step;

                break;
            }
        }
    }

    $initialStep = $errorSteps === [] ? 1 : min($errorSteps);
    $totalSteps = count($steps);
@endphp

<div
    data-wizard
    data-initial-step="{{ $initialStep }}"
    class="space-y-6"
>
    <div>
        <ol class="grid gap-2 sm:grid-cols-5">
            @foreach ($steps as $step => $meta)
                <li>
                    <button
                        type="button"
                        data-wizard-goto="{{ $step }}"
                        data-state="{{ $step === $initialStep ? 'current' : ($step < $initialStep ? 'complete' : 'upcoming') }}"
                        class="group flex w-full items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-left transition hover:border-slate-300 hover:bg-slate-50 data-[state=complete]:border-brand-green/30 data-[state=complete]:bg-brand-green/[0.04] data-[state=current]:border-brand-navy/30 data-[state=current]:bg-brand-navy/[0.03]"
                    >
                        <span class="grid size-7 shrink-0 place-items-center rounded-full border border-slate-200 bg-white text-xs font-semibold text-slate-400 transition group-data-[state=complete]:border-brand-green group-data-[state=complete]:bg-brand-green/10 group-data-[state=complete]:text-brand-green group-data-[state=current]:border-brand-navy group-data-[state=current]:bg-brand-navy group-data-[state=current]:text-white">
                            {{ $step }}
                        </span>
                        <span class="min-w-0 text-xs font-medium leading-tight text-slate-500 group-data-[state=complete]:text-brand-green group-data-[state=current]:text-brand-navy">
                            {{ $meta['label'] }}
                        </span>
                    </button>
                </li>
            @endforeach
        </ol>

        <div class="mt-3 flex items-center gap-3">
            <div class="h-1.5 flex-1 overflow-hidden rounded-full bg-slate-200">
                <div data-wizard-progress class="h-full rounded-full bg-brand-green transition-all duration-300" style="width: {{ ($initialStep / $totalSteps) * 100 }}%"></div>
            </div>
            <p data-wizard-counter class="shrink-0 text-xs font-medium text-slate-500">
                Step {{ $initialStep }} of {{ $totalSteps }}
            </p>
        </div>
    </div>

    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <p class="font-semibold">Please fix the following before saving:</p>
            <ul class="mt-2 space-y-1">
                @foreach ($errors->messages() as $field => $messages)
                    @foreach ($messages as $message)
                        <li>
                            <button
                                type="button"
                                data-wizard-error-step="{{ $errorSteps[$field] ?? 1 }}"
                                data-wizard-error-field="{{ $field }}"
                                class="text-left underline underline-offset-2 transition hover:text-red-900"
                            >
                                {{ $message }}
                            </button>
                        </li>
                    @endforeach
                @endforeach
            </ul>
        </div>
    @endif

    <section data-wizard-step="1" @class(['space-y-4', 'hidden' => $initialStep !== 1])>
        <div class="flex items-start gap-3">
            <span class="grid size-8 shrink-0 place-items-center rounded-lg bg-brand-navy/5 text-xs font-bold text-brand-navy">1</span>
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-500">Basic info</h3>
                <p class="mt-0.5 text-xs text-slate-400">{{ $steps[1]['description'] }}</p>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <x-admin.form.field label="Tour name" name="name">
                    <input id="name" name="name" type="text" value="{{ old('name', $tour?->name) }}" required class="{{ $inputClass }}">
                </x-admin.form.field>
            </div>

            <div class="sm:col-span-2">
                <x-admin.form.field label="Slug" name="slug" hint="Leave blank to generate from the tour name.">
                    <input id="slug" name="slug" type="text" value="{{ old('slug', $tour?->slug) }}" placeholder="china-in-winter" class="{{ $inputClass }}">
                </x-admin.form.field>
            </div>

            <x-admin.form.field label="Year" name="year">
                <input id="year" name="year" type="number" min="2000" max="2100" value="{{ old('year', $tour?->year ?? now()->year) }}" required class="{{ $inputClass }}">
            </x-admin.form.field>

            <x-admin.form.field label="Country / region" name="country">
                <input id="country" name="country" type="text" value="{{ old('country', $tour?->country) }}" class="{{ $inputClass }}">
            </x-admin.form.field>

            <div class="sm:col-span-2">
                <x-admin.form.field label="Summary" name="summary" hint="Short description shown on the tour card.">
                    <textarea id="summary" name="summary" rows="2" class="{{ $inputClass }}">{{ old('summary', $tour?->summary) }}</textarea>
                </x-admin.form.field>
            </div>
        </div>
    </section>

    <section data-wizard-step="2" @class(['space-y-4', 'hidden' => $initialStep !== 2])>
        <div class="flex items-start gap-3">
            <span class="grid size-8 shrink-0 place-items-center rounded-lg bg-brand-navy/5 text-xs font-bold text-brand-navy">2</span>
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-500">Content</h3>
                <p class="mt-0.5 text-xs text-slate-400">{{ $steps[2]['description'] }}</p>
            </div>
        </div>

        <div class="grid gap-4">
            <x-admin.form.field label="Description" name="description">
                <textarea id="description" name="description" rows="6" class="{{ $inputClass }}">{{ old('description', $tour?->description) }}</textarea>
            </x-admin.form.field>

            <x-admin.form.field label="Itinerary" name="itinerary">
                <textarea id="itinerary" name="itinerary" rows="10" class="{{ $inputClass }}">{{ old('itinerary', $tour?->itinerary) }}</textarea>
            </x-admin.form.field>
        </div>
    </section>

    <section data-wizard-step="3" @class(['space-y-4', 'hidden' => $initialStep !== 3])>
        <div class="flex items-start gap-3">
            <span class="grid size-8 shrink-0 place-items-center rounded-lg bg-brand-navy/5 text-xs font-bold text-brand-navy">3</span>
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-500">Dates &amp; pricing</h3>
                <p class="mt-0.5 text-xs text-slate-400">{{ $steps[3]['description'] }}</p>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <x-admin.form.field label="Duration (days)" name="duration_days">
                <input id="duration_days" name="duration_days" type="number" min="1" max="365" value="{{ old('duration_days', $tour?->duration_days) }}" class="{{ $inputClass }}">
            </x-admin.form.field>

            <x-admin.form.field label="Group size" name="group_size" hint="Maximum number of birders, e.g. 8 or 7-8. Leave blank to show the default.">
                <input id="group_size" name="group_size" type="text" value="{{ old('group_size', $tour?->group_size) }}" class="{{ $inputClass }}">
            </x-admin.form.field>

            <x-admin.form.field label="Date label" name="date_label" hint="Flexible text, e.g. 10th - 29th January 2027 (20 days).">
                <input id="date_label" name="date_label" type="text" value="{{ old('date_label', $tour?->date_label) }}" class="{{ $inputClass }}">
            </x-admin.form.field>

            <x-admin.form.field label="Start date" name="start_date">
                <input id="start_date" name="start_date" type="date" value="{{ old('start_date', $tour?->start_date?->format('Y-m-d')) }}" class="{{ $inputClass }}">
            </x-admin.form.field>

            <x-admin.form.field label="End date" name="end_date">
                <input id="end_date" name="end_date" type="date" value="{{ old('end_date', $tour?->end_date?->format('Y-m-d')) }}" class="{{ $inputClass }}">
            </x-admin.form.field>

            <x-admin.form.field label="Price (GBP)" name="price_gbp" hint="Enter pounds, e.g. 3495.00">
                <input id="price_gbp" name="price_gbp" type="number" step="0.01" min="0" value="{{ old('price_gbp', $moneyValue($tour?->price_gbp)) }}" class="{{ $inputClass }}">
            </x-admin.form.field>

            <x-admin.form.field label="Price (USD)" name="price_usd" hint="Enter dollars, e.g. 4295.00">
                <input id="price_usd" name="price_usd" type="number" step="0.01" min="0" value="{{ old('price_usd', $moneyValue($tour?->price_usd)) }}" class="{{ $inputClass }}">
            </x-admin.form.field>

            <x-admin.form.field label="Single supplement (GBP)" name="single_supplement_gbp">
                <input id="single_supplement_gbp" name="single_supplement_gbp" type="number" step="0.01" min="0" value="{{ old('single_supplement_gbp', $moneyValue($tour?->single_supplement_gbp)) }}" class="{{ $inputClass }}">
            </x-admin.form.field>

            <x-admin.form.field label="Single supplement (USD)" name="single_supplement_usd">
                <input id="single_supplement_usd" name="single_supplement_usd" type="number" step="0.01" min="0" value="{{ old('single_supplement_usd', $moneyValue($tour?->single_supplement_usd)) }}" class="{{ $inputClass }}">
            </x-admin.form.field>
        </div>
    </section>

    <section data-wizard-step="4" @class(['space-y-4', 'hidden' => $initialStep !== 4])>
        <div class="flex items-start gap-3">
            <span class="grid size-8 shrink-0 place-items-center rounded-lg bg-brand-navy/5 text-xs font-bold text-brand-navy">4</span>
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-500">Media</h3>
                <p class="mt-0.5 text-xs text-slate-400">{{ $steps[4]['description'] }}</p>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <x-admin.form.field label="Image URL" name="image" hint="Paste an external image URL, or upload a file below.">
                    <input id="image" name="image" type="text" value="{{ old('image', $externalImage) }}" placeholder="https://..." class="{{ $inputClass }}">
                </x-admin.form.field>
            </div>

            <div class="sm:col-span-2">
                <x-admin.form.field label="Upload image" name="image_file" hint="JPG, PNG or WebP, max 4 MB. Saved to public/uploads/tours.">
                    <input id="image_file" name="image_file" type="file" accept="image/jpeg,image/png,image/webp" class="block w-full cursor-pointer rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-brand-navy file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white">
                </x-admin.form.field>
            </div>

            @if ($tour?->imageUrl())
                <div class="sm:col-span-2">
                    <p class="text-sm font-medium text-slate-700">Current image</p>
                    <img src="{{ $tour->imageUrl() }}" alt="{{ $tour->name }}" class="mt-2 h-24 w-auto rounded-lg border border-slate-200 object-cover">

                    <label class="mt-3 flex items-center gap-2 text-sm text-slate-600">
                        <input type="hidden" name="remove_image" value="0">
                        <input type="checkbox" name="remove_image" value="1" class="size-4 rounded border-slate-300 text-brand-green focus:ring-brand-green/30" @checked(old('remove_image'))>
                        Remove current image
                    </label>
                </div>
            @endif
        </div>
    </section>

    <section data-wizard-step="5" @class(['space-y-4', 'hidden' => $initialStep !== 5])>
        <div class="flex items-start gap-3">
            <span class="grid size-8 shrink-0 place-items-center rounded-lg bg-brand-navy/5 text-xs font-bold text-brand-navy">5</span>
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-500">Publishing &amp; SEO</h3>
                <p class="mt-0.5 text-xs text-slate-400">{{ $steps[5]['description'] }}</p>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <x-admin.form.field label="Status" name="status">
                <select id="status" name="status" class="{{ $inputClass }}">
                    @foreach ($statuses as $status)
                        <option value="{{ $status->value }}" @selected(old('status', $tour?->status?->value ?? \App\Enums\TourStatus::Available->value) === $status->value)>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
            </x-admin.form.field>

            <x-admin.form.field label="Sort order" name="sort_order" hint="Lower numbers appear first.">
                <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $tour?->sort_order ?? 0) }}" class="{{ $inputClass }}">
            </x-admin.form.field>

            <div class="sm:col-span-2">
                <x-admin.form.field label="Status label (public badge)" name="status_label" hint="Optional. Leave blank to use the status label above.">
                    <input id="status_label" name="status_label" type="text" value="{{ old('status_label', $tour?->status_label) }}" placeholder="{{ $tour?->status?->label() ?? \App\Enums\TourStatus::Available->label() }}" class="{{ $inputClass }}">
                </x-admin.form.field>
            </div>

            <div class="flex flex-col gap-3 sm:col-span-2 sm:flex-row sm:gap-6">
                <label class="flex items-center gap-2 text-sm text-slate-700">
                    <input type="hidden" name="is_featured" value="0">
                    <input type="checkbox" name="is_featured" value="1" class="size-4 rounded border-slate-300 text-brand-green focus:ring-brand-green/30" @checked(old('is_featured', $tour?->is_featured ?? false))>
                    Feature on the home page
                </label>

                <label class="flex items-center gap-2 text-sm text-slate-700">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" class="size-4 rounded border-slate-300 text-brand-green focus:ring-brand-green/30" @checked(old('is_published', $tour?->is_published ?? true))>
                    Published
                </label>
            </div>

            <div class="sm:col-span-2">
                <x-admin.form.field label="Meta title" name="meta_title">
                    <input id="meta_title" name="meta_title" type="text" value="{{ old('meta_title', $tour?->meta_title) }}" class="{{ $inputClass }}">
                </x-admin.form.field>
            </div>

            <div class="sm:col-span-2">
                <x-admin.form.field label="Meta description" name="meta_description">
                    <textarea id="meta_description" name="meta_description" rows="3" class="{{ $inputClass }}">{{ old('meta_description', $tour?->meta_description) }}</textarea>
                </x-admin.form.field>
            </div>
        </div>
    </section>

    <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-5 sm:flex-row sm:items-center sm:justify-between">
        <a href="{{ route('admin.tours.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
            Cancel
        </a>

        <div class="flex items-center justify-end gap-2">
            <button type="button" data-wizard-back style="display: none;" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                Back
            </button>

            <button type="button" data-wizard-next class="inline-flex items-center justify-center rounded-lg bg-brand-navy px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-navy/90">
                Next
            </button>

            <button type="submit" data-wizard-save style="display: none;" class="inline-flex items-center justify-center rounded-lg bg-brand-green px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-green/90">
                {{ $tour ? 'Save changes' : 'Save tour' }}
            </button>
        </div>
    </div>
</div>
