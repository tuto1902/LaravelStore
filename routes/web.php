<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/products', 'ProductsController@index');
Route::get('/products/{id}', 'ProductsController@show');

Route::get('/cart', 'CartController@index');
Route::put('/cart/{product}', 'CartController@update');

Route::post('/orders', 'OrdersController@store');
Route::get('/orders/{order}', 'OrdersController@show');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
