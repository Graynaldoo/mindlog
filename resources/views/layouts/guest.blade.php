<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="MindLog EduSmart — Platform jurnal belajar dan literasi digital.">
    <title>{{ config('app.name', 'MindLog EduSmart') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-slate-50" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="min-h-screen flex">
        {{-- Left Panel — Branding --}}
        <div class="hidden lg:flex lg:w-1/2 xl:w-[55%] relative overflow-hidden bg-slate-950 items-center justify-center border-r border-slate-800/50">
            {{-- Abstract glow background --}}
            <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-indigo-950 to-violet-950"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-indigo-500/15 via-transparent to-transparent"></div>
            
            {{-- Decorative Grid --}}
            <div class="absolute inset-0 pointer-events-none opacity-[0.05]" style="background-image: linear-gradient(to right, #ffffff 1px, transparent 1px), linear-gradient(to bottom, #ffffff 1px, transparent 1px); background-size: 3rem 3rem;"></div>

            {{-- Glassmorphism Content Card --}}
            <div class="relative z-10 w-full max-w-lg p-12 animate-fade-up">
                
                {{-- Logo and Text --}}
                <div class="flex items-center gap-4 mb-10">
                    <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center shadow-xl shadow-indigo-900/50">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                        </svg>
                    </div>
                    <span class="text-3xl font-extrabold text-white tracking-tight">MindLog</span>
                </div>
                
                <h1 class="text-4xl xl:text-5xl font-extrabold text-white leading-[1.1] mb-6 tracking-tight">
                    Bangun kebiasaan <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-200 to-white">belajar</span> yang konsisten.
                </h1>
                
                <p class="text-base text-indigo-100/80 leading-relaxed font-medium mb-12 max-w-md">
                    MindLog EduSmart adalah platform analitik dan jurnal personal untuk melacak setiap tahap perkembangan literasi digital Anda.
                </p>


            </div>
            
            {{-- Decorative Blurs --}}
            <div class="absolute -top-32 -right-32 w-[30rem] h-[30rem] bg-white/10 blur-[120px] rounded-full pointer-events-none"></div>
            <div class="absolute -bottom-32 -left-32 w-[30rem] h-[30rem] bg-indigo-400/20 blur-[120px] rounded-full pointer-events-none"></div>
        </div>

        {{-- Right Panel — Form --}}
        <div class="flex-1 flex items-center justify-center p-6 sm:p-8 lg:p-12">
            <div class="w-full max-w-md">
                {{-- Mobile Logo --}}
                <div class="lg:hidden text-center mb-8">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center mx-auto mb-4 shadow-lg shadow-indigo-200/50">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-extrabold text-slate-900">MindLog EduSmart</h2>
                </div>

                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
