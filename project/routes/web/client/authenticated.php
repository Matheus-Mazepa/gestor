<?php

Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');
Route::get('order/{order}/print', 'OrderController@print')->name('order.print');

Route::resource('orders', 'OrderController');
Route::resource('users', 'UserController');
Route::resource('categories', 'CategoryController');
Route::resource('products', 'ProductController');
Route::resource('clients', 'ClientController');
Route::resource('bills', 'BillController');
