@props(['journal'])

<a href="{{ route('journal.show', $journal) }}" 
   class="article-card flex flex-col justify-between h-56 bg-white">
    <div class="absolute top-0 left-0 w-full h-1.5 opacity-80" style="background-color: {{ $journal->mood->color }}"></div>
    
    <div>
        <div class="flex items-center justify-between gap-3 mb-4">
            <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">
                {{ $journal->journal_date->translatedFormat('l, d M Y') }}
            </span>
            <div class="flex items-center gap-2.5">
                @if($journal->is_private)
                    <span class="text-[9px] font-extrabold bg-slate-50 border border-slate-200 text-slate-400 px-2 py-0.5 rounded-full uppercase tracking-widest">Privat</span>
                @endif
                <x-mood-icon :score="$journal->mood->score" :color="$journal->mood->color" class="w-6 h-6 flex-shrink-0" />
            </div>
        </div>
        
        <h3 class="text-lg font-extrabold text-slate-900 group-hover:text-indigo-600 transition-colors leading-tight mb-2 line-clamp-2">
            {{ $journal->title }}
        </h3>
        
        <p class="text-xs font-medium text-slate-500 line-clamp-3 leading-relaxed">
            {{ Str::limit(strip_tags($journal->content), 120) }}
        </p>
    </div>
    
    <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider border"
              style="background-color: {{ $journal->mood->color }}12; color: {{ $journal->mood->color }}; border-color: {{ $journal->mood->color }}30">
            {{ $journal->mood->name }}
        </span>
        
        <span class="text-xs font-bold text-indigo-600 flex items-center gap-1 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all duration-300">
            Baca <span aria-hidden="true">&rarr;</span>
        </span>
    </div>
</a>
