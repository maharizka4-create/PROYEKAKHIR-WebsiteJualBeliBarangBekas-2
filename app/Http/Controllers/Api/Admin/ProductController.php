<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // GET /api/admin/products?status=menunggu&q=jaket&kategori=1
    public function index(Request $request)
    {
        $request->validate([
            'status' => ['nullable', 'in:menunggu,disetujui,ditolak'],
        ]);

        $products = Product::with(['penjual', 'category'])
            ->when($request->q, fn ($query, $cari) => $query->where('nama', 'like', '%' . $cari . '%'))
            ->when($request->status, fn ($query, $status) => $query->where('status_persetujuan', $status))
            ->when($request->kategori, fn ($query, $kategori) => $query->where('category_id', $kategori))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return response()->json([
            'data' => $products->getCollection()->map(fn ($p) => $this->format($p))->values(),
            'meta' => [
                'halaman' => $products->currentPage(),
                'terakhir' => $products->lastPage(),
                'total' => $products->total(),
            ],
        ]);
    }

    // GET /api/admin/products/{product}
    public function show(Product $product)
    {
        $product->load(['penjual', 'category', 'pemeriksa']);

        return response()->json(['data' => $this->format($product)]);
    }

    private function format(Product $p): array
    {
        return [
            'id' => $p->id,
            'nama' => $p->nama,
            'deskripsi' => $p->deskripsi,
            'harga' => $p->harga,
            'stok' => $p->stok,
            'kondisi' => $p->kondisi,
            'kategori' => $p->category->name ?? null,
            'penjual' => $p->penjual->name ?? null,
            'status_persetujuan' => $p->status_persetujuan,
            'alasan_penolakan' => $p->alasan_penolakan,
            'diperiksa_oleh' => $p->pemeriksa->name ?? null,
            'diperiksa_pada' => $p->diperiksa_pada?->toDateTimeString(),
        ];
    }
}