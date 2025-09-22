@extends('layouts.app')

{{-- Author: Santiago Gómez  --}}

@section('title', __('product.title'))

@section('content')
    <div class="container py-4">
        <!-- Header Section -->
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold text-dark mb-3">{{ __('product.featured_finds') }}</h1>
            <p class="lead text-muted mb-4">{{ __('product.handpicked_treasures') }}</p>
            @auth
                <a href="{{ route('product.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>
                    {{ __('product.sell_your_items') }}
                </a>
            @endauth
        </div>

        <!-- Products Grid -->
        <div class="row g-4 mb-4">
            @forelse($viewData['products'] as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card h-100 shadow-sm">
                        <!-- Product Image -->
                        <div class="position-relative">
                            <img src="{{ $product->getImages()[0] ?? asset('images/default-product.jpg') }}"
                                alt="{{ $product->getTitle() }}" class="card-img-top"
                                style="height: 250px; object-fit: cover;">

                            <!-- Condition Badge -->
                            <span class="position-absolute top-0 start-0 m-2 badge bg-success">
                                {{ $product->getCondition() }}
                            </span>

                            <!-- Action Icons -->
                            <div class="position-absolute top-0 end-0 m-2">
                                @if ($product->getSwap())
                                    <button class="btn btn-sm btn-dark bg-opacity-50 text-white me-1"
                                        title="{{ __('product.available_for_exchange') }}">
                                        <i class="fas fa-exchange-alt"></i>
                                    </button>
                                @endif
                                @auth('web')
                                    @if ($product->getSellerId() !== Auth::guard('web')->id())
                                        <form action="{{ route('cart.add', $product->getId()) }}" method="POST"
                                            class="d-inline me-1">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary bg-opacity-75 text-white"
                                                title="{{ __('product.add_to_cart') }}">
                                                <i class="fas fa-cart-plus"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                                <button class="btn btn-sm btn-dark bg-opacity-50 text-white"
                                    title="{{ __('product.add_to_favorites') }}">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->getTitle() }}</h5>
                            <p class="card-text text-muted small mb-2">{{ __('product.by') }}
                                {{ $product->seller->getName() }}</p>

                            <!-- Price -->
                            <div class="mb-2">
                                <span class="h5 text-dark fw-bold">${{ $product->getPrice() }}</span>
                            </div>

                            <!-- View Product Button -->
                            <a href="{{ route('product.show', $product->getId()) }}"
                                class="btn btn-outline-primary mt-auto">
                                {{ __('product.view_details') }}
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                        <h3 class="text-muted">{{ __('product.no_products_found') }}</h3>
                        <p class="text-muted">{{ __('product.be_first_to_list') }}</p>
                    </div>
                </div>
            @endforelse
        </div>

    </div>
@endsection