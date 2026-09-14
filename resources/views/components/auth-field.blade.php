@props([
    'name',
    'label',
    'type' => 'text',
    'placeholder' => '',
    'autocomplete' => 'off',
    'icon' => null,
    'required' => false,
])

@php
    $id = $attributes->get('id', $name);
    $error = $errors->first($name);
    $describedBy = $error ? $id.'-error' : null;
    $isPassword = $type === 'password';
@endphp

<div @if ($isPassword) x-data="{ visible: false }" @endif>
    <label for="{{ $id }}" class="mb-2 block text-sm font-medium leading-5 text-tvip-label">
        {{ $label }}
        @if ($required)
            <span class="text-tvip-required" aria-hidden="true">*</span>
        @endif
    </label>

    <div class="relative">
        @if ($icon)
            <img src="{{ asset('images/tvip/career/'.$icon) }}" alt="" aria-hidden="true" class="pointer-events-none absolute left-4 top-1/2 size-5 -translate-y-1/2">
        @endif

        <input
            id="{{ $id }}"
            name="{{ $name }}"
            @if ($isPassword)
                :type="visible ? 'text' : 'password'"
            @else
                type="{{ $type }}"
                value="{{ old($name) }}"
            @endif
            placeholder="{{ $placeholder }}"
            autocomplete="{{ $autocomplete }}"
            @if ($required) required @endif
            @if ($error) aria-invalid="true" @endif
            @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
            {{ $attributes->except(['id'])->class([
                'h-[54px] w-full rounded-tvip-button border bg-white py-3 text-sm leading-5 text-tvip-heading placeholder:text-tvip-placeholder',
                'pl-12' => $icon,
                'pl-4' => ! $icon,
                'pr-24' => $isPassword,
                'pr-4' => ! $isPassword,
                'border-tvip-required' => $error,
                'border-tvip-divider hover:border-tvip-outline' => ! $error,
            ]) }}
        >

        @if ($isPassword)
            <button
                type="button"
                class="absolute right-2 top-1/2 min-h-10 -translate-y-1/2 rounded-md px-3 text-xs font-medium text-tvip-blue hover:bg-tvip-surface"
                @click="visible = ! visible"
                :aria-label="visible ? 'Sembunyikan password' : 'Tampilkan password'"
                :aria-pressed="visible"
                x-text="visible ? 'Sembunyikan' : 'Lihat'"
            ></button>
        @endif
    </div>

    @if ($error)
        <p id="{{ $id }}-error" class="mt-2 text-sm leading-5 text-tvip-required" role="alert">{{ $error }}</p>
    @endif
</div>
