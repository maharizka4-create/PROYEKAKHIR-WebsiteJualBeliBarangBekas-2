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
            'status' => ['nullable', 'in:menunggu_pembayaran,dibayar,dikirim,selesai,dibatalkan'],
        ], [
            'sampai.after_or_equal' => 'Tanggal sampai tidak boleh lebih awal dari tanggal dari.',
        ]);

        // Pesanan yang dihitung sebagai pendapatan (sudah dibayar)
        $statusPendapatan = [Order::DIBAYAR, Order::DIKIRIM, Order::SELESAI];

        $query = Order::query()
            ->when($request->dari, fn ($q, $dari) => $q->whereDate('created_at', '>=', $dari))
            ->when($request->sampai, fn ($q, $sampai) => $q->whereDate('created_at', '<=', $sampai))
            ->when($request->status, fn ($q, $status) => $q->where('status', $status));

        $jumlahPesanan = (clone $query)->count();

        $pendapatan = (clone $query)
            ->whereIn('status', $statusPendapatan)
            ->sum('total_harga');

        $perStatus = (clone $query)
            ->selectRaw('status, count(*) as jumlah')
            ->groupBy('status')
            ->pluck('jumlah', 'status');

        $orders = $query
            ->with(['pembeli', 'items'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.laporan.index', compact('orders', 'jumlahPesanan', 'pendapatan', 'perStatus'));
    }
}