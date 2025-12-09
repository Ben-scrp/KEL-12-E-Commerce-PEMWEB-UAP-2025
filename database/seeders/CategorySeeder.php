<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Elektronik', 'Fashion', 'Kesehatan', 'Gaming', 'Aksesoris'];

        foreach ($categories as $item) {
            ProductCategory::create([
                'name' => $item,
                'slug' => strtolower(str_replace(' ', '-', $item)),
            ]);
        }
    }
}

