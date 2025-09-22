<!-- Author: Isabella Camacho -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">{{ __('swap.swap_status') }}</h2>
        @if ($viewData['swapRequest']->getStatus() === 'Accepted')
            <p class="text-muted mb-0">{{ __('swap.was_accepted') }}</p>
        @elseif($viewData['swapRequest']->getStatus() === 'Rejected')
            <p class="text-muted mb-0">{{ __('swap.was_rejected') }}</p>
        @elseif($viewData['swapRequest']->getStatus() === 'Pending')
            <p class="text-muted mb-0">{{ __('swap.is_pending') }}</p>
        @elseif($viewData['swapRequest']->getStatus() === 'Counter Proposed')
            <p class="text-muted mb-0">{{ __('swap.is_counter_offered') }}</p>
        @endif
    
        <hr class="mb-4">

        <div class="row">
            <!-- Desired Product -->
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
                            <span class="badge bg-light text-dark">{{ $viewData['desiredItem']->getCondition() }}</span>
                            @if ($viewData['desiredItem']->getSize())
                                <span class="badge bg-light text-dark">{{ __('swap.size') }}:
                                    {{ $viewData['desiredItem']->getSize() }}</span>
                            @endif
                            @if ($viewData['desiredItem']->getCategory())
                                <span class="badge bg-light text-dark">{{ $viewData['desiredItem']->getCategory() }}</span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between align-items-center border-top pt-2">
                            <span class="text-muted small">{{ __('swap.price') }}:</span>
                            <span class="fw-bold h5 mb-0">${{ $viewData['desiredItem']->getPrice() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Offered Product -->
            <div class="col-md-6">
                @if ($viewData['offeredItem'])
                    <div class="card shadow-sm mb-4">
                        <div class="card-header" style="background-color: #efe8e0ff; ">
                            <h5 class="mb-0 text-dark fw-bold">{{ __('swap.counter_offer') }}</h5>
                        </div>
                        <img src="{{ $viewData['offeredItem']->getImages()[0] ?? asset('storage/images/logo.png') }}"
                            class="card-img-top img-limit" alt="{{ $viewData['offeredItem']->getTitle() }}">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $viewData['offeredItem']->getTitle() }}</h5>
                            <p class="card-text">{{ $viewData['offeredItem']->getDescription() }}</p>
                            <div class="mb-3">
                                <span class="badge bg-light text-dark">{{ $viewData['offeredItem']->getCondition() }}</span>
                                @if ($viewData['offeredItem']->getSize())
                                    <span class="badge bg-light text-dark">{{ __('swap.size') }}:
                                        {{ $viewData['offeredItem']->getSize() }}</span>
                                @endif
                                @if ($viewData['offeredItem']->getCategory())
                                    <span class="badge bg-light text-dark">{{ $viewData['offeredItem']->getCategory() }}</span>
                                @endif
                            </div>
                            <div class="d-flex justify-content-between align-items-center border-top pt-2">
                                <span class="text-muted small">{{ __('swap.price') }}:</span>
                                <span class="fw-bold h5 mb-0">${{ $viewData['offeredItem']->getPrice() }}</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card shadow-sm mb-4">
                        <div div class="card-header border-0" style="background-color: #efe8e0ff; ">
                            <h5 class="mb-0 text-dark">{{ __('swap.counter_offer') }}</h5>
                        </div>
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <div class="alert alert-warning mb-0">{{ __('swap.no_counter_offer') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Swap status -->
        <div class="mt-4">
            <p>{{ __('swap.swap_status') }}
                @if ($viewData['swapRequest']->getStatus() === 'Accepted')
                    <span class="badge bg-success">{{ __('swap.accepted') }}</span>
                @elseif($viewData['swapRequest']->getStatus() === 'Rejected')
                    <span class="badge bg-danger">{{ __('swap.rejected') }}</span>
                @else
                    <span class="badge bg-warning">{{ __('swap.pending') }}</span>
                @endif
            </p>
            <p class="text-muted">{{ __('swap.initiated_by') }} {{ $viewData['initiator'] }}</p>
            <p class="text-muted">{{ __('swap.requested_to') }} {{ $viewData['responder'] }}</p>
        </div>

        <div class="text-center my-4">
            <a href="{{ route('home.index') }}" class="btn btn-custom">{{ __('home.go_home') }}</a>
        </div>

    </div>
@endsection
