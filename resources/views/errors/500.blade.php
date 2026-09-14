<x-layouts.app
    title="Terjadi Gangguan — TVIP"
    description="Layanan TVIP sedang mengalami gangguan sementara."
    :canonical="route('home')"
>
    <section class="tvip-container flex min-h-[70vh] items-center justify-center pb-20 pt-32 text-center">
        <div class="max-w-xl">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-tvip-blue">500</p>
            <h1 class="mt-3 text-3xl font-bold text-tvip-heading sm:text-4xl">Layanan sedang mengalami gangguan</h1>
            <p class="mt-4 text-base leading-7 text-tvip-body">Silakan coba kembali beberapa saat lagi. Jika gangguan berlanjut, hubungi tim TVIP.</p>
            <a href="{{ url()->current() }}" class="mt-8 inline-flex min-h-11 items-center justify-center rounded-tvip-button bg-tvip-blue px-6 text-sm font-semibold text-white hover:bg-tvip-blue-dark">Coba Lagi</a>
        </div>
    </section>
</x-layouts.app>
