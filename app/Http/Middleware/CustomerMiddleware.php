<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated with web guard (CustomUser)
        if (! Auth::guard('web')->check()) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
