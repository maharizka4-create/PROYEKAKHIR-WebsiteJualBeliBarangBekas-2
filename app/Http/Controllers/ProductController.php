<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Menampilkan daftar produk milik penjual
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
        return view('penjual.products.create');
    }

    // Menyimpan produk baru
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'condition' => 'required|in:seperti_baru,baik,cukup',
            'price' => 'required|numeric|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data['user_id'] = $request->user()->id;
        $data['stock'] = 1;
        $data['status'] = 'pending';

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('products', 'public');
        }

        Product::create($data);

        return redirect()
            ->route('penjual.products.index')
            ->with('success', 'Produk berhasil ditambahkan dan menunggu persetujuan Admin.');
    }

    // Menampilkan detail produk
    public function show(Request $request, Product $product): View
    {
        $this->authorizeOwner($request, $product);

        return view('penjual.products.show', compact('product'));
    }

    // Form edit produk
    public function edit(Request $request, Product $product): View
    {
        $this->authorizeOwner($request, $product);

        abort_if($product->status === 'sold', 403);

        return view('penjual.products.edit', compact('product'));
    }

    // Memperbarui produk
    public function update(
        Request $request,
        Product $product
    ): RedirectResponse {

        $this->authorizeOwner($request, $product);

        abort_if($product->status === 'sold', 403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'condition' => 'required|in:seperti_baru,baik,cukup',
            'price' => 'required|numeric|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {

            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = $request->file('image')
                ->store('products', 'public');
        }

        // Produk yang diedit harus disetujui Admin kembali
        $data['status'] = 'pending';

        $product->update($data);

        return redirect()
            ->route('penjual.products.index')
            ->with('success', 'Produk berhasil diperbarui dan menunggu persetujuan Admin.');
    }

    // Menghapus produk
    public function destroy(
        Request $request,
        Product $product
    ): RedirectResponse {

        $this->authorizeOwner($request, $product);

        abort_if($product->status === 'sold', 403);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('penjual.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    // Memastikan produk hanya dapat dikelola pemiliknya
    private function authorizeOwner(
        Request $request,
        Product $product
    ): void {

        abort_unless(
            (int) $product->user_id === (int) $request->user()->id,
            403
        );
    }
}