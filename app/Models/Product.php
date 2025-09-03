<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Product extends Model
{ 
    /**
     * PRODUCT ATTRIBUTES
     * $this->attributes['id'] - int - contains the product primary key (id)
     * $this->attributes['title'] - string - contains the product name
     * $this->attributes['description'] - string - contains the product description
     * $this->attributes['category'] - string - contains the product category
     * $this->attributes['color'] - string - contains the product color
     * $this->attributes['size'] - string - contains the product size
     * $this->attributes['condition'] - string - contains the product condition
     * $this->attributes['price'] - int - contains the product price
     * $this->attributes['status'] - string - contains the product status
     * $this->attributes['swap'] - bool - tells if the product has been swapped
     * $this->attributes['image'] - string - contains the product image (url or path)
     * $this->attributes['created_at'] - timestamp - contains the product creation timestamp
     * $this->attributes['updated_at'] - timestamp - contains the product last update timestamp
     */
    protected $fillable = [
        'title',
        'description',
        'category',
        'color',
        'size',
        'condition',
        'price',
        'status',
        'image',
    ];

    public static function validate(Request $request): void
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'size' => 'required|string|max:50',
            'condition' => 'required|string|max:50',
            'price' => 'required|integer|gt:0',
            'status' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    }

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getTitle(): string
    {
        return $this->attributes['title'];
    }

    public function setTitle(string $title): void
    {
        $this->attributes['title'] = $title;
    }

    public function getDescription(): string
    {
        return $this->attributes['description'];
    }

    public function setDescription(string $description): void
    {
        $this->attributes['description'] = $description;
    }

    public function getCategory(): string
    {
        return $this->attributes['category'];
    }

    public function setCategory(string $category): void
    {
        $this->attributes['category'] = $category;
    }

    public function getColor(): string
    {
        return $this->attributes['color'];
    }

    public function setColor(string $color): void
    {
        $this->attributes['color'] = $color;
    }

    public function getSize(): string
    {
        return $this->attributes['size'];
    }

    public function setSize(string $size): void
    {
        $this->attributes['size'] = $size;
    }

    public function getCondition(): string
    {
        return $this->attributes['condition'];
    }

    public function setCondition(string $condition): void
    {
        $this->attributes['condition'] = $condition;
    }

    public function getPrice(): int
    {
        return $this->attributes['price'];
    }

    public function setPrice(int $price): void
    {
        $this->attributes['price'] = $price;
    }

    public function getStatus(): string
    {
        return $this->attributes['status'];
    }

    public function setStatus(string $status): void
    {
        $this->attributes['status'] = $status;
    }

    public function getSwap(): bool
    {
        return $this->attributes['swap'];
    }

    public function setSwap(bool $swap): void
    {
        $this->attributes['swap'] = $swap;
    }

    public function getImage(): string
    {
        return $this->attributes['image'];
    }

    public function setImage(string $image): void
    {
        $this->attributes['image'] = $image;
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }
}
