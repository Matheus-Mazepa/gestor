<?php
Route::resource('users', 'UserController');

Route::resource('template_images', 'TemplateImageController')->only(['index', 'edit', 'show']);
