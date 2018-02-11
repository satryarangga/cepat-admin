<?php

Route::resource('product/color', 'Product\ColorController');

Route::resource('product/size', 'Product\SizeController');

Route::get('product/category/delete/{id}', 'Product\CategoryController@delete')->name('category.delete');
Route::get('product/category/format', 'Product\CategoryController@formatTree')->name('category.format-list');
Route::get('product/category/update-state', 'Product\CategoryController@updateState')->name('category.update-state');
Route::get('product/category/change-status/{id}/{status}', 'Product\CategoryController@changeStatus')->name('category.change-status');
Route::resource('product/category', 'Product\CategoryController');

Route::post('product/product-manage/countdown', 'Product\ProductVariantControllerroller@setCountdown')->name('product-manage.setCountdown');
Route::get('product/product-manage/stop-countdown/{id}/{name}', 'Product\ProductController@stopCountdown')->name('product-manage.stopCountdown');
Route::get('product/product-manage/expired-countdown', 'Product\ProductController@expiredCountdown')->name('product-manage.expiredCountdown');
Route::get('product/product-manage/change-status/{id}/{status}', 'Product\ProductController@changeStatus')->name('product-manage.change-status');
Route::get('product/product-manage/delete-image', 'Product\ProductController@deleteImage')->name('product-manage.delete-image');
Route::resource('product/product-manage', 'Product\ProductController');

Route::post('product/product-variant/image', 'Product\ProductVariantController@addImage')->name('product-variant.addImage');
Route::get('product/product-variant/inventory', 'Product\ProductVariantController@inventoryControl')->name('product-variant.inventoryControl');
Route::put('product/product-variant/change-inventory', 'Product\ProductVariantController@changeInventory')->name('product-variant.changeInventory');
Route::resource('product/product-variant', 'Product\ProductVariantController');

Route::post('product/option/add-value', 'Product\OptionController@addValue')->name('option.addValue');
Route::get('product/option/delete-value/{id}', 'Product\OptionController@deleteValue')->name('option.deleteValue');
Route::put('product/option/update-value', 'Product\OptionController@updateValue')->name('option.editValue');
Route::get('product/option/change-status/{id}/{status}', 'Product\OptionController@changeStatus')->name('option.change-status');
Route::resource('product/option', 'Product\OptionController');

Route::get('product/promo/delete-product/{id}', 'Product\PromoController@deleteProduct')->name('promo.delete-product');
Route::post('product/promo/add-product', 'Product\PromoController@addProduct')->name('promo.add-product');
Route::put('product/promo/update-product', 'Product\PromoController@updateProduct')->name('promo.update-product');
Route::get('product/promo/manage-product/{id}', 'Product\PromoController@manageProduct')->name('promo.manage-product');
Route::get('product/promo/change-status/{id}/{status}', 'Product\PromoController@changeStatus')->name('promo.change-status');
Route::resource('product/promo', 'Product\PromoController');