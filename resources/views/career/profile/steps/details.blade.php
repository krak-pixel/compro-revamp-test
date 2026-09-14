<header>
    <p class="text-sm font-semibold text-tvip-blue">Langkah 2 dari 4</p>
    <h1 class="mt-1 text-xl font-semibold text-tvip-heading">Data Detail</h1>
    <p class="mt-1 text-sm leading-6 text-tvip-muted">Tambahkan informasi fisik dan alamat yang dapat dihubungi.</p>
</header>
<form method="POST" action="{{ route('career.profile.store', ['step' => 2]) }}" class="mt-7" novalidate @submit="submitting = true; $dispatch('candidate-saving')">
    @csrf
    @method('PUT')
    <div class="grid gap-5 sm:grid-cols-2">
        <x-career.profile-field name="height_cm" label="Tinggi Badan (cm)" type="number" :value="$profile?->height_cm" min="100" max="250" required />
        <x-career.profile-field name="weight_kg" label="Berat Badan (kg)" type="number" :value="$profile?->weight_kg" min="30" max="300" required />
        <x-career.profile-field name="nationality" label="Kewarganegaraan" :value="$profile?->nationality ?? 'Indonesia'" required />
        <x-career.profile-field name="residence_city" label="Kota Tempat Tinggal" :value="$profile?->residence_city" required />
        <x-career.profile-field name="phone" label="Nomor Telepon" type="tel" :value="$profile?->phone" placeholder="08xxxxxxxxxx" required />
        <x-career.profile-field name="account_email" label="Email Akun" type="email" :value="auth()->user()->email" disabled help="Email mengikuti akun kandidat." />
        <x-career.profile-field name="identity_address" label="Alamat Sesuai KTP" type="textarea" :value="$profile?->identity_address" required class="sm:col-span-2" />
        <x-career.profile-field name="domicile_address" label="Alamat Domisili" type="textarea" :value="$profile?->domicile_address" required class="sm:col-span-2" />
    </div>
    @include('career.profile.steps.actions', ['step' => 2])
</form>
