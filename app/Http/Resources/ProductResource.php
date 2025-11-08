<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'category' => $this->getCategory(),
            'color' => $this->getColor(),
            'size' => $this->getSize(),
            'condition' => $this->getCondition(),
            'price' => $this->getPrice(),
            'available' => $this->getAvailable(),
            'images' => $this->getImages(),
            'url' => route('product.show', ['id' => $this->getId()]),
        ];
    }
}
