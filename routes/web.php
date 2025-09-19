<?php

use Illuminate\Support\Facades\Route;

// Home Route
Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home.index');

// Language switching route
Route::get('/lang/{locale}', 'App\Http\Controllers\LanguageController@switch')->name('lang.switch');

// Customer Authentication Routes (CustomUser model)
Route::get('/login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login');
Route::post('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
Route::get('/register', 'App\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'App\Http\Controllers\Auth\RegisterController@register');

// Product Routes (public)
Route::get('/products', 'App\Http\Controllers\ProductController@index')->name('product.index');
Route::get('/products/search', 'App\Http\Controllers\ProductController@search')->name('product.search');

// Customer Protected Routes
Route::middleware('customer')->group(function () {
    Route::get('/customer/profile', 'App\Http\Controllers\CustomUserController@show')->name('user.profile');
    Route::get('/customer/profile/edit', 'App\Http\Controllers\CustomUserController@edit')->name('user.edit');
    Route::put('/customer/profile', 'App\Http\Controllers\CustomUserController@update')->name('user.update');

    // Product Management Routes - Specific routes first
    Route::get('/products/create', 'App\Http\Controllers\ProductController@create')->name('product.create');
    Route::post('/products', 'App\Http\Controllers\ProductController@store')->name('product.store');
    Route::get('/my-products', 'App\Http\Controllers\ProductController@myProducts')->name('product.my-products');

    // Product routes with parameters - must come after specific routes
    Route::get('/products/{id}', 'App\Http\Controllers\ProductController@show')->name('product.show');
    Route::get('/products/{id}/edit', 'App\Http\Controllers\ProductController@edit')->name('product.edit');
    Route::put('/products/{id}', 'App\Http\Controllers\ProductController@update')->name('product.update');
    Route::delete('/products/{id}', 'App\Http\Controllers\ProductController@destroy')->name('product.destroy');
    Route::patch('/products/{id}/mark-sold', 'App\Http\Controllers\ProductController@markAsSold')->name('product.mark-sold');

    // ----- Additional customer routes must be added here -----
});

// Admin Authentication Routes (User model)
Route::get('/admin/login', 'App\Http\Controllers\Admin\LoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login', 'App\Http\Controllers\Admin\LoginController@login');
Route::post('/admin/logout', 'App\Http\Controllers\Admin\LoginController@logout')->name('admin.logout');

// Admin Protected Routes
Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', 'App\Http\Controllers\Admin\DashboardController@index')->name('admin.dashboard');

    // ----- Additional admin routes must be added here -----
});
