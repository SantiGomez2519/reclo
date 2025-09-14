@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>
                        <i class="fas fa-receipt me-2"></i>{{ __('cart.order_details') }} #{{ $viewData['order']->getId() }}
                    </h2>
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>{{ __('cart.back') }}
                    </a>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">{{ __('cart.item') }}s del Pedido</h5>
                            </div>
                            <div class="card-body">
                                @foreach ($viewData['order']->products as $product)
                                    <div class="row align-items-center mb-3 pb-3 border-bottom">
                                        <div class="col-md-2">
                                            <img src="{{ $product->getImages()[0] ?? asset('images/default-product.jpg') }}"
                                                alt="{{ $product->getTitle() }}" class="img-fluid rounded"
                                                style="height: 80px; object-fit: cover;"
                                                onerror="this.src='{{ asset('images/default-product.jpg') }}'">
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="mb-1">{{ $product->getTitle() }}</h6>
                                            <p class="mb-1 text-muted">{{ $product->getDescription() }}</p>
                                            <small class="text-muted">
                                                {{ $product->getCategory() }} - {{ $product->getSize() }} -
                                                {{ $product->getCondition() }}
                                            </small>
                                            <br>
                                            <small class="text-muted">Vendido por:
                                                {{ $product->seller->getName() }}</small>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="fw-bold">${{ number_format($product->getPrice()) }}</span>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="badge bg-success">{{ __('cart.completed') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Información del Pedido</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <h6>{{ __('cart.order_number') }}</h6>
                                    <p class="mb-0">#{{ $viewData['order']->getId() }}</p>
                                </div>

                                <div class="mb-3">
                                    <h6>{{ __('cart.order_date') }}</h6>
                                    <p class="mb-0">
                                        {{ date('M d, Y H:i', strtotime($viewData['order']->getCreatedAt())) }}</p>
                                </div>

                                <div class="mb-3">
                                    <h6>{{ __('cart.order_status') }}</h6>
                                    <span class="badge bg-success fs-6">{{ __('cart.completed') }}</span>
                                </div>

                                <div class="mb-3">
                                    <h6>{{ __('cart.payment_method') }}</h6>
                                    <p class="mb-0">
                                        {{ ucfirst(str_replace('_', ' ', $viewData['order']->getPaymentMethod())) }}</p>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">{{ __('cart.order_total') }}:</h5>
                                    <h4 class="mb-0 text-success">${{ number_format($viewData['order']->getTotalPrice()) }}
                                    </h4>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header">
                                <h5 class="mb-0">Información del Comprador</h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-1"><strong>Nombre:</strong> {{ $viewData['order']->buyer->getName() }}</p>
                                <p class="mb-1"><strong>Email:</strong> {{ $viewData['order']->buyer->getEmail() }}</p>
                                <p class="mb-0"><strong>Teléfono:</strong> {{ $viewData['order']->buyer->getPhone() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
