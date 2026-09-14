<header>
    <p class="text-sm font-semibold text-tvip-blue">Langkah 1 dari 4</p>
    <h1 class="mt-1 text-xl font-semibold text-tvip-heading">Data Induk</h1>
    <p class="mt-1 text-sm leading-6 text-tvip-muted">Lengkapi identitas utama dan dokumen kandidat.</p>
</header>

<form method="POST" action="{{ route('career.profile.store', ['step' => 1]) }}" enctype="multipart/form-data" class="mt-7" novalidate @submit="submitting = true; $dispatch('candidate-saving')">
    @csrf
    @method('PUT')
    <div class="rounded-tvip-button border border-tvip-info-border bg-tvip-info-bg px-4 py-3 text-xs leading-5 text-tvip-blue" role="note">
        Data identitas bersifat pribadi. Dokumen hanya dapat diakses oleh akun Anda dan proses rekrutmen yang berwenang.
    </div>
    <div class="mt-6 grid gap-5 sm:grid-cols-2">
        <x-career.upload-field name="photo" label="Foto Profil" accept=".jpg,.jpeg,.png,image/jpeg,image/png" help="JPG atau PNG, maksimal 5 MB." :document="$photo" required />
        <x-career.upload-field name="cv" label="Curriculum Vitae" accept=".pdf,application/pdf" help="PDF, maksimal 5 MB." :document="$cv" required />
    </div>
    <div class="my-7 border-t border-tvip-divider"></div>
    <div class="grid gap-5 sm:grid-cols-2">
        <x-career.profile-field name="full_name" label="Nama Lengkap" :value="$profile?->full_name ?? auth()->user()->display_name" required />
        <x-career.profile-field name="national_id" label="Nomor KTP" :value="$profile?->national_id" placeholder="16 digit" inputmode="numeric" maxlength="16" required help="Disimpan terenkripsi dan tidak ditampilkan utuh." />
        <x-career.profile-field name="birth_place" label="Tempat Lahir" :value="$profile?->birth_place" required />
        <x-career.profile-field name="birth_date" label="Tanggal Lahir" type="date" :value="optional($profile?->birth_date)->format('Y-m-d')" required />
        <x-career.profile-field name="gender" label="Jenis Kelamin" type="select" :value="$profile?->gender" :options="['male' => 'Laki-laki', 'female' => 'Perempuan']" required />
        <x-career.profile-field name="marital_status" label="Status Pernikahan" type="select" :value="$profile?->marital_status" :options="['single' => 'Belum Menikah', 'married' => 'Menikah', 'divorced' => 'Cerai', 'widowed' => 'Duda/Janda']" required />
        <x-career.profile-field name="blood_type" label="Golongan Darah" type="select" :value="$profile?->blood_type" :options="['A'=>'A','B'=>'B','AB'=>'AB','O'=>'O']" required />
        <x-career.profile-field name="religion" label="Agama" type="select" :value="$profile?->religion" :options="['islam'=>'Islam','kristen'=>'Kristen','katolik'=>'Katolik','hindu'=>'Hindu','buddha'=>'Buddha','konghucu'=>'Konghucu','lainnya'=>'Lainnya']" required />
    </div>
    @include('career.profile.steps.actions', ['step' => 1])
</form>
