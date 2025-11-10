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
                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $folder ? $folder . '/' . $fileName : $fileName;

                Storage::disk('public')->put($path, file_get_contents($file->getRealPath()));
                $urls[] = Storage::disk('public')->url($path);

                \Log::info('Imagen guardada:', ['urls' => $urls]);

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
            $oldImages = json_decode($product->attributes['image'] ?? '[]', true);
            if (is_array($oldImages)) {
                $this->deleteOldImages($oldImages);
            }
            $imagePaths = $this->store($request, 'products');
            $product->setImages($imagePaths);
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
                // Verificar si es una URL de nuestro storage
                $storageUrl = Storage::disk('public')->url('');
                if (!str_starts_with($imagePath, $storageUrl)) {
                    continue; // Es una URL externa, no eliminar
                }
                // Es una URL de nuestro storage, extraer la ruta relativa
                $imagePath = str_replace($storageUrl, '', $imagePath);
            }

            // Eliminar el archivo si existe
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
            $imagePaths = !empty($pexelsImages) ? $pexelsImages : ['images/default-product.jpg'];
        }

        return $imagePaths;
    }
}
