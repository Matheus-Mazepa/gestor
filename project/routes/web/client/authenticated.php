<?php

Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');

Route::resource('users', 'UserController');
Route::resource('products', 'ProductController');
Route::resource('clients', 'ClientController');
Route::resource('bills', 'BillController');
