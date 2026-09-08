<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TVIP | Solusi Distribusi dan Logistik Terintegrasi</title>
    <meta name="description" content="TVIP menyediakan solusi distribusi dan logistik terintegrasi untuk mendukung pertumbuhan bisnis di JABODETABEK dan Banten.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url('/') }}">

    <meta property="og:type" content="website">
    <meta property="og:title" content="TVIP | Solusi Distribusi dan Logistik Terintegrasi">
    <meta property="og:description" content="Solusi distribusi dan logistik yang efisien, terpercaya, dan terintegrasi untuk pertumbuhan bisnis Anda.">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:image" content="{{ asset('images/tvip/hero-building.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
    x-data="tvipPage({ openContactOnLoad: {{ $errors->any() ? 'true' : 'false' }} })"
    @open-contact-form.window="openContactForm()"
    class="min-h-screen bg-white"
>
    <x-navigation />

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
            class="fixed bottom-6 left-1/2 z-[70] w-[calc(100%-48px)] max-w-xl -translate-x-1/2 rounded-tvip-card bg-tvip-blue px-6 py-4 text-center text-sm font-medium leading-5 text-white shadow-tvip-floating"
            role="status"
        >
            {{ session('contact_success') }}
        </div>
    @endif
</body>
</html>
