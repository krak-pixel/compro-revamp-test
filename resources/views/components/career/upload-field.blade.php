@props(['name', 'label', 'accept', 'help', 'document' => null, 'required' => false])

@php
    $id = 'upload-'.preg_replace('/[^a-zA-Z0-9_-]/', '-', $name);
    $errorKey = str_replace(['[', ']'], ['.', ''], $name);
@endphp

<div x-data="filePicker()">
    <label for="{{ $id }}" class="block text-sm font-medium leading-5 text-tvip-label">
        {{ $label }}
        @if ($required)<span class="text-tvip-required" aria-hidden="true">*</span>@endif
    </label>
    <label
        for="{{ $id }}"
        class="mt-2 flex min-h-12 cursor-pointer items-center justify-between gap-3 rounded-tvip-button border border-dashed border-tvip-outline bg-white px-4 py-2.5 hover:border-tvip-blue focus-within:ring-2 focus-within:ring-tvip-blue focus-within:ring-offset-2"
    >
        <span class="min-w-0 truncate text-sm" :class="fileName ? 'text-tvip-heading' : 'text-tvip-muted'" x-text="fileName || {{ Illuminate\Support\Js::from($document?->original_name ?: 'Pilih berkas') }}"></span>
        <span class="shrink-0 text-sm font-semibold text-tvip-blue">Unggah</span>
        <input id="{{ $id }}" name="{{ $name }}" type="file" accept="{{ $accept }}" class="sr-only" @change="select($event)" @if($required && !$document) required @endif aria-invalid="{{ $errors->has($errorKey) ? 'true' : 'false' }}" aria-describedby="{{ $id }}-help{{ $errors->has($errorKey) ? ' '.$id.'-error' : '' }}">
    </label>
    <p id="{{ $id }}-help" class="mt-1.5 text-xs leading-5 text-tvip-muted">{{ $help }}</p>
    @if ($document)
        <a href="{{ route('career.documents.show', $document) }}" class="mt-1 inline-flex min-h-8 items-center text-xs font-medium text-tvip-blue hover:underline">Unduh berkas tersimpan</a>
    @endif
    @error($errorKey)<p id="{{ $id }}-error" class="mt-1.5 text-xs font-medium text-tvip-required" role="alert">{{ $message }}</p>@enderror
</div>
