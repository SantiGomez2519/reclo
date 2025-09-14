<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\CustomUser;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first custom user to be the seller
        $user = CustomUser::first();

        if (!$user) {
            $this->command->info('No custom users found. Please run CustomUserSeeder first.');
            return;
        }

        $products = [
            [
                'title' => 'Vintage Denim Jacket',
                'description' => 'Classic blue denim jacket with a vintage wash. Perfect for layering or wearing on its own. Features button closure and chest pockets.',
                'category' => 'Women',
                'color' => 'Blue',
                'size' => 'M',
                'condition' => 'Excellent',
                'price' => 45,
                'status' => 'available',
                'swap' => true,
                'image' => 'products/vintage-jacket.jpg',
                'seller_id' => $user->getId(),
            ],
            [
                'title' => 'Designer Silk Scarf',
                'description' => 'Luxurious silk scarf with beautiful geometric pattern. Perfect accessory for any outfit. Made from 100% silk.',
                'category' => 'Accessories',
                'color' => 'Multi-color',
                'size' => 'One Size',
                'condition' => 'Like New',
                'price' => 28,
                'status' => 'available',
                'swap' => false,
                'image' => 'products/silk-scarf.jpg',
                'seller_id' => $user->getId(),
            ],
            [
                'title' => 'Retro Leather Boots',
                'description' => 'Classic brown leather boots with a retro style. Comfortable and stylish, perfect for any season. Size runs true to size.',
                'category' => 'Shoes',
                'color' => 'Brown',
                'size' => 'L',
                'condition' => 'Good',
                'price' => 65,
                'status' => 'available',
                'swap' => true,
                'image' => 'products/leather-boots.jpg',
                'seller_id' => $user->getId(),
            ],
            [
                'title' => 'Bohemian Maxi Dress',
                'description' => 'Flowing maxi dress with beautiful paisley print. Perfect for summer days or special occasions. Features long sleeves and V-neck.',
                'category' => 'Women',
                'color' => 'Multi-color',
                'size' => 'L',
                'condition' => 'Very Good',
                'price' => 38,
                'status' => 'available',
                'swap' => true,
                'image' => 'products/maxi-dress.jpg',
                'seller_id' => $user->getId(),
            ],
            [
                'title' => 'Classic White Shirt',
                'description' => 'Crisp white button-down shirt. Perfect for professional settings or casual wear. Made from high-quality cotton.',
                'category' => 'Men',
                'color' => 'White',
                'size' => 'L',
                'condition' => 'Excellent',
                'price' => 25,
                'status' => 'available',
                'swap' => false,
                'image' => 'products/white-shirt.jpg',
                'seller_id' => $user->getId(),
            ],
            [
                'title' => 'Vintage Leather Bag',
                'description' => 'Authentic vintage leather handbag with beautiful patina. Features multiple compartments and adjustable strap.',
                'category' => 'Bags',
                'color' => 'Brown',
                'size' => 'One Size',
                'condition' => 'Good',
                'price' => 55,
                'status' => 'available',
                'swap' => true,
                'image' => 'products/leather-bag.jpg',
                'seller_id' => $user->getId(),
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        $this->command->info('Products seeded successfully!');
    }
}