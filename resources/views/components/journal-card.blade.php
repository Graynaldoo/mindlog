{{-- resources/views/components/journal-card.blade.php --}}
@props(['journal'])

<a href="{{ route('journal.show', $journal) }}"
   class="block bg-white rounded-3xl p-6 border border-gray-100/70 shadow-sm hover:shadow-lg hover:shadow-violet-100/20 hover:border-violet-200 transition-all duration-300 group relative overflow-hidden flex flex-col justify-between h-48">
    {{-- Mood Accent Bar --}}
    <div class="absolute top-0 left-0 w-full h-1" style="background-color: {{ $journal->mood->color }}"></div>

    <div>
        <div class="flex items-center justify-between gap-3 mb-2.5">
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                {{ $journal->journal_date->translatedFormat('l, d M Y') }}
            </span>
            <div class="flex items-center gap-2">
                @if($journal->is_private)
                    <span class="text-[9px] font-bold bg-gray-50 border border-gray-100 text-gray-400 px-2 py-0.5 rounded-full">🔒 Privat</span>
                @endif
                <x-mood-icon :score="$journal->mood->score" :color="$journal->mood->color" class="w-6 h-6 flex-shrink-0" />
            </div>
        </div>

        <h3 class="font-bold text-gray-900 group-hover:text-violet-600 transition-colors text-base line-clamp-1 leading-snug">
            {{ $journal->title }}
        </h3>

        <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed mt-2 pl-0.5">
            {{ Str::limit(strip_tags($journal->content), 125) }}
        </p>
    </div>

    <div class="mt-4 flex items-center justify-between pl-0.5">
        <span class="inline-flex items-center gap-1 text-[9px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full border"
              style="background-color: {{ $journal->mood->color }}12; color: {{ $journal->mood->color }}; border-color: {{ $journal->mood->color }}25">
            {{ $journal->mood->name }}
        </span>
        
        <span class="text-xs font-bold text-violet-500 flex items-center gap-0.5 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all duration-300">
            Baca
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
            </svg>
        </span>
    </div>
</a>
