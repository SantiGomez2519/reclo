<!-- Author: Santiago Gómez -->
@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">
                    <i class="fas fa-shopping-cart me-2"></i>{{ __('cart.title') }}
                </h2>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (count($viewData['cartItems']) > 0)
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    @foreach ($viewData['cartItems'] as $item)
                                        <div class="row align-items-center mb-3 pb-3 border-bottom">
                                            <div class="col-md-2">
                                                <img src="{{ $item['product']->getImages()[0] ?? asset('images/default-product.jpg') }}"
                                                    alt="{{ $item['product']->getTitle() }}" class="img-fluid rounded"
                                                    style="height: 80px; object-fit: cover;"
                                                    onerror="this.src='{{ asset('images/default-product.jpg') }}'">
                                            </div>
                                            <div class="col-md-4">
                                                <h6 class="mb-1">{{ $item['product']->getTitle() }}</h6>
                                                <small class="text-muted">{{ $item['product']->getCategory() }} -
                                                    {{ $item['product']->getSize() }}</small>
                                                <br>
                                                <small class="text-muted">{{ __('cart.sold_by') }}:
                                                    {{ $item['product']->getSeller()->getName() }}</small>
                                            </div>
                                            <div class="col-md-2">
                                                <span
                                                    class="fw-bold">${{ number_format($item['product']->getPrice()) }}</span>
                                            </div>
                                            <div class="col-md-2">
                                                <span class="badge bg-secondary fs-6">1</span>
                                                <small class="text-muted d-block">{{ __('cart.unique') }}</small>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="fw-bold">${{ number_format($item['subtotal']) }}</span>
                                                    <form action="{{ route('cart.remove', $item['product']->getId()) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                                            onclick="return confirm('{{ __('cart.remove') }}?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">{{ __('cart.order_summary') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-3">
                                        <span>{{ __('cart.total') }}:</span>
                                        <span class="fw-bold fs-5">${{ number_format($viewData['total']) }}</span>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <a href="{{ route('cart.checkout') }}" class="btn btn-primary">
                                            <i class="fas fa-credit-card me-2"></i>{{ __('cart.proceed_checkout') }}
                                        </a>
                                        <a href="{{ route('product.index') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-arrow-left me-2"></i>{{ __('cart.continue_shopping') }}
                                        </a>
                                        <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger w-100"
                                                onclick="return confirm('{{ __('cart.clear_cart') }}?')">
                                                <i class="fas fa-trash me-2"></i>{{ __('cart.clear_cart') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                        <h4 class="text-muted">{{ __('cart.empty_cart') }}</h4>
                        <p class="text-muted mb-4">{{ __('cart.continue_shopping') }}</p>
                        <a href="{{ route('product.index') }}" class="btn btn-primary">
                            <i class="fas fa-shopping-bag me-2"></i>{{ __('cart.continue_shopping') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
