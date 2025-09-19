@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">{{ __('swap.swap_counter_offer') }}</h2>
        <p class="text-muted mb-0">{{ __('swap.responded_intro', ['name' => $viewData['responder']]) }}</p>
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
            </div>
        </div>

        <!-- Swap status -->
        <div class="mt-4">
            <p>{{ __('swap.swap_status') }}:
                @if ($viewData['swapRequest']->getStatus() === 'Accepted')
                    <span class="badge bg-success">{{ __('swap.accepted') }}</span>
                @elseif($viewData['swapRequest']->getStatus() === 'Rejected')
                    <span class="badge bg-danger">{{ __('swap.rejected') }}</span>
                @else
                    <span class="badge bg-warning">{{ __('swap.pending') }}</span>
                @endif
            </p>
        </div>

        <!-- Action buttons -->
        <div class="mt-4 text-center">
            <form method="POST" class="d-inline-block"
                action="{{ route('swap-request.close', ['id' => $viewData['swapRequest']->getId()]) }}">
                @csrf
                <input type="hidden" name="response" value="accepted">
                <button type="submit" class="btn btn-success">{{ __('swap.accept') }}</button>
            </form>
            <form method="POST" class="d-inline-block"
                action="{{ route('swap-request.close', ['id' => $viewData['swapRequest']->getId()]) }}">
                @csrf
                <input type="hidden" name="response" value="rejected">
                <button type="submit" class="btn btn-danger">{{ __('swap.reject') }}</button>
            </form>
        </div>

    </div>
@endsection
