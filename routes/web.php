<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', 'DashboardController@index')->name('dashboard');
Route::get('orders/shipped', 'OrderController@shipped');
Route::get('orders/purchased', 'OrderController@purchased')->name('purchased.list');
Route::get('orders/purchased/{order_id}', 'OrderController@show')
    ->name('purchased.show')->middleware('bindings');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
