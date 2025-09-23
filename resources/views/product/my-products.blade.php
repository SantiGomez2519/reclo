<!-- Author: Santiago Gómez -->
@extends('layouts.app')

@section('title', __('product.my_products_title'))

@section('content')
    <div class="container py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="display-5 fw-bold text-dark mb-2">{{ __('product.my_products') }}</h1>
                <p class="lead text-muted">{{ __('product.manage_listed_items') }}</p>
            </div>
            <a href="{{ route('product.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus me-2"></i>
                {{ __('product.add_new_product') }}
            </a>
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

                            <!-- Status Badge -->
                            <span
                                class="position-absolute top-0 start-0 m-2 badge {{ $product->getAvailable() ? 'bg-success' : 'bg-danger' }}">
                                {{ $product->getAvailable() ? __('product.available') : __('product.sold') }}
                            </span>

                            <!-- Condition Badge -->
                            <span class="position-absolute top-0 end-0 m-2 badge bg-primary">
                                {{ $product->getCondition() }}
                            </span>
                        </div>

                        <!-- Product Info -->
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->getTitle() }}</h5>
                            <p class="card-text text-muted small mb-2">{{ $product->getCategory() }} •
                                {{ $product->getSize() }}</p>

                            <!-- Price -->
                            <div class="mb-3">
                                <span class="h5 fw-bold text-dark">${{ $product->getPrice() }}</span>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-auto">
                                <a href="{{ route('product.show', $product->getId()) }}"
                                    class="btn btn-outline-primary btn-sm w-100 mb-2">
                                    {{ __('product.view_details') }}
                                </a>

                                @if ($product->getAvailable())
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <a href="{{ route('product.edit', $product->getId()) }}"
                                                class="btn btn-primary btn-sm w-100">
                                                {{ __('product.edit_product') }}
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <form action="{{ route('product.destroy', $product->getId()) }}" method="POST"
                                                onsubmit="return confirm('{{ __('product.are_you_sure_delete') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm w-100">
                                                    {{ __('product.delete_product') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <small class="text-muted">{{ __('product.product_sold') }}</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                        <h3 class="text-muted">{{ __('product.no_products_yet') }}</h3>
                        <p class="text-muted mb-4">{{ __('product.start_selling') }}</p>
                        <a href="{{ route('product.create') }}" class="btn btn-primary btn-lg">
                            {{ __('product.list_first_product') }}
                        </a>
                    </div>
                </div>
            @endforelse
        </div>


        <!-- Statistics -->
        @if ($viewData['products']->count() > 0)
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-4">{{ __('product.your_statistics') }}</h5>
                            <div class="row text-center">
                                <div class="col-md-4">
                                    <div class="h2 text-primary fw-bold">
                                        {{ $viewData['products']->where('available', true)->count() }}</div>
                                    <div class="text-muted">{{ __('product.available_items') }}</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="h2 text-success fw-bold">
                                        {{ $viewData['products']->where('available', false)->count() }}</div>
                                    <div class="text-muted">{{ __('product.sold_items') }}</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="h2 text-info fw-bold">
                                        {{ $viewData['products']->where('swap', true)->count() }}</div>
                                    <div class="text-muted">{{ __('product.exchange_items') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
