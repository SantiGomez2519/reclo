<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class SwapRequest extends Model
{
    /**
     * SWAP REQUEST ATTRIBUTES
     * $this->attributes['id'] - int - contains the swap request primary key (id)
     * $this->attributes['date_created'] - string - contains the swap request creation date
     * $this->attributes['date_accepted'] - string - contains the swap request acceptance date
     * $this->attributes['status'] - string - contains the swap request status (Pending, Counter Proposed, Accepted, Rejected)
     * $this->attributes['initiator_id'] - int - contains the initiator (CustomUser) foreign key
     * $this->attributes['offered_item_id'] - int - contains the offered item (Product) foreign key (nullable)
     * $this->attributes['desired_item_id'] - int - contains the desired item (Product) foreign key
     * $this->attributes['created_at'] - timestamp - contains the swap request creation timestamp
     * $this->attributes['updated_at'] - timestamp - contains the swap request last update timestamp
     * $this->initiator - CustomUser - contains the associated user who initiated the swap
     * $this->offeredItem - Product - contains the associated offered product (nullable)
     * $this->desiredItem - Product - contains the associated desired product
     */
    protected $fillable = [
        'initiator_id',
        'desired_item_id',
        'status',
        'date_created',
        'date_accepted',
        'status',
    ];

    public static function validateRespond(Request $request): void
    {
        $request->validate([
            'response' => 'required|in:accept,reject',
            'offered_item_id' => 'nullable|exists:products,id',
        ]);
    }

    public static function validateFinalize(Request $request): void
    {
        $request->validate([
            'response' => 'required|in:accepted,rejected',
        ]);
    }

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getDateCreated(): string
    {
        return $this->attributes['date_created'];
    }

    public function setDateCreated(string $date_created): void
    {
        $this->attributes['date_created'] = $date_created;
    }

    public function getDateAccepted(): ?string
    {
        return $this->attributes['date_accepted'];
    }

    public function setDateAccepted(?string $date_accepted): void
    {
        $this->attributes['date_accepted'] = $date_accepted;
    }

    public function getStatus(): string
    {
        return $this->attributes['status'];
    }

    public function setStatus(string $status): void
    {
        $this->attributes['status'] = $status;
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
    public function getInitiatorId(): int
    {
        return $this->attributes['initiator_id'];
    }

    public function setInitiatorId(int $initiator_id): void
    {
        $this->attributes['initiator_id'] = $initiator_id;
    }

    public function getOfferedItemId(): ?int
    {
        return $this->attributes['offered_item_id'];
    }

    public function setOfferedItemId(?int $offered_item_id): void
    {
        $this->attributes['offered_item_id'] = $offered_item_id;
    }

    public function getDesiredItemId(): int
    {
        return $this->attributes['desired_item_id'];
    }

    public function setDesiredItemId(int $desired_item_id): void
    {
        $this->attributes['desired_item_id'] = $desired_item_id;
    }

    // Relationships
    public function initiator(): BelongsTo
    {
        return $this->belongsTo(CustomUser::class, 'initiator_id');
    }

    public function getInitiator(): CustomUser
    {
        return $this->initiator;
    }

    public function setInitiator(CustomUser $initiator): void
    {
        $this->initiator = $initiator;
    }

    public function offeredItem(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'offered_item_id');
    }

    public function getOfferedItem(): ?Product
    {
        return $this->offeredItem;
    }

    public function setOfferedItem(?Product $offeredItem): void
    {
        $this->offeredItem = $offeredItem;
    }

    public function desiredItem(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'desired_item_id');
    }

    public function getDesiredItem(): Product
    {
        return $this->desiredItem;
    }

    public function setDesiredItem(Product $desiredItem): void
    {
        $this->desiredItem = $desiredItem;
    }
}
