@extends('layouts.app')

@section('title', $viewData['product']->getTitle() . ' - Reclo')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li><a href="{{ route('product.index') }}" class="hover:text-blue-500">Products</a></li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-800">{{ $viewData['product']->getTitle() }}</span>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Product Image -->
                <div class="space-y-4">
                    <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $viewData['product']->getImage()) }}"
                            alt="{{ $viewData['product']->getTitle() }}" class="w-full h-full object-cover">
                    </div>

                    <!-- Condition Badge -->
                    <div class="flex items-center space-x-2">
                        <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full">
                            {{ $viewData['product']->getCondition() }}
                        </span>
                        @if ($viewData['product']->getSwap())
                            <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                                Available for Exchange
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Product Details -->
                <div class="space-y-6">
                    <!-- Title and Seller -->
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $viewData['product']->getTitle() }}</h1>
                        <p class="text-lg text-gray-600">by {{ $viewData['product']->seller->getName() }}</p>
                    </div>

                    <!-- Price -->
                    <div class="flex items-center space-x-4">
                        <span class="text-3xl font-bold text-gray-800">${{ $viewData['product']->getPrice() }}</span>
                        <span class="text-lg text-gray-500 line-through">${{ $viewData['product']->getPrice() * 2 }}</span>
                    </div>

                    <!-- Rating -->
                    <div class="flex items-center space-x-2">
                        <div class="flex">
                            @for ($i = 1; $i <= 5; $i++)
                                <div class="w-5 h-5 bg-green-500 rounded-full"></div>
                            @endfor
                        </div>
                        <span class="text-gray-600">(4.9) • 23 reviews</span>
                    </div>

                    <!-- Description -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Description</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $viewData['product']->getDescription() }}</p>
                    </div>

                    <!-- Product Details -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-semibold text-gray-800">Category</h4>
                            <p class="text-gray-600">{{ $viewData['product']->getCategory() }}</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">Color</h4>
                            <p class="text-gray-600">{{ $viewData['product']->getColor() }}</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">Size</h4>
                            <p class="text-gray-600">{{ $viewData['product']->getSize() }}</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">Condition</h4>
                            <p class="text-gray-600">{{ $viewData['product']->getCondition() }}</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-4">
                        @auth
                            @if ($viewData['product']->getSellerId() === Auth::guard('web')->id())
                                <!-- Owner Actions -->
                                <div class="flex space-x-4">
                                    <a href="{{ route('product.edit', $viewData['product']->getId()) }}"
                                        class="flex-1 bg-blue-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-600 transition duration-200 text-center">
                                        Edit Product
                                    </a>
                                    <form action="{{ route('product.destroy', $viewData['product']->getId()) }}" method="POST"
                                        class="flex-1"
                                        onsubmit="return confirm('Are you sure you want to delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full bg-red-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-red-600 transition duration-200">
                                            Delete Product
                                        </button>
                                    </form>
                                </div>

                                @if ($viewData['product']->getStatus() === 'available')
                                    <form action="{{ route('product.mark-sold', $viewData['product']->getId()) }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="w-full bg-green-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-600 transition duration-200">
                                            Mark as Sold
                                        </button>
                                    </form>
                                @endif
                            @else
                                <!-- Buyer Actions -->
                                <div class="flex space-x-4">
                                    <button
                                        class="flex-1 bg-blue-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-600 transition duration-200">
                                        Add to Cart
                                    </button>
                                    @if ($viewData['product']->getSwap())
                                        <button
                                            class="flex-1 bg-green-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-600 transition duration-200">
                                            Propose Exchange
                                        </button>
                                    @endif
                                </div>
                                <button
                                    class="w-full bg-gray-200 text-gray-800 py-3 px-6 rounded-lg font-semibold hover:bg-gray-300 transition duration-200">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                        </path>
                                    </svg>
                                    Add to Favorites
                                </button>
                            @endif
                        @else
                            <div class="text-center">
                                <p class="text-gray-600 mb-4">Please log in to interact with this product</p>
                                <a href="{{ route('login') }}"
                                    class="inline-block bg-blue-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-600 transition duration-200">
                                    Log In
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Reviews</h2>
                <div class="bg-white rounded-lg shadow-md p-6">
                    @if ($viewData['product']->review)
                        <div class="space-y-4">
                            <div class="flex items-center space-x-2">
                                <div class="flex">
                                    @for ($i = 1; $i <= $viewData['product']->review->getRating(); $i++)
                                        <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                                    @endfor
                                </div>
                                <span class="text-gray-600">{{ $viewData['product']->review->getRating() }}/5</span>
                            </div>
                            <p class="text-gray-700">{{ $viewData['product']->review->getComment() }}</p>
                            <p class="text-sm text-gray-500">by {{ $viewData['product']->review->user->getName() }}</p>
                        </div>
                    @else
                        <p class="text-gray-600 text-center py-8">No reviews yet. Be the first to review this product!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
