<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Tambahan: fitur search
        $search = $request->input('search');

        $products = Product::with(['productImages', 'productCategory', 'store'])
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->get();

        return view('products.index', compact('products'));
    }

    public function show($slug)
    {
        $product = Product::with(['productImages', 'productCategory', 'store', 'productReviews.user'])
                        ->where('slug', $slug)
                        ->firstOrFail();

        return view('products.show', compact('product'));
    }
}
