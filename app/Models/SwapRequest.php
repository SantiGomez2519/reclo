<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SwapRequest extends Model
{
    /**
     * SWAP REQUEST ATTRIBUTES
     * $this->attributes['id'] - int - contains the swap request primary key (id)
     * $this->attributes['date_created'] - string - contains the swap request creation date
     * $this->attributes['date_accepted'] - string - contains the swap request acceptance date
     * $this->attributes['status'] - string - contains the swap request status
     * $this->attributes['created_at'] - timestamp - contains the swap request creation timestamp
     * $this->attributes['updated_at'] - timestamp - contains the swap request last update timestamp
     */
    protected $fillable = [
        'date_created',
        'date_accepted',
        'status',
    ];

    public static function validate(Request $request): void
    {
        $request->validate([
            'date_created' => 'required',
            'date_accepted' => 'nullable',
            'status' => 'required|string|max:255',
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
}
