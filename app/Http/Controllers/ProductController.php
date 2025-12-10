<?php

namespace App\Http\Controllers;

use App\Models\Product;
class ProductController extends Controller
{
    // Homepage — tampilkan semua produk
    public function index()
    {
        $products = Product::with(['store', 'productImages', 'productCategory'])
                            ->latest()
                            ->get();

        return view('products.index', compact('products'));
    }

    // Halaman detail produk
    public function show($slug)
    {
        $product = Product::with([
            'productImages',
            'productCategory',
            'store',
            'productReviews.user'
        ])
        ->where('slug', $slug)
        ->firstOrFail();

        return view('products.show', compact('product'));
    }
}