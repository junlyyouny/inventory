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

Route::get('/', function () {
    return view('home');
});

Route::match(['get', 'post'], 'stocks', 'StocksController@index');
Route::match(['get', 'post'], 'stocks/storage', 'StocksController@storage');
Route::get('stocks/destroy/{key}', 'StocksController@destroy');
Route::get('stocks/delete/{id}', 'StocksController@delete');
Route::get('stocks/store', 'StocksController@store');

Route::match(['get', 'post'], 'sales', 'SalesController@index');
Route::match(['get', 'post'], 'sales/delivering', 'SalesController@delivering');
Route::get('sales/delete/{id}', 'SalesController@delete');
Route::get('sales/destroy/{id}', 'SalesController@destroy');
Route::get('sales/store', 'SalesController@store');