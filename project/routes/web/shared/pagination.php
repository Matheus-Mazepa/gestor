<?php
/**
 * Authenticated routes
 * Middleware 'auth', 'web'
 * Prefix pagination
 */

Route::get('notifications', 'NotificationsController@pagination')->name('pagination.notifications');