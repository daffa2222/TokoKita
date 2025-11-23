<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // List Produk Saya
    public function index()
    {
        // Ambil produk HANYA milik toko yang sedang login
        $storeId = auth()->user()->store->id;
        $products = Product::where('store_id', $storeId)->latest()->paginate(10);
        
        return view('seller.products.index', compact('products'));
    }

    // Form Tambah Produk
    public function create()
    {
        $categories = Category::all();
        return view('seller.products.create', compact('categories'));
    }

    // Proses Simpan Produk
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload Gambar
        $path = $request->file('image')->store('products', 'public');

        // Simpan ke Database
        Product::create([
            'store_id' => auth()->user()->store->id, // Otomatis ID Toko Seller
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(5),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $path,
        ]);

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    // Form Edit Produk
    public function edit($id)
    {
        $storeId = auth()->user()->store->id;
        // Pastikan produk milik seller ini (keamanan)
        $product = Product::where('store_id', $storeId)->findOrFail($id);
        $categories = Category::all();

        return view('seller.products.edit', compact('product', 'categories'));
    }

    // Proses Update Produk
    public function update(Request $request, $id)
    {
        $storeId = auth()->user()->store->id;
        $product = Product::where('store_id', $storeId)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ];

        // Cek upload gambar baru
        if ($request->hasFile('image')) {
            if ($product->image) Storage::delete('public/' . $product->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    // Hapus Produk
    public function destroy($id)
    {
        $storeId = auth()->user()->store->id;
        $product = Product::where('store_id', $storeId)->findOrFail($id);
        
        // Hapus file gambar dari penyimpanan
        if ($product->image) Storage::delete('public/' . $product->image);
        
        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus.');
    }
}