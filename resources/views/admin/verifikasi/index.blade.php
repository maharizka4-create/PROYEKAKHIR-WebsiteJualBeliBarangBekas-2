<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">Verifikasi Barang</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 rounded-md bg-green-100 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 rounded-md bg-red-100 text-red-800">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            {{-- Pencarian --}}
            <form method="GET" action="{{ route('admin.verifikasi.index') }}" class="flex gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama barang"
                    class="rounded-md border-coklat-300 focus:border-coklat-500 focus:ring-coklat-500 text-sm">
                <button type="submit"
                    class="px-4 py-2 bg-coklat-700 hover:bg-coklat-800 text-white text-xs font-semibold uppercase tracking-widest rounded-md">
                    Cari
                </button>
            </form>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-coklat-50 text-coklat-900">
                        <tr>
                            <th class="px-6 py-3">Barang</th>
                            <th class="px-6 py-3">Penjual</th>
                            <th class="px-6 py-3">Kategori</th>
                            <th class="px-6 py-3">Harga</th>
                            <th class="px-6 py-3">Stok</th>
                            <th class="px-6 py-3">Kondisi</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-coklat-100">
                        @forelse ($products as $p)
                            <tr class="align-top">
                                <td class="px-6 py-3">
                                    <div class="font-medium text-coklat-900">{{ $p->nama }}</div>
                                    <div class="text-xs text-coklat-600 max-w-xs">{{ $p->deskripsi }}</div>
                                </td>
                                <td class="px-6 py-3">{{ $p->penjual->name ?? '-' }}</td>
                                <td class="px-6 py-3">{{ $p->category->name ?? '-' }}</td>
                                <td class="px-6 py-3">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-3">{{ $p->stok }}</td>
                                <td class="px-6 py-3">{{ $p->kondisi }}</td>
                                <td class="px-6 py-3" x-data="{ tolak: false }">
                                    <div class="flex gap-2">
                                        <form method="POST" action="{{ route('admin.verifikasi.setujui', $p) }}"
                                            onsubmit="return confirm('Setujui barang ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="px-3 py-1 rounded-md bg-green-600 hover:bg-green-700 text-white text-xs font-semibold">
                                                Setujui
                                            </button>
                                        </form>

                                        <button type="button" @click="tolak = ! tolak"
                                            class="px-3 py-1 rounded-md bg-red-600 hover:bg-red-700 text-white text-xs font-semibold">
                                            Tolak
                                        </button>
                                    </div>

                                    <form x-show="tolak" x-cloak method="POST"
                                        action="{{ route('admin.verifikasi.tolak', $p) }}" class="mt-3 space-y-2">
                                        @csrf
                                        @method('PATCH')
                                        <textarea name="alasan_penolakan" rows="2" required maxlength="500"
                                            placeholder="Tulis alasan penolakan..."
                                            class="w-56 rounded-md border-coklat-300 focus:border-coklat-500 focus:ring-coklat-500 text-sm"></textarea>
                                        <div>
                                            <button type="submit"
                                                class="px-3 py-1 rounded-md bg-coklat-700 hover:bg-coklat-800 text-white text-xs font-semibold">
                                                Kirim penolakan
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-coklat-600">
                                    Tidak ada barang yang menunggu verifikasi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>