<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    // Menampilkan barang milik pengguna yang login
    public function index(Request $request): Response
    {
        abort_unless($request->user()->hasRole('penjual'), 403);

        $products = Product::query()
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return Inertia::render('Products/Index', [
            'products' => $products,
        ]);
    }

    // Menampilkan form tambah barang
    public function create(Request $request): Response
    {
        abort_unless($request->user()->hasRole('penjual'), 403);

        return Inertia::render('Products/Create');
    }

    // Menyimpan barang baru
    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()->hasRole('penjual'), 403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => ['required', 'string', 'max:100'],
            'condition' => [
                'required',
                'in:seperti_baru,baik,cukup',
            ],
            'price' => ['required', 'numeric', 'min:1'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        // Pemilik dan status selalu ditentukan oleh server
        $data['user_id'] = $request->user()->id;
        $data['stock'] = 1;
        $data['status'] = 'pending';

        // Simpan foto ke storage Laravel
        if ($request->hasFile('image')) {
            $data['image'] = $request
                ->file('image')
                ->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('products.index');
    }

    // Menampilkan detail barang milik penjual
    public function show(Request $request, Product $product): Response
    {
        $this->authorizeOwner($request, $product);

        return Inertia::render('Products/Show', [
            'product' => $product,
        ]);
    }

    // Menampilkan form edit barang
    public function edit(Request $request, Product $product): Response
    {
        $this->authorizeOwner($request, $product);

        return Inertia::render('Products/Edit', [
            'product' => $product,
        ]);
    }

    // Memperbarui barang
    public function update(
        Request $request,
        Product $product
    ): RedirectResponse {
        $this->authorizeOwner($request, $product);

        abort_if($product->status === 'sold', 403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => ['required', 'string', 'max:100'],
            'condition' => ['required', 'in:seperti_baru,baik,cukup'],
            'price' => ['required', 'numeric', 'min:1'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request
                ->file('image')
                ->store('products', 'public');
        } else {
            unset($data['image']);
        }

        // Produk yang diedit perlu persetujuan admin kembali
        $data['status'] = 'pending';

        $product->update($data);

        return redirect()->route('products.index');
    }

    // Menghapus barang
    public function destroy(
        Request $request,
        Product $product
    ): RedirectResponse {
        $this->authorizeOwner($request, $product);

        abort_if($product->status === 'sold', 403);

        $product->delete();

        return redirect()->route('products.index');
    }

    // Memastikan produk milik pengguna yang login
    private function authorizeOwner(
        Request $request,
        Product $product
    ): void {
        abort_unless(
            $request->user()->hasRole('penjual')
                && $product->user_id === $request->user()->id,
            403
        );
    }
}