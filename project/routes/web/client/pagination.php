<?php
/**
 * Authenticated routes
 * Middleware 'auth', 'web'
 * Prefix pagination
 */

Route::get('instagram', 'InstagramController@pagination')->name('pagination.instagram');

Route::get('user-images', 'UserImageController@pagination')->name('pagination.user-images');

Route::get('profiles', 'ClientProfileController@pagination')->name('pagination.profiles');

Route::get('layouts', 'LayoutController@pagination')->name('pagination.layouts');
Route::get('leads', 'LeadController@pagination')->name('pagination.layouts.leads');

Route::get('images', 'ImageController@pagination')->name('pagination.images');

Route::get('invoices', 'InvoiceController@pagination')->name('pagination.invoices');

Route::get('file-download', 'FileDownloadController@pagination')->name('pagination.file-download');

Route::get('events', 'EventsController@pagination')->name('pagination.events');
Route::get('events/{id}/images', 'EventsController@imagePagination')->name('pagination.events.image');

Route::get('courses', 'CourseController@coursePagination')
    ->name('pagination.courses');
Route::get('{course}/modules', 'CourseController@modulePagination')
    ->name('pagination.modules');
Route::get('{course}/modules/{module}/lessons', 'CourseController@lessonPagination')
    ->name('pagination.modules.lessons');
