<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Daftar semua barang (admin hanya melihat)
    public function index(Request $request)
    {
        $products = Product::with(['penjual', 'category'])
            ->when($request->q, function ($query, $cari) {
                $query->where('nama', 'like', '%' . $cari . '%');
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status_persetujuan', $status);
            })
            ->when($request->kategori, function ($query, $kategori) {
                $query->where('category_id', $kategori);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    // Detail satu barang
    public function show(Product $product)
    {
        $product->load(['penjual', 'category', 'pemeriksa']);

        return view('admin.products.show', compact('product'));
    }
}