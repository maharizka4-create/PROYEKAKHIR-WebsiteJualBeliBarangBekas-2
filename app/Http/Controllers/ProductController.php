<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    // Daftar produk milik penjual
    public function index(Request $request): View
    {
        $products = Product::where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('penjual.products.index', compact('products'));
    }

    // Form tambah produk
    public function create(): View
    {
        $product = new Product();
        $categories = Category::orderBy('name')->get();

        return view('penjual.products.create', compact('product', 'categories'));
    }

    // Simpan produk
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validasi($request);

        $data = $this->mapData($validated);

        $data['user_id'] = $request->user()->id;
        $data['status'] = Product::MENUNGGU;

        if ($request->hasFile('foto')) {
            $data['image'] = $request->file('foto')->store('products', 'public');
        }

        Product::create($data);

        return redirect()
            ->route('penjual.products.index')
            ->with('success', 'Produk berhasil ditambahkan dan menunggu persetujuan Admin.');
    }

    // Detail produk
    public function show(Request $request, Product $product): View
    {
        $this->authorizeOwner($request, $product);

        return view('penjual.products.show', compact('product'));
    }

    // Form edit
    public function edit(Request $request, Product $product): View
    {
        $this->authorizeOwner($request, $product);

        $categories = Category::orderBy('name')->get();

        return view('penjual.products.edit', compact('product', 'categories'));
    }

    // Update produk
    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->authorizeOwner($request, $product);

        $validated = $this->validasi($request);
        $data = $this->mapData($validated);

        $fotoLama = $product->image;

        if ($request->hasFile('foto')) {
            $data['image'] = $request->file('foto')->store('products', 'public');
        }

        $data['status'] = Product::MENUNGGU;

        $product->update($data);

        // Hapus foto lama setelah perubahan berhasil disimpan.
        if ($request->hasFile('foto') && $fotoLama) {
            Storage::disk('public')->delete($fotoLama);
        }

        return redirect()
            ->route('penjual.products.index')
            ->with('success', 'Produk berhasil diperbarui dan menunggu persetujuan Admin.');
    }

    // Hapus produk
    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $this->authorizeOwner($request, $product);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('penjual.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    // Validasi input form
    private function validasi(Request $request): array
    {
        return $request->validate([
            'category' => [
                'required',
                'string',
                Rule::exists('categories', 'name'),
            ],
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'kondisi' => ['required', 'in:seperti_baru,baik,cukup'],
            'harga' => ['required', 'numeric', 'min:1'],
            'stok' => ['required', 'integer', 'min:1'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }

    // Sesuaikan nama input form dengan kolom database.
    private function mapData(array $validated): array
    {
        return [
            'category' => $validated['category'],
            'name' => $validated['nama'],
            'description' => $validated['deskripsi'],
            'condition' => $validated['kondisi'],
            'price' => $validated['harga'],
            'stock' => $validated['stok'],
        ];
    }

    // Pastikan produk milik penjual yang sedang login.
    private function authorizeOwner(Request $request, Product $product): void
    {
        abort_unless(
            (int) $product->user_id === (int) $request->user()->id,
            403
        );
    }
}