<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomUser;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(): View
    {
        $viewData = [];
        $viewData['products'] = Product::with('seller')->paginate(10);

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
        Product::validateAdmin($request);

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

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'_'.uniqid().'.'.$image->getClientOriginalExtension();
            $image->storeAs('products', $imageName, 'public');
            $product->setImage('products/'.$imageName);
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

        Product::validateAdminUpdate($request);

        $product->setTitle($request->input('title'));
        $product->setDescription($request->input('description'));
        $product->setCategory($request->input('category'));
        $product->setColor($request->input('color'));
        $product->setSize($request->input('size'));
        $product->setCondition($request->input('condition'));
        $product->setPrice($request->input('price'));
        $product->setStatus($request->input('status'));
        $product->setSellerId($request->input('seller_id'));

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->getImage()) {
                Storage::disk('public')->delete($product->getImage());
            }

            $image = $request->file('image');
            $imageName = time().'_'.uniqid().'.'.$image->getClientOriginalExtension();
            $image->storeAs('products', $imageName, 'public');
            $product->setImage('products/'.$imageName);
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', __('admin.product_updated_successfully'));
    }

    public function destroy(string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        // Delete associated image if exists
        if ($product->getImage()) {
            Storage::disk('public')->delete($product->getImage());
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', __('admin.product_deleted_successfully'));
    }
}
