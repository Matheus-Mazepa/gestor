<?php
/**
 * Authenticated routes
 * Middleware 'auth', 'web'
 * Prefix pagination
 */

Route::get('clients', 'Users\ClientController@pagination')->name('pagination.clients');

Route::get('layouts', 'LayoutController@pagination')->name('pagination.layouts');

