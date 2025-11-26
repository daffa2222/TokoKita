<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $storeId = auth()->user()->store->id;
        $products = Product::where('store_id', $storeId)->latest()->paginate(10);
        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('seller.products.create', compact('categories'));
    }

    // PROSES SIMPAN (VALIDASI DIPERKETAT)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            // Harga: Wajib angka, minimal 1 (tidak boleh 0 atau minus)
            'price' => 'required|numeric|min:1',
            // Stok: Wajib angka bulat, minimal 1 (tidak boleh 0 atau minus)
            'stock' => 'required|integer|min:1',
            // Gambar: Wajib file gambar (jpeg, png, jpg, gif, svg), maks 2MB
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            // Pesan Error Kustom (Opsional, agar lebih ramah)
            'price.min' => 'Harga tidak boleh nol atau negatif.',
            'stock.min' => 'Stok awal minimal 1.',
            'image.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'image.max' => 'Ukuran gambar maksimal 2MB.'
        ]);

        $path = $request->file('image')->store('products', 'public');

        Product::create([
            'store_id' => auth()->user()->store->id,
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

    public function edit($id)
    {
        $storeId = auth()->user()->store->id;
        $product = Product::where('store_id', $storeId)->findOrFail($id);
        $categories = Category::all();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    // PROSES UPDATE (VALIDASI DIPERKETAT)
    public function update(Request $request, $id)
    {
        $storeId = auth()->user()->store->id;
        $product = Product::where('store_id', $storeId)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            // Validasi Harga & Stok saat Edit juga harus ketat
            'price' => 'required|numeric|min:1',
            'stock' => 'required|integer|min:0', // Kalau edit boleh 0 (habis)
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ];

        if ($request->hasFile('image')) {
            if ($product->image) Storage::delete('public/' . $product->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        return redirect()->route('seller.products.index')->with('success', 'Produk diperbarui.');
    }

    public function destroy($id)
    {
        $storeId = auth()->user()->store->id;
        $product = Product::where('store_id', $storeId)->findOrFail($id);
        
        if ($product->image) Storage::delete('public/' . $product->image);
        $product->delete();

        return back()->with('success', 'Produk dihapus.');
    }
}