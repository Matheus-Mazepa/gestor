<?php

Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');

Route::resource('users-admin', 'UserAdminController');
Route::resource('companies', 'CompanyController');
