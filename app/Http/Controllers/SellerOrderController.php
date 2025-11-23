<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class SellerOrderController extends Controller
{
    // Melihat Pesanan Masuk
    public function index()
    {
        $storeId = auth()->user()->store->id;

        // Ambil item order yang ditujukan ke toko ini
        $orderItems = OrderItem::where('store_id', $storeId)
                        ->with(['order.user', 'product']) // Load data pembeli & produk
                        ->latest()
                        ->paginate(10);

        return view('seller.orders.index', compact('orderItems'));
    }
}