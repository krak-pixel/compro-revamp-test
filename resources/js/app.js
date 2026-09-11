import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('tvipPage', (options = {}) => ({
    activeSection: 'home',
    mobileMenuOpen: false,
    contactModalOpen: Boolean(options.openContactOnLoad),
    returnFocusTarget: null,

    init() {
        const sectionIds = ['home', 'tentang-kami', 'kontak-kami'];
        const sections = sectionIds
            .map((id) => document.getElementById(id))
            .filter(Boolean);

        const observer = new IntersectionObserver(
            (entries) => {
                const visible = entries
                    .filter((entry) => entry.isIntersecting)
                    .sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];

                if (visible) {
                    this.activeSection = visible.target.id;
                }
            },
            {
                rootMargin: '-24% 0px -56% 0px',
                threshold: [0.05, 0.2, 0.5],
            },
        );

        sections.forEach((section) => observer.observe(section));

        this.$watch('contactModalOpen', (isOpen) => {
            document.documentElement.classList.toggle('overflow-hidden', isOpen);
        });

        if (this.contactModalOpen) {
            this.$nextTick(() => {
                const firstInvalid = this.$refs.contactModal?.querySelector('[aria-invalid="true"]');
                const firstField = this.$refs.contactModal?.querySelector('#name');
                (firstInvalid || firstField)?.focus();
            });
        }
    },

    openContactForm() {
        this.returnFocusTarget = document.activeElement;
        this.contactModalOpen = true;
        this.mobileMenuOpen = false;
        this.$nextTick(() => this.$refs.contactModal?.querySelector('#name')?.focus());
    },

    closeContactForm() {
        this.contactModalOpen = false;
        this.$nextTick(() => this.returnFocusTarget?.focus());
    },

    trapFocus(event, container) {
        if (!container || event.key !== 'Tab') return;

        const focusable = [...container.querySelectorAll(
            'a[href], button:not([disabled]), input:not([disabled]), textarea:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex="-1"])',
        )].filter((element) => !element.hasAttribute('hidden'));

        if (!focusable.length) return;

        const first = focusable[0];
        const last = focusable[focusable.length - 1];

        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first.focus();
        }
    },
}));

Alpine.data('careerPage', (options = {}) => ({
    activePoster: null,
    activePosterAlt: '',
    drawerMode: options.drawerMode || null,
    listUrl: options.listUrl || '/karir',
    searchQuery: options.searchQuery || '',
    returnFocusTarget: null,

    init() {
        this.$watch('activePoster', () => this.syncScrollLock());
        this.$watch('drawerMode', () => this.syncScrollLock());

        if (this.drawerMode) {
            this.$nextTick(() => this.$refs.drawerClose?.focus());
        }

        this.syncScrollLock();
    },

    syncScrollLock() {
        document.documentElement.classList.toggle(
            'overflow-hidden',
            Boolean(this.activePoster || this.drawerMode),
        );
    },

    openPoster(url, alt, trigger) {
        this.returnFocusTarget = trigger || document.activeElement;
        this.activePoster = url;
        this.activePosterAlt = alt;
        this.$nextTick(() => this.$refs.posterClose?.focus());
    },

    closePoster() {
        this.activePoster = null;
        this.activePosterAlt = '';
        this.$nextTick(() => this.returnFocusTarget?.focus());
    },

    closeDrawer() {
        window.location.assign(this.listUrl);
    },

    clearSearch() {
        this.searchQuery = '';
        this.$nextTick(() => {
            this.$refs.searchInput?.focus();
            this.$refs.filterForm?.requestSubmit();
        });
    },

    handleGlobalKeydown(event) {
        if (event.key !== 'Escape') return;

        if (this.activePoster) {
            event.preventDefault();
            this.closePoster();
            return;
        }

        if (this.drawerMode) {
            event.preventDefault();
            this.closeDrawer();
        }
    },

    trapFocus(event, container) {
        if (!container || event.key !== 'Tab') return;

        const focusable = [...container.querySelectorAll(
            'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex="-1"])',
        )].filter((element) => !element.hasAttribute('hidden'));

        if (!focusable.length) return;

        const first = focusable[0];
        const last = focusable[focusable.length - 1];

        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first.focus();
        }
    },
}));

Alpine.start();
