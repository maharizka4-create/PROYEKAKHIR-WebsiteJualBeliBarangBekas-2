<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    public const MENUNGGU = 'pending';
    public const DISETUJUI = 'approved';
    public const DITOLAK = 'rejected';

    protected $fillable = [
        'user_id',
        'category',
        'name',
        'description',
        'price',
        'stock',
        'condition',
        'image',
        'status',
    ];

    public function penjual(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
