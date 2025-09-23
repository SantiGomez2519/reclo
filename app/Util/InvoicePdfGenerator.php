<?php

// Author: Pablo Cabrejos

namespace App\Util;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class InvoicePdfGenerator
{
    public static function generateInvoicePdf(Order $order): Response
    {
        // Load the order with related data
        $order->load(['buyer', 'products.seller']);

        $viewData = [];
        $viewData['order'] = $order;
        $viewData['company'] = [
            'name' => 'Reclo Marketplace',
            'address' => '123 Commerce Street',
            'city' => 'Medellín, Colombia',
            'phone' => '+57 (4) 123-4567',
            'email' => 'info@reclo.com',
            'website' => 'www.reclo.com',
        ];
        $viewData['invoice_date'] = now()->format('Y-m-d');
        $viewData['invoice_number'] = 'INV-'.str_pad($order->getId(), 6, '0', STR_PAD_LEFT);
        $viewData['css'] = file_get_contents(public_path('css/invoice.css'));

        $data = ['viewData' => $viewData];
        $pdf = Pdf::loadView('invoice.pdf', $data);
        $filename = 'invoice-'.$viewData['invoice_number'].'.pdf';

        return $pdf->download($filename);
    }
}
