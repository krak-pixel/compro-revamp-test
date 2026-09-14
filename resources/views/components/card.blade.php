@props([
    'variant' => 'info',
])

@php
    $classes = match ($variant) {
        'contact' => 'rounded-tvip-card bg-white shadow-tvip-contact',
        'cta' => 'rounded-tvip-card-lg bg-white shadow-tvip-floating',
        default => 'overflow-hidden rounded-tvip-card-lg bg-tvip-light-card shadow-tvip-info-card',
    };
@endphp

<div {{ $attributes->class($classes) }}>
    {{ $slot }}
</div>
