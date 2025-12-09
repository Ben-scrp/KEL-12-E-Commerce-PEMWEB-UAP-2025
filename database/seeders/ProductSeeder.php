<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Store;
use App\Models\ProductCategory;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $store = Store::first();
        $category = ProductCategory::first();

        for ($i = 1; $i <= 10; $i++) {
            Product::create([
                'store_id' => $store->id,
                'category_id' => $category->id,
                'name' => 'Produk ke-' . $i,
                'slug' => 'produk-ke-' . $i,
                'description' => 'Deskripsi produk ke-' . $i,
                'price' => rand(50000, 200000),
                'stock' => rand(5, 20),
            ]);
        }
    }
}


