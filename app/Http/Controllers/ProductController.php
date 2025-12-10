<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::with(['productImages', 'productCategory', 'store', 'productReviews.user'])
                        ->where('slug', $slug)
                        ->firstOrFail();

        return view('products.show', compact('product'));
    }
}
