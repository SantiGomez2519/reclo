<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web')->except(['index', 'show']);
    }

    public function index(): View
    {
        $viewData = [];
        $viewData['products'] = Product::with('seller')->where('status', 'available')->paginate(12);

        return view('product.index')->with('viewData', $viewData);
    }
    public function create(): View
    {
        $viewData = [];
        $viewData['categories'] = ['Women', 'Men', 'Vintage', 'Accessories', 'Shoes', 'Bags', 'Jewelry'];
        $viewData['conditions'] = ['Like New', 'Excellent', 'Very Good', 'Good', 'Fair'];
        $viewData['sizes'] = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'One Size'];

        return view('product.create')->with('viewData', $viewData);
    }

    public function store(Request $request): RedirectResponse
    {
        Product::validate($request);

        $product = new Product();
        $product->setTitle($request->title);
        $product->setDescription($request->description);
        $product->setCategory($request->category);
        $product->setColor($request->color);
        $product->setSize($request->size);
        $product->setCondition($request->condition);
        $product->setPrice($request->price);
        $product->setStatus('available');
        $product->setSwap($request->has('swap'));
        $product->setSellerId(Auth::guard('web')->id());

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->setImage($imagePath);
        }

        $product->save();

        return redirect()->route('product.index')->with('success', __('product.product_created_successfully'));
    }

    public function show(int $id): View
    {
        $viewData = [];
        $viewData['product'] = Product::with(['seller', 'review'])->findOrFail($id);

        return view('product.show')->with('viewData', $viewData);
    }

    public function edit(int $id): View
    {
        $viewData = [];
        $product = Product::findOrFail($id);

        // Check if user owns the product
        if ($product->getSellerId() !== Auth::guard('web')->id()) {
            abort(403, 'Unauthorized action.');
        }

        $viewData['product'] = $product;
        $viewData['categories'] = ['Women', 'Men', 'Vintage', 'Accessories', 'Shoes', 'Bags', 'Jewelry'];
        $viewData['conditions'] = ['Like New', 'Excellent', 'Very Good', 'Good', 'Fair'];
        $viewData['sizes'] = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'One Size'];

        return view('product.edit')->with('viewData', $viewData);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        // Check if user owns the product
        if ($product->getSellerId() !== Auth::guard('web')->id()) {
            abort(403, 'Unauthorized action.');
        }

        Product::validateUpdate($request);

        $product->setTitle($request->title);
        $product->setDescription($request->description);
        $product->setCategory($request->category);
        $product->setColor($request->color);
        $product->setSize($request->size);
        $product->setCondition($request->condition);
        $product->setPrice($request->price);
        $product->setSwap($request->has('swap'));

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->getImage()) {
                Storage::disk('public')->delete($product->getImage());
            }

            $imagePath = $request->file('image')->store('products', 'public');
            $product->setImage($imagePath);
        }

        $product->save();

        return redirect()->route('product.show', $id)->with('success', __('product.product_updated_successfully'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        // Check if user owns the product
        if ($product->getSellerId() !== Auth::guard('web')->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete image file
        if ($product->getImage()) {
            Storage::disk('public')->delete($product->getImage());
        }

        $product->delete();

        return redirect()->route('product.index')->with('success', __('product.product_deleted_successfully'));
    }

    public function myProducts(): View
    {
        $viewData = [];
        $viewData['products'] = Product::where('seller_id', Auth::guard('web')->id())
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('product.my-products')->with('viewData', $viewData);
    }

    public function markAsSold(int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        // Check if user owns the product
        if ($product->getSellerId() !== Auth::guard('web')->id()) {
            abort(403, 'Unauthorized action.');
        }

        $product->setStatus('sold');
        $product->save();

        return redirect()->back()->with('success', __('product.product_marked_as_sold'));
    }
}
