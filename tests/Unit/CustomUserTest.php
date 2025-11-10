<?php

namespace Tests\Unit;

use App\Models\CustomUser;
use Tests\TestCase;

class CustomUserTest extends TestCase
{
    public function test_custom_user_getters_and_setters(): void
    {
        $user = new CustomUser;

        $user->setName('John Doe');
        $user->setPhone('1234567890');
        $user->setEmail('john@example.com');
        $user->setPassword('password123');
        $user->setPaymentMethod('credit_card');

        $this->assertEquals('John Doe', $user->getName());
        $this->assertEquals('1234567890', $user->getPhone());
        $this->assertEquals('john@example.com', $user->getEmail());
        $this->assertEquals('password123', $user->getPassword());
        $this->assertEquals('credit_card', $user->getPaymentMethod());
    }

    public function test_custom_user_email_can_be_updated(): void
    {
        $user = new CustomUser;
        $user->setEmail('old@example.com');

        $this->assertEquals('old@example.com', $user->getEmail());

        $user->setEmail('new@example.com');

        $this->assertEquals('new@example.com', $user->getEmail());
    }

    public function test_custom_user_payment_method_can_be_changed(): void
    {
        $user = new CustomUser;
        $user->setPaymentMethod('paypal');

        $this->assertEquals('paypal', $user->getPaymentMethod());

        $user->setPaymentMethod('bank_transfer');

        $this->assertEquals('bank_transfer', $user->getPaymentMethod());
    }
}
