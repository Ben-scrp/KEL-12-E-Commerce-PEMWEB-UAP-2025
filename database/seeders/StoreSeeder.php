<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        Store::create([
            'user_id' => 2, // member1
            'name' => 'Toko Satu',
            'about' => 'Toko online terpercaya',
            'logo' => 'logo.png',
            'is_verified' => true,
        ]);
    }
}

