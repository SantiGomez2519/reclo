@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card admin-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('adminDashboard.dashboard') }}</h4>
                    <span class="badge admin-badge">{{ $viewData['admin']->getRole() }}</span>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="text-success">{{ __('adminDashboard.welcome_back') }}{{ $viewData['admin']->getName() }}!</h5>
                            <p class="text-muted">{{ __('adminDashboard.successfully_logged_in') }}</p>
                            
                            <div class="alert alert-info admin-alert" role="alert">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>{{ __('adminDashboard.system_status') }}</strong> {{ __('adminDashboard.dual_auth_active') }}
                                <ul class="mb-0 mt-2">
                                    <li>{{ __('adminDashboard.customer_auth') }} <span class="badge bg-success">{{ __('adminDashboard.active') }}</span> {{ __('adminDashboard.customuser_model') }}</li>
                                    <li>{{ __('adminDashboard.admin_auth') }} <span class="badge bg-success">{{ __('adminDashboard.active') }}</span> {{ __('adminDashboard.user_model') }}</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="card-title">{{ __('adminDashboard.quick_actions') }}</h6>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('home.index') }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-external-link-alt me-1"></i>{{ __('adminDashboard.view_customer_site') }}
                                        </a>
                                        <a href="#" class="btn btn-outline-secondary btn-sm" onclick="alert('{{ __('adminDashboard.feature_coming_soon') }}')">
                                            <i class="fas fa-users me-1"></i>{{ __('adminDashboard.manage_users') }}
                                        </a>
                                        <a href="#" class="btn btn-outline-secondary btn-sm" onclick="alert('{{ __('adminDashboard.feature_coming_soon') }}')">
                                            <i class="fas fa-cog me-1"></i>{{ __('adminDashboard.system_settings') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white admin-dashboard-card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-users"></i>
                                    </h5>
                                    <p class="card-text">{{ __('adminDashboard.customer_management') }}</p>
                                    <small>{{ __('adminDashboard.manage_customuser_accounts') }}</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-success text-white admin-dashboard-card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-shopping-cart"></i>
                                    </h5>
                                    <p class="card-text">{{ __('adminDashboard.orders_products') }}</p>
                                    <small>{{ __('adminDashboard.monitor_marketplace') }}</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-warning text-white admin-dashboard-card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-chart-bar"></i>
                                    </h5>
                                    <p class="card-text">{{ __('adminDashboard.analytics') }}</p>
                                    <small>{{ __('adminDashboard.view_system_reports') }}</small>
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
