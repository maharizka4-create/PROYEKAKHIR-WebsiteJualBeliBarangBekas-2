<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $penjual = User::where('email', 'penjual@example.com')->first();
        $admin = User::where('email', 'admin@example.com')->first();

        if (! $penjual || ! $admin) {
            $this->command->warn('Akun penjual/admin belum ada. Jalankan UserSeeder dulu.');
            return;
        }

        $fashion = Category::firstOrCreate(['nama' => 'Fashion'], ['deskripsi' => 'Pakaian, sepatu, tas']);
        $elektronik = Category::firstOrCreate(['nama' => 'Elektronik'], ['deskripsi' => 'Gadget dan perangkat elektronik']);
        $buku = Category::firstOrCreate(['nama' => 'Buku'], ['deskripsi' => 'Buku dan alat tulis']);

        $data = [
            ['Jaket Denim Vintage', $fashion, 180000, 1, 'Seperti Baru', 'menunggu'],
            ['Sepatu Sneakers Putih', $fashion, 250000, 1, 'Baik', 'menunggu'],
            ['Headphone Bluetooth', $elektronik, 150000, 2, 'Baik', 'menunggu'],
            ['Novel Laskar Pelangi', $buku, 40000, 3, 'Cukup Baik', 'menunggu'],
            ['Kamera Mirrorless Bekas', $elektronik, 3500000, 1, 'Baik', 'disetujui'],
            ['Tas Ransel Rusak', $fashion, 20000, 1, 'Kurang Baik', 'ditolak'],
        ];

        foreach ($data as [$nama, $kategori, $harga, $stok, $kondisi, $status]) {
            Product::firstOrCreate(
                ['user_id' => $penjual->id, 'nama' => $nama],
                [
                    'category_id' => $kategori->id,
                    'deskripsi' => 'Barang bekas layak pakai, kondisi sesuai deskripsi.',
                    'harga' => $harga,
                    'stok' => $stok,
                    'kondisi' => $kondisi,
                    'status_persetujuan' => $status,
                    'alasan_penolakan' => $status === 'ditolak' ? 'Foto dan kondisi barang tidak sesuai.' : null,
                    'diperiksa_oleh' => $status === 'menunggu' ? null : $admin->id,
                    'diperiksa_pada' => $status === 'menunggu' ? null : now(),
                ]
            );
        }
    }
}