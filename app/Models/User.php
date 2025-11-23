<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        // --- TAMBAHAN KHUSUS TOKOKITA ---
        'role',           // 'admin', 'seller', 'buyer'
        'seller_status',  // 'pending', 'approved', 'rejected'
        'phone',          // Nomor HP
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ==========================================
    // RELASI ANTAR TABEL (RELATIONSHIPS)
    // ==========================================

    /**
     * Relasi: User (Seller) hanya punya 1 Toko.
     */
    public function store()
    {
        return $this->hasOne(Store::class);
    }

    /**
     * Relasi: User (Buyer) bisa punya banyak Pesanan (Order).
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Relasi: User bisa punya banyak Alamat Pengiriman.
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Relasi: User punya banyak barang di Keranjang (Cart).
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Relasi: User bisa memberikan banyak Ulasan (Review).
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Relasi: User bisa menyukai banyak produk (Wishlist).
     */
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}