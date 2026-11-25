<?php

namespace App\Http\Controllers;

use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Arahkan pengguna ke dashboard sesuai role.
     */
    public function index()
    {
        return redirect()->route(
            auth()->user()->dashboardRoute()
        );
    }

    /**
     * Dashboard Admin.
     */
    public function admin()
    {
        return view('dashboard.admin', [
            'totalUser' => User::role(User::ROLE_USER)->count(),
            'totalPenjual' => User::role(User::ROLE_PENJUAL)->count(),
            'latestUsers' => User::with('roles')
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }

    /**
     * Dashboard Penjual.
     */
    public function penjual()
    {
        return view('dashboard.penjual');
    }

    /**
     * Dashboard Pembeli.
     */
    public function user()
    {
        return view('dashboard.user', [
            'user' => auth()->user(),
        ]);
    }
}