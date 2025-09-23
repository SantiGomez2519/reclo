<!-- Author: Sofia Flores -->
@extends('layouts.app')

@section('title', __('user.edit_profile') . ' - Reclo')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">{{ __('user.edit_profile') }}</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('user.full_name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $viewData['user']->getName()) }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('user.phone_number') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $viewData['user']->getPhone()) }}" required autocomplete="tel">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('user.email_address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $viewData['user']->getEmail()) }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="payment_method" class="col-md-4 col-form-label text-md-end">{{ __('user.payment_method') }}</label>

                            <div class="col-md-6">
                                <select id="payment_method" class="form-select @error('payment_method') is-invalid @enderror" name="payment_method" required>
                                    <option value="Credit Card" {{ old('payment_method', $viewData['user']->getPaymentMethod()) == 'Credit Card' ? 'selected' : '' }}>{{ __('user.credit_card') }}</option>
                                    <option value="Debit Card" {{ old('payment_method', $viewData['user']->getPaymentMethod()) == 'Debit Card' ? 'selected' : '' }}>{{ __('user.debit_card') }}</option>
                                    <option value="PayPal" {{ old('payment_method', $viewData['user']->getPaymentMethod()) == 'PayPal' ? 'selected' : '' }}>{{ __('user.paypal') }}</option>
                                    <option value="Bank Transfer" {{ old('payment_method', $viewData['user']->getPaymentMethod()) == 'Bank Transfer' ? 'selected' : '' }}>{{ __('user.bank_transfer') }}</option>
                                </select>

                                @error('payment_method')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn bg-primary text-white">
                                    {{ __('user.update_profile') }}
                                </button>
                                
                                <a href="{{ route('user.profile') }}" class="btn btn-outline-secondary ms-2">
                                    {{ __('user.cancel') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
