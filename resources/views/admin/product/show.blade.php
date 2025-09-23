<!-- Author: Pablo Cabrejos -->
@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card admin-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-eye me-2"></i>{{ __('admin.product_details') }}
                        </h4>
                        <div>
                            <a href="{{ route('admin.products.edit', $viewData['product']->getId()) }}"
                                class="btn btn-warning me-2">
                                <i class="fas fa-edit me-1"></i>{{ __('admin.edit') }}
                            </a>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>{{ __('admin.back_to_list') }}
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                @if (count($viewData['product']->getImages()) > 0)
                                    @if (count($viewData['product']->getImages()) > 1)
                                        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                @foreach ($viewData['product']->getImages() as $imageUrl)
                                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                        <img src="{{ $imageUrl }}"
                                                            alt="{{ $viewData['product']->getTitle() }}"
                                                            class="d-block w-100 img-fluid rounded shadow-sm"
                                                            onerror="this.src='{{ asset('images/default-product.jpg') }}'">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button class="carousel-control-prev" type="button"
                                                data-bs-target="#productCarousel" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon"></span>
                                            </button>
                                            <button class="carousel-control-next" type="button"
                                                data-bs-target="#productCarousel" data-bs-slide="next">
                                                <span class="carousel-control-next-icon"></span>
                                            </button>
                                        </div>
                                    @else
                                        <img src="{{ $viewData['product']->getImages()[0] }}"
                                            alt="{{ $viewData['product']->getTitle() }}"
                                            class="img-fluid rounded shadow-sm"
                                            onerror="this.src='{{ asset('images/default-product.jpg') }}'">
                                    @endif
                                @else
                                    <div class="text-center p-5 bg-light rounded shadow-sm">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                        <p class="text-muted mt-2">{{ __('admin.no_image_available') }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <strong class="text-muted">{{ __('admin.id') }}:</strong>
                                            <p class="mb-1">{{ $viewData['product']->getId() }}</p>
                                        </div>

                                        <div class="mb-3">
                                            <strong class="text-muted">{{ __('admin.product_title') }}:</strong>
                                            <p class="mb-1">{{ $viewData['product']->getTitle() }}</p>
                                        </div>

                                        <div class="mb-3">
                                            <strong class="text-muted">{{ __('admin.category') }}:</strong>
                                            <p class="mb-1">
                                                <span
                                                    class="badge bg-primary">{{ __('admin.category_' . $viewData['product']->getCategory()) }}</span>
                                            </p>
                                        </div>

                                        <div class="mb-3">
                                            <strong class="text-muted">{{ __('admin.price') }}:</strong>
                                            <p class="mb-1 fs-5 fw-bold text-success">
                                                ${{ number_format($viewData['product']->getPrice()) }}</p>
                                        </div>

                                        <div class="mb-3">
                                            <strong class="text-muted">{{ __('admin.status') }}:</strong>
                                            <p class="mb-1">
                                                <span
                                                    class="badge {{ $viewData['product']->getAvailable() ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $viewData['product']->getAvailable() ? __('admin.status_available') : __('admin.status_unavailable') }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <strong class="text-muted">{{ __('admin.product_color') }}:</strong>
                                            <p class="mb-1">{{ $viewData['product']->getColor() }}</p>
                                        </div>

                                        <div class="mb-3">
                                            <strong class="text-muted">{{ __('admin.product_size') }}:</strong>
                                            <p class="mb-1">{{ $viewData['product']->getSize() }}</p>
                                        </div>

                                        <div class="mb-3">
                                            <strong class="text-muted">{{ __('admin.product_condition') }}:</strong>
                                            <p class="mb-1">
                                                <span
                                                    class="badge bg-info">{{ __('admin.condition_' . $viewData['product']->getCondition()) }}</span>
                                            </p>
                                        </div>

                                        <div class="mb-3">
                                            <strong class="text-muted">{{ __('admin.swap_available') }}:</strong>
                                            <p class="mb-1">
                                                <span
                                                    class="badge {{ $viewData['product']->getSwap() ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $viewData['product']->getSwap() ? __('admin.yes') : __('admin.no') }}
                                                </span>
                                            </p>
                                        </div>

                                        <div class="mb-3">
                                            <strong class="text-muted">{{ __('admin.created_at') }}:</strong>
                                            <p class="mb-1">
                                                {{ date('M d, Y H:i', strtotime($viewData['product']->getCreatedAt())) }}
                                            </p>
                                        </div>

                                        <div class="mb-3">
                                            <strong class="text-muted">{{ __('admin.last_updated') }}:</strong>
                                            <p class="mb-1">
                                                {{ date('M d, Y H:i', strtotime($viewData['product']->getUpdatedAt())) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <strong class="text-muted">{{ __('admin.description') }}:</strong>
                                    <p class="mb-1 mt-2">{{ $viewData['product']->getDescription() }}</p>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Seller Information -->
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="mb-3">
                                    <i class="fas fa-user me-2"></i>{{ __('admin.seller_information') }}
                                </h5>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <strong>{{ __('admin.name') }}:</strong>
                                                <p class="mb-1">{{ $viewData['product']->seller->getName() }}</p>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>{{ __('admin.email') }}:</strong>
                                                <p class="mb-1">{{ $viewData['product']->seller->getEmail() }}</p>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>{{ __('admin.phone') }}:</strong>
                                                <p class="mb-1">{{ $viewData['product']->seller->getPhone() }}</p>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>{{ __('admin.payment_method') }}:</strong>
                                                <p class="mb-1">
                                                    <span
                                                        class="badge bg-info">{{ __('admin.payment_' . str_replace(' ', '_', strtolower($viewData['product']->seller->getPaymentMethod()))) }}</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <a href="{{ route('admin.customusers.show', $viewData['product']->seller->getId()) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fas fa-user me-1"></i>{{ __('admin.view_seller_profile') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
