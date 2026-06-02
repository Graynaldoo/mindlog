@extends('layouts.app')
@section('title', 'Kelola Pengguna - MindLog EduSmart')

@section('content')
<div class="space-y-6 max-w-6xl mx-auto animate-fade-in">
    {{-- Header --}}
    <div class="card p-6 md:p-8 flex flex-col md:flex-row md:items-center justify-between gap-6 bg-white">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-rose-50 border border-rose-100 mb-3">
                <span class="text-[11px] font-bold tracking-wide text-rose-700 uppercase">Administrator System</span>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Manajemen Pengguna</h1>
            <p class="text-sm font-medium text-slate-500 mt-2 max-w-2xl leading-relaxed">
                Kelola hak akses dan informasi pengguna platform MindLog EduSmart. Admin dapat mengubah role antara Admin, Educator, dan User.
            </p>
        </div>
        <div class="flex-shrink-0 text-center md:text-right">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-rose-500 to-pink-600 text-white flex items-center justify-center text-2xl font-extrabold shadow-lg shadow-rose-200 mx-auto md:ml-auto md:mr-0 mb-2">
                {{ $users->total() }}
            </div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total User</span>
        </div>
    </div>

    {{-- Users Table --}}
    <div class="card bg-white overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500 border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-4">Informasi Pengguna</th>
                        <th scope="col" class="px-6 py-4">Hak Akses (Role)</th>
                        <th scope="col" class="px-6 py-4 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($users as $user)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                                @csrf
                                @method('PUT')
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-2">
                                        <input name="name" value="{{ old('name', $user->name) }}" class="input !py-2 !px-3 text-sm font-bold text-slate-800 bg-transparent border-transparent hover:border-slate-200 focus:bg-white transition-all w-full md:w-64">
                                        <input name="email" value="{{ old('email', $user->email) }}" class="input !py-1.5 !px-3 text-xs text-slate-500 bg-transparent border-transparent hover:border-slate-200 focus:bg-white transition-all w-full md:w-64">
                                    </div>
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <select name="role_id" class="input !py-2 !px-3 text-sm font-bold text-slate-700 bg-slate-50 border-slate-200 w-full md:w-40 cursor-pointer">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" @selected($user->role_id === $role->id)>{{ $role->display_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        <span class="text-[10px] font-bold text-rose-500 mt-1 block">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td class="px-6 py-4 align-top text-right">
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <button type="submit" class="btn btn-primary btn-sm" title="Simpan Perubahan">
                                            Simpan
                                        </button>
                            </form>
                                        @if($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Yakin hapus pengguna ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus Pengguna">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
