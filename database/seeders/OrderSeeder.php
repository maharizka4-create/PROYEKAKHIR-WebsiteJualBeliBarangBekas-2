<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Pesanan contoh hanya memakai barang yang sudah disetujui admin
        $produk = Product::where('status_persetujuan', Product::DISETUJUI)->get();
        $pembeli = User::role(User::ROLE_USER)->get();

        if ($produk->isEmpty() || $pembeli->isEmpty()) {
            $this->command->warn('Belum ada barang berstatus disetujui atau akun user. Setujui minimal 1 barang dulu di halaman Verifikasi.');
            return;
        }

        // [berapa hari lalu, status, metode bayar, [[urutan produk, jumlah], ...]]
        $contoh = [
            [20, Order::SELESAI, 'transfer_bank', [[0, 1]]],
            [15, Order::SELESAI, 'qris', [[1, 1]]],
            [10, Order::DIKIRIM, 'transfer_bank', [[0, 1], [1, 1]]],
            [7, Order::DIBAYAR, 'qris', [[1, 1]]],
            [5, Order::SELESAI, 'cod', [[0, 1]]],
            [3, Order::MENUNGGU_PEMBAYARAN, null, [[0, 1]]],
            [2, Order::DIBATALKAN, null, [[1, 1]]],
            [0, Order::DIBAYAR, 'qris', [[0, 1]]],
        ];

        foreach ($contoh as $i => [$hari, $status, $metode, $barang]) {
            $tanggal = now()->subDays($hari)->setTime(10 + $i, 0);
            $kode = 'INV-' . $tanggal->format('Ymd') . '-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT);
            $user = $pembeli[$i % $pembeli->count()];

            if (Order::where('kode', $kode)->exists()) {
                continue;
            }

            $order = new Order([
                'kode' => $kode,
                'user_id' => $user->id,
                'total_harga' => 0,
                'status' => $status,
                'metode_pembayaran' => $metode,
                'dibayar_pada' => in_array($status, [Order::DIBAYAR, Order::DIKIRIM, Order::SELESAI]) ? $tanggal : null,
                'alamat_pengiriman' => $user->address ?: 'Jl. Contoh No. 1, Bangkalan',
            ]);
            $order->created_at = $tanggal;
            $order->updated_at = $tanggal;
            $order->save();

            $total = 0;

            foreach ($barang as [$urutan, $jumlah]) {
                $p = $produk[$urutan % $produk->count()];
                $subtotal = $p->harga * $jumlah;
                $total += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $p->id,
                    'penjual_id' => $p->user_id,
                    'nama_barang' => $p->nama,
                    'harga' => $p->harga,
                    'jumlah' => $jumlah,
                    'subtotal' => $subtotal,
                ]);
            }

            $order->update(['total_harga' => $total]);
        }
    }
}