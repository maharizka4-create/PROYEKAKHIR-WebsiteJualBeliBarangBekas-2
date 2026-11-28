@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8 max-w-2xl">

    <h1 class="text-2xl font-bold text-amber-950 mb-6">Detail Produk</h1>

    <div class="bg-white rounded-xl shadow p-6 space-y-3">

        @if ($product->image)
            <img
                src="{{ asset('storage/'.$product->image) }}"
                class="w-48 h-48 object-cover rounded-lg"
                alt="Foto produk">
        @endif

        <p>
            <strong>Nama:</strong>
            {{ $product->name }}
        </p>

        <p>
            <strong>Kategori:</strong>
            {{ $product->category ?: '-' }}
        </p>

        <p>
            <strong>Kondisi:</strong>
            {{ $product->condition
                ? str_replace('_', ' ', ucfirst($product->condition))
                : '-' }}
        </p>

        <p>
            <strong>Harga:</strong>
            Rp{{ number_format($product->price ?? 0, 0, ',', '.') }}
        </p>

        <p>
            <strong>Stok:</strong>
            {{ $product->stock ?? 0 }}
        </p>

        <p>
            <strong>Deskripsi:</strong>
            {{ $product->description ?: '-' }}
        </p>

        <p>
            <strong>Status:</strong>

            @if ($product->status === 'approved')
                <span class="text-green-700 font-semibold">Disetujui</span>
            @elseif ($product->status === 'rejected')
                <span class="text-red-700 font-semibold">Ditolak</span>
            @elseif ($product->status === 'pending')
                <span class="text-yellow-700 font-semibold">Menunggu</span>
            @else
                <span class="text-gray-600">Tidak diketahui</span>
            @endif
        </p>

        <a
            href="{{ route('penjual.products.index') }}"
            class="inline-block mt-4 text-blue-700">
            &larr; Kembali ke daftar produk
        </a>

    </div>
</div>
@endsection
