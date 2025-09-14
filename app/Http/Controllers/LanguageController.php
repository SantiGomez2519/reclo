<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class LanguageController extends Controller
{
    public function switch(string $locale): RedirectResponse
    {
        $supportedLocales = ['en', 'es'];

        if (in_array($locale, $supportedLocales)) {
            session(['locale' => $locale]);
        }

        return redirect()->back();
    }
}
