<!-- Author: Pablo Cabrejos -->
@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card admin-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-users me-2"></i>{{ __('admin.customer_management') }}
                        </h4>
                        <a href="{{ route('admin.customusers.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>{{ __('admin.create_customer') }}
                        </a>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($viewData['customUsers']->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>{{ __('admin.id') }}</th>
                                            <th>{{ __('admin.name') }}</th>
                                            <th>{{ __('admin.email') }}</th>
                                            <th>{{ __('admin.phone') }}</th>
                                            <th>{{ __('admin.payment_method') }}</th>
                                            <th>{{ __('admin.products') }}</th>
                                            <th>{{ __('admin.customer_registered') }}</th>
                                            <th>{{ __('admin.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($viewData['customUsers'] as $user)
                                            <tr>
                                                <td>{{ $user->getId() }}</td>
                                                <td>{{ $user->getName() }}</td>
                                                <td>{{ $user->getEmail() }}</td>
                                                <td>{{ $user->getPhone() }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-info">{{ __('admin.payment_' . str_replace(' ', '_', strtolower($user->getPaymentMethod()))) }}</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-secondary">{{ $user->getProducts()->count() }}</span>
                                                </td>
                                                <td>{{ date('M d, Y', strtotime($user->getCreatedAt())) }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.customusers.show', $user->getId()) }}"
                                                            class="btn btn-sm btn-outline-primary"
                                                            title="{{ __('admin.view') }}">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.customusers.edit', $user->getId()) }}"
                                                            class="btn btn-sm btn-outline-warning"
                                                            title="{{ __('admin.edit') }}">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form method="POST"
                                                            action="{{ route('admin.customusers.destroy', $user->getId()) }}"
                                                            class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                title="{{ __('admin.delete') }}"
                                                                onclick="return confirm('{{ __('admin.delete_customer_confirmation', ['name' => $user->getName()]) }}')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">{{ __('admin.no_customers') }}</h5>
                                <p class="text-muted">{{ __('admin.start_by_creating', ['item' => 'cliente']) }}</p>
                                <a href="{{ route('admin.customusers.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i>{{ __('admin.create_customer') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
