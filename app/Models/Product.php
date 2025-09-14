<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
     * $this->attributes['images'] - array - contains the product images (url or path)
     * $this->attributes['seller_id'] - int - contains the seller (CustomUser) foreign key
     * $this->attributes['order_id'] - int - contains the order foreign key (nullable)
     * $this->attributes['created_at'] - timestamp - contains the product creation timestamp
     * $this->attributes['updated_at'] - timestamp - contains the product last update timestamp
     * $this->seller - CustomUser - contains the associated seller
     * $this->order - Order - contains the associated order (nullable)
     * $this->review - Review - contains the associated review (nullable)
     * $this->swapRequestsDesired - SwapRequest[] - contains swap requests where this product is desired
     * $this->swapRequestsOffered - SwapRequest[] - contains swap requests where this product is offered
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

    public static function validate(Request $request, bool $isUpdate = false): void
    {
        $rules = [
            'title' => 'required|string|max:255|min:3',
            'description' => 'required|string|min:10|max:1000',
            'category' => 'required|string|in:Women,Men,Vintage,Accessories,Shoes,Bags,Jewelry',
            'color' => 'required|string|max:50',
            'size' => 'required|string|in:XS,S,M,L,XL,XXL,One Size',
            'condition' => 'required|string|in:Like New,Excellent,Very Good,Good,Fair',
            'price' => 'required|integer|min:1|max:10000',
            'status' => 'required|string|in:available,sold,unavailable',
            'images' => $isUpdate ? 'nullable|array|max:5' : 'required|array|min:1|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        // seller_id validation for admin
        if ($request->has('seller_id')) {
            $rules['seller_id'] = 'required|exists:custom_users,id';
        }

        $request->validate($rules);
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

    /** 
     * Get product images as URLs or file paths
     */
    public function getImages(bool $asUrls = true): array
    {
        $image = $this->attributes['image'];

        if ($image) {
            $images = json_decode($image, true);
            if (is_array($images)) {
                if ($asUrls) {
                    $urls = [];
                    foreach ($images as $imagePath) {
                        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                            $urls[] = $imagePath;
                        } else {
                            $urls[] = url('storage/' . ltrim($imagePath, '/'));
                        }
                    }
                    return $urls;
                } else {
                    return $images;
                }
            }
        }

        return [];
    }

    public function setImages(array $images): void
    {
        $this->attributes['image'] = json_encode($images);
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
    public function getSellerId(): int
    {
        return $this->attributes['seller_id'];
    }

    public function setSellerId(int $seller_id): void
    {
        $this->attributes['seller_id'] = $seller_id;
    }

    public function getOrderId(): ?int
    {
        return $this->attributes['order_id'];
    }

    public function setOrderId(?int $order_id): void
    {
        $this->attributes['order_id'] = $order_id;
    }

    // Relationships
    public function seller(): BelongsTo
    {
        return $this->belongsTo(CustomUser::class, 'seller_id');
    }

    public function getSeller(): CustomUser
    {
        return $this->seller;
    }

    public function setSeller(CustomUser $seller): void
    {
        $this->seller = $seller;
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): void
    {
        $this->order = $order;
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    public function getReview(): ?Review
    {
        return $this->review;
    }

    public function setReview(?Review $review): void
    {
        $this->review = $review;
    }

    public function swapRequestsDesired(): HasMany
    {
        return $this->hasMany(SwapRequest::class, 'desired_item_id');
    }

    public function getSwapRequestsDesired(): Collection
    {
        return $this->swapRequestsDesired;
    }

    public function setSwapRequestsDesired(Collection $swapRequestsDesired): void
    {
        $this->swapRequestsDesired = $swapRequestsDesired;
    }

    public function swapRequestsOffered(): HasMany
    {
        return $this->hasMany(SwapRequest::class, 'offered_item_id');
    }

    public function getSwapRequestsOffered(): Collection
    {
        return $this->swapRequestsOffered;
    }

    public function setSwapRequestsOffered(Collection $swapRequestsOffered): void
    {
        $this->swapRequestsOffered = $swapRequestsOffered;
    }
}
