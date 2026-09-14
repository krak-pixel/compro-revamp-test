<footer class="bg-white">
    <div class="tvip-container py-16">
        <div class="grid gap-12 md:grid-cols-2 lg:grid-cols-3">
            <div>
                <img src="{{ asset('images/tvip/logo-tvip-horizontal.png') }}" alt="TVIP" width="128" height="32" class="h-8 w-32 object-contain">

                <div class="mt-8">
                    <h2 class="text-base font-semibold leading-[26px] text-tvip-heading">Kantor Pusat:</h2>
                    <address class="mt-2 max-w-sm not-italic text-base font-normal leading-[26px] text-tvip-body">
                        Jl. Kedoya Raya No.1, Kedoya Selatan, Kecamatan Kebon Jeruk, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11520
                    </address>
                </div>

                <div class="mt-6">
                    <h2 class="text-base font-semibold leading-[26px] text-tvip-heading">Kontak:</h2>
                    <div class="mt-2 flex flex-col gap-1 text-base font-normal leading-[26px] text-tvip-body">
                        <a href="tel:+62215802130">(021) 5802130</a>
                        <a href="mailto:info@tvip.co.id">info@tvip.co.id</a>
                    </div>
                </div>

                <div class="mt-8 flex gap-4">
                    @foreach ([
                        ['facebook', 'Facebook'],
                        ['instagram', 'Instagram'],
                        ['twitter', 'X (Twitter)'],
                        ['linkedin', 'LinkedIn'],
                    ] as [$icon, $label])
                        <span role="img" aria-label="{{ $label }} — tautan akan tersedia kemudian" class="inline-flex rounded-tvip-full">
                            <x-icon-wrapper size="40" background="social">
                                <img src="{{ asset('images/tvip/icon-'.$icon.'.svg') }}" alt="" aria-hidden="true" class="size-5">
                            </x-icon-wrapper>
                        </span>
                    @endforeach
                </div>
            </div>

            <div>
                <h2 class="text-base font-semibold leading-[26px] text-tvip-heading">Perusahaan</h2>
                <ul class="mt-4 flex flex-col gap-3 text-base font-normal leading-[26px] text-tvip-body">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('home') }}#tentang-kami">Tentang Kami</a></li>
                    <li><a href="{{ route('home') }}#kontak-kami">Kontak Kami</a></li>
                    <li><a href="{{ route('career.index') }}">Karir</a></li>
                </ul>
            </div>

            <div>
                <h2 class="text-base font-semibold leading-[26px] text-tvip-heading">Media Sosial</h2>
                <ul class="mt-4 flex flex-col gap-3 text-base font-normal leading-[26px] text-tvip-body">
                    <li><span>Facebook</span></li>
                    <li><span>Instagram</span></li>
                    <li><span>X (Twitter)</span></li>
                    <li><span>LinkedIn</span></li>
                </ul>
            </div>
        </div>

        <div class="mt-12 flex flex-col gap-6 border-t border-tvip-divider pt-8 text-sm font-normal leading-5 text-tvip-body md:flex-row md:items-center md:justify-between">
            <p>© 2026 TVIP. Semua hak dilindungi.</p>
            <div class="flex flex-wrap gap-6">
                <span>Kebijakan Privasi</span>
                <span>Syarat dan Ketentuan</span>
                <span>Pengaturan Cookies</span>
            </div>
        </div>
    </div>
</footer>
