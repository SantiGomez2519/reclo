@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">{{ $viewData['title'] }}</h2>
    <p class="text-muted mb-0">Your swap request was responded, {{ $viewData['responder'] }} wants to swap a poduct with you.</p>
    <hr class="mb-4">

    <div class="row">
        <!-- Desired Product -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header" style="background-color: #efe8e0ff; ">
                    <h5 class="mb-0 text-dark fw-bold">Solicited Product</h5>
                </div>
                @if($viewData['desiredItem']->getImages())
                    <img src="{{ asset('storage/' . $viewData['desiredItem']->getImages()) }}" 
                            class="card-img-top"
                            alt="{{ $viewData['desiredItem']->getTitle() }}">
                @endif
                <div class="card-body">
                    <h5 class="card-title fw-bold">{{ $viewData['desiredItem']->getTitle() }}</h5>
                    <p class="card-text">{{ $viewData['desiredItem']->getDescription() }}</p>
                    <div class="mb-3">
                        <span class="badge bg-light text-dark">{{ $viewData['desiredItem']->getCondition() }}</span>
                        @if($viewData['desiredItem']->getSize())
                            <span class="badge bg-light text-dark">Size: {{ $viewData['desiredItem']->getSize() }}</span>
                        @endif
                        @if($viewData['desiredItem']->getCategory())
                            <span class="badge bg-light text-dark">{{ $viewData['desiredItem']->getCategory() }}</span>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between align-items-center border-top pt-2">
                        <span class="text-muted small">Price:</span>
                        <span class="fw-bold h5 mb-0">${{ $viewData['desiredItem']->getPrice() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Offered Product -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header" style="background-color: #efe8e0ff; ">
                    <h5 class="mb-0 text-dark fw-bold">Counter offer</h5>
                </div>
                @if($viewData['offeredItem']->getImages())
                    <img src="{{ asset('storage/' . $viewData['offeredItem']->getImages()) }}" 
                            class="card-img-top"
                            alt="{{ $viewData['offeredItem']->getTitle() }}">
                @endif
                <div class="card-body">
                    <h5 class="card-title fw-bold">{{ $viewData['offeredItem']->getTitle() }}</h5>
                    <p class="card-text">{{ $viewData['offeredItem']->getDescription() }}</p>
                    <div class="mb-3">
                        <span class="badge bg-light text-dark">{{ $viewData['offeredItem']->getCondition() }}</span>
                        @if($viewData['offeredItem']->getSize())
                            <span class="badge bg-light text-dark">Size: {{ $viewData['offeredItem']->getSize() }}</span>
                        @endif
                        @if($viewData['offeredItem']->getCategory())
                            <span class="badge bg-light text-dark">{{ $viewData['offeredItem']->getCategory() }}</span>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between align-items-center border-top pt-2">
                        <span class="text-muted small">Price:</span>
                        <span class="fw-bold h5 mb-0">${{ $viewData['offeredItem']->getPrice() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Swap status -->
    <div class="mt-4">
        <p>Swap status: 
            @if($viewData['swapRequest']->getStatus() === 'Accepted')
                <span class="badge bg-success">Accepted</span>
            @elseif($viewData['swapRequest']->getStatus() === 'Rejected')
                <span class="badge bg-danger">Rejected</span>
            @else
                <span class="badge bg-warning">Pending</span>
            @endif
        </p>
    </div>

    <!-- Action buttons -->
    <div class="mt-4 text-center">
        <form method="POST" class="d-inline-block" action="{{ route('swap-request.close', ['id' => $viewData['swapRequest']->getId()]) }}">
            @csrf
            <input type="hidden" name="response" value="accepted">
            <button type="submit" class="btn btn-success">Accept</button>
        </form>
        <form method="POST" class="d-inline-block" action="{{ route('swap-request.close', ['id' => $viewData['swapRequest']->getId()]) }}">
            @csrf
            <input type="hidden" name="response" value="rejected">
            <button type="submit" class="btn btn-danger">Reject</button>
        </form>
    </div>
    
</div>
@endsection

