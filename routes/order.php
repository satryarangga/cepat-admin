<?php

Route::put('order/set-shipment/', 'Order\OrderController@setShipment')->name('order-manage.setShipment');
Route::get('order/change-status/{id}/{type}', 'Order\OrderController@changeStatus')->name('order-manage.changeStatus');
Route::get('order/order-manage/{status}', 'Order\OrderController@index')->name('order-manage.index');
Route::get('order/order-detail/{id}', 'Order\OrderController@detail')->name('order-manage.detail');
Route::get('order/send-email-finish/{orderId}', 'Order\OrderController@sendEmailOrder')->name('order-manage.sendEmailOrder');
Route::get('ajax/graph-sales', 'Order\AjaxController@graphSales')->name('ajax.graphSales');


Route::get('shipping/export-city', 'Order\ShippingController@exportCity')->name('shipping.exportCity');
Route::get('shipping/check-cost', 'Order\ShippingController@checkCost')->name('shipping.checkCost');

// PARTNER
Route::get('order/order-partner/{status}', 'Order\PartnerController@index')->name('order-partner.index');
Route::get('order/order-partner-detail/{id}', 'Order\PartnerController@detail')->name('order-partner.detail');

Route::get('report/sales', 'Order\ReportController@sales')->name('report.sales');
Route::get('report/excel/sales', 'Order\ReportController@excelSales')->name('report.excel.sales');

// RETURN
Route::get('order/return/change-status/{id}/{status}', 'Order\ReturnController@changeStatus')->name('return.change-status');
Route::resource('order/return', 'Order\ReturnController');