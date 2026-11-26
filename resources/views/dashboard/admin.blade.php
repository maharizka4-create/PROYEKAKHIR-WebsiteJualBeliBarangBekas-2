<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">Dashboard Admin</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Peringatan barang menunggu verifikasi --}}
            @if ($menungguVerifikasi > 0)
                <div class="p-4 rounded-md bg-yellow-100 text-yellow-800 flex items-center justify-between">
                    <span>Ada <strong>{{ $menungguVerifikasi }}</strong> barang yang menunggu verifikasi.</span>
                    <a href="{{ route('admin.verifikasi.index') }}" class="underline font-medium">Periksa sekarang</a>
                </div>
            @endif

            {{-- Kartu statistik --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-coklat-600">Total pembeli</div>
                    <div class="text-3xl font-bold text-coklat-900">{{ $totalUser }}</div>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-coklat-600">Total penjual</div>
                    <div class="text-3xl font-bold text-coklat-900">{{ $totalPenjual }}</div>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-coklat-600">Total barang</div>
                    <div class="text-3xl font-bold text-coklat-900">{{ $totalBarang }}</div>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-coklat-600">Menunggu verifikasi</div>
                    <div class="text-3xl font-bold text-coklat-900">{{ $menungguVerifikasi }}</div>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-coklat-600">Total transaksi</div>
                    <div class="text-3xl font-bold text-coklat-900">{{ $totalPesanan }}</div>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-coklat-600">Pendapatan (sudah dibayar)</div>
                    <div class="text-2xl font-bold text-coklat-900">Rp {{ number_format($pendapatan, 0, ',', '.') }}</div>
                </div>
            </div>

            {{-- Barang menunggu verifikasi --}}
            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <div class="px-6 py-4 flex items-center justify-between border-b border-coklat-100">
                    <h3 class="font-semibold text-coklat-900">Barang menunggu verifikasi</h3>
                    <a href="{{ route('admin.verifikasi.index') }}" class="text-sm text-coklat-700 underline">Lihat semua</a>
                </div>
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-coklat-50 text-coklat-900">
                        <tr>
                            <th class="px-6 py-3">Barang</th>
                            <th class="px-6 py-3">Penjual</th>
                            <th class="px-6 py-3">Kategori</th>
                            <th class="px-6 py-3">Harga</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-coklat-100">
                        @forelse ($barangMenunggu as $b)
                            <tr>
                                <td class="px-6 py-3">{{ $b->nama }}</td>
                                <td class="px-6 py-3">{{ $b->penjual->name ?? '-' }}</td>
                                <td class="px-6 py-3">{{ $b->category->name ?? '-' }}</td>
                                <td class="px-6 py-3">Rp {{ number_format($b->harga, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-6 text-center text-coklat-600">
                                    Tidak ada barang yang menunggu verifikasi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pengguna terbaru --}}
            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <div class="px-6 py-4 border-b border-coklat-100">
                    <h3 class="font-semibold text-coklat-900">Pengguna terbaru</h3>
                </div>
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-coklat-50 text-coklat-900">
                        <tr>
                            <th class="px-6 py-3">Nama</th>
                            <th class="px-6 py-3">Email</th>
                            <th class="px-6 py-3">Role</th>
                            <th class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-coklat-100">
                        @foreach ($latestUsers as $u)
                            <tr>
                                <td class="px-6 py-3">{{ $u->name }}</td>
                                <td class="px-6 py-3">{{ $u->email }}</td>
                                <td class="px-6 py-3">{{ $u->getRoleNames()->first() }}</td>
                                <td class="px-6 py-3">{{ $u->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>