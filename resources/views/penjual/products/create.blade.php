@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8 max-w-2xl">
    <h1 class="text-2xl font-bold text-amber-950 mb-6">Tambah Produk</h1>

    <form action="{{ route('penjual.products.store') }}" method="POST"
          enctype="multipart/form-data" class="bg-white rounded-xl shadow p-6 space-y-5">
        @csrf

        @include('penjual.products.form')

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-amber-900 text-white px-5 py-3 rounded-lg">
                Simpan Produk
            </button>
            <a href="{{ route('penjual.products.index') }}" class="px-5 py-3 rounded-lg bg-gray-200">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection