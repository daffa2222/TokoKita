<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $guarded = []; // Semua kolom boleh diisi

    // Toko dimiliki 1 User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Toko punya banyak Produk
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}