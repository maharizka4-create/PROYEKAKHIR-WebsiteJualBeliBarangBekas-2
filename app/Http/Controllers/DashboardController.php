<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return redirect()->route(
            auth()->user()->dashboardRoute()
        );
    }

    public function admin()
    {
        return view('dashboard.admin', [
            // Role user dan pembeli dihitung sebagai pembeli
            'totalPembeli' => User::role(['user', 'pembeli'])->count(),

            'totalPenjual' => User::role('penjual')->count(),

            'totalBarang' => Product::count(),

            'menungguVerifikasi' => Product::where(
                'status',
                Product::MENUNGGU
            )->count(),

            'totalPesanan' => Order::count(),

            'pendapatan' => Order::whereIn('status', [
                Order::DIBAYAR,
                Order::DIKIRIM,
                Order::SELESAI,
            ])->sum('total_harga'),

            'barangMenunggu' => Product::with('penjual')
                ->where('status', Product::MENUNGGU)
                ->latest()
                ->take(5)
                ->get(),

            'barangTerbaru' => Product::with('penjual')
                ->latest()
                ->take(5)
                ->get(),

            'latestUsers' => User::with('roles')
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }

    public function penjual()
    {
        $user = auth()->user();

        $produk = Product::where('user_id', $user->id);

        $totalProduk = (clone $produk)->count();

        $produkDisetujui = (clone $produk)
            ->where('status', Product::DISETUJUI)
            ->count();

        $produkMenunggu = (clone $produk)
            ->where('status', Product::MENUNGGU)
            ->count();

        $produkDitolak = (clone $produk)
            ->where('status', Product::DITOLAK)
            ->count();

        $produkTerbaru = (clone $produk)
            ->latest()
            ->take(5)
            ->get();

        $totalPesanan = \Illuminate\Support\Facades\DB::table('order_items')
            ->where('penjual_id', $user->id)
            ->distinct()
            ->count('order_id');

        return view('dashboard.penjual', compact(
            'totalProduk',
            'produkDisetujui',
            'produkMenunggu',
            'produkDitolak',
            'produkTerbaru',
            'totalPesanan'
        ));
    }

    public function user()
    {
        return view('dashboard.user', [
            'user' => auth()->user(),
        ]);
    }
}