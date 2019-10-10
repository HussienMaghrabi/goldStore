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

Route::get('/store', function () {
    return redirect('/ar/store');
});

Route::get('store/signin', 'Vendor\LoginController@index')->name('vendor.login');
Route::post('store/signin', 'Vendor\LoginController@login')->name('vendor.login');

Route::prefix('{lang}/store')->namespace('Vendor')->name('vendor.')->middleware(['vendor:vendor', 'locale'])->group(function () {

    Route::get('update-profile' ,'ProfileController@index')->name('profile');
    Route::post('update-profile', 'ProfileController@update')->name('profile');


    Route::get('/', 'HomeController@index')->name('home');
    Route::post('logout', 'LoginController@logout')->name('logout');

    Route::delete('orders/multiDelete', 'OrderController@multiDelete')->name('orders.multiDelete');
    Route::any('orders/search', 'OrderController@search')->name('orders.search');
    Route::resource('orders', 'OrderController');

    Route::delete('products/multiDelete', 'ProductController@multiDelete')->name('products.multiDelete');
    Route::any('products/search', 'ProductController@search')->name('products.search');
    Route::get('products/ajax', 'ProductController@ajax')->name('products.ajax');
    Route::resource('products', 'ProductController');


    Route::prefix('{product}')->group(function ()
    {
        Route::delete('productImages/multiDelete', 'ProductImageController@multiDelete')->name('productImages.multiDelete');
        Route::resource('productImages', 'ProductImageController');
    });












});
