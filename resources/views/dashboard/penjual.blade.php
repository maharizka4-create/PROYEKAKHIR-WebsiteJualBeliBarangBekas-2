
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-amber-950 leading-tight">
            Dashboard Penjual
        </h2>
    </x-slot>

    <div class="py-10 bg-stone-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Sapaan --}}
            <div class="bg-gradient-to-r from-amber-950 to-amber-700
                        rounded-2xl p-6 text-white shadow mb-8">
                <h1 class="text-2xl font-bold mb-2">
                    Halo, {{ auth()->user()->name }}!
                </h1>
                <p class="text-amber-100">
                    Selamat datang di dashboard penjual SEKENOVA.
                    Kelola produk dan pantau pesananmu di sini.
                </p>
            </div>

            {{-- Statistik --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">

                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-amber-800">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm">Total Produk</p>
                            <h3 class="text-3xl font-bold text-amber-950 mt-2">
                                {{ $totalProduk }}
                            </h3>
                        </div>
                        <span class="text-3xl">📦</span>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-600">
                    <div class="flex justify-between items-center">
                        <div>
                            </h3>
                            <p class="text-gray-500 text-sm">Produk Disetujui</p>
                            <h3 class="text-3xl font-bold text-green-700 mt-2">
                                {{ $produkDisetujui }}
                        </div>
                        <span class="text-3xl">✅</span>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm">Menunggu Verifikasi</p>
                            <h3 class="text-3xl font-bold text-yellow-600 mt-2">
                                {{ $produkMenunggu }}
                            </h3>
                        </div>
                        <span class="text-3xl">⏳</span>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm">Produk Ditolak</p>
                            <h3 class="text-3xl font-bold text-red-600 mt-2">
                                {{ $produkDitolak }}
                            </h3>
                        </div>
                        <span class="text-3xl">❌</span>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-600">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm">Pesanan Masuk</p>
                            <h3 class="text-3xl font-bold text-blue-700 mt-2">
                                {{ $totalPesanan }}
                            </h3>
                        </div>
                        <span class="text-3xl">🛍️</span>
                    </div>
                </div>

            </div>

            {{-- Tombol Aksi --}}
            <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                <h3 class="text-lg font-bold text-amber-950 mb-4">
                    Aksi Cepat
                </h3>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('penjual.products.create') }}"
                       class="bg-amber-900 hover:bg-amber-950 text-white
                              px-5 py-3 rounded-lg font-semibold transition">
                        + Tambah Produk
                    </a>

                    <a href="{{ route('penjual.products.index') }}"
                       class="bg-amber-100 hover:bg-amber-200 text-amber-950
                              px-5 py-3 rounded-lg font-semibold transition">
                        Kelola Produk
                    </a>
                </div>
            </div>

            {{-- Produk Terbaru --}}
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex flex-wrap justify-between items-center gap-3 mb-5">
                    <h3 class="text-lg font-bold text-amber-950">
                        Produk Terbaru
                    </h3>

                    <a href="{{ route('penjual.products.index') }}"
                       class="text-amber-800 hover:text-amber-950 text-sm font-semibold">
                        Lihat Semua →
                    </a>
                </div>

                @forelse ($produkTerbaru as $product)
                    <div class="flex flex-col sm:flex-row sm:items-center
                                justify-between gap-4 py-4 border-b last:border-0">

                        <div class="flex items-center gap-4">
                            @if ($product->image)
                                <img
                                    src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->name }}"
                                    class="w-16 h-16 object-cover rounded-lg">
                            @else
                                <div class="w-16 h-16 rounded-lg bg-amber-50
                                            flex items-center justify-center text-2xl">
                                    📦
                                </div>
                            @endif

                            <div>
                                <h4 class="font-semibold text-gray-800">
                                    {{ $product->name }}
                                </h4>
                                <p class="text-sm text-gray-500">
                                    {{ $product->category ?: 'Tanpa kategori' }}
                                </p>
                                <p class="text-sm font-semibold text-amber-900 mt-1">
                                    Rp{{ number_format($product->price ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <div>
                            @if ($product->status === 'approved')
                                <span class="px-3 py-1 rounded-full text-xs
                                             bg-green-100 text-green-700">
                                    Disetujui
                                </span>
                            @elseif ($product->status === 'pending')
                                <span class="px-3 py-1 rounded-full text-xs
                                             bg-yellow-100 text-yellow-700">
                                    Menunggu
                                </span>
                            @elseif ($product->status === 'rejected')
                                <span class="px-3 py-1 rounded-full text-xs
                                             bg-red-100 text-red-700">
                                    Ditolak
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs
                                             bg-gray-100 text-gray-700">
                                    {{ $product->status }}
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10">
                        <div class="text-5xl mb-3">📦</div>
                        <p class="text-gray-600 font-semibold">
                            Belum ada produk.
                        </p>
                        <p class="text-gray-400 text-sm mt-1">
                            Mulai jual barang bekasmu sekarang.
                        </p>
                        <a href="{{ route('penjual.products.create') }}"
                           class="inline-block mt-4 bg-amber-900 text-white
                                  px-5 py-2 rounded-lg hover:bg-amber-950">
                            Tambah Produk
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
