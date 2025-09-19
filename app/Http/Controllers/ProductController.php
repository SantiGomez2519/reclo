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
        $viewData['products'] = Product::with('seller')->where('available', true)->get();

        $viewData['categories'] = ['Women', 'Men', 'Vintage', 'Accessories', 'Shoes', 'Bags', 'Jewelry'];
        $viewData['conditions'] = ['Like New', 'Excellent', 'Very Good', 'Good', 'Fair'];
        $viewData['sizes'] = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'One Size'];
        $viewData['filters'] = [];

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
        $imagePaths = $this->imageStorage->store($request, 'products');
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
        $this->handleImageUpload($request, $product);

        $product->save();

        return redirect()->route('product.show', $id)->with('success', __('product.product_updated_successfully'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $this->checkProductOwnership($product);

        // Delete image files using ImageStorage
        $this->deleteOldImages($product->getImages(false));

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
        $this->checkProductOwnership($product);

        $product->setStatus('sold');
        $product->save();

        return redirect()->back()->with('success', __('product.product_marked_as_sold'));
    }

    public function search(Request $request): View
{
    $viewData = [];
    
    $viewData['categories'] = ['Women', 'Men', 'Vintage', 'Accessories', 'Shoes', 'Bags', 'Jewelry'];
    $viewData['conditions'] = ['Like New', 'Excellent', 'Very Good', 'Good', 'Fair'];
    $viewData['sizes'] = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'One Size'];
    $viewData['filters'] = $request->all();

    $productsQuery = Product::with('seller')->where('available', true);

    if ($request->has('search') && !empty($request->search)) {
        $keyword = strtolower($request->search);
        $keywordsArray = explode(' ', $keyword);

        $productsQuery->where(function ($query) use ($keywordsArray, $keyword) {
            foreach ($keywordsArray as $word) {
                $singularWord = rtrim($word, 's');
                $query->orWhere('title', 'LIKE', '%'.$word.'%')
                    ->orWhere('title', 'LIKE', '%'.$singularWord.'%')
                    ->orWhere('description', 'LIKE', '%'.$word.'%')
                    ->orWhere('description', 'LIKE', '%'.$singularWord.'%');
            }

            $query->orWhere('title', 'LIKE', '%'.str_replace(' ', '', $keyword).'%')
                ->orWhere('description', 'LIKE', '%'.str_replace(' ', '', $keyword).'%');
        });
    }

    if ($request->has('category') && !empty($request->category)) {
        $productsQuery->where('category', $request->category);
    }

    if ($request->has('size') && !empty($request->size)) {
        $productsQuery->where('size', $request->size);
    }

    if ($request->has('condition') && !empty($request->condition)) {
        $productsQuery->where('condition', $request->condition);
    }

    if ($request->has('min_price') && !empty($request->min_price)) {
        $productsQuery->where('price', '>=', (int)$request->min_price);
    }

    if ($request->has('max_price') && !empty($request->max_price)) {
        $productsQuery->where('price', '<=', (int)$request->max_price);
    }

    $products = $productsQuery->get();

    $viewData['title'] = __('Product.results_for') . ($request->search ?? '');
    $viewData['products'] = $products;
    $viewData['searchTerm'] = $request->search ?? '';

    return view('product.search')->with('viewData', $viewData);
}

    private function handleImageUpload(Request $request, Product $product): void
    {
        if ($request->hasFile('images')) {
            // Delete old images if they're not the default
            $this->deleteOldImages($product->getImages(false));
            $imagePaths = $this->imageStorage->store($request, 'products');
            $product->setImages($imagePaths);
        } else {
            // Keep current images if no new images are uploaded
            $currentImages = $product->getImages(false);
            $product->setImages($currentImages);
        }
    }

    private function deleteOldImages(array $images): void
    {
        foreach ($images as $imagePath) {
            if ($imagePath !== 'images/logo.png') {
                $this->imageStorage->delete($imagePath);
            }
        }
    }
}
