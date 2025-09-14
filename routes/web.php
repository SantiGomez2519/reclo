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

    // Product CRUD Routes
    Route::get('/admin/products', 'App\Http\Controllers\Admin\ProductController@index')->name('admin.products.index');
    Route::get('/admin/products/create', 'App\Http\Controllers\Admin\ProductController@create')->name('admin.products.create');
    Route::post('/admin/products', 'App\Http\Controllers\Admin\ProductController@store')->name('admin.products.store');
    Route::get('/admin/products/{id}', 'App\Http\Controllers\Admin\ProductController@show')->name('admin.products.show');
    Route::get('/admin/products/{id}/edit', 'App\Http\Controllers\Admin\ProductController@edit')->name('admin.products.edit');
    Route::put('/admin/products/{id}', 'App\Http\Controllers\Admin\ProductController@update')->name('admin.products.update');
    Route::delete('/admin/products/{id}', 'App\Http\Controllers\Admin\ProductController@destroy')->name('admin.products.destroy');

    // CustomUser CRUD Routes
    Route::get('/admin/customusers', 'App\Http\Controllers\Admin\CustomUserController@index')->name('admin.customusers.index');
    Route::get('/admin/customusers/create', 'App\Http\Controllers\Admin\CustomUserController@create')->name('admin.customusers.create');
    Route::post('/admin/customusers', 'App\Http\Controllers\Admin\CustomUserController@store')->name('admin.customusers.store');
    Route::get('/admin/customusers/{id}', 'App\Http\Controllers\Admin\CustomUserController@show')->name('admin.customusers.show');
    Route::get('/admin/customusers/{id}/edit', 'App\Http\Controllers\Admin\CustomUserController@edit')->name('admin.customusers.edit');
    Route::put('/admin/customusers/{id}', 'App\Http\Controllers\Admin\CustomUserController@update')->name('admin.customusers.update');
    Route::delete('/admin/customusers/{id}', 'App\Http\Controllers\Admin\CustomUserController@destroy')->name('admin.customusers.destroy');
});
