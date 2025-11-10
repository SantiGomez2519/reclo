<?php

namespace App\Util;

use App\Interfaces\ImageStorage;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageGcpStorage implements ImageStorage
{
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
            $this->deleteOldImages($product->getImages(false));
            $imageUrls = $this->store($request, 'products');
            $product->setImages($imageUrls);
        } else {
            $currentImages = $product->getImages(false);
            $product->setImages($currentImages);
        }
    }

    public function deleteOldImages(array $images): void
    {
        $this->deleteMultiple($images);
    }
}
