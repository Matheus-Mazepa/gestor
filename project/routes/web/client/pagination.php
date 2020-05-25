<?php
/**
 * Authenticated routes
 * Middleware 'auth', 'web'
 * Prefix pagination
 */

Route::get('users', 'UserController@pagination')->name('users');
Route::get('products', 'ProductController@pagination')->name('products');
Route::get('categories', 'CategoryController@pagination')->name('categories');
Route::get('clients', 'ClientController@pagination')->name('clients');
