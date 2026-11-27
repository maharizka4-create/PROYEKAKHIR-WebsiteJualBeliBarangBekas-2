<x-admin-layout>
    <x-slot name="header">
        <h2>Edit {{ $category->parent_id ? 'Jenis' : 'Kategori' }}</h2>
        <p>Ubah nama, deskripsi, atau pindahkan ke kategori lain.</p>
    </x-slot>

    <div class="mx-auto max-w-2xl">
        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">
                @foreach ($errors->all() as $e)
                    <p>{{ $e }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-5 rounded-xl border border-coklat-200 bg-white p-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-coklat-800">Nama</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}"
                       class="mt-1 w-full rounded-lg border-coklat-200 text-sm focus:border-coklat-600 focus:ring-coklat-600">
            </div>

            <div>
                <label class="block text-sm font-medium text-coklat-800">Masuk ke kategori</label>
                @if ($category->children()->exists())
                    <p class="mt-1 rounded-lg bg-coklat-50 px-3 py-2 text-sm text-coklat-600">
                        Ini kategori utama dan punya {{ $category->children()->count() }} jenis, jadi tidak bisa dijadikan jenis.
                    </p>
                    <input type="hidden" name="parent_id" value="">
                @else
                    <select name="parent_id" class="mt-1 w-full rounded-lg border-coklat-200 text-sm focus:border-coklat-600 focus:ring-coklat-600">
                        <option value="">Kategori utama</option>
                        @foreach ($induk as $i)
                            <option value="{{ $i->id }}" @selected(old('parent_id', $category->parent_id) == $i->id)>Jenis dari: {{ $i->name }}</option>
                        @endforeach
                    </select>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-coklat-800">Deskripsi (opsional)</label>
                <input type="text" name="description" value="{{ old('description', $category->description) }}"
                       class="mt-1 w-full rounded-lg border-coklat-200 text-sm focus:border-coklat-600 focus:ring-coklat-600">
            </div>

            <div class="flex gap-3">
                <button type="submit" class="rounded-lg bg-coklat-700 px-6 py-2 text-sm font-semibold text-white hover:bg-coklat-800">Simpan</button>
                <a href="{{ route('admin.categories.index') }}" class="rounded-lg border border-coklat-200 px-6 py-2 text-sm font-medium text-coklat-700 hover:bg-coklat-50">Batal</a>
            </div>
        </form>
    </div>
</x-admin-layout>