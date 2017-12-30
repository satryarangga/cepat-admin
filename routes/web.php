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

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@index')->name('home');
Route::get('/dashboard-partner', 'HomeController@partner')->name('home-partner');

Route::get('ajax/get-province', 'Master\AjaxController@getProvince')->name('ajax.getProvince');
Route::get('ajax/get-city', 'Master\AjaxController@getCity')->name('ajax.getCity');
Route::get('ajax/get-category-child', 'Master\AjaxController@getCategoryChild')->name('ajax.getCategoryChild');
Route::get('ajax/change-status-size-variant', 'Product\ProductVariantController@changeStatusSize')->name('ajax.changeStatusSizeVariant');
Route::get('ajax/delete-size-variant', 'Product\ProductVariantController@deleteSize')->name('ajax.deleteSizeVariant');
Route::get('ajax/delete-image-variant', 'Product\ProductVariantController@deleteImage')->name('ajax.deleteImageVariant');
Route::get('ajax/get-option-value', 'Product\OptionController@getValue')->name('ajax.getOptionValue');
