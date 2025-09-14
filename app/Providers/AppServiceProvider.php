<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Se ejecuta cada vez que se va a renderizar una vista
        View::composer('*', function ($view) {
            $data = $view->getData(); // lo que ya se pasó desde el controlador
            $viewData = $data['viewData'] ?? []; // si no existe, arranca vacío

            $user = Auth::guard('web')->user();

            $viewData['notifications'] = $user
                ? $user->notifications
                : collect();

            $view->with('viewData', $viewData);
        });
    }
}
