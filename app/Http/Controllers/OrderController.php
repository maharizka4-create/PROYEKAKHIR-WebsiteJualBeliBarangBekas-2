<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    // ========================================
    // MENAMPILKAN HALAMAN CHECKOUT
    // ========================================

    public function create(Product $product): View
    {
        abort_unless(
            $product->status === 'approved' && $product->stock > 0,
            404,
            'Produk tidak tersedia.'
        );

        abort_if(
            (int) $product->user_id === (int) auth()->id(),
            403,
            'Kamu tidak dapat membeli produk milik sendiri.'
        );

        return view('orders.checkout', compact('product'));
    }


    // ========================================
    // MENYIMPAN TRANSAKSI PEMBELIAN
    // ========================================

    public function store(
        Request $request,
        Product $product
    ): RedirectResponse {

        $data = $request->validate([
            'jumlah' => ['required', 'integer', 'min:1'],
            'alamat_pengiriman' => ['required', 'string', 'max:2000'],
            'metode_pembayaran' => ['required', 'in:transfer,cod'],
        ]);

        $order = DB::transaction(function () use (
            $request,
            $product,
            $data
        ) {

            $lockedProduct = Product::whereKey($product->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedProduct->status !== 'approved') {
                throw ValidationException::withMessages([
                    'produk' => 'Produk tidak tersedia.',
                ]);
            }

            if ($lockedProduct->stock < $data['jumlah']) {
                throw ValidationException::withMessages([
                    'jumlah' => 'Stok produk tidak mencukupi.',
                ]);
            }

            if (
                (int) $lockedProduct->user_id ===
                (int) $request->user()->id
            ) {
                throw ValidationException::withMessages([
                    'produk' => 'Kamu tidak dapat membeli produk sendiri.',
                ]);
            }

            $harga = (int) round((float) $lockedProduct->price);
            $jumlah = (int) $data['jumlah'];
            $subtotal = $harga * $jumlah;

            $order = Order::create([
                'kode' => 'SKN-' . now()->format('YmdHis')
                    . '-' . Str::upper(Str::random(5)),

                'user_id' => $request->user()->id,
                'total_harga' => $subtotal,
                'status' => Order::MENUNGGU_PEMBAYARAN,
                'metode_pembayaran' => $data['metode_pembayaran'],
                'alamat_pengiriman' => $data['alamat_pengiriman'],
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $lockedProduct->id,
                'penjual_id' => $lockedProduct->user_id,
                'nama_barang' => $lockedProduct->name,
                'harga' => $harga,
                'jumlah' => $jumlah,
                'subtotal' => $subtotal,
            ]);

            $lockedProduct->decrement('stock', $jumlah);

            return $order;
        });

        return redirect()
            ->route('user.orders.index')
            ->with(
                'success',
                'Pesanan berhasil dibuat. Kode pesanan: ' . $order->kode
            );
    }


    // ========================================
    // UPLOAD BUKTI PEMBAYARAN TRANSFER
    // ========================================

    public function uploadBukti(
        Request $request,
        Order $order
    ): RedirectResponse {

        abort_unless(
            (int) $order->user_id === (int) $request->user()->id,
            403
        );

        $data = $request->validate([
            'bukti_pembayaran' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $newPath = null;

        try {

            $newPath = $data['bukti_pembayaran']
                ->store('bukti-pembayaran', 'public');

            if (!$newPath) {
                throw new \RuntimeException(
                    'Gagal menyimpan bukti pembayaran.'
                );
            }

            $oldPath = DB::transaction(function () use (
                $order,
                $newPath
            ) {

                $lockedOrder = Order::whereKey($order->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if (
                    $lockedOrder->metode_pembayaran !== 'transfer' ||
                    $lockedOrder->status !== Order::MENUNGGU_PEMBAYARAN
                ) {
                    throw ValidationException::withMessages([
                        'pembayaran' => 'Pesanan tidak dapat menerima bukti pembayaran.',
                    ]);
                }

                $oldPath = $lockedOrder->bukti_pembayaran;

                $lockedOrder->update([
                    'bukti_pembayaran' => $newPath,
                ]);

                return $oldPath;
            });

            if ($oldPath) {
                Storage::disk('public')->delete($oldPath);
            }

        } catch (\Throwable $e) {

            if ($newPath) {
                Storage::disk('public')->delete($newPath);
            }

            throw $e;
        }

        return back()->with(
            'success',
            'Bukti pembayaran berhasil diunggah dan menunggu verifikasi Admin.'
        );
    }


    // ========================================
    // MENAMPILKAN RIWAYAT PEMBELIAN
    // ========================================

    public function index(Request $request): View
    {
        $orders = Order::with('items')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('user.orders.index', compact('orders'));
    }


    // ========================================
    // KONFIRMASI BARANG SUDAH DITERIMA
    // ========================================

    public function konfirmasiDiterima(
        Request $request,
        Order $order
    ): RedirectResponse {

        abort_unless(
            (int) $order->user_id === (int) $request->user()->id,
            403,
            'Kamu tidak memiliki akses ke pesanan ini.'
        );

        DB::transaction(function () use ($order) {

            $lockedOrder = Order::whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedOrder->status !== Order::DIKIRIM) {
                throw ValidationException::withMessages([
                    'pesanan' => 'Pesanan belum dikirim atau sudah selesai.',
                ]);
            }

            if (!in_array(
                $lockedOrder->metode_pembayaran,
                ['transfer', 'cod'],
                true
            )) {
                throw ValidationException::withMessages([
                    'pembayaran' => 'Metode pembayaran tidak valid.',
                ]);
            }

            // Transfer wajib sudah diverifikasi Admin.
            if (
                $lockedOrder->metode_pembayaran === 'transfer' &&
                !$lockedOrder->dibayar_pada
            ) {
                throw ValidationException::withMessages([
                    'pembayaran' => 'Pembayaran transfer belum diverifikasi Admin.',
                ]);
            }

            // COD dibayar ketika barang diterima.
            $lockedOrder->update([
                'status' => Order::SELESAI,
                'diterima_pada' => now(),

                'dibayar_pada' =>
                    $lockedOrder->metode_pembayaran === 'cod'
                        ? now()
                        : $lockedOrder->dibayar_pada,
            ]);
        });

        return redirect()
            ->route('user.orders.index')
            ->with(
                'success',
                'Terima kasih! Pesanan berhasil dikonfirmasi sudah diterima.'
            );
    }
}