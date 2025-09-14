<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\ImageStorage;
use App\Models\CustomUser;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminProductController extends Controller
{
    private ImageStorage $imageStorage;

    public function __construct(ImageStorage $imageStorage)
    {
        $this->middleware('admin');
        $this->imageStorage = $imageStorage;
    }

    public function index(): View
    {
        $viewData = [];
        $viewData['products'] = Product::with('seller')->get();

        return view('admin.product.index')->with('viewData', $viewData);
    }

    public function show(string $id): View
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
        $product->setStatus($request->input('status'));
        $product->setSellerId($request->input('seller_id'));
        $product->setSwap(false);

        // Handle image upload using dependency injection
        if ($request->hasFile('images')) {
            $imagePaths = $this->imageStorage->store($request, 'products');
            $product->setImages($imagePaths);
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', __('admin.product_created_successfully'));
    }

    public function edit(string $id): View
    {
        $viewData = [];
        $viewData['product'] = Product::findOrFail($id);
        $viewData['sellers'] = CustomUser::all();

        return view('admin.product.edit')->with('viewData', $viewData);
    }

    public function update(Request $request, string $id): RedirectResponse
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
        $product->setStatus($request->input('status'));
        $product->setSellerId($request->input('seller_id'));

        // Handle image upload using dependency injection
        if ($request->hasFile('images')) {
            // Delete old images
            $oldImages = $product->getImages(false);
            if (!empty($oldImages)) {
                $this->imageStorage->deleteMultiple($oldImages);
            }

            // Store new images
            $imagePaths = $this->imageStorage->store($request, 'products');
            $product->setImages($imagePaths);
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', __('admin.product_updated_successfully'));
    }

    public function destroy(string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        // Delete associated images using dependency injection
        $images = $product->getImages(false);
        if (!empty($images)) {
            $this->imageStorage->deleteMultiple($images);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', __('admin.product_deleted_successfully'));
    }
}
