<?php

namespace App\Http\Controllers;

use App\Models\CustomUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash; // for hashing the password

class CustomUserController extends Controller
{
    // Here it goes the methods that are not implemented yet

    // Note: Remember to validate the request in the model
    // public function save(Request $request): View
    // {
    //    Model::validate($request);
    //
    //    In this case, for CustomUser, we need to hash the password
    //    CustomUser::create([
    //        ...
    //        'password' => Hash::make($request->password), // hash the password
    //        ...
    //    ]);
    // }
}
