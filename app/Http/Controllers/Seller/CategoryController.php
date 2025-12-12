<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::paginate(10);
        return view('seller.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('seller.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'tagline' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        ProductCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(5),
            'description' => $request->description,
            'tagline' => $request->tagline,
            'image' => $imagePath,
        ]);

        return redirect()->route('seller.categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(ProductCategory $category)
    {
        return view('seller.categories.edit', compact('category'));
    }

    public function update(Request $request, ProductCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'tagline' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
             // Use Storage generic class but assumes disk public as per store method
             // Ideally delete old image
            $category->image = $request->file('image')->store('categories', 'public');
        }

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(5), // Update slug or keep? usually update if name changes.
            'description' => $request->description,
            'tagline' => $request->tagline,
        ]);

        return redirect()->route('seller.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(ProductCategory $category)
    {
        $category->delete();
        return redirect()->route('seller.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
