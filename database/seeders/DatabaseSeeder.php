<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'username' => 'admin',
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create regular user
        User::create([
            'username' => 'user',
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);

        // Create sample products
        Product::create([
            'name' => 'Laptop',
            'description' => 'High-performance laptop for developers',
            'price' => 999.99,
            'created_by' => $admin->id,
        ]);

        Product::create([
            'name' => 'Wireless Mouse',
            'description' => 'Ergonomic wireless mouse',
            'price' => 29.99,
            'created_by' => $admin->id,
        ]);

        Product::create([
            'name' => 'Mechanical Keyboard',
            'description' => 'RGB mechanical keyboard with Cherry MX switches',
            'price' => 79.99,
            'created_by' => $admin->id,
        ]);

        Product::create([
            'name' => 'Monitor',
            'description' => '27-inch 4K IPS monitor',
            'price' => 449.99,
            'created_by' => $admin->id,
        ]);

        Product::create([
            'name' => 'USB Hub',
            'description' => '7-port USB 3.0 hub',
            'price' => 24.99,
            'created_by' => $admin->id,
        ]);
    }
}
