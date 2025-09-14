@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="fw-bold">Welcome to Reclo</h1>
        <p class="fs-5 text-secondary">We bring you sustainable fashion, second-hand treasures, and circular economy in one place.</p>
    </div>

    <!-- Main Features -->
    <div class="row justify-content-center">

        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow text-center p-4 border-0">
                <img src="{{ asset('images/account.png') }}" alt="Accounts" class="mx-auto" style="height: 90px;">
                <h4 class="fw-bold mt-3">User Accounts</h4>
                <p>Register, publish products, and manage your personal profile with ease.</p>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow text-center p-4 border-0">
                <img src="{{ asset('images/ratings.png') }}" alt="Ratings" class="mx-auto" style="height: 90px;">
                <h4 class="fw-bold mt-3">User Ratings</h4>
                <p>Build trust with a reputation system for buyers, sellers, and exchangers.</p>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow text-center p-4 border-0">
                <img src="{{ asset('images/search.png') }}" alt="Search" class="mx-auto" style="height: 80px;">
                <h4 class="fw-bold mt-3">Smart Search</h4>
                <p>Filter items and use keywords to quickly find what matches your style.</p>
            </div>
        </div>
    </div>

    <!-- Final Message -->
    <div class="text-center mt-5">
        <h3 class="fw-bold"> Join the circular fashion revolution 🌱👔👗</h3>
        <p class="fs-5 text-secondary">Buy, sell, and exchange clothes — sustainable fashion starts with you.</p>
        <a href="#" class="btn btn-custom">Start Now</a>
    </div>
</div>
@endsection
