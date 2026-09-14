@props(['paginator', 'label' => 'Navigasi halaman lowongan'])

@if ($paginator->hasPages())
    <nav class="mt-12 flex items-center justify-center gap-2" aria-label="{{ $label }}">
        <a
            href="{{ $paginator->previousPageUrl() ?: $paginator->url(1) }}"
            @class(['inline-flex size-9 items-center justify-center rounded-tvip-button-lg border border-tvip-divider text-sm text-tvip-muted', 'pointer-events-none opacity-40' => $paginator->onFirstPage(), 'hover:border-tvip-blue hover:text-tvip-blue' => ! $paginator->onFirstPage()])
            @if ($paginator->onFirstPage()) aria-disabled="true" tabindex="-1" @endif
            aria-label="Halaman sebelumnya"
        >←</a>

        @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
            <a
                href="{{ $url }}"
                @class(['inline-flex size-9 items-center justify-center rounded-tvip-button-lg border text-sm font-medium', 'border-tvip-blue bg-tvip-blue text-white shadow-tvip-active' => $page === $paginator->currentPage(), 'border-tvip-divider text-tvip-body hover:border-tvip-blue hover:text-tvip-blue' => $page !== $paginator->currentPage()])
                @if ($page === $paginator->currentPage()) aria-current="page" @endif
                aria-label="Halaman {{ $page }}"
            >{{ $page }}</a>
        @endforeach

        <a
            href="{{ $paginator->nextPageUrl() ?: $paginator->url($paginator->lastPage()) }}"
            @class(['inline-flex size-9 items-center justify-center rounded-tvip-button-lg border border-tvip-divider text-sm text-tvip-muted', 'pointer-events-none opacity-40' => ! $paginator->hasMorePages(), 'hover:border-tvip-blue hover:text-tvip-blue' => $paginator->hasMorePages()])
            @if (! $paginator->hasMorePages()) aria-disabled="true" tabindex="-1" @endif
            aria-label="Halaman berikutnya"
        >→</a>
    </nav>
@endif
