<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class AlliedProductsApiController extends Controller
{
    /*
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
    }*/

    
    public function index()
    {
        $apiResponse = [
            "data" => [
                [
                    "id" => 101,
                    "name" => "Teléfono Inteligente Modelo A",
                    "description" => "Dispositivo de alta gama con cámara de 108MP y 128GB de almacenamiento. Pantalla OLED.",
                    "price" => 799.99,
                    "sku" => "TLF-SMART-A",
                    "brand" => "TecnoNova",
                    "stock" => 25,
                    "image" => "https://placehold.co/400x200/38B2AC/ffffff?text=Smartphone+A",
                    "url" => "#", // URL simulada
                    "category" => [
                        "id" => 1,
                        "name" => "Electrónica",
                        "description" => "Dispositivos electrónicos y gadgets."
                    ],
                ],
                [
                    "id" => 102,
                    "name" => "Auriculares Inalámbricos Pro",
                    "description" => "Cancelación de ruido activa, 30 horas de batería y ajuste cómodo.",
                    "price" => 149.50,
                    "sku" => "AUD-PRO-WRL",
                    "brand" => "SoundWave",
                    "stock" => 0, // Simulación de producto agotado
                    "image" => "https://placehold.co/400x200/9F7AEA/ffffff?text=Audifonos+Pro",
                    "url" => "#",
                    "category" => [
                        "id" => 1,
                        "name" => "Electrónica",
                        "description" => "Dispositivos electrónicos y gadgets."
                    ],
                ],
                [
                    "id" => 103,
                    "name" => "Taza de Café Programable",
                    "description" => "Mantiene la bebida a la temperatura exacta que elijas. Conexión Bluetooth.",
                    "price" => 45.00,
                    "sku" => "HOME-MUG-P",
                    "brand" => "CasaFutura",
                    "stock" => 40,
                    "image" => "https://placehold.co/400x200/F6E05E/000000?text=Taza+Smart",
                    "url" => "#",
                    "category" => [
                        "id" => 2,
                        "name" => "Hogar",
                        "description" => "Artículos para el hogar y cocina."
                    ],
                ],
            ]
        ];

        $products = $apiResponse;
        
        return view('allied-products.index', compact('products'));

    }

}
