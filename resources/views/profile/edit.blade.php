@extends('layouts.app')
@section('title', 'Profil Saya')

@section('content')
<div class="max-w-2xl mx-auto">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="font-display text-4xl text-gray-900">Profil Saya</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola informasi akun kamu</p>
    </div>

    {{-- Avatar & Update Profile --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-5">

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('patch')

            @if(session('status') === 'profile-updated')
                <div class="mb-5 px-4 py-3 bg-green-50 border border-green-100 text-green-700 text-sm rounded-xl flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Profil berhasil diperbarui!
                </div>
            @endif

            {{-- Foto Profil --}}
            <div class="flex items-start gap-5 mb-6 pb-6 border-b border-gray-100">
                <div class="relative flex-shrink-0">
                    <div class="w-20 h-20 rounded-2xl overflow-hidden shadow-md">
                        @if(auth()->user()->avatar)
                            <img id="avatar-preview"
                                 src="{{ Storage::url(auth()->user()->avatar) }}"
                                 alt="Foto Profil"
                                 class="w-full h-full object-cover">
                        @else
                            <div id="avatar-placeholder"
                                 class="w-full h-full bg-gradient-to-br from-violet-500 to-purple-600
                                        flex items-center justify-center text-white font-bold text-3xl">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <img id="avatar-preview" src="" alt="" class="w-full h-full object-cover hidden">
                        @endif
                    </div>

                    {{-- Badge kamera --}}
                    <label for="avatar"
                           class="absolute -bottom-1 -right-1 w-7 h-7 bg-violet-600 hover:bg-violet-700
                                  rounded-xl flex items-center justify-center cursor-pointer
                                  shadow-md shadow-violet-200 transition-colors">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </label>
                </div>

                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-900 mb-1">Foto Profil</p>
                    <p class="text-xs text-gray-400 mb-3">JPG, PNG atau GIF. Maks 2MB.</p>
                    <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden"
                           onchange="previewAvatar(this)">
                    <label for="avatar"
                           class="inline-flex items-center gap-2 px-3 py-2 bg-gray-100 hover:bg-gray-200
                                  text-gray-700 text-xs font-medium rounded-lg cursor-pointer transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Pilih Foto
                    </label>
                    <p id="file-name" class="text-xs text-gray-400 mt-2 hidden"></p>
                    @error('avatar')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama</label>
                    <input type="text" id="name" name="name"
                           value="{{ old('name', auth()->user()->name) }}"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200
                                  focus:outline-none focus:ring-2 focus:ring-violet-400 focus:border-transparent bg-white text-gray-900">
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email', auth()->user()->email) }}"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200
                                  focus:outline-none focus:ring-2 focus:ring-violet-400 focus:border-transparent bg-white text-gray-900">
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <button type="submit"
                        class="px-6 py-3 bg-violet-600 hover:bg-violet-700 text-white font-semibold rounded-xl transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    {{-- Update Password --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-5">
        <h3 class="text-base font-semibold text-gray-900 mb-5">Ubah Password</h3>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('put')
            @if(session('status') === 'password-updated')
                <div class="mb-4 px-4 py-3 bg-green-50 border border-green-100 text-green-700 text-sm rounded-xl">
                    Password berhasil diperbarui!
                </div>
            @endif
            <div class="space-y-4">
                <div>
                    <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">Password Saat Ini</label>
                    <input type="password" id="current_password" name="current_password"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-violet-400 bg-white">
                    @error('current_password', 'updatePassword')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
                    <input type="password" id="password" name="password"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-violet-400 bg-white">
                    @error('password', 'updatePassword')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-violet-400 bg-white">
                </div>
            </div>
            <div class="mt-6">
                <button type="submit"
                        class="px-6 py-3 bg-gray-800 hover:bg-gray-900 text-white font-semibold rounded-xl transition-colors">
                    Ubah Password
                </button>
            </div>
        </form>
    </div>

    {{-- Danger Zone --}}
    <div class="bg-white rounded-2xl border border-red-100 shadow-sm p-6">
        <h3 class="text-base font-semibold text-red-600 mb-2">Hapus Akun</h3>
        <p class="text-sm text-gray-500 mb-5">Setelah akun dihapus, semua data termasuk jurnal tidak bisa dipulihkan.</p>
        <form method="POST" action="{{ route('profile.destroy') }}"
              onsubmit="return confirm('Yakin hapus akun? Semua data akan hilang permanen!')">
            @csrf
            @method('delete')
            <div class="mb-4">
                <label for="del_password" class="block text-sm font-semibold text-gray-700 mb-2">Masukkan password untuk konfirmasi</label>
                <input type="password" id="del_password" name="password" placeholder="Password kamu"
                       class="w-full px-4 py-3 rounded-xl border border-red-200 focus:outline-none focus:ring-2 focus:ring-red-300 bg-white">
                @error('password', 'userDeletion')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit"
                    class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-xl transition-colors">
                Hapus Akun Saya
            </button>
        </form>
    </div>

</div>

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileName = document.getElementById('file-name');
        fileName.textContent = file.name;
        fileName.classList.remove('hidden');
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatar-preview');
            const placeholder = document.getElementById('avatar-placeholder');
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }
}
</script>
@endsection