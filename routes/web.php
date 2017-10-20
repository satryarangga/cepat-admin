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

Route::get('setting/user/change-status/{id}/{status}', 'Master\UserController@changeStatus')->name('user.change-status');
Route::resource('setting/user', 'Master\UserController');

Route::get('master/customer/change-status/{id}/{status}', 'Master\CustomerController@changeStatus')->name('customer.change-status');
Route::resource('master/customer', 'Master\CustomerController');

Route::resource('setting/static-content', 'Master\StaticContentController');

Route::get('master/voucher/change-status/{id}/{status}', 'Master\VoucherController@changeStatus')->name('voucher.change-status');
Route::resource('master/voucher', 'Master\VoucherController');

Route::get('ajax/get-province', 'Master\AjaxController@getProvince')->name('ajax.getProvince');
Route::get('ajax/get-city', 'Master\AjaxController@getCity')->name('ajax.getCity');
