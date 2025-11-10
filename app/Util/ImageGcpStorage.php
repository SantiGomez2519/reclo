<?php

namespace App\Util;

use App\Interfaces\ImageStorage;
use App\Models\Product;
use App\Services\PexelsImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageGcpStorage implements ImageStorage
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
                $fileName = md5($file->getClientOriginalName() . time()) . '.' . $file->extension();
            
                $path = Storage::disk('gcs')->putFile($folder, $file);
                $urls[] = Storage::disk('gcs')->url($path);
            }
        }

        return $urls;
    }

    public function delete(string $path): void
    {
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            $storageUrl = Storage::disk('gcs')->url('');
            if (! str_starts_with($path, $storageUrl)) {
                return;
            }
            $path = str_replace($storageUrl, '', $path);
        }

        $relativePath = parse_url($path, PHP_URL_PATH);
        $bucketName = env('GCS_BUCKET');
        $relativePath = ltrim(str_replace("/{$bucketName}", '', $relativePath), '/');
        if (Storage::disk('gcs')->exists($relativePath)) {
            Storage::disk('gcs')->delete($relativePath);
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
            $this->deleteProductImages($product);
            $imageUrls = $this->store($request, 'products');
            $product->setImages($imageUrls);
        } else {
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
                $storageUrl = Storage::disk('gcs')->url('');
                if (! str_starts_with($imagePath, $storageUrl)) {
                    continue;
                }
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
            $imagePaths = ! empty($pexelsImages) ? $pexelsImages : [asset('images/default-product.jpg')];
        }

        return $imagePaths;
    }
}
