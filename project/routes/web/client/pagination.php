<?php
/**
 * Authenticated routes
 * Middleware 'auth', 'web'
 * Prefix pagination
 */

<<<<<<< HEAD
Route::get('clients', 'Users\ClientController@pagination')->name('pagination.clients');

Route::get('layouts', 'LayoutController@pagination')->name('pagination.layouts');
=======
Route::get('template-images', 'TemplateImageController@pagination')->name('pagination.template_images');
>>>>>>> cbf1ac96386fbfdfd241f7e851de7d812f19cca4

