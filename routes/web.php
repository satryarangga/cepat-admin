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

Route::put('master/customer/adjust-wallet', 'Master\CustomerController@adjustWallet')->name('customer.adjustWallet');
Route::get('master/customer/change-status/{id}/{status}', 'Master\CustomerController@changeStatus')->name('customer.change-status');
Route::resource('master/customer', 'Master\CustomerController');

Route::get('master/partner/change-status/{id}/{status}', 'Master\PartnerController@changeStatus')->name('partner.change-status');
Route::resource('master/partner', 'Master\PartnerController');

Route::resource('master/static-content', 'Master\StaticContentController');

Route::get('master/voucher/change-status/{id}/{status}', 'Master\VoucherController@changeStatus')->name('voucher.change-status');
Route::resource('master/voucher', 'Master\VoucherController');

Route::get('master/payment-method/change-status/{id}/{status}', 'Master\PaymentMethodController@changeStatus')->name('payment-method.change-status');
Route::resource('master/payment-method', 'Master\PaymentMethodController');

Route::get('master/slider/change-status/{id}/{status}', 'Master\SliderController@changeStatus')->name('slider.change-status');
Route::resource('master/slider', 'Master\SliderController');

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

Route::post('product/product-manage/countdown', 'Product\ProductController@setCountdown')->name('product-manage.setCountdown');
Route::get('product/product-manage/stop-countdown/{id}/{name}', 'Product\ProductController@stopCountdown')->name('product-manage.stopCountdown');
Route::get('product/product-manage/expired-countdown', 'Product\ProductController@expiredCountdown')->name('product-manage.expiredCountdown');
Route::get('product/product-manage/change-status/{id}/{status}', 'Product\ProductController@changeStatus')->name('product-manage.change-status');
Route::resource('product/product-manage', 'Product\ProductController');

Route::post('product/product-variant/image', 'Product\ProductVariantController@addImage')->name('product-variant.addImage');
Route::get('product/product-variant/inventory', 'Product\ProductVariantController@inventoryControl')->name('product-variant.inventoryControl');
Route::put('product/product-variant/change-inventory', 'Product\ProductVariantController@changeInventory')->name('product-variant.changeInventory');
Route::resource('product/product-variant', 'Product\ProductVariantController');

Route::put('order/set-shipment/', 'Order\OrderController@setShipment')->name('order-manage.setShipment');
Route::get('order/change-status/{id}/{type}', 'Order\OrderController@changeStatus')->name('order-manage.changeStatus');
Route::get('order/order-manage/{status}', 'Order\OrderController@index')->name('order-manage.index');
Route::get('order/order-detail/{id}', 'Order\OrderController@detail')->name('order-manage.detail');
Route::get('ajax/graph-sales', 'Order\AjaxController@graphSales')->name('ajax.graphSales');

Route::get('report/sales', 'Order\ReportController@sales')->name('report.sales');
Route::get('report/excel/sales', 'Order\ReportController@excelSales')->name('report.excel.sales');
