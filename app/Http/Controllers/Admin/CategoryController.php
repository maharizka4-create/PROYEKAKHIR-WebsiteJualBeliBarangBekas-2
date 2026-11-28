<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('products')
            ->when($request->filled('q'), function ($query) use ($request) {
                $kata = $request->q;

                $query->where('name', 'like', "%{$kata}%");
            })
            ->orderBy('name')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:categories,name',
            ],
            'description' => ['nullable', 'string', 'max:255'],
        ], [
            'name.unique' => 'Nama kategori sudah digunakan.',
        ]);

        Category::create($data);

        return back()->with('status', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categories', 'name')->ignore($category->id),
            ],
            'description' => ['nullable', 'string', 'max:255'],
        ], [
            'name.unique' => 'Nama kategori sudah digunakan.',
        ]);

        $namaLama = $category->name;

        $category->update($data);
        
        if ($namaLama !== $category->name) {
            Product::where('category', $namaLama)
                ->update(['category' => $category->name]);
        }
        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'Perubahan kategori berhasil disimpan.');
    }

    public function destroy(Category $category)
    {
        // Jangan hapus kategori yang masih dipakai produk.
        if ($category->products()->exists()) {
            return back()->with(
                'error',
                'Kategori tidak bisa dihapus karena masih digunakan oleh produk.'
            );
        }

        $category->delete();

        return back()->with('status', 'Kategori berhasil dihapus.');
    }
}