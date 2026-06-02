{{-- Sidebar Component — MindLog EduSmart --}}
@php
    $mainLinks = [
        [
            'label' => 'Dashboard',
            'route' => 'dashboard',
            'active' => 'dashboard',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>',
        ],
        [
            'label' => 'Jurnal Harian',
            'route' => 'journal.index',
            'active' => 'journal.*',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>',
        ],
        [
            'label' => 'Artikel Edukasi',
            'route' => 'articles.index',
            'active' => 'articles.index|articles.show',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>',
        ],
        [
            'label' => 'Statistik',
            'route' => 'statistics.index',
            'active' => 'statistics.*',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>',
        ],
    ];

    $adminLinks = [];

    if(auth()->user()->can('write-articles')) {
        $adminLinks[] = [
            'label' => 'Kelola Artikel',
            'route' => 'articles.manage',
            'active' => 'articles.manage|articles.create|articles.edit',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>',
        ];
    }

    if(auth()->user()->can('manage-categories')) {
        $adminLinks[] = [
            'label' => 'Kelola Kategori',
            'route' => 'categories.index',
            'active' => 'categories.*',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/>',
        ];
    }

    if(auth()->user()->can('manage-users')) {
        $adminLinks[] = [
            'label' => 'Kelola User',
            'route' => 'admin.users.index',
            'active' => 'admin.users.*',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>',
        ];
    }

    $bottomLinks = [
        [
            'label' => 'Pengaturan',
            'route' => 'profile.edit',
            'active' => 'profile.*',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>',
        ],
    ];
@endphp

<aside class="sidebar" :class="sidebarOpen && 'open'">
    <div class="flex flex-col h-full">
        {{-- User Card --}}
        <div class="mb-5 p-3.5 rounded-xl bg-gradient-to-br from-slate-50 to-indigo-50/50 border border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-white text-sm font-bold shadow-md shadow-indigo-200/50">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-bold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[11px] font-medium text-slate-400">{{ auth()->user()->role?->display_name ?? 'User' }}</p>
                </div>
            </div>
        </div>

        {{-- Main Navigation --}}
        <div class="sidebar-section-title">Menu Utama</div>
        <nav class="space-y-0.5">
            @foreach($mainLinks as $link)
                <a href="{{ route($link['route']) }}"
                   class="sidebar-link {{ collect(explode('|', $link['active']))->contains(fn($p) => request()->routeIs($p)) ? 'active' : '' }}"
                   id="sidebar-{{ Str::slug($link['label']) }}">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">{!! $link['icon'] !!}</svg>
                    <span>{{ $link['label'] }}</span>
                </a>
            @endforeach
        </nav>

        {{-- Admin Links --}}
        @if(count($adminLinks) > 0)
            <div class="sidebar-section-title">Pengelolaan</div>
            <nav class="space-y-0.5">
                @foreach($adminLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       class="sidebar-link {{ collect(explode('|', $link['active']))->contains(fn($p) => request()->routeIs($p)) ? 'active' : '' }}"
                       id="sidebar-{{ Str::slug($link['label']) }}">
                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">{!! $link['icon'] !!}</svg>
                        <span>{{ $link['label'] }}</span>
                    </a>
                @endforeach
            </nav>
        @endif

        {{-- Bottom Links --}}
        <div class="mt-auto pt-4 border-t border-slate-100">
            @foreach($bottomLinks as $link)
                <a href="{{ route($link['route']) }}"
                   class="sidebar-link {{ collect(explode('|', $link['active']))->contains(fn($p) => request()->routeIs($p)) ? 'active' : '' }}"
                   id="sidebar-{{ Str::slug($link['label']) }}">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">{!! $link['icon'] !!}</svg>
                    <span>{{ $link['label'] }}</span>
                </a>
            @endforeach

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link w-full text-left hover:!text-rose-600 hover:!bg-rose-50" id="sidebar-logout">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </div>
</aside>
