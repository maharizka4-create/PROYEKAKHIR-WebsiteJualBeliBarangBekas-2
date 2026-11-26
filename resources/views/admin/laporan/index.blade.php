@php
    $label = [
        'menunggu_pembayaran' => 'Menunggu pembayaran',
        'dibayar' => 'Dibayar',
        'dikirim' => 'Dikirim',
        'selesai' => 'Selesai',
        'dibatalkan' => 'Dibatalkan',
    ];
    $warna = [
        'menunggu_pembayaran' => 'bg-yellow-100 text-yellow-800',
        'dibayar' => 'bg-blue-100 text-blue-800',
        'dikirim' => 'bg-purple-100 text-purple-800',
        'selesai' => 'bg-green-100 text-green-800',
        'dibatalkan' => 'bg-red-100 text-red-800',
    ];
@endphp

<x-admin-layout>
    <x-slot name="header">
        <h2>Laporan Transaksi</h2>
        <p>Pantau semua pesanan dan pendapatan SEKENOVA.</p>
    </x-slot>

    <style>
        @media print {
            aside, body header, footer, .no-print { display: none !important; }
            main { padding: 0 !important; }
            body { background: #fff !important; }
            @page { margin: 1.5cm; }
            thead th { background: #5b3a26 !important; color: #fff !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>

    <div class="mx-auto max-w-6xl space-y-6">

        {{-- Keterangan cetak (hanya muncul saat dicetak) --}}
        <div class="hidden print:block text-sm text-gray-700">
            <p>
                Periode:
                {{ request('dari') ? \Carbon\Carbon::parse(request('dari'))->format('d/m/Y') : 'awal' }}
                s/d
                {{ request('sampai') ? \Carbon\Carbon::parse(request('sampai'))->format('d/m/Y') : 'sekarang' }}
                @if (request('status')) &middot; Status: {{ $label[request('status')] }} @endif
            </p>
            <p>Dicetak: {{ now()->format('d/m/Y H:i') }} oleh {{ auth()->user()->name }}</p>
        </div>

        {{-- Filter --}}
        <form method="GET" class="no-print flex flex-wrap items-end gap-3 rounded-xl border border-coklat-200 bg-white p-4">
            <div>
                <label class="block text-xs font-medium text-coklat-600">Dari tanggal</label>
                <input type="date" name="dari" value="{{ request('dari') }}" class="mt-1 rounded-lg border-coklat-200 text-sm focus:border-coklat-600 focus:ring-coklat-600">
            </div>
            <div>
                <label class="block text-xs font-medium text-coklat-600">Sampai tanggal</label>
                <input type="date" name="sampai" value="{{ request('sampai') }}" class="mt-1 rounded-lg border-coklat-200 text-sm focus:border-coklat-600 focus:ring-coklat-600">
            </div>
            <div>
                <label class="block text-xs font-medium text-coklat-600">Status</label>
                <select name="status" class="mt-1 rounded-lg border-coklat-200 text-sm focus:border-coklat-600 focus:ring-coklat-600">
                    <option value="">Semua status</option>
                    @foreach ($label as $k => $v)
                        <option value="{{ $k }}" @selected(request('status') === $k)>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="rounded-lg bg-coklat-700 px-5 py-2 text-sm font-semibold text-white hover:bg-coklat-800">Tampilkan</button>
            <a href="{{ url('/admin/laporan') }}" class="rounded-lg border border-coklat-200 px-5 py-2 text-sm font-medium text-coklat-700 hover:bg-coklat-50">Reset</a>
            <button type="button" onclick="window.print()" class="ml-auto rounded-lg border border-coklat-700 px-5 py-2 text-sm font-semibold text-coklat-700 hover:bg-coklat-50">Cetak</button>
        </form>

        @if ($errors->any())
            <p class="no-print rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">{{ $errors->first() }}</p>
        @endif

        {{-- Ringkasan --}}
        <div class="grid gap-4 sm:grid-cols-2">
            <div class="rounded-xl border border-coklat-200 bg-white p-5">
                <p class="text-sm text-coklat-600">Jumlah pesanan</p>
                <p class="mt-2 text-2xl font-bold text-coklat-950">{{ $jumlahPesanan }}</p>
            </div>
            <div class="rounded-xl border border-coklat-200 bg-white p-5">
                <p class="text-sm text-coklat-600">Total pendapatan (sudah dibayar)</p>
                <p class="mt-2 text-2xl font-bold text-coklat-950">Rp {{ number_format($pendapatan, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="flex flex-wrap gap-2">
            @foreach ($label as $k => $v)
                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $warna[$k] }}">{{ $v }}: {{ $perStatus[$k] ?? 0 }}</span>
            @endforeach
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto rounded-xl border border-coklat-300 bg-white">
            <table class="w-full border-collapse text-left text-sm">
                <thead>
                    <tr class="bg-coklat-700 text-xs uppercase tracking-wide text-white">
                        <th class="w-12 border border-coklat-600 px-3 py-3 text-center">No</th>
                        <th class="border border-coklat-600 px-4 py-3">Kode</th>
                        <th class="border border-coklat-600 px-4 py-3">Tanggal</th>
                        <th class="border border-coklat-600 px-4 py-3">Pembeli</th>
                        <th class="border border-coklat-600 px-4 py-3">Barang</th>
                        <th class="border border-coklat-600 px-4 py-3 text-right">Total</th>
                        <th class="border border-coklat-600 px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $o)
                        <tr class="{{ $loop->even ? 'bg-coklat-50' : 'bg-white' }}">
                            <td class="border border-coklat-200 px-3 py-3 text-center text-coklat-700">{{ $orders->firstItem() + $loop->index }}</td>
                            <td class="border border-coklat-200 px-4 py-3 font-medium text-coklat-950 whitespace-nowrap">{{ $o->kode }}</td>
                            <td class="border border-coklat-200 px-4 py-3 text-coklat-700 whitespace-nowrap">{{ $o->created_at->format('d/m/Y') }}</td>
                            <td class="border border-coklat-200 px-4 py-3 text-coklat-700">{{ $o->pembeli->name ?? '-' }}</td>
                            <td class="border border-coklat-200 px-4 py-3 text-coklat-700">
                                @foreach ($o->items as $i)
                                    <div>{{ $i->nama_barang }} <span class="text-coklat-500">x{{ $i->jumlah }}</span></div>
                                @endforeach
                            </td>
                            <td class="border border-coklat-200 px-4 py-3 text-right font-semibold text-coklat-950 whitespace-nowrap">Rp {{ number_format($o->total_harga, 0, ',', '.') }}</td>
                            <td class="border border-coklat-200 px-4 py-3 text-center">
                                <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold {{ $warna[$o->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $label[$o->status] ?? $o->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="border border-coklat-200 px-4 py-10 text-center text-coklat-500">Tidak ada pesanan pada filter ini.</td></tr>
                    @endforelse
                </tbody>
                @if ($orders->count())
                    <tfoot>
                        <tr class="bg-coklat-100 font-semibold text-coklat-950">
                            <td colspan="5" class="border border-coklat-300 px-4 py-3 text-right">Total pada halaman ini</td>
                            <td class="border border-coklat-300 px-4 py-3 text-right whitespace-nowrap">Rp {{ number_format($orders->sum('total_harga'), 0, ',', '.') }}</td>
                            <td class="border border-coklat-300"></td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>

        <div class="no-print">{{ $orders->links() }}</div>
    </div>
</x-admin-layout>