<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer('layouts.app', function ($view) {
            $cartCount = 0;
            if (auth()->guard('web')->check()) {
                $cart = session()->get('cart', []);
                $cartCount = array_sum($cart);
            }
            $view->with('cartCount', $cartCount);
        });
    }
}
