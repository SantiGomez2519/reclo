<?php

namespace Database\Seeders;

use App\Models\CustomUser;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
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
                'title' => 'Black Jogger Pants',
                'description' => 'Comfortable black jogger pants perfect for casual wear or workouts. Made from high-quality cotton blend with elastic waistband and drawstring.',
                'category' => 'Men',
                'color' => 'Black',
                'size' => 'L',
                'condition' => 'Excellent',
                'price' => 35,
                'status' => 'available',
                'swap' => true,
                'image' => json_encode(['products/black-jogger.webp', 'products/black-jogger2.webp', 'products/black-jogger3.webp']),
                'seller_id' => $user->getId(),
            ],
            [
                'title' => 'Vintage Hoodie',
                'description' => 'Classic vintage-style hoodie with soft fleece lining. Perfect for layering or wearing on its own. Features kangaroo pocket and adjustable hood.',
                'category' => 'Men',
                'color' => 'Gray',
                'size' => 'M',
                'condition' => 'Very Good',
                'price' => 42,
                'status' => 'available',
                'swap' => false,
                'image' => json_encode(['products/hodie1.webp', 'products/hodie2.webp', 'products/hodie3.webp']),
                'seller_id' => $user->getId(),
            ],
            [
                'title' => 'Designer Jacket',
                'description' => 'Stylish designer jacket with modern cut and premium materials. Perfect for both casual and semi-formal occasions.',
                'category' => 'Women',
                'color' => 'Black',
                'size' => 'M',
                'condition' => 'Like New',
                'price' => 85,
                'status' => 'available',
                'swap' => true,
                'image' => json_encode(['products/jacket.webp', 'products/jacket2.webp', 'products/jacket3.webp']),
                'seller_id' => $user->getId(),
            ],
            [
                'title' => 'Classic T-Shirt',
                'description' => 'Essential cotton t-shirt with comfortable fit. Perfect for everyday wear, layering, or casual outings. Made from 100% cotton.',
                'category' => 'Men',
                'color' => 'White',
                'size' => 'L',
                'condition' => 'Good',
                'price' => 18,
                'status' => 'available',
                'swap' => false,
                'image' => json_encode(['products/t-shirt.webp', 'products/t-shirt2.webp', 'products/t-shirt3.webp']),
                'seller_id' => $user->getId(),
            ],
            [
                'title' => 'Vintage Washed Denim',
                'description' => 'Authentic vintage washed denim with unique fading and distressing. Perfect for creating a retro or casual look.',
                'category' => 'Women',
                'color' => 'Blue',
                'size' => 'M',
                'condition' => 'Good',
                'price' => 55,
                'status' => 'available',
                'swap' => true,
                'image' => json_encode(['products/washed.webp', 'products/washed2.webp', 'products/washed3.webp']),
                'seller_id' => $user->getId(),
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        $this->command->info('Products seeded successfully!');
    }
}
