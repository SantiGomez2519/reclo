<?php

use Illuminate\Support\Facades\Route;

// Home Route
Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home.index');

// Customer Authentication Routes (CustomUser model)
Route::get('/login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login');
Route::post('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
Route::get('/register', 'App\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'App\Http\Controllers\Auth\RegisterController@register');

// Customer Protected Routes
Route::middleware('customer')->group(function () {
    Route::get('/customer/profile', 'App\Http\Controllers\CustomUserController@show')->name('user.profile');
    Route::get('/customer/profile/edit', 'App\Http\Controllers\CustomUserController@edit')->name('user.edit');
    Route::put('/customer/profile', 'App\Http\Controllers\CustomUserController@update')->name('user.update');

    // ----- Additional customer routes must be added here -----

    // ----- Swap Routes -----
    Route::post('/swap-request/create', 'App\Http\Controllers\SwapRequestController@create')->name('swap-request.create');
    Route::post('/swap-request/store', 'App\Http\Controllers\SwapRequestController@store')->name('swap-request.store');
    Route::get('/swap-request/{id}/receive', 'App\Http\Controllers\SwapRequestController@receive')->name('swap-request.receive');
    Route::post('/swap-request/{id}/respond', 'App\Http\Controllers\SwapRequestController@respond')->name('swap-request.respond');
    Route::get('/swap-request/{id}/finalize', 'App\Http\Controllers\SwapRequestController@finalize')->name('swap-request.finalize');
    Route::post('/swap-request/{id}/close', 'App\Http\Controllers\SwapRequestController@close')->name('swap-request.close');
    Route::get('/swap-request', 'App\Http\Controllers\SwapRequestController@index')->name('swap-request.index');
    Route::get('/swap-request/test', 'App\Http\Controllers\SwapRequestController@test')->name('swap-request.test'); // For testing purposes only

    // ----- Notifications Routes -----
    Route::get('/notifications', 'App\Http\Controllers\NotificationController@index')->name('notifications.index');
    Route::get('/notifications/{id}', 'App\Http\Controllers\NotificationController@read')->name('notifications.read');
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
