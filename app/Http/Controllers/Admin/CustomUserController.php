<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class CustomUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(): View
    {
        $viewData = [];
        $viewData['customUsers'] = CustomUser::withCount('products')->paginate(10);

        return view('admin.customuser.index')->with('viewData', $viewData);
    }

    public function show(string $id): View
    {
        $viewData = [];
        $viewData['customUser'] = CustomUser::with(['products', 'orders', 'reviews'])->findOrFail($id);

        return view('admin.customuser.show')->with('viewData', $viewData);
    }

    public function create(): View
    {
        return view('admin.customuser.create');
    }

    public function store(Request $request): RedirectResponse
    {
        CustomUser::validate($request);

        $customUser = new CustomUser;
        $customUser->setName($request->input('name'));
        $customUser->setPhone($request->input('phone'));
        $customUser->setEmail($request->input('email'));
        $customUser->setPassword(Hash::make($request->input('password')));
        $customUser->setPaymentMethod($request->input('payment_method'));
        $customUser->save();

        return redirect()->route('admin.customusers.index')->with('success', __('admin.customer_created_successfully'));
    }

    public function edit(string $id): View
    {
        $viewData = [];
        $viewData['customUser'] = CustomUser::findOrFail($id);

        return view('admin.customuser.edit')->with('viewData', $viewData);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $customUser = CustomUser::findOrFail($id);

        CustomUser::validateUpdate($request, (int) $id);

        $customUser->setName($request->input('name'));
        $customUser->setPhone($request->input('phone'));
        $customUser->setEmail($request->input('email'));
        $customUser->setPaymentMethod($request->input('payment_method'));

        // Only update password if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $customUser->setPassword(Hash::make($request->input('password')));
        }

        $customUser->save();

        return redirect()->route('admin.customusers.index')->with('success', __('admin.customer_updated_successfully'));
    }

    public function destroy(string $id): RedirectResponse
    {
        $customUser = CustomUser::findOrFail($id);

        // Check if user has products or orders before deleting
        if ($customUser->products()->count() > 0 || $customUser->orders()->count() > 0) {
            return redirect()->route('admin.customusers.index')
                ->with('error', __('admin.cannot_delete_customer'));
        }

        $customUser->delete();

        return redirect()->route('admin.customusers.index')->with('success', __('admin.customer_deleted_successfully'));
    }
}
