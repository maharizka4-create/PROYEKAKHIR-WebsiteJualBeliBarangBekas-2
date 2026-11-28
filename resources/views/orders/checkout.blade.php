<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Checkout Pesanan
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4">

            <div class="bg-white rounded-xl shadow p-6">

                <h3 class="text-xl font-bold mb-5">
                    Ringkasan Produk
                </h3>

                <div class="border rounded-xl p-4 mb-6">

                    <h4 class="font-bold text-lg">
                        {{ $product->name }}
                    </h4>

                    <p class="text-gray-500">
                        Kondisi: {{ $product->condition }}
                    </p>

                    <p class="text-gray-500">
                        Stok tersedia: {{ $product->stock }}
                    </p>

                    <p class="text-xl font-bold text-amber-800 mt-3">
                        Rp{{ number_format($product->price, 0, ',', '.') }}
                    </p>

                </div>

                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-4 rounded mb-5">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form
                    action="{{ route('user.checkout.store', $product) }}"
                    method="POST"
                >
                    @csrf

                    <div class="mb-5">
                        <label class="block font-semibold mb-2">
                            Jumlah Pembelian
                        </label>

                        <input
                            type="number"
                            name="jumlah"
                            min="1"
                            max="{{ $product->stock }}"
                            value="{{ old('jumlah', 1) }}"
                            required
                            class="w-full rounded-lg border-gray-300"
                        >
                    </div>

                    <div class="mb-5">
                        <label class="block font-semibold mb-2">
                            Alamat Pengiriman
                        </label>

                        <textarea
                            name="alamat_pengiriman"
                            rows="4"
                            required
                            class="w-full rounded-lg border-gray-300"
                            placeholder="Masukkan alamat lengkap..."
                        >{{ old('alamat_pengiriman') }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block font-semibold mb-2">
                            Metode Pembayaran
                        </label>

                        <select
                            name="metode_pembayaran"
                            required
                            class="w-full rounded-lg border-gray-300"
                        >
                            <option value="">Pilih pembayaran</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="cod">Cash on Delivery (COD)</option>
                        </select>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-amber-800 hover:bg-amber-900 text-white font-bold py-3 rounded-lg"
                    >
                        Buat Pesanan
                    </button>

                    <a
                        href="{{ route('catalog.show', $product) }}"
                        class="block text-center mt-4 text-gray-600"
                    >
                        Kembali ke Produk
                    </a>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>