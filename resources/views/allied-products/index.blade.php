<!-- Author: Isabella Camacho -->
@extends('layouts.app')

@section('title', __('product.title'))

@section('content')
    <div class="container py-4">
        <h1>Productos desde la API</h1>

        @if(session('error'))
            <p style="color:red;">{{ session('error') }}</p>
        @endif

        @if(!empty($products))
            <ul>
                @foreach($products as $product)
                    <li>
                        <strong>{{ $product['name'] ?? 'Sin nombre' }}</strong> - 
                        Precio: {{ $product['price'] ?? 'N/A' }}
                    </li>
                @endforeach
            </ul>
        @else
            <p>No hay productos disponibles.</p>
        @endif
     
    </div>
@endsection