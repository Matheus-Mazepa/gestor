<?php

Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');
Route::get('order/{order}/print', 'OrderController@print')->name('order.print');

Route::post('product/{product}/duplicate', 'ProductController@duplicate')->name('product.duplicate');
Route::get('product/{product}/stock', 'ProductController@editStock')->name('product.edit_stock');
Route::put('product/{product}/stock', 'ProductController@updateStock')->name('product.update_stock');

Route::resource('orders', 'OrderController');
Route::resource('users', 'UserController');
Route::resource('categories', 'CategoryController');
Route::resource('products', 'ProductController');
Route::resource('clients', 'ClientController');
Route::resource('bills', 'BillController');

