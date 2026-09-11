@props(['mode', 'job' => null, 'listUrl', 'queryParams' => []])

@php
    $departmentTone = $job ? match ($job->department->slug) {
        'sales' => 'sales',
        'operations' => 'operations',
        'logistik' => 'logistics',
        default => 'neutral',
    } : 'neutral';
    $levelTone = $job ? match (strtolower((string) $job->position->level)) {
        'manager' => 'manager',
        'supervisor' => 'supervisor',
        default => 'neutral',
    } : 'neutral';
    $isDetail = $mode === 'detail';
    $isApply = $mode === 'apply';
    $isSendCv = $mode === 'send-cv';
@endphp

<div
    x-cloak
    x-show="drawerMode"
    x-transition.opacity.duration.200ms
    class="fixed inset-0 z-backdrop bg-black/60"
    @click.self="closeDrawer()"
    aria-hidden="true"
></div>

<aside
    x-cloak
    x-show="drawerMode"
    x-ref="drawer"
    x-transition:enter="transition duration-300 ease-out motion-reduce:transition-none"
    x-transition:enter-start="translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition duration-200 ease-out motion-reduce:transition-none"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="translate-x-full"
    @keydown.tab="trapFocus($event, $refs.drawer)"
    class="fixed inset-y-0 right-0 z-sheet flex w-full max-w-[600px] flex-col bg-white shadow-tvip-overlay"
    role="dialog"
    aria-modal="true"
    aria-labelledby="career-drawer-title"
    aria-describedby="career-drawer-description"
