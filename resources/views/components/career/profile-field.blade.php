@props([
    'name', 'label', 'type' => 'text', 'value' => '', 'required' => false,
    'options' => [], 'placeholder' => '', 'help' => null,
])

@php
    $id = 'field-'.preg_replace('/[^a-zA-Z0-9_-]/', '-', $name);
    $errorKey = str_replace(['[', ']'], ['.', ''], $name);
    $fieldValue = old($errorKey, $value);
    $describedBy = collect([$help ? $id.'-help' : null, $errors->has($errorKey) ? $id.'-error' : null])->filter()->join(' ');
@endphp

<label for="{{ $id }}" class="block text-sm font-medium leading-5 text-tvip-label">
    {{ $label }}
    @if ($required)<span class="text-tvip-required" aria-hidden="true">*</span>@endif
    @if ($type === 'textarea')
        <textarea
            id="{{ $id }}"
            name="{{ $name }}"
            rows="4"
            placeholder="{{ $placeholder }}"
            @if($required) required @endif
            aria-invalid="{{ $errors->has($errorKey) ? 'true' : 'false' }}"
            @if($describedBy) aria-describedby="{{ $describedBy }}" @endif
            @class(['career-control mt-2 h-auto min-h-28 resize-none py-3', 'border-tvip-required' => $errors->has($errorKey)])
            {{ $attributes }}
        >{{ $fieldValue }}</textarea>
    @elseif ($type === 'select')
        <select
            id="{{ $id }}"
            name="{{ $name }}"
            @if($required) required @endif
            aria-invalid="{{ $errors->has($errorKey) ? 'true' : 'false' }}"
            @if($describedBy) aria-describedby="{{ $describedBy }}" @endif
            @class(['career-control mt-2', 'border-tvip-required' => $errors->has($errorKey)])
            {{ $attributes }}
        >
            <option value="">{{ $placeholder ?: 'Pilih '.$label }}</option>
            @foreach ($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" @selected((string) $fieldValue === (string) $optionValue)>{{ $optionLabel }}</option>
            @endforeach
        </select>
    @else
        <input
            id="{{ $id }}"
            name="{{ $name }}"
            type="{{ $type }}"
            value="{{ $fieldValue }}"
            placeholder="{{ $placeholder }}"
            @if($required) required @endif
            aria-invalid="{{ $errors->has($errorKey) ? 'true' : 'false' }}"
            @if($describedBy) aria-describedby="{{ $describedBy }}" @endif
            @class(['career-control mt-2', 'border-tvip-required' => $errors->has($errorKey)])
            {{ $attributes }}
        >
    @endif
    @if ($help)<span id="{{ $id }}-help" class="mt-1.5 block text-xs leading-5 text-tvip-muted">{{ $help }}</span>@endif
    @error($errorKey)<span id="{{ $id }}-error" class="mt-1.5 block text-xs font-medium text-tvip-required" role="alert">{{ $message }}</span>@enderror
</label>
