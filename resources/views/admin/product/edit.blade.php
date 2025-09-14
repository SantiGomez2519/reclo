@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card admin-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-edit me-2"></i>{{ __('admin.edit_product') }}
                    </h4>
                    <a href="{{ route('admin.products.show', $viewData['product']->getId()) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>{{ __('admin.back_to_product') }}
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.products.update', $viewData['product']->getId()) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">{{ __('admin.product_title') }}</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title', $viewData['product']->getTitle()) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category" class="form-label">{{ __('admin.category') }}</label>
                                    <select class="form-select @error('category') is-invalid @enderror" 
                                            id="category" name="category" required>
                                        <option value="">{{ __('admin.select_category') }}</option>
                                        <option value="clothing" {{ old('category', $viewData['product']->getCategory()) == 'clothing' ? 'selected' : '' }}>{{ __('admin.category_clothing') }}</option>
                                        <option value="shoes" {{ old('category', $viewData['product']->getCategory()) == 'shoes' ? 'selected' : '' }}>{{ __('admin.category_shoes') }}</option>
                                        <option value="accessories" {{ old('category', $viewData['product']->getCategory()) == 'accessories' ? 'selected' : '' }}>{{ __('admin.category_accessories') }}</option>
                                        <option value="other" {{ old('category', $viewData['product']->getCategory()) == 'other' ? 'selected' : '' }}>{{ __('admin.category_other') }}</option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('admin.description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description', $viewData['product']->getDescription()) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="color" class="form-label">{{ __('admin.product_color') }}</label>
                                    <input type="text" class="form-control @error('color') is-invalid @enderror" 
                                           id="color" name="color" value="{{ old('color', $viewData['product']->getColor()) }}" required>
                                    @error('color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="size" class="form-label">{{ __('admin.product_size') }}</label>
                                    <input type="text" class="form-control @error('size') is-invalid @enderror" 
                                           id="size" name="size" value="{{ old('size', $viewData['product']->getSize()) }}" required>
                                    @error('size')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="condition" class="form-label">{{ __('admin.product_condition') }}</label>
                                    <select class="form-select @error('condition') is-invalid @enderror" 
                                            id="condition" name="condition" required>
                                        <option value="">{{ __('admin.select_condition') }}</option>
                                        <option value="new" {{ old('condition', $viewData['product']->getCondition()) == 'new' ? 'selected' : '' }}>{{ __('admin.condition_new') }}</option>
                                        <option value="like_new" {{ old('condition', $viewData['product']->getCondition()) == 'like_new' ? 'selected' : '' }}>{{ __('admin.condition_like_new') }}</option>
                                        <option value="good" {{ old('condition', $viewData['product']->getCondition()) == 'good' ? 'selected' : '' }}>{{ __('admin.condition_good') }}</option>
                                        <option value="fair" {{ old('condition', $viewData['product']->getCondition()) == 'fair' ? 'selected' : '' }}>{{ __('admin.condition_fair') }}</option>
                                        <option value="poor" {{ old('condition', $viewData['product']->getCondition()) == 'poor' ? 'selected' : '' }}>{{ __('admin.condition_poor') }}</option>
                                    </select>
                                    @error('condition')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="price" class="form-label">{{ __('admin.product_price') }}</label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                           id="price" name="price" value="{{ old('price', $viewData['product']->getPrice()) }}" min="1" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="status" class="form-label">{{ __('admin.status') }}</label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="">{{ __('admin.select_status') }}</option>
                                        <option value="available" {{ old('status', $viewData['product']->getStatus()) == 'available' ? 'selected' : '' }}>{{ __('admin.status_available') }}</option>
                                        <option value="sold" {{ old('status', $viewData['product']->getStatus()) == 'sold' ? 'selected' : '' }}>{{ __('admin.status_sold') }}</option>
                                        <option value="pending" {{ old('status', $viewData['product']->getStatus()) == 'pending' ? 'selected' : '' }}>{{ __('admin.status_pending') }}</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="seller_id" class="form-label">{{ __('admin.product_seller') }}</label>
                                    <select class="form-select @error('seller_id') is-invalid @enderror" 
                                            id="seller_id" name="seller_id" required>
                                        <option value="">{{ __('admin.select_seller') }}</option>
                                        @foreach($viewData['sellers'] as $seller)
                                            <option value="{{ $seller->getId() }}" {{ old('seller_id', $viewData['product']->getSellerId()) == $seller->getId() ? 'selected' : '' }}>
                                                {{ $seller->getName() }} ({{ $seller->getEmail() }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('seller_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">{{ __('admin.product_image') }}</label>
                            @if($viewData['product']->getImage())
                                <div class="mb-2">
                                    <small class="text-muted">{{ __('admin.current_image') }}:</small><br>
                                    <img src="{{ asset('storage/' . $viewData['product']->getImage()) }}" 
                                         alt="{{ __('admin.current_image') }}" class="img-thumbnail current-image-preview">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            <div class="form-text">{{ __('admin.image_upload_help') }}</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.products.show', $viewData['product']->getId()) }}" class="btn btn-secondary">{{ __('admin.cancel') }}</a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-1"></i>{{ __('admin.update_product') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
