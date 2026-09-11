<x-layouts.auth
    title="Masuk — TVIP Karir"
    description="Masuk ke portal kandidat TVIP untuk menjelajahi peluang karir."
>
    <section class="rounded-tvip-card-lg bg-white px-7 py-10 shadow-tvip-auth sm:px-10" aria-labelledby="login-title">
        <img src="{{ asset('images/tvip/logo-tvip-horizontal.png') }}" alt="TVIP" width="112" height="29" class="mx-auto h-[29px] w-28 object-contain">

        <div class="mt-5 text-center">
            <h1 id="login-title" class="text-2xl font-bold leading-8 text-tvip-heading">Masuk ke TVIP Karir</h1>
            <p class="mt-2 text-sm leading-5 text-tvip-muted">Login untuk melihat akun kandidat Anda</p>
        </div>

        @if (session('status'))
            <div class="mt-6 rounded-tvip-button border border-tvip-badge-green bg-tvip-badge-green-bg px-4 py-3 text-sm leading-5 text-tvip-badge-green" role="status">
                {{ session('status') }}
            </div>
        @endif

        <form
            action="{{ route('career.login.store') }}"
            method="POST"
            class="mt-7 space-y-4"
            novalidate
            x-data="{ submitting: false }"
            @submit="submitting = true"
            x-init='$nextTick(() => $el.querySelector("[aria-invalid=true]")?.focus())'
        >
            @csrf
            <x-auth-field
                name="email"
                label="Email"
                type="email"
                autocomplete="email"
                placeholder="nama@email.com"
                icon="icon-email.svg"
                required
                autofocus
            />
            <x-auth-field
                name="password"
                label="Password"
                type="password"
                autocomplete="current-password"
                placeholder="Masukkan password"
                icon="icon-password.svg"
                required
            />

            <button type="submit" class="mt-1 inline-flex h-[46px] w-full items-center justify-center rounded-tvip-button bg-tvip-blue px-6 text-sm font-medium text-white transition hover:bg-tvip-blue-dark active:translate-y-px disabled:opacity-60" :disabled="submitting" :aria-busy="submitting">
                <span x-text="submitting ? 'Memproses...' : 'Masuk'">Masuk</span>
            </button>
        </form>

        <div class="my-5 flex items-center gap-3 text-xs text-tvip-muted" aria-hidden="true">
            <span class="h-px flex-1 bg-tvip-divider"></span>
            <span>Belum punya akun?</span>
            <span class="h-px flex-1 bg-tvip-divider"></span>
        </div>

        <a href="{{ route('register') }}" class="flex min-h-11 items-center justify-center rounded-tvip-button text-sm font-semibold text-tvip-heading hover:bg-tvip-surface">
            Daftar Sekarang
        </a>
    </section>
</x-layouts.auth>
