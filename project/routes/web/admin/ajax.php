<?php
Route::post('choose-layout/{id}', 'LayoutController@chooseLayout')->name('choose_layout');

Route::get('templates/filters/categories', 'TemplateImageController@getFilterCategories')
    ->name('templates.filters.categories');

Route::get('data-roles/get-all', 'DataRoleController@getAll')
    ->name('data-roles.get-all');

Route::get('user-groups/get-all', 'UserGroupController@getAll')
    ->name('user-groups.get-all');

Route::post('comment/{lesson_id}', 'Course\ModuleController@saveComment')
    ->name('lesson.comment.store');
Route::put('comment/{lesson_id}', 'Course\ModuleController@updateComment')
    ->name('lesson.comment.update');
Route::delete('comment/{lesson_id}', 'Course\ModuleController@deleteComment')
    ->name('lesson.comment.delete');

Route::namespace('Dashboards')->prefix('dashboards')->name('dashboards.')->group(function () {
    Route::get('users-per-month', 'GeneralController@getUsersPerMonth')->name('get-users-per-month');
    Route::get('templates-most-used', 'GeneralController@getTemplatesMostUsed')->name('get-template-most-used');
    Route::get('top-users', 'GeneralController@getTopUsers')->name('get-top-users');
});

Route::get('payment-checkout/{paymentCheckout}', 'PaymentCheckoutController@getPaymentCheckout')->name('payment_checkout.get-payment-checkout');
Route::post('payment-checkout/{paymentCheckout}/edit-layout/save', 'PaymentCheckoutController@saveHtml')->name('payment_checkout.save_page_html');
Route::post('payment-checkout/{paymentCheckout}/edit-layout-consulting/save', 'PaymentCheckoutController@saveHtmlConsulting')->name('payment_checkout.save_page_html_consulting');
