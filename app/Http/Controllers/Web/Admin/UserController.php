<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\UserRepositoryInterface;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private UserRepositoryInterface $users) {}

    public function index()
    {
        abort_unless(auth()->user()->can('manage-users'), 403);

        return view('admin.users.index', [
            'users' => $this->users->paginate(15),
            'roles' => Role::orderBy('display_name')->get(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        abort_unless(auth()->user()->can('manage-users'), 403);

        $data = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $this->users->update($user, $data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        abort_unless(auth()->user()->can('manage-users'), 403);
        abort_if($user->id === auth()->id(), 422, 'Admin tidak dapat menghapus akun sendiri.');

        $this->users->delete($user);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
