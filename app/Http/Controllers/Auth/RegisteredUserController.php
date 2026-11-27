<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class,
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            // Admin tidak boleh mendaftar melalui form publik
            'role' => [
                'required',
                Rule::in([
                    User::ROLE_USER,
                    User::ROLE_PENJUAL,
                ]),
            ],

            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ]);

        // Membuat akun baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),

            // Akun baru otomatis aktif
            'is_active' => true,
        ]);

        // Memberikan role sesuai pilihan registrasi
        $user->assignRole($request->role);

        // Menjalankan event registrasi
        event(new Registered($user));

        // Login otomatis setelah registrasi
        Auth::login($user);

        // Regenerasi session untuk keamanan
        $request->session()->regenerate();

        // Redirect berdasarkan role pengguna
        return redirect()->route($user->dashboardRoute());
    }
}