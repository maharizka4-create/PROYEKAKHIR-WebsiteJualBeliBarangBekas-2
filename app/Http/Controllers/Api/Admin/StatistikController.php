<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class StatistikController extends Controller
{
    // GET /api/admin/statistik
    public function index()
    {
        return response()->json([
            'data' => [
                'total_pembeli' => User::role(User::ROLE_USER)->count(),
                'total_penjual' => User::role(User::ROLE_PENJUAL)->count(),
                'total_barang' => Product::count(),
                'menunggu_verifikasi' => Product::where('status_persetujuan', Product::MENUNGGU)->count(),
                'total_transaksi' => Order::count(),
                'pendapatan' => (int) Order::whereIn('status', [Order::DIBAYAR, Order::DIKIRIM, Order::SELESAI])
                    ->sum('total_harga'),
            ],
        ]);
    }
}