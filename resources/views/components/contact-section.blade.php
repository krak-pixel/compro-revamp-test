<section id="kontak-kami" class="scroll-mt-16 bg-tvip-light-section py-20">
    <div class="tvip-container flex flex-col gap-8">
        <header class="mx-auto max-w-3xl text-center">
            <h2 class="text-4xl font-bold leading-tight text-tvip-blue md:text-5xl md:leading-[48px]">Hubungi Kami</h2>
            <p class="mt-4 text-lg font-normal leading-7 text-tvip-body">
                Tim kami siap membantu Anda dengan segala kebutuhan distribusi.<br class="hidden md:block">
                Jangan ragu untuk menghubungi kami melalui berbagai cara di bawah ini.
            </p>
        </header>

        <div class="grid gap-8 lg:grid-cols-3">
            <x-card variant="contact" class="flex min-h-[378px] flex-col items-center px-8 py-8 text-center">
                <x-icon-wrapper>
                    <img src="{{ asset('images/tvip/icon-email.svg') }}" alt="" class="size-8" aria-hidden="true">
                </x-icon-wrapper>
                <h3 class="mt-6 text-2xl font-semibold leading-8 text-tvip-heading">Email</h3>
                <p class="mt-4 text-base font-normal leading-[26px] text-tvip-body">Hubungi kami untuk pertanyaan atau informasi lebih lanjut.</p>
                <a href="mailto:info@tvip.co.id" class="mt-4 text-base font-medium leading-[26px] text-tvip-blue">info@tvip.co.id</a>
            </x-card>

            <x-card variant="contact" class="flex min-h-[378px] flex-col items-center px-8 py-8 text-center">
                <x-icon-wrapper>
                    <img src="{{ asset('images/tvip/icon-phone.svg') }}" alt="" class="size-8" aria-hidden="true">
                </x-icon-wrapper>
                <h3 class="mt-6 text-2xl font-semibold leading-8 text-tvip-heading">Telepon</h3>
                <p class="mt-4 text-base font-normal leading-[26px] text-tvip-body">Kami siap membantu Anda dengan layanan pelanggan terbaik.</p>
                <a href="tel:+62215802130" class="mt-4 text-base font-medium leading-[26px] text-tvip-blue">(021) 5802130</a>
            </x-card>

            <x-card variant="contact" class="flex min-h-[378px] flex-col items-center px-8 py-8 text-center">
                <x-icon-wrapper>
                    <img src="{{ asset('images/tvip/icon-map-pin.svg') }}" alt="" class="size-8" aria-hidden="true">
                </x-icon-wrapper>
                <h3 class="mt-6 text-2xl font-semibold leading-8 text-tvip-heading">Kantor Pusat</h3>
                <p class="mt-4 text-base font-normal leading-[26px] text-tvip-body">Kunjungi kami di lokasi kami yang strategis.</p>
                <address class="mt-4 not-italic text-base font-medium leading-[26px] text-tvip-blue">
                    Jl. Kedoya Raya No.1, Kedoya Selatan, Kecamatan Kebon Jeruk, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11520
                </address>
            </x-card>
        </div>

        <x-card variant="cta" class="flex min-h-[264px] flex-col items-center justify-center px-8 py-8 text-center">
            <h3 class="text-[30px] font-bold leading-9 text-tvip-heading">Siap Bermitra dengan TVIP?</h3>
            <p class="mt-4 max-w-3xl text-lg font-normal leading-7 text-tvip-body">
                Bergabunglah dengan ratusan mitra bisnis yang telah mempercayai TVIP sebagai solusi distribusi &amp; logistik terintegrasi di seluruh JABODETABEK dan Banten.
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <x-button size="cta" @click="$dispatch('open-contact-form')">Hubungi Sekarang</x-button>
                <x-button href="mailto:info@tvip.co.id" variant="outline" size="cta">Kirim Email</x-button>
            </div>
        </x-card>
    </div>
</section>
