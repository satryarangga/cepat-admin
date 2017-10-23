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

Route::get('master/user/change-status/{id}/{status}', 'Master\UserController@changeStatus')->name('user.change-status');
Route::resource('master/user', 'Master\UserController');

Route::get('master/request-partner/change-status/{id}/{status}', 'Master\RequestPartnerController@changeStatus')->name('request-partner.change-status');
Route::resource('master/request-partner', 'Master\RequestPartnerController');

Route::get('master/customer/change-status/{id}/{status}', 'Master\CustomerController@changeStatus')->name('customer.change-status');
Route::resource('master/customer', 'Master\CustomerController');

Route::resource('master/static-content', 'Master\StaticContentController');

Route::get('master/voucher/change-status/{id}/{status}', 'Master\VoucherController@changeStatus')->name('voucher.change-status');
Route::resource('master/voucher', 'Master\VoucherController');

Route::get('ajax/get-province', 'Master\AjaxController@getProvince')->name('ajax.getProvince');
Route::get('ajax/get-city', 'Master\AjaxController@getCity')->name('ajax.getCity');
Route::get('ajax/get-category-child', 'Master\AjaxController@getCategoryChild')->name('ajax.getCategoryChild');
Route::get('ajax/change-status-size-variant', 'Product\ProductVariantController@changeStatusSize')->name('ajax.changeStatusSizeVariant');
Route::get('ajax/delete-size-variant', 'Product\ProductVariantController@deleteSize')->name('ajax.deleteSizeVariant');
Route::get('ajax/delete-image-variant', 'Product\ProductVariantController@deleteImage')->name('ajax.deleteImageVariant');


// PRODUCT
Route::resource('product/color', 'Product\ColorController');

Route::resource('product/size', 'Product\SizeController');

Route::get('product/category-parent/change-status/{id}/{status}', 'Product\CategoryParentController@changeStatus')->name('category-parent.change-status');
Route::resource('product/category-parent', 'Product\CategoryParentController');

Route::get('product/category-child/change-status/{id}/{status}', 'Product\CategoryChildController@changeStatus')->name('category-child.change-status');
Route::resource('product/category-child', 'Product\CategoryChildController');

Route::get('product/product-manage/change-status/{id}/{status}', 'Product\ProductController@changeStatus')->name('product-manage.change-status');
Route::resource('product/product-manage', 'Product\ProductController');

Route::post('product/product-variant/image', 'Product\ProductVariantController@addImage')->name('product-variant.addImage');
Route::resource('product/product-variant', 'Product\ProductVariantController');


