<?php

// Author: Santiago Gómez

namespace Database\Seeders;

use App\Models\CustomUser;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Get custom users to be the sellers
        $users = CustomUser::all();

        if ($users->count() < 2) {
            $this->command->info('Not enough custom users found. Please run CustomUserSeeder first.');

            return;
        }

        $user1 = $users->first(); // John Customer
        $user2 = $users->skip(1)->first(); // Jane Customer
        $user3 = $users->skip(2)->first(); // Bob Customer

        $products = [
            [
                'title' => 'Black Jogger Pants',
                'description' => 'Comfortable black jogger pants perfect for casual wear or workouts. Made from high-quality cotton blend with elastic waistband and drawstring.',
                'category' => 'Men',
                'color' => 'Black',
                'size' => 'L',
                'condition' => 'Excellent',
                'price' => 35,
                'available' => true,
                'swap' => true,
                'image' => json_encode(['products/black-jogger.webp', 'products/black-jogger2.webp', 'products/black-jogger3.webp']),
                'seller_id' => $user1->getId(),
            ],
            [
                'title' => 'Vintage Hoodie',
                'description' => 'Classic vintage-style hoodie with soft fleece lining. Perfect for layering or wearing on its own. Features kangaroo pocket and adjustable hood.',
                'category' => 'Men',
                'color' => 'Gray',
                'size' => 'M',
                'condition' => 'Very Good',
                'price' => 42,
                'available' => true,
                'swap' => false,
                'image' => json_encode(['products/hodie1.webp', 'products/hodie2.webp', 'products/hodie3.webp']),
                'seller_id' => $user1->getId(),
            ],
            [
                'title' => 'Designer Jacket',
                'description' => 'Stylish designer jacket with modern cut and premium materials. Perfect for both casual and semi-formal occasions.',
                'category' => 'Women',
                'color' => 'Black',
                'size' => 'M',
                'condition' => 'Like New',
                'price' => 85,
                'available' => true,
                'swap' => true,
                'image' => json_encode(['products/jacket.webp', 'products/jacket2.webp', 'products/jacket3.webp']),
                'seller_id' => $user1->getId(),
            ],
            [
                'title' => 'Classic T-Shirt',
                'description' => 'Essential cotton t-shirt with comfortable fit. Perfect for everyday wear, layering, or casual outings. Made from 100% cotton.',
                'category' => 'Men',
                'color' => 'White',
                'size' => 'L',
                'condition' => 'Good',
                'price' => 18,
                'available' => true,
                'swap' => false,
                'image' => json_encode(['products/t-shirt.webp', 'products/t-shirt2.webp', 'products/t-shirt3.webp']),
                'seller_id' => $user1->getId(),
            ],
            [
                'title' => 'Vintage Washed Denim',
                'description' => 'Authentic vintage washed denim with unique fading and distressing. Perfect for creating a retro or casual look.',
                'category' => 'Women',
                'color' => 'Blue',
                'size' => 'M',
                'condition' => 'Good',
                'price' => 55,
                'available' => true,
                'swap' => true,
                'image' => json_encode(['products/washed.webp', 'products/washed2.webp', 'products/washed3.webp']),
                'seller_id' => $user1->getId(),
            ],
            [
                'title' => 'Boxy White Shirt',
                'description' => 'Trendy boxy fit white shirt with relaxed silhouette. Perfect for layering or wearing on its own. Made from premium cotton with a modern oversized cut.',
                'category' => 'Women',
                'color' => 'White',
                'size' => 'M',
                'condition' => 'Like New',
                'price' => 28,
                'available' => true,
                'swap' => true,
                'image' => json_encode(['products/boxy-white.webp', 'products/boxy-white2.webp', 'products/boxy-white3.webp']),
                'seller_id' => $user2->getId(),
            ],
            [
                'title' => 'Leather Jacket',
                'description' => 'Premium genuine leather jacket with classic biker style. Features multiple pockets, zippers, and adjustable waist belt. Perfect for adding edge to any outfit.',
                'category' => 'Men',
                'color' => 'Black',
                'size' => 'L',
                'condition' => 'Excellent',
                'price' => 120,
                'available' => true,
                'swap' => true,
                'image' => json_encode(['products/leather-jacket.webp', 'products/leather-jacket2.webp', 'products/leather-jacket3.webp']),
                'seller_id' => $user3->getId(),
            ],
            [
                'title' => 'Casual Sneakers',
                'description' => 'Comfortable white casual sneakers perfect for everyday wear. Features breathable material, cushioned sole, and classic design that goes with everything.',
                'category' => 'Shoes',
                'color' => 'White',
                'size' => '10',
                'condition' => 'Very Good',
                'price' => 65,
                'available' => true,
                'swap' => false,
                'image' => json_encode(['products/sneakers.webp', 'products/sneakers2.webp', 'products/sneakers3.webp']),
                'seller_id' => $user3->getId(),
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        $this->command->info('Products seeded successfully!');
    }
}
