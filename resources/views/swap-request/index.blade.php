<!-- Author: Isabella Camacho -->
@extends('layouts.app')

@section('content')
    <div class="container ">
        <div class="mb-4">
            <h2>{{ __('swap.my_swap_requests') }}</h2>
        </div>

        @if ($viewData['swapRequests']->count() > 0)
            @foreach ($viewData['swapRequests'] as $swapRequest)
                <div class="card shadow-sm mb-4">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Swap Request #{{ $swapRequest->getId() }}</span>
                            <div>
                                @if ($swapRequest->getStatus() === 'Accepted')
                                    <span class="badge bg-success fs-6">{{ __('swap.accepted') }}</span>
                                    <a href="{{ route('swap-request.show', ['id' => $swapRequest->getId()]) }}" 
                                    class="btn btn-swap">{{ __('swap.view_request')}}</a>
                                @elseif($swapRequest->getStatus() === 'Rejected')
                                    <span class="badge bg-danger fs-6">{{ __('swap.rejected') }}</span>
                                    <a href="{{ route('swap-request.show', ['id' => $swapRequest->getId()]) }}" 
                                    class="btn btn-swap">{{ __('swap.view_request')}}</a>
                                @elseif($swapRequest->getStatus() === 'Pending')
                                    <span class="badge bg-warning fs-6">{{ __('swap.pending') }}</span>
                                    <a href="{{ route('swap-request.receive', ['id' => $swapRequest->getId()]) }}" 
                                    class="btn btn-swap">{{ __('swap.view_request')}}</a>
                                @else
                                    <span class="badge bg-warning fs-6">{{ __('swap.counter_offered') }}</span>
                                    <a href="{{ route('swap-request.finalize', ['id' => $swapRequest->getId()]) }}" 
                                    class="btn btn-swap">{{ __('swap.view_request')}}</a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header border-0" style="background-color: #efe8e0ff; ">
                                        <h5 class="mb-0 text-dark">{{ __('swap.solicited_product') }}</h5>
                                    </div>
                                    <img src="{{ $swapRequest->getDesiredItem()->getImages()[0] ?? 'https://via.placeholder.com/250' }}"
                                        class="card-img-top img-limit" alt="{{ $swapRequest->getDesiredItem()->getTitle() }}">
                                    <div class="card-body">
                                        <h6 class="card-title fw-bold">{{ $swapRequest->getDesiredItem()->getTitle() }}</h6>
                                        <p class="card-text small">{{ $swapRequest->getDesiredItem()->getDescription() }}
                                        </p>
                                        <div class="mb-3">
                                            <span
                                                class="badge bg-light text-dark">{{ $swapRequest->getDesiredItem()->getCondition() }}</span>
                                            @if ($swapRequest->getDesiredItem()->getSize())
                                                <span class="badge bg-light text-dark">{{ __('swap.size') }}:
                                                    {{ $swapRequest->getDesiredItem()->getSize() }}</span>
                                            @endif
                                            @if ($swapRequest->getDesiredItem()->getCategory())
                                                <span
                                                    class="badge bg-light text-dark">{{ $swapRequest->getDesiredItem()->getCategory() }}</span>
                                            @endif
                                        </div>
                                        <p class="small text-muted mb-0">{{ __('product.sold_by') }}:
                                            {{ $swapRequest->getDesiredItem()->getSeller()->getName() }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                @if ($swapRequest->getOfferedItem())
                                    <div class="card h-100">
                                        <div div class="card-header border-0" style="background-color: #efe8e0ff; ">
                                            <h5 class="mb-0 text-dark">{{ __('swap.counter_offer') }}</h5>
                                        </div>
                                        <img src="{{ $swapRequest->getOfferedItem()->getImages()[0] ?? 'https://via.placeholder.com/250' }}"
                                            class="card-img-top img-limit" alt="{{ $swapRequest->getOfferedItem()->getTitle() }}">
                                        <div class="card-body">
                                            <h6 class="card-title fw-bold">{{ $swapRequest->getOfferedItem()->getTitle() }}
                                            </h6>
                                            <p class="card-text small">
                                                {{ $swapRequest->getOfferedItem()->getDescription() }}</p>
                                            <div class="mb-3">
                                                <span
                                                    class="badge bg-light text-dark">{{ $swapRequest->getOfferedItem()->getCondition() }}</span>
                                                @if ($swapRequest->getOfferedItem()->getSize())
                                                    <span class="badge bg-light text-dark">{{ __('swap.size') }}:
                                                        {{ $swapRequest->getOfferedItem()->getSize() }}</span>
                                                @endif
                                                @if ($swapRequest->getOfferedItem()->getCategory())
                                                    <span
                                                        class="badge bg-light text-dark">{{ $swapRequest->getOfferedItem()->getCategory() }}</span>
                                                @endif
                                            </div>
                                            <p class="small text-muted mb-0">{{ __('product.sold_by') }}:
                                                {{ $swapRequest->getOfferedItem()->getSeller()->getName() }}</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="card h-100">
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
                    </div>
                    <div class="card-footer bg-light text-muted small">
                        <span><strong>{{ __('home.last_updated') ?? 'Last updated' }}:</strong>
                            {{ $swapRequest->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            @endforeach
        @else
            <div class="alert alert-info">
                {{ __('swap.none') }}
            </div>
        @endif

        <div class="text-center my-4">
            <a href="{{ route('home.index') }}" class="btn btn-custom">{{ __('home.go_home') ?? 'Go to Home' }}</a>
        </div>
    </div>
@endsection
