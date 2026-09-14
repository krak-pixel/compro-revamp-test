<header>
    <p class="text-sm font-semibold text-tvip-blue">Langkah 4 dari 4</p>
    <h1 class="mt-1 text-xl font-semibold text-tvip-heading">Data Pengalaman</h1>
    <p class="mt-1 text-sm leading-6 text-tvip-muted">Pilih status pengalaman dan lengkapi riwayat kerja bila ada.</p>
</header>

<form method="POST" action="{{ route('career.profile.store', ['step' => 4]) }}" enctype="multipart/form-data" class="mt-7" novalidate @submit="submitting = true; $dispatch('candidate-saving')" x-data="experienceStep({{ Illuminate\Support\Js::from(old('experience_status', $profile?->experience_status ?? 'fresh_graduate')) }}, {{ Illuminate\Support\Js::from($works) }})">
    @csrf
    @method('PUT')
    <p class="sr-only" aria-live="polite" x-text="liveMessage"></p>

    @if ($errors->any())
        <div class="mb-6 rounded-tvip-button border border-tvip-required/30 bg-tvip-badge-red-bg px-4 py-3 text-sm text-tvip-badge-red" role="alert">Periksa kembali data pengalaman yang ditandai.</div>
    @endif

    <fieldset>
        <legend class="text-sm font-medium text-tvip-label">Status Pengalaman <span class="text-tvip-required">*</span></legend>
        <div class="mt-3 grid gap-4 sm:grid-cols-2">
            <label class="candidate-choice" :class="status === 'fresh_graduate' ? 'candidate-choice-active' : ''">
                <input type="radio" name="experience_status" value="fresh_graduate" x-model="status" class="text-tvip-blue focus:ring-tvip-blue">
                <span><strong class="block text-sm text-tvip-heading">Fresh Graduate</strong><span class="mt-1 block text-xs leading-5 text-tvip-muted">Belum memiliki pengalaman kerja formal.</span></span>
            </label>
            <label class="candidate-choice" :class="status === 'experienced' ? 'candidate-choice-active' : ''">
                <input type="radio" name="experience_status" value="experienced" x-model="status" @change="ensureWork()" class="text-tvip-blue focus:ring-tvip-blue">
                <span><strong class="block text-sm text-tvip-heading">Memiliki Pengalaman</strong><span class="mt-1 block text-xs leading-5 text-tvip-muted">Tambahkan maksimal tiga perusahaan.</span></span>
            </label>
        </div>
        @error('experience_status')<p class="mt-2 text-xs font-medium text-tvip-required">{{ $message }}</p>@enderror
    </fieldset>

    <div x-show="status === 'fresh_graduate'" class="mt-6 rounded-tvip-button border border-tvip-success-border bg-tvip-success-bg px-4 py-4 text-sm leading-6 text-tvip-success">
        Anda dapat menyelesaikan profil tanpa menambahkan riwayat perusahaan.
    </div>

    <section x-show="status === 'experienced'" class="mt-7" aria-labelledby="work-title">
        <div class="flex items-center justify-between gap-4">
            <h2 id="work-title" class="text-base font-semibold text-tvip-heading">Riwayat Perusahaan</h2>
            <button type="button" @click="addWork()" :disabled="works.length >= 3" class="inline-flex min-h-10 items-center rounded-tvip-button border border-tvip-blue px-4 text-sm font-semibold text-tvip-blue hover:bg-tvip-info-bg disabled:opacity-50">+ Tambah Perusahaan</button>
        </div>

        <div class="mt-5 space-y-5">
            <template x-for="(work, index) in works" :key="work.key">
                <fieldset class="rounded-tvip-button border border-tvip-divider p-4 sm:p-5">
                    <legend class="sr-only" x-text="`Pengalaman kerja ${index + 1}`"></legend>
                    <div class="mb-5 flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-tvip-heading" x-text="`Perusahaan ${index + 1}`"></h3>
                        <button x-show="works.length > 1" type="button" @click="removeWork(index)" class="inline-flex min-h-9 items-center px-2 text-sm font-semibold text-tvip-badge-red hover:underline">Hapus</button>
                    </div>
                    <input type="hidden" :name="`work_experiences[${index}][id]`" x-model="work.id">
                    <div class="grid gap-5 sm:grid-cols-2">
                        <label class="block text-sm font-medium text-tvip-label sm:col-span-2">Nama Perusahaan <span class="text-tvip-required">*</span><input :name="`work_experiences[${index}][company_name]`" x-model="work.company_name" class="career-control mt-2" required></label>
                        <div class="border-l-4 border-tvip-blue pl-4 sm:col-span-2">
                            <h4 class="text-sm font-semibold text-tvip-blue">Jabatan Awal</h4>
                            <div class="mt-4 grid gap-5 sm:grid-cols-2">
                                <label class="block text-sm font-medium text-tvip-label sm:col-span-2">Nama Jabatan <span class="text-tvip-required">*</span><input :name="`work_experiences[${index}][initial_position]`" x-model="work.initial_position" class="career-control mt-2" required></label>
                                <label class="block text-sm font-medium text-tvip-label">Mulai <span class="text-tvip-required">*</span><input :name="`work_experiences[${index}][initial_started_at]`" x-model="work.initial_started_at" type="month" class="career-control mt-2" required></label>
                                <label class="block text-sm font-medium text-tvip-label">Selesai <span class="text-tvip-required">*</span><input :name="`work_experiences[${index}][initial_ended_at]`" x-model="work.initial_ended_at" type="month" class="career-control mt-2" required></label>
                                <label class="block text-sm font-medium text-tvip-label sm:col-span-2">Tugas dan Tanggung Jawab <span class="text-tvip-required">*</span><textarea :name="`work_experiences[${index}][initial_responsibilities]`" x-model="work.initial_responsibilities" rows="4" class="career-control mt-2 h-auto min-h-28 resize-none py-3" required></textarea></label>
                            </div>
                        </div>
                        <div class="border-l-4 border-tvip-success-bright pl-4 sm:col-span-2">
                            <h4 class="text-sm font-semibold text-tvip-success">Jabatan Akhir</h4>
                            <div class="mt-4 grid gap-5 sm:grid-cols-2">
                                <label class="block text-sm font-medium text-tvip-label sm:col-span-2">Nama Jabatan <span class="text-tvip-required">*</span><input :name="`work_experiences[${index}][final_position]`" x-model="work.final_position" class="career-control mt-2" required></label>
                                <label class="block text-sm font-medium text-tvip-label">Mulai <span class="text-tvip-required">*</span><input :name="`work_experiences[${index}][final_started_at]`" x-model="work.final_started_at" type="month" class="career-control mt-2" required></label>
                                <label class="block text-sm font-medium text-tvip-label">Selesai<input :name="`work_experiences[${index}][final_ended_at]`" x-model="work.final_ended_at" type="month" :disabled="work.is_current" class="career-control mt-2 disabled:bg-tvip-social-bg"></label>
                                <label class="flex min-h-10 items-center gap-2 text-sm text-tvip-body sm:col-span-2"><input :name="`work_experiences[${index}][is_current]`" type="checkbox" value="1" x-model="work.is_current" class="rounded border-tvip-outline text-tvip-blue focus:ring-tvip-blue">Saya masih bekerja di sini</label>
                                <label class="block text-sm font-medium text-tvip-label sm:col-span-2">Tugas dan Tanggung Jawab <span class="text-tvip-required">*</span><textarea :name="`work_experiences[${index}][final_responsibilities]`" x-model="work.final_responsibilities" rows="4" class="career-control mt-2 h-auto min-h-28 resize-none py-3" required></textarea></label>
                            </div>
                        </div>
                        <label class="block text-sm font-medium text-tvip-label" x-show="!work.is_current">Tahun Mengundurkan Diri<input :name="`work_experiences[${index}][resign_year]`" x-model="work.resign_year" type="number" min="1950" max="{{ now()->year }}" class="career-control mt-2"></label>
                        <label class="block text-sm font-medium text-tvip-label">Gaji Terakhir (Rp)<input :name="`work_experiences[${index}][last_salary]`" x-model="work.last_salary" type="number" min="0" class="career-control mt-2"></label>
                        <label class="block text-sm font-medium text-tvip-label sm:col-span-2" x-show="!work.is_current">Alasan Mengundurkan Diri<textarea :name="`work_experiences[${index}][resign_reason]`" x-model="work.resign_reason" rows="3" class="career-control mt-2 h-auto py-3"></textarea></label>
                        <label class="block text-sm font-medium text-tvip-label">Ekspektasi Gaji (Rp)<input :name="`work_experiences[${index}][expected_salary]`" x-model="work.expected_salary" type="number" min="0" class="career-control mt-2"></label>
                        <label class="block text-sm font-medium text-tvip-label">Telepon Perusahaan<input :name="`work_experiences[${index}][company_phone]`" x-model="work.company_phone" class="career-control mt-2"></label>
                        <label class="block text-sm font-medium text-tvip-label">Nama Atasan<input :name="`work_experiences[${index}][supervisor_name]`" x-model="work.supervisor_name" class="career-control mt-2"></label>
                        <label class="block text-sm font-medium text-tvip-label">Telepon Atasan<input :name="`work_experiences[${index}][supervisor_phone]`" x-model="work.supervisor_phone" class="career-control mt-2"></label>
                        <label class="block text-sm font-medium text-tvip-label sm:col-span-2">Paklaring <span class="font-normal text-tvip-muted">(Opsional)</span><input :name="`work_experiences[${index}][employment_letter]`" type="file" accept=".pdf,application/pdf" class="mt-2 block w-full rounded-tvip-button border border-dashed border-tvip-outline px-4 py-2 text-sm file:mr-4 file:rounded-md file:border-0 file:bg-tvip-info-bg file:px-3 file:py-1.5 file:font-semibold file:text-tvip-blue"><span class="mt-1.5 block text-xs text-tvip-muted">PDF, maksimal 5 MB.</span></label>
                    </div>
                </fieldset>
            </template>
        </div>
    </section>

    @include('career.profile.steps.actions', ['step' => 4])
</form>
