<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Produk milik Toko
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    // Produk masuk Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Produk punya banyak Ulasan
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}