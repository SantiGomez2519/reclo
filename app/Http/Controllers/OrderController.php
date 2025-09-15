<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(): View
    {
        $viewData = [];
        $viewData['orders'] = Order::where('buyer_id', Auth::guard('web')->id())
            ->with('products')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.index')->with('viewData', $viewData);
    }

    public function show(int $id): View
    {
        $order = Order::where('buyer_id', Auth::guard('web')->id())
            ->with('products')
            ->findOrFail($id);

        $viewData = [];
        $viewData['order'] = $order;

        return view('orders.show')->with('viewData', $viewData);
    }
}
