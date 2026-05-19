{{-- resources/views/components/streak-card.blade.php --}}
@props(['streak'])

<div class="bg-gradient-to-br from-indigo-600 via-violet-600 to-purple-700 rounded-3xl p-6 text-white shadow-xl shadow-violet-100/40 relative overflow-hidden flex flex-col justify-between">
    {{-- Decorative Background Elements --}}
    <div class="absolute -top-12 -right-12 w-32 h-32 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
    <div class="absolute -bottom-16 -left-16 w-36 h-36 bg-purple-500/20 rounded-full blur-2xl pointer-events-none"></div>

    <div class="relative">
        <div class="flex items-center justify-between mb-4">
            <span class="text-xs font-bold uppercase tracking-wider text-indigo-100">Streak Harian</span>
            <div class="w-9 h-9 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center text-lg shadow-inner">
                <svg class="w-5 h-5 text-amber-300 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                </svg>
            </div>
        </div>

        <div class="flex items-baseline gap-2 mb-1">
            <span class="text-5xl font-display font-bold tracking-tight">
                {{ $streak?->current_streak ?? 0 }}
            </span>
            <span class="text-xs font-semibold text-indigo-100">Hari Berturut-turut</span>
        </div>
    </div>

    <div class="mt-6 pt-5 border-t border-white/10 relative">
        <div class="flex justify-between text-[11px] text-indigo-100 font-semibold mb-3">
            <span>Rekor Terbaik: {{ $streak?->longest_streak ?? 0 }} Hari</span>
            <span>
                @if($streak?->last_journal_date)
                    Aktif: {{ $streak->last_journal_date->diffForHumans() }}
                @else
                    Belum Dimulai
                @endif
            </span>
        </div>
        
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-3 text-[11px] leading-relaxed border border-white/5 text-indigo-50">
            @if(($streak?->current_streak ?? 0) >= 7)
                🎉 <strong>Luar biasa!</strong> Kamu sudah sangat konsisten menjaga kesehatan mentalmu. Pertahankan!
            @elseif(($streak?->current_streak ?? 0) >= 3)
                🔥 <strong>Hebat!</strong> Kamu sedang dalam alur yang baik. Teruskan catatanmu!
            @elseif(($streak?->current_streak ?? 0) > 0)
                🌱 <strong>Langkah awal yang baik!</strong> Jangan lupa untuk menulis lagi besok ya.
            @else
                ✨ <strong>Mari mulai!</strong> Tulis perasaanmu hari ini untuk memulai kebiasaan baik baru.
            @endif
        </div>
    </div>
</div>
