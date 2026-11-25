<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Pemilik barang (penjual)
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Informasi barang bekas
            $table->string('name');
            $table->text('description');
            $table->string('category');
            $table->enum('condition', [
                'seperti_baru',
                'baik',
                'cukup',
            ]);

            // Harga dan stok
            $table->decimal('price', 15, 2);
            $table->unsignedInteger('stock')->default(1);

            // Lokasi penyimpanan foto produk
            $table->string('image')->nullable();

            // Status moderasi
            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'sold',
            ])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};