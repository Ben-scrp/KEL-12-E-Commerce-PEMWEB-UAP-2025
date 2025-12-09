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
<<<<<<< HEAD
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

=======
        // User::factory(10)->create();
         // Panggil semua seeder di sini
        $this->call([
            AdminUserSeeder::class,
        ]);
        
        //template
        // User::factory()->create([
        //     'name' => 'admin',
        //     'email' => 'admin@example.com',
        // ]);

        
>>>>>>> 0270f70430a5f82f38c0eaa8414c61b86e23f218
    }
}