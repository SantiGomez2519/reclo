@extends('layouts.app')

{{-- Author: Santiago Gómez  --}}

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">
                    <i class="fas fa-credit-card me-2"></i>{{ __('cart.checkout') }}
                </h2>

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('cart.process-order') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">{{ __('cart.order_summary') }}</h5>
                                </div>
                                <div class="card-body">
                                    @foreach ($viewData['cartItems'] as $item)
                                        <div class="row align-items-center mb-3 pb-3 border-bottom">
                                            <div class="col-md-2">
                                                <img src="{{ $item['product']->getImages()[0] ?? asset('images/default-product.jpg') }}"
                                                    alt="{{ $item['product']->getTitle() }}" class="img-fluid rounded"
                                                    style="height: 60px; object-fit: cover;"
                                                    onerror="this.src='{{ asset('images/default-product.jpg') }}'">
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="mb-1">{{ $item['product']->getTitle() }}</h6>
                                                <small class="text-muted">{{ $item['product']->getCategory() }} -
                                                    {{ $item['product']->getSize() }}</small>
                                                <br>
                                                <small class="text-muted">{{ __('cart.sold_by') }}:
                                                    {{ $item['product']->seller->getName() }}</small>
                                            </div>
                                            <div class="col-md-2">
                                                <span class="badge bg-secondary">1</span>
                                                <small class="text-muted d-block">{{ __('cart.unique') }}</small>
                                            </div>
                                            <div class="col-md-2">
                                                <span class="fw-bold">${{ number_format($item['subtotal']) }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">{{ __('cart.payment_method') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($viewData['paymentMethods'] as $method)
                                            <div class="col-md-4 mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="payment_method"
                                                        id="payment_{{ $method }}" value="{{ $method }}"
                                                        required>
                                                    <label class="form-check-label" for="payment_{{ $method }}">
                                                        <i class="fas fa-credit-card me-2"></i>{{ __('cart.' . $method) }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('payment_method')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">{{ __('cart.order_summary') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <h6>{{ __('cart.order_details') }}</h6>
                                        <p class="mb-1"><strong>{{ __('cart.order_date') }}:</strong>
                                            {{ now()->format('M d, Y') }}</p>
                                        <p class="mb-1"><strong>{{ __('cart.order_status') }}:</strong>
                                            {{ __('cart.pending') }}</p>
                                    </div>

                                    <hr>

                                    <div class="d-flex justify-content-between mb-2">
                                        <span>{{ __('cart.total') }}:</span>
                                        <span class="fw-bold fs-5">${{ number_format($viewData['total']) }}</span>
                                    </div>

                                    <div class="d-grid gap-2 mt-4">
                                        <button type="submit" class="btn btn-success btn-lg">
                                            <i class="fas fa-check me-2"></i>{{ __('cart.place_order') }}
                                        </button>
                                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-arrow-left me-2"></i>{{ __('cart.back') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
