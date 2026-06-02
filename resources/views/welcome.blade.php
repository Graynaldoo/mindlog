<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'MindLog') }} - Tingkatkan Literasi & Refleksi</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fafafa;
            color: #0f172a;
        }

        .text-brand {
            color: #7c3aed; /* Violet 600 */
        }

        .bg-brand {
            background-color: #7c3aed;
        }

        .btn-primary {
            background-color: #7c3aed;
            color: white;
            transition: all 0.2s ease-in-out;
        }
        .btn-primary:hover {
            background-color: #6d28d9; /* Violet 700 */
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(124, 58, 237, 0.3);
        }

        .btn-outline {
            background-color: white;
            color: #7c3aed;
            border: 1px solid #e5e7eb;
            transition: all 0.2s ease-in-out;
        }
        .btn-outline:hover {
            border-color: #7c3aed;
            background-color: #f5f3ff;
        }

        .feature-card {
            background: white;
            border-radius: 1.5rem;
            transition: all 0.3s ease;
            border: 1px solid white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }
        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: #f3f4f6;
        }

        .hero-bg {
            background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .mockup-bg {
            background-color: #d8b4e2;
            border-radius: 2rem;
            box-shadow: 0 25px 50px -12px rgba(124, 58, 237, 0.15);
        }

        .badge-new {
            background-color: #e0e7ff;
            color: #4338ca;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.375rem 0.875rem;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            letter-spacing: 0.025em;
        }

        .cta-container {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
            border-radius: 2rem;
            position: relative;
            overflow: hidden;
        }
    </style>
</head>
<body class="antialiased overflow-x-hidden flex flex-col min-h-screen">

    <!-- Navigation -->
    <nav class="w-full bg-white/90 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <span class="text-2xl font-extrabold text-brand tracking-tight">MindLog</span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-sm font-semibold text-brand border-b-2 border-brand pb-1">Fitur</a>
                    <a href="#impact" class="text-sm font-medium text-slate-500 hover:text-slate-900 transition-colors">Dampak</a>
                </div>

                <!-- Auth Links -->
                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-brand hover:text-purple-800 transition-colors">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-brand hover:text-purple-800 transition-colors hidden sm:block">
                                Login
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-6 py-2.5 rounded-full btn-primary text-sm font-bold">
                                    Get Started
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="flex-grow hero-bg pt-20 pb-28 md:pt-32 md:pb-40 relative overflow-hidden flex items-center justify-center">
        <!-- Abstract Background Blobs -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[500px] bg-purple-200/40 rounded-full blur-[100px] pointer-events-none -z-10"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-10">
            <div class="flex flex-col items-center text-center max-w-4xl mx-auto">
                
                <div class="badge-new mb-8 inline-flex items-center mx-auto shadow-sm">
                    <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
                    </svg>
                    BARU: AI INSIGHT JURNAL
                </div>

                <h1 class="text-5xl md:text-6xl lg:text-[4.5rem] font-extrabold tracking-tight mb-8 text-slate-900 leading-[1.1] mx-auto">
                    Tingkatkan Literasi & Refleksi Bersama <span class="text-brand block sm:inline">MindLog</span>
                </h1>
                
                <p class="text-lg md:text-xl text-slate-500 mb-12 max-w-2xl mx-auto leading-relaxed font-medium">
                    Platform cerdas untuk menulis jurnal belajar dan membaca artikel edukasi berkualitas. Temukan cara baru untuk tumbuh setiap hari dengan refleksi mendalam.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full sm:w-auto">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-10 py-4 rounded-xl btn-primary text-lg font-bold flex items-center justify-center shadow-lg shadow-purple-500/20">
                        Mulai Menulis Gratis
                    </a>
                    <a href="#features" class="w-full sm:w-auto px-10 py-4 rounded-xl btn-outline text-lg font-bold flex items-center justify-center">
                        Pelajari Fitur
                    </a>
                </div>

                <!-- Social Proof / Stats below buttons -->
                <div class="mt-16 pt-8 border-t border-slate-200/60 flex flex-wrap justify-center gap-8 md:gap-16 text-slate-500 font-bold text-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        100% Gratis
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Edukasi Berkualitas
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Analitik Personal
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Features Section -->
    <section id="features" class="py-20 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4">Kenapa Memilih MindLog?</h2>
                <p class="text-lg text-slate-500 font-medium">
                    Kami merancang setiap fitur untuk memastikan perjalanan belajar Anda terstruktur, menyenangkan, dan memberikan dampak jangka panjang.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card p-8">
                    <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Jurnal Harian</h3>
                    <p class="text-slate-500 leading-relaxed text-sm font-medium">
                        Refleksi harian yang terstruktur membantu Anda memproses informasi baru dan memperkuat ingatan jangka panjang.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card p-8">
                    <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600 mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Artikel Edukasi</h3>
                    <p class="text-slate-500 leading-relaxed text-sm font-medium">
                        Konten pilihan dari para ahli di berbagai bidang untuk memperluas cakrawala pengetahuan Anda setiap hari.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card p-8">
                    <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Statistik Belajar</h3>
                    <p class="text-slate-500 leading-relaxed text-sm font-medium">
                        Pantau perkembangan belajarmu dengan visualisasi data yang intuitif dan motivasi yang personal.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Impact Stats Section -->
    <section id="impact" class="py-20 md:py-24 bg-slate-50 border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">Dampak Nyata untuk Kamu</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-slate-200">
                <div class="text-center py-8 md:py-0 px-4">
                    <p class="text-4xl md:text-5xl font-extrabold text-brand mb-2">10k+</p>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-3">Pengguna Aktif</p>
                    <p class="text-sm text-slate-500 font-medium max-w-xs mx-auto">Bergabung dengan komunitas pembelajaran yang berdedikasi.</p>
                </div>
                <div class="text-center py-8 md:py-0 px-4">
                    <p class="text-4xl md:text-5xl font-extrabold text-brand mb-2">50k+</p>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-3">Jurnal Ditulis</p>
                    <p class="text-sm text-slate-500 font-medium max-w-xs mx-auto">Ribuan pikiran yang terorganisir dan refleksi yang bermakna.</p>
                </div>
                <div class="text-center py-8 md:py-0 px-4">
                    <p class="text-4xl md:text-5xl font-extrabold text-brand mb-2">100+</p>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-3">Artikel Baru</p>
                    <p class="text-sm text-slate-500 font-medium max-w-xs mx-auto">Setiap minggu, konten segar untuk memicu rasa ingin tahu Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 md:py-24 bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="cta-container p-12 md:p-20 text-center text-white shadow-2xl">
                <!-- Decorative Circles -->
                <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/4 w-[500px] h-[500px] rounded-full border-[40px] border-white/5 pointer-events-none"></div>
                <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-[45%] w-[350px] h-[350px] rounded-full border-[40px] border-white/5 pointer-events-none"></div>
                
                <div class="relative z-10 max-w-2xl mx-auto">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold mb-6 leading-tight tracking-tight text-white">Siap Memulai Perjalanan Belajarmu?</h2>
                    <p class="text-lg text-indigo-100 mb-10 font-medium">
                        Wujudkan potensi penuhmu dengan refleksi harian yang konsisten. Daftar sekarang secara gratis.
                    </p>
                    <a href="{{ route('register') }}" class="inline-block px-10 py-4 rounded-xl bg-white text-brand font-bold text-lg hover:bg-slate-50 hover:shadow-xl transition-all duration-300">
                        Buat Akun MindLog
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-50 border-t border-slate-200 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex flex-col items-center md:items-start gap-2">
                <span class="text-xl font-extrabold text-brand tracking-tight">MindLog</span>
                <p class="text-slate-500 text-xs font-medium">
                    &copy; {{ date('Y') }} MindLog. Empowering learners through reflection.
                </p>
            </div>
            
            <div class="flex flex-wrap justify-center items-center gap-6">
                <a href="#" class="text-slate-500 hover:text-slate-900 transition-colors text-sm font-semibold">Privacy Policy</a>
                <a href="#" class="text-slate-500 hover:text-slate-900 transition-colors text-sm font-semibold">Terms of Service</a>
                <a href="#" class="text-slate-500 hover:text-slate-900 transition-colors text-sm font-semibold">Help Center</a>
                <a href="#" class="text-slate-500 hover:text-slate-900 transition-colors text-sm font-semibold">Contact Us</a>
                <a href="#" class="text-slate-500 hover:text-slate-900 transition-colors text-sm font-semibold">Careers</a>
            </div>
        </div>
    </footer>
</body>
</html>
