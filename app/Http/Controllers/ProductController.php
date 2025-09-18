<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Util\ImageLocalStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $viewData['products'] = Product::with('seller')->where('available', true)->get();

        return view('product.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        return view('product.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Product::validate($request);

        $product = new Product;
        $product->setTitle($request->title);
        $product->setDescription($request->description);
        $product->setCategory($request->category);
        $product->setColor($request->color);
        $product->setSize($request->size);
        $product->setCondition($request->condition);
        $product->setPrice($request->price);
        $product->setAvailable(true);
        $product->setSwap($request->has('swap'));
        $product->setSellerId(Auth::guard('web')->id());

        // Handle image upload
        $imageStorage = new ImageLocalStorage();
        $imagePaths = $imageStorage->store($request, 'products');
        $product->setImages($imagePaths);

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
        $product->checkProductOwnership();

        $viewData['product'] = $product;

        return view('product.edit')->with('viewData', $viewData);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->checkProductOwnership();

        Product::validate($request, true);

        $product->setTitle($request->title);
        $product->setDescription($request->description);
        $product->setCategory($request->category);
        $product->setColor($request->color);
        $product->setSize($request->size);
        $product->setCondition($request->condition);
        $product->setPrice($request->price);
        $product->setSwap($request->has('swap'));

        // Handle image upload
        $imageStorage = new ImageLocalStorage();
        $imageStorage->handleImageUpload($request, $product);

        $product->save();

        return redirect()->route('product.show', $id)->with('success', __('product.product_updated_successfully'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->checkProductOwnership();

        // Delete image files
        $imageStorage = new ImageLocalStorage();
        $imageStorage->deleteOldImages($product->getImages(false));

        $product->delete();

        return redirect()->route('product.index')->with('success', __('product.product_deleted_successfully'));
    }

    public function myProducts(): View
    {
        $viewData = [];
        $viewData['products'] = Product::where('seller_id', Auth::guard('web')->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('product.my-products')->with('viewData', $viewData);
    }

    public function markAsSold(int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->checkProductOwnership();

        $product->setAvailable(false);
        $product->save();

        return redirect()->back()->with('success', __('product.product_marked_as_sold'));
    }

}
