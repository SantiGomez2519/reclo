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
                $path = Storage::disk('gcs')->putFile($folder, $file);
                $urls[] = Storage::disk('gcs')->url($path);
            }
        }

        return $urls;
    }

    public function delete(string $path): void
    {
        // No eliminar URLs externas (Pexels, etc.)
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            $storageUrl = Storage::disk('gcs')->url('');
            if (!str_starts_with($path, $storageUrl)) {
                return; // Es una URL externa, no eliminar
            }
            // Es una URL de GCS, extraer la ruta relativa
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
            // Delete old images if they're not the default
            $oldImages = json_decode($product->attributes['image'] ?? '[]', true);
            if (is_array($oldImages)) {
                $this->deleteOldImages($oldImages);
            }
            $imageUrls = $this->store($request, 'products');
            $product->setImages($imageUrls);
        } else {
            // Keep current images if no new images are uploaded
            $currentImages = json_decode($product->attributes['image'] ?? '[]', true);
            if (!is_array($currentImages) || empty($currentImages)) {
                // Si no hay imágenes, usar Pexels como fallback
                $imagePaths = $this->getProductImages($request, $product);
                $product->setImages($imagePaths);
            }
        }
    }

    public function deleteOldImages(array $images): void
    {
        foreach ($images as $imagePath) {
            // No eliminar imágenes por defecto
            if ($imagePath === 'images/default-product.jpg' || str_contains($imagePath, 'default-product.jpg')) {
                continue;
            }

            // No eliminar URLs externas (Pexels, etc.)
            if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                $storageUrl = Storage::disk('gcs')->url('');
                if (!str_starts_with($imagePath, $storageUrl)) {
                    continue; // Es una URL externa, no eliminar
                }
            }

            $this->delete($imagePath);
        }
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
            $imagePaths = !empty($pexelsImages) ? $pexelsImages : [asset('images/default-product.jpg')];
        }

        return $imagePaths;
    }
}
