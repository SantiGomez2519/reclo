@extends('layouts.app')

@section('title', 'My Profile - Reclo')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('product.my_profile') }}</h4>
                    <a href="{{ route('user.edit') }}" class="btn btn-sm bg-primary text-white">
                        {{ __('product.edit_profile') }}
                    </a>
                </div>

                <div class="card-body">
                    <!-- Información del usuario (existente) -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>{{ __('product.name') }}</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ $viewData['user']->getName() }}
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>{{ __('product.phone') }}</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ $viewData['user']->getPhone() }}
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>{{ __('product.email') }}</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ $viewData['user']->getEmail() }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>{{ __('product.payment_method') }}</strong>
                                </div>
                                <div class="col-md-8">
                                    <span class="badge bg-secondary">{{ $viewData['user']->getPaymentMethod() }}</span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>{{ __('product.member_since') }}</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ $viewData['user']->created_at->format('F j, Y') }}
                                </div>
                            </div>

                            <!-- Resumen de actividad -->
                            <div class="row mt-4">
                                <div class="col-md-6 text-center">
                                    <div class="border rounded p-2 bg-light">
                                        <h5 class="mb-1 text-primary">{{ $viewData['purchaseHistory']->count() }}</h5>
                                        <small class="text-muted">{{ __('Purchases') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-6 text-center">
                                    <a href="{{ route('user.sales-history') }}" class="text-decoration-none">
                                        <div class="border rounded p-2 bg-light">
                                            <h5 class="mb-1 text-success">{{ $viewData['purchaseHistory']->count() }}</h5>
                                            <small class="text-muted">{{ __('Sales') }}</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pestañas de historial -->
                    <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="purchases-tab" data-bs-toggle="tab" href="#purchases" role="tab">
                                <i class="fas fa-shopping-bag me-1"></i>{{ __('product.my_purchases') }}
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content mt-3" id="profileTabsContent">
                        <!-- FR17: Historial de Compras -->
                        <div class="tab-pane fade show active" id="purchases" role="tabpanel">
                            @forelse($viewData['purchaseHistory'] as $order)
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ __('product.order') }} #{{ $order->id }}</strong>
                                                <span class="ms-2 badge bg-secondary">{{ $order->order_date }}</span>
                                            </div>
                                            <div>
                                                <span class="badge bg-success me-2">${{ number_format($order->total_price, 0) }}</span>
                                                <span class="badge bg-info">{{ ucfirst($order->status) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="mb-3">{{ __('Products:') }}</h6>
                                        @foreach($order->products as $product)
                                            <div class="row align-items-center mb-3 border-bottom pb-3">
                                                <div class="col-md-2">
                                                    <img src="{{ $product->getImages()[0] ?? asset('storage/images/logo.png') }}" 
                                                         alt="{{ $product->title }}" 
                                                         class="img-fluid rounded" 
                                                         style="height: 60px; object-fit: cover;">
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="mb-1">{{ $product->title }}</h6>
                                                    <p class="text-muted mb-1 small">{{ __('product.seller') }}: {{ $product->seller->name }}</p>
                                                    <span class="badge bg-secondary me-1">{{ $product->category }}</span>
                                                    <span class="badge bg-info">{{ $product->condition }}</span>
                                                </div>
                                                <div class="col-md-2 text-center">
                                                    <strong>${{ number_format($product->price, 0) }}</strong>
                                                </div>
                                                <div class="col-md-2 text-center">
                                                    @if($product->review)
                                                        <div class="rating small">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <i class="fas fa-star {{ $i <= $product->review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                            @endfor
                                                        </div>
                                                    @else
                                                        <span class="badge bg-light text-dark">{{ __('Not rated') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">{{ __('product.no_purchases_yet') }}</h5>
                                    <p class="text-muted">{{ __('product.your_purchase_history') }}</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Activar pestañas de Bootstrap
    const triggerTabList = document.querySelectorAll('#profileTabs a')
    triggerTabList.forEach(triggerEl => {
        new bootstrap.Tab(triggerEl)
    })
</script>
@endsection