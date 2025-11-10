<?php

// Author: Santiago Gómez

namespace App\Util;

use App\Interfaces\ImageStorage;
use App\Models\Product;
use App\Services\PexelsImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageLocalStorage implements ImageStorage
{
    protected PexelsImageService $pexelsImageService;

    public function __construct(PexelsImageService $pexelsImageService)
    {
        $this->pexelsImageService = $pexelsImageService;
    }

    public function store(Request $request, string $folder = ''): array
    {
        $urls = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $fileName = uniqid().'.'.$file->getClientOriginalExtension();
                $path = $folder ? $folder.'/'.$fileName : $fileName;

                Storage::disk('public')->put($path, file_get_contents($file->getRealPath()));
                $urls[] = Storage::disk('public')->url($path);
            }
        }

        return $urls;
    }

    public function delete(string $path): void
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function deleteMultiple(array $paths): void
    {
        foreach ($paths as $path) {
            $this->delete($path);
        }
    }

    public function handleImageUpload(Request $request, Product $product): void
    {
        if ($request->hasFile('images')) {
            // Delete old images if they're not the default
            $this->deleteProductImages($product);
            $imagePaths = $this->store($request, 'products');
            $product->setImages($imagePaths);
        } else {
            // Keep current images if no new images are uploaded
            // If no images exist, use Pexels as fallback
            $currentImages = $this->extractRawImages($product);
            if (empty($currentImages)) {
                $imagePaths = $this->getProductImages($request, $product);
                $product->setImages($imagePaths);
            }
        }
    }

    public function deleteOldImages(array $images): void
    {
        foreach ($images as $imagePath) {
            if ($imagePath === 'images/default-product.jpg' || str_contains($imagePath, 'default-product.jpg')) {
                continue;
            }

            if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                $storageUrl = Storage::disk('public')->url('');
                if (! str_starts_with($imagePath, $storageUrl)) {
                    continue;
                }
                $imagePath = str_replace($storageUrl, '', $imagePath);
            }

            $this->delete($imagePath);
        }
    }

    public function deleteProductImages(Product $product): void
    {
        $images = $this->extractRawImages($product);
        if (! empty($images)) {
            $this->deleteOldImages($images);
        }
    }

    private function extractRawImages(Product $product): array
    {
        $imageJson = $product->attributes['image'] ?? null;

        if (empty($imageJson)) {
            return [];
        }

        $images = json_decode($imageJson, true);

        return is_array($images) ? $images : [];
    }

    public function getProductImages(Request $request, Product $product): array
    {
        $imagePaths = $this->store($request, 'products');

        if (empty($imagePaths)) {
            $searchQuery = $this->pexelsImageService->buildSearchQuery(
                $product->getTitle(),
                $product->getCategory()
            );
            $maxImages = config('services.pexels.max_images', 5);
            $pexelsImages = $this->pexelsImageService->searchImages($searchQuery, $maxImages);
            $imagePaths = ! empty($pexelsImages) ? $pexelsImages : ['images/default-product.jpg'];
        }

        return $imagePaths;
    }
}
