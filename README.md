# SEKENOVA - Website Jual Beli Barang Bekas

> Every item deserves a second story.

SEKENOVA adalah website jual beli barang bekas. Penjual menitipkan barang, admin memverifikasi barang tersebut, dan pembeli bisa melihat serta membeli barang yang sudah disetujui.

Project ini dibuat untuk UAS mata kuliah Pemrograman Berbasis Web Lanjut (PBWL).

## Anggota Kelompok

| Nama | NIM | Bagian |
|------|-----|--------|
| Rika Trismawati | 250441100056 | Admin |
| Juliansah Khoirul Umam | 250441100012 | Penjual |
| (isi nama teman) | (isi NIM) | User |

## Teknologi

- Laravel 13 (PHP 8.4)
- Laravel Breeze (Blade), Tailwind CSS, Alpine.js
- Spatie Laravel-Permission (role)
- Laravel Sanctum (REST API)
- MySQL (lokal)

## Fitur Admin

- Dashboard statistik (data diambil dari REST API)
- CRUD Kategori
- Verifikasi barang (setujui atau tolak dengan alasan)
- Daftar barang dan Detail (hanya lihat)
- Laporan transaksi (filter tanggal dan status)
- Kelola user (aktif/nonaktif dan ubah role)

## REST API

| Method | Endpoint | Keterangan | Akses |
|--------|----------|------------|-------|
| POST | /api/login | Login dan dapat token | Publik |
| POST | /api/logout | Logout | Login |
| GET | /api/admin/statistik | Statistik dashboard | Admin |
| GET | /api/admin/products | Daftar barang | Admin |
| GET | /api/admin/products/{id} | Detail barang | Admin |

## Cara Install (Lokal)

1. `git clone <url-repo>` lalu `git switch dev`
2. `composer install` dan `npm install`
3. `cp .env.example .env` lalu `php artisan key:generate`
4. Atur database di file `.env`
5. `php artisan migrate --seed`
6. `npm run build` lalu `php artisan serve`
7. Buka `http://localhost:8000`

## Akun Contoh (hanya lokal)

Password semua akun contoh: `password`

(isi email admin, penjual, dan user dari seeder)

## Link Deploy

(diisi setelah deploy)
