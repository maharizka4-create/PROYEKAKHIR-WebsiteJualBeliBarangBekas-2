<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request): View
    {
        // Validasi input pencarian dan filter
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'string', 'max:100'],
            'condition' => [
                'nullable',
                'in:seperti_baru,baik,cukup',
            ],
        ]);

        // Ambil barang yang sudah disetujui
        $products = Product::query()
            ->where('status', 'approved')
            ->where('stock', '>', 0)

            // Filter nama barang
            ->when(
                $filters['search'] ?? null,
                fn ($query, $search) =>
                    $query->where('name', 'ilike', '%' . $search . '%')
            )

            // Filter kategori
            ->when(
                $filters['category'] ?? null,
                fn ($query, $category) =>
                    $query->where('category', $category)
            )

            // Filter kondisi barang
            ->when(
                $filters['condition'] ?? null,
                fn ($query, $condition) =>
                    $query->where('condition', $condition)
            )

            ->latest()
            ->paginate(12)
            ->withQueryString();

        // Tampilkan katalog menggunakan Blade
        return view('catalog.index', [
            'products' => $products,
            'filters' => $filters,
        ]);
    }
    
    public function show(Product $product): View
{
    // Hanya produk yang disetujui admin
    // yang dapat dilihat oleh pengguna.
    abort_unless($product->status === 'approved', 404);

    return view('catalog.show', [
        'product' => $product,
    ]);
}

}