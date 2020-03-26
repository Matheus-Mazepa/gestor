<?php
/**
 * Pagination routes for admin
 * Prefix 'admin', middleware 'auth:'web', 'auth', 'verified', 'user-type:ADMIN'
 * Name 'admin.'
 * Namespace 'App\Http\Controllers\Admin
 */

Route::get('users-admin', 'UserAdminController@pagination')->name('users-admin');
