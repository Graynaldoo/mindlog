<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logout - MindLog EduSmart</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-900 text-slate-100 flex flex-col font-['Plus_Jakarta_Sans'] relative overflow-hidden">
    
    {{-- Dotted Background Pattern --}}
    <div class="absolute inset-0 pointer-events-none opacity-20" 
         style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 24px 24px;">
    </div>



    {{-- Main Container --}}
    <main class="flex-1 flex flex-col items-center justify-center p-4 z-10 animate-fade-in relative">
        
        {{-- Decorative Glow behind card --}}
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[80vw] md:w-[600px] h-[500px] bg-indigo-500/20 blur-[100px] rounded-full pointer-events-none"></div>

        {{-- White Logout Card --}}
        <div class="bg-white/95 backdrop-blur-xl w-full max-w-[440px] rounded-3xl shadow-2xl shadow-black/50 border border-white/20 p-8 md:p-10 text-center animate-scale-in relative overflow-hidden">
            
            {{-- Decorative Gradient inside top edge --}}
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-indigo-500 via-violet-500 to-indigo-500"></div>

            {{-- Illustration --}}
            <div class="w-full h-48 bg-slate-100 rounded-2xl mb-8 overflow-hidden border border-slate-200/60 shadow-inner mx-auto relative flex items-center justify-center">
                {{-- Fallback abstract pattern or actual image if available --}}
                <img src="{{ asset('images/logout-illustration.png') }}" alt="Logout Illustration" class="w-full h-full object-cover opacity-90" onerror="this.style.display='none'">
                
                {{-- Fallback icon if image fails to load --}}
                <svg class="w-16 h-16 text-indigo-200 absolute -z-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                </svg>
            </div>

            {{-- Title --}}
            <h2 class="text-2xl font-extrabold text-slate-800 mb-1 leading-tight">
                Sampai Jumpa Lagi,
            </h2>
            <div class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600 mb-4 pb-1">
                {{ session('logout_name', 'Sobat EduSmart') }}!
            </div>

            {{-- Subtitle --}}
            <p class="text-sm font-medium text-slate-500 mb-8 leading-relaxed max-w-xs mx-auto">
                Anda telah berhasil keluar dari sistem. Sesi Anda aman.
            </p>

            {{-- Primary Action --}}
            <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 w-full bg-gradient-to-r from-indigo-600 to-violet-600 text-white font-bold py-3.5 px-4 rounded-xl hover:shadow-lg hover:shadow-indigo-500/30 hover:scale-[1.02] active:scale-95 transition-all">
                Masuk Kembali
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>
    </main>
</body>
</html>
