<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public const MENUNGGU_PEMBAYARAN = 'menunggu_pembayaran';
    public const DIBAYAR = 'dibayar';
    public const DIKIRIM = 'dikirim';
    public const SELESAI = 'selesai';
    public const DIBATALKAN = 'dibatalkan';

    protected $fillable = [
        'kode',
        'user_id',
        'total_harga',
        'status',
        'metode_pembayaran',
        'bukti_pembayaran',
        'dibayar_pada',
        'alamat_pengiriman',
        'diterima_pada',
    ];

    protected function casts(): array
    {
        return [
            'total_harga' => 'integer',
            'dibayar_pada' => 'datetime',
            'diterima_pada' => 'datetime',
        ];
    }

    // Relasi ke akun pembeli
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Alias relasi pembeli
    public function pembeli(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke detail pesanan
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}