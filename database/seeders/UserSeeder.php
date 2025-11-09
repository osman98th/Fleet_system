<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
       User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345678'), // change to a secure password
            'is_admin' => true,
        ]);

        // Regular users
       User::factory()->create([
            'name' => 'John Doe',
            'email' => 'customer@example.com',
            'password' => Hash::make('12345678'),
            'is_admin' => false,
        ]);

       User::factory()->create([
            'name' => 'Jane Smith',
            'email' => 'driver@example.com',
            'password' => Hash::make('12345678'),
            'is_admin' => false,
        ]);
    }
}
