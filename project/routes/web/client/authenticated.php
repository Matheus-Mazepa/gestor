<?php

Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');

Route::resource('template_images', 'TemplateImageController')->only(['index', 'edit', 'show']);

Route::resource('profile', 'ClientProfileController');

Route::get('profile/instagram/{id}', 'ClientProfileController@editInstagram')->name('profile.instagram');
Route::put('profile/instagram/{id}', 'ClientProfileController@updateInstagram')->name('profile.instagram.update');

Route::resource('instagram', 'InstagramController');
Route::get('instagram/user/get-picture', 'InstagramController@getProfilePicture')
    ->name('instagram.get-picture');
Route::get('instagram/create/{image_id}', 'InstagramController@createForImage')
    ->name('instagram.create-for-image');

Route::resource('layouts', 'LayoutController');

Route::get('layouts/edit-layout/{id}', 'LayoutController@editLayout')->name('layouts.edit-layout');
Route::post('layouts/update-layout/{id}', 'LayoutController@updateLayout')->name('layouts.update-layout');
Route::post('layouts/update-layout/{layout}/image', 'LayoutController@saveImage')->name('layouts.save-image');

Route::get('leads', 'LeadController@index')->name('layouts.leads.index');

Route::get('invoices', 'InvoiceController@index')->name('invoices.index');
Route::get('invoices/{id}', 'InvoiceController@showInvoice')->name('invoices.show-invoice');

Route::get('subscription', 'SubscriptionController')->name('subscription.show');

Route::get('subdomain', 'SubdomainsController@showFirst')
    ->name('subdomains.showFirst');

Route::get('subdomain/edit-first', 'SubdomainsController@editFirst')
    ->name('subdomains.editFirst');

Route::get('subdomain/create', 'SubdomainsController@create')
    ->name('subdomains.create');

Route::post('subdomain', 'SubdomainsController@storeOrUpdateFirst')
    ->name('subdomains.storeOrUpdateFirst');

Route::post('user-images', 'UserImageController@store')->name('user-images.store');
Route::get('user-images', 'UserImageController@index')->name('user-images.index');

Route::get('images', 'ImageController@index')->name('images.index');
Route::get('images/get-template/{template_image_id}', 'ImageController@getTemplateImage')->name('images.get-template');
Route::get('images/{template_image_id}/fill', 'ImageController@fillTemplateImage')
    ->name('images.fill-template-image');

Route::resource('file-download', 'FileDownloadController')->only(['index', 'show']);

Route::resource('events', 'EventsController');
Route::get('events/{id}/image', 'EventsController@image')->name('events.image');
Route::get('events/{id}/image/{image}/fill', 'EventsController@imageFill')->name('events.image.fill');

Route::get('courses', 'CourseController@index')
    ->name('courses.index');
Route::get('courses/{course}/module', 'CourseController@modules')
    ->name('courses.modules');
Route::get('courses/{course}/module/{module}/lessons', 'CourseController@lessons')
    ->name('courses.modules.lessons');
Route::get('courses/{course}/module/{module}/lessons/{lesson}', 'CourseController@lesson')
    ->name('courses.modules.lesson');

Route::get('lesson/attachment/{attachment_id}/download', 'CourseController@downloadAttachment')
    ->name('attachment.download');
