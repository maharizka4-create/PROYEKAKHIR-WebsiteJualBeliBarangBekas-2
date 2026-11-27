<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::utama()
            ->withCount('products')
            ->with(['children' => fn ($q) => $q->withCount('products')])
            ->when($request->q, function ($query, $kata) {
                $query->where(function ($w) use ($kata) {
                    $w->where('name', 'like', "%{$kata}%")
                        ->orWhereHas('children', fn ($c) => $c->where('name', 'like', "%{$kata}%"));
                });
            })
            ->orderBy('name')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => [
                'required', 'string', 'max:100',
                Rule::unique('categories', 'name')->where(fn ($q) => $q->where('parent_id', $request->parent_id)),
            ],
            'description' => ['nullable', 'string', 'max:255'],
            'parent_id' => ['nullable', Rule::exists('categories', 'id')->whereNull('parent_id')],
        ], [
            'name.unique' => 'Nama itu sudah dipakai di tempat yang sama.',
        ]);

        Category::create($data);

        return back()->with('status', $data['parent_id'] ?? null ? 'Jenis ditambahkan.' : 'Kategori ditambahkan.');
    }

    public function edit(Category $category)
    {
        $induk = Category::utama()
            ->where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();

        return view('admin.categories.edit', compact('category', 'induk'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => [
                'required', 'string', 'max:100',
                Rule::unique('categories', 'name')
                    ->where(fn ($q) => $q->where('parent_id', $request->parent_id))
                    ->ignore($category->id),
            ],
            'description' => ['nullable', 'string', 'max:255'],
            'parent_id' => [
                'nullable',
                Rule::exists('categories', 'id')->whereNull('parent_id'),
                Rule::notIn([$category->id]),
            ],
        ], [
            'name.unique' => 'Nama itu sudah dipakai di tempat yang sama.',
        ]);

        // Kategori yang sudah punya jenis tidak boleh dijadikan jenis (maksimal 2 tingkat)
        if (($data['parent_id'] ?? null) && $category->children()->exists()) {
            return back()
                ->withErrors(['parent_id' => 'Kategori yang punya jenis tidak bisa dijadikan jenis.'])
                ->withInput();
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('status', 'Perubahan disimpan.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('status', 'Kategori dihapus.');
    }
}