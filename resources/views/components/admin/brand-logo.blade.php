@props(['size' => 'h-9', 'framed' => false])

@php
    $src = asset('images/kunam-logo.jpg');
@endphp

@if ($framed)
    <span {{ $attributes->class('inline-flex items-center justify-center rounded-xl bg-white px-4 py-2 shadow-sm') }}>
        <img src="{{ $src }}" alt="Kunam Birding Tours" class="{{ $size }} w-auto">
    </span>
@else
    <img src="{{ $src }}" alt="Kunam Birding Tours" {{ $attributes->class($size.' w-auto') }}>
@endif
