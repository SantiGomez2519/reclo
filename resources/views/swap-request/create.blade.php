@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">{{ $viewData['title'] }}</h2>
    <p class="text-muted mb-0">You are about to complete your swap request for the following product:</p>
    <hr class="mb-4">

    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <!-- Card principal -->
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header border-0" 
                    style="background-color: #efe8e0ff; ">
                    <h4 class="mb-0 text-dark">Product Information</h4>
                </div>
                <div class="card-body">

                    <!-- Producto -->
                    <h5 class="fw-bold">{{ $viewData['desiredItem']->getTitle() }}</h5>
                    <p class="text-muted">
                        {{ $viewData['desiredItem']->getDescription() ?? 'Producto en excelente estado, listo para intercambio.' }}
                    </p>
                    
                    <!-- Badges -->
                    <div class="mb-3">
                        <span class="badge bg-light text-dark">{{ $viewData['desiredItem']->getCondition() }}</span>
                        @if($viewData['desiredItem']->getSize())
                            <span class="badge bg-light text-dark">Size {{ $viewData['desiredItem']->getSize() }}</span>
                        @endif
                        @if($viewData['desiredItem']->getCategory())
                            <span class="badge bg-light text-dark">{{ $viewData['desiredItem']->getCategory() }}</span>
                        @endif
                    </div>

                    <!-- Precio alineado a la derecha -->
                    <div class="d-flex justify-content-between align-items-center border-top pt-3">
                        <span class="text-muted small">Price:</span>
                        <span class="fw-bold h5 mb-0">${{ $viewData['desiredItem']->getPrice() }}</span>
                    </div>

                    <!-- Info vendedor -->
                    <div class="d-flex align-items-center mt-4 border-top pt-3">
                        <i class="bi bi-person-circle fs-4 text-secondary me-3"></i>
                        <div>
                            <span class="fw-bold">Seller: {{ $viewData['desiredItem']->seller->getName() }}</span><br>
                            <small class="text-muted">Member since {{ \Carbon\Carbon::parse($viewData['desiredItem']->seller->getCreatedAt())->format('Y') }}</small>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="mt-4 text-center">
                        <form method="POST" action="{{ route('swap-request.store') }}" class="d-inline-block">
                            @csrf
                            <input type="hidden" name="desired_item_id" value="{{ $viewData['desiredItem']->getId() }}">
                            <button type="submit" class="btn btn-success px-4">
                                Confirm request
                            </button>
                        </form>
                        <a href="{{ route('home.index') }}" class="btn btn-danger px-4 ms-2">Cancell</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
