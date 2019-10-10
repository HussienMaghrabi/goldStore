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

Route::get('/admin', function () {
    return redirect('/ar/dashboard');
});

Route::get('admin/signin', 'Dashboard\LoginController@index')->name('admin.login');
Route::post('admin/signin', 'Dashboard\LoginController@login')->name('admin.login');

Route::prefix('{lang}/dashboard')->namespace('Dashboard')->name('admin.')->middleware(['admin:admin', 'locale'])->group(function () {

    Route::get('/', 'HomeController@index')->name('home');
    Route::post('logout', 'LoginController@logout')->name('logout');

    Route::delete('admins/multiDelete', 'AdminController@multiDelete')->name('admins.multiDelete');
    Route::any('admins/search', 'AdminController@search')->name('admins.search');
    Route::resource('admins', 'AdminController');

    Route::delete('banners/multiDelete', 'BannerController@multiDelete')->name('banners.multiDelete');
    Route::resource('banners', 'BannerController');

    Route::delete('contacts/multiDelete', 'ContactController@multiDelete')->name('contacts.multiDelete');
    Route::any('contacts/search', 'ContactController@search')->name('contacts.search');
    Route::resource('contacts', 'ContactController');


    Route::delete('complaints/multiDelete', 'ComplaintController@multiDelete')->name('complaints.multiDelete');
    Route::any('complaints/search', 'ComplaintController@search')->name('complaints.search');
    Route::resource('complaints', 'ComplaintController');

    Route::delete('categories/multiDelete', 'CategoryController@multiDelete')->name('categories.multiDelete');
    Route::any('categories/search', 'CategoryController@search')->name('categories.search');
    Route::resource('categories', 'CategoryController');

    Route::resource('notifications', 'NotificationController');

    Route::delete('product/multiDelete', 'ProductController@multiDelete')->name('product.multiDelete');
    Route::any('product/search', 'ProductController@search')->name('product.search');
    Route::resource('product', 'ProductController');


    Route::prefix('{product}')->group(function ()
    {
        Route::delete('productImages/multiDelete', 'ProductImageController@multiDelete')->name('productImages.multiDelete');
        Route::resource('productImages', 'ProductImageController');
    });

    Route::delete('requestProducts/multiDelete', 'RequestProductController@multiDelete')->name('requestProducts.multiDelete');
    Route::any('requestProducts/search', 'RequestProductController@search')->name('requestProducts.search');
    Route::resource('requestProducts', 'RequestProductController');

    Route::delete('users/multiDelete', 'UserController@multiDelete')->name('users.multiDelete');
    Route::any('users/search', 'UserController@search')->name('users.search');
    Route::any('users/{id}/block', 'UserController@block')->name('users.block');
    Route::resource('users', 'UserController');

    Route::delete('bouquets/multiDelete', 'BouquetController@multiDelete')->name('bouquets.multiDelete');
    Route::any('bouquets/search', 'BouquetController@search')->name('bouquets.search');
    Route::resource('bouquets', 'BouquetController');


    Route::delete('subcategories/multiDelete', 'SubCategoryController@multiDelete')->name('subcategories.multiDelete');
    Route::any('subcategories/search', 'SubCategoryController@search')->name('subcategories.search');
    Route::resource('subcategories', 'SubCategoryController');

    Route::resource('settings', 'SettingController');

    Route::delete('vendors/multiDelete', 'VendorController@multiDelete')->name('vendors.multiDelete');
    Route::any('vendors/search', 'VendorController@search')->name('vendors.search');
    Route::resource('vendors', 'VendorController');



















});
