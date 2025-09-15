<?php

namespace App\Providers;

use App\Http\View\Composers\LocaleComposer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share notifications with all views
        View::composer('*', function ($view) {
            $data = $view->getData();
            $viewData = $data['viewData'] ?? [];

            $user = Auth::guard('web')->user();

            $viewData['notifications'] = $user
                ? $user->unreadNotifications
                : collect();

            $view->with('viewData', $viewData);
        });

        // Share current locale with all views
        View::composer('*', LocaleComposer::class);
    }
}
