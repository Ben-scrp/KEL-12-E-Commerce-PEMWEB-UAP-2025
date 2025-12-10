<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::with(['store', 'productImages', 'productReviews.user'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('customer.product-detail', compact('product'));
    }
}
