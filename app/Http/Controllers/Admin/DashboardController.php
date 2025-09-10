<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(): View
    {
        $viewData = [];
        $viewData['admin'] = Auth::guard('admin')->user();

        return view('admin.dashboard')->with('viewData', $viewData);
    }
}
