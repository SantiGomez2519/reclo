@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card admin-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-plus me-2"></i>{{ __('admin.create_product') }}
                        </h4>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>{{ __('admin.back_to_list') }}
                        </a>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">{{ __('admin.product_title') }}</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" value="{{ old('title') }}" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">{{ __('admin.category') }}</label>
                                        <select class="form-select @error('category') is-invalid @enderror" id="category"
                                            name="category" required>
                                            <option value="">{{ __('admin.select_category') }}</option>
                                            <option value="Women" {{ old('category') == 'Women' ? 'selected' : '' }}>
                                                {{ __('admin.category_Women') }}</option>
                                            <option value="Men" {{ old('category') == 'Men' ? 'selected' : '' }}>
                                                {{ __('admin.category_Men') }}</option>
                                            <option value="Vintage" {{ old('category') == 'Vintage' ? 'selected' : '' }}>
                                                {{ __('admin.category_Vintage') }}</option>
                                            <option value="Accessories"
                                                {{ old('category') == 'Accessories' ? 'selected' : '' }}>
                                                {{ __('admin.category_Accessories') }}</option>
                                            <option value="Shoes" {{ old('category') == 'Shoes' ? 'selected' : '' }}>
                                                {{ __('admin.category_Shoes') }}</option>
                                            <option value="Bags" {{ old('category') == 'Bags' ? 'selected' : '' }}>
                                                {{ __('admin.category_Bags') }}</option>
                                            <option value="Jewelry" {{ old('category') == 'Jewelry' ? 'selected' : '' }}>
                                                {{ __('admin.category_Jewelry') }}</option>
                                        </select>
                                        @error('category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">{{ __('admin.description') }}</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="4" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="color" class="form-label">{{ __('admin.product_color') }}</label>
                                        <input type="text" class="form-control @error('color') is-invalid @enderror"
                                            id="color" name="color" value="{{ old('color') }}" required>
                                        @error('color')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="size" class="form-label">{{ __('admin.product_size') }}</label>
                                        <select class="form-select @error('size') is-invalid @enderror" id="size"
                                            name="size" required>
                                            <option value="">{{ __('admin.select_size') }}</option>
                                            <option value="XS" {{ old('size') == 'XS' ? 'selected' : '' }}>XS</option>
                                            <option value="S" {{ old('size') == 'S' ? 'selected' : '' }}>S</option>
                                            <option value="M" {{ old('size') == 'M' ? 'selected' : '' }}>M</option>
                                            <option value="L" {{ old('size') == 'L' ? 'selected' : '' }}>L</option>
                                            <option value="XL" {{ old('size') == 'XL' ? 'selected' : '' }}>XL</option>
                                            <option value="XXL" {{ old('size') == 'XXL' ? 'selected' : '' }}>XXL
                                            </option>
                                            <option value="One Size" {{ old('size') == 'One Size' ? 'selected' : '' }}>
                                                {{ __('admin.one_size') }}</option>
                                        </select>
                                        @error('size')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="condition"
                                            class="form-label">{{ __('admin.product_condition') }}</label>
                                        <select class="form-select @error('condition') is-invalid @enderror" id="condition"
                                            name="condition" required>
                                            <option value="">{{ __('admin.select_condition') }}</option>
                                            <option value="Like New"
                                                {{ old('condition') == 'Like New' ? 'selected' : '' }}>
                                                {{ __('admin.condition_Like New') }}</option>
                                            <option value="Excellent"
                                                {{ old('condition') == 'Excellent' ? 'selected' : '' }}>
                                                {{ __('admin.condition_Excellent') }}</option>
                                            <option value="Very Good"
                                                {{ old('condition') == 'Very Good' ? 'selected' : '' }}>
                                                {{ __('admin.condition_Very Good') }}</option>
                                            <option value="Good" {{ old('condition') == 'Good' ? 'selected' : '' }}>
                                                {{ __('admin.condition_Good') }}</option>
                                            <option value="Fair" {{ old('condition') == 'Fair' ? 'selected' : '' }}>
                                                {{ __('admin.condition_Fair') }}</option>
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
                                            id="price" name="price" value="{{ old('price') }}" min="1"
                                            required>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input @error('available') is-invalid @enderror"
                                            type="checkbox" id="available" name="available" value="1"
                                            {{ old('available', true) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="available">{{ __('admin.status_available') }}</label>
                                        @error('available')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="seller_id"
                                            class="form-label">{{ __('admin.product_seller') }}</label>
                                        <select class="form-select @error('seller_id') is-invalid @enderror"
                                            id="seller_id" name="seller_id" required>
                                            <option value="">{{ __('admin.select_seller') }}</option>
                                            @foreach ($viewData['sellers'] as $seller)
                                                <option value="{{ $seller->getId() }}"
                                                    {{ old('seller_id') == $seller->getId() ? 'selected' : '' }}>
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
                                <label for="images" class="form-label">{{ __('admin.product_images') }}</label>
                                <input type="file" class="form-control @error('images') is-invalid @enderror"
                                    id="images" name="images[]" accept="image/*" multiple required>
                                <div class="form-text">{{ __('admin.images_help') }}</div>
                                @error('images')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('images.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('admin.products.index') }}"
                                    class="btn btn-secondary">{{ __('admin.cancel') }}</a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i>{{ __('admin.create_product') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
