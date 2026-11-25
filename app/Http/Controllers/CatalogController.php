<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    /**
     * Menampilkan katalog barang yang tersedia.
     */
    public function index(Request $request): View
    {
        // Validasi pencarian dan filter
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'string', 'max:100'],
            'condition' => [
                'nullable',
                'in:seperti_baru,baik,cukup',
            ],
        ]);

        // Mengambil produk yang sudah disetujui Admin
        // dan masih memiliki stok
        $products = Product::query()
            ->where('status', 'approved')
            ->where('stock', '>', 0)

            // Pencarian berdasarkan nama barang
            ->when(
                $filters['search'] ?? null,
                function ($query, $search) {
                    $query->where('name', 'like', '%' . $search . '%');
                }
            )

            // Filter kategori
            ->when(
                $filters['category'] ?? null,
                function ($query, $category) {
                    $query->where('category', $category);
                }
            )

            // Filter kondisi barang
            ->when(
                $filters['condition'] ?? null,
                function ($query, $condition) {
                    $query->where('condition', $condition);
                }
            )

            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('catalog.index', [
            'products' => $products,
            'filters' => $filters,
        ]);
    }

    /**
     * Menampilkan detail produk.
     */
    public function show(Product $product): View
    {
        // Produk hanya dapat dilihat jika sudah disetujui
        // dan stok masih tersedia
        abort_unless(
            $product->status === 'approved' &&
            $product->stock > 0,
            404
        );

        return view('catalog.show', [
            'product' => $product,
        ]);
    }
}