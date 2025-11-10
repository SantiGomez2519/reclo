<?php

namespace App\Interfaces;

use App\Models\Product;
use Illuminate\Http\Request;

interface ImageStorage
{
    public function store(Request $request, string $folder = ''): array;

    public function delete(string $path): void;

    public function deleteMultiple(array $paths): void;

    public function handleImageUpload(Request $request, Product $product): void;

    public function deleteOldImages(array $images): void;

    public function getProductImages(Request $request, Product $product): array;
}
