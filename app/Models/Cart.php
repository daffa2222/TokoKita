<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Item keranjang punya 1 User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Item keranjang merujuk ke 1 Produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}