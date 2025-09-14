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
    Route::get('/test', function () {
        return view('swap_request.test');
    })->name('swap_request.test');
    Route::get('/customer/profile', 'App\Http\Controllers\CustomUserController@show')->name('user.profile');
    Route::get('/customer/profile/edit', 'App\Http\Controllers\CustomUserController@edit')->name('user.edit');
    Route::put('/customer/profile', 'App\Http\Controllers\CustomUserController@update')->name('user.update');

    // ----- Additional customer routes must be added here -----

    // ----- Swap Routes -----
    Route::post('/swap_request/create', 'App\Http\Controllers\SwapRequestController@create')->name('swap_request.create');
    Route::post('/swap_request/store', 'App\Http\Controllers\SwapRequestController@store')->name('swap_request.store');
    Route::get('/swap_request/{id}/receive', 'App\Http\Controllers\SwapRequestController@receive')->name('swap_request.receive');
    Route::post('/swap_request/{id}/respond', 'App\Http\Controllers\SwapRequestController@respond')->name('swap_request.respond');
    Route::get('/swap_request/{id}/finalize', 'App\Http\Controllers\SwapRequestController@finalize')->name('swap_request.finalize');
    Route::post('/swap_request/{id}/close', 'App\Http\Controllers\SwapRequestController@close')->name('swap_request.close');
    Route::get('/swap_request', 'App\Http\Controllers\SwapRequestController@index')->name('swap_request.index');

    // ----- Notifications Routes -----
    Route::get('/notifications', 'App\Http\Controllers\NotificationController@index')->name('notifications.index');
    Route::get('/notifications/{id}', 'App\Http\Controllers\NotificationController@read')->name('notifications.read');
    Route::post('/notifications/{id}/read', 'App\Http\Controllers\NotificationController@mark')->name('notifications.mark');
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
