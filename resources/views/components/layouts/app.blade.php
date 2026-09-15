@props([
    'title' => 'TVIP | Solusi Distribusi dan Logistik Terintegrasi',
    'description' => 'TVIP menyediakan solusi distribusi dan logistik terintegrasi untuk mendukung pertumbuhan bisnis di JABODETABEK dan Banten.',
    'canonical' => url()->current(),
    'ogImage' => asset('images/tvip/hero-building.png'),
    'currentPage' => 'home',
])

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ $canonical }}">

    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:image" content="{{ $ogImage }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{ $head ?? '' }}
</head>
<body
    x-data="tvipPage({ openContactOnLoad: {{ $currentPage === 'home' && isset($errors) && $errors->any() ? 'true' : 'false' }} })"
    @open-contact-form.window="openContactForm()"
    class="min-h-screen bg-white"
>
    <x-navigation :current-page="$currentPage" />

    <main>
        {{ $slot }}
    </main>

    <x-footer />
    <x-contact-form-modal />

    @if (session('contact_success'))
        <div
            x-data="{ visible: true }"
            x-show="visible"
            x-init="setTimeout(() => visible = false, 6000)"
            x-transition
            class="fixed bottom-6 left-1/2 z-toast w-[calc(100%-48px)] max-w-xl -translate-x-1/2 rounded-tvip-card bg-tvip-blue px-6 py-4 text-center text-sm font-medium leading-5 text-white shadow-tvip-floating"
            role="status"
        >
            {{ session('contact_success') }}
        </div>
    @endif
</body>
</html>
