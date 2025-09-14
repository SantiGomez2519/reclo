@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">
                    <p>You are about to create a swap request for the following product: <strong>{{ $viewData["desiredItem"]->getTitle() }}</strong>.                           
                    </p>
                    @if($viewData["desiredItem"]->getImage())
                        <img src="{{ asset('storage/' .  $viewData["desiredItem"]->getImage()) }}" 
                            alt="{{ $viewData["desiredItem"]->getTitle() }}" width="200">
                    @else
                        <p>No hay imagen</p>
                    @endif

                    <div class="mt-3 text-center">
                        <form method="POST" action="{{ route('swap_request.store') }}" class="d-inline-block">
                            @csrf
                            <input type="hidden" name="desired_item_id" value="{{ $viewData['desiredItem']->getId() }}">
                            <button type="submit" class="btn btn-success">
                                Confirm swap request
                            </button>
                        </form>
                        <a href="{{ route('home.index') }}" class="btn btn-danger d-inline-block ms-2">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
