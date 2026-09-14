@props(['job', 'compact' => false])

<div {{ $attributes->class(['flex flex-wrap text-tvip-muted', 'gap-x-4 gap-y-2' => $compact, 'flex-col gap-2' => ! $compact]) }}>
    <span class="inline-flex items-center gap-2 text-sm leading-5">
        <img src="{{ asset('images/tvip/career/icon-location.svg') }}" alt="" aria-hidden="true" class="size-4 shrink-0">
        {{ $job->location->name }}
    </span>
    <span class="inline-flex items-center gap-2 text-sm leading-5">
        <img src="{{ asset('images/tvip/career/icon-employment.svg') }}" alt="" aria-hidden="true" class="size-4 shrink-0">
        {{ $job->employment_type_label }}
    </span>
    @unless ($compact)
        <span class="inline-flex items-center gap-2 text-sm leading-5">
            <img src="{{ asset('images/tvip/career/icon-period.svg') }}" alt="" aria-hidden="true" class="size-4 shrink-0">
            Periode {{ $job->opens_at->translatedFormat('j M Y') }} s/d {{ $job->closes_at->translatedFormat('j M Y') }}
        </span>
    @endunless
</div>
