@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-amber-950">Produk Saya</h1>
            <p class="text-gray-600">Kelola barang bekas yang kamu jual di SEKENOVA.</p>
        </div>

        <a href="{{ route('penjual.products.create') }}"
           class="bg-amber-900 text-white px-5 py-3 rounded-lg">
            + Tambah Produk
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-5">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-amber-100">
                <tr>
                    <th class="p-4">Nama Produk</th>
                    <th class="p-4">Kategori</th>
                    <th class="p-4">Harga</th>
                    <th class="p-4">Kondisi</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($products as $product)
                    <tr class="border-b">
                        <td class="p-4">
                            {{ $product->name }}
                        </td>

                        <td class="p-4">
                            {{ $product->category ?: '-' }}
                        </td>

                        <td class="p-4">
                            Rp{{ number_format($product->price ?? 0, 0, ',', '.') }}
                        </td>

                        <td class="p-4">
                            {{ $product->condition
                                ? str_replace('_', ' ', ucfirst($product->condition))
                                : '-' }}
                        </td>

                        <td class="p-4">
                            @if ($product->status === 'approved')
                                <span class="text-green-700 font-semibold">Disetujui</span>
                            @elseif ($product->status === 'pending')
                                <span class="text-yellow-700 font-semibold">Menunggu</span>
                            @elseif ($product->status === 'rejected')
                                <span class="text-red-700 font-semibold">Ditolak</span>
                            @else
                                <span class="text-gray-600">Tidak diketahui</span>
                            @endif
                        </td>

                        <td class="p-4">
                            <div class="flex gap-2">
                                <a href="{{ route('penjual.products.show', $product) }}"
                                   class="text-blue-700">
                                    Detail
                                </a>

                                <a href="{{ route('penjual.products.edit', $product) }}"
                                   class="text-amber-800">
                                    Edit
                                </a>

                                <form
                                    action="{{ route('penjual.products.destroy', $product) }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-red-600">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500">
                            Belum ada produk yang ditambahkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $products->links() }}
    </div>

</div>
@endsection
