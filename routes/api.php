<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Product API Routes
Route::get('/products', 'App\Http\Controllers\Api\ProductApiController@index')->name('api.product.index');
Route::get('/products/paginate', 'App\Http\Controllers\Api\ProductApiController@paginate')->name('api.product.paginate');
Route::get('/products/{id}', 'App\Http\Controllers\Api\ProductApiController@show')->name('api.product.show');
