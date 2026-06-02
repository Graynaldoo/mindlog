<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Buat Akun Baru ✨</h2>
        <p class="mt-2 text-sm font-medium text-slate-500">Bergabunglah dan mulai perjalanan belajar digital Anda.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="input-label">{{ __('Nama Lengkap') }}</label>
            <input id="name" class="input" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="input-label">{{ __('Email') }}</label>
            <input id="email" class="input" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="user@mindlog.test" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="input-label">{{ __('Password') }}</label>
            <input id="password" class="input" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="input-label">{{ __('Konfirmasi Password') }}</label>
            <input id="password_confirmation" class="input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" class="btn btn-primary w-full text-base py-3">
                {{ __('Daftar Sekarang') }}
            </button>
        </div>

        <p class="text-center text-sm font-medium text-slate-500 mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-700 transition-colors">Masuk di sini</a>
        </p>
    </form>
</x-guest-layout>
