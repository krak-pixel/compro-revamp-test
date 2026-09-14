@props([
    'size' => '64',
    'background' => 'light',
])

@php
    $sizeClasses = match ((string) $size) {
        '40' => 'size-10 p-[10px]',
        '48' => 'size-12 p-3',
        default => 'size-16 p-4',
    };

    $backgroundClasses = $background === 'social'
        ? 'bg-tvip-social-bg'
        : 'bg-tvip-light-section';
@endphp

<div {{ $attributes->class("inline-flex shrink-0 items-center justify-center rounded-tvip-full {$sizeClasses} {$backgroundClasses}") }}>
    {{ $slot }}
</div>
