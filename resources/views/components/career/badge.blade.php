@props(['label', 'tone' => 'neutral'])

@php
    $toneClasses = match ($tone) {
        'sales' => 'bg-tvip-badge-blue-bg text-tvip-badge-blue',
        'operations' => 'bg-tvip-badge-green-bg text-tvip-badge-green',
        'manager' => 'bg-tvip-badge-red-bg text-tvip-badge-red',
        'supervisor' => 'bg-tvip-badge-indigo-bg text-tvip-badge-indigo',
        'logistics' => 'bg-tvip-badge-orange-bg text-tvip-badge-orange',
        default => 'bg-tvip-social-bg text-tvip-body',
    };
@endphp

<span {{ $attributes->class("inline-flex items-center rounded-tvip-full px-2.5 py-0.5 text-xs font-medium leading-4 {$toneClasses}") }}>{{ $label }}</span>
