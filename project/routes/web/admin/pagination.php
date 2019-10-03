<?php
/**
 * Pagination routes for admin
 * Prefix 'admin', middleware 'auth:'web', 'auth', 'verified', 'user-type:ADMIN'
 * Name 'admin.'
 * Namespace 'App\Http\Controllers\Admin
 */

Route::get('admins', 'Users\AdminController@pagination')->name('pagination.admins');

Route::get('clients', 'Users\ClientController@pagination')->name('pagination.clients');

Route::get('template-images', 'TemplateImageController@pagination')->name('pagination.template_images');
