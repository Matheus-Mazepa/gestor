<?php

Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');

Route::get('get-fonts', 'FontsController@getFonts')->name('font.getAll');
Route::get('get-fonts-family/{regularFont}', 'FontsController@getFontsFamily')->name('font.getAll');

Route::namespace('Users')->prefix('users')->name('users.')->group(function () {
    Route::resource('admin', 'AdminController');
    Route::resource('client', 'ClientController');
    Route::get('client/{id}/invoices', 'InvoiceController@index')->name('invoices');
    Route::post('client/invoices/{id}', 'InvoiceController@refund')->name('invoices.refund');
});

Route::resource('payment-checkout', 'PaymentCheckoutController');
Route::get('payment-checkout/{paymentCheckout}/edit-layout', 'PaymentCheckoutController@editLayout')->name('payment-checkout.edit-layout');

Route::resource('payment-checkout-items', 'PaymentCheckoutItemsController')->only(['store', 'update']);

Route::get('payment-checkout-items/payment-checkout/{paymentCheckoutId}', 'PaymentCheckoutItemsController@index')->name('payment-checkout-items.index-payment');
Route::get('payment-checkout-items/payment-checkout/{paymentCheckoutId}/create', 'PaymentCheckoutItemsController@create')->name('payment-checkout-items.create');

Route::resource('consulting', 'ConsultingController');

Route::get('payment-checkout-users/payment-checkout/{paymentCheckoutId}', 'PaymentCheckoutUsersController@index')->name('payment-checkout-users.index-payment');
Route::post('payment-checkout-users/{paymentCheckoutUser}/approve-payment', 'PaymentCheckoutUsersController@approvePayment')->name('payment-checkout-users.approve-payment');

Route::resource('user-groups', 'UserGroupController');

Route::resource('profile', 'ProfileController')->only(['show', 'edit', 'update']);

Route::resource('layouts', 'LayoutController')->only(['index', 'edit', 'update']);

Route::get('layouts/edit-layout/{id}', 'LayoutController@editLayout')->name('layouts.edit-layout');
Route::post('layouts/update-layout/{id}', 'LayoutController@updateLayout')->name('layouts.update-layout');
Route::post('layouts/update-layout/{layout}/image', 'LayoutController@saveImage')->name('layouts.save-image');

Route::post('layouts/{layout}/is-active/change', 'LayoutController@changeIsActive')->name('layouts.change_is_active');

Route::resource('template_images', 'TemplateImageController');
Route::resource('groups', 'GroupController')->except(['show']);

Route::get('template_images/all-by-image-type/{imageType}', 'TemplateImageController@getAllByImageType')->name('template.all_by_image_type');
Route::resource('profiles_permissions', 'ProfileAndPermissionController');

Route::resource('email_journeys', 'EmailJourneyController');
Route::resource('plans', 'PlansController');
Route::resource('subscriptions', 'SubscriptionsController');

Route::resource('email_journeys', 'EmailJourneyController');

Route::resource('emails', 'EmailController')->except(['index', 'create']);

Route::get('email/create/{email_journey_id}', 'EmailController@create')->name('emails.create');
Route::get('email/index/{email_journey_id}', 'EmailController@index')->name('emails.index');

Route::get('/audit', 'AuditorshipController@report')->name('audit.report');

Route::get('/audit/{activity}', 'AuditorshipController@show')
    ->where('activity', '[0-9]+')
    ->name('audit.show');

Route::resource('categories', 'CategoriesController');

Route::resource('file-upload', 'FileUploadController');

Route::resource('course', 'Course\CourseController');
Route::namespace('Course')->prefix('course/{course}')->name('course.')->group(function () {
    Route::resource('module', 'ModuleController');

    Route::get('modules/{module}/lessons/{lesson}', 'ModuleController@showLessons')
        ->name('module.lessons.show');
    Route::get('modules/{module}/lessons', 'ModuleController@lessons')
        ->name('module.lessons.edit');
    Route::put('modules/{module}/lessons', 'ModuleController@lessonsUpdate')
        ->name('module.lessons.update');
});


Route::get('subdomain', 'SubdomainsController@showFirst')
    ->name('subdomains.showFirst');

Route::get('subdomain/edit-first', 'SubdomainsController@editFirst')
    ->name('subdomains.editFirst');

Route::get('subdomain/create', 'SubdomainsController@create')
    ->name('subdomains.create');

Route::post('subdomain', 'SubdomainsController@storeOrUpdateFirst')
    ->name('subdomains.storeOrUpdateFirst');
Route::resource('svg-upload', 'SvgUploadController');
