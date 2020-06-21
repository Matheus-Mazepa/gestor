<?php
/**
 * Pagination routes for admin
 * Prefix 'admin', middleware 'auth:'web', 'auth', 'verified', 'user-type:ADMIN'
 * Name 'admin.'
 * Namespace 'App\Http\Controllers\Admin
 */

Route::get('users-admin', 'UserAdminController@pagination')->name('users-admin');
Route::get('companies', 'CompanyController@pagination')->name('companies');
Route::get('companies/{company}/users', 'UserCompanyController@pagination')->name('companies.users');
