<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class PenjualOrderController extends Controller
{
    // Semua pesanan yang isinya ada barang milik penjual ini
    public function index(Request $request): View
    {
        $penjualId = $request->user()->id;

        $orders = Order::whereHas('items', function ($q) use ($penjualId) {
                $q->where('penjual_id', $penjualId);
            })
            ->with(['pembeli', 'items' => function ($q) use ($penjualId) {
                $q->where('penjual_id', $penjualId);
            }])
            ->latest()
            ->paginate(10);

        return view('penjual.orders.index', compact('orders'));
    }

    // Tandai pesanan sudah dikirim
    public function kirim(Request $request, Order $order): RedirectResponse
    {
        $penjualId = $request->user()->id;

        // Pastikan order ini memang mengandung barang milik penjual yang login
        $adaBarangMilikPenjual = $order->items()->where('penjual_id', $penjualId)->exists();
        abort_unless($adaBarangMilikPenjual, 403);

        abort_unless($order->status === Order::DIBAYAR, 400, 'Pesanan belum dibayar atau sudah diproses.');

        $order->update(['status' => Order::DIKIRIM]);

        return back()->with('success', 'Pesanan ditandai sudah dikirim.');
    }
}