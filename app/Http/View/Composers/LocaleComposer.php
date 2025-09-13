<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\App;

class LocaleComposer
{
    public function compose(View $view): void
    {
        $view->with('currentLocale', App::getLocale());
    }
}
