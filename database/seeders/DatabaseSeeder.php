<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            StoreSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);

        User::factory()->create([
        'name' => 'Member Satu',
        'email' => 'member1@gmail.com',
        'password' => bcrypt('password'),
        'role' => 'member'
        ]);

    }
}