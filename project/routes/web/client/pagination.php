<?php
/**
 * Authenticated routes
 * Middleware 'auth', 'web'
 * Prefix pagination
 */

Route::get('template-images', 'TemplateImageController@pagination')->name('pagination.template_images');

