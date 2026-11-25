@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8 max-w-3xl">

    <a href="{{ route('penjual.products.index') }}"
       class="text-amber-900 mb-5 inline-block">
        ← Kembali ke Produk Saya
    </a>

    <div class="bg-white rounded-xl shadow p-6">

        @if($product->image)
            <img src="{{ asset('storage/'.$product->image) }}"
                 class="w-full max-h-96 object-contain rounded-lg mb-5"
                 alt="{{ $product->name }}">
        @endif

        <h1 class="text-2xl font-bold text-amber-950">
            {{ $product->name }}
        </h1>

        <p class="text-xl font-semibold text-amber-800 my-3">
            Rp{{ number_format($product->price, 0, ',', '.') }}
        </p>

        <p class="text-gray-700 mb-4">
            {{ $product->description }}
        </p>

        <div class="space-y-2">
            <p><strong>Kategori:</strong> {{ $product->category }}</p>
            <p><strong>Kondisi:</strong> {{ $product->condition }}</p>
            <p><strong>Stok:</strong> {{ $product->stock }}</p>
            <p><strong>Status:</strong> {{ $product->status }}</p>
        </div>

        @if($product->status !== 'sold')
            <a href="{{ route('penjual.products.edit', $product) }}"
               class="inline-block mt-6 bg-amber-900 text-white px-5 py-3 rounded-lg">
                Edit Produk
            </a>
        @endif

    </div>
</div>
@endsection