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

        view()->composer('layouts.app', function ($view) {
            $user = auth()->guard('web')->user();
            $notifications = $user
                ? $user->unreadNotifications
                : collect();
            $view->with('notifications', $notifications);
        });

        view()->composer('layouts.app', function ($view) {
            $user = auth()->guard('web')->user();
            $notificationTypes = [
                'swap_request_created' => 'App\Notifications\SwapRequestCreated',
                'swap_request_responded' => 'App\Notifications\SwapRequestResponded',
                'swap_request_finalized' => 'App\Notifications\SwapRequestFinalized',
                'product_sold' => 'App\Notifications\ProductSold',
            ];
            $view->with('notificationTypes', $notificationTypes);
        });
    }
}
