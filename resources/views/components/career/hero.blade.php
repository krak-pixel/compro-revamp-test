@props(['stats'])

<section class="relative min-h-[620px] overflow-hidden bg-tvip-hero pt-16 text-white lg:min-h-[700px]" aria-labelledby="career-heading">
    <div class="tvip-container relative z-10 pb-28 pt-16 sm:pt-20 lg:pt-24">
        <div class="max-w-[672px]">
            <span class="inline-flex h-9 items-center gap-2 rounded-tvip-full border border-white/20 bg-white/10 px-4 text-sm font-medium leading-5">
                <span class="size-2 rounded-full bg-tvip-hiring" aria-hidden="true"></span>
                We Are Hiring!
            </span>

            <h1 id="career-heading" class="mt-5 max-w-[620px] text-[38px] font-bold leading-[1.16] sm:text-5xl sm:leading-[60px]">
                Bergabunglah dengan<br class="hidden sm:block"> Tim TVIP
            </h1>
            <p class="mt-5 max-w-2xl text-base leading-7 text-tvip-badge-blue-bg sm:text-[17px] sm:leading-[27.625px]">
                Jadilah bagian dari perusahaan distribusi &amp; logistik terkemuka di Indonesia. Temukan kesempatan karir terbaik Anda bersama TVIP GROUP.
            </p>

            <dl class="mt-7 flex flex-wrap gap-x-9 gap-y-4">
                @foreach ([
                    [$stats['jobs'].'+', 'Lowongan Aktif'],
                    [$stats['locations'].'+', 'Kota'],
                    [$stats['departments'].'+', 'Departemen'],
                ] as [$value, $label])
                    <div>
                        <dt class="order-2 text-sm leading-5 text-tvip-on-dark-muted">{{ $label }}</dt>
                        <dd class="text-2xl font-bold leading-[38px] text-white">{{ $value }}</dd>
                    </div>
                @endforeach
            </dl>

            @guest
                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ route('login') }}" class="inline-flex min-h-11 items-center justify-center rounded-tvip-button-lg bg-white px-6 text-sm font-semibold text-tvip-blue transition hover:bg-tvip-surface">Login</a>
                    <a href="{{ route('register') }}" class="inline-flex min-h-11 items-center justify-center rounded-tvip-button-lg border-2 border-white px-6 text-sm font-semibold text-white transition hover:bg-white/10">Daftar</a>
                </div>
            @else
                <div class="mt-7 inline-flex max-w-full items-center gap-3 rounded-tvip-button border border-white/15 bg-white/10 px-4 py-3 shadow-tvip-job backdrop-blur-sm">
                    <a href="{{ route('career.profile') }}" class="flex min-w-0 items-center gap-3 rounded-md p-3 hover:bg-white/10" aria-label="Buka profil saya">
                        <span class="inline-flex size-9 shrink-0 items-center justify-center rounded-tvip-full bg-white">
                            <img src="{{ asset('images/tvip/career/icon-profile.svg') }}" alt="" aria-hidden="true" class="size-5">
                        </span>
                        <span class="min-w-0">
                            <strong class="block truncate text-sm font-semibold leading-5 text-white">{{ auth()->user()->display_name }}</strong>
                            <span class="block truncate text-xs leading-4 text-white/70">{{ auth()->user()->email }}</span>
                        </span>
                    </a>
                    <form action="{{ route('career.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex min-h-10 items-center gap-2 rounded-md px-2 text-xs font-medium text-white/90 hover:bg-white/10 hover:text-white">
                            <img src="{{ asset('images/tvip/career/icon-logout.svg') }}" alt="" aria-hidden="true" class="size-4 brightness-0 invert">
                            Logout
                        </button>
                    </form>
                </div>
            @endguest
        </div>
    </div>
    <div class="career-hero-wave" aria-hidden="true"></div>
</section>
