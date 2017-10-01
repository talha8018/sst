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

Route::middleware(['auth'])->group(function () {
	Route::get('/products','ProductController@show');
	Route::post('/insert-product','ProductController@insert');
	Route::post('/insert-stock','StockController@insert');
	Route::post('/update-product','ProductController@update');
	Route::get('/delete-product/{id}','ProductController@delete');
	

});



Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
