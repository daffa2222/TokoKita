<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureSellerApproved
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Cek apakah dia Seller
        if ($user && $user->role === 'seller') {
            
            // Jika status masih pending
            if ($user->seller_status === 'pending') {
                return redirect()->route('seller.pending');
            }

            // Jika status ditolak (rejected)
            if ($user->seller_status === 'rejected') {
                // Arahkan ke halaman pending juga, tapi nanti tampilannya beda
                return redirect()->route('seller.pending');
            }
        }

        return $next($request);
    }
}