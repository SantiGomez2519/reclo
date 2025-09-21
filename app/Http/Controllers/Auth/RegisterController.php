<?php

// Author: Pablo Cabrejos

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CustomUser;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest:web');
    }

    public function register(Request $request): RedirectResponse
    {
        CustomUser::validate($request, false);
        $user = $this->create($request->all());
        $this->guard()->login($user);

        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }

    protected function guard(): Guard|StatefulGuard
    {
        return auth()->guard('web');
    }

    protected function create(array $data): CustomUser
    {
        return CustomUser::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'payment_method' => $data['payment_method'],
        ]);
    }
}
