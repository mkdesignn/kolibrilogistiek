<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', 'DashboardController@index')->name('dashboard');
Route::get('orders/shipped', 'OrderController@shipped');
Route::get('orders/purchased', 'OrderController@purchased')->name('purchased.list');
Route::post('orders/purchased', 'OrderController@StorePurchased')->name('purchased.store');

Route::get('orders/purchased/{order_id}/lines', 'OrderController@purchasedLine')->name('purchased.line.list');
Route::get('orders/purchased/{order_id}', 'OrderController@show')
    ->name('purchased.show')->middleware('bindings');

Route::get('users/suppliers', 'UserController@getSuppliers');
Route::get('products', 'ProductController@getIndex');
Route::put('orders/purchased/{order_id}', 'OrderController@UpdatePurchased')
    ->middleware('bindings')
    ->name('purchased.update');


Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
