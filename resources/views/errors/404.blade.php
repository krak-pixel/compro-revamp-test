<x-layouts.app
    title="Halaman Tidak Ditemukan — TVIP"
    description="Halaman yang Anda cari tidak tersedia."
    :canonical="route('home')"
>
    <section class="tvip-container flex min-h-[70vh] items-center justify-center pb-20 pt-32 text-center">
        <div class="max-w-xl">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-tvip-blue">404</p>
            <h1 class="mt-3 text-3xl font-bold text-tvip-heading sm:text-4xl">Halaman tidak ditemukan</h1>
            <p class="mt-4 text-base leading-7 text-tvip-body">Tautan mungkin sudah berubah atau lowongan sudah tidak aktif. Anda tetap dapat melihat peluang terbaru di halaman Karir.</p>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('career.index') }}" class="inline-flex min-h-11 items-center justify-center rounded-tvip-button bg-tvip-blue px-6 text-sm font-semibold text-white hover:bg-tvip-blue-dark">Lihat Karir</a>
                <a href="{{ route('home') }}" class="inline-flex min-h-11 items-center justify-center rounded-tvip-button border border-tvip-outline px-6 text-sm font-semibold text-tvip-heading hover:bg-tvip-surface">Kembali ke Home</a>
            </div>
        </div>
    </section>
</x-layouts.app>
