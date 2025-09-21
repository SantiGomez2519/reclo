<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

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

        $review = Review::create([
            'user_id' =>  Auth::guard('web')->user()->getId(),  
            'product_id' => $productId,
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        $review->setUser(Auth::guard('web')->user());
        $product->setReview($review);

        return redirect()
            ->route('orders.show', $request->input('order_id'))
            ->with('status', __('review.thank_message'));
    }
}
