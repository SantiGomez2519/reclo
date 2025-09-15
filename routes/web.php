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
Route::get('/admin/login', 'App\Http\Controllers\Admin\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login', 'App\Http\Controllers\Admin\AdminLoginController@login');
Route::post('/admin/logout', 'App\Http\Controllers\Admin\AdminLoginController@logout')->name('admin.logout');

// Admin Protected Routes
Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', 'App\Http\Controllers\Admin\AdminDashboardController@index')->name('admin.dashboard');

    // Product CRUD Routes
    Route::get('/admin/products', 'App\Http\Controllers\Admin\AdminProductController@index')->name('admin.products.index');
    Route::get('/admin/products/create', 'App\Http\Controllers\Admin\AdminProductController@create')->name('admin.products.create');
    Route::post('/admin/products', 'App\Http\Controllers\Admin\AdminProductController@store')->name('admin.products.store');
    Route::get('/admin/products/{id}', 'App\Http\Controllers\Admin\AdminProductController@show')->name('admin.products.show');
    Route::get('/admin/products/{id}/edit', 'App\Http\Controllers\Admin\AdminProductController@edit')->name('admin.products.edit');
    Route::put('/admin/products/{id}', 'App\Http\Controllers\Admin\AdminProductController@update')->name('admin.products.update');
    Route::delete('/admin/products/{id}', 'App\Http\Controllers\Admin\AdminProductController@destroy')->name('admin.products.destroy');

    // CustomUser CRUD Routes
    Route::get('/admin/customusers', 'App\Http\Controllers\Admin\AdminCustomUserController@index')->name('admin.customusers.index');
    Route::get('/admin/customusers/create', 'App\Http\Controllers\Admin\AdminCustomUserController@create')->name('admin.customusers.create');
    Route::post('/admin/customusers', 'App\Http\Controllers\Admin\AdminCustomUserController@store')->name('admin.customusers.store');
    Route::get('/admin/customusers/{id}', 'App\Http\Controllers\Admin\AdminCustomUserController@show')->name('admin.customusers.show');
    Route::get('/admin/customusers/{id}/edit', 'App\Http\Controllers\Admin\AdminCustomUserController@edit')->name('admin.customusers.edit');
    Route::put('/admin/customusers/{id}', 'App\Http\Controllers\Admin\AdminCustomUserController@update')->name('admin.customusers.update');
    Route::delete('/admin/customusers/{id}', 'App\Http\Controllers\Admin\AdminCustomUserController@destroy')->name('admin.customusers.destroy');
});
