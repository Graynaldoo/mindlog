{{-- resources/views/components/streak-card.blade.php --}}
@props(['streak'])

<div class="bg-gradient-to-br from-violet-500 to-purple-600 rounded-2xl p-5 text-white">
    <div class="flex items-center justify-between mb-3">
        <span class="text-sm font-medium opacity-80">Streak Harian</span>
        <span class="text-2xl">🔥</span>
    </div>

    <div class="flex items-end gap-2">
        <span class="text-5xl font-display font-bold">
            {{ $streak?->current_streak ?? 0 }}
        </span>
        <span class="text-sm opacity-70 mb-2">hari berturut</span>
    </div>

    <div class="mt-4 pt-4 border-t border-white/20 flex justify-between text-xs opacity-70">
        <span>Rekor: {{ $streak?->longest_streak ?? 0 }} hari</span>
        <span>
            @if($streak?->last_journal_date)
                Terakhir: {{ $streak->last_journal_date->diffForHumans() }}
            @else
                Belum mulai
            @endif
        </span>
    </div>
</div>
