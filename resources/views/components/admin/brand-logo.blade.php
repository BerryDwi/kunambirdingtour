@props(['size' => 'h-9', 'framed' => false])

@php
    $src = 'https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e8c523028289f697f322d6e_Birdtour-Asia-CMYK-logo.png';
@endphp

@if ($framed)
    <span {{ $attributes->class('inline-flex items-center justify-center rounded-xl bg-white px-4 py-2 shadow-sm') }}>
        <img src="{{ $src }}" alt="Birdtour Asia" class="{{ $size }} w-auto">
    </span>
@else
    <img src="{{ $src }}" alt="Birdtour Asia" {{ $attributes->class($size.' w-auto') }}>
@endif
