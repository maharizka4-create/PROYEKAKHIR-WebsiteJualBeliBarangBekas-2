<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Daftar semua produk
    public function index(Request $request)
    {
        $products = Product::with('penjual')
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->q . '%');
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->filled('kategori'), function ($query) use ($request) {
                $query->where('category', $request->kategori);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact(
            'products',
            'categories'
        ));
    }

    // Detail satu produk
    public function show(Product $product)
    {
        $product->load('penjual');

        return view('admin.products.show', compact('product'));
    }
}
