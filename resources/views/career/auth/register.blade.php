<x-layouts.auth
    title="Daftar — TVIP Karir"
    description="Buat akun kandidat TVIP untuk menjelajahi peluang karir."
>
    <section class="rounded-tvip-card-lg bg-white px-7 py-8 shadow-tvip-auth sm:px-10" aria-labelledby="register-title">
        <img src="{{ asset('images/tvip/logo-tvip-horizontal.png') }}" alt="TVIP" width="112" height="29" class="mx-auto h-[29px] w-28 object-contain">

        <div class="mt-4 text-center">
            <h1 id="register-title" class="text-2xl font-bold leading-8 text-tvip-heading">Daftar Akun TVIP</h1>
            <p class="mt-2 text-sm leading-5 text-tvip-muted">Buat akun untuk menjelajahi peluang kerja</p>
        </div>

        <form
            action="{{ route('career.register.store') }}"
            method="POST"
            class="mt-6 space-y-3.5"
            novalidate
            x-data="{ submitting: false }"
            @submit="submitting = true"
            x-init='$nextTick(() => $el.querySelector("[aria-invalid=true]")?.focus())'
        >
            @csrf
            <x-auth-field
                name="name"
                label="Nama Lengkap (Opsional)"
                autocomplete="name"
                placeholder="John Doe"
                icon="icon-profile.svg"
                autofocus
            />
            <x-auth-field
                name="email"
                label="Email"
                type="email"
                autocomplete="email"
                placeholder="nama@email.com"
                icon="icon-email.svg"
                required
            />
            <x-auth-field
                name="password"
                label="Password"
                type="password"
                autocomplete="new-password"
                placeholder="Minimal 6 karakter"
                icon="icon-password.svg"
                required
            />
            <x-auth-field
                name="password_confirmation"
                label="Konfirmasi Password"
                type="password"
                autocomplete="new-password"
                placeholder="Ulangi password"
                icon="icon-password.svg"
                required
            />

            <button type="submit" class="mt-1 inline-flex h-[46px] w-full items-center justify-center rounded-tvip-button bg-tvip-blue px-6 text-sm font-medium text-white transition hover:bg-tvip-blue-dark active:translate-y-px disabled:opacity-60" :disabled="submitting" :aria-busy="submitting">
                <span x-text="submitting ? 'Memproses...' : 'Daftar'">Daftar</span>
            </button>
        </form>

        <div class="my-4 flex items-center gap-3 text-xs text-tvip-muted" aria-hidden="true">
            <span class="h-px flex-1 bg-tvip-divider"></span>
            <span>Sudah punya akun?</span>
            <span class="h-px flex-1 bg-tvip-divider"></span>
        </div>

        <a href="{{ route('login') }}" class="flex min-h-11 items-center justify-center rounded-tvip-button text-sm font-semibold text-tvip-heading hover:bg-tvip-surface">
            Masuk
        </a>
    </section>
</x-layouts.auth>
