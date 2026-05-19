{{-- resources/views/components/mood-icon.blade.php --}}
@props(['score', 'class' => 'w-6 h-6', 'color' => null])

<img src="{{ asset('images/moods/mood_' . $score . '.png') }}" 
     alt="Mood Score {{ $score }}" 
     class="{{ $class }} object-contain select-none transition-all duration-200 pointer-events-none" />
