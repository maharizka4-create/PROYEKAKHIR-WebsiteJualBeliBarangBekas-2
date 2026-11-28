<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->with('roles')
            ->when($request->filled('q'), function ($query) use ($request) {
                $kataKunci = $request->q;

                $query->where(function ($w) use ($kataKunci) {
                    $w->where('name', 'like', "%{$kataKunci}%")
                      ->orWhere('email', 'like', "%{$kataKunci}%");
                });
            })
            ->when(
                in_array($request->role, User::ROLES, true),
                function ($query) use ($request) {
                    $query->role($request->role);
                }
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function toggle(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with(
                'error',
                'Tidak bisa menonaktifkan akun sendiri.'
            );
        }

        $user->update([
            'is_active' => ! $user->is_active,
        ]);

        return back()->with(
            'status',
            'Status akun berhasil diperbarui.'
        );
    }

    public function updateRole(Request $request, User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with(
                'error',
                'Tidak bisa mengubah role akun sendiri.'
            );
        }

        $data = $request->validate([
            'role' => [
                'required',
                Rule::in(User::ROLES),
            ],
        ]);

        $user->syncRoles([$data['role']]);

        return back()->with(
            'status',
            'Role pengguna berhasil diperbarui.'
        );
    }
}