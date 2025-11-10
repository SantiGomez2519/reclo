<?php

namespace App\Providers;

use App\Interfaces\ImageStorage;
use App\Util\ImageGcpStorage;
use App\Util\ImageLocalStorage;
use Illuminate\Support\ServiceProvider;
use Exception;

class ImageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ImageStorage::class, function () {
            $storageType = config('app.image_storage', 'local');

            return match ($storageType) {
                'gcp'   => new ImageGcpStorage(),
                'local' => new ImageLocalStorage(),
                default => throw new Exception("Tipo de almacenamiento desconocido: {$storageType}"),
            };
        });
    }

    public function boot(): void
    {
        // Aquí podrías agregar logs o eventos si necesitas
    }
}
