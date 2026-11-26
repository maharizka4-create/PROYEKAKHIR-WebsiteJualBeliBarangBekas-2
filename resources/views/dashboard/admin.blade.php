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

            {{-- Kartu statistik: datanya diambil dari REST API (GET /api/admin/statistik) --}}
            <div
                x-data="{
                    d: null,
                    gagal: false,
                    async muat() {
                        try {
                            const r = await fetch('/api/admin/statistik', {
                                headers: { 'Accept': 'application/json' },
                                credentials: 'same-origin'
                            });
                            if (!r.ok) throw new Error('gagal');
                            this.d = (await r.json()).data;
                        } catch (e) {
                            this.gagal = true;
                        }
                    },
                    rp(n) { return 'Rp ' + new Intl.NumberFormat('id-ID').format(n); }
                }"
                x-init="muat()"
                class="space-y-2"
            >
                <p x-show="gagal" x-cloak class="p-3 rounded-md bg-red-100 text-red-800 text-sm">
                    Gagal memuat statistik dari API. Coba muat ulang halaman.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <div class="text-sm text-coklat-600">Total pembeli</div>
                        <div class="text-3xl font-bold text-coklat-900" x-text="d ? d.total_pembeli : '...'">...</div>
                    </div>
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <div class="text-sm text-coklat-600">Total penjual</div>
                        <div class="text-3xl font-bold text-coklat-900" x-text="d ? d.total_penjual : '...'">...</div>
                    </div>
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <div class="text-sm text-coklat-600">Total barang</div>
                        <div class="text-3xl font-bold text-coklat-900" x-text="d ? d.total_barang : '...'">...</div>
                    </div>
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <div class="text-sm text-coklat-600">Menunggu verifikasi</div>
                        <div class="text-3xl font-bold text-coklat-900" x-text="d ? d.menunggu_verifikasi : '...'">...</div>
                    </div>
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <div class="text-sm text-coklat-600">Total transaksi</div>
                        <div class="text-3xl font-bold text-coklat-900" x-text="d ? d.total_transaksi : '...'">...</div>
                    </div>
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <div class="text-sm text-coklat-600">Pendapatan (sudah dibayar)</div>
                        <div class="text-2xl font-bold text-coklat-900" x-text="d ? rp(d.pendapatan) : '...'">...</div>
                    </div>
                </div>

                <p class="text-xs text-coklat-600">Data statistik diambil dari REST API <code>GET /api/admin/statistik</code>.</p>
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