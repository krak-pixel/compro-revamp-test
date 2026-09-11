@props(['job', 'queryParams' => []])

@php
    $departmentTone = match ($job->department->slug) {
        'sales' => 'sales',
        'operations' => 'operations',
        'logistik' => 'logistics',
        default => 'neutral',
    };
    $levelTone = match (strtolower((string) $job->position->level)) {
        'manager' => 'manager',
        'supervisor' => 'supervisor',
        default => 'neutral',
    };
    $detailParameters = ['slug' => $job->slug, ...$queryParams];
@endphp

<article class="group flex min-h-[446px] flex-col overflow-hidden rounded-tvip-card border border-tvip-social-bg bg-white shadow-tvip-job transition duration-200 hover:-translate-y-1 hover:shadow-tvip-cta motion-reduce:transform-none motion-reduce:transition-none">
    <button
        type="button"
        class="relative block h-52 w-full overflow-hidden bg-tvip-surface text-left"
        @click="openPoster(@js(asset($job->poster_path)), @js('Poster lowongan '.$job->title), $event.currentTarget)"
        aria-label="Perbesar poster lowongan {{ $job->title }}"
    >
        <img src="{{ asset($job->poster_path) }}" alt="Poster lowongan {{ $job->title }}" width="774" height="774" loading="lazy" class="h-full w-full object-cover object-top transition duration-300 group-hover:scale-[1.02] motion-reduce:transform-none motion-reduce:transition-none">
        <span class="absolute bottom-3 right-3 rounded-tvip-full bg-white/95 px-3 py-1.5 text-xs font-semibold text-tvip-blue shadow-tvip-job">Lihat poster</span>
    </button>

    <div class="flex flex-1 flex-col px-5 py-5">
        <div class="flex flex-wrap gap-2">
            <x-career.badge :label="$job->department->name" :tone="$departmentTone" />
            <x-career.badge :label="$job->position->level ?: 'Staff'" :tone="$levelTone" />
        </div>

        <h2 class="mt-4 text-base font-semibold leading-[26px] text-tvip-heading">
            <a href="{{ route('career.show', $detailParameters) }}" class="rounded-sm hover:text-tvip-blue">{{ $job->title }}</a>
        </h2>

        <x-career.job-metadata :job="$job" class="mt-4" />

        <a href="{{ route('career.apply', $detailParameters) }}" class="mt-auto inline-flex h-[42px] w-full items-center justify-center rounded-tvip-button-lg bg-tvip-primary px-6 text-sm font-medium text-white transition hover:opacity-90 active:translate-y-px">
            Lamar
        </a>
    </div>
</article>
