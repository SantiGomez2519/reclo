<?php

namespace App\Http\Controllers;

use App\Models\CustomUser;
use App\Models\Order;
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
                    
        // FR17: Historial de compras (órdenes donde este usuario es el comprador)
        $viewData['purchaseHistory'] = Order::where('buyer_id', $user->id)
            ->with(['products.seller', 'products.review']) // Cargar productos con sus vendedores y reviews
            ->orderBy('order_date', 'desc')
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

        CustomUser::validateUpdate($request, $user->getId());

        $user->setName($request->name);
        $user->setPhone($request->phone);
        $user->setEmail($request->email);
        $user->setPaymentMethod($request->payment_method);

        $user->save();

        return redirect()->route('user.profile')->with('status', 'Profile updated successfully!');
    }

    public function salesHistory(): View
    {
        $user = Auth::guard('web')->user();

        $viewData = [];
        $viewData['user'] = $user;
        $viewData['salesHistory'] = Product::where('seller_id', $user->id)
            ->where('available', false)
            ->with(['order.buyer', 'review'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('user.sales')->with('viewData', $viewData);
    }
}
