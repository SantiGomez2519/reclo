<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated with admin guard
        if (! Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        // Get the authenticated admin user
        $admin = Auth::guard('admin')->user();

        // Verify the user has admin role
        if (! $admin->isAdmin()) {
            Auth::guard('admin')->logout();

            return redirect()->route('admin.login')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}
