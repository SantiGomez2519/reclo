@extends('layouts.app')

@section('title', __('user.my_profile') . ' - Reclo')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('user.my_profile') }}</h4>
                    <a href="{{ route('user.edit') }}" class="btn btn-sm bg-primary text-white">
                        {{ __('user.edit_profile') }}
                    </a>
                </div>

                <div class="card-body">
                    <!-- User Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>{{ __('user.name_label') }}</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ $viewData['user']->getName() }}
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>{{ __('user.phone_label') }}</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ $viewData['user']->getPhone() }}
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>{{ __('user.email_label') }}</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ $viewData['user']->getEmail() }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>{{ __('user.payment_method_label') }}</strong>
                                </div>
                                <div class="col-md-8">
                                    <span class="badge bg-secondary">{{ __('user.' . str_replace(' ', '_', strtolower($viewData['user']->getPaymentMethod()))) }}</span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>{{ __('user.member_since') }}</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ $viewData['user']->getCreatedAt()->translatedFormat('F j, Y') }}
                                </div>
                            </div>

                            <!-- Activity Summary -->
                            <div class="row mt-4">
                                <div class="col-md-6 text-center">
                                    <div class="border rounded p-2 bg-light">
                                        <h5 class="mb-1 text-success">{{ $viewData['salesHistory']->count() }}</h5>
                                        <small class="text-muted">{{ __('product.sales') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs for History -->
                    <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" id="sales-tab" data-bs-toggle="tab" href="#sales" role="tab">
                                <i class="fas fa-store me-1"></i>{{ __('product.my_sales') }}
                                <span class="badge bg-success ms-1">{{ $viewData['salesHistory']->count() }}</span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content mt-3" id="profileTabsContent">
                        <!-- Pestaña de información de perfil -->
                        <div class="tab-pane fade show active" id="profile" role="tabpanel">
                            <div class="alert alert-info mt-3">
                                <i class="fas fa-info-circle me-2"></i>
                                {{ __('user.profile_info_message') }}
                            </div>
                        </div>

                        <!-- Sales History Tab -->
                        <div class="tab-pane fade" id="sales" role="tabpanel">
                            @forelse($viewData['salesHistory'] as $product)
                                <div class="card mb-3 mt-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <img src="{{ $product->getImages()[0] ?? asset('storage/images/logo.png') }}" 
                                                     alt="{{ $product->title }}" 
                                                     class="img-fluid rounded" 
                                                     style="height: 120px; object-fit: cover; width: 100%;">
                                            </div>
                                            <div class="col-md-7">
                                                <h5 class="card-title">{{ $product->title }}</h5>
                                                <div class="row mb-2">
                                                    <div class="col-md-6">
                                                        <strong>{{ __('product.price') }}:</strong> ${{ number_format($product->price, 0) }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>{{ __('product.sold_on') }}:</strong> {{ $product->updated_at->format('M j, Y') }}
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-6">
                                                        <strong>{{ __('product.buyer') }}:</strong> {{ $product->order->buyer->name ?? __('Unknown') }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>{{ __('product.category') }}:</strong> 
                                                        <span class="badge bg-primary">{{ $product->category }}</span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong>{{ __('product.condition') }}:</strong> 
                                                        <span class="badge bg-info">{{ $product->condition }}</span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>{{ __('product.size') }}:</strong> 
                                                        <span class="badge bg-secondary">{{ $product->size }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-center">
                                                @if($product->review)
                                                    <div class="rating">
                                                        <h6>{{ __('product.rating') }}:</h6>
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="fas fa-star {{ $i <= $product->review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                        @endfor
                                                        <p class="text-muted small mt-2">"{{ Str::limit($product->review->comment, 50) }}"</p>
                                                    </div>
                                                @else
                                                    <div class="text-muted">
                                                        <i class="fas fa-comment-slash fa-2x mb-2"></i>
                                                        <p class="small">{{ __('product.no_rating_yet') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 mt-3">
                                    <i class="fas fa-store-slash fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">{{ __('product.no_sales_yet') }}</h5>
                                    <p class="text-muted">{{ __('product.your_sales_history_empty') }}</p>
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