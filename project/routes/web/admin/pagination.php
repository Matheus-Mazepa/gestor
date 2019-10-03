<?php
/**
 * Pagination routes for admin
 * Prefix 'admin', middleware 'auth:'web', 'auth', 'verified', 'user-type:ADMIN'
 * Name 'admin.'
 * Namespace 'App\Http\Controllers\Admin
 */

<<<<<<< HEAD
Route::get('admins', 'Users\AdminController@pagination')->name('pagination.admins');
=======
Route::get('users', 'UserController@pagination')->name('pagination.users');

Route::get('template-images', 'TemplateImageController@pagination')->name('pagination.template_images');
>>>>>>> cbf1ac96386fbfdfd241f7e851de7d812f19cca4
