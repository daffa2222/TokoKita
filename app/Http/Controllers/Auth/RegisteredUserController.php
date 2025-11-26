<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store; // <--- JANGAN LUPA TAMBAHKAN INI
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str; // <--- TAMBAHKAN INI JUGA

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role' => ['required', 'string', 'in:buyer,seller'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $sellerStatus = null;
        if ($request->role === 'seller') {
            $sellerStatus = 'pending';
        }

        // 1. Buat User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'seller_status' => $sellerStatus,
            'password' => Hash::make($request->password),
        ]);

        // --- TAMBAHAN PENTING: BUAT TOKO OTOMATIS ---
        if ($request->role === 'seller') {
            Store::create([
                'user_id' => $user->id,
                'name' => 'Toko ' . $request->name, // Nama toko default: Toko Budi
                'slug' => Str::slug($request->name . '-' . Str::random(5)),
                'description' => 'Deskripsi toko belum diisi.',
            ]);
        }
        // ---------------------------------------------

        event(new Registered($user));

        // Redirect ke Login (sesuai request Anda sebelumnya agar tidak auto-login)
        return redirect()->route('login')->with('status', 'Registrasi berhasil! Silakan login.');
    }
}