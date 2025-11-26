<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * 1. TAMPILKAN DAFTAR USER
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * 2. HALAMAN TAMBAH USER BARU
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * 3. PROSES SIMPAN USER BARU
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
            'role' => ['required', 'in:admin,seller,buyer'],
        ]);

        // Jika membuat seller, langsung set status 'approved'
        $sellerStatus = null;
        if ($request->role === 'seller') {
            $sellerStatus = 'approved'; 
        }

        // Buat User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'seller_status' => $sellerStatus,
        ]);

        // Buat Toko Otomatis jika role-nya Seller
        if ($request->role === 'seller') {
            Store::create([
                'user_id' => $user->id,
                'name' => 'Toko ' . $user->name,
                'slug' => Str::slug($user->name . '-' . Str::random(5)),
                'description' => 'Deskripsi toko belum diisi.',
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    /**
     * 4. HALAMAN EDIT USER
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * 5. PROSES UPDATE USER (FULL CONTROL)
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'in:admin,seller,buyer'],
            'password' => ['nullable', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()], // Password bersifat opsional
        ]);

        // Siapkan data update dasar
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Logika Ubah Password: Hanya jika field password diisi
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        // Simpan role lama untuk pengecekan logika toko
        $oldRole = $user->role;
        
        // Eksekusi Update User
        $user->update($userData);

        // Logika 1: Jika Role berubah jadi Seller dan belum punya toko -> Buatkan Toko
        if ($request->role === 'seller' && $oldRole !== 'seller' && !$user->store) {
            $user->update(['seller_status' => 'approved']);
            Store::create([
                'user_id' => $user->id,
                'name' => 'Toko ' . $user->name,
                'slug' => Str::slug($user->name . '-' . Str::random(5)),
                'description' => 'Deskripsi toko belum diisi.',
            ]);
        }
        
        // Logika 2: Jika User adalah Seller, Admin bisa mengubah Nama Tokonya juga (dari input 'store_name')
        if ($request->role === 'seller' && $user->store && $request->has('store_name')) {
             $user->store->update([
                 'name' => $request->store_name,
                 'slug' => Str::slug($request->store_name . '-' . Str::random(5)) // Update slug juga biar rapi
             ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui sepenuhnya.');
    }

    /**
     * 6. HAPUS USER
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Mencegah Admin menghapus dirinya sendiri saat sedang login
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                             ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', "Pengguna **{$userName}** berhasil dihapus.");
    }
}