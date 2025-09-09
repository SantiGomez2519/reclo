<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home.index');
    }

    public function prueba(): View|RedirectResponse
    {
        return redirect()->route('home.index')->with('status', 'Operación realizada con éxito');

    }
}
