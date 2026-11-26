<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Kategori</h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-4">
                    @csrf @method('PUT')

                    <div>
                        <x-input-label for="name" value="Nama" />
                        <x-text-input id="name" name="name" class="block mt-1 w-full" :value="old('name', $category->name)" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Deskripsi" />
                        <x-text-input id="description" name="description" class="block mt-1 w-full" :value="old('description', $category->description)" />
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>Simpan</x-primary-button>
                        <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-600 underline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
