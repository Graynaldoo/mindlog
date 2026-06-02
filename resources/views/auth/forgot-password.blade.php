<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Lupa Password? 🔐</h2>
        <p class="mt-2 text-sm font-medium text-slate-500 leading-relaxed">
            {{ __('Jangan khawatir. Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mereset password.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="input-label">{{ __('Email Akun Anda') }}</label>
            <input id="email" class="input" type="email" name="email" :value="old('email')" required autofocus placeholder="user@mindlog.test" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" class="btn btn-primary w-full text-base py-3">
                {{ __('Kirim Tautan Reset Password') }}
            </button>
        </div>

        <p class="text-center text-sm font-medium text-slate-500 mt-6">
            <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-700 transition-colors flex items-center justify-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                </svg>
                Kembali ke halaman Login
            </a>
        </p>
    </form>
</x-guest-layout>
