{{-- Navbar Component — MindLog EduSmart --}}
<nav class="navbar">
    <div class="flex items-center justify-between w-full max-w-[1800px] mx-auto">
        {{-- Left: Logo + Mobile Toggle --}}
        <div class="flex items-center gap-4">
            {{-- Mobile sidebar toggle --}}
            <button @click="sidebarOpen = !sidebarOpen"
                    class="lg:hidden flex items-center justify-center w-9 h-9 rounded-lg hover:bg-slate-100 transition-colors"
                    aria-label="Toggle sidebar">
                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                </svg>
            </button>

            {{-- Brand --}}
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group" id="nav-brand">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-200/50 group-hover:shadow-indigo-300/60 transition-all duration-300">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                    </svg>
                </div>
                <div class="hidden sm:block">
                    <span class="block text-sm font-extrabold text-slate-900 leading-tight">MindLog</span>
                    <span class="block text-[10px] font-semibold text-slate-400 tracking-wide">EduSmart Platform</span>
                </div>
            </a>
        </div>

        {{-- Center: Search Bar --}}
        <div class="hidden md:flex flex-1 max-w-md mx-8">
            <div class="relative w-full group">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                </svg>
                <input type="text" placeholder="Cari jurnal, artikel, atau topik..."
                       id="nav-search-input"
                       class="w-full pl-10 pr-4 py-2.5 text-sm font-medium bg-slate-50 border border-slate-200 rounded-xl
                              focus:bg-white focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 focus:outline-none
                              placeholder-slate-400 transition-all duration-200">
                <kbd class="absolute right-3 top-1/2 -translate-y-1/2 hidden lg:inline-flex items-center gap-0.5 px-2 py-0.5 text-[10px] font-semibold text-slate-400 bg-white border border-slate-200 rounded-md">
                    ⌘K
                </kbd>
            </div>
        </div>

        {{-- Right: Actions --}}
        <div class="flex items-center gap-2">
            {{-- Write Journal CTA --}}
            <a href="{{ route('journal.create') }}"
               id="nav-write-journal-btn"
               class="hidden sm:inline-flex btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                <span>Tulis Jurnal</span>
            </a>

            {{-- Notification Bell --}}
            <div class="relative" x-data="{ notifOpen: false, hasNew: true }">
                <button id="nav-notification-btn"
                        @click="notifOpen = !notifOpen; hasNew = false"
                        class="relative flex items-center justify-center w-9 h-9 rounded-xl hover:bg-slate-100 transition-colors">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"/>
                    </svg>
                    <span x-show="hasNew" class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white"></span>
                </button>

                {{-- Notification Dropdown --}}
                <div x-show="notifOpen"
                     @click.away="notifOpen = false"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="absolute right-0 mt-2 w-72 bg-white rounded-xl border border-slate-200 shadow-lg z-50"
                     style="display:none;">

                    {{-- Header --}}
                    <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100">
                        <span class="text-sm font-bold text-slate-800">Notifikasi</span>
                        <span class="text-[10px] font-semibold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full">2 baru</span>
                    </div>

                    {{-- List --}}
                    <div class="divide-y divide-slate-50">
                        <div class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 transition-colors cursor-pointer">
                            <div class="w-2 h-2 rounded-full bg-indigo-500 flex-shrink-0"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-slate-700">Jurnal baru berhasil disimpan</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">2 menit lalu</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 transition-colors cursor-pointer">
                            <div class="w-2 h-2 rounded-full bg-indigo-500 flex-shrink-0"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-slate-700">Artikel baru: Literasi Digital</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">1 jam lalu</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 transition-colors cursor-pointer">
                            <div class="w-2 h-2 rounded-full bg-slate-200 flex-shrink-0"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-slate-500">Streak 7 hari tercapai</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">3 jam lalu</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 transition-colors cursor-pointer">
                            <div class="w-2 h-2 rounded-full bg-slate-200 flex-shrink-0"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-slate-500">Kategori baru ditambahkan</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">Kemarin</p>
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="px-4 py-2.5 border-t border-slate-100 text-center">
                        <a href="#" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">Lihat semua</a>
                    </div>
                </div>
            </div>


            {{-- User Profile Dropdown --}}
            <div class="relative" x-data="{ profileOpen: false }">
                <button @click="profileOpen = !profileOpen"
                        @click.away="profileOpen = false"
                        id="nav-profile-dropdown-btn"
                        class="flex items-center gap-2.5 pl-2.5 pr-3 py-1.5 rounded-xl hover:bg-slate-100 transition-colors">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="hidden sm:block text-left">
                        <p class="text-xs font-bold text-slate-800 leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] font-medium text-slate-400">{{ auth()->user()->role?->display_name ?? 'User' }}</p>
                    </div>
                    <svg class="w-3.5 h-3.5 text-slate-400 hidden sm:block transition-transform duration-200" :class="profileOpen && 'rotate-180'" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                    </svg>
                </button>

                {{-- Dropdown Menu --}}
                <div x-show="profileOpen"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-56 bg-white rounded-xl border border-slate-200 shadow-xl shadow-slate-200/50 py-1.5 z-50"
                     style="display: none;">
                    <div class="px-4 py-3 border-b border-slate-100">
                        <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ auth()->user()->email }}</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors" id="nav-profile-link">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                        </svg>
                        Profil Saya
                    </a>
                    <a href="{{ route('statistics.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors" id="nav-statistics-link">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/>
                        </svg>
                        Statistik
                    </a>
                    <div class="border-t border-slate-100 mt-1.5 pt-1.5">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 text-sm font-medium text-rose-600 hover:bg-rose-50 transition-colors" id="nav-logout-btn">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9"/>
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
