@props(['status' => null])

@php
    $value = $status instanceof \BackedEnum ? $status->value : (string) $status;

    $label = match (true) {
        $status instanceof \App\Enums\TourStatus => $status->label(),
        $status instanceof \BackedEnum && method_exists($status, 'label') => $status->label(),
        default => match ($value) {
            'published' => 'Published',
            'draft' => 'Draft',
            'deposit_paid' => 'Deposit paid',
            'twin_share' => 'Twin share',
            'single_supplement' => 'Single supplement',
            default => ucfirst(str_replace('_', ' ', $value)),
        },
    };

    $classes = match ($value) {
        'available', 'published', 'active', 'confirmed', 'paid', 'replied', 'open', 'completed' => 'bg-brand-green/10 text-brand-green ring-brand-green/20',
        'provisional', 'pending', 'deposit_paid' => 'bg-amber-50 text-amber-700 ring-amber-200',
        'full', 'cancelled', 'refunded', 'inactive' => 'bg-red-50 text-red-700 ring-red-200',
        'new' => 'bg-sky-50 text-sky-700 ring-sky-200',
        default => 'bg-slate-100 text-slate-600 ring-slate-200',
    };
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset '.$classes]) }}>
    {{ $label }}
</span>
