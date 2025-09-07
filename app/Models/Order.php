<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class Order extends Model
{
    /**
     * ORDER ATTRIBUTES
     * $this->attributes['id'] - int - contains the order primary key (id)
     * $this->attributes['order_date'] - string - contains the order date
     * $this->attributes['total_price'] - int - contains the order total price
     * $this->attributes['status'] - string - contains the order status
     * $this->attributes['payment_method'] - string - contains the order payment method
     * $this->attributes['buyer_id'] - int - contains the buyer (CustomUser) foreign key
     * $this->attributes['created_at'] - timestamp - contains the order creation timestamp
     * $this->attributes['updated_at'] - timestamp - contains the order last update timestamp
     * $this->buyer - CustomUser - contains the associated buyer
     * $this->products - Product[] - contains the products included in this order
     */
    protected $fillable = [
        'order_date',
        'total_price',
        'status',
        'payment_method',
    ];

    public static function validate(Request $request): void
    {
        $request->validate([
            'order_date' => 'required',
            'total_price' => 'required|numeric|gt:0',
            'status' => 'required|in:pending,completed,cancelled',
            'payment_method' => 'required|in:credit_card,paypal,bank_transfer',
        ]);
    }

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getOrderDate(): string
    {
        return $this->attributes['order_date'];
    }

    public function setOrderDate(string $order_date): void
    {
        $this->attributes['order_date'] = $order_date;
    }

    public function getTotalPrice(): int
    {
        return $this->attributes['total_price'];
    }

    public function setTotalPrice(int $total_price): void
    {
        $this->attributes['total_price'] = $total_price;
    }

    public function getStatus(): string
    {
        return $this->attributes['status'];
    }

    public function setStatus(string $status): void
    {
        $this->attributes['status'] = $status;
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

    // Foreign Key Getters/Setters
    public function getBuyerId(): int
    {
        return $this->attributes['buyer_id'];
    }

    public function setBuyerId(int $buyer_id): void
    {
        $this->attributes['buyer_id'] = $buyer_id;
    }

    // Relationships
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(CustomUser::class, 'buyer_id');
    }

    public function getBuyer(): CustomUser
    {
        return $this->buyer;
    }

    public function setBuyer(CustomUser $buyer): void
    {
        $this->buyer = $buyer;
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function setProducts(Collection $products): void
    {
        $this->products = $products;
    }
}
