
<x-admin-layout>
    <x-slot name="header">
        <h2>Kelola Kategori</h2>
        <p>Atur kategori barang yang akan digunakan oleh Penjual.</p>
    </x-slot>

    <div class="mx-auto max-w-6xl space-y-6">

        @if (session('status'))
            <p class="rounded-lg bg-green-50 px-4 py-3 text-sm text-green-800">
                {{ session('status') }}
            </p>
        @endif

        @if (session('error'))
            <p class="rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </p>
        @endif

        @if ($errors->any())
            <div class="rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">
                @foreach ($errors->all() as $e)
                    <p>{{ $e }}</p>
                @endforeach
            </div>
        @endif

        {{-- Form tambah kategori --}}
        <form method="POST"
              action="{{ route('admin.categories.store') }}"
              class="rounded-xl border border-coklat-200 bg-white p-5">
            @csrf

            <h3 class="font-semibold text-coklat-950">Tambah kategori</h3>

            <div class="mt-4 grid gap-3 md:grid-cols-3">
                <div>
                    <label class="block text-xs font-medium text-coklat-600">
                        Nama kategori
                    </label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Contoh: Fashion"
                        required
                        class="mt-1 w-full rounded-lg border-coklat-200 text-sm focus:border-coklat-600 focus:ring-coklat-600">
                </div>

                <div>
                    <label class="block text-xs font-medium text-coklat-600">
                        Deskripsi (opsional)
                    </label>
                    <input
                        type="text"
                        name="description"
                        value="{{ old('description') }}"
                        placeholder="Deskripsi kategori"
                        class="mt-1 w-full rounded-lg border-coklat-200 text-sm focus:border-coklat-600 focus:ring-coklat-600">
                </div>

                <div class="flex items-end">
                    <button
                        type="submit"
                        class="w-full rounded-lg bg-coklat-700 px-5 py-2 text-sm font-semibold text-white hover:bg-coklat-800">
                        Simpan
                    </button>
                </div>
            </div>
        </form>

        {{-- Pencarian --}}
        <form method="GET" class="flex flex-wrap gap-2">
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Cari kategori"
                class="w-64 rounded-lg border-coklat-200 text-sm focus:border-coklat-600 focus:ring-coklat-600">

            <button
                type="submit"
                class="rounded-lg bg-coklat-700 px-5 py-2 text-sm font-semibold text-white hover:bg-coklat-800">
                Cari
            </button>

            @if (request('q'))
                <a
                    href="{{ route('admin.categories.index') }}"
                    class="rounded-lg border border-coklat-200 px-5 py-2 text-sm font-medium text-coklat-700 hover:bg-coklat-50">
                    Reset
                </a>
            @endif
        </form>

        {{-- Tabel kategori --}}
        <div class="overflow-x-auto rounded-xl border border-coklat-300 bg-white">
            <table class="w-full border-collapse text-left text-sm">
                <thead>
                    <tr class="bg-coklat-700 text-xs uppercase tracking-wide text-white">
                        <th class="border border-coklat-600 px-4 py-3">Nama</th>
                        <th class="border border-coklat-600 px-4 py-3">Deskripsi</th>
                        <th class="border border-coklat-600 px-4 py-3 text-center">Barang</th>
                        <th class="border border-coklat-600 px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($categories as $c)
                        <tr class="bg-white text-coklat-950">
                            <td class="border border-coklat-200 px-4 py-3 font-semibold">
                                {{ $c->name }}
                            </td>

                            <td class="border border-coklat-200 px-4 py-3 text-coklat-700">
                                {{ $c->description ?: '-' }}
                            </td>

                            <td class="border border-coklat-200 px-4 py-3 text-center">
                                {{ $c->products_count }}
                            </td>

                            <td class="border border-coklat-200 px-4 py-3 text-center whitespace-nowrap">
                                <a
                                    href="{{ route('admin.categories.edit', $c) }}"
                                    class="font-medium text-coklat-700 hover:underline">
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('admin.categories.destroy', $c) }}"
                                    class="ml-3 inline"
                                    onsubmit="return confirm('Yakin ingin menghapus kategori {{ $c->name }}?')">
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="font-medium text-red-600 hover:underline">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="border border-coklat-200 px-4 py-10 text-center text-coklat-500">
                                Belum ada kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>