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

// Customer Protected Routes
Route::middleware('customer')->group(function () {
    Route::get('/customer/profile', 'App\Http\Controllers\CustomUserController@show')->name('user.profile');
    Route::get('/customer/profile/edit', 'App\Http\Controllers\CustomUserController@edit')->name('user.edit');
    Route::put('/customer/profile', 'App\Http\Controllers\CustomUserController@update')->name('user.update');

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
