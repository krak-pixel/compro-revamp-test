@php
    $queryParams = array_filter(
        Illuminate\Support\Arr::only($filters, ['q', 'department', 'position', 'location', 'page']),
        fn ($value) => filled($value),
    );
    $pageTitle = $selectedJob ? $selectedJob->title.' — TVIP Karir' : 'Karir — TVIP';
    $pageDescription = $selectedJob
        ? $selectedJob->description
        : 'Temukan peluang karir di perusahaan distribusi dan logistik TVIP Group.';
    $toJobPosting = fn ($job) => [
        '@context' => 'https://schema.org',
        '@type' => 'JobPosting',
        'title' => $job->title,
        'description' => $job->description,
        'datePosted' => optional($job->published_at)->toDateString(),
        'validThrough' => $job->closes_at->endOfDay()->toIso8601String(),
        'employmentType' => strtoupper($job->employment_type),
        'hiringOrganization' => [
            '@type' => 'Organization',
            'name' => 'TVIP Group',
            'sameAs' => url('/'),
            'logo' => asset('images/tvip/logo-tvip-horizontal.png'),
        ],
        'jobLocation' => [
            '@type' => 'Place',
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => $job->location->name,
                'addressCountry' => 'ID',
            ],
        ],
        'url' => route('career.show', ['slug' => $job->slug]),
    ];
    $structuredData = $selectedJob
        ? $toJobPosting($selectedJob)
        : [
            '@context' => 'https://schema.org',
            '@type' => 'ItemList',
            'numberOfItems' => $jobs->total(),
            'itemListElement' => $jobs->getCollection()->values()->map(fn ($job, $index) => [
                '@type' => 'ListItem',
                'position' => $jobs->firstItem() + $index,
                'name' => $job->title,
                'url' => route('career.show', ['slug' => $job->slug]),
            ]),
        ];
@endphp

<x-layouts.app
    :title="$pageTitle"
    :description="$pageDescription"
    :canonical="url()->current()"
    :og-image="$selectedJob ? asset($selectedJob->poster_path) : asset('images/tvip/career/preseller-gt-retail-afh.png')"
    current-page="career"
>
    <x-slot:head>
        <script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
    </x-slot:head>

    <div
        x-data="careerPage({
            drawerMode: {{ Illuminate\Support\Js::from($drawerMode) }},
            listUrl: {{ Illuminate\Support\Js::from($listUrl) }},
            searchQuery: {{ Illuminate\Support\Js::from($filters['q'] ?? '') }}
        })"
        @keydown.window="handleGlobalKeydown($event)"
    >
        <x-career.hero :stats="$stats" />

        <div class="tvip-container relative z-20 -mt-4 sm:-mt-8">
            <x-career.filters :filters="$filters" :departments="$departments" :positions="$positions" :locations="$locations" />
        </div>

        <section class="tvip-container py-12 sm:py-16" aria-labelledby="job-list-heading">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <h2 id="job-list-heading" class="text-sm font-medium leading-5 text-tvip-body">
                    Menampilkan <strong class="font-semibold text-tvip-heading">{{ $jobs->total() }}</strong> lowongan
                </h2>
                <p class="text-sm leading-5 text-tvip-muted">Halaman {{ $jobs->currentPage() }} / {{ max(1, $jobs->lastPage()) }}</p>
            </div>

            @if ($jobs->count())
                <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($jobs as $job)
                        <x-career.job-card :job="$job" :query-params="$queryParams" />
                    @endforeach
                </div>

                <x-career.pagination :paginator="$jobs" />
            @else
                <div class="mt-8 rounded-tvip-card border border-tvip-divider bg-tvip-surface px-6 py-16 text-center">
                    <div class="mx-auto inline-flex size-14 items-center justify-center rounded-tvip-full bg-tvip-badge-blue-bg">
                        <img src="{{ asset('images/tvip/career/icon-search.svg') }}" alt="" aria-hidden="true" class="size-6">
                    </div>
                    <h3 class="mt-5 text-xl font-semibold text-tvip-heading">
                        {{ $queryParams ? 'Lowongan tidak ditemukan' : 'Belum ada lowongan aktif' }}
                    </h3>
                    <p class="mx-auto mt-2 max-w-lg text-sm leading-6 text-tvip-body">
                        {{ $queryParams ? 'Coba gunakan kata kunci lain atau hapus filter untuk melihat peluang yang tersedia.' : 'Peluang baru akan ditampilkan di halaman ini setelah tersedia.' }}
                    </p>
                    @if ($queryParams)
                        <a href="{{ route('career.index') }}" class="mt-6 inline-flex min-h-11 items-center justify-center rounded-tvip-button bg-tvip-blue px-6 text-sm font-medium text-white hover:bg-tvip-blue-dark">Reset filter</a>
                    @endif
                </div>
            @endif
        </section>

        <section class="tvip-container pb-20" aria-labelledby="career-cta-title">
            <div class="flex min-h-[186px] flex-col justify-between gap-8 rounded-tvip-card-lg bg-tvip-primary px-7 py-9 text-white shadow-tvip-cta sm:px-12 sm:py-10 lg:flex-row lg:items-center">
                <div>
                    <h2 id="career-cta-title" class="text-[22px] font-bold leading-9">Tidak Menemukan Posisi yang Cocok?</h2>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-tvip-on-dark-muted">Kirimkan CV dan portofolio Anda ke tim HR TVIP. Fitur pengiriman akan tersedia pada Versi 3.</p>
                </div>
                <a href="{{ route('career.send-cv') }}" class="inline-flex min-h-12 shrink-0 items-center justify-center rounded-tvip-button-lg bg-white px-8 text-sm font-semibold text-tvip-blue hover:bg-tvip-surface">Kirim CV Sekarang</a>
            </div>
        </section>

        <x-career.poster-modal />

        @if ($drawerMode)
            <x-career.drawer :mode="$drawerMode" :job="$selectedJob" :list-url="$listUrl" :query-params="$queryParams" />
        @endif
    </div>
</x-layouts.app>
