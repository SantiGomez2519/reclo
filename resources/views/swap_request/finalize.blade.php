@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">{{ $viewData['title'] }}</h2>

    <div class="row">
        <!-- Desired Product -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Desired product
                </div>
                <div class="card-body text-center">
                    @if($viewData['desiredItem']->getImage())
                        <img src="{{ asset('storage/' . $viewData['desiredItem']->getImage()) }}" 
                             alt="{{ $viewData['desiredItem']->getTitle() }}" 
                             class="img-fluid mb-3" style="max-height:200px;">
                    @else
                        <p>No hay imagen</p>
                    @endif
                    <h5>{{ $viewData['desiredItem']->getTitle() }}</h5>
                    <p><strong>Precio:</strong> ${{ $viewData['desiredItem']->getPrice() }}</p>
                </div>
            </div>
        </div>

        <!-- Offered Product -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Offered product
                </div>
                <div class="card-body text-center">
                    @if($viewData['offeredItem']->getImage())
                        <img src="{{ asset('storage/' . $viewData['offeredItem']->getImage()) }}" 
                             alt="{{ $viewData['offeredItem']->getTitle() }}" 
                             class="img-fluid mb-3" style="max-height:200px;">
                    @else
                        <p>No hay imagen</p>
                    @endif
                    <h5>{{ $viewData['offeredItem']->getTitle() }}</h5>
                    <p><strong>Precio:</strong> ${{ $viewData['offeredItem']->getPrice() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Swap status -->
    <div class="mt-4">
        <p>Swap status: 
            @if($viewData['swapRequest']->getStatus() === 'accepted')
                <span class="badge bg-success">Accepted</span>
            @elseif($viewData['swapRequest']->getStatus() === 'rejected')
                <span class="badge bg-danger">Rejected</span>
            @else
                <span class="badge bg-secondary">Pending</span>
            @endif
        </p>
    </div>

    <!-- Action buttons -->
    
    <div class="mt-3 d-flex gap-2">
        <form method="POST" action="{{ route('swap_request.close', ['id' => $viewData['swapRequest']->getId()]) }}">
            @csrf
            <input type="hidden" name="response" value="accepted">
            <button type="submit" class="btn btn-success">Accept</button>
        </form>
        <form method="POST" action="{{ route('swap_request.close', ['id' => $viewData['swapRequest']->getId()]) }}">
            @csrf
            <input type="hidden" name="response" value="rejected">
            <button type="submit" class="btn btn-danger">Reject</button>
        </form>
    </div>
    
</div>
@endsection

