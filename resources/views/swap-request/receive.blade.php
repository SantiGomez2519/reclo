<!-- Author: Isabella Camacho -->
@extends('layouts.app')

@section('content')
    <div class="container ">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <h2 class="mb-2">{{ __('swap.someone_wants_to_swap') }}</h2>
                <p class="text-muted mb-0">{{ __('swap.propose_intro', ['name' => $viewData['initiator']]) }}</p>
                <hr class="mb-4">

                <div class="container">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card shadow-sm mb-4">
                                <div class="card-header" style="background-color: #efe8e0ff; ">
                                    <h5 class="mb-0 text-dark fw-bold">{{ __('swap.solicited_product') }}</h5>
                                </div>
                                
                                <img src="{{ $viewData['desiredItem']->getImages()[0] ?? asset('storage/images/logo.png') }}"
                                    class="card-img-top img-limit" alt="{{ $viewData['desiredItem']->getTitle() }}">
                                
               
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">{{ $viewData['desiredItem']->getTitle() }}</h5>
                                    <p class="card-text">{{ $viewData['desiredItem']->getDescription() }}</p>
                                    <div class="mb-3">
                                        <span
                                            class="badge bg-light text-dark">{{ $viewData['desiredItem']->getCondition() }}</span>
                                        @if ($viewData['desiredItem']->getSize())
                                            <span class="badge bg-light text-dark">{{ __('swap.size') }}:
                                                {{ $viewData['desiredItem']->getSize() }}</span>
                                        @endif
                                        @if ($viewData['desiredItem']->getCategory())
                                            <span
                                                class="badge bg-ligth text-dark">{{ $viewData['desiredItem']->getCategory() }}</span>
                                        @endif
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center border-top pt-2">
                                        <span class="text-muted small">{{ __('swap.price') }}:</span>
                                        <span class="fw-bold h5 mb-0">${{ $viewData['desiredItem']->getPrice() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <form method="POST"
                                action="{{ route('swap-request.respond', ['id' => $viewData['swapRequest']->getId()]) }}">
                                @csrf
                                <div class="card shadow-sm mb-4">
                                    <div class="card-header" style="background-color: #efe8e0ff; ">
                                        <h5 class="mb-0 text-dark fw-bold">{{ __('swap.select_product_to_offer') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        @if ($viewData['initiatorProducts']->isEmpty())
                                            <div class="alert alert-warning">{{ __('swap.no_products_available') }}</div>
                                        @else
                                            <div style="max-height: 400px; overflow-y: auto; padding-right: 15px;">
                                                <div class="row gy-3">
                                                    @foreach ($viewData['initiatorProducts'] as $product)
                                                        <div class="col-12">
                                                            <div class="card h-100 selectable-card position-relative">
                                                                <input class="form-check-input" type="radio"
                                                                    name="offered_item_id" value="{{ $product->getId() }}"
                                                                    id="product_{{ $product->getId() }}"
                                                                    style="position: absolute; top: 10px; right: 10px; z-index: 10;">
                                                                <label class="card-body stretched-link mb-0"
                                                                    for="product_{{ $product->getId() }}"
                                                                    style="cursor: pointer;">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-md-4">
                                                                            <img src="{{ $product->getImages()[0] ?? asset('storage/images/logo.png') }}"
                                                                                class="card-img-top" alt="{{ $product->getTitle() }}">
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <h6 class="card-title fw-bold">
                                                                                {{ $product->getTitle() }}</h6>
                                                                            <p class="card-text small mb-2">
                                                                                {{ $product->getDescription() }}</p>
                                                                            <div class="mb-2">
                                                                                <span
                                                                                    class="badge bg-light text-dark">{{ $product->getCondition() }}</span>
                                                                                @if ($product->getSize())
                                                                                    <span
                                                                                        class="badge bg-light text-dark">{{ __('swap.size') }}:
                                                                                        {{ $product->getSize() }}</span>
                                                                                @endif
                                                                                @if ($product->getCategory())
                                                                                    <span
                                                                                        class="badge bg-light text-dark">{{ $product->getCategory() }}</span>
                                                                                @endif
                                                                            </div>
                                                                            <p class="card-text fw-bold mb-0">
                                                                                ${{ $product->getPrice() }}</p>
                                                                        </div>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger mb-3">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                {{ $error }}
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="d-flex justify-content-between">
                                    <button type="submit" name="response" value="reject" class="btn btn-danger px-4">
                                        {{ __('swap.reject_swap') }}
                                    </button>
                                    @if (!$viewData['initiatorProducts']->isEmpty())
                                        <button type="submit" name="response" value="accept" class="btn btn-success px-4">
                                            {{ __('swap.accept_with_selected') }}
                                        </button>
                                    @endif
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
