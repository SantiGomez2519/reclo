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
        $sellerIds = $order->products->pluck('seller_id')->unique();

        $reviewedSellerIds = Review::where('user_id', $userId)
            ->whereIn('seller_id', $sellerIds)
            ->pluck('seller_id')
            ->toArray();

        $sellerReviews = [];
        foreach ($sellerIds as $sellerId) {
            $sellerReviews[$sellerId] = in_array($sellerId, $reviewedSellerIds);
        }

        $viewData = [];
        $viewData['order'] = $order;
        $viewData['sellerReviews'] = $sellerReviews;

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
