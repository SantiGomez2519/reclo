<?php

namespace Tests\Unit;

use App\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_product_getters_and_setters(): void
    {
        $product = new Product();

        $product->setTitle('Test Product');
        $product->setDescription('This is a test product description');
        $product->setCategory('Women');
        $product->setColor('Blue');
        $product->setSize('M');
        $product->setCondition('Like New');
        $product->setPrice(5000);
        $product->setAvailable(true);
        $product->setSwap(false);

        $this->assertEquals('Test Product', $product->getTitle());
        $this->assertEquals('This is a test product description', $product->getDescription());
        $this->assertEquals('Women', $product->getCategory());
        $this->assertEquals('Blue', $product->getColor());
        $this->assertEquals('M', $product->getSize());
        $this->assertEquals('Like New', $product->getCondition());
        $this->assertEquals(5000, $product->getPrice());
        $this->assertTrue($product->getAvailable());
        $this->assertFalse($product->getSwap());
    }

    public function test_product_price_can_be_updated(): void
    {
        $product = new Product();
        $product->setPrice(1000);

        $this->assertEquals(1000, $product->getPrice());

        $product->setPrice(2500);

        $this->assertEquals(2500, $product->getPrice());
    }

    public function test_product_availability_can_be_toggled(): void
    {
        $product = new Product();
        $product->setAvailable(true);

        $this->assertTrue($product->getAvailable());

        $product->setAvailable(false);

        $this->assertFalse($product->getAvailable());
    }
}

