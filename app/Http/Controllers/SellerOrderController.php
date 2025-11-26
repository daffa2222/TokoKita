<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class SellerOrderController extends Controller
{
    // Melihat Pesanan Masuk
    public function index()
    {
        $storeId = auth()->user()->store->id;

        $orderItems = OrderItem::where('store_id', $storeId)
                        ->with(['order.user', 'product'])
                        ->latest()
                        ->paginate(10);

        return view('seller.orders.index', compact('orderItems'));
    }

    // TAMBAHAN: Update Status
    public function updateStatus(Request $request, $id)
    {
        $item = OrderItem::where('store_id', auth()->user()->store->id)
                    ->where('id', $id)
                    ->firstOrFail();

        $order = $item->order; // Ambil Order Induknya
        
        // Update status Order Induk
        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}