<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', 'DashboardController@index');
Route::get('orders', 'OrderController@index');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
