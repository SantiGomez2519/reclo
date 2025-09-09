<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home.index');
Route::get('/prueba', 'App\Http\Controllers\HomeController@prueba')->name('home.prueba');
