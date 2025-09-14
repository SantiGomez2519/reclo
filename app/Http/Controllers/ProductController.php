<?php

namespace App\Http\Controllers;

use App\Interfaces\ImageStorage;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProductController extends Controller
{
    private ImageStorage $imageStorage;

    public function __construct(ImageStorage $imageStorage)
    {
        $this->middleware('auth:web')->except(['index', 'show']);
        $this->imageStorage = $imageStorage;
    }

    private function getFormData(): array
    {
        return [
            'categories' => ['Women', 'Men', 'Vintage', 'Accessories', 'Shoes', 'Bags', 'Jewelry'],
            'conditions' => ['Like New', 'Excellent', 'Very Good', 'Good', 'Fair'],
            'sizes' => ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'One Size'],
        ];
    }

    private function checkProductOwnership(Product $product): void
    {
        if ($product->getSellerId() !== Auth::guard('web')->id()) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function index(): View
    {
        $viewData = [];
        $viewData['products'] = Product::with('seller')->where('status', 'available')->paginate(12);

        return view('product.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        return view('product.create')->with('viewData', $this->getFormData());
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
        $product->setStatus('available');
        $product->setSwap($request->has('swap'));
        $product->setSellerId(Auth::guard('web')->id());

        // Handle image upload using ImageStorage
        if ($request->hasFile('images')) {
            $imagePaths = $this->imageStorage->storeMultiple($request, 'products');
            $product->setImages($imagePaths);
        } else {
            $imagePath = $this->imageStorage->store($request, 'products');
            $product->setImages([$imagePath]);
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
        $product = Product::findOrFail($id);
        $this->checkProductOwnership($product);

        $viewData = array_merge($this->getFormData(), ['product' => $product]);

        return view('product.edit')->with('viewData', $viewData);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $this->checkProductOwnership($product);

        Product::validate($request, true);

        $product->setTitle($request->title);
        $product->setDescription($request->description);
        $product->setCategory($request->category);
        $product->setColor($request->color);
        $product->setSize($request->size);
        $product->setCondition($request->condition);
        $product->setPrice($request->price);
        $product->setSwap($request->has('swap'));

        // Handle image upload using ImageStorage
        if ($request->hasFile('images')) {
            // Delete old images if they're not the default
            $currentImages = $product->getImages();
            foreach ($currentImages as $imagePath) {
                if ($imagePath !== 'images/logo.png') {
                    $this->imageStorage->delete($imagePath);
                }
            }
            $imagePaths = $this->imageStorage->storeMultiple($request, 'products');
            $product->setImages($imagePaths);
        } elseif ($request->hasFile('image')) {
            // Delete old image if it's not the default
            if ($product->getFirstImage() !== 'images/logo.png') {
                $previousImagePath = str_replace(url('storage') . '/', '', $product->getFirstImage());
                $this->imageStorage->delete($previousImagePath);
            }
            $product->setImages([$this->imageStorage->store($request, 'products')]);
        } else {
            // Keep current images if no new images are uploaded
            $currentImages = $product->getImages();
            $product->setImages($currentImages);
        }

        $product->save();

        return redirect()->route('product.show', $id)->with('success', __('product.product_updated_successfully'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $this->checkProductOwnership($product);

        // Delete image files using ImageStorage
        $images = $product->getImages();
        foreach ($images as $imagePath) {
            if ($imagePath !== 'images/logo.png') {
                $this->imageStorage->delete($imagePath);
            }
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
        $this->checkProductOwnership($product);

        $product->setStatus('sold');
        $product->save();

        return redirect()->back()->with('success', __('product.product_marked_as_sold'));
    }
}
