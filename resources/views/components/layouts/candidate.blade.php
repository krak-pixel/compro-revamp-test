@props(['title' => 'Profil Kandidat — TVIP Karir'])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/tvip/logo-tvip-favicon.svg') }}" type="image/svg+xml">
    <title>{{ $title }}</title>
    <meta name="description" content="Lengkapi profil kandidat dan pantau riwayat lamaran TVIP Karir.">
    <meta name="robots" content="noindex, nofollow">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-dvh bg-tvip-surface font-inter text-tvip-heading">
    <header class="h-[81px] border-b border-tvip-divider bg-white">
        <div class="mx-auto flex h-full w-full max-w-[1024px] items-center justify-between px-5 sm:px-8">
            <div class="flex min-w-0 items-center gap-3">
                <div class="min-w-0">
                    <p class="truncate text-lg font-bold leading-6 text-tvip-blue sm:text-xl">Form Kandidat</p>
                    <p class="hidden truncate text-sm leading-5 text-tvip-muted sm:block">Lengkapi data diri Anda untuk melamar pekerjaan</p>
                </div>
            </div>
        </div>
    </header>

    <main>{{ $slot }}</main>

    @if (session('success') || session('warning'))
        <div class="fixed bottom-5 right-5 z-toast max-w-sm rounded-tvip-button border px-4 py-3 text-sm shadow-tvip-overlay {{ session('success') ? 'border-tvip-success-border bg-tvip-success-bg text-tvip-success' : 'border-tvip-warning-border bg-tvip-warning-bg text-tvip-warning' }}" role="status">
            {{ session('success') ?: session('warning') }}
        </div>
    @endif

    <script>
        window.history.pushState({ candidateProfile: true }, '', window.location.href);

        window.addEventListener('popstate', () => {
            window.location.replace(@json(route('career.index')));
        });
    </script>
</body>
</html>
