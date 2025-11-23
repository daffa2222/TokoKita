<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Relasi ke Produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke Toko (Penting buat Seller Dashboard)
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    // Relasi ke Order Utama
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}