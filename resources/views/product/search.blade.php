@extends('layouts.app')

@section('title', __('product.title'))

@section('content')
    <div class="container py-4">

        <!-- Search and Filters Section -->
        <div class="card shadow-sm mb-5">
            <div class="card-body">
                <form method="GET" action="{{ route('product.search') }}">
                    <!-- Search Input -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label small text-muted mb-1">{{ __('product.search_keyword') }}</label>
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="{{ __('product.search_placeholder') }}" 
                                       value="{{ $viewData['filters']['search'] ?? '' }}">
                                <button type="submit" class="btn btn-dark">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Options  -->
                    <div class="row mb-3">
                        <div class="col-md-3 mb-2">
                            <label class="form-label small text-muted mb-1">{{ __('product.category') }}</label>
                            <select name="category" class="form-select">
                                <option value="">{{ __('product.all_categories') }}</option>
                                @foreach($viewData['categories'] as $category)
                                    <option value="{{ $category }}" 
                                        {{ (isset($viewData['filters']['category']) && $viewData['filters']['category'] == $category) ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 mb-2">
                            <label class="form-label small text-muted mb-1">{{ __('product.size') }}</label>
                            <select name="size" class="form-select">
                                <option value="">{{ __('product.all_sizes') }}</option>
                                @foreach($viewData['sizes'] as $size)
                                    <option value="{{ $size }}" 
                                        {{ (isset($viewData['filters']['size']) && $viewData['filters']['size'] == $size) ? 'selected' : '' }}>
                                        {{ $size }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 mb-2">
                            <label class="form-label small text-muted mb-1">{{ __('product.condition') }}</label>
                            <select name="condition" class="form-select">
                                <option value="">{{ __('product.all_conditions') }}</option>
                                @foreach($viewData['conditions'] as $condition)
                                    <option value="{{ $condition }}" 
                                        {{ (isset($viewData['filters']['condition']) && $viewData['filters']['condition'] == $condition) ? 'selected' : '' }}>
                                        {{ $condition }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 mb-2">
                            <label class="form-label small text-muted mb-1">{{ __('product.min_price') }}</label>
                            <input type="number" name="min_price" class="form-control" 
                                   placeholder="$0" min="0" 
                                   value="{{ $viewData['filters']['min_price'] ?? '' }}">
                        </div>

                        <div class="col-md-3 mb-2">
                            <label class="form-label small text-muted mb-1">{{ __('product.max_price') }}</label>
                            <input type="number" name="max_price" class="form-control" 
                                   placeholder="$10000" max="10000" 
                                   value="{{ $viewData['filters']['max_price'] ?? '' }}">
                        </div>
                    </div>

                    <!-- Action Buttons  -->
                    <div class="row justify-content-center">
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-dark w-100">
                                <i class="fas fa-filter me-2"></i>
                                {{ __('product.apply_filters') }}
                            </button>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('product.index') }}" class="btn btn-outline-dark w-100">
                                <i class="fas fa-undo me-2"></i>
                                {{ __('product.reset_filters') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Results Count  -->
        @if(isset($viewData['filters']) && count(array_filter($viewData['filters'])))
            <div class="alert alert-info mb-4">
                <i class="fas fa-info-circle me-2"></i>
                {{ __('product.showing_results_for') }}
                @if(!empty($viewData['filters']['search']))
                    <span class="badge bg-dark ms-2">{{ $viewData['filters']['search'] }}</span>
                @endif
                @if(!empty($viewData['filters']['category']))
                    <span class="badge bg-secondary ms-2">{{ $viewData['filters']['category'] }}</span>
                @endif
                @if(!empty($viewData['filters']['size']))
                    <span class="badge bg-success ms-2">{{ $viewData['filters']['size'] }}</span>
                @endif
                @if(!empty($viewData['filters']['condition']))
                    <span class="badge bg-warning ms-2">{{ $viewData['filters']['condition'] }}</span>
                @endif
                @if(!empty($viewData['filters']['min_price']))
                    <span class="badge bg-info ms-2">Min: ${{ $viewData['filters']['min_price'] }}</span>
                @endif
                @if(!empty($viewData['filters']['max_price']))
                    <span class="badge bg-info ms-2">Max: ${{ $viewData['filters']['max_price'] }}</span>
                @endif
            </div>
        @endif

        <!-- Products Grid  -->
        <div class="row g-4 mb-4">
            @forelse($viewData['products'] as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card h-100 shadow-sm product-card">
                        <!-- Product Image -->
                        <div class="position-relative">
                            <img src="{{ $product->getImages()[0] ?? asset('storage/images/logo.png') }}"
                                alt="{{ $product->getTitle() }}" class="card-img-top"
                                style="height: 250px; object-fit: cover;">

                            <!-- Condition Badge -->
                            <span class="position-absolute top-0 start-0 m-2 badge bg-success">
                                {{ $product->getCondition() }}
                            </span>

                            <!-- Action Icons -->
                            <div class="position-absolute top-0 end-0 m-2">
                                @if ($product->getSwap())
                                    <button class="btn btn-sm btn-dark bg-opacity-75 text-white me-1"
                                        title="Available for Exchange">
                                        <i class="fas fa-exchange-alt"></i>
                                    </button>
                                @endif
                                <button class="btn btn-sm btn-dark bg-opacity-75 text-white" title="Add to Favorites">
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
                                <span class="h5 text-dark fw-bold">${{ number_format($product->getPrice(), 0) }}</span>
                            </div>

                            <!-- Rating -->
                            <div class="mb-3">
                                <div class="d-flex align-items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-warning"></i>
                                    @endfor
                                    <span class="text-muted ms-2">(4.9)</span>
                                </div>
                            </div>

                            <!-- Category and Size Badges -->
                            <div class="mb-3">
                                <span class="badge bg-light text-dark me-1">{{ $product->getCategory() }}</span>
                                <span class="badge bg-light text-dark">{{ $product->getSize() }}</span>
                            </div>

                            <!-- View Product Button -->
                            <a href="{{ route('product.show', $product->getId()) }}"
                                class="btn btn-outline-dark mt-auto">
                                {{ __('product.view_details') }}
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-4x text-muted mb-3"></i>
                        <h3 class="text-muted">{{ __('product.no_products_found') }}</h3>
                        <p class="text-muted">{{ __('product.try_different_filters') }}</p>
                        <a href="{{ route('product.index') }}" class="btn btn-dark mt-3">
                            <i class="fas fa-undo me-2"></i>
                            {{ __('product.clear_all_filters') }}
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
