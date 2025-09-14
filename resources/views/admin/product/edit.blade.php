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
                        <form method="POST" action="{{ route('admin.products.update', $viewData['product']->getId()) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">{{ __('admin.product_title') }}</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title"
                                            value="{{ old('title', $viewData['product']->getTitle()) }}" required>
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
                                            <option value="Women"
                                                {{ old('category', $viewData['product']->getCategory()) == 'Women' ? 'selected' : '' }}>
                                                {{ __('admin.category_Women') }}</option>
                                            <option value="Men"
                                                {{ old('category', $viewData['product']->getCategory()) == 'Men' ? 'selected' : '' }}>
                                                {{ __('admin.category_Men') }}</option>
                                            <option value="Vintage"
                                                {{ old('category', $viewData['product']->getCategory()) == 'Vintage' ? 'selected' : '' }}>
                                                {{ __('admin.category_Vintage') }}</option>
                                            <option value="Accessories"
                                                {{ old('category', $viewData['product']->getCategory()) == 'Accessories' ? 'selected' : '' }}>
                                                {{ __('admin.category_Accessories') }}</option>
                                            <option value="Shoes"
                                                {{ old('category', $viewData['product']->getCategory()) == 'Shoes' ? 'selected' : '' }}>
                                                {{ __('admin.category_Shoes') }}</option>
                                            <option value="Bags"
                                                {{ old('category', $viewData['product']->getCategory()) == 'Bags' ? 'selected' : '' }}>
                                                {{ __('admin.category_Bags') }}</option>
                                            <option value="Jewelry"
                                                {{ old('category', $viewData['product']->getCategory()) == 'Jewelry' ? 'selected' : '' }}>
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
                                    rows="4" required>{{ old('description', $viewData['product']->getDescription()) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="color" class="form-label">{{ __('admin.product_color') }}</label>
                                        <input type="text" class="form-control @error('color') is-invalid @enderror"
                                            id="color" name="color"
                                            value="{{ old('color', $viewData['product']->getColor()) }}" required>
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
                                            <option value="XS"
                                                {{ old('size', $viewData['product']->getSize()) == 'XS' ? 'selected' : '' }}>
                                                XS</option>
                                            <option value="S"
                                                {{ old('size', $viewData['product']->getSize()) == 'S' ? 'selected' : '' }}>
                                                S</option>
                                            <option value="M"
                                                {{ old('size', $viewData['product']->getSize()) == 'M' ? 'selected' : '' }}>
                                                M</option>
                                            <option value="L"
                                                {{ old('size', $viewData['product']->getSize()) == 'L' ? 'selected' : '' }}>
                                                L</option>
                                            <option value="XL"
                                                {{ old('size', $viewData['product']->getSize()) == 'XL' ? 'selected' : '' }}>
                                                XL</option>
                                            <option value="XXL"
                                                {{ old('size', $viewData['product']->getSize()) == 'XXL' ? 'selected' : '' }}>
                                                XXL</option>
                                            <option value="One Size"
                                                {{ old('size', $viewData['product']->getSize()) == 'One Size' ? 'selected' : '' }}>
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
                                                {{ old('condition', $viewData['product']->getCondition()) == 'Like New' ? 'selected' : '' }}>
                                                {{ __('admin.condition_Like New') }}</option>
                                            <option value="Excellent"
                                                {{ old('condition', $viewData['product']->getCondition()) == 'Excellent' ? 'selected' : '' }}>
                                                {{ __('admin.condition_Excellent') }}</option>
                                            <option value="Very Good"
                                                {{ old('condition', $viewData['product']->getCondition()) == 'Very Good' ? 'selected' : '' }}>
                                                {{ __('admin.condition_Very Good') }}</option>
                                            <option value="Good"
                                                {{ old('condition', $viewData['product']->getCondition()) == 'Good' ? 'selected' : '' }}>
                                                {{ __('admin.condition_Good') }}</option>
                                            <option value="Fair"
                                                {{ old('condition', $viewData['product']->getCondition()) == 'Fair' ? 'selected' : '' }}>
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
                                            id="price" name="price"
                                            value="{{ old('price', $viewData['product']->getPrice()) }}" min="1"
                                            required>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">{{ __('admin.status') }}</label>
                                        <select class="form-select @error('status') is-invalid @enderror" id="status"
                                            name="status" required>
                                            <option value="">{{ __('admin.select_status') }}</option>
                                            <option value="available"
                                                {{ old('status', $viewData['product']->getStatus()) == 'available' ? 'selected' : '' }}>
                                                {{ __('admin.status_available') }}</option>
                                            <option value="sold"
                                                {{ old('status', $viewData['product']->getStatus()) == 'sold' ? 'selected' : '' }}>
                                                {{ __('admin.status_sold') }}</option>
                                            <option value="unavailable"
                                                {{ old('status', $viewData['product']->getStatus()) == 'unavailable' ? 'selected' : '' }}>
                                                {{ __('admin.status_unavailable') }}</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
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
                                                    {{ old('seller_id', $viewData['product']->getSellerId()) == $seller->getId() ? 'selected' : '' }}>
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

                                <!-- Current Images -->
                                @if (count($viewData['product']->getImages()) > 0)
                                    <div class="mb-3">
                                        <small class="text-muted">{{ __('admin.current_images') }}:</small>
                                        <div class="row mt-2">
                                            @foreach ($viewData['product']->getImages() as $imageUrl)
                                                <div class="col-md-3 mb-2">
                                                    <img src="{{ $imageUrl }}" alt="{{ __('admin.current_image') }}"
                                                        class="img-thumbnail current-image-preview"
                                                        onerror="this.src='{{ asset('images/default-product.jpg') }}'">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <input type="file" class="form-control @error('images') is-invalid @enderror"
                                    id="images" name="images[]" accept="image/*" multiple>
                                <div class="form-text">{{ __('admin.images_help') }}</div>
                                @error('images')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('images.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('admin.products.show', $viewData['product']->getId()) }}"
                                    class="btn btn-secondary">{{ __('admin.cancel') }}</a>
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
