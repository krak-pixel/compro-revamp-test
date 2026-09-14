@php
    $highSchool = $profile?->educations?->firstWhere('level', 'high_school');
    $colleges = old('college_educations', $profile?->educations?->where('level', 'college')->values()->map(fn ($education) => [
        'id' => $education->id,
        'institution_name' => $education->institution_name,
        'degree' => Illuminate\Support\Str::contains($education->field_of_study, ' — ') ? Illuminate\Support\Str::before($education->field_of_study, ' — ') : 'S1',
        'field_of_study' => Illuminate\Support\Str::contains($education->field_of_study, ' — ') ? Illuminate\Support\Str::after($education->field_of_study, ' — ') : $education->field_of_study,
        'start_year' => $education->start_year,
        'end_year' => $education->end_year,
        'final_score' => $education->final_score,
    ])->all() ?? []);
    $works = old('work_experiences', $profile?->workExperiences?->map(fn ($work) => [
        'id' => $work->id,
        'company_name' => $work->company_name,
        'initial_position' => $work->initial_position,
        'initial_started_at' => optional($work->initial_started_at)->format('Y-m'),
        'initial_ended_at' => optional($work->initial_ended_at)->format('Y-m'),
        'initial_responsibilities' => $work->initial_responsibilities,
        'final_position' => $work->final_position,
        'final_started_at' => optional($work->final_started_at)->format('Y-m'),
        'final_ended_at' => optional($work->final_ended_at)->format('Y-m'),
        'final_responsibilities' => $work->final_responsibilities,
        'is_current' => $work->is_current,
        'resign_year' => $work->resign_year,
        'last_salary' => $work->last_salary,
        'resign_reason' => $work->resign_reason,
        'expected_salary' => $work->expected_salary,
        'company_phone' => $work->company_phone,
        'supervisor_name' => $work->supervisor_name,
        'supervisor_phone' => $work->supervisor_phone,
    ])->values()->all() ?? []);
    $steps = [1 => 'Data Induk', 2 => 'Data Detail', 3 => 'Pendidikan', 4 => 'Pengalaman'];
@endphp

