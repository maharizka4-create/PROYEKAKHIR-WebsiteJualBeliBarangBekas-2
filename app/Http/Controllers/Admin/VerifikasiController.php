<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;    

class VerifikasiController extends Controller
{
    // Daftar produk yang menunggu verifikasi
    public function index(Request $request)
    {
        $products = Product::with('penjual')
            ->where('status', Product::MENUNGGU)
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->q . '%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.verifikasi.index', compact('products'));
    }

    // Menyetujui produk
    public function setujui(Product $product)
    {
        $product->update([
            'status' => Product::DISETUJUI,
        ]);

        return back()->with(
            'success',
            'Produk "' . $product->name . '" berhasil disetujui.'
        );
    }

    // Menolak produk
    public function tolak(Request $request, Product $product)
    {
        $request->validate([
            'alasan_penolakan' => ['required', 'string', 'max:500'],
        ], [
            'alasan_penolakan.required' => 'Alasan penolakan wajib diisi.',
            'alasan_penolakan.max' => 'Alasan penolakan maksimal 500 karakter.',
        ]);

        $product->update([
            'status' => Product::DITOLAK,
        ]);

        return back()->with(
            'success',
            'Produk "' . $product->name . '" berhasil ditolak. Catatan alasan belum disimpan ke database.'
        );
    }
}