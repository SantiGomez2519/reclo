@extends('layouts.app')

@section('title', $viewData['product']->getTitle() . ' - Reclo')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('product.index') }}">{{ __('product.title') }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $viewData['product']->getTitle() }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <!-- Product Images -->
                <div class="card">
                    @php
                        $images = $viewData['product']->getImages();
                        $imageCount = count($images);
                    @endphp

                    @if ($imageCount > 1)
                        <!-- Multiple Images - Carousel -->
                        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($images as $index => $imagePath)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ url('storage/' . ltrim($imagePath, '/')) }}"
                                            alt="{{ $viewData['product']->getTitle() }} - Image {{ $index + 1 }}"
                                            class="d-block w-100" style="height: 500px; object-fit: cover;"
                                            onerror="this.src='{{ url('storage/images/logo.png') }}'">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    @else
                        <!-- Single Image -->
                        <img src="{{ $viewData['product']->getFirstImage() }}" alt="{{ $viewData['product']->getTitle() }}"
                            class="card-img-top" style="height: 500px; object-fit: cover;"
                            onerror="this.src='{{ url('storage/images/logo.png') }}'">
                    @endif
                </div>

                <!-- Condition Badge -->
                <div class="mt-3">
                    <span class="badge bg-success fs-6 me-2">{{ $viewData['product']->getCondition() }}</span>
                    @if ($viewData['product']->getSwap())
                        <span class="badge bg-primary fs-6">{{ __('product.available_for_exchange') }}</span>
                    @endif
                </div>
            </div>

            <div class="col-lg-6">
                <!-- Product Details -->
                <div class="card h-100">
                    <div class="card-body">
                        <!-- Title and Seller -->
                        <h1 class="card-title display-6 fw-bold mb-2">{{ $viewData['product']->getTitle() }}</h1>
                        <p class="text-muted fs-5 mb-3">{{ __('product.by') }}
                            {{ $viewData['product']->seller->getName() }}
                        </p>

                        <!-- Price -->
                        <div class="mb-4">
                            <span class="display-6 fw-bold text-dark">${{ $viewData['product']->getPrice() }}</span>
                            <span
                                class="text-muted text-decoration-line-through fs-5 ms-3">${{ $viewData['product']->getPrice() * 2 }}</span>
                        </div>

                        <!-- Rating -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-warning me-1"></i>
                                @endfor
                                <span class="text-muted ms-2">(4.9) • 23 {{ __('product.reviews') }}</span>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <h5 class="fw-bold">{{ __('product.description_label') }}</h5>
                            <p class="text-muted">{{ $viewData['product']->getDescription() }}</p>
                        </div>

                        <!-- Product Details -->
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">{{ __('product.product_details') }}</h5>
                            <div class="row g-3">
                                <div class="col-6">
                                    <strong>{{ __('product.category') }}:</strong>
                                    <span class="text-muted">{{ $viewData['product']->getCategory() }}</span>
                                </div>
                                <div class="col-6">
                                    <strong>{{ __('product.color') }}:</strong>
                                    <span class="text-muted">{{ $viewData['product']->getColor() }}</span>
                                </div>
                                <div class="col-6">
                                    <strong>{{ __('product.size') }}:</strong>
                                    <span class="text-muted">{{ $viewData['product']->getSize() }}</span>
                                </div>
                                <div class="col-6">
                                    <strong>{{ __('product.condition') }}:</strong>
                                    <span class="text-muted">{{ $viewData['product']->getCondition() }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-auto">
                            @auth
                                @if ($viewData['product']->getSellerId() === Auth::guard('web')->id())
                                    <!-- Owner Actions -->
                                    <div class="d-grid gap-2">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <a href="{{ route('product.edit', $viewData['product']->getId()) }}"
                                                    class="btn btn-primary w-100">
                                                    <i class="fas fa-edit me-2"></i>
                                                    {{ __('product.edit_product') }}
                                                </a>
                                            </div>
                                            <div class="col-6">
                                                <form action="{{ route('product.destroy', $viewData['product']->getId()) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('{{ __('product.are_you_sure_delete') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger w-100">
                                                        <i class="fas fa-trash me-2"></i>
                                                        {{ __('product.delete_product') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        @if ($viewData['product']->getStatus() === 'available')
                                            <form action="{{ route('product.mark-sold', $viewData['product']->getId()) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success w-100">
                                                    <i class="fas fa-check me-2"></i>
                                                    {{ __('product.mark_as_sold') }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @else
                                    <!-- Buyer Actions -->
                                    <div class="d-grid gap-2">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <button class="btn btn-primary w-100">
                                                    <i class="fas fa-shopping-cart me-2"></i>
                                                    {{ __('product.add_to_cart') }}
                                                </button>
                                            </div>
                                            @if ($viewData['product']->getSwap())
                                                <div class="col-6">
                                                    <button class="btn btn-success w-100">
                                                        <i class="fas fa-exchange-alt me-2"></i>
                                                        {{ __('product.propose_exchange') }}
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                        <button class="btn btn-outline-secondary w-100">
                                            <i class="fas fa-heart me-2"></i>
                                            {{ __('product.add_to_favorites') }}
                                        </button>
                                    </div>
                                @endif
                            @else
                                <div class="text-center">
                                    <p class="text-muted mb-3">{{ __('product.please_login') }}</p>
                                    <a href="{{ route('login') }}" class="btn btn-primary">
                                        {{ __('product.log_in') }}
                                    </a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="row mt-5">
            <div class="col-12">
                <h2 class="fw-bold mb-4">{{ __('product.reviews') }}</h2>
                <div class="card">
                    <div class="card-body">
                        @if ($viewData['product']->review)
                            <div class="d-flex align-items-center mb-3">
                                @for ($i = 1; $i <= $viewData['product']->review->getRating(); $i++)
                                    <i class="fas fa-star text-warning me-1"></i>
                                @endfor
                                <span class="text-muted ms-2">{{ $viewData['product']->review->getRating() }}/5</span>
                            </div>
                            <p class="text-muted mb-2">{{ $viewData['product']->review->getComment() }}</p>
                            <small class="text-muted">{{ __('product.by') }}
                                {{ $viewData['product']->review->user->getName() }}</small>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                <p class="text-muted">{{ __('product.no_reviews_yet') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
