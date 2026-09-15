<header class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
    <div>
        <div class="inline-flex items-center gap-2 rounded-full border border-tvip-success-border bg-tvip-success-bg px-3 py-1 text-xs font-semibold text-tvip-success"><span aria-hidden="true">✓</span> Profil Lengkap</div>
        <h1 class="mt-3 text-xl font-semibold text-tvip-heading">Formulir Kandidat</h1>
        <p class="mt-1 text-sm leading-6 text-tvip-muted">Data ini akan digunakan saat Anda mengirim lamaran.</p>
    </div>
</header>

<div class="mt-7 space-y-5">
    <section class="candidate-summary-section" aria-labelledby="summary-identity">
        <div class="candidate-summary-heading"><h2 id="summary-identity">Data Induk</h2><a href="{{ route('career.profile.step', ['step' => 1]) }}">Edit</a></div>
        <dl class="candidate-summary-grid">
            <div><dt>Nama Lengkap</dt><dd>{{ $profile->full_name }}</dd></div>
            <div><dt>Nomor KTP</dt><dd>{{ $profile->masked_national_id }}</dd></div>
            <div><dt>Tempat, Tanggal Lahir</dt><dd>{{ $profile->birth_place }}, {{ $profile->birth_date?->format('d/m/Y') }}</dd></div>
            <div><dt>Jenis Kelamin</dt><dd>{{ $profile->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</dd></div>
            <div><dt>Status Pernikahan</dt><dd>{{ str($profile->marital_status)->headline() }}</dd></div>
            <div><dt>Golongan Darah</dt><dd>{{ $profile->blood_type }}</dd></div>
            <div><dt>Agama</dt><dd>{{ str($profile->religion)->headline() }}</dd></div>
            <div><dt>Dokumen</dt><dd class="flex flex-wrap gap-x-4 gap-y-1">@if($photo)<a href="{{ route('career.documents.show', $photo) }}">Foto</a>@endif @if($cv)<a href="{{ route('career.documents.show', $cv) }}">CV</a>@endif</dd></div>
        </dl>
    </section>

    <section class="candidate-summary-section" aria-labelledby="summary-detail">
        <div class="candidate-summary-heading"><h2 id="summary-detail">Data Detail</h2><a href="{{ route('career.profile.step', ['step' => 2]) }}">Edit</a></div>
        <dl class="candidate-summary-grid">
            <div><dt>Tinggi / Berat</dt><dd>{{ $profile->height_cm }} cm / {{ $profile->weight_kg }} kg</dd></div>
            <div><dt>Kewarganegaraan</dt><dd>{{ $profile->nationality }}</dd></div>
            <div><dt>Kota Tempat Tinggal</dt><dd>{{ $profile->residence_city }}</dd></div>
            <div><dt>Nomor Telepon</dt><dd>{{ $profile->phone }}</dd></div>
            <div class="sm:col-span-2"><dt>Alamat KTP</dt><dd>{{ $profile->identity_address }}</dd></div>
            <div class="sm:col-span-2"><dt>Alamat Domisili</dt><dd>{{ $profile->domicile_address }}</dd></div>
        </dl>
    </section>

    <section class="candidate-summary-section" aria-labelledby="summary-education">
        <div class="candidate-summary-heading"><h2 id="summary-education">Pendidikan</h2><a href="{{ route('career.profile.step', ['step' => 3]) }}">Edit</a></div>
        <div class="space-y-4">
            @foreach ($profile->educations as $education)
                <div class="rounded-tvip-button bg-tvip-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-tvip-muted">{{ $education->level === 'high_school' ? 'SMA/SMK' : 'Perguruan Tinggi' }}</p>
                    <h3 class="mt-1 text-sm font-semibold text-tvip-heading">{{ $education->institution_name }}</h3>
                    <p class="mt-1 text-sm text-tvip-body">{{ $education->field_of_study }} · {{ $education->start_year }}–{{ $education->end_year ?: 'Sekarang' }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="candidate-summary-section" aria-labelledby="summary-work">
        <div class="candidate-summary-heading"><h2 id="summary-work">Pengalaman</h2><a href="{{ route('career.profile.step', ['step' => 4]) }}">Edit</a></div>
        @if ($profile->experience_status === 'fresh_graduate')
            <p class="text-sm text-tvip-body">Fresh Graduate</p>
        @else
            <div class="space-y-4">
                @foreach ($profile->workExperiences as $work)
                    <div class="rounded-tvip-button bg-tvip-surface p-4">
                        <h3 class="text-sm font-semibold text-tvip-heading">{{ $work->company_name }}</h3>
                        <p class="mt-1 text-sm text-tvip-body">{{ $work->initial_position }} → {{ $work->final_position }}</p>
                        <p class="mt-1 text-xs text-tvip-muted">{{ $work->initial_started_at->format('m/Y') }} – {{ $work->is_current ? 'Sekarang' : $work->final_ended_at?->format('m/Y') }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
</div>

<div class="mt-7 flex flex-col gap-3 border-t border-tvip-divider pt-6 sm:flex-row sm:justify-end">
    <a href="{{ route('career.profile.step', ['step' => 1]) }}" class="inline-flex min-h-11 items-center justify-center rounded-tvip-button border border-tvip-blue px-5 text-sm font-semibold text-tvip-blue hover:bg-tvip-info-bg">Edit Profil</a>
    <a href="{{ route('career.index') }}" class="inline-flex min-h-11 items-center justify-center rounded-tvip-button bg-tvip-blue px-6 text-sm font-semibold text-white hover:bg-tvip-blue-dark">Lihat Lowongan</a>
</div>
