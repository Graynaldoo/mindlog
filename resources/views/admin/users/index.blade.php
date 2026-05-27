@extends('layouts.app')

@section('title', 'Kelola User - MindLog EduSmart')

@section('content')
<div class="space-y-5">
    <div class="rounded-lg border border-slate-200 bg-white p-5 card-shadow">
        <h1 class="text-2xl font-extrabold">Kelola User</h1>
        <p class="mt-1 text-sm font-medium text-slate-600">Admin dapat mengubah role Admin, Educator, dan User.</p>
    </div>

    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white card-shadow">
        <table class="w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-extrabold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($users as $user)
                    <tr>
                        <form method="POST" action="{{ route('admin.users.update', $user) }}">
                            @csrf
                            @method('PUT')
                            <td class="px-4 py-3"><input name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-md border-slate-300 text-sm"></td>
                            <td class="px-4 py-3"><input name="email" value="{{ old('email', $user->email) }}" class="w-full rounded-md border-slate-300 text-sm"></td>
                            <td class="px-4 py-3">
                                <select name="role_id" class="w-full rounded-md border-slate-300 text-sm">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" @selected($user->role_id === $role->id)>{{ $role->display_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <button class="rounded-md border border-slate-200 px-3 py-1 font-bold">Simpan</button>
                        </form>
                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="rounded-md border border-red-200 px-3 py-1 font-bold text-red-700">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $users->links() }}
</div>
@endsection
