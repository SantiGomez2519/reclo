<?php

// Author: Santiago Gómez y Pablo Cabrejos

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use App\Util\InvoicePdfGenerator;
use Illuminate\Http\Response;
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
            ->with('products.seller')
            ->findOrFail($id);

        $userId = Auth::guard('web')->id();
        $productIds = $order->products->pluck('id')->toArray();

        $reviewedProductIds = Review::where('user_id', $userId)
            ->whereIn('product_id', $productIds)
            ->pluck('product_id')
            ->toArray();

        $productReviews = [];
        foreach ($order->products as $product) {
            $productReviews[$product->getId()] = in_array($product->getId(), $reviewedProductIds);
        }

        $viewData = [];
        $viewData['order'] = $order;
        $viewData['productReviews'] = $productReviews;

        return view('orders.show')->with('viewData', $viewData);
    }

    public function downloadInvoice(int $id): Response
    {
        $order = Order::where('buyer_id', Auth::guard('web')->id())
            ->with(['buyer', 'products.seller'])
            ->findOrFail($id);

        return InvoicePdfGenerator::generateInvoicePdf($order);
    }
}
