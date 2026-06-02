@extends('layouts.app')
@section('title', 'Profil Saya')

@section('content')
<div class="max-w-2xl mx-auto animate-fade-in space-y-6">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Pengaturan Profil</h1>
        <p class="text-sm font-medium text-slate-500 mt-1">Kelola informasi akun dan preferensi Anda.</p>
    </div>

    {{-- Avatar & Update Profile --}}
    <div class="card p-6 md:p-8">
        <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
            Informasi Personal
        </h3>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('patch')

            @if(session('status') === 'profile-updated')
                <div class="px-4 py-3 bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-bold rounded-xl flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                    </svg>
                    Profil berhasil diperbarui!
                </div>
            @endif

            {{-- Foto Profil --}}
            <div class="flex items-start gap-6 pb-6 border-b border-slate-100">
                <div class="relative flex-shrink-0 group">
                    <div class="w-24 h-24 rounded-2xl overflow-hidden shadow-sm border border-slate-200">
                        @if(auth()->user()->avatar)
                            <img id="avatar-preview"
                                 src="{{ Storage::url(auth()->user()->avatar) }}"
                                 alt="Foto Profil"
                                 class="w-full h-full object-cover">
                        @else
                            <div id="avatar-placeholder"
                                 class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-400 font-extrabold text-3xl">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <img id="avatar-preview" src="" alt="" class="w-full h-full object-cover hidden">
                        @endif
                    </div>

                    {{-- Badge kamera --}}
                    <label for="avatar"
                           class="absolute -bottom-2 -right-2 w-8 h-8 bg-indigo-600 hover:bg-indigo-700
                                  rounded-xl flex items-center justify-center cursor-pointer
                                  shadow-md shadow-indigo-200 transition-transform group-hover:scale-110">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"/>
                        </svg>
                    </label>
                </div>

                <div class="flex-1 pt-2">
                    <p class="text-sm font-bold text-slate-800 mb-1">Foto Profil Baru</p>
                    <p class="text-xs font-medium text-slate-500 mb-4">Format JPG, PNG atau GIF. Maksimal ukuran 2MB.</p>
                    <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden"
                           onchange="previewAvatar(this)">
                    <label for="avatar" class="btn btn-secondary btn-sm cursor-pointer inline-flex">
                        Pilih Foto
                    </label>
                    <p id="file-name" class="text-xs font-bold text-indigo-600 mt-2 hidden"></p>
                    @error('avatar')
                        <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label for="name" class="input-label">Nama Lengkap</label>
                    <input type="text" id="name" name="name"
                           value="{{ old('name', auth()->user()->name) }}"
                           class="input">
                    @error('name')
                        <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="input-label">Alamat Email</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email', auth()->user()->email) }}"
                           class="input">
                    @error('email')
                        <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="btn btn-primary px-8">
                    Simpan Profil
                </button>
            </div>
        </form>
    </div>

    {{-- Update Password --}}
    <div class="card p-6 md:p-8">
        <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
            Keamanan Sandi
        </h3>
        
        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            @method('put')
            
            @if(session('status') === 'password-updated')
                <div class="px-4 py-3 bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-bold rounded-xl mb-4">
                    Password berhasil diperbarui!
                </div>
            @endif
            
            <div>
                <label for="current_password" class="input-label">Password Saat Ini</label>
                <input type="password" id="current_password" name="current_password" class="input">
                @error('current_password', 'updatePassword')
                    <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="password" class="input-label">Password Baru</label>
                <input type="password" id="password" name="password" class="input">
                @error('password', 'updatePassword')
                    <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="password_confirmation" class="input-label">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="input">
            </div>
            
            <div class="pt-4 flex justify-end">
                <button type="submit" class="btn btn-secondary px-8">
                    Perbarui Password
                </button>
            </div>
        </form>
    </div>

    {{-- Danger Zone --}}
    <div class="card p-6 md:p-8 border-rose-100 bg-rose-50/30">
        <h3 class="text-lg font-bold text-rose-600 mb-2 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            Zona Berbahaya
        </h3>
        <p class="text-sm font-medium text-slate-600 mb-6">
            Menghapus akun bersifat permanen. Semua data Anda, termasuk jurnal harian dan statistik, akan terhapus sepenuhnya.
        </p>
        
        <form method="POST" action="{{ route('profile.destroy') }}"
              onsubmit="return confirm('Apakah Anda benar-benar yakin ingin menghapus akun? Aksi ini tidak dapat dibatalkan.')"
              class="space-y-4">
            @csrf
            @method('delete')
            
            <div>
                <label for="del_password" class="input-label text-rose-700">Password Konfirmasi</label>
                <input type="password" id="del_password" name="password" placeholder="Masukkan password untuk verifikasi" class="input border-rose-200 focus:border-rose-400 focus:ring-rose-100">
                @error('password', 'userDeletion')
                    <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="pt-2">
                <button type="submit" class="btn btn-danger">
                    Hapus Akun Permanen
                </button>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileName = document.getElementById('file-name');
        fileName.textContent = 'File terpilih: ' + file.name;
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
@endpush
@endsection