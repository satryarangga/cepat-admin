<?php

Route::get('master/user/change-status/{id}/{status}', 'Master\UserController@changeStatus')->name('user.change-status');
Route::resource('master/user', 'Master\UserController');

Route::get('master/request-partner/change-status/{id}/{status}', 'Master\RequestPartnerController@changeStatus')->name('request-partner.change-status');
Route::resource('master/request-partner', 'Master\RequestPartnerController');

Route::get('master/customer/send-email/{id}', 'Master\CustomerController@sendEmail')->name('customer.sendRegisterEmail');
Route::get('master/customer/forgot-password/{id}/{token}', 'Master\CustomerController@forgotPassword')->name('customer.forgotPassword');
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

Route::get('master/banner/change-status/{id}/{status}', 'Master\BannerController@changeStatus')->name('banner.change-status');
Route::resource('master/banner', 'Master\BannerController');