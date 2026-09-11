@props(['currentPage' => 'home'])

@php
    $homeLinks = [
        ['label' => 'Home', 'section' => 'home'],
        ['label' => 'Tentang Kami', 'section' => 'tentang-kami'],
        ['label' => 'Kontak Kami', 'section' => 'kontak-kami'],
    ];
    $onHome = $currentPage === 'home';
@endphp

<nav class="fixed inset-x-0 top-0 z-nav h-16 bg-white shadow-tvip-navbar" aria-label="Navigasi utama">
    <div class="tvip-container flex h-16 items-center justify-between">
        <a href="{{ $onHome ? '#home' : route('home') }}" aria-label="TVIP Home" class="block h-8 w-32 shrink-0">
            <img src="{{ asset('images/tvip/logo-tvip-horizontal.png') }}" alt="TVIP" class="h-8 w-32 object-contain">
        </a>

        <div class="hidden items-center gap-8 lg:flex">
            @foreach ($homeLinks as $link)
                <a
                    href="{{ $onHome ? '#'.$link['section'] : route('home').'#'.$link['section'] }}"
                    @class(['relative px-3 py-2 text-base leading-[26px]', 'text-tvip-nav' => ! $onHome])
                    @if ($onHome) :class="activeSection === '{{ $link['section'] }}' ? 'text-tvip-blue' : 'text-tvip-nav'" @endif
                >
                    <span class="relative">
                        {{ $link['label'] }}
                        @if ($onHome)
                            <span x-show="activeSection === '{{ $link['section'] }}'" class="absolute -bottom-2 left-0 h-0.5 w-full rounded-tvip-full bg-tvip-blue" aria-hidden="true"></span>
                        @endif
                    </span>
                </a>
            @endforeach
            <a
                href="{{ route('career.index') }}"
                @class([
                    'relative px-3 py-2 text-base leading-[26px]',
                    'text-tvip-blue' => $currentPage === 'career',
                    'text-tvip-nav' => $currentPage !== 'career',
                ])
                @if ($currentPage === 'career') aria-current="page" @endif
            >
                <span class="relative">
                    Karir
                    @if ($currentPage === 'career')
                        <span class="absolute -bottom-2 left-0 h-0.5 w-full rounded-tvip-full bg-tvip-blue" aria-hidden="true"></span>
                    @endif
                </span>
            </a>
        </div>

        <button
            type="button"
            class="inline-flex h-10 items-center rounded-tvip-button px-4 text-sm font-medium text-tvip-nav lg:hidden"
            @click="mobileMenuOpen = !mobileMenuOpen"
            :aria-expanded="mobileMenuOpen"
            aria-controls="mobile-navigation"
        >
            Menu
        </button>
    </div>

    <div id="mobile-navigation" x-cloak x-show="mobileMenuOpen" x-transition class="border-t border-tvip-divider bg-white lg:hidden">
        <div class="tvip-container flex flex-col py-4">
            @foreach ($homeLinks as $link)
                <a href="{{ $onHome ? '#'.$link['section'] : route('home').'#'.$link['section'] }}" class="px-4 py-3 text-base text-tvip-nav" @click="mobileMenuOpen = false">{{ $link['label'] }}</a>
            @endforeach
            <a href="{{ route('career.index') }}" @class(['px-4 py-3 text-base', 'font-semibold text-tvip-blue' => $currentPage === 'career', 'text-tvip-nav' => $currentPage !== 'career']) @click="mobileMenuOpen = false" @if ($currentPage === 'career') aria-current="page" @endif>Karir</a>
        </div>
    </div>
</nav>
