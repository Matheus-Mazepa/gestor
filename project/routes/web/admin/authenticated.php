<?php

Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');

Route::resource('users-admin', 'UserAdminController');
Route::resource('companies', 'CompanyController');
Route::resource('companies/{company}/users', 'UserCompanyController');
