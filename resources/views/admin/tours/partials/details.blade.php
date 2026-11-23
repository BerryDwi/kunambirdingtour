@php
    $money = fn (?int $value, string $symbol): string => $value === null
        ? '—'
        : $symbol.number_format($value / 100, 2);

    $hasLongContent = filled($tour->summary) || filled($tour->description) || filled($tour->itinerary);
@endphp

<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row">
        @if ($tour->imageUrl())
            <img src="{{ $tour->imageUrl() }}" alt="{{ $tour->name }}" class="h-40 w-full shrink-0 rounded-xl border border-slate-200 object-cover sm:w-56">
        @else
            <span class="grid h-40 w-full shrink-0 place-items-center rounded-xl bg-slate-100 text-xs font-semibold text-slate-400 sm:w-56">No image</span>
        @endif

        <div class="min-w-0">
            <h3 class="text-lg font-semibold text-brand-navy">{{ $tour->name }}</h3>
            <p class="mt-0.5 break-all text-xs text-slate-400">{{ $tour->slug }}</p>

            <div class="mt-3 flex flex-wrap items-center gap-2">
                <x-admin.status-badge :status="$tour->status" />
                <x-admin.status-badge :status="$tour->is_published ? 'published' : 'draft'" />

                @if ($tour->is_featured)
                    <span class="inline-flex items-center rounded-full bg-brand-navy/10 px-2.5 py-0.5 text-xs font-medium text-brand-navy ring-1 ring-inset ring-brand-navy/20">
                        Featured
                    </span>
                @endif
            </div>

            @if (filled($tour->summary))
                <p class="mt-3 text-sm text-slate-600">{{ $tour->summary }}</p>
            @endif
        </div>
    </div>

    <dl class="grid gap-4 rounded-xl border border-slate-200 bg-slate-50/70 p-4 sm:grid-cols-2 lg:grid-cols-3">
        <div>
            <dt class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Year</dt>
            <dd class="mt-0.5 text-sm font-medium text-slate-700">{{ $tour->year }}</dd>
        </div>

        <div>
            <dt class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Country / region</dt>
            <dd class="mt-0.5 text-sm font-medium text-slate-700">{{ $tour->country ?: '—' }}</dd>
        </div>

        <div>
            <dt class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Duration</dt>
            <dd class="mt-0.5 text-sm font-medium text-slate-700">{{ $tour->duration_days ? $tour->duration_days.' days' : '—' }}</dd>
        </div>

        <div>
            <dt class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Start date</dt>
            <dd class="mt-0.5 text-sm font-medium text-slate-700">{{ $tour->start_date?->format('d M Y') ?? '—' }}</dd>
        </div>

        <div>
            <dt class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">End date</dt>
            <dd class="mt-0.5 text-sm font-medium text-slate-700">{{ $tour->end_date?->format('d M Y') ?? '—' }}</dd>
        </div>

        <div>
            <dt class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Date label</dt>
            <dd class="mt-0.5 text-sm font-medium text-slate-700">{{ $tour->date_label ?: '—' }}</dd>
        </div>

        <div>
            <dt class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Price (GBP)</dt>
            <dd class="mt-0.5 text-sm font-semibold text-slate-800">{{ $money($tour->price_gbp, '£') }}</dd>
        </div>

        <div>
            <dt class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Price (USD)</dt>
            <dd class="mt-0.5 text-sm font-semibold text-slate-800">{{ $money($tour->price_usd, '$') }}</dd>
        </div>

        <div>
            <dt class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Single supplement (GBP)</dt>
            <dd class="mt-0.5 text-sm font-medium text-slate-700">{{ $money($tour->single_supplement_gbp, '£') }}</dd>
        </div>

        <div>
            <dt class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Single supplement (USD)</dt>
            <dd class="mt-0.5 text-sm font-medium text-slate-700">{{ $money($tour->single_supplement_usd, '$') }}</dd>
        </div>

        <div>
            <dt class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Sort order</dt>
            <dd class="mt-0.5 text-sm font-medium text-slate-700">{{ $tour->sort_order }}</dd>
        </div>

        <div>
            <dt class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Last updated</dt>
            <dd class="mt-0.5 text-sm font-medium text-slate-700">{{ $tour->updated_at?->format('d M Y, H:i') ?? '—' }}</dd>
        </div>
    </dl>

    @if ($hasLongContent)
        <div class="space-y-4">
            @if (filled($tour->summary))
                <div>
                    <h4 class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Summary</h4>
                    <p class="mt-1 whitespace-pre-line text-sm leading-relaxed text-slate-700">{{ $tour->summary }}</p>
                </div>
            @endif

            @if (filled($tour->description))
                <div>
                    <h4 class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Description</h4>
                    <p class="mt-1 whitespace-pre-line text-sm leading-relaxed text-slate-700">{{ $tour->description }}</p>
                </div>
            @endif

            @if (filled($tour->itinerary))
                <div>
                    <h4 class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Itinerary</h4>
                    <p class="mt-1 whitespace-pre-line text-sm leading-relaxed text-slate-700">{{ $tour->itinerary }}</p>
                </div>
            @endif
        </div>
    @endif

    @if (filled($tour->meta_title) || filled($tour->meta_description))
        <div class="rounded-xl border border-slate-200 p-4">
            <h4 class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">SEO</h4>
            <p class="mt-2 text-sm font-semibold text-slate-800">{{ $tour->meta_title ?: '—' }}</p>
            <p class="mt-1 text-sm text-slate-600">{{ $tour->meta_description ?: '—' }}</p>
        </div>
    @endif

    <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-4 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-xs text-slate-400">
            Created {{ $tour->created_at?->format('d M Y, H:i') ?? '—' }}
        </p>

        <div class="flex items-center justify-end gap-2">
            <a href="{{ route('admin.tours.edit', $tour) }}" class="inline-flex items-center rounded-lg bg-brand-navy px-3.5 py-2 text-sm font-semibold text-white transition hover:bg-brand-navy/90">
                Edit tour
            </a>

            <form method="POST" action="{{ route('admin.tours.destroy', $tour) }}" onsubmit="return confirm('Delete this tour?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center rounded-lg border border-red-200 px-3.5 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-50">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>
