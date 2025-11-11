<?php

// Author: Isabella Camacho

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function create(int $productId): View
    {
        $product = Product::findOrFail($productId);

        $viewData = [];
        $viewData['product'] = $product;

        return view('reviews.create')->with('viewData', $viewData);
    }

    public function store(Request $request, int $productId): RedirectResponse
    {
        Review::validate($request);

        $product = Product::findOrFail($productId);
        $sellerId = $product->getSellerId();
        $user = Auth::guard('web')->user();

        if (
            Review::where('user_id', $user->getId())
                ->where('product_id', $productId)
                ->exists()
        ) {
            return redirect()
                ->route('orders.show', $request->input('order_id'))
                ->with('error', __('review.already_reviewed_product'));
        }

        Review::create([
            'user_id' => $user->getId(),
            'seller_id' => $sellerId,
            'product_id' => $productId,
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        return redirect()
            ->route('orders.show', $request->input('order_id'))
            ->with('status', __('review.thank_message'));
    }
}
