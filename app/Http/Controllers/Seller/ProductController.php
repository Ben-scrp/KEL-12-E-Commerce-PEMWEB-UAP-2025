<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('store_id', Auth::user()->store->id)
            ->with(['productImages', 'productCategory'])
            ->latest()
            ->paginate(10);
        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'description' => 'required|string',
            'condition' => 'required|in:new,second',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::create([
            'store_id' => Auth::user()->store->id,
            'product_category_id' => $request->product_category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(5),
            'description' => $request->description,
            'condition' => $request->condition,
            'price' => $request->price,
            'weight' => $request->weight,
            'stock' => $request->stock,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'is_thumbnail' => $index === 0, // First image is thumbnail by default
                ]);
            }
        }

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        if ($product->store_id !== Auth::user()->store->id) {
            abort(403);
        }
        $categories = ProductCategory::all();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->store_id !== Auth::user()->store->id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'description' => 'required|string',
            'condition' => 'required|in:new,second',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product->update([
            'product_category_id' => $request->product_category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(5),
            'description' => $request->description,
            'condition' => $request->condition,
            'price' => $request->price,
            'weight' => $request->weight,
            'stock' => $request->stock,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'is_thumbnail' => false,
                ]);
            }
        }
        
        // Handle thumbnail update if requested (e.g., set specific image as thumbnail)
        // This part could be more complex, for now assuming images are just added.
        // A separate mechanism to manage images (delete, set thumbnail) would be better.
        // But to keep it simple, I'll allow deleting images in edit view if needed (separate route) usually.
        // For now, basic implementation.

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->store_id !== Auth::user()->store->id) {
            abort(403);
        }
        
        // Delete images from storage
        foreach ($product->productImages as $bg) {
            if (Storage::disk('public')->exists($bg->image)) {
                Storage::disk('public')->delete($bg->image);
            }
        }

        $product->delete();
        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil dihapus!');
    }

    public function deleteImage(ProductImage $image)
    {
        if ($image->product->store_id !== Auth::user()->store->id) {
            abort(403);
        }

        // Prevent deleting the last image
        if ($image->product->productImages->count() <= 1) {
            return back()->with('error', 'Produk harus memiliki minimal satu gambar.');
        }

        // If deleting thumbnail, set another as thumbnail
        if ($image->is_thumbnail) {
            $nextImage = $image->product->productImages->where('id', '!=', $image->id)->first();
            if ($nextImage) {
                $nextImage->update(['is_thumbnail' => true]);
            }
        }

        if (Storage::disk('public')->exists($image->image)) {
            Storage::disk('public')->delete($image->image);
        }

        $image->delete();

        return back()->with('success', 'Gambar berhasil dihapus.');
    }

    public function setThumbnail(ProductImage $image)
    {
         if ($image->product->store_id !== Auth::user()->store->id) {
            abort(403);
        }

        // Reset all others
        ProductImage::where('product_id', $image->product_id)->update(['is_thumbnail' => false]);
        
        // Set this one
        $image->update(['is_thumbnail' => true]);

        return back()->with('success', 'Thumbnail berhasil diatur.');
    }
}

