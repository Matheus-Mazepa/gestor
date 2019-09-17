<?php

Route::get('users', 'UserController@pagination')->name('pagination.users');

Route::get('template-images', 'TemplateImageController@pagination')->name('pagination.template_images');
