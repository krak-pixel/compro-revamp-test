import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('tvipPage', (options = {}) => ({
    activeSection: 'home',
    mobileMenuOpen: false,
    contactModalOpen: Boolean(options.openContactOnLoad),

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
            this.$nextTick(() => this.$refs.contactName?.focus());
        }
    },

    openContactForm() {
        this.contactModalOpen = true;
        this.mobileMenuOpen = false;
        this.$nextTick(() => this.$refs.contactName?.focus());
    },

    closeContactForm() {
        this.contactModalOpen = false;
    },
}));

Alpine.start();
