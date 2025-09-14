<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomUser;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(): View
    {
        $viewData = [];
        $viewData['admin'] = Auth::guard('admin')->user();
        $viewData['customUsersCount'] = CustomUser::count();
        $viewData['productsCount'] = Product::count();

        return view('admin.dashboard')->with('viewData', $viewData);
    }
}
