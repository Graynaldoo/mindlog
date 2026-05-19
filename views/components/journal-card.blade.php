{{-- resources/views/components/journal-card.blade.php --}}
@props(['journal'])

<a href="{{ route('journal.show', $journal) }}"
   class="block bg-white rounded-2xl p-5 border border-gray-100
          hover:border-violet-200 hover:shadow-md transition-all duration-200 group">

    <div class="flex items-start justify-between gap-3 mb-3">
        <div>
            <p class="text-xs text-gray-400 mb-1">
                {{ $journal->journal_date->translatedFormat('l, d M Y') }}
            </p>
            <h3 class="font-semibold text-gray-900 group-hover:text-violet-700 transition-colors line-clamp-1">
                {{ $journal->title }}
            </h3>
        </div>
        <span class="text-2xl flex-shrink-0">{{ $journal->mood->emoji }}</span>
    </div>

    <p class="text-sm text-gray-500 line-clamp-2 leading-relaxed">
        {{ Str::limit(strip_tags($journal->content), 120) }}
    </p>

    <div class="mt-4 flex items-center justify-between">
        <span class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-full"
              style="background-color: {{ $journal->mood->color }}22; color: {{ $journal->mood->color }}">
            {{ $journal->mood->name }}
        </span>
        @if($journal->is_private)
            <span class="text-xs text-gray-300">🔒 Privat</span>
        @endif
    </div>
</a>
