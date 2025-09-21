<?php

// Author: Pablo Cabrejos

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomUser;
use App\Models\Product;
use App\Util\ImageLocalStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(): View
    {
        $viewData = [];
        $viewData['products'] = Product::with('seller')->get();

        return view('admin.product.index')->with('viewData', $viewData);
    }

    public function show(int $id): View
    {
        $viewData = [];
        $viewData['product'] = Product::with('seller')->findOrFail($id);

        return view('admin.product.show')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['sellers'] = CustomUser::all();

        return view('admin.product.create')->with('viewData', $viewData);
    }

    public function store(Request $request): RedirectResponse
    {
        Product::validate($request, false);

        $product = new Product;
        $product->setTitle($request->input('title'));
        $product->setDescription($request->input('description'));
        $product->setCategory($request->input('category'));
        $product->setColor($request->input('color'));
        $product->setSize($request->input('size'));
        $product->setCondition($request->input('condition'));
        $product->setPrice($request->input('price'));
        $product->setAvailable($request->boolean('available'));
        $product->setSellerId($request->input('seller_id'));
        $product->setSwap(false);

        // Handle image upload
        if ($request->hasFile('images')) {
            $imageStorage = new ImageLocalStorage;
            $imagePaths = $imageStorage->store($request, 'products');
            $product->setImages($imagePaths);
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', __('admin.product_created_successfully'));
    }

    public function edit(int $id): View
    {
        $viewData = [];
        $viewData['product'] = Product::findOrFail($id);
        $viewData['sellers'] = CustomUser::all();

        return view('admin.product.edit')->with('viewData', $viewData);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        Product::validate($request, true);

        $product->setTitle($request->input('title'));
        $product->setDescription($request->input('description'));
        $product->setCategory($request->input('category'));
        $product->setColor($request->input('color'));
        $product->setSize($request->input('size'));
        $product->setCondition($request->input('condition'));
        $product->setPrice($request->input('price'));
        $product->setAvailable($request->boolean('available'));
        $product->setSellerId($request->input('seller_id'));

        // Handle image upload
        if ($request->hasFile('images')) {
            $imageStorage = new ImageLocalStorage;
            $imageStorage->handleImageUpload($request, $product);
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', __('admin.product_updated_successfully'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        // Delete associated images
        $imageStorage = new ImageLocalStorage;
        $imageStorage->deleteOldImages($product->getImages(false));

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', __('admin.product_deleted_successfully'));
    }
}
