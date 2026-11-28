@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8 max-w-2xl">

    <h1 class="text-2xl font-bold text-amber-950 mb-6">
        Ubah Produk
    </h1>

    @if ($product->status === 'rejected')
        <div class="bg-red-100 text-red-800 p-3 rounded mb-5">
            Produk ini ditolak oleh Admin. Silakan periksa kembali
            informasi produk sebelum menyimpan perubahan.
        </div>
    @elseif ($product->status === 'approved')
        <div class="bg-green-100 text-green-800 p-3 rounded mb-5">
            Produk ini sudah disetujui. Jika kamu mengubahnya,
            produk akan kembali menunggu persetujuan Admin.
        </div>
    @endif

    <form
        action="{{ route('penjual.products.update', $product) }}"
        method="POST"
        enctype="multipart/form-data"
        class="bg-white rounded-xl shadow p-6 space-y-5">

        @csrf
        @method('PUT')

        @include('penjual.products.form')

        <div class="flex gap-3 pt-2">
            <button
                type="submit"
                class="bg-amber-900 text-white px-5 py-3 rounded-lg">
                Simpan Perubahan
            </button>

            <a
                href="{{ route('penjual.products.index') }}"
                class="px-5 py-3 rounded-lg bg-gray-200">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
