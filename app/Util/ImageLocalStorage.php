<?php

// Author: Santiago Gómez

namespace App\Util;

use App\Interfaces\ImageStorage;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageLocalStorage implements ImageStorage
{
    public function store(Request $request, string $folder = ''): array
    {
        $urls = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $fileName = uniqid().'.'.$file->getClientOriginalExtension();
                $path = $folder ? $folder.'/'.$fileName : $fileName;

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
            $this->deleteOldImages($product->getImages(false));
            $imagePaths = $this->store($request, 'products');
            $product->setImages($imagePaths);
        } else {
            // Keep current images if no new images are uploaded
            $currentImages = $product->getImages(false);
            $product->setImages($currentImages);
        }
    }

    public function deleteOldImages(array $images): void
    {
        foreach ($images as $imagePath) {
            if ($imagePath !== 'images/default-product.jpg') {
                $this->delete($imagePath);
            }
        }
    }
}
