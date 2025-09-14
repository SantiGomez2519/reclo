@extends('layouts.app')

@section('title', __('product.edit_title'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header -->
                <div class="text-center mb-4">
                    <h1 class="display-5 fw-bold text-dark mb-2">{{ __('product.edit_title') }}</h1>
                    <p class="lead text-muted">{{ __('product.update_product_info') }}</p>
                </div>

                <!-- Form -->
                <div class="card shadow">
                    <div class="card-body p-4">
                        <form action="{{ route('product.update', $viewData['product']->getId()) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="current_image" value="{{ $viewData['product']->getFirstImage() }}">

                            <input type="hidden" name="storage_type" value="local">

                            <!-- Current Product Image -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    {{ __('product.current_image') }}
                                </label>
                                <div class="text-center">
                                    <img src="{{ asset($viewData['product']->getFirstImage()) }}"
                                        alt="{{ $viewData['product']->getTitle() }}" class="img-fluid rounded"
                                        style="max-height: 200px;">
                                </div>
                            </div>

                            <!-- New Product Image -->
                            <div class="mb-4">
                                <label for="image" class="form-label fw-semibold">
                                    {{ __('product.update_image_optional') }}
                                </label>
                                <input type="file" id="image" name="image" accept="image/*" class="form-control">
                                @error('image')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Product Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label fw-semibold">
                                    {{ __('product.product_title') }} *
                                </label>
                                <input type="text" id="title" name="title"
                                    value="{{ old('title', $viewData['product']->getTitle()) }}"
                                    class="form-control @error('title') is-invalid @enderror"
                                    placeholder="{{ __('product.title_placeholder') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label fw-semibold">
                                    {{ __('product.description') }} *
                                </label>
                                <textarea id="description" name="description" rows="4"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="{{ __('product.description_placeholder') }}" required>{{ old('description', $viewData['product']->getDescription()) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Category and Condition -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="category" class="form-label fw-semibold">
                                        {{ __('product.category') }} *
                                    </label>
                                    <select id="category" name="category"
                                        class="form-select @error('category') is-invalid @enderror" required>
                                        <option value="">{{ __('product.select_category') }}</option>
                                        <option value="Women"
                                            {{ old('category', $viewData['product']->getCategory()) == 'Women' ? 'selected' : '' }}>
                                            {{ __('product.women') }}</option>
                                        <option value="Men"
                                            {{ old('category', $viewData['product']->getCategory()) == 'Men' ? 'selected' : '' }}>
                                            {{ __('product.men') }}</option>
                                        <option value="Vintage"
                                            {{ old('category', $viewData['product']->getCategory()) == 'Vintage' ? 'selected' : '' }}>
                                            {{ __('product.vintage') }}</option>
                                        <option value="Accessories"
                                            {{ old('category', $viewData['product']->getCategory()) == 'Accessories' ? 'selected' : '' }}>
                                            {{ __('product.accessories') }}</option>
                                        <option value="Shoes"
                                            {{ old('category', $viewData['product']->getCategory()) == 'Shoes' ? 'selected' : '' }}>
                                            {{ __('product.shoes') }}</option>
                                        <option value="Bags"
                                            {{ old('category', $viewData['product']->getCategory()) == 'Bags' ? 'selected' : '' }}>
                                            {{ __('product.bags') }}</option>
                                        <option value="Jewelry"
                                            {{ old('category', $viewData['product']->getCategory()) == 'Jewelry' ? 'selected' : '' }}>
                                            {{ __('product.jewelry') }}</option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="condition" class="form-label fw-semibold">
                                        {{ __('product.condition') }} *
                                    </label>
                                    <select id="condition" name="condition"
                                        class="form-select @error('condition') is-invalid @enderror" required>
                                        <option value="">{{ __('product.select_condition') }}</option>
                                        <option value="Like New"
                                            {{ old('condition', $viewData['product']->getCondition()) == 'Like New' ? 'selected' : '' }}>
                                            {{ __('product.like_new') }}</option>
                                        <option value="Excellent"
                                            {{ old('condition', $viewData['product']->getCondition()) == 'Excellent' ? 'selected' : '' }}>
                                            {{ __('product.excellent') }}</option>
                                        <option value="Very Good"
                                            {{ old('condition', $viewData['product']->getCondition()) == 'Very Good' ? 'selected' : '' }}>
                                            {{ __('product.very_good') }}</option>
                                        <option value="Good"
                                            {{ old('condition', $viewData['product']->getCondition()) == 'Good' ? 'selected' : '' }}>
                                            {{ __('product.good') }}</option>
                                        <option value="Fair"
                                            {{ old('condition', $viewData['product']->getCondition()) == 'Fair' ? 'selected' : '' }}>
                                            {{ __('product.fair') }}</option>
                                    </select>
                                    @error('condition')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Color, Size, and Price -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="color" class="form-label fw-semibold">
                                        {{ __('product.color') }} *
                                    </label>
                                    <input type="text" id="color" name="color"
                                        value="{{ old('color', $viewData['product']->getColor()) }}"
                                        class="form-control @error('color') is-invalid @enderror"
                                        placeholder="{{ __('product.color_placeholder') }}" required>
                                    @error('color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="size" class="form-label fw-semibold">
                                        {{ __('product.size') }} *
                                    </label>
                                    <select id="size" name="size"
                                        class="form-select @error('size') is-invalid @enderror" required>
                                        <option value="">{{ __('product.select_size') }}</option>
                                        <option value="XS"
                                            {{ old('size', $viewData['product']->getSize()) == 'XS' ? 'selected' : '' }}>
                                            {{ __('product.xs') }}</option>
                                        <option value="S"
                                            {{ old('size', $viewData['product']->getSize()) == 'S' ? 'selected' : '' }}>
                                            {{ __('product.s') }}</option>
                                        <option value="M"
                                            {{ old('size', $viewData['product']->getSize()) == 'M' ? 'selected' : '' }}>
                                            {{ __('product.m') }}</option>
                                        <option value="L"
                                            {{ old('size', $viewData['product']->getSize()) == 'L' ? 'selected' : '' }}>
                                            {{ __('product.l') }}</option>
                                        <option value="XL"
                                            {{ old('size', $viewData['product']->getSize()) == 'XL' ? 'selected' : '' }}>
                                            {{ __('product.xl') }}</option>
                                        <option value="XXL"
                                            {{ old('size', $viewData['product']->getSize()) == 'XXL' ? 'selected' : '' }}>
                                            {{ __('product.xxl') }}</option>
                                        <option value="One Size"
                                            {{ old('size', $viewData['product']->getSize()) == 'One Size' ? 'selected' : '' }}>
                                            {{ __('product.one_size') }}</option>
                                    </select>
                                    @error('size')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="price" class="form-label fw-semibold">
                                        {{ __('product.price') }} *
                                    </label>
                                    <input type="number" id="price" name="price"
                                        value="{{ old('price', $viewData['product']->getPrice()) }}" min="1"
                                        class="form-control @error('price') is-invalid @enderror"
                                        placeholder="{{ __('product.price_placeholder') }}" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Swap Option -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input type="checkbox" name="swap" value="1" id="swap"
                                        {{ old('swap', $viewData['product']->getSwap()) ? 'checked' : '' }}
                                        class="form-check-input">
                                    <label for="swap" class="form-check-label">
                                        {{ __('product.available_for_exchange') }}
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('product.show', $viewData['product']->getId()) }}"
                                    class="btn btn-outline-secondary me-md-2">
                                    {{ __('product.cancel') }}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('product.update_product') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/product-image-preview.js') }}"></script>
@endsection