>
    <button
        x-ref="drawerClose"
        type="button"
        @click="closeDrawer()"
        class="absolute right-4 top-3 z-10 inline-flex size-11 items-center justify-center rounded-tvip-full bg-tvip-social-bg text-xl text-tvip-body hover:bg-tvip-divider sm:right-6"
        aria-label="Tutup panel"
    >×</button>

    @if ($isDetail && $job)
        <div class="relative h-44 shrink-0 overflow-hidden bg-tvip-surface sm:h-64">
            <img src="{{ asset($job->poster_path) }}" alt="Poster lowongan {{ $job->title }}" width="774" height="774" class="h-full w-full object-cover object-top">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/15 to-transparent" aria-hidden="true"></div>
            <div class="absolute inset-x-0 bottom-0 p-5 text-white sm:p-8">
                <div class="flex flex-wrap gap-2">
                    <x-career.badge :label="$job->department->name" :tone="$departmentTone" class="px-3 py-1" />
                    <x-career.badge :label="$job->position->level ?: 'Staff'" :tone="$levelTone" class="px-3 py-1" />
                </div>
                <p class="mt-3 text-lg font-bold leading-7">{{ $job->title }}</p>
            </div>
        </div>
    @endif

    <div class="min-h-0 flex-1 overflow-y-auto px-5 pb-8 pt-6 sm:px-8 sm:pt-7">
        @if ($isSendCv)
            <header class="pr-12">
                <h2 id="career-drawer-title" class="text-xl font-bold leading-7 text-tvip-blue">Kirim CV Sekarang</h2>
                <p id="career-drawer-description" class="mt-2 text-sm leading-5 text-tvip-muted">Preview akun kandidat dan informasi peluang yang diminati</p>
            </header>

            <section class="mt-6 rounded-tvip-candidate border border-tvip-divider bg-tvip-surface p-5" aria-label="Preview kandidat">
                <div class="flex items-center gap-4">
                    <span class="inline-flex size-16 shrink-0 items-center justify-center rounded-tvip-button border-2 border-tvip-outline bg-white">
                        <img src="{{ asset('images/tvip/career/icon-profile.svg') }}" alt="" aria-hidden="true" class="size-8">
                    </span>
                    <div class="min-w-0">
                        <h3 class="truncate text-base font-semibold leading-[26px] text-tvip-heading">{{ auth()->user()->display_name }}</h3>
                        <p class="truncate text-sm leading-5 text-tvip-muted">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <dl class="mt-5 grid grid-cols-2 gap-x-6 gap-y-4 text-sm leading-5">
                    @foreach ([['No. Telepon', 'Belum dilengkapi'], ['Tempat Tinggal', 'Belum dilengkapi'], ['Status', 'Belum dilengkapi'], ['Pendidikan', 'Belum dilengkapi']] as [$label, $value])
                        <div>
                            <dt class="text-tvip-muted">{{ $label }}</dt>
                            <dd class="mt-0.5 font-medium text-tvip-heading">{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>
            </section>

            <section class="mt-6" aria-labelledby="interest-title">
                <h3 id="interest-title" class="text-base font-semibold leading-[26px] text-tvip-heading">Informasi Posisi yang Diminati</h3>
                <div class="mt-4 space-y-4">
                    @foreach ([['Departemen', 'Pilih departemen'], ['Posisi', 'Pilih posisi'], ['Lokasi', 'Pilih lokasi']] as [$label, $placeholder])
                        <label class="block text-sm font-medium leading-5 text-tvip-label">
                            {{ $label }} <span class="text-tvip-required" aria-hidden="true">*</span>
                            <select class="career-control mt-2 opacity-60" disabled aria-describedby="v3-notice">
                                <option>{{ $placeholder }}</option>
                            </select>
                        </label>
                    @endforeach
                </div>
            </section>
        @elseif ($job)
            <header class="pr-12">
                <h2 id="career-drawer-title" class="text-xl font-bold leading-7 text-tvip-blue">{{ $isApply ? 'Konfirmasi Lamaran' : 'Job Detail' }}</h2>
                <p id="career-drawer-description" class="mt-2 text-sm leading-5 text-tvip-muted">
                    {{ $isApply ? 'Pastikan informasi posisi sesuai dengan pekerjaan yang Anda inginkan' : 'Informasi lengkap tentang posisi yang tersedia' }}
                </p>
            </header>

            <section class="mt-6">
                <div class="flex flex-wrap gap-2">
                    <x-career.badge :label="$job->department->name" :tone="$departmentTone" class="px-3 py-1" />
                    <x-career.badge :label="$job->position->level ?: 'Staff'" :tone="$levelTone" class="px-3 py-1" />
                </div>
                <h3 class="mt-4 text-lg font-semibold leading-7 text-tvip-blue">{{ $job->title }}</h3>
                <x-career.job-metadata :job="$job" compact class="mt-3" />
            </section>

            <section class="mt-6">
                <h3 class="text-base font-semibold leading-[26px] text-tvip-heading">Deskripsi Pekerjaan</h3>
                <p class="mt-2 text-sm leading-6 text-tvip-body">{{ $job->description }}</p>
            </section>

            <section class="mt-6">
                <h3 class="text-base font-semibold leading-[26px] text-tvip-heading">Kualifikasi</h3>
                <ul class="mt-3 space-y-2.5">
                    @foreach ($job->qualifications as $qualification)
                        <li class="flex gap-2.5 text-sm leading-5 text-tvip-body">
                            <span class="mt-0.5 inline-flex size-4 shrink-0 items-center justify-center rounded-tvip-full border border-tvip-blue text-[10px] font-bold text-tvip-blue" aria-hidden="true">✓</span>
                            <span>{{ $qualification }}</span>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif

        @if ($isApply || $isSendCv)
            <div id="v3-notice" class="mt-6 rounded-tvip-button border border-tvip-badge-blue bg-tvip-badge-blue-bg px-4 py-3 text-sm leading-5 text-tvip-blue" role="note">
                Pelengkapan profil, upload CV, dan pengiriman lamaran akan tersedia pada Versi 3.
            </div>
        @endif
    </div>

    <footer class="shrink-0 border-t border-tvip-divider bg-white px-5 py-4 sm:px-8">
        @if ($isDetail && $job)
            <a href="{{ route('career.apply', ['slug' => $job->slug, ...$queryParams]) }}" class="inline-flex h-11 w-full items-center justify-center rounded-tvip-button bg-tvip-blue px-6 text-sm font-medium text-white hover:bg-tvip-blue-dark">Lamar</a>
        @else
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ $listUrl }}" class="inline-flex h-11 items-center justify-center rounded-tvip-button border border-tvip-divider text-sm font-medium text-tvip-heading hover:bg-tvip-surface">Batal</a>
                <button type="button" class="h-11 rounded-tvip-button bg-tvip-blue px-4 text-sm font-medium text-white opacity-50" disabled aria-describedby="v3-notice">Lamar Sekarang</button>
            </div>
        @endif
    </footer>
</aside>
