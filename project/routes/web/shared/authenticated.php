<?php
Route::get('/', 'SingleInvokes\WelcomeController');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('template_image/{template_image_id}/image', 'SingleInvokes\TemplateImageController')
    ->name('template_image.getImage');

Route::get('template_image/{template_image_id}/thumbnail', 'SingleInvokes\ImageThumbnailController')
    ->name('template_image.thumbnail');

Route::get('template_image/{template_image_id}/logo', 'SingleInvokes\TemplateLogoController')
    ->name('template_image.logo');

Route::get('theme/{theme_id}/image', 'SingleInvokes\ThemeController')
    ->name('theme.getImage');

Route::get('theme/{theme_id}/thumbnail', 'SingleInvokes\ThemeThumbnailController')
    ->name('theme.getImage.thumbnail');

Route::get('user-image/{id}/thumb', 'Client\UserImageController@getThumb')
    ->name('user-image.getThumb');

Route::get('notifications', 'NotificationsController@index');
Route::post('notifications/read-all', 'NotificationsController@readAll');

Route::get('notifications/read/{id}', 'NotificationsController@readNotification')->name('notification.read');

Route::get('lesson/{lesson_id}/thumbnail', 'SingleInvokes\LessonThumbnailController')->name('lesson.thumbnail');

Route::get('module/{lesson_id}/thumbnail', 'SingleInvokes\ModuleThumbnailController')->name('module.thumbnail');

Route::get('course/{lesson_id}/thumbnail', 'SingleInvokes\CourseThumbnailController')->name('course.thumbnail');



Route::get('editor/svg/{svg_id}', 'SingleInvokes\SvgController')->name('svg.get');