<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    // Menampilkan katalog produk yang sudah disetujui Admin
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'string', 'max:100'],
            'condition' => [
                'nullable',
                'in:seperti_baru,baik,cukup',
            ],
        ]);

        $products = Product::query()
            ->where('status', 'approved')
            ->where('stock', '>', 0)

            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })

            ->when($filters['category'] ?? null, function ($query, $category) {
                $query->where('category', $category);
            })

            ->when($filters['condition'] ?? null, function ($query, $condition) {
                $query->where('condition', $condition);
            })

            ->latest()
            ->paginate(12)
            ->withQueryString();

        // Mengambil kategori unik dari tabel produk
        $categories = Product::where('status', 'approved')
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('catalog.index', compact(
            'products',
            'filters',
            'categories'
        ));
    }

    // Menampilkan detail produk
    public function show(Product $product): View
    {
        abort_unless(
            $product->status === 'approved' &&
            $product->stock > 0,
            404
        );

        return view('catalog.show', compact('product'));
    }
}