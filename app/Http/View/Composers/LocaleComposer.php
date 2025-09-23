<?php

// Author: Pablo Cabrejos

namespace App\Http\View\Composers;

use Illuminate\Support\Facades\App;
use Illuminate\View\View;

class LocaleComposer
{
    public function compose(View $view): void
    {
        $view->with('currentLocale', App::getLocale());
    }
}
