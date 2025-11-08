<?php

// Author: Sofia Flores

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class Review extends Model
{
    /**
     * REVIEW ATTRIBUTES
     * $this->attributes['id'] - int - contains the review primary key (id)
     * $this->attributes['comment'] - string - contains the review comment
     * $this->attributes['rating'] - int - contains the review rating
     * $this->attributes['user_id'] - int - contains the user (CustomUser) foreign key
     * $this->attributes['seller_id'] - int - contains the seller (CustomUser) foreign key
     * $this->attributes['created_at'] - timestamp - contains the review creation timestamp
     * $this->attributes['updated_at'] - timestamp - contains the review last update timestamp
     * $this->user - CustomUser - contains the associated user who wrote the review
     * $this->seller - CustomUser - contains the associated seller being reviewed
     */
    protected $fillable = [
        'comment',
        'rating',
        'user_id',
        'seller_id',
    ];

    public static function validate(Request $request): void
    {
        $rules = [
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ];

        $messages = [
            'comment.required' => __('review.comment_required'),
            'comment.string' => __('review.comment_string'),
            'rating.required' => __('review.rating_required'),
            'rating.integer' => __('review.rating_integer'),
            'rating.min' => __('review.rating_min'),
            'rating.max' => __('review.rating_max'),
        ];

        $request->validate($rules, $messages);
    }

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getComment(): string
    {
        return $this->attributes['comment'];
    }

    public function setComment(string $comment): void
    {
        $this->attributes['comment'] = $comment;
    }

    public function getRating(): int
    {
        return $this->attributes['rating'];
    }

    public function setRating(int $rating): void
    {
        $this->attributes['rating'] = $rating;
    }

    public function getCreatedAt(): mixed
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): mixed
    {
        return $this->updated_at;
    }

    // Foreign Key Getters/Setters
    public function getUserId(): int
    {
        return $this->attributes['user_id'];
    }

    public function setUserId(int $user_id): void
    {
        $this->attributes['user_id'] = $user_id;
    }

    public function getSellerId(): int
    {
        return $this->attributes['seller_id'];
    }

    public function setSellerId(int $seller_id): void
    {
        $this->attributes['seller_id'] = $seller_id;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(CustomUser::class, 'user_id');
    }

    public function getUser(): CustomUser
    {
        return $this->user;
    }

    public function setUser(CustomUser $user): void
    {
        $this->user = $user;
    }

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
}
