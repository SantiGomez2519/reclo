<?php

// Author: Pablo Cabrejos

namespace App\Http\Controllers;

use App\Models\CustomUser;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CustomUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function show(): View
    {
        $user = Auth::guard('web')->user();

        $viewData = [];
        $viewData['user'] = $user;

        $viewData['salesHistory'] = Product::where('seller_id', $user->getId())
            ->whereNotNull('order_id')
            ->with(['order.buyer', 'review'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('user.profile')->with('viewData', $viewData);
    }

    public function edit(): View
    {
        $viewData = [];
        $viewData['user'] = Auth::guard('web')->user();

        return view('user.edit')->with('viewData', $viewData);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::guard('web')->user();

        CustomUser::validate($request, true, $user->getId());

        $user->setName($request->input('name'));
        $user->setPhone($request->input('phone'));
        $user->setEmail($request->input('email'));
        $user->setPaymentMethod($request->input('payment_method'));

        $user->save();

        return redirect()->route('user.profile')->with('status', __('user.profile_updated_successfully'));
    }
}
