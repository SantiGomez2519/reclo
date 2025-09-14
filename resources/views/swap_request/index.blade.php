@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">{{ $viewData['title'] }}</h2>

    @if($viewData['swapRequests']->count() > 0)
    <div class="list-group">
            @foreach($viewData['swapRequests'] as $swapRequest)

            <div class="card ">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Swap #{{ $swapRequest->getId() }}</span>
                    <span>
                        @if($swapRequest->getStatus() === 'Accepted')
                            <span class="badge bg-success fs-6">Accepted</span>
                        @elseif($swapRequest->getStatus() === 'Rejected')
                            <span class="badge bg-danger fs-6">Rejected</span>
                        @else
                            <span class="badge bg-warning fs-6">{{ ucfirst($swapRequest->getStatus()) }}</span>
                        @endif
                    </span>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <h5 class="mb-3">DesiredProduct</h5>
                            <div class="card h-100 shadow-sm">
                                <img src="{{ $swapRequest->getDesiredItem()->getImage() ?? 'https://via.placeholder.com/250' }}" 
                                    class="card-img-top img-fluid" 
                                    alt="{{ $swapRequest->getDesiredItem()->getTitle() }}">
                                <div class="card-body">
                                    <h6>{{ $swapRequest->getDesiredItem()->getTitle() }}</h6>
                                    <p>{{ $swapRequest->getDesiredItem()->getDescription() }}</p>
                                    <p><strong>Dueño:</strong> {{ $swapRequest->getDesiredItem()->getSeller()->getName() }}</p>
                                </div>
                            </div>
                        </div>

                        @if($swapRequest->getOfferedItem())
                        <div class="col-md-6 text-center">
                            <h5 class="mb-3">Offered Product</h5>
                            <div class="card h-100 shadow-sm">
                                <img src="{{ $swapRequest->getOfferedItem()->getImage() ?? 'https://via.placeholder.com/250' }}" 
                                    class="card-img-top img-fluid" 
                                    alt="{{ $swapRequest->getOfferedItem()->getTitle() }}">
                                <div class="card-body">
                                    <h6>{{ $swapRequest->getOfferedItem()->getTitle() }}</h6>
                                    <p>{{ $swapRequest->getOfferedItem()->getDescription() }}</p>
                                    <p><strong>Dueño:</strong> {{ $swapRequest->getOfferedItem()->getSeller()->getName() }}</p>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="col-md-6 text-center">
                            <h5 class="mb-3">Offered Product</h5>
                            <div class="alert alert-warning">
                                No product offered yet.
                            </div>      
                        </div>
                        @endif

                    <p><strong>Created at:</strong> {{ $swapRequest->getCreatedAt() }}</p>
                    <p><strong>Last update:</strong> {{ $swapRequest->updated_at->diffForHumans() }}</p>
                </div>
            </div>
            @endforeach
    </div>
    @else
        <div class="alert alert-info">
            You don't have any swaps.
        </div>
    @endif
   

    <div class="mt-4">
        <a href="{{ route('home.index') }}" class="btn btn-primary">Go to home</a>
    </div>
</div>
@endsection
