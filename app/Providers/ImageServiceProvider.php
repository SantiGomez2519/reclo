<?php

namespace App\Providers;

use App\Interfaces\ImageStorage;
use App\Services\PexelsImageService;
use App\Util\ImageGcpStorage;
use App\Util\ImageLocalStorage;
use Exception;
use Illuminate\Support\ServiceProvider;

class ImageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ImageStorage::class, function ($app) {
            $storageType = config('app.image_storage', 'local');
            $pexelsImageService = $app->make(PexelsImageService::class);

            return match ($storageType) {
                'gcp' => new ImageGcpStorage($pexelsImageService),
                'local' => new ImageLocalStorage($pexelsImageService),
                default => throw new Exception("Unknown storage type: {$storageType}"),
            };
        });
    }

    public function boot(): void {}
}
