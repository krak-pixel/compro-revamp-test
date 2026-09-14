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
    submittingApplication: false,

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

Alpine.data('candidateProfile', () => ({
    submitting: false,
    dirty: false,
    init() {
        this.$nextTick(() => this.$root.querySelector('[aria-invalid="true"]')?.focus());
    },
    warnIfDirty(event) {
        if (!this.dirty || this.submitting) return;
        event.preventDefault();
        event.returnValue = '';
    },
}));

Alpine.data('filePicker', () => ({
    fileName: '',
    select(event) {
        const file = event.target.files?.[0];
        this.fileName = file?.name || '';
    },
}));

const clientKey = () => globalThis.crypto?.randomUUID?.() || `${Date.now()}-${Math.random()}`;

Alpine.data('educationStep', (initial = []) => ({
    submitting: false,
    liveMessage: '',
    colleges: initial.map((college) => ({ ...college, key: clientKey() })),
    addCollege() {
        if (this.colleges.length >= 4) return;
        this.colleges.push({
            key: clientKey(), id: '', institution_name: '', degree: '',
            field_of_study: '', start_year: '', end_year: '', final_score: '',
        });
        this.liveMessage = `Pendidikan ${this.colleges.length} ditambahkan.`;
        this.$nextTick(() => {
            const groups = this.$root.querySelectorAll('fieldset');
            groups[groups.length - 1]?.querySelector('select, input')?.focus();
        });
    },
    removeCollege(index) {
        this.colleges.splice(index, 1);
        this.liveMessage = 'Data pendidikan dihapus dari formulir. Perubahan tersimpan setelah formulir dikirim.';
    },
}));

Alpine.data('experienceStep', (initialStatus = 'fresh_graduate', initial = []) => ({
    submitting: false,
    liveMessage: '',
    status: initialStatus,
    works: initial.map((work) => ({ ...work, key: clientKey() })),
    blankWork() {
        return {
            key: clientKey(), id: '', company_name: '', initial_position: '', final_position: '',
            initial_started_at: '', initial_ended_at: '', initial_responsibilities: '',
            final_started_at: '', final_ended_at: '', final_responsibilities: '', is_current: false, resign_year: '',
            last_salary: '', resign_reason: '', expected_salary: '', company_phone: '',
            supervisor_name: '', supervisor_phone: '',
        };
    },
    ensureWork() {
        if (this.works.length === 0) this.works.push(this.blankWork());
    },
    addWork() {
        if (this.works.length >= 3) return;
        this.works.push(this.blankWork());
        this.liveMessage = `Perusahaan ${this.works.length} ditambahkan.`;
    },
    removeWork(index) {
        if (this.works.length <= 1) return;
        this.works.splice(index, 1);
        this.liveMessage = 'Data perusahaan dihapus dari formulir. Perubahan tersimpan setelah formulir dikirim.';
    },
    init() {
        if (this.status === 'experienced') this.ensureWork();
    },
}));

Alpine.start();
