<?php

namespace App\Http\Controllers;

use App\Models\User;

class DashboardController extends Controller
{
    /** Arahkan ke dashboard sesuai role */
    public function index()
    {
        return redirect()->route(auth()->user()->dashboardRoute());
    }

    public function admin()
    {
        return view('dashboard.admin', [
            'totalUser'    => User::role(User::ROLE_USER)->count(),
            'totalPenjual' => User::role(User::ROLE_PENJUAL)->count(),
            'latestUsers'  => User::with('roles')->latest()->take(5)->get(),
        ]);
    }
    public function penjual()
    {
        return view('dashboard.penjual');
    }

    public function user()
    {
        return view('dashboard.user');
    }
}