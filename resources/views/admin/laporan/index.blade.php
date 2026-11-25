<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">Laporan Transaksi</h2>
    </x-slot>

    @php
        $labelStatus = [
            'menunggu_pembayaran' => ['Menunggu pembayaran', 'bg-yellow-100 text-yellow-800'],
            'dibayar' => ['Dibayar', 'bg-blue-100 text-blue-800'],
            'dikirim' => ['Dikirim', 'bg-purple-100 text-purple-800'],
            'selesai' => ['Selesai', 'bg-green-100 text-green-800'],
            'dibatalkan' => ['Dibatalkan', 'bg-red-100 text-red-800'],
        ];
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if ($errors->any())
                <div class="p-4 rounded-md bg-red-100 text-red-800">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            {{-- Filter --}}
            <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex flex-wrap items-end gap-2">
                <div>
                    <label class="block text-xs text-coklat-600 mb-1">Dari tanggal</label>
                    <input type="date" name="dari" value="{{ request('dari') }}"
                        class="rounded-md border-coklat-300 focus:border-coklat-500 focus:ring-coklat-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-coklat-600 mb-1">Sampai tanggal</label>
                    <input type="date" name="sampai" value="{{ request('sampai') }}"
                        class="rounded-md border-coklat-300 focus:border-coklat-500 focus:ring-coklat-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-coklat-600 mb-1">Status</label>
                    <select name="status"
                        class="rounded-md border-coklat-300 focus:border-coklat-500 focus:ring-coklat-500 text-sm">
                        <option value="">Semua status</option>
                        @foreach ($labelStatus as $nilai => $info)
                            <option value="{{ $nilai }}" @selected(request('status') === $nilai)>{{ $info[0] }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                    class="px-4 py-2 bg-coklat-700 hover:bg-coklat-800 text-white text-xs font-semibold uppercase tracking-widest rounded-md">
                    Tampilkan
                </button>
                @if (request()->hasAny(['dari', 'sampai', 'status']))
                    <a href="{{ route('admin.laporan.index') }}" class="px-2 py-2 text-sm text-coklat-700 underline">Reset</a>
                @endif
            </form>

            {{-- Ringkasan --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-coklat-600">Jumlah pesanan</div>
                    <div class="text-3xl font-bold text-coklat-900">{{ $jumlahPesanan }}</div>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-coklat-600">Total pendapatan (sudah dibayar)</div>
                    <div class="text-3xl font-bold text-coklat-900">Rp {{ number_format($pendapatan, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="flex flex-wrap gap-2">
                @foreach ($labelStatus as $nilai => $info)
                    <span class="px-3 py-1 rounded-full text-xs {{ $info[1] }}">
                        {{ $info[0] }}: {{ $perStatus[$nilai] ?? 0 }}
                    </span>
                @endforeach
            </div>

            {{-- Tabel pesanan --}}
            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-coklat-50 text-coklat-900">
                        <tr>
                            <th class="px-6 py-3">Kode</th>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Pembeli</th>
                            <th class="px-6 py-3">Barang</th>
                            <th class="px-6 py-3">Total</th>
                            <th class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-coklat-100">
                        @forelse ($orders as $o)
                            <tr class="align-top">
                                <td class="px-6 py-3 font-medium text-coklat-900">{{ $o->kode }}</td>
                                <td class="px-6 py-3">{{ $o->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-3">{{ $o->pembeli->name ?? '-' }}</td>
                                <td class="px-6 py-3">
                                    @foreach ($o->items as $item)
                                        <div>{{ $item->nama_barang }} <span class="text-coklat-600">x{{ $item->jumlah }}</span></div>
                                    @endforeach
                                </td>
                                <td class="px-6 py-3">Rp {{ number_format($o->total_harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-3">
                                    @php $info = $labelStatus[$o->status] ?? [$o->status, 'bg-gray-100 text-gray-800']; @endphp
                                    <span class="px-2 py-1 rounded-full text-xs {{ $info[1] }}">{{ $info[0] }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-coklat-600">
                                    Tidak ada transaksi pada filter ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $orders->links() }}
        </div>
    </div>
</x-app-layout>