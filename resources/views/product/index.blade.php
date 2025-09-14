@extends('layouts.app')

@section('title', 'Products - Reclo')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Featured Finds</h1>
            <p class="text-lg text-gray-600 mb-8">Handpicked treasures from our community</p>
            @auth
                <a href="{{ route('product.create') }}"
                    class="inline-flex items-center px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                        </path>
                    </svg>
                    Sell Your Items
                </a>
            @endauth
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            @forelse($viewData['products'] as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                    <!-- Product Image -->
                    <div class="relative">
                        <img src="{{ asset('storage/' . $product->getImage()) }}" alt="{{ $product->getTitle() }}"
                            class="w-full h-64 object-cover">

                        <!-- Condition Badge -->
                        <div class="absolute top-2 left-2">
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">
                                {{ $product->getCondition() }}
                            </span>
                        </div>

                        <!-- Action Icons -->
                        <div class="absolute top-2 right-2 flex space-x-1">
                            @if ($product->getSwap())
                                <button class="bg-gray-800 bg-opacity-50 text-white p-1 rounded-full hover:bg-opacity-70">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                    </svg>
                                </button>
                            @endif
                            <button class="bg-gray-800 bg-opacity-50 text-white p-1 rounded-full hover:bg-opacity-70">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-1">{{ $product->getTitle() }}</h3>
                        <p class="text-sm text-gray-600 mb-2">by {{ $product->seller->getName() }}</p>

                        <!-- Price -->
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="text-lg font-bold text-gray-800">${{ $product->getPrice() }}</span>
                            <span class="text-sm text-gray-500 line-through">${{ $product->getPrice() * 2 }}</span>
                        </div>

                        <!-- Rating -->
                        <div class="flex items-center space-x-1">
                            <div class="flex">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                @endfor
                            </div>
                            <span class="text-sm text-gray-600">(4.9)</span>
                        </div>

                        <!-- View Product Button -->
                        <a href="{{ route('product.show', $product->getId()) }}"
                            class="block w-full mt-3 text-center bg-gray-100 text-gray-800 py-2 rounded-lg hover:bg-gray-200 transition duration-200">
                            View Details
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                    <p class="text-gray-600">Be the first to list a product!</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($viewData['products']->hasPages())
            <div class="flex justify-center">
                {{ $viewData['products']->links() }}
            </div>
        @endif
    </div>
@endsection
