<nav class="border-b border-slate-200 bg-white">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <span class="grid h-9 w-9 place-items-center rounded-lg bg-emerald-600 text-sm font-extrabold text-white">ML</span>
            <span>
                <span class="block text-base font-extrabold leading-tight">MindLog EduSmart</span>
                <span class="block text-xs font-semibold text-slate-500">Jurnal dan literasi digital</span>
            </span>
        </a>

        <div class="flex items-center gap-3">
            <a href="{{ route('journal.create') }}" class="hidden rounded-lg bg-emerald-600 px-4 py-2 text-sm font-bold text-white hover:bg-emerald-700 sm:inline-flex">
                Tulis Jurnal
            </a>
            <div class="text-right">
                <p class="text-sm font-bold">{{ auth()->user()->name }}</p>
                <p class="text-xs font-semibold text-slate-500">{{ auth()->user()->role?->display_name ?? 'User' }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50">Logout</button>
            </form>
        </div>
    </div>
</nav>
