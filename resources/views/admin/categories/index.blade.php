<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Kategori</h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('status'))
                <div class="p-4 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-medium text-gray-800 mb-3">Tambah kategori</h3>
                <form method="POST" action="{{ route('admin.categories.store') }}" class="grid gap-3 sm:grid-cols-3">
                    @csrf
                    <div>
                        <x-text-input name="name" class="block w-full" placeholder="Nama kategori" :value="old('name')" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>
                    <div>
                        <x-text-input name="description" class="block w-full" placeholder="Deskripsi (opsional)" :value="old('description')" />
                        <x-input-error :messages="$errors->get('description')" class="mt-1" />
                    </div>
                    <div>
                        <x-primary-button>Simpan</x-primary-button>
                    </div>
                </form>
            </div>

            <form method="GET" class="flex gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kategori"
                       class="border-gray-300 rounded-md shadow-sm text-sm">
                <button class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm">Cari</button>
            </form>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-left text-gray-600">
                        <tr>
                            <th class="px-6 py-3">Nama</th>
                            <th class="px-6 py-3">Deskripsi</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($categories as $c)
                            <tr>
                                <td class="px-6 py-3">{{ $c->name }}</td>
                                <td class="px-6 py-3">{{ $c->description }}</td>
                                <td class="px-6 py-3 flex gap-4">
                                    <a href="{{ route('admin.categories.edit', $c) }}" class="text-indigo-600 hover:underline">Edit</a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $c) }}"
                                          onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-6 py-6 text-center text-gray-500">Belum ada kategori.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $categories->links() }}
        </div>
    </div>
</x-admin-layout>
