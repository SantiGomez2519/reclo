@extends('layouts.app')

@section('title', 'Edit Product - Reclo')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit Product</h1>
            <p class="text-gray-600">Update your product information</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('product.update', $viewData['product']->getId()) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Current Product Image -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Current Image
                    </label>
                    <div class="w-32 h-32 bg-gray-100 rounded-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $viewData['product']->getImage()) }}"
                            alt="{{ $viewData['product']->getTitle() }}" class="w-full h-full object-cover">
                    </div>
                </div>

                <!-- New Product Image -->
                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Update Image (optional)
                    </label>
                    <div
                        class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition duration-200">
                        <input type="file" id="image" name="image" accept="image/*" class="hidden">
                        <label for="image" class="cursor-pointer">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <p class="text-sm text-gray-600">Click to upload a new image</p>
                            <p class="text-xs text-gray-500 mt-1">PNG, JPG up to 2MB</p>
                        </label>
                    </div>
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Product Title -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Product Title *
                    </label>
                    <input type="text" id="title" name="title"
                        value="{{ old('title', $viewData['product']->getTitle()) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="e.g., Vintage Denim Jacket" required>
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description *
                    </label>
                    <textarea id="description" name="description" rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Describe your item in detail..." required>{{ old('description', $viewData['product']->getDescription()) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category and Condition -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                            Category *
                        </label>
                        <select id="category" name="category"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                            <option value="">Select a category</option>
                            @foreach ($viewData['categories'] as $category)
                                <option value="{{ $category }}"
                                    {{ old('category', $viewData['product']->getCategory()) == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">
                            Condition *
                        </label>
                        <select id="condition" name="condition"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                            <option value="">Select condition</option>
                            @foreach ($viewData['conditions'] as $condition)
                                <option value="{{ $condition }}"
                                    {{ old('condition', $viewData['product']->getCondition()) == $condition ? 'selected' : '' }}>
                                    {{ $condition }}
                                </option>
                            @endforeach
                        </select>
                        @error('condition')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Color, Size, and Price -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                            Color *
                        </label>
                        <input type="text" id="color" name="color"
                            value="{{ old('color', $viewData['product']->getColor()) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="e.g., Blue" required>
                        @error('color')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="size" class="block text-sm font-medium text-gray-700 mb-2">
                            Size *
                        </label>
                        <select id="size" name="size"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                            <option value="">Select size</option>
                            @foreach ($viewData['sizes'] as $size)
                                <option value="{{ $size }}"
                                    {{ old('size', $viewData['product']->getSize()) == $size ? 'selected' : '' }}>
                                    {{ $size }}
                                </option>
                            @endforeach
                        </select>
                        @error('size')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                            Price ($) *
                        </label>
                        <input type="number" id="price" name="price"
                            value="{{ old('price', $viewData['product']->getPrice()) }}" min="1"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="0" required>
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Swap Option -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="swap" value="1"
                            {{ old('swap', $viewData['product']->getSwap()) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">
                            This item is available for exchange
                        </span>
                    </label>
                </div>

                <!-- Submit Buttons -->
                <div class="flex space-x-4">
                    <button type="submit"
                        class="flex-1 bg-blue-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-600 transition duration-200">
                        Update Product
                    </button>
                    <a href="{{ route('product.show', $viewData['product']->getId()) }}"
                        class="flex-1 bg-gray-200 text-gray-800 py-3 px-6 rounded-lg font-semibold hover:bg-gray-300 transition duration-200 text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Image preview functionality
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.createElement('img');
                    preview.src = e.target.result;
                    preview.className = 'w-full h-64 object-cover rounded-lg';

                    const container = document.querySelector('.border-dashed');
                    container.innerHTML = '';
                    container.appendChild(preview);
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
