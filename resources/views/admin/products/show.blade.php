<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">Detail Barang</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-4">
                <div class="flex items-start justify-between gap-4">
                    <h3 class="text-2xl font-bold text-coklat-900">{{ $product->nama }}</h3>

                    @if ($product->status_persetujuan === 'disetujui')
                        <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-800">Disetujui</span>
                    @elseif ($product->status_persetujuan === 'ditolak')
                        <span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-800">Ditolak</span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-800">Menunggu</span>
                    @endif
                </div>

                <p class="text-coklat-700">{{ $product->deskripsi ?: 'Tidak ada deskripsi.' }}</p>

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-coklat-600">Harga</dt>
                        <dd class="font-semibold text-coklat-900">Rp {{ number_format($product->harga, 0, ',', '.') }}</dd>
                    </div>
                    <div>
                        <dt class="text-coklat-600">Stok</dt>
                        <dd class="font-semibold text-coklat-900">{{ $product->stok }}</dd>
                    </div>
                    <div>
                        <dt class="text-coklat-600">Kondisi</dt>
                        <dd class="font-semibold text-coklat-900">{{ $product->kondisi }}</dd>
                    </div>
                    <div>
                        <dt class="text-coklat-600">Kategori</dt>
                        <dd class="font-semibold text-coklat-900">{{ $product->category->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-coklat-600">Penjual</dt>
                        <dd class="font-semibold text-coklat-900">
                            {{ $product->penjual->name ?? '-' }}
                            <span class="font-normal text-coklat-600">({{ $product->penjual->email ?? '-' }})</span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-coklat-600">Diunggah</dt>
                        <dd class="font-semibold text-coklat-900">{{ $product->created_at->format('d M Y, H:i') }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Riwayat pemeriksaan --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-2 text-sm">
                <h4 class="font-semibold text-coklat-900">Riwayat Pemeriksaan</h4>

                @if ($product->status_persetujuan === 'menunggu')
                    <p class="text-coklat-600">Barang ini belum diperiksa.</p>
                    <a href="{{ route('admin.verifikasi.index') }}"
                        class="inline-block text-coklat-700 hover:text-coklat-900 underline">
                        Ke halaman verifikasi
                    </a>
                @else
                    <p>
                        Diperiksa oleh
                        <span class="font-medium">{{ $product->pemeriksa->name ?? '-' }}</span>
                        pada
                        <span class="font-medium">{{ $product->diperiksa_pada?->format('d M Y, H:i') ?? '-' }}</span>
                    </p>

                    @if ($product->status_persetujuan === 'ditolak')
                        <div class="p-3 rounded-md bg-red-50 text-red-800">
                            <span class="font-medium">Alasan penolakan:</span>
                            {{ $product->alasan_penolakan }}
                        </div>
                    @endif
                @endif
            </div>

            <a href="{{ route('admin.products.index') }}"
                class="inline-block px-4 py-2 bg-coklat-700 hover:bg-coklat-800 text-white text-xs font-semibold uppercase tracking-widest rounded-md">
                Kembali ke daftar
            </a>
        </div>
    </div>
</x-app-layout>