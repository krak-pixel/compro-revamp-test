@props([
    'mode', 'job' => null, 'listUrl', 'queryParams' => [],
    'departments' => collect(), 'positions' => collect(), 'locations' => collect(),
    'candidateProfile' => null, 'candidatePhoto' => null, 'candidateCv' => null,
])

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
                <p id="career-drawer-description" class="mt-2 text-sm leading-5 text-tvip-muted">Pilih peluang yang diminati lalu kirim profil Anda ke talent pool.</p>
            </header>

            <section class="mt-6 rounded-tvip-candidate border border-tvip-divider bg-tvip-surface p-5" aria-label="Preview kandidat">
                <div class="flex items-center gap-4">
                    <span class="inline-flex size-16 shrink-0 items-center justify-center overflow-hidden rounded-tvip-button border-2 border-tvip-outline bg-white">
                        @if ($candidatePhoto)
                            <img src="{{ route('career.documents.show', $candidatePhoto) }}" alt="Foto {{ $candidateProfile->full_name }}" width="64" height="64" class="h-full w-full object-cover">
                        @else
                            <img src="{{ asset('images/tvip/career/icon-profile.svg') }}" alt="" aria-hidden="true" class="size-8">
                        @endif
                    </span>
                    <div class="min-w-0">
                        <h3 class="truncate text-base font-semibold leading-[26px] text-tvip-heading">{{ $candidateProfile->full_name }}</h3>
                        <p class="truncate text-sm leading-5 text-tvip-muted">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <dl class="mt-5 grid grid-cols-2 gap-x-6 gap-y-4 text-sm leading-5">
                    @foreach ([['No. Telepon', $candidateProfile->phone], ['Tempat Tinggal', $candidateProfile->residence_city], ['Status', $candidateProfile->experience_status === 'experienced' ? 'Berpengalaman' : 'Fresh Graduate'], ['Pendidikan', $candidateProfile->educations->last()?->institution_name]] as [$label, $value])
                        <div>
                            <dt class="text-tvip-muted">{{ $label }}</dt>
                            <dd class="mt-0.5 font-medium text-tvip-heading">{{ $value ?: 'Belum dilengkapi' }}</dd>
                        </div>
                    @endforeach
                </dl>
            </section>

            <form id="talent-pool-form" method="POST" action="{{ route('career.applications.talent-pool') }}" class="mt-6" novalidate x-data="{ department: {{ Illuminate\Support\Js::from((string) old('department_id')) }} }" @submit="submittingApplication = true">
                @csrf
            <section aria-labelledby="interest-title">
                <h3 id="interest-title" class="text-base font-semibold leading-[26px] text-tvip-heading">Informasi Posisi yang Diminati</h3>
                <div class="mt-4 space-y-4">
                    <label class="block text-sm font-medium leading-5 text-tvip-label">Departemen <span class="text-tvip-required" aria-hidden="true">*</span>
                        <select name="department_id" x-model="department" @change="$refs.position.value = ''" class="career-control mt-2" required aria-invalid="{{ $errors->has('department_id') ? 'true' : 'false' }}">
                            <option value="">Pilih departemen</option>
                            @foreach($departments as $department)<option value="{{ $department->id }}" @selected((string)old('department_id') === (string)$department->id)>{{ $department->name }}</option>@endforeach
                        </select>
                        @error('department_id')<span class="mt-1 block text-xs font-medium text-tvip-required">{{ $message }}</span>@enderror
                    </label>
                    <label class="block text-sm font-medium leading-5 text-tvip-label">Posisi <span class="text-tvip-required" aria-hidden="true">*</span>
                        <select x-ref="position" name="position_id" class="career-control mt-2" required aria-invalid="{{ $errors->has('position_id') ? 'true' : 'false' }}">
                            <option value="">Pilih posisi</option>
                            @foreach($positions as $position)<option value="{{ $position->id }}" :disabled="department && department !== '{{ $position->department_id }}'" @selected((string)old('position_id') === (string)$position->id)>{{ $position->name }}</option>@endforeach
                        </select>
                        @error('position_id')<span class="mt-1 block text-xs font-medium text-tvip-required">{{ $message }}</span>@enderror
                    </label>
                    <label class="block text-sm font-medium leading-5 text-tvip-label">Lokasi <span class="text-tvip-required" aria-hidden="true">*</span>
                        <select name="location_id" class="career-control mt-2" required aria-invalid="{{ $errors->has('location_id') ? 'true' : 'false' }}">
                            <option value="">Pilih lokasi</option>
                            @foreach($locations as $location)<option value="{{ $location->id }}" @selected((string)old('location_id') === (string)$location->id)>{{ $location->name }}</option>@endforeach
                        </select>
                        @error('location_id')<span class="mt-1 block text-xs font-medium text-tvip-required">{{ $message }}</span>@enderror
                    </label>
                </div>
            </section>
            </form>
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

            @if ($isApply)
                <section class="mt-6 rounded-tvip-button border border-tvip-success-border bg-tvip-success-bg p-4" aria-labelledby="application-ready-title">
                    <h3 id="application-ready-title" class="text-sm font-semibold text-tvip-success">Profil siap dikirim</h3>
                    <p class="mt-1 text-sm leading-5 text-tvip-body">Lamaran menggunakan profil terbaru {{ $candidateProfile->full_name }} dan CV {{ $candidateCv->original_name }}.</p>
                    <a href="{{ route('career.profile') }}" class="mt-2 inline-flex min-h-8 items-center text-xs font-semibold text-tvip-blue hover:underline">Tinjau profil</a>
                </section>
                <form id="job-application-form" method="POST" action="{{ route('career.applications.job', ['slug' => $job->slug]) }}" @submit="submittingApplication = true">@csrf</form>
            @endif
        @endif
    </div>

    <footer class="shrink-0 border-t border-tvip-divider bg-white px-5 py-4 sm:px-8">
        @if ($isDetail && $job)
            <a href="{{ route('career.apply', ['slug' => $job->slug, ...$queryParams]) }}" class="inline-flex h-11 w-full items-center justify-center rounded-tvip-button bg-tvip-blue px-6 text-sm font-medium text-white hover:bg-tvip-blue-dark">Lamar</a>
        @else
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ $listUrl }}" class="inline-flex h-11 items-center justify-center rounded-tvip-button border border-tvip-divider text-sm font-medium text-tvip-heading hover:bg-tvip-surface">Batal</a>
                <button type="submit" form="{{ $isSendCv ? 'talent-pool-form' : 'job-application-form' }}" :disabled="submittingApplication" :aria-busy="submittingApplication" class="h-11 rounded-tvip-button bg-tvip-blue px-4 text-sm font-medium text-white hover:bg-tvip-blue-dark disabled:opacity-60" x-text="submittingApplication ? 'Mengirim…' : '{{ $isSendCv ? 'Kirim CV' : 'Lamar Sekarang' }}'"></button>
            </div>
        @endif
    </footer>
</aside>
