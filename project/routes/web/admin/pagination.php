<?php
/**
 * Pagination routes for admin
 * Prefix 'admin', middleware 'auth:'web', 'auth', 'verified', 'user-type:ADMIN'
 * Name 'admin.'
 * Namespace 'App\Http\Controllers\Admin
 */

Route::get('payment-checkout', 'PaymentCheckoutController@pagination')->name('pagination.payment_checkout');

Route::get('payment-checkout-items/{paymentCheckoutId}', 'PaymentCheckoutItemsController@paginationByPaymentCheckoutId')->name('pagination.payment_checkout-items');

Route::get('payment-checkout-users/{paymentCheckoutId}', 'PaymentCheckoutUsersController@paginationByPaymentCheckoutId')->name('pagination.payment_checkout-users');

Route::get('admins', 'Users\AdminController@pagination')->name('pagination.admins');

Route::get('clients', 'Users\ClientController@pagination')->name('pagination.clients');
Route::get('user-groups', 'UserGroupController@pagination')->name('pagination.user_groups');

Route::get('invoices/{id}', 'Users\InvoiceController@paginationByUserId')->name('pagination.invoices');

Route::get('profiles-permissions', 'ProfileAndPermissionController@pagination')
    ->name('pagination.profiles_permissions');

Route::get('template-images', 'TemplateImageController@pagination')->name('pagination.template_images');

Route::get('template-images', 'TemplateImageController@pagination')
    ->name('pagination.template_images');

Route::get('plans', 'PlansController@pagination')->name('pagination.plans');

Route::get('subscriptions', 'SubscriptionsController@pagination')->name('pagination.subscriptions');

Route::get('layouts', 'LayoutController@pagination')->name('pagination.layouts');

Route::get('email_journeys', 'EmailJourneyController@pagination')
    ->name('pagination.email_journeys');

Route::get('emails/{email_journey_id}', 'EmailController@paginationByEmailJourney')
    ->name('pagination.emails');

Route::get('audit', 'AuditorshipController@pagination')
    ->name('pagination.audit');

Route::get('categories', 'CategoriesController@pagination')->name('pagination.categories');
Route::get('groups', 'GroupController@pagination')->name('pagination.groups');

Route::get('file-upload', 'FileUploadController@pagination')->name('pagination.file-upload');

Route::get('courses', 'Course\CourseController@pagination')->name('pagination.courses');
Route::get('{course}/modules', 'Course\ModuleController@pagination')->name('pagination.modules');
Route::get('{course}/modules/{module}/lessons', 'Course\ModuleController@lessonPagination')
    ->name('pagination.modules.lessons');

Route::get('svg', 'SvgUploadController@pagination')->name('pagination.svg');
Route::get('svg/editor', 'SvgUploadController@paginationEditor')->name('pagination.svg.editor');

Route::namespace('Dashboards')->prefix('dashboards')->name('dashboards.')->group(function () {
    Route::get('users-and-user-groups', 'GeneralController@getUsersAndUsersGroup')->name('pagination.users-and-user-groups');
});
