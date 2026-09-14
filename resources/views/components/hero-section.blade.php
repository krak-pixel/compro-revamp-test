<section id="home" class="flex min-h-[944px] scroll-mt-16 items-center bg-white pt-16">
    <div class="tvip-container py-16 xl:py-0">
        <div class="grid items-center gap-16 xl:grid-cols-2 xl:gap-20">
            <div class="flex flex-col gap-8 xl:h-[608px] xl:justify-center xl:pt-6">
                <div class="flex flex-col gap-6">
                    <h1 class="text-4xl font-bold leading-tight text-tvip-blue md:text-5xl xl:text-[60px] xl:leading-[75px]">
                        Solusi Distribusi &amp; Logistik Terbaik untuk Pertumbuhan Bisnis Anda.
                    </h1>
                    <p class="max-w-[568px] text-base font-normal leading-7 text-tvip-body md:text-lg md:leading-[29px]">
                        Kami hadir sebagai solusi distribusi dan logistik yang membawa bisnis Anda ke level berikutnya. Dengan standar operasional tertinggi, kami menjamin efisiensi dan keunggulan di setiap rantai pasok.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-4">
                    <x-button href="#kontak-kami">Hubungi Kami</x-button>
                    <x-button href="#tentang-kami" variant="text" class="w-[200px]">Pelajari Lebih Lanjut</x-button>
                </div>
            </div>

            <div class="relative mx-auto w-full max-w-[568px] xl:h-[600px]">
                <div class="relative aspect-[568/600] overflow-hidden rounded-tvip-hero bg-white shadow-tvip-hero xl:h-[600px] xl:w-[568px]">
                    <img
                        src="{{ asset('images/tvip/hero-building.png') }}"
                        alt="Gedung kantor TVIP"
                        width="568"
                        height="600"
                        class="absolute inset-0 h-full w-full object-cover"
                        fetchpriority="high"
                    >
                    <div class="absolute inset-0 bg-white/60"></div>
                    <img
                        src="{{ asset('images/tvip/logo-tvip-3d.png') }}"
                        alt="Logo tiga dimensi TVIP"
                        width="480"
                        height="161"
                        class="absolute left-1/2 top-1/2 w-[84.5%] -translate-x-1/2 -translate-y-1/2 object-contain"
                    >
                </div>

                <x-card variant="contact" class="absolute bottom-8 left-6 flex h-24 w-[212px] items-center px-6 shadow-tvip-floating md:left-8">
                    <div class="flex items-center gap-4">
                        <x-icon-wrapper size="48">
                            <img src="{{ asset('images/tvip/icon-truck.svg') }}" alt="" class="size-6" aria-hidden="true">
                        </x-icon-wrapper>
                        <div>
                            <p class="text-base font-semibold leading-6 text-tvip-heading">50.000+</p>
                            <p class="text-sm font-normal leading-5 text-tvip-body">Mitra Distribusi</p>
                        </div>
                    </div>
                </x-card>
            </div>
        </div>
    </div>
</section>
