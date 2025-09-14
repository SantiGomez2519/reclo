@extends('layouts.app')

@section('title', __('user.my_profile') . ' - Reclo')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('user.my_profile') }}</h4>
                    <a href="{{ route('user.edit') }}" class="btn btn-sm bg-primary text-white">
                        {{ __('user.edit_profile') }}
                    </a>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>{{ __('user.name_label') }}</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $viewData['user']->getName() }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>{{ __('user.phone_label') }}</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $viewData['user']->getPhone() }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>{{ __('user.email_label') }}</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $viewData['user']->getEmail() }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>{{ __('user.payment_method_label') }}</strong>
                        </div>
                        <div class="col-md-8">
                            <span class="badge bg-secondary">{{ __('user.' . str_replace(' ', '_', strtolower($viewData['user']->getPaymentMethod()))) }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>{{ __('user.member_since') }}</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $viewData['user']->getCreatedAt()->translatedFormat('F j, Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
