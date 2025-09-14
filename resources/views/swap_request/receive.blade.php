@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card mb-4">
                <div class="card-header">{{ $viewData['title'] }}</div>
                <div class="card-body">
                    <h5>Solicited product</h5>
                    <div class="d-flex align-items-center">
                        @if($viewData['desiredItem']->getImage())
                            <img src="{{ asset('storage/' . $viewData['desiredItem']->getImage()) }}" 
                                 alt="{{ $viewData['desiredItem']->getTitle() }}" 
                                 width="150" class="me-3">
                        @endif
                        <div>
                            <p><strong>{{ $viewData['desiredItem']->getTitle() }}</strong></p>
                            <p>Precio: ${{ $viewData['desiredItem']->getPrice() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('swap_request.respond', ['id' => $viewData['swapRequest']->getId()]) }}">
                @csrf

                <div class="card mb-4">
                    <div class="card-header">Select a product to swap</div>
                    <div class="card-body">
                        @if($viewData['initiatorProducts']->isEmpty())
                            <p>El usuario no tiene productos disponibles para intercambio.</p>
                        @else
                            <div class="row">
                                @foreach($viewData['initiatorProducts'] as $product)
                                    <div class="col-md-4 mb-3">
                                        <div class="card h-100">
                                            @if($product->getImage())
                                                <img src="{{ asset('storage/' . $product->getImage()) }}" 
                                                     class="card-img-top" 
                                                     alt="{{ $product->getTitle() }}">
                                            @endif
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $product->getTitle() }}</h5>
                                                <p>Precio: ${{ $product->getPrice() }}</p>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" 
                                                           name="offered_item_id" value="{{ $product->getId() }}">
                                                    <label class="form-check-label">Choose</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Confirmation message-->
                <div class="d-flex justify-content-between">
                    <button type="submit" name="response" value="reject" class="btn btn-danger">
                        Reject swap request
                    </button>
                    <button type="submit" name="response" value="accept" class="btn btn-success">
                        Accept swap request with selected product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
