<div>
    <label class="block font-semibold mb-2">Nama Produk</label>
    <input type="text" name="name"
           value="{{ old('name', $product->name ?? '') }}"
           class="w-full border rounded-lg p-3"
           required>
    @error('name')
        <p class="text-red-600 text-sm">{{ $message }}</p>
    @enderror
</div>

<div>
    <label class="block font-semibold mb-2">Deskripsi</label>
    <textarea name="description" rows="4"
              class="w-full border rounded-lg p-3"
              required>{{ old('description', $product->description ?? '') }}</textarea>
    @error('description')
        <p class="text-red-600 text-sm">{{ $message }}</p>
    @enderror
</div>

<div>
    <label class="block font-semibold mb-2">Kategori</label>
    <input type="text" name="category"
           value="{{ old('category', $product->category ?? '') }}"
           class="w-full border rounded-lg p-3"
           required>
    @error('category')
        <p class="text-red-600 text-sm">{{ $message }}</p>
    @enderror
</div>

<div>
    <label class="block font-semibold mb-2">Kondisi Barang</label>
    <select name="condition" class="w-full border rounded-lg p-3" required>
        <option value="">Pilih Kondisi</option>
        <option value="seperti_baru"
            @selected(old('condition', $product->condition ?? '') === 'seperti_baru')>
            Seperti Baru
        </option>
        <option value="baik"
            @selected(old('condition', $product->condition ?? '') === 'baik')>
            Baik
        </option>
        <option value="cukup"
            @selected(old('condition', $product->condition ?? '') === 'cukup')>
            Cukup
        </option>
    </select>
    @error('condition')
        <p class="text-red-600 text-sm">{{ $message }}</p>
    @enderror
</div>

<div>
    <label class="block font-semibold mb-2">Harga (Rupiah)</label>
    <input type="number" name="price" min="1"
           value="{{ old('price', $product->price ?? '') }}"
           class="w-full border rounded-lg p-3"
           required>
    @error('price')
        <p class="text-red-600 text-sm">{{ $message }}</p>
    @enderror
</div>

<div>
    <label class="block font-semibold mb-2">Foto Produk</label>

    @if(isset($product) && $product->image)
        <img src="{{ asset('storage/'.$product->image) }}"
             class="w-32 h-32 object-cover rounded-lg mb-3"
             alt="Foto produk">
    @endif

    <input type="file" name="image"
           accept="image/jpeg,image/png,image/webp"
           class="w-full border rounded-lg p-3">

    @error('image')
        <p class="text-red-600 text-sm">{{ $message }}</p>
    @enderror

    <p class="text-sm text-gray-500 mt-1">
        Format JPG, PNG, atau WEBP. Maksimal 2 MB.
    </p>
</div>