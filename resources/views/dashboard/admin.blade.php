
<x-admin-layout>
    <div class="space-y-6">

        {{-- Sambutan --}}
        <div>
            <h1 class="text-2xl font-bold text-coklat-950">
                Selamat datang, {{ auth()->user()->name }}!
            </h1>
            <p class="text-sm text-coklat-600">
                Kelola dan pantau aktivitas marketplace SEKENOVA dengan mudah.
            </p>
        </div>

        {{-- Peringatan --}}
        @if ($menungguVerifikasi > 0)
            <div class="flex items-center justify-between rounded-2xl border border-amber-200 bg-amber-50 px-6 py-4">
                <p class="text-sm text-amber-900">
                    Ada <strong>{{ $menungguVerifikasi }}</strong>
                    barang menunggu verifikasi.
                </p>
                <a href="{{ url('/admin/verifikasi') }}"
                    class="text-sm font-semibold text-amber-900 hover:underline">
                    Periksa sekarang →
                </a>
            </div>
        @endif

        {{-- Statistik --}}
        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">

            @php
                $kartuStatistik = [
                    ['label' => 'Total Pembeli', 'nilai' => $totalPembeli],
                    ['label' => 'Total Penjual', 'nilai' => $totalPenjual],
                    ['label' => 'Total Barang', 'nilai' => $totalBarang],
                    ['label' => 'Menunggu Verifikasi', 'nilai' => $menungguVerifikasi],
                    ['label' => 'Total Transaksi', 'nilai' => $totalPesanan],
                    ['label' => 'Pendapatan', 'nilai' => 'Rp ' . number_format($pendapatan, 0, ',', '.')],
                ];
            @endphp

            @foreach ($kartuStatistik as $kartu)
                <div class="rounded-2xl border border-coklat-100 border-l-4 border-l-coklat-600 bg-white p-5 shadow-sm">
                    <p class="text-sm text-coklat-600">
                        {{ $kartu['label'] }}
                    </p>
                    <p class="mt-1 truncate text-3xl font-bold text-coklat-950">
                        {{ $kartu['nilai'] }}
                    </p>
                </div>
            @endforeach

        </div>

        <div class="grid gap-6 lg:grid-cols-2">

            {{-- Menunggu verifikasi --}}
            <div class="rounded-2xl border border-coklat-100 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-coklat-950">
                        Menunggu Verifikasi
                    </h3>
                    <a href="{{ url('/admin/verifikasi') }}"
                        class="text-sm font-semibold text-coklat-700 hover:underline">
                        Lihat Semua →
                    </a>
                </div>

                <div class="mt-4 space-y-3">
                    @forelse ($barangMenunggu as $b)
                        <div class="flex items-center gap-4 rounded-xl bg-coklat-50 p-3">
                            <div class="min-w-0 flex-1">
                                <p class="truncate font-medium text-coklat-950">
                                    {{ $b->name }}
                                </p>
                                <p class="text-xs text-coklat-600">
                                    oleh {{ $b->penjual->name ?? '-' }}
                                    · Rp {{ number_format($b->price ?? 0, 0, ',', '.') }}
                                </p>
                            </div>

                            <a href="{{ url('/admin/verifikasi') }}"
                                class="rounded-lg bg-coklat-700 px-4 py-2 text-xs font-semibold text-white hover:bg-coklat-800">
                                Verifikasi
                            </a>
                        </div>
                    @empty
                        <p class="py-8 text-center text-sm text-coklat-500">
                            Tidak ada barang yang menunggu.
                        </p>
                    @endforelse
                </div>
            </div>

            {{-- User terbaru --}}
            <div class="rounded-2xl border border-coklat-100 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-coklat-950">
                        User Terbaru
                    </h3>
                    <a href="{{ url('/admin/users') }}"
                        class="text-sm font-semibold text-coklat-700 hover:underline">
                        Lihat Semua →
                    </a>
                </div>

                <div class="mt-4 space-y-3">
                    @forelse ($latestUsers as $u)
                        <div class="flex items-center gap-4 rounded-xl bg-coklat-50 p-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-coklat-700 font-bold text-white">
                                {{ strtoupper(substr($u->name, 0, 1)) }}
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="truncate font-medium text-coklat-950">
                                    {{ $u->name }}
                                </p>
                                <p class="truncate text-xs text-coklat-600">
                                    {{ $u->email }}
                                </p>
                            </div>

                            <span class="rounded-full bg-coklat-100 px-3 py-1 text-xs font-semibold text-coklat-800">
                                {{ $u->getRoleNames()->first() ?? '-' }}
                            </span>
                        </div>
                    @empty
                        <p class="py-8 text-center text-sm text-coklat-500">
                            Belum ada user.
                        </p>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- Barang terbaru --}}
        <div class="rounded-2xl border border-coklat-100 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="font-semibold text-coklat-950">
                    Barang Terbaru
                </h3>
                <a href="{{ url('/admin/products') }}"
                    class="text-sm font-semibold text-coklat-700 hover:underline">
                    Lihat Semua →
                </a>
            </div>

            @php
                $badge = [
                    'pending' => 'bg-amber-100 text-amber-800',
                    'approved' => 'bg-green-100 text-green-800',
                    'rejected' => 'bg-red-100 text-red-800',
                ];

                $labelStatus = [
                    'pending' => 'Menunggu',
                    'approved' => 'Disetujui',
                    'rejected' => 'Ditolak',
                ];
            @endphp

            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="text-xs uppercase text-coklat-500">
                        <tr>
                            <th class="py-2 pr-4">Barang</th>
                            <th class="py-2 pr-4">Penjual</th>
                            <th class="py-2 pr-4">Harga</th>
                            <th class="py-2 pr-4">Status</th>
                            <th class="py-2">Ditambahkan</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-coklat-100">
                        @forelse ($barangTerbaru as $p)
                            <tr>
                                <td class="py-3 pr-4 font-medium text-coklat-950">
                                    {{ $p->name }}
                                </td>

                                <td class="py-3 pr-4 text-coklat-700">
                                    {{ $p->penjual->name ?? '-' }}
                                </td>

                                <td class="py-3 pr-4 font-semibold text-coklat-800">
                                    Rp {{ number_format($p->price ?? 0, 0, ',', '.') }}
                                </td>

                                <td class="py-3 pr-4">
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $badge[$p->status] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ $labelStatus[$p->status] ?? $p->status }}
                                    </span>
                                </td>

                                <td class="py-3 text-coklat-600">
                                    {{ $p->created_at?->diffForHumans() ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-coklat-500">
                                    Belum ada barang.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-admin-layout>