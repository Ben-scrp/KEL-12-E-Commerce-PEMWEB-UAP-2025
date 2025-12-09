<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        // Member 1
        User::create([
            'name' => 'Member Satu',
            'email' => 'member1@gmail.com',
            'password' => Hash::make('member123'),
            'role' => 'member'
        ]);

        // Member 2
        User::create([
            'name' => 'Member Dua',
            'email' => 'member2@gmail.com',
            'password' => Hash::make('member123'),
            'role' => 'member'
        ]);
    }
}

