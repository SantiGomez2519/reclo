<!-- Author: Isabella Camacho -->
@extends('layouts.app')

@section('title', __('allied-products.title')) 

@section('content')
    <div class="container py-4">
        <!-- Header Section -->
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold text-dark mb-3">{{ __('allied-products.header') }}</h1>
            <p class="lead text-muted mb-4">{{ __('allied-products.intro') }}</p>
            @auth
                <a href="{{ route('product.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>
                    {{ __('allied-products.visit_website') }}
                </a>
            @endauth
        </div>

        @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <!-- Products Grid -->
        @if(!empty($products) && !empty($products['data']))
            <div class="row">
                @foreach($products['data'] as $product)
                    <div class="col-md-4 mb-4"> 
                        <div class="card h-100 shadow-sm">
                            @if(!empty($product['image']))
                                <img src="{{ $product['image'] }}" class="card-img-top" alt="{{ $product['name'] ?? __('allied-products.product_details.name') }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <p class="text-muted">{{ __('allied-products.product_details.image_missing') }}</p>
                                </div>
                            @endif
                            
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $product['name'] ?? __('allied-products.product_details.name') }}</h5>
                                <h6 class="card-subtitle mb-2 text-primary">${{ number_format($product['price'] ?? 0, 2) }}</h6>
                                
                                <p class="card-text text-muted">{{ Str::limit($product['description'] ?? __('allied-products.product_details.description_missing'), 80) }}</p>

                                <ul class="list-group list-group-flush mb-3 mt-auto"> {{-- mt-auto empuja la lista hacia abajo --}}
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-1 border-0">
                                        {{ __('allied-products.product_details.sku') }}
                                        <span class="badge bg-secondary">{{ $product['sku'] ?? 'N/A' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-1 border-0">
                                        {{ __('allied-products.product_details.brand') }}
                                        <span>{{ $product['brand'] ?? 'N/A' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-1 border-0">
                                        {{ __('allied-products.product_details.stock') }}
                                        <span class="badge {{ ($product['stock'] ?? 0) > 0 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $product['stock'] ?? 0 }}
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-1 border-0">
                                        {{ __('allied-products.product_details.category') }}
                                        <span class="text-info">{{ $product['category']['name'] ?? __('allied-products.product_details.category_missing') }}</span>
                                    </li>
                                </ul>

                                @if(!empty($product['url']))
                                    <a href="{{ $product['url'] }}" class="btn btn-primary mt-2" target="_blank">{{ __('allied-products.product_details.button_details') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-warning" role="alert">
                {{ __('allied-products.no_products') }}
            </div>
        @endif
    </div>
@endsection