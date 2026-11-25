<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            // pembeli
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->unsignedBigInteger('total_harga')->default(0);
            $table->enum('status', [
                'menunggu_pembayaran',
                'dibayar',
                'dikirim',
                'selesai',
                'dibatalkan',
            ])->default('menunggu_pembayaran');
            $table->string('metode_pembayaran')->nullable();
            $table->timestamp('dibayar_pada')->nullable();
            $table->text('alamat_pengiriman')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};