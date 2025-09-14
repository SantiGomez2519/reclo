@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card admin-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('admin.dashboard') }}</h4>
                    <span class="badge admin-badge">{{ $viewData['admin']->getRole() }}</span>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="text-success">{{ __('admin.welcome_back') }}{{ $viewData['admin']->getName() }}!</h5>
                            <p class="text-muted">{{ __('admin.successfully_logged_in') }}</p>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="card-title">{{ __('admin.quick_actions') }}</h6>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('home.index') }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-external-link-alt me-1"></i>{{ __('admin.view_customer_site') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <!-- CRUD Management Sections -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card admin-crud-card mb-4">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">
                                        <i class="fas fa-users me-2"></i>{{ __('admin.customer_management') }}
                                    </h5>
                                    <span class="badge bg-light text-primary">{{ $viewData['customUsersCount'] ?? 0 }}</span>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">{{ __('admin.manage_customuser_accounts') }}</p>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.customusers.index') }}" class="btn btn-primary">
                                            <i class="fas fa-list me-1"></i>{{ __('admin.view_all_users') }}
                                        </a>
                                        <a href="{{ route('admin.customusers.create') }}" class="btn btn-outline-primary">
                                            <i class="fas fa-plus me-1"></i>{{ __('admin.create_new_user') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card admin-crud-card mb-4">
                                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">
                                        <i class="fas fa-shopping-cart me-2"></i>{{ __('admin.product_management') }}
                                    </h5>
                                    <span class="badge bg-light text-success">{{ $viewData['productsCount'] ?? 0 }}</span>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">{{ __('admin.manage_all_products') }}</p>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.products.index') }}" class="btn btn-success">
                                            <i class="fas fa-list me-1"></i>{{ __('admin.view_all_products') }}
                                        </a>
                                        <a href="{{ route('admin.products.create') }}" class="btn btn-outline-success">
                                            <i class="fas fa-plus me-1"></i>{{ __('admin.create_new_product') }}
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
