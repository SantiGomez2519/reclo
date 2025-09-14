<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['notifications'] = Auth::guard('web')->user()->notifications ?? [];

        return view('home.index')->with('viewData', $viewData);
    }
}
