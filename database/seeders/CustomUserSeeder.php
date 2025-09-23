<?php

// Author: Pablo Cabrejos

namespace Database\Seeders;

use App\Models\CustomUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample customers
        CustomUser::create([
            'name' => 'John Customer',
            'phone' => '+1234567890',
            'email' => 'customer1@example.com',
            'password' => Hash::make('password123'),
            'payment_method' => 'Credit Card',
        ]);

        CustomUser::create([
            'name' => 'Jane Customer',
            'phone' => '+1987654321',
            'email' => 'customer2@example.com',
            'password' => Hash::make('password123'),
            'payment_method' => 'PayPal',
        ]);

        CustomUser::create([
            'name' => 'Bob Customer',
            'phone' => '+1555123456',
            'email' => 'customer3@example.com',
            'password' => Hash::make('password123'),
            'payment_method' => 'Bank Transfer',
        ]);
    }
}
