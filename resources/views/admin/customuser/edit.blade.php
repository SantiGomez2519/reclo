@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card admin-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-edit me-2"></i>{{ __('admin.edit_customer') }}
                    </h4>
                    <a href="{{ route('admin.customusers.show', $viewData['customUser']->getId()) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>{{ __('admin.back') }}
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.customusers.update', $viewData['customUser']->getId()) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">{{ __('admin.full_name') }}</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $viewData['customUser']->getName()) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">{{ __('admin.phone_number') }}</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', $viewData['customUser']->getPhone()) }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('admin.email_address') }}</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $viewData['customUser']->getEmail()) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">{{ __('admin.payment_method') }}</label>
                                    <select class="form-select @error('payment_method') is-invalid @enderror" 
                                            id="payment_method" name="payment_method" required>
                                        <option value="">{{ __('admin.select_payment_method') }}</option>
                                        <option value="credit_card" {{ old('payment_method', $viewData['customUser']->getPaymentMethod()) == 'credit_card' ? 'selected' : '' }}>{{ __('admin.payment_credit_card') }}</option>
                                        <option value="debit_card" {{ old('payment_method', $viewData['customUser']->getPaymentMethod()) == 'debit_card' ? 'selected' : '' }}>{{ __('admin.payment_debit_card') }}</option>
                                        <option value="paypal" {{ old('payment_method', $viewData['customUser']->getPaymentMethod()) == 'paypal' ? 'selected' : '' }}>{{ __('admin.payment_paypal') }}</option>
                                        <option value="bank_transfer" {{ old('payment_method', $viewData['customUser']->getPaymentMethod()) == 'bank_transfer' ? 'selected' : '' }}>{{ __('admin.payment_bank_transfer') }}</option>
                                    </select>
                                    @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                            <h5 class="mb-3">
                                <i class="fas fa-lock me-2"></i>{{ __('admin.password_update') }}
                                <small class="text-muted">({{ __('admin.optional') }})</small>
                            </h5>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>{{ __('admin.note') }}:</strong> {{ __('admin.leave_empty_keep_password') }}
                            </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">{{ __('admin.new_password') }}</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password">
                                    <div class="form-text">{{ __('admin.minimum_characters_if_changing') }}</div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">{{ __('admin.confirm_password') }}</label>
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                           id="password_confirmation" name="password_confirmation">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <strong class="text-muted">{{ __('admin.customer_id') }}:</strong>
                                    <p class="mb-1">{{ $viewData['customUser']->getId() }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <strong class="text-muted">{{ __('admin.member_since') }}:</strong>
                                    <p class="mb-1">{{ date('M d, Y H:i', strtotime($viewData['customUser']->getCreatedAt())) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.customusers.show', $viewData['customUser']->getId()) }}" class="btn btn-secondary">{{ __('admin.cancel') }}</a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-1"></i>{{ __('admin.update_customer') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
