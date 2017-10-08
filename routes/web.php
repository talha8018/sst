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
	// Start Products Routes
	Route::get('/products','ProductController@show');
	Route::post('/insert-product','ProductController@insert');
	Route::post('/update-product','ProductController@update');
	Route::get('/delete-product/{id}','ProductController@delete');
	// End Products Routes


	// Start Stock Routes
	Route::get('/stock','StockController@show');
	Route::post('/update-stock','StockController@update');
	Route::post('/insert-stock','StockController@insert');
	Route::get('/delete-stock/{id}','StockController@delete');
	// End Stock Routes


	// Start Sale Routes
	Route::get('/sale','SaleController@show');
	Route::post('/insert-sale','SaleController@insert');
	Route::get('/search-sale','SaleController@search');

	// End Sale Routes


});



Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
