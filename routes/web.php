<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', 'DashboardController@index');
Route::get('orders/shipped', 'OrderController@shipped');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
