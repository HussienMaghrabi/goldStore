<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('apiLocale')->namespace('Api')->group(function () {



    Route::resource('home', 'HomeController');
    Route::resource('banner', 'BannerController');
    Route::resource('settings', 'SettingController');
    Route::resource('category', 'CategoryController');
    Route::resource('subcategories', 'SubCategoryController');
    Route::resource('complaints', 'ComplaintController');
    Route::resource('contacts', 'ContactController');
    Route::resource('products', 'ProductController');
    Route::resource('conversations', 'ConversationController');
    Route::resource('messages', 'MessageController');

    Route::middleware('api:apiUser')->group(function () {

        Route::post('product', 'ProductController@stores');

    });


});