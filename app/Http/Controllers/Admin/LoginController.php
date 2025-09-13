<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function __construct()
    {
        // Custom middleware to handle admin authentication state
        $this->middleware(function ($request, $next) {
            // If already authenticated as admin, redirect to dashboard
            if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return $next($request);
        })->only(['showLoginForm', 'login']);
    }

    public function showLoginForm(): View
    {
        return view('admin.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        User::validateLogin($request);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Verify the authenticated user has admin role
            $admin = Auth::guard('admin')->user();
            if (! $admin->isAdmin()) {
                Auth::guard('admin')->logout();

                return back()->withErrors([
                    'email' => 'Unauthorized access.',
                ]);
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
