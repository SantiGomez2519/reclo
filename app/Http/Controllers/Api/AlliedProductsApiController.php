<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class AlliedProductApiController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $url = 'http://127.0.0.1:8000/api/products';

        try {
            $response = Http::get($url);

            if ($response->successful()) {
                $products = $response->json();

                return view('allied-products.index', compact('products'));
            } else {
                return redirect()->back()->with('error', 'Error al obtener los productos. Código: '.$response->status());
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se pudo conectar con la API: '.$e->getMessage());
        }
    }
}
