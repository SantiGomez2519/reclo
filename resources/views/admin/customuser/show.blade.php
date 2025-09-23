<!-- Author: Pablo Cabrejos -->
@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card admin-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-user me-2"></i>{{ __('admin.customer_details') }}
                        </h4>
                        <div>
                            <a href="{{ route('admin.customusers.edit', $viewData['customUser']->getId()) }}"
                                class="btn btn-warning me-2">
                                <i class="fas fa-edit me-1"></i>{{ __('admin.edit') }}
                            </a>
                            <a href="{{ route('admin.customusers.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>{{ __('admin.back_to_customers') }}
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Customer Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="mb-3">
                                    <i class="fas fa-info-circle me-2"></i>{{ __('admin.personal_information') }}
                                </h5>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <strong class="text-muted">{{ __('admin.customer_id') }}:</strong>
                                                    <p class="mb-1">{{ $viewData['customUser']->getId() }}</p>
                                                </div>

                                                <div class="mb-3">
                                                    <strong class="text-muted">{{ __('admin.full_name') }}:</strong>
                                                    <p class="mb-1">{{ $viewData['customUser']->getName() }}</p>
                                                </div>

                                                <div class="mb-3">
                                                    <strong class="text-muted">{{ __('admin.email') }}:</strong>
                                                    <p class="mb-1">{{ $viewData['customUser']->getEmail() }}</p>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <strong class="text-muted">{{ __('admin.phone') }}:</strong>
                                                    <p class="mb-1">{{ $viewData['customUser']->getPhone() }}</p>
                                                </div>

                                                <div class="mb-3">
                                                    <strong class="text-muted">{{ __('admin.payment_method') }}:</strong>
                                                    <p class="mb-1">
                                                        <span
                                                            class="badge bg-info">{{ __('admin.payment_' . str_replace(' ', '_', strtolower($viewData['customUser']->getPaymentMethod()))) }}</span>
                                                    </p>
                                                </div>

                                                <div class="mb-3">
                                                    <strong class="text-muted">{{ __('admin.member_since') }}:</strong>
                                                    <p class="mb-1">
                                                        {{ date('M d, Y', strtotime($viewData['customUser']->getCreatedAt())) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5 class="mb-3">
                                    <i class="fas fa-chart-bar me-2"></i>{{ __('admin.activity_summary') }}
                                </h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card text-center bg-primary text-white">
                                            <div class="card-body">
                                                <h3 class="card-title">
                                                    {{ $viewData['customUser']->getProducts()->count() }}</h3>
                                                <p class="card-text">{{ __('admin.products_listed') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card text-center bg-success text-white">
                                            <div class="card-body">
                                                <h3 class="card-title">{{ $viewData['customUser']->getOrders()->count() }}
                                                </h3>
                                                <p class="card-text">{{ __('admin.orders_made') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card text-center bg-info text-white">
                                            <div class="card-body">
                                                <h3 class="card-title">{{ $viewData['customUser']->getReviews()->count() }}
                                                </h3>
                                                <p class="card-text">{{ __('admin.reviews_written') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Products Section -->
                        @if ($viewData['customUser']->getProducts()->count() > 0)
                            <div class="mb-4">
                                <h5 class="mb-3">
                                    <i class="fas fa-shopping-bag me-2"></i>{{ __('admin.products_listed') }}
                                    ({{ $viewData['customUser']->getProducts()->count() }})
                                </h5>
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>{{ __('admin.id') }}</th>
                                                <th>{{ __('admin.image') }}</th>
                                                <th>{{ __('admin.product_title') }}</th>
                                                <th>{{ __('admin.category') }}</th>
                                                <th>{{ __('admin.price') }}</th>
                                                <th>{{ __('admin.status') }}</th>
                                                <th>{{ __('admin.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($viewData['customUser']->getProducts()->take(5) as $product)
                                                <tr>
                                                    <td>{{ $product->getId() }}</td>
                                                    <td>
                                                        @if ($product->getImages()[0] ?? null)
                                                            <div class="customer-product-thumbnail">
                                                                <img src="{{ $product->getImages()[0] }}"
                                                                    alt="{{ $product->getTitle() }}"
                                                                    class="img-thumbnail customer-product-img"
                                                                    onerror="this.src='{{ asset('images/default-product.jpg') }}'">
                                                            </div>
                                                        @else
                                                            <div
                                                                class="customer-product-placeholder d-flex align-items-center justify-content-center">
                                                                <i class="fas fa-image text-muted icon-small"></i>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>{{ $product->getTitle() }}</td>
                                                    <td>{{ __('admin.category_' . $product->getCategory()) }}</td>
                                                    <td>${{ number_format($product->getPrice()) }}</td>
                                                    <td>
                                                        <span
                                                            class="badge {{ $product->getAvailable() ? 'bg-success' : 'bg-secondary' }}">
                                                            {{ $product->getAvailable() ? __('admin.status_available') : __('admin.status_unavailable') }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.products.show', $product->getId()) }}"
                                                            class="btn btn-sm btn-outline-primary"
                                                            title="{{ __('admin.view_product') }}">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if ($viewData['customUser']->getProducts()->count() > 5)
                                    <div class="text-center">
                                        <small
                                            class="text-muted">{{ __('admin.showing_products', ['shown' => 5, 'total' => $viewData['customUser']->getProducts()->count()]) }}</small>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Orders Section -->
                        @if ($viewData['customUser']->getOrders()->count() > 0)
                            <div class="mb-4">
                                <h5 class="mb-3">
                                    <i class="fas fa-shopping-cart me-2"></i>{{ __('admin.recent_orders') }}
                                    ({{ $viewData['customUser']->getOrders()->count() }})
                                </h5>
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>{{ __('admin.order_id') }}</th>
                                                <th>{{ __('admin.date') }}</th>
                                                <th>{{ __('admin.total') }}</th>
                                                <th>{{ __('admin.status') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($viewData['customUser']->getOrders()->take(5) as $order)
                                                <tr>
                                                    <td>{{ $order->getId() }}</td>
                                                    <td>{{ date('M d, Y', strtotime($order->getCreatedAt())) }}</td>
                                                    <td>${{ number_format($order->getTotal()) }}</td>
                                                    <td>
                                                        <span
                                                            class="badge bg-info">{{ __('admin.status_' . $order->getStatus()) }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if ($viewData['customUser']->getOrders()->count() > 5)
                                    <div class="text-center">
                                        <small
                                            class="text-muted">{{ __('admin.showing_orders', ['shown' => 5, 'total' => $viewData['customUser']->getOrders()->count()]) }}</small>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Reviews Section -->
                        @if ($viewData['customUser']->getReviews()->count() > 0)
                            <div class="mb-4">
                                <h5 class="mb-3">
                                    <i class="fas fa-star me-2"></i>{{ __('admin.recent_reviews') }}
                                    ({{ $viewData['customUser']->getReviews()->count() }})
                                </h5>
                                <div class="row">
                                    @foreach ($viewData['customUser']->getReviews()->take(3) as $review)
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center mb-2">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i
                                                                class="fas fa-star {{ $i <= $review->getRating() ? 'text-warning' : 'text-muted' }}"></i>
                                                        @endfor
                                                        <span class="ms-2 text-muted">{{ $review->getRating() }}/5</span>
                                                    </div>
                                                    <p class="card-text small">
                                                        {{ Str::limit($review->getComment(), 100) }}</p>
                                                    <small
                                                        class="text-muted">{{ date('M d, Y', strtotime($review->getCreatedAt())) }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if ($viewData['customUser']->getReviews()->count() > 3)
                                    <div class="text-center mt-3">
                                        <small
                                            class="text-muted">{{ __('admin.showing_reviews', ['shown' => 3, 'total' => $viewData['customUser']->getReviews()->count()]) }}</small>
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if (
                            $viewData['customUser']->getProducts()->count() == 0 &&
                                $viewData['customUser']->getOrders()->count() == 0 &&
                                $viewData['customUser']->getReviews()->count() == 0)
                            <div class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">{{ __('admin.no_activity_yet') }}</h5>
                                <p class="text-muted">{{ __('admin.no_activity_description') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
