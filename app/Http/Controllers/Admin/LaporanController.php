<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'dari' => ['nullable', 'date'],
            'sampai' => ['nullable', 'date', 'after_or_equal:dari'],
            'status' => [
                'nullable',
                'in:' . implode(',', [
                    Order::MENUNGGU_PEMBAYARAN,
                    Order::DIBAYAR,
                    Order::DIKIRIM,
                    Order::SELESAI,
                    Order::DIBATALKAN,
                ]),
            ],
        ], [
            'sampai.after_or_equal' =>
                'Tanggal sampai tidak boleh lebih awal dari tanggal dari.',
        ]);

        $statusPendapatan = [
            Order::DIBAYAR,
            Order::DIKIRIM,
            Order::SELESAI,
        ];

        $query = Order::query()
            ->when($request->filled('dari'), function ($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->dari);
            })
            ->when($request->filled('sampai'), function ($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->sampai);
            })
            ->when($request->filled('status'), function ($q) use ($request) {
                $q->where('status', $request->status);
            });

        $jumlahPesanan = (clone $query)->count();

        $pendapatan = (clone $query)
            ->whereIn('status', $statusPendapatan)
            ->sum('total_harga');

        $perStatus = (clone $query)
            ->selectRaw('status, COUNT(*) as jumlah')
            ->groupBy('status')
            ->pluck('jumlah', 'status');

        $orders = $query
            ->with(['pembeli', 'items'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.laporan.index', compact(
            'orders',
            'jumlahPesanan',
            'pendapatan',
            'perStatus'
        ));
    }
}