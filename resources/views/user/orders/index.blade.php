<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Riwayat Pembelian
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Pantau pesanan dan pembayaran kamu di SEKENOVA.
            </p>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- NOTIFIKASI --}}
            @if (session('success'))
                <div class="mb-6 rounded-xl bg-green-100 border border-green-200 text-green-800 p-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-xl bg-red-100 border border-red-200 text-red-800 p-4">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-xl bg-red-100 border border-red-200 text-red-800 p-4">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            {{-- JUDUL --}}
            <div class="mb-8">
                <h3 class="text-2xl font-extrabold text-amber-950">
                    Pesanan Saya
                </h3>
                <p class="text-gray-500 mt-2">
                    Berikut daftar transaksi pembelian kamu.
                </p>
            </div>

            {{-- DAFTAR PESANAN --}}
            @forelse ($orders as $order)

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 mb-6 overflow-hidden">

                    {{-- HEADER PESANAN --}}
                    <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row sm:justify-between gap-3">

                        <div>
                            <p class="text-xs text-gray-500">
                                Kode Pesanan
                            </p>

                            <p class="font-bold text-amber-950 mt-1">
                                {{ $order->kode }}
                            </p>

                            <p class="text-xs text-gray-500 mt-2">
                                {{ $order->created_at?->format('d M Y, H:i') }}
                            </p>
                        </div>

                        <div class="sm:text-right">
                            <p class="text-xs text-gray-500 mb-2">
                                Status Pesanan
                            </p>

                            @php
                                $status = [
                                    'menunggu_pembayaran' => [
                                        'label' => 'Menunggu Pembayaran',
                                        'class' => 'bg-yellow-100 text-yellow-800'
                                    ],
                                    'dibayar' => [
                                        'label' => 'Pembayaran Terverifikasi',
                                        'class' => 'bg-blue-100 text-blue-800'
                                    ],
                                    'dikirim' => [
                                        'label' => 'Sedang Dikirim',
                                        'class' => 'bg-indigo-100 text-indigo-800'
                                    ],
                                    'selesai' => [
                                        'label' => 'Pesanan Selesai',
                                        'class' => 'bg-green-100 text-green-800'
                                    ],
                                    'dibatalkan' => [
                                        'label' => 'Dibatalkan',
                                        'class' => 'bg-red-100 text-red-800'
                                    ],
                                ];

                                $statusInfo = $status[$order->status] ?? [
                                    'label' => $order->status,
                                    'class' => 'bg-gray-100 text-gray-700'
                                ];
                            @endphp

                            <span class="inline-block px-3 py-2 rounded-full text-xs font-bold {{ $statusInfo['class'] }}">
                                {{ $statusInfo['label'] }}
                            </span>
                        </div>

                    </div>

                    {{-- DETAIL PRODUK --}}
                    <div class="p-5">

                        @foreach ($order->items as $item)

                            <div class="flex flex-col sm:flex-row sm:justify-between gap-3 py-3 border-b border-gray-100">

                                <div>
                                    <h4 class="font-bold text-gray-800">
                                        {{ $item->nama_barang }}
                                    </h4>

                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $item->jumlah }} barang ×
                                        Rp{{ number_format($item->harga, 0, ',', '.') }}
                                    </p>
                                </div>

                                <p class="font-bold text-amber-800">
                                    Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                                </p>

                            </div>

                        @endforeach

                        {{-- TOTAL --}}
                        <div class="flex justify-between items-center pt-5">
                            <span class="text-gray-600 font-semibold">
                                Total Pembayaran
                            </span>

                            <span class="text-xl font-extrabold text-amber-900">
                                Rp{{ number_format($order->total_harga, 0, ',', '.') }}
                            </span>
                        </div>

                        {{-- METODE PEMBAYARAN --}}
                        <div class="mt-5 text-sm text-gray-600">
                            <p>
                                <strong>Metode Pembayaran:</strong>
                                {{ $order->metode_pembayaran === 'transfer'
                                    ? 'Transfer Bank'
                                    : 'Cash on Delivery (COD)' }}
                            </p>

                            <p class="mt-2">
                                <strong>Alamat Pengiriman:</strong>
                                {{ $order->alamat_pengiriman }}
                            </p>
                        </div>

                        {{-- UPLOAD BUKTI TRANSFER --}}
                        @if (
                            $order->metode_pembayaran === 'transfer' &&
                            $order->status === 'menunggu_pembayaran'
                        )

                            <div class="mt-6 p-5 bg-amber-50 border border-amber-200 rounded-xl">

                                <h4 class="font-bold text-amber-950">
                                    Bukti Pembayaran
                                </h4>

                                <p class="text-sm text-gray-600 mt-2">
                                    @if ($order->bukti_pembayaran)
                                        Bukti pembayaran sudah diunggah.
                                        Silakan tunggu verifikasi Admin atau unggah ulang jika bukti ditolak.
                                    @else
                                        Silakan unggah foto bukti transfer pembayaran.
                                    @endif
                                </p>

                                @if ($order->bukti_pembayaran)
                                    <div class="mt-4">
                                        <img
                                            src="{{ asset('storage/' . $order->bukti_pembayaran) }}"
                                            alt="Bukti Pembayaran"
                                            class="w-full max-w-xs rounded-xl border shadow-sm"
                                        >
                                    </div>
                                @endif

                                <form
                                    action="{{ route('user.orders.bukti', $order) }}"
                                    method="POST"
                                    enctype="multipart/form-data"
                                    class="mt-5"
                                >
                                    @csrf

                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Pilih Foto Bukti Transfer
                                    </label>

                                    <input
                                        type="file"
                                        name="bukti_pembayaran"
                                        accept="image/jpeg,image/png,image/webp"
                                        required
                                        class="block w-full text-sm text-gray-600
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-lg file:border-0
                                        file:bg-amber-800 file:text-white
                                        hover:file:bg-amber-900"
                                    >

                                    <p class="text-xs text-gray-500 mt-2">
                                        Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                                    </p>

                                    <button
                                        type="submit"
                                        class="mt-4 px-5 py-3 rounded-lg
                                        bg-amber-800 hover:bg-amber-900
                                        text-white font-bold text-sm"
                                    >
                                        {{ $order->bukti_pembayaran
                                            ? 'Unggah Ulang Bukti'
                                            : 'Upload Bukti Pembayaran' }}
                                    </button>

                                </form>

                            </div>

                        @endif

                        {{-- INFORMASI PEMBAYARAN --}}
                        @if (
                            $order->metode_pembayaran === 'transfer' &&
                            $order->status === 'dibayar'
                        )
                            <div class="mt-5 p-4 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm">
                                Pembayaran berhasil diverifikasi Admin. Pesanan sedang menunggu proses pengiriman.
                            </div>
                        @endif

                        {{-- KONFIRMASI BARANG DITERIMA --}}
                        @if ($order->status === 'dikirim')

                            <div class="mt-6 p-5 rounded-xl bg-blue-50 border border-blue-200">

                                <h4 class="font-bold text-blue-950">
                                    Konfirmasi Penerimaan Barang
                                </h4>

                                <p class="text-sm text-blue-800 mt-2">
                                    Apakah barang pesanan kamu sudah diterima?
                                    Konfirmasikan setelah barang benar-benar sampai.
                                </p>

                                <form
                                    action="{{ route('user.orders.diterima', $order) }}"
                                    method="POST"
                                    class="mt-4"
                                    onsubmit="return confirm('Apakah kamu yakin barang sudah diterima?')"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="px-5 py-3 rounded-lg
                                        bg-blue-700 hover:bg-blue-800
                                        text-white font-bold text-sm"
                                    >
                                        Barang Sudah Diterima
                                    </button>
                                </form>

                            </div>

                        @endif

                        {{-- PESANAN SELESAI --}}
                        @if ($order->status === 'selesai')

                            <div class="mt-5 p-4 rounded-xl bg-green-50 border border-green-200">

                                <p class="font-bold text-green-800">
                                    ✓ Pesanan Selesai
                                </p>

                                <p class="text-sm text-green-700 mt-1">
                                    Pesanan telah dikonfirmasi diterima.

                                    @if ($order->diterima_pada)
                                        {{ $order->diterima_pada->format('d M Y, H:i') }}
                                    @endif
                                </p>

                            </div>

                        @endif

                    </div>

                </div>

            @empty

                <div class="bg-white rounded-2xl border border-gray-200 p-10 text-center">

                    <div class="text-5xl mb-4">
                        📦
                    </div>

                    <h3 class="text-xl font-bold text-gray-800">
                        Belum Ada Pesanan
                    </h3>

                    <p class="text-gray-500 mt-2">
                        Kamu belum melakukan pembelian di SEKENOVA.
                    </p>

                    <a
                        href="{{ route('catalog.index') }}"
                        class="inline-block mt-6 px-6 py-3 rounded-xl
                        bg-amber-800 hover:bg-amber-900
                        text-white font-bold"
                    >
                        Mulai Belanja
                    </a>

                </div>

            @endforelse

            {{-- PAGINATION --}}
            <div class="mt-8">
                {{ $orders->links() }}
            </div>

            {{-- KEMBALI --}}
            <div class="mt-8">
                <a
                    href="{{ route('user.dashboard') }}"
                    class="text-amber-800 hover:text-amber-950 font-semibold"
                >
                    ← Kembali ke Dashboard
                </a>
            </div>

        </div>
    </div>

</x-app-layout>