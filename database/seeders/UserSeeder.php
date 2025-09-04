<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@tokoonline.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Customer user
        User::create([
            'name' => 'John Customer',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'role' => 'customer',
            'address' => [
                'street' => 'Jl. Contoh No. 123',
                'city' => 'Jakarta',
                'postal_code' => '12345',
                'country' => 'Indonesia'
            ],
            'is_active' => true,
        ]);
    }
}
