<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('product.index', compact('products'));
    }

    public function addToCart(Request $request)
    {
        // Validasi data yang diterima dari permintaan AJAX
        $request->validate([
            'productId' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Mendapatkan informasi produk
        $product = Product::findOrFail($request->productId);

        // Simpan informasi produk ke dalam session atau database
        // Di sini, saya akan menggunakan session sebagai contoh
        $cart = session()->get('cart', []);

        $cartItem = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $request->quantity,
            'total' => $product->price * $request->quantity,
        ];

        $cart[] = $cartItem;

        session()->put('cart', $cart);

        return response()->json(['message' => 'Product added to cart successfully']);
    }

    public function bayar(Request $request)
    {
        // Validasi data yang diterima dari permintaan AJAX
        $request->validate([
            'totalBelanja' => 'required|numeric|min:0',
            'diBayar' => 'required|numeric|min:0',
            'kembalian' => 'required|numeric|min:0',
        ]);

        // Simpan informasi pembayaran ke dalam database atau lakukan proses lainnya
        // Di sini saya akan menggunakan session sebagai contoh
        $cart = session()->get('cart', []);

        // Bersihkan keranjang belanja setelah pembayaran selesai
        session()->forget('cart');

        return response()->json(['message' => 'Payment completed successfully']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
