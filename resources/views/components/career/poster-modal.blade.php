<div
    x-cloak
    x-show="activePoster"
    x-transition.opacity.duration.200ms
    class="fixed inset-0 z-dialog flex items-center justify-center bg-black/60 p-4 sm:p-6"
    @click.self="closePoster()"
    role="presentation"
>
    <section
        x-ref="posterDialog"
        @keydown.tab="trapFocus($event, $refs.posterDialog)"
        class="career-layer-enter relative max-h-[calc(100dvh-32px)] max-w-[896px] overflow-hidden rounded-tvip-card bg-white shadow-tvip-overlay sm:max-h-[calc(100dvh-48px)]"
        role="dialog"
        aria-modal="true"
        aria-labelledby="poster-title"
    >
        <h2 id="poster-title" class="sr-only" x-text="activePosterAlt"></h2>
        <img :src="activePoster" :alt="activePosterAlt" class="max-h-[calc(100dvh-32px)] w-auto max-w-full object-contain sm:max-h-[calc(100dvh-48px)]">
        <button
            x-ref="posterClose"
            type="button"
            @click="closePoster()"
            class="absolute right-3 top-3 inline-flex size-11 items-center justify-center rounded-tvip-full bg-tvip-heading/85 text-2xl leading-none text-white shadow-tvip-job hover:bg-tvip-heading"
            aria-label="Tutup poster lowongan"
        >×</button>
    </section>
</div>
