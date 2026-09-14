<header>
    <p class="text-sm font-semibold text-tvip-blue">Langkah 3 dari 4</p>
    <h1 class="mt-1 text-xl font-semibold text-tvip-heading">Data Pendidikan</h1>
    <p class="mt-1 text-sm leading-6 text-tvip-muted">Riwayat SMA/SMK wajib diisi. Pendidikan tinggi dapat ditambahkan hingga empat data.</p>
</header>

<form method="POST" action="{{ route('career.profile.store', ['step' => 3]) }}" enctype="multipart/form-data" class="mt-7" novalidate @submit="submitting = true; $dispatch('candidate-saving')" x-data="educationStep({{ Illuminate\Support\Js::from($colleges) }})">
    @csrf
    @method('PUT')
    <p class="sr-only" aria-live="polite" x-text="liveMessage"></p>

    @if ($errors->any())
        <div class="mb-6 rounded-tvip-button border border-tvip-required/30 bg-tvip-badge-red-bg px-4 py-3 text-sm text-tvip-badge-red" role="alert">Periksa kembali data pendidikan yang ditandai.</div>
    @endif

    <section aria-labelledby="high-school-title">
        <h2 id="high-school-title" class="text-base font-semibold text-tvip-heading">Pendidikan SMA/SMK</h2>
        <div class="mt-5 grid gap-5 sm:grid-cols-2">
            <x-career.profile-field name="high_school[institution_name]" label="Nama Sekolah" :value="$highSchool?->institution_name" required />
            <x-career.profile-field name="high_school[field_of_study]" label="Jurusan" :value="$highSchool?->field_of_study" required />
            <x-career.profile-field name="high_school[start_year]" label="Tahun Masuk" type="number" :value="$highSchool?->start_year" min="1950" :max="now()->year" required />
            <x-career.profile-field name="high_school[end_year]" label="Tahun Lulus" type="number" :value="$highSchool?->end_year" min="1950" :max="now()->year" required />
            <x-career.profile-field name="high_school[final_score]" label="Nilai Akhir" type="number" :value="$highSchool?->final_score" min="0" max="100" step="0.01" required />
            <x-career.upload-field name="high_school[diploma]" label="Ijazah" accept=".pdf,application/pdf" help="PDF, maksimal 5 MB." :document="$highSchool?->document" required />
        </div>
    </section>

    <div class="my-8 border-t border-tvip-divider"></div>

    <section aria-labelledby="college-title">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 id="college-title" class="text-base font-semibold text-tvip-heading">Pendidikan Tinggi <span class="font-normal text-tvip-muted">(Opsional)</span></h2>
                <p class="mt-1 text-xs leading-5 text-tvip-muted">Tambahkan diploma atau perguruan tinggi jika ada.</p>
            </div>
            <button type="button" @click="addCollege()" :disabled="colleges.length >= 4" class="inline-flex min-h-10 items-center justify-center rounded-tvip-button border border-tvip-blue px-4 text-sm font-semibold text-tvip-blue hover:bg-tvip-info-bg disabled:opacity-50">+ Tambah Pendidikan</button>
        </div>

        <p x-show="colleges.length === 0" class="mt-5 rounded-tvip-button border border-dashed border-tvip-outline px-4 py-7 text-center text-sm text-tvip-muted">Belum ada pendidikan tinggi.</p>

        <div class="mt-5 space-y-5">
            <template x-for="(college, index) in colleges" :key="college.key">
                <fieldset class="rounded-tvip-button border border-tvip-divider p-4 sm:p-5">
                    <legend class="sr-only" x-text="`Pendidikan tinggi ${index + 1}`"></legend>
                    <div class="mb-5 flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-tvip-heading" x-text="`Pendidikan ${index + 1}`"></h3>
                        <button type="button" @click="removeCollege(index)" class="inline-flex min-h-9 items-center px-2 text-sm font-semibold text-tvip-badge-red hover:underline">Hapus</button>
                    </div>
                    <input type="hidden" :name="`college_educations[${index}][id]`" x-model="college.id">
                    <div class="grid gap-5 sm:grid-cols-2">
                        <label class="block text-sm font-medium text-tvip-label">Jenjang <span class="text-tvip-required">*</span>
                            <select :name="`college_educations[${index}][degree]`" x-model="college.degree" class="career-control mt-2" required>
                                <option value="">Pilih jenjang</option>
                                <template x-for="degree in ['D1','D2','D3','D4','S1','S2','S3']"><option :value="degree" x-text="degree"></option></template>
                            </select>
                        </label>
                        <label class="block text-sm font-medium text-tvip-label">Nama Institusi <span class="text-tvip-required">*</span>
                            <input :name="`college_educations[${index}][institution_name]`" x-model="college.institution_name" class="career-control mt-2" required>
                        </label>
                        <label class="block text-sm font-medium text-tvip-label">Jurusan <span class="text-tvip-required">*</span>
                            <input :name="`college_educations[${index}][field_of_study]`" x-model="college.field_of_study" class="career-control mt-2" required>
                        </label>
                        <label class="block text-sm font-medium text-tvip-label">IPK
                            <input :name="`college_educations[${index}][final_score]`" x-model="college.final_score" type="number" min="0" max="4" step="0.01" class="career-control mt-2">
                        </label>
                        <label class="block text-sm font-medium text-tvip-label">Tahun Masuk <span class="text-tvip-required">*</span>
                            <input :name="`college_educations[${index}][start_year]`" x-model="college.start_year" type="number" min="1950" max="{{ now()->year }}" class="career-control mt-2" required>
                        </label>
                        <label class="block text-sm font-medium text-tvip-label">Tahun Lulus
                            <input :name="`college_educations[${index}][end_year]`" x-model="college.end_year" type="number" min="1950" max="{{ now()->year }}" class="career-control mt-2">
                        </label>
                        <label class="block text-sm font-medium text-tvip-label sm:col-span-2">Ijazah <span class="font-normal text-tvip-muted">(Opsional)</span>
                            <input :name="`college_educations[${index}][diploma]`" type="file" accept=".pdf,application/pdf" class="mt-2 block w-full rounded-tvip-button border border-dashed border-tvip-outline px-4 py-2 text-sm file:mr-4 file:rounded-md file:border-0 file:bg-tvip-info-bg file:px-3 file:py-1.5 file:font-semibold file:text-tvip-blue">
                            <span class="mt-1.5 block text-xs text-tvip-muted">PDF, maksimal 5 MB.</span>
                        </label>
                    </div>
                </fieldset>
            </template>
        </div>
    </section>

    @include('career.profile.steps.actions', ['step' => 3])
</form>
