<?php

// Author: Pablo Cabrejos

namespace App\Providers;

use App\Http\View\Composers\LocaleComposer;
use App\Interfaces\ImageStorage;
use App\Util\ImageLocalStorage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ImageStorage::class, ImageLocalStorage::class);
    }

    public function boot(): void
    {
        // Share current locale with all views
        View::composer('*', LocaleComposer::class);
    }
}
