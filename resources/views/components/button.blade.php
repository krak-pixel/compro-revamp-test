@props([
    'href' => null,
    'variant' => 'primary',
    'size' => 'hero',
    'type' => 'button',
])

@php
    $variantClasses = match ($variant) {
        'outline' => 'border border-tvip-outline bg-transparent text-tvip-cta-secondary',
        'text' => 'bg-transparent text-tvip-black',
        default => 'bg-tvip-primary text-white',
    };

    $sizeClasses = match ($size) {
        'cta' => 'h-[60px] rounded-tvip-button-lg px-8 text-base leading-[26px]',
        default => 'h-9 rounded-tvip-button px-8 text-sm leading-5',
    };

    $classes = "inline-flex items-center justify-center whitespace-nowrap font-medium transition-opacity hover:opacity-90 {$variantClasses} {$sizeClasses}";
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->class($classes) }}>
        {{ $slot }}
    </button>
@endif
