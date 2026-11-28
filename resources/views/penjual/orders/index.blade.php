@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-2xl font-bold text-amber-950 mb-6">Pesanan Masuk</h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-5">{{ session('success') }}</div>
    @endif

    @forelse ($orders as $order)
    <div class="bg-white rounded-xl shadow p-5 mb-4">
        <div class="flex justify-between items-start">
            <div>
                <p class="font-semibold">{{ $order->kode }}</p>
                <p class="text-sm text-gray-600">Pembeli: {{ $order->pembeli->name }}</p>
                <p class="text-sm text-gray-600">Kirim ke: {{ $order->alamat_pengiriman }}</p>
            </div>
            <span class="px-3 py-1 text-xs rounded-full
                @class([
                    'bg-yellow-100 text-yellow-700' => $order->status === 'dibayar',
                    'bg-purple-100 text-purple-700' => $order->status === 'dikirim',
                    'bg-green-100 text-green-700' => $order->status === 'selesai',
                    'bg-gray-100 text-gray-700' => $order->status === 'menunggu_pembayaran',
                ])">
                {{ str_replace('_', ' ', ucfirst($order->status)) }}
            </span>
        </div>

        <ul class="mt-3 text-sm list-disc list-inside">
            @foreach ($order->items as $item)
                <li>{{ $item->nama_barang }} x{{ $item->jumlah }} — Rp{{ number_format($item->subtotal, 0, ',', '.') }}</li>
            @endforeach
        </ul>

        @if ($order->status === 'dibayar')
            <form action="{{ route('penjual.orders.kirim', $order) }}" method="POST" class="mt-3 inline"
                  onsubmit="return confirm('Tandai pesanan ini sudah dikirim?')">
                @csrf
                @method('PATCH')
                <button class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm">
                    Tandai Dikirim
                </button>
            </form>
        @endif
    </div>
    @empty
    <p class="text-center text-gray-500 py-10">Belum ada pesanan masuk.</p>
    @endforelse

    {{ $orders->links() }}
</div>
@endsection