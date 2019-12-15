<?php
Route::get('/', 'SingleInvokes\WelcomeController');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::resource('users', 'UserController');
Route::resource('products', 'ProductController');
Route::resource('bills', 'BillController');
