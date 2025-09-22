@extends('layouts.app')

@section('title', __('home.title'))

@section('content')
<div class="container mt-5 mb-5">
    
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="fw-bold">{{ __('home.welcome_title') }}</h1>
        <p class="fs-5 text-secondary">{{ __('home.welcome_subtitle') }}</p>
    </div>

    <!-- Main Features -->
    <div class="row justify-content-center">

        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow text-center p-4 border-0">
                <img src="{{ asset('images/account.png') }}" alt="{{ __('home.alt_accounts') }}" class="mx-auto" style="height: 90px;">
                <h4 class="fw-bold mt-3">{{ __('home.user_accounts_title') }}</h4>
                <p>{{ __('home.user_accounts_description') }}</p>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow text-center p-4 border-0">
                <img src="{{ asset('images/ratings.png') }}" alt="{{ __('home.alt_ratings') }}" class="mx-auto" style="height: 90px;">
                <h4 class="fw-bold mt-3">{{ __('home.user_ratings_title') }}</h4>
                <p>{{ __('home.user_ratings_description') }}</p>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow text-center p-4 border-0">
                <img src="{{ asset('images/search.png') }}" alt="{{ __('home.alt_search') }}" class="mx-auto" style="height: 80px;">
                <h4 class="fw-bold mt-3">{{ __('home.smart_search_title') }}</h4>
                <p>{{ __('home.smart_search_description') }}</p>
            </div>
        </div>
    </div>

    <!-- Final Message -->
    <div class="text-center mt-5">
        <h3 class="fw-bold">{{ __('home.final_message_title') }}</h3>
        <p class="fs-5 text-secondary">{{ __('home.final_message_subtitle') }}</p>
        <a href="{{ route('product.index') }}" class="btn btn-custom">{{ __('home.start_now_button') }}</a>
    </div>
</div>
@endsection
