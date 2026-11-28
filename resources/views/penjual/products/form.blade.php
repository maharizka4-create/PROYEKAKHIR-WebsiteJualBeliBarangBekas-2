<div>
    <label class="block font-semibold mb-2">Kategori</label>

    <select name="category" class="w-full border rounded-lg p-3" required>
        <option value="">Pilih Kategori</option>

        @foreach ($categories as $kategori)
            <option value="{{ $kategori->name }}"
                @selected(old('category', $product->category ?? '') == $kategori->name)>
                {{ $kategori->name }}
            </option>
        @endforeach
    </select>

    @if ($categories->isEmpty())
        <p class="text-amber-600 text-sm mt-2">
            Belum ada kategori. Silakan hubungi Admin untuk menambahkan kategori.
        </p>
    @endif

    @error('category')
        <p class="text-red-600 text-sm">{{ $message }}</p>
    @enderror
</div>

<div>
    <label class="block font-semibold mb-2">Nama Produk</label>
    <input type="text" name="nama"
        value="{{ old('nama', $product->name ?? '') }}"
        class="w-full border rounded-lg p-3" required>

    @error('nama')
        <p class="text-red-600 text-sm">{{ $message }}</p>
    @enderror
</div>

<div>
    <label class="block font-semibold mb-2">Deskripsi</label>
    <textarea name="deskripsi" rows="4"
        class="w-full border rounded-lg p-3" required>{{ old('deskripsi', $product->description ?? '') }}</textarea>

    @error('deskripsi')
        <p class="text-red-600 text-sm">{{ $message }}</p>
    @enderror
</div>

<div>
    <label class="block font-semibold mb-2">Kondisi Barang</label>
    <select name="kondisi" class="w-full border rounded-lg p-3" required>
        <option value="">Pilih Kondisi</option>
        <option value="seperti_baru" @selected(old('kondisi', $product->condition ?? '') === 'seperti_baru')>Seperti Baru</option>
        <option value="baik" @selected(old('kondisi', $product->condition ?? '') === 'baik')>Baik</option>
        <option value="cukup" @selected(old('kondisi', $product->condition ?? '') === 'cukup')>Cukup</option>
    </select>

    @error('kondisi')
        <p class="text-red-600 text-sm">{{ $message }}</p>
    @enderror
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block font-semibold mb-2">Harga (Rupiah)</label>
        <input type="number" name="harga" min="1"
            value="{{ old('harga', $product->price ?? '') }}"
            class="w-full border rounded-lg p-3" required>

        @error('harga')
            <p class="text-red-600 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block font-semibold mb-2">Stok</label>
        <input type="number" name="stok" min="1"
            value="{{ old('stok', $product->stock ?? 1) }}"
            class="w-full border rounded-lg p-3" required>

        @error('stok')
            <p class="text-red-600 text-sm">{{ $message }}</p>
        @enderror
    </div>
</div>

<div>
    <label class="block font-semibold mb-2">Foto Produk</label>

    @if (isset($product) && $product->image)
        <img src="{{ asset('storage/'.$product->image) }}"
            class="w-32 h-32 object-cover rounded-lg mb-3"
            alt="Foto produk">
    @endif

    <input type="file" name="foto"
        accept="image/jpeg,image/png,image/webp"
        class="w-full border rounded-lg p-3">

    @error('foto')
        <p class="text-red-600 text-sm">{{ $message }}</p>
    @enderror

    <p class="text-sm text-gray-500 mt-1">
        Format JPG, PNG, atau WEBP. Maksimal 2 MB.
        @if (isset($product) && $product->exists)
            Kosongkan jika tidak ingin mengganti foto.
        @endif
    </p>
</div>