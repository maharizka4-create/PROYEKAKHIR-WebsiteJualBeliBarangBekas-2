<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'description', 'parent_id'];

    // Kategori induk (kosong kalau ini kategori utama)
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Jenis-jenis di dalam kategori ini
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('name');
    }

    // Barang yang memakai kategori/jenis ini
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    // Hanya kategori utama (bukan jenis)
    public function scopeUtama($query)
    {
        return $query->whereNull('parent_id');
    }
}