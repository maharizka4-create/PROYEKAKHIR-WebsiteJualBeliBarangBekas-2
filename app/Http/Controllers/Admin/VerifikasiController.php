<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    // Daftar barang yang menunggu verifikasi
    public function index(Request $request)
    {
        $products = Product::with(['penjual', 'category'])
            ->where('status_persetujuan', Product::MENUNGGU)
            ->when($request->q, function ($query, $cari) {
                $query->where('nama', 'like', '%' . $cari . '%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.verifikasi.index', compact('products'));
    }

    // Setujui barang
    public function setujui(Product $product)
    {
        $product->update([
            'status_persetujuan' => Product::DISETUJUI,
            'alasan_penolakan' => null,
            'diperiksa_oleh' => auth()->id(),
            'diperiksa_pada' => now(),
        ]);

        return back()->with('success', 'Barang "' . $product->nama . '" disetujui.');
    }

    // Tolak barang (alasan wajib diisi)
    public function tolak(Request $request, Product $product)
    {
        $data = $request->validate([
            'alasan_penolakan' => ['required', 'string', 'max:500'],
        ], [
            'alasan_penolakan.required' => 'Alasan penolakan wajib diisi.',
            'alasan_penolakan.max' => 'Alasan penolakan maksimal 500 karakter.',
        ]);

        $product->update([
            'status_persetujuan' => Product::DITOLAK,
            'alasan_penolakan' => $data['alasan_penolakan'],
            'diperiksa_oleh' => auth()->id(),
            'diperiksa_pada' => now(),
        ]);

        return back()->with('success', 'Barang "' . $product->nama . '" ditolak.');
    }
}