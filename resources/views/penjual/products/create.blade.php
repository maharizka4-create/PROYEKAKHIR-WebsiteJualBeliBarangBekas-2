@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8 max-w-3xl">

    <h1 class="text-2xl font-bold text-amber-950 mb-6">
        Tambah Produk
    </h1>

    <form action="{{ route('penjual.products.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="bg-white p-6 rounded-xl shadow space-y-5">

        @csrf

        @include('penjual.products.form')

        <button type="submit"
                class="bg-amber-900 text-white px-6 py-3 rounded-lg">
            Simpan Produk
        </button>

        <a href="{{ route('penjual.products.index') }}"
           class="text-gray-600 ml-3">
            Batal
        </a>

    </form>
</div>
@endsection