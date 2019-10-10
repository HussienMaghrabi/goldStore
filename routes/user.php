<?php

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

Route::middleware('apiLocale')->namespace('Api\User')->group(function ()
{
    Route::post('login', 'AuthController@login');
    Route::post('login-verification', 'AuthController@login_verification');
    Route::post('signup', 'AuthController@register');
    Route::post('signup-verification', 'AuthController@register_verification');

    Route::middleware('api:apiUser')->group(function ()
    {

        Route::resource('bouquet', 'BouquetController');
        Route::resource('notification', 'NotificationController');
        Route::resource('message', 'MessageController');
        Route::get('messages', 'MessageController@message');
        Route::get('profile'        , 'UpdateController@index');
        Route::any('profile-update', 'UpdateController@update');
        Route::resource('favorites', 'FavoriteController');
        Route::resource('repost', 'RePostController');
        Route::resource('Pinned', 'PinnedController');


    });
});
