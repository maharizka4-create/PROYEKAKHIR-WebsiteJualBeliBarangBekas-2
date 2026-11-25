<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SellerActivationController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Pastikan hanya pembeli yang dapat mengaktifkan penjual.
        abort_unless($user->hasRole('pembeli'), 403);

        // Tambahkan role penjual tanpa menghapus role pembeli.
        if (! $user->hasRole('penjual')) {
            $user->assignRole('penjual');
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'Akun penjual berhasil diaktifkan!');
    }
}