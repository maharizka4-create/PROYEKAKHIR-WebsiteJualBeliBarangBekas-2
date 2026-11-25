<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">Daftar Barang</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Filter dan pencarian --}}
            <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-wrap gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama barang"
                    class="rounded-md border-coklat-300 focus:border-coklat-500 focus:ring-coklat-500 text-sm">

                <select name="status"
                    class="rounded-md border-coklat-300 focus:border-coklat-500 focus:ring-coklat-500 text-sm">
                    <option value="">Semua status</option>
                    <option value="menunggu" @selected(request('status') === 'menunggu')>Menunggu</option>
                    <option value="disetujui" @selected(request('status') === 'disetujui')>Disetujui</option>
                    <option value="ditolak" @selected(request('status') === 'ditolak')>Ditolak</option>
                </select>

                <select name="kategori"
                    class="rounded-md border-coklat-300 focus:border-coklat-500 focus:ring-coklat-500 text-sm">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $c)
                        <option value="{{ $c->id }}" @selected(request('kategori') == $c->id)>{{ $c->name }}</option>
                    @endforeach
                </select>

                <button type="submit"
                    class="px-4 py-2 bg-coklat-700 hover:bg-coklat-800 text-white text-xs font-semibold uppercase tracking-widest rounded-md">
                    Cari
                </button>

                @if (request()->hasAny(['q', 'status', 'kategori']))
                    <a href="{{ route('admin.products.index') }}"
                        class="px-4 py-2 text-sm text-coklat-700 underline self-center">Reset</a>
                @endif
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
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-coklat-100">
                        @forelse ($products as $p)
                            <tr>
                                <td class="px-6 py-3 font-medium text-coklat-900">{{ $p->nama }}</td>
                                <td class="px-6 py-3">{{ $p->penjual->name ?? '-' }}</td>
                                <td class="px-6 py-3">{{ $p->category->name ?? '-' }}</td>
                                <td class="px-6 py-3">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-3">{{ $p->stok }}</td>
                                <td class="px-6 py-3">
                                    @if ($p->status_persetujuan === 'disetujui')
                                        <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Disetujui</span>
                                    @elseif ($p->status_persetujuan === 'ditolak')
                                        <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-800">Ditolak</span>
                                    @else
                                        <span class="px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-800">Menunggu</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    <a href="{{ route('admin.products.show', $p) }}"
                                        class="text-coklat-700 hover:text-coklat-900 underline">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-coklat-600">
                                    Belum ada barang.
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