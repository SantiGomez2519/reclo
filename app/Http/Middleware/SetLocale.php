<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = ['en', 'es'];
        
        // Check if user has a preferred locale in session
        $sessionLocale = Session::get('locale');
        if (in_array($sessionLocale, $supportedLocales)) {
            App::setLocale($sessionLocale);
        } else {
            // Fallback to browser language detection
            $browserLocale = $this->getBrowserLocale($request);
            
            if (in_array($browserLocale, $supportedLocales)) {
                App::setLocale($browserLocale);
                Session::put('locale', $browserLocale);
            } else {
                // Default to English
                App::setLocale('en');
                Session::put('locale', 'en');
            }
        }
        
        return $next($request);
    }
    
    private function getBrowserLocale(Request $request): string
    {
        $acceptLanguage = $request->header('Accept-Language');
        
        if (!$acceptLanguage) {
            return 'en';
        }
        
        // Parse Accept-Language header
        $languages = [];
        foreach (explode(',', $acceptLanguage) as $lang) {
            $parts = explode(';', trim($lang));
            $locale = trim($parts[0]);
            $quality = 1.0;
            
            if (isset($parts[1]) && strpos($parts[1], 'q=') === 0) {
                $quality = (float) substr($parts[1], 2);
            }
            
            $languages[$locale] = $quality;
        }
        
        // Sort by quality
        arsort($languages);
        
        // Check for supported locales
        foreach (array_keys($languages) as $locale) {
            // Extract language code (e.g., 'es' from 'es-ES')
            $langCode = substr($locale, 0, 2);
            if (in_array($langCode, ['en', 'es'])) {
                return $langCode;
            }
        }
        
        return 'en';
    }
}
