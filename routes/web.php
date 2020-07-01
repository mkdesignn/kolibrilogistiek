<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('orders/shipped', 'OrderController@shipped');
    Route::get('orders/purchased/list', 'OrderController@purchased')->name('purchased.list');

    Route::get('orders/purchased/{order_id}/lines', 'OrderController@purchasedLine')->name('purchased.line.list');
    Route::get('orders/purchased/{order_id}', 'OrderController@show')->name('purchased.show')->middleware('bindings');

    Route::get('orders/purchased', 'OrderController@create')->name('purchased.create');
    Route::post('orders/purchased', 'OrderController@StorePurchased')->name('purchased.store');

    Route::get('users/suppliers', 'UserController@getSuppliers');
    Route::get('users/customers', 'UserController@getCustomers');
    Route::get('products', 'ProductController@getIndex');
    Route::put('orders/purchased/{order_id}', 'OrderController@UpdatePurchased')->middleware('bindings')->name('purchased.update');
});


Auth::routes();

Route::get('/', function(){

    return redirect()->to('login');
});
