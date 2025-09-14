@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card admin-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-shopping-cart me-2"></i>{{ __('admin.product_management') }}
                    </h4>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-success">
                        <i class="fas fa-plus me-1"></i>{{ __('admin.create_product') }}
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($viewData['products']->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>{{ __('admin.id') }}</th>
                                        <th>{{ __('admin.image') }}</th>
                                        <th>{{ __('admin.product_title') }}</th>
                                        <th>{{ __('admin.category') }}</th>
                                        <th>{{ __('admin.price') }}</th>
                                        <th>{{ __('admin.status') }}</th>
                                        <th>{{ __('admin.product_seller') }}</th>
                                        <th>{{ __('admin.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($viewData['products'] as $product)
                                        <tr>
                                            <td>{{ $product->getId() }}</td>
                                            <td>
                                                @if($product->getImage())
                                                    <div class="product-thumbnail">
                                                        <img src="{{ asset('storage/' . $product->getImage()) }}" 
                                                             alt="{{ $product->getTitle() }}" 
                                                             class="product-thumbnail-img">
                                                    </div>
                                                @else
                                                    <div class="no-image-placeholder" 
                                                         class="no-image-placeholder">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ $product->getTitle() }}</td>
                                            <td>{{ __('admin.category_' . $product->getCategory()) }}</td>
                                            <td>${{ number_format($product->getPrice()) }}</td>
                                            <td>
                                                <span class="badge {{ $product->getStatus() === 'available' ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ __('admin.status_' . $product->getStatus()) }}
                                                </span>
                                            </td>
                                            <td>{{ $product->seller->getName() }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.products.show', $product->getId()) }}" 
                                                       class="btn btn-sm btn-outline-primary" title="{{ __('admin.view') }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.products.edit', $product->getId()) }}" 
                                                       class="btn btn-sm btn-outline-warning" title="{{ __('admin.edit') }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                     <form method="POST" action="{{ route('admin.products.destroy', $product->getId()) }}" class="d-inline">
                                                         @csrf
                                                         @method('DELETE')
                                                         <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                                 title="{{ __('admin.delete') }}"
                                                                 onclick="return confirm('{{ __('admin.delete_confirmation', ['item' => __('admin.product')]) }}')">
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

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $viewData['products']->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">{{ __('admin.no_products') }}</h5>
                            <p class="text-muted">{{ __('admin.start_by_creating', ['item' => 'producto']) }}</p>
                            <a href="{{ route('admin.products.create') }}" class="btn btn-success">
                                <i class="fas fa-plus me-1"></i>{{ __('admin.create_product') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