<x-layouts.candidate title="Profil Kandidat — TVIP Karir">
    <div x-data="candidateProfile()" @input="dirty = true" @change="dirty = true" @candidate-saving.window="dirty = false" @beforeunload.window="warnIfDirty($event)" class="mx-auto w-full max-w-[1024px] px-4 py-8 sm:px-8 sm:py-10">
        <nav class="border-b border-tvip-divider" aria-label="Area kandidat">
            <div class="flex gap-7">
                <a href="{{ route('career.profile') }}" @class(['candidate-tab', 'candidate-tab-active' => $activeTab === 'profile']) @if($activeTab === 'profile') aria-current="page" @endif>Profil Saya</a>
                <a href="{{ route('career.profile', ['tab' => 'history']) }}" @class(['candidate-tab', 'candidate-tab-active' => $activeTab === 'history']) @if($activeTab === 'history') aria-current="page" @endif>Riwayat Lamaran</a>
            </div>
        </nav>

        @if ($activeTab === 'history')
            <section class="mt-8 rounded-tvip-candidate border border-tvip-divider bg-white p-5 shadow-tvip-job sm:p-8" aria-labelledby="history-title">
                <div>
                    <h1 id="history-title" class="text-xl font-semibold text-tvip-heading">Riwayat Lamaran</h1>
                    <p class="mt-1 text-sm leading-6 text-tvip-muted">Pantau semua lamaran dan CV yang pernah Anda kirim.</p>
                </div>

                @if (! $profile?->profile_completed_at)
                    <div class="mt-6 rounded-tvip-button border border-tvip-badge-blue bg-tvip-info-bg px-4 py-4 text-sm leading-6 text-tvip-blue">
                        Riwayat akan tersedia setelah profil lengkap. <a href="{{ route('career.profile') }}" class="font-semibold underline">Lanjutkan profil</a>.
                    </div>
                @elseif ($applications->isEmpty())
                    <div class="py-16 text-center">
                        <span class="mx-auto inline-flex size-14 items-center justify-center rounded-full bg-tvip-info-bg text-2xl" aria-hidden="true">↗</span>
                        <h2 class="mt-5 text-lg font-semibold text-tvip-heading">Belum ada lamaran</h2>
                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-tvip-muted">Temukan posisi yang sesuai atau kirim CV ke talent pool TVIP.</p>
                        <a href="{{ route('career.index') }}" class="mt-6 inline-flex min-h-11 items-center rounded-tvip-button bg-tvip-blue px-6 text-sm font-semibold text-white hover:bg-tvip-blue-dark">Lihat Lowongan</a>
                    </div>
                @else
                    <div class="mt-6 space-y-4">
                        @foreach ($applications as $application)
                            <article class="rounded-tvip-button border border-tvip-divider p-5">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-wide text-tvip-muted">{{ $application->type === 'job_application' ? 'Lamaran Posisi' : 'Talent Pool' }}</p>
                                        <h2 class="mt-1 text-base font-semibold text-tvip-heading">{{ $application->job_snapshot['title'] ?? $application->position?->name ?? 'Posisi Pilihan' }}</h2>
                                        <p class="mt-1 text-sm text-tvip-muted">{{ collect([$application->department?->name ?? data_get($application->job_snapshot, 'department'), $application->location?->name ?? data_get($application->job_snapshot, 'location')])->filter()->join(' · ') }}</p>
                                    </div>
                                    <span class="inline-flex w-fit rounded-full border border-tvip-warning-border bg-tvip-warning-bg px-3 py-1 text-xs font-semibold text-tvip-warning">{{ $application->status_label }}</span>
                                </div>
                                <p class="mt-4 border-t border-tvip-divider pt-3 text-xs text-tvip-muted">Dikirim {{ $application->submitted_at->format('d/m/Y, H.i') }}</p>
                            </article>
                        @endforeach
                    </div>
                    <x-career.pagination :paginator="$applications" label="Navigasi halaman riwayat lamaran" />
                @endif
            </section>
        @else
            @unless ($isSummary)
                <nav aria-label="Progres profil kandidat">
                <ol class="candidate-stepper">
                    @foreach ($steps as $number => $label)
                        @php
                            $isCurrent = $activeStep === $number;
                            $isComplete = $profile?->profile_completed_at || ($profile && $profile->current_step > $number);
                        @endphp
                        <li class="candidate-step-item">
                            <a href="{{ route('career.profile.step', ['step' => $number]) }}" class="candidate-step group" @if($isCurrent) aria-current="step" @endif>
                                <span @class(['candidate-step-circle', 'candidate-step-current' => $isCurrent, 'candidate-step-complete' => $isComplete && !$isCurrent])>{{ $isComplete && !$isCurrent ? '✓' : $number }}</span>
                                <span @class(['candidate-step-label', 'text-tvip-blue' => $isCurrent, 'text-tvip-heading' => $isComplete && !$isCurrent])>{{ $label }}</span>
                            </a>
                            @if ($number < 4)<span @class(['candidate-step-line', 'bg-tvip-success-bright' => $isComplete, 'bg-tvip-divider' => !$isComplete]) aria-hidden="true"></span>@endif
                        </li>
                    @endforeach
                </ol>
                </nav>
                @if ($profile?->profile_completed_at)
                    <div class="mb-5 flex items-center justify-between rounded-tvip-button border border-tvip-info-border bg-tvip-info-bg px-4 py-3">
                        <p class="text-sm font-medium text-tvip-blue">Mode edit profil</p>
                        <a href="{{ route('career.profile') }}" @click="dirty = false" class="inline-flex min-h-9 items-center px-2 text-sm font-semibold text-tvip-blue hover:underline">Batal Edit</a>
                    </div>
                @endif
            @endunless

            <section class="mt-8 rounded-tvip-candidate border border-tvip-divider bg-white p-5 shadow-tvip-job sm:p-8">
                @if ($errors->has('profile'))
                    <div class="mb-6 rounded-tvip-button border border-tvip-required/30 bg-tvip-badge-red-bg px-4 py-3 text-sm text-tvip-badge-red" role="alert">{{ $errors->first('profile') }}</div>
                @endif

                @if ($isSummary)
                    @include('career.profile.summary')
                @elseif ($activeStep === 1)
                    @include('career.profile.steps.identity')
                @elseif ($activeStep === 2)
                    @include('career.profile.steps.details')
                @elseif ($activeStep === 3)
                    @include('career.profile.steps.education')
                @else
                    @include('career.profile.steps.experience')
                @endif
            </section>
        @endif
    </div>
</x-layouts.candidate>
