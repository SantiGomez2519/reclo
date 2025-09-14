@extends('layouts.app')

@section('title', 'My Products - Reclo')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">My Products</h1>
                <p class="text-gray-600">Manage your listed items</p>
            </div>
            <a href="{{ route('product.create') }}"
                class="bg-blue-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-600 transition duration-200">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                Add New Product
            </a>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            @forelse($viewData['products'] as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                    <!-- Product Image -->
                    <div class="relative">
                        <img src="{{ asset('storage/' . $product->getImage()) }}" alt="{{ $product->getTitle() }}"
                            class="w-full h-64 object-cover">

                        <!-- Status Badge -->
                        <div class="absolute top-2 left-2">
                            @if ($product->getStatus() === 'available')
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">
                                    Available
                                </span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-medium px-2 py-1 rounded-full">
                                    Sold
                                </span>
                            @endif
                        </div>

                        <!-- Condition Badge -->
                        <div class="absolute top-2 right-2">
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">
                                {{ $product->getCondition() }}
                            </span>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-1 truncate">{{ $product->getTitle() }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $product->getCategory() }} • {{ $product->getSize() }}</p>

                        <!-- Price -->
                        <div class="flex items-center space-x-2 mb-3">
                            <span class="text-lg font-bold text-gray-800">${{ $product->getPrice() }}</span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-2">
                            <a href="{{ route('product.show', $product->getId()) }}"
                                class="block w-full text-center bg-gray-100 text-gray-800 py-2 rounded-lg hover:bg-gray-200 transition duration-200">
                                View Details
                            </a>

                            @if ($product->getStatus() === 'available')
                                <div class="grid grid-cols-2 gap-2">
                                    <a href="{{ route('product.edit', $product->getId()) }}"
                                        class="text-center bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-200 text-sm">
                                        Edit
                                    </a>
                                    <form action="{{ route('product.destroy', $product->getId()) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full bg-red-500 text-white py-2 rounded-lg hover:bg-red-600 transition duration-200 text-sm">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="text-center">
                                    <span class="text-sm text-gray-500">Product sold</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No products yet</h3>
                    <p class="text-gray-600 mb-4">Start selling by listing your first item!</p>
                    <a href="{{ route('product.create') }}"
                        class="inline-block bg-blue-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-600 transition duration-200">
                        List Your First Product
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($viewData['products']->hasPages())
            <div class="flex justify-center">
                {{ $viewData['products']->links() }}
            </div>
        @endif

        <!-- Statistics -->
        @if ($viewData['products']->count() > 0)
            <div class="mt-12 bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Your Statistics</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">
                            {{ $viewData['products']->where('status', 'available')->count() }}</div>
                        <div class="text-sm text-gray-600">Available Items</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">
                            {{ $viewData['products']->where('status', 'sold')->count() }}</div>
                        <div class="text-sm text-gray-600">Sold Items</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600">
                            {{ $viewData['products']->where('swap', true)->count() }}</div>
                        <div class="text-sm text-gray-600">Exchange Items</div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
