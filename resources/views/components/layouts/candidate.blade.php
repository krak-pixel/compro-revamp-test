@props(['title' => 'Profil Kandidat — TVIP Karir'])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
                <a href="{{ route('career.index') }}" class="inline-flex size-11 shrink-0 items-center justify-center rounded-tvip-button text-xl text-tvip-blue hover:bg-tvip-info-bg" aria-label="Kembali ke halaman Karir">←</a>
                <div class="min-w-0">
                    <p class="truncate text-lg font-bold leading-6 text-tvip-blue sm:text-xl">Form Kandidat</p>
                    <p class="hidden truncate text-sm leading-5 text-tvip-muted sm:block">Lengkapi data diri Anda untuk melamar pekerjaan</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="hidden max-w-52 truncate text-sm text-tvip-body sm:block">{{ auth()->user()->display_name }}</span>
                <form method="POST" action="{{ route('career.logout') }}">
                    @csrf
                    <button type="submit" class="inline-flex min-h-11 items-center rounded-tvip-button px-3 text-sm font-medium text-tvip-blue hover:bg-tvip-badge-blue-bg">Keluar</button>
                </form>
            </div>
        </div>
    </header>

    <main>{{ $slot }}</main>

    @if (session('success') || session('warning'))
        <div class="fixed bottom-5 right-5 z-toast max-w-sm rounded-tvip-button border px-4 py-3 text-sm shadow-tvip-overlay {{ session('success') ? 'border-tvip-success-border bg-tvip-success-bg text-tvip-success' : 'border-tvip-warning-border bg-tvip-warning-bg text-tvip-warning' }}" role="status">
            {{ session('success') ?: session('warning') }}
        </div>
    @endif
</body>
</html>
