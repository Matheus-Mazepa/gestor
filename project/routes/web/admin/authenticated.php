<?php
Route::namespace('Users')->prefix('users')->name('users.')->group(function () {
    Route::resource('admin', 'AdminController');
    Route::resource('client', 'ClientController');
});

