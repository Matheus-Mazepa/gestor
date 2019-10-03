<?php
/**
 * Authenticated routes
 * Middleware 'auth', 'web'
 * Prefix pagination
 */
Route::get('users', 'UserController@pagination')->name('pagination.users');

Route::get('layouts', 'LayoutController@pagination')->name('pagination.layouts');

Route::get('template-images', 'TemplateImageController@pagination')->name('pagination.template_images');


