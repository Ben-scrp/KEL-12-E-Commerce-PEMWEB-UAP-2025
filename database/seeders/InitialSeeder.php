<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Store;
use App\Models\ProductCategory;
use App\Models\Product;

class InitialSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Dua user member
        $member1 = User::create([
            'name' => 'Member Satu',
            'email' => 'member1@example.com',
            'password' => Hash::make('password123'),
            'role' => 'member',
        ]);

        $member2 = User::create([
            'name' => 'Member Dua',
            'email' => 'member2@example.com',
            'password' => Hash::make('password123'),
            'role' => 'member',
        ]);

        // 3. Satu toko milik member1
        $store = Store::create([
            'user_id' => $member1->id,
            'name' => 'Toko Satu',
            'logo' => null,
            'about' => 'Toko pertama member.',
            'phone' => '08123456789',
            'address_id' => null,
            'city' => 'Malang',
            'address' => 'Jl. Contoh No. 1',
            'postal_code' => '65111',
            'is_verified' => 1,
        ]);

        // 4. Lima kategori produk
        $categories = collect([
            'Elektronik',
            'Fashion',
            'Makanan',
            'Olahraga',
            'Aksesoris'
        ])->map(function ($name) {
            return ProductCategory::create(['name' => $name]);
        });

        // 5. Sepuluh produk milik toko tersebut
        for ($i = 1; $i <= 10; $i++) {
            Product::create([
                'store_id' => $store->id,
                'category_id' => $categories->random()->id,
                'name' => 'Produk ' . $i,
                'price' => rand(10000, 100000),
                'stock' => rand(1, 50),
                'description' => 'Deskripsi produk ' . $i,
                'image' => null,
            ]);
        }
        
        Store::create([
            'user_id' => 2,
            'name' => 'Toko Satu',
            'phone' => '081234567890',
        ]);

    }
}
