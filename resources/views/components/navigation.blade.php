<nav class="fixed inset-x-0 top-0 z-50 h-16 bg-white shadow-tvip-navbar" aria-label="Navigasi utama">
    <div class="tvip-container flex h-16 items-center justify-between">
        <a href="{{ route('home') }}" aria-label="TVIP Home" class="block h-8 w-32 shrink-0">
            <img src="{{ asset('images/tvip/logo-tvip-horizontal.png') }}" alt="TVIP" class="h-8 w-32 object-contain">
        </a>

        <div class="hidden items-center gap-8 lg:flex">
            <a href="{{ route('home') }}" class="relative px-3 py-2 text-base leading-[26px]" :class="activeSection === 'home' ? 'text-tvip-blue' : 'text-tvip-nav'">
                <span class="relative" :class="activeSection === 'home' ? 'after:absolute after:-bottom-2 after:left-0 after:h-0.5 after:w-full after:rounded-tvip-full after:bg-tvip-blue' : ''">Home</span>
            </a>
            <a href="#tentang-kami" class="relative px-3 py-2 text-base leading-[26px]" :class="activeSection === 'tentang-kami' ? 'text-tvip-blue' : 'text-tvip-nav'">
                <span class="relative" :class="activeSection === 'tentang-kami' ? 'after:absolute after:-bottom-2 after:left-0 after:h-0.5 after:w-full after:rounded-tvip-full after:bg-tvip-blue' : ''">Tentang Kami</span>
            </a>
            <a href="#kontak-kami" class="relative px-3 py-2 text-base leading-[26px]" :class="activeSection === 'kontak-kami' ? 'text-tvip-blue' : 'text-tvip-nav'">
                <span class="relative" :class="activeSection === 'kontak-kami' ? 'after:absolute after:-bottom-2 after:left-0 after:h-0.5 after:w-full after:rounded-tvip-full after:bg-tvip-blue' : ''">Kontak Kami</span>
            </a>
            <a href="/karir" aria-disabled="true" @click.prevent class="cursor-not-allowed px-3 py-2 text-base leading-[26px] text-tvip-nav opacity-60" title="Fitur Karir tersedia pada fase berikutnya">Karir</a>
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
            <a href="{{ route('home') }}" class="px-4 py-3 text-base text-tvip-nav" @click="mobileMenuOpen = false">Home</a>
            <a href="#tentang-kami" class="px-4 py-3 text-base text-tvip-nav" @click="mobileMenuOpen = false">Tentang Kami</a>
            <a href="#kontak-kami" class="px-4 py-3 text-base text-tvip-nav" @click="mobileMenuOpen = false">Kontak Kami</a>
            <a href="/karir" aria-disabled="true" @click.prevent class="cursor-not-allowed px-4 py-3 text-base text-tvip-nav opacity-60">Karir</a>
        </div>
    </div>
</nav>
