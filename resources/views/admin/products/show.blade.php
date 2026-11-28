<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">Detail Barang</h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-4">

                <div class="flex items-start justify-between gap-4">
                    <h3 class="text-2xl font-bold text-coklat-900">
                        {{ $product->name }}
                    </h3>

                    @if ($product->status === 'approved')
                        <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-800">
                            Disetujui
                        </span>
                    @elseif ($product->status === 'rejected')
                        <span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-800">
                            Ditolak
                        </span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-800">
                            Menunggu
                        </span>
                    @endif
                </div>

                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}"
                        alt="{{ $product->name }}"
                        class="w-full max-h-80 object-contain rounded-lg">
                @endif

                <p class="text-coklat-700">
                    {{ $product->description ?: 'Tidak ada deskripsi.' }}
                </p>

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">

                    <div>
                        <dt class="text-coklat-600">Harga</dt>
                        <dd class="font-semibold text-coklat-900">
                            Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-coklat-600">Stok</dt>
                        <dd class="font-semibold text-coklat-900">
                            {{ $product->stock ?? 0 }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-coklat-600">Kondisi</dt>
                        <dd class="font-semibold text-coklat-900">
                            {{ $product->condition ?: '-' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-coklat-600">Kategori</dt>
                        <dd class="font-semibold text-coklat-900">
                            {{ $product->category ?: '-' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-coklat-600">Penjual</dt>
                        <dd class="font-semibold text-coklat-900">
                            {{ $product->penjual->name ?? '-' }}
                            <span class="font-normal text-coklat-600">
                                ({{ $product->penjual->email ?? '-' }})
                            </span>
                        </dd>
                    </div>

                    <div>
                        <dt class="text-coklat-600">Diunggah</dt>
                        <dd class="font-semibold text-coklat-900">
                            {{ $product->created_at?->format('d M Y, H:i') ?? '-' }}
                        </dd>
                    </div>

                </dl>
            </div>

            <a href="{{ route('admin.products.index') }}"
                class="inline-block px-4 py-2 bg-coklat-700 hover:bg-coklat-800 text-white text-xs font-semibold uppercase tracking-widest rounded-md">
                Kembali ke daftar
            </a>

        </div>
    </div>
</x-admin-layout>