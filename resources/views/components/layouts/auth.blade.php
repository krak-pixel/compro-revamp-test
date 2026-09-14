@props([
    'title',
    'description' => 'Portal kandidat TVIP Karir.',
])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <meta name="robots" content="noindex, follow">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-dvh bg-tvip-hero font-inter text-tvip-heading">
    <main class="flex min-h-dvh items-center justify-center px-4 py-12 sm:px-6">
        <div class="w-full max-w-[448px]">
            <a href="{{ route('career.index') }}" class="mb-5 inline-flex min-h-11 items-center text-sm leading-5 text-white/80 transition hover:text-white">
                <span class="mr-2 text-lg" aria-hidden="true">←</span>
                Kembali ke Halaman Karir
            </a>

            {{ $slot }}

            <p class="mt-5 text-center text-xs leading-5 text-white/60">
                Data kandidat digunakan untuk proses rekrutmen dan disimpan secara privat sesuai kebijakan perusahaan.
            </p>
        </div>
    </main>
</body>
</html>
