<x-layouts.app
    title="Akses Ditolak — TVIP"
    description="Anda tidak memiliki akses ke halaman ini."
    :canonical="route('home')"
>
    <section class="tvip-container flex min-h-[70vh] items-center justify-center pb-20 pt-32 text-center">
        <div class="max-w-xl">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-tvip-blue">403</p>
            <h1 class="mt-3 text-3xl font-bold text-tvip-heading sm:text-4xl">Akses tidak tersedia</h1>
            <p class="mt-4 text-base leading-7 text-tvip-body">Akun Anda tidak memiliki izin untuk membuka halaman ini.</p>
            <a href="{{ route('career.index') }}" class="mt-8 inline-flex min-h-11 items-center justify-center rounded-tvip-button bg-tvip-blue px-6 text-sm font-semibold text-white hover:bg-tvip-blue-dark">Kembali ke Karir</a>
        </div>
    </section>
</x-layouts.app>
