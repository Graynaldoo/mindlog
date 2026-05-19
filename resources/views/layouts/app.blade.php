<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MindLog') — Jurnal Mental Health</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Vite (Tailwind + Alpine) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --font-display: 'Instrument Serif', serif;
            --font-body: 'Plus Jakarta Sans', sans-serif;
        }
        body { 
            font-family: var(--font-body); 
            background: radial-gradient(circle at 10% 20%, rgba(243, 241, 237, 0.4) 0%, rgba(248, 247, 244, 1) 90%);
        }
        .font-display { font-family: var(--font-display); }
        .sidebar-item-active {
            background-color: #7c3aed;
            color: #ffffff;
            box-shadow: 0 10px 15px -3px rgba(124, 58, 237, 0.25);
        }
    </style>
</head>
<body class="h-full text-gray-800 antialiased">

{{-- Sidebar + main wrapper --}}
<div class="flex h-screen overflow-hidden">

    {{-- ── SIDEBAR ────────────────────────────────── --}}
    <aside class="w-64 flex-shrink-0 bg-white/80 backdrop-blur-md border-r border-gray-100 flex flex-col justify-between py-6 px-5 z-20">
        <div>
            {{-- Logo --}}
            <div class="flex items-center justify-between mb-8 px-2">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-violet-600 flex items-center justify-center text-white shadow-md shadow-violet-200">
                        <span class="font-display text-xl font-bold">M</span>
                    </div>
                    <span class="font-display text-2xl font-bold tracking-tight text-gray-900">MindLog</span>
                </div>
                <span class="text-[9px] bg-violet-50 text-violet-600 font-extrabold uppercase tracking-widest px-2 py-0.5 rounded-full">Beta</span>
            </div>

            {{-- Nav --}}
            <nav class="space-y-1.5">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-200 group
                          {{ request()->routeIs('dashboard') ? 'sidebar-item-active' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50/80' }}">
                    <svg class="w-5 h-5 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('journal.index') }}"
                   class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-200 group
                          {{ request()->routeIs('journal.*') ? 'sidebar-item-active' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50/80' }}">
                    <svg class="w-5 h-5 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Jurnal Saya
                </a>

                <a href="{{ route('journal.create') }}"
                   class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-200 group
                          text-gray-500 hover:text-gray-900 hover:bg-gray-50/80">
                    <svg class="w-5 h-5 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 4v16m8-8H4"/>
                    </svg>
                    Tulis Jurnal
                </a>
            </nav>
        </div>

        {{-- User profile --}}
        <div class="border-t border-gray-100 pt-6">
            <div class="flex items-center gap-3.5 bg-gray-50/50 p-3 rounded-2xl border border-gray-100/60">
                <div class="w-10 h-10 rounded-xl bg-violet-100 flex items-center justify-center text-violet-700 font-bold text-base shadow-inner">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-gray-400 font-medium truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button class="w-full py-2.5 px-4 rounded-xl text-center text-xs font-bold text-gray-400 hover:text-red-500 hover:bg-red-50/40 transition-all duration-200 border border-transparent hover:border-red-100">
                    Keluar Akun →
                </button>
            </form>
        </div>
    </aside>

    {{-- ── MAIN CONTENT ────────────────────────────── --}}
    <main class="flex-1 overflow-y-auto">
        {{-- Flash messages --}}
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                 class="fixed top-6 right-6 z-50 bg-green-50 border border-green-200 text-green-800
                        px-5 py-3.5 rounded-2xl text-sm font-semibold shadow-lg shadow-green-100/50 animate-bounce">
                {{ session('success') }}
            </div>
        @endif

        <div class="max-w-5xl mx-auto px-8 py-10">
            @yield('content')
        </div>
    </main>
</div>

@stack('scripts')
</body>
</html>

