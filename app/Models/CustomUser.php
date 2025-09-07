<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class CustomUser extends Model
{
    /**
     * CUSTOM USER ATTRIBUTES
     * $this->attributes['id'] - int - contains the custom user primary key (id)
     * $this->attributes['name'] - string - contains the custom user full name
     * $this->attributes['phone'] - string - contains the custom user phone number
     * $this->attributes['email'] - string - contains the custom user email address
     * $this->attributes['password'] - string - contains the custom user hashed password
     * $this->attributes['payment_method'] - string - contains the custom user preferred payment method
     * $this->attributes['created_at'] - timestamp - contains the custom user creation timestamp
     * $this->attributes['updated_at'] - timestamp - contains the custom user last update timestamp
     * $this->products - Product[] - contains the products sold by this user
     * $this->orders - Order[] - contains the orders made by this user
     * $this->reviews - Review[] - contains the reviews written by this user
     * $this->swapRequests - SwapRequest[] - contains the swap requests initiated by this user
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'payment_method',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public static function validate(Request $request): void
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:custom_users,email|max:255',
            'password' => 'required|string|min:8',
            'payment_method' => 'required|string|max:255',
        ]);
    }

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function getPhone(): string
    {
        return $this->attributes['phone'];
    }

    public function setPhone(string $phone): void
    {
        $this->attributes['phone'] = $phone;
    }

    public function getEmail(): string
    {
        return $this->attributes['email'];
    }

    public function setEmail(string $email): void
    {
        $this->attributes['email'] = $email;
    }

    public function getPassword(): string
    {
        return $this->attributes['password'];
    }

    public function setPassword(string $password): void
    {
        $this->attributes['password'] = $password;
    }

    public function getPaymentMethod(): string
    {
        return $this->attributes['payment_method'];
    }

    public function setPaymentMethod(string $payment_method): void
    {
        $this->attributes['payment_method'] = $payment_method;
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    // Relationships
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function setProducts(Collection $products): void
    {
        $this->products = $products;
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function setOrders(Collection $orders): void
    {
        $this->orders = $orders;
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function setReviews(Collection $reviews): void
    {
        $this->reviews = $reviews;
    }

    public function swapRequests(): HasMany
    {
        return $this->hasMany(SwapRequest::class, 'initiator_id');
    }

    public function getSwapRequests(): Collection
    {
        return $this->swapRequests;
    }

    public function setSwapRequests(Collection $swapRequests): void
    {
        $this->swapRequests = $swapRequests;
    }
}
