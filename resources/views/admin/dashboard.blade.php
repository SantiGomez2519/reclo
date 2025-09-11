@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card admin-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('Admin Dashboard') }}</h4>
                    <span class="badge admin-badge">{{ $viewData['admin']->getRole() }}</span>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="text-success">{{ __('Welcome back, ') }}{{ $viewData['admin']->getName() }}!</h5>
                            <p class="text-muted">{{ __('You are successfully logged in to the admin panel.') }}</p>
                            
                            <div class="alert alert-info admin-alert" role="alert">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>System Status:</strong> Dual authentication system is active.
                                <ul class="mb-0 mt-2">
                                    <li>Customer authentication: <span class="badge bg-success">Active</span> (CustomUser model)</li>
                                    <li>Admin authentication: <span class="badge bg-success">Active</span> (User model)</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Quick Actions</h6>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('home.index') }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-external-link-alt me-1"></i>View Customer Site
                                        </a>
                                        <a href="#" class="btn btn-outline-secondary btn-sm" onclick="alert('Feature coming soon!')">
                                            <i class="fas fa-users me-1"></i>Manage Users
                                        </a>
                                        <a href="#" class="btn btn-outline-secondary btn-sm" onclick="alert('Feature coming soon!')">
                                            <i class="fas fa-cog me-1"></i>System Settings
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
                                    <p class="card-text">Customer Management</p>
                                    <small>Manage CustomUser accounts</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-success text-white admin-dashboard-card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-shopping-cart"></i>
                                    </h5>
                                    <p class="card-text">Orders & Products</p>
                                    <small>Monitor marketplace activity</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-warning text-white admin-dashboard-card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-chart-bar"></i>
                                    </h5>
                                    <p class="card-text">Analytics</p>
                                    <small>View system reports</small>
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
