<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MindLog') — Jurnal Mental Health</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    {{-- Vite (Tailwind + Alpine) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --font-display: 'Instrument Serif', serif;
            --font-body: 'Plus Jakarta Sans', sans-serif;
        }
        body { font-family: var(--font-body); }
        .font-display { font-family: var(--font-display); }
    </style>
</head>
<body class="h-full bg-[#F7F5F2] text-gray-900">

{{-- Sidebar + main wrapper --}}
<div class="flex h-screen overflow-hidden">

    {{-- ── SIDEBAR ────────────────────────────────── --}}
    <aside class="w-64 flex-shrink-0 bg-white border-r border-gray-100 flex flex-col">
        {{-- Logo --}}
        <div class="px-6 py-5 border-b border-gray-100">
            <span class="font-display text-2xl text-gray-900">MindLog</span>
            <span class="ml-1 text-xs text-violet-500 font-medium">✦ beta</span>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-4 py-6 space-y-1">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium
                      {{ request()->routeIs('dashboard') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('journal.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium
                      {{ request()->routeIs('journal.*') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Jurnal Saya
            </a>

            <a href="{{ route('journal.create') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium
                      text-gray-600 hover:bg-gray-50">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                          d="M12 4v16m8-8H4"/>
                </svg>
                Tulis Jurnal
            </a>
        </nav>

        {{-- User profile --}}
        <div class="px-4 py-4 border-t border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-violet-100 flex items-center justify-center text-violet-700 font-semibold text-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button class="w-full text-left text-xs text-gray-400 hover:text-red-500 transition-colors">
                    Keluar →
                </button>
            </form>
        </div>
    </aside>

    {{-- ── MAIN CONTENT ────────────────────────────── --}}
    <main class="flex-1 overflow-y-auto">
        {{-- Flash messages --}}
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                 class="fixed top-4 right-4 z-50 bg-green-50 border border-green-200 text-green-800
                        px-4 py-3 rounded-xl text-sm font-medium shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="max-w-5xl mx-auto px-8 py-8">
            @yield('content')
        </div>
    </main>
</div>

</body>
</html>
