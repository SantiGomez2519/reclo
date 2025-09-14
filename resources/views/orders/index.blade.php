@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">
                    <i class="fas fa-receipt me-2"></i>{{ __('cart.order_details') }}
                </h2>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (count($viewData['orders']) > 0)
                    <div class="row">
                        @foreach ($viewData['orders'] as $order)
                            <div class="col-lg-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">
                                            {{ __('cart.order_number') }}{{ $order->getId() }}
                                        </h6>
                                        <span class="badge bg-success">{{ __('cart.completed') }}</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-1">
                                                    <strong>{{ __('cart.order_date') }}:</strong><br>
                                                    {{ date('M d, Y H:i', strtotime($order->getCreatedAt())) }}
                                                </p>
                                                <p class="mb-1">
                                                    <strong>{{ __('cart.payment_method') }}:</strong><br>
                                                    {{ ucfirst(str_replace('_', ' ', $order->getPaymentMethod())) }}
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1">
                                                    <strong>{{ __('cart.order_total') }}:</strong><br>
                                                    <span
                                                        class="fs-5 fw-bold text-success">${{ number_format($order->getTotalPrice()) }}</span>
                                                </p>
                                                <p class="mb-1">
                                                    <strong>{{ __('cart.item') }}s:</strong><br>
                                                    {{ $order->products->count() }} {{ __('cart.item') }}(s)
                                                </p>
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <h6>{{ __('cart.item') }}s:</h6>
                                            @foreach ($order->products as $product)
                                                <div class="d-flex align-items-center mb-2">
                                                    <img src="{{ $product->getImages()[0] ?? asset('images/default-product.jpg') }}"
                                                        alt="{{ $product->getTitle() }}" class="img-thumbnail me-3"
                                                        style="width: 40px; height: 40px; object-fit: cover;"
                                                        onerror="this.src='{{ asset('images/default-product.jpg') }}'">
                                                    <div class="flex-grow-1">
                                                        <small class="fw-bold">{{ $product->getTitle() }}</small><br>
                                                        <small
                                                            class="text-muted">${{ number_format($product->getPrice()) }}</small>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('orders.show', $order->getId()) }}"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye me-1"></i>{{ __('cart.view_order') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-receipt fa-4x text-muted mb-4"></i>
                        <h4 class="text-muted">{{ __('cart.no_orders') }}</h4>
                        <p class="text-muted mb-4">Comienza a comprar productos para ver tus pedidos aquí</p>
                        <a href="{{ route('product.index') }}" class="btn btn-primary">
                            <i class="fas fa-shopping-bag me-2"></i>Ver Productos
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
