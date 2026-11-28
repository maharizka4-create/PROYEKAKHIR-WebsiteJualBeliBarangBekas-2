
<x-admin-layout>
    <x-slot name="header">
        <h2>Edit Kategori</h2>
        <p>Ubah nama atau deskripsi kategori barang.</p>
    </x-slot>

    <div class="mx-auto max-w-2xl">

        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">
                @foreach ($errors->all() as $e)
                    <p>{{ $e }}</p>
                @endforeach
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('admin.categories.update', $category) }}"
            class="space-y-5 rounded-xl border border-coklat-200 bg-white p-6">

            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-coklat-800">
                    Nama Kategori
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $category->name) }}"
                    required
                    maxlength="100"
                    class="mt-1 w-full rounded-lg border-coklat-200 text-sm focus:border-coklat-600 focus:ring-coklat-600">
            </div>

            <div>
                <label class="block text-sm font-medium text-coklat-800">
                    Deskripsi (opsional)
                </label>

                <input
                    type="text"
                    name="description"
                    value="{{ old('description', $category->description) }}"
                    maxlength="255"
                    class="mt-1 w-full rounded-lg border-coklat-200 text-sm focus:border-coklat-600 focus:ring-coklat-600">
            </div>

            <div class="flex gap-3">
                <button
                    type="submit"
                    class="rounded-lg bg-coklat-700 px-6 py-2 text-sm font-semibold text-white hover:bg-coklat-800">
                    Simpan
                </button>

                <a
                    href="{{ route('admin.categories.index') }}"
                    class="rounded-lg border border-coklat-200 px-6 py-2 text-sm font-medium text-coklat-700 hover:bg-coklat-50">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>