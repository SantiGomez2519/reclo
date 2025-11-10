<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class AlliedProductsApiController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $url = env('API_URL').'/api/products';

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
