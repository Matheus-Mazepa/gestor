<?php
Route::get('/', 'SingleInvokes\WelcomeController');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
