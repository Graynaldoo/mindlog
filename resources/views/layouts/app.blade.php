<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MindLog EduSmart')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f6f7f9; }
        .card-shadow { box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06); }
    </style>
</head>
<body class="min-h-full text-slate-900">
    <x-navbar />

    <div class="mx-auto flex max-w-7xl gap-6 px-4 py-6 sm:px-6 lg:px-8">
        <x-sidebar />
        <main class="min-w-0 flex-1">
            <x-alert />
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
