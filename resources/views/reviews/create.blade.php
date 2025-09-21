@extends('layouts.app')

@section('content')
<div class="container">
     <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header border-0">
                    <h4 class="mb-0 text-light">
                        {{ __('review.review_for', ['product' => $viewData['product']->getTitle()]) }}
                    </h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5 text-center border-end">
                            <img src="{{ $viewData['product']->getImages()[0] ?? 'https://via.placeholder.com/250' }}"
                                 class="img-fluid rounded mb-3 img-limit" 
                                 alt="{{ $viewData['product']->getTitle() }}">
                            <h5>{{ $viewData['product']->getTitle() }}</h5>
                            <p class="text-muted">
                                {{ $viewData['product']->getDescription() ?? '' }}
                            </p>
                        </div>

                        <div class="col-md-7">
                            <form action="{{ route('reviews.store', ['product' => $viewData['product']]) }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">{{ __('review.rating') }}</label>
                                    <div class="star-rating">
                                        <input type="hidden" name="rating" id="rating" value="0">
                                        <span class="star" data-value="1">&#9733;</span>
                                        <span class="star" data-value="2">&#9733;</span>
                                        <span class="star" data-value="3">&#9733;</span>
                                        <span class="star" data-value="4">&#9733;</span>
                                        <span class="star" data-value="5">&#9733;</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="comment" class="form-label">{{ __('review.comment') }}</label>
                                    <textarea class="form-control" name="comment" id="comment" rows="4"
                                              placeholder="{{ __('review.comment_placeholder') }}"></textarea>
                                </div>

                                <input type="hidden" name="order_id" value="{{ request()->get('order_id') }}">

                                @if ($errors->any())
                                    <div class="alert alert-danger mb-3">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="mt-4 text-center">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('review.send_review') }}
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
     </div>
</div>

<script src="{{ asset('js/star-rating.js') }}"></script>
@endsection
