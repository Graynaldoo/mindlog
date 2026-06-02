<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="MindLog EduSmart — Platform jurnal belajar, literasi digital, dan pengembangan diri berbasis TIK untuk masyarakat Indonesia.">
    <title>@yield('title', 'MindLog EduSmart')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full" x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false">

    {{-- ── Top Navbar ──────────────────────────────── --}}
    <x-navbar />

    {{-- ── Sidebar Overlay (mobile) ────────────────── --}}
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 z-30 bg-slate-900/30 backdrop-blur-sm lg:hidden"
         style="display: none;">
    </div>

    {{-- ── Sidebar ─────────────────────────────────── --}}
    <x-sidebar />

    {{-- ── Main Content Area ───────────────────────── --}}
    <main class="main-content">
        <x-alert />
        <div class="stagger-children">
            @yield('content')
        </div>
    </main>

    {{-- ── Mobile Bottom Navigation ────────────────── --}}
    <x-mobile-bottom-nav />

    @stack('scripts')
</body>
</html>
