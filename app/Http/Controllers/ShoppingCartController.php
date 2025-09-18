<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ShoppingCartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(): View
    {
        $viewData = $this->getCartData();

        return view('cart.index')->with('viewData', $viewData);
    }

    public function add(Request $request, int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        if (! $product->getAvailable()) {
            return redirect()->back()->with('error', __('cart.product_not_available'));
        }

        if ($product->getSellerId() === Auth::guard('web')->id()) {
            return redirect()->back()->with('error', __('cart.cannot_buy_own_product'));
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            return redirect()->back()->with('error', __('cart.product_already_in_cart'));
        }

        $cart[$id] = 1;
        session()->put('cart', $cart);

        return redirect()->back()->with('success', __('cart.product_added'));
    }

    public function remove(Request $request, string $id): RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', __('cart.product_removed'));
    }

    public function clear(): RedirectResponse
    {
        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', __('cart.cleared'));
    }

    public function checkout(): View|RedirectResponse
    {
        $viewData = $this->getCartData();

        if (empty($viewData['cartItems'])) {
            return redirect()->route('cart.index')->with('error', __('cart.empty_cart'));
        }

        $viewData['user'] = Auth::guard('web')->user();
        $viewData['paymentMethods'] = ['credit_card', 'paypal', 'bank_transfer'];

        return view('cart.checkout')->with('viewData', $viewData);
    }

    public function processOrder(Request $request): RedirectResponse
    {
        $request->validate([
            'payment_method' => 'required|in:credit_card,paypal,bank_transfer',
        ]);

        $cart = session()->get('cart', []);
        $user = Auth::guard('web')->user();

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', __('cart.empty_cart'));
        }

        // Calculate total and validate products
        $total = 0;
        $products = [];
        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if (! $product || ! $product->getAvailable()) {
                return redirect()->route('cart.index')->with('error', __('cart.product_not_available'));
            }
            if ($product->getSellerId() === $user->getId()) {
                return redirect()->route('cart.index')->with('error', __('cart.cannot_buy_own_product'));
            }
            $total += $product->getPrice();
            $products[] = ['product' => $product, 'quantity' => 1];
        }

        // Create order
        $order = new Order;
        $order->setOrderDate(now()->format('Y-m-d H:i:s'));
        $order->setTotalPrice($total);
        $order->setStatus('completed');
        $order->setPaymentMethod($request->input('payment_method'));
        $order->setBuyerId($user->getId());
        $order->save();

        // Update products and mark as sold
        foreach ($products as $item) {
            $product = $item['product'];
            $product->setAvailable(false);
            $product->setOrderId($order->getId());
            $product->save();
        }

        // Clear cart
        session()->forget('cart');

        return redirect()->route('orders.show', $order->getId())->with('success', __('cart.order_completed'));
    }

    private function getCartData(): array
    {
        $cart = session()->get('cart', []);
        $viewData = [];
        $viewData['cartItems'] = [];
        $viewData['total'] = 0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product && $product->getAvailable()) {
                $viewData['cartItems'][] = [
                    'product' => $product,
                    'quantity' => 1,
                    'subtotal' => $product->getPrice(),
                ];
                $viewData['total'] += $product->getPrice();
            }
        }

        return $viewData;
    }
}
