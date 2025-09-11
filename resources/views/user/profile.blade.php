@extends('layouts.app')

@section('title', 'My Profile - Reclo')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('My Profile') }}</h4>
                    <a href="{{ route('user.edit') }}" class="btn btn-sm bg-primary text-white">
                        {{ __('Edit Profile') }}
                    </a>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>{{ __('Name:') }}</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $viewData['user']->getName() }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>{{ __('Phone:') }}</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $viewData['user']->getPhone() }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>{{ __('Email:') }}</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $viewData['user']->getEmail() }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>{{ __('Payment Method:') }}</strong>
                        </div>
                        <div class="col-md-8">
                            <span class="badge bg-secondary">{{ $viewData['user']->getPaymentMethod() }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>{{ __('Member since:') }}</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $viewData['user']->created_at->format('F j, Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
