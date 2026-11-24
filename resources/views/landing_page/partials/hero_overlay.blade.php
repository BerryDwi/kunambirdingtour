@php
    $heroValue = fn (string $suffix): string => (string) ($settings[$page.'_hero_'.$suffix] ?? '');

    $heroBadge = $heroValue('badge');
    $heroDate = $heroValue('date');
    $heroTitle = $heroValue('title');
    $heroText = $heroValue('text');
    $heroCtaLabel = $heroValue('cta_label');
    $heroCtaUrl = $heroValue('cta_url');
    $heroSecondaryLabel = $heroValue('secondary_cta_label');
    $heroSecondaryUrl = $heroValue('secondary_cta_url');
@endphp

<div class="bta-announcement-overlay">
    @if ($heroBadge !== '' || $heroDate !== '')
        <div class="d-flex align-items-center gap-2 mb-2">
            @if ($heroBadge !== '')
                <span class="badge bg-success text-uppercase px-2 py-1" style="font-size: 11px; letter-spacing: 0.5px;">{{ $heroBadge }}</span>
            @endif
            @if ($heroDate !== '')
                <span class="text-white-50 small">{{ $heroDate }}</span>
            @endif
        </div>
    @endif

    @if ($heroTitle !== '')
        <h4>{{ $heroTitle }}</h4>
    @endif

    @if ($heroText !== '')
        <p>{{ $heroText }}</p>
    @endif

    @if ($heroCtaLabel !== '' && $heroCtaUrl !== '')
        <div class="mt-3 d-flex flex-wrap gap-2">
            <a href="{{ $heroCtaUrl }}" class="btn btn-sm btn-primary py-1 px-3">{{ $heroCtaLabel }}</a>
            @if ($heroSecondaryLabel !== '' && $heroSecondaryUrl !== '')
                <a href="{{ $heroSecondaryUrl }}" class="btn btn-sm btn-outline-light py-1 px-3">{{ $heroSecondaryLabel }}</a>
            @endif
        </div>
    @endif
</div>
