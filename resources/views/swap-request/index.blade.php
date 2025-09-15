@extends('layouts.app')

@section('content')
<div class="container ">
    <div class="mb-4">
        <h2>{{ $viewData['title'] }}</h2>
    </div>

    @if($viewData['swapRequests']->count() > 0)
        @foreach($viewData['swapRequests'] as $swapRequest)
            <div class="card shadow-sm mb-4">
                <div class="card-header border-0" style="background-color: #b1cfa7ff; ">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Swap Request #{{ $swapRequest->getId() }}</span>
                        <div>
                            @if($swapRequest->getStatus() === 'Accepted')
                                <span class="badge bg-success fs-6">Accepted</span>
                            @elseif($swapRequest->getStatus() === 'Rejected')
                                <span class="badge bg-danger fs-6">Rejected</span>
                            @else
                                <span class="badge bg-warning fs-6">{{ ucfirst($swapRequest->getStatus()) }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header border-0" style="background-color: #efe8e0ff; ">
                                    <h5 class="mb-0 text-dark">Desired Product</h5>
                                </div>
                                <img src="{{ $swapRequest->getDesiredItem()->getImages()[0] ?? 'https://via.placeholder.com/250' }}" 
                                    class="card-img-top"
                                    alt="{{ $swapRequest->getDesiredItem()->getTitle() }}">
                                <div class="card-body">
                                    <h6 class="card-title fw-bold">{{ $swapRequest->getDesiredItem()->getTitle() }}</h6>
                                    <p class="card-text small">{{ $swapRequest->getDesiredItem()->getDescription() }}</p>
                                    <div class="mb-3">
                                        <span class="badge bg-light text-dark">{{ $swapRequest->getDesiredItem()->getCondition() }}</span>
                                        @if($swapRequest->getDesiredItem()->getSize())
                                            <span class="badge bg-light text-dark">Size: {{ $swapRequest->getDesiredItem()->getSize() }}</span>
                                        @endif
                                        @if($swapRequest->getDesiredItem()->getCategory())
                                            <span class="badge bg-light text-dark">{{ $swapRequest->getDesiredItem()->getCategory() }}</span>
                                        @endif
                                    </div>
                                    <p class="small text-muted mb-0">Owner: {{ $swapRequest->getDesiredItem()->getSeller()->getName() }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            @if($swapRequest->getOfferedItem())
                                <div class="card h-100">
                                    <div div class="card-header border-0" style="background-color: #efe8e0ff; ">
                                        <h5 class="mb-0 text-dark">Offered Product</h5>
                                    </div>
                                    <img src="{{ $swapRequest->getOfferedItem()->getImages()[0] ?? 'https://via.placeholder.com/250' }}" 
                                    class="card-img-top"
                                    alt="{{ $swapRequest->getOfferedItem()->getTitle() }}">
                                    <div class="card-body">
                                        <h6 class="card-title fw-bold">{{ $swapRequest->getOfferedItem()->getTitle() }}</h6>
                                        <p class="card-text small">{{ $swapRequest->getOfferedItem()->getDescription() }}</p>
                                        <div class="mb-3">
                                            <span class="badge bg-light text-dark">{{ $swapRequest->getOfferedItem()->getCondition() }}</span>
                                            @if($swapRequest->getOfferedItem()->getSize())
                                                <span class="badge bg-light text-dark">Size: {{ $swapRequest->getOfferedItem()->getSize() }}</span>
                                            @endif
                                            @if($swapRequest->getOfferedItem()->getCategory())
                                                <span class="badge bg-light text-dark">{{ $swapRequest->getOfferedItem()->getCategory() }}</span>
                                            @endif
                                        </div>
                                        <p class="small text-muted mb-0">Owner: {{ $swapRequest->getOfferedItem()->getSeller()->getName() }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="card h-100">
                                    <div div class="card-header border-0" style="background-color: #efe8e0ff; ">
                                        <h5 class="mb-0 text-dark">Offered Product</h5>
                                    </div>
                                    <div class="card-body d-flex align-items-center justify-content-center">
                                        <div class="alert alert-warning mb-0">No product offered.</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light text-muted small">
                    <span><strong>Last updated:</strong> {{ $swapRequest->updated_at->diffForHumans() }}</span>
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-info">
            You don't have any swap requests.
        </div>
    @endif
   
    <div class="text-center my-4">
        <a href="{{ route('home.index') }}" class="btn btn-custom">Go to Home</a>
    </div>
</div>
@endsection