<?php
Route::post('choose-layout/{id}', 'LayoutController@chooseLayout')->name('choose_layout');
Route::post('lesson-watched/{lesson_id}', 'CourseController@watchedLesson')->name('lesson.watched');
Route::get('get-template-images', 'TemplateImageController@getTemplateImages')->name('get_template_images');
Route::post('template-image/{template_image_id}/favorite', 'ImageController@favorite')
    ->name('template_image.favorite');
Route::post('template-image/{template_image_id}/disfavor', 'ImageController@disfavor')
    ->name('template_image.disfavor');
Route::get('images/filters/categories', 'ImageController@getFilterCategories')
    ->name('images.filters.categories');

Route::get('user-images/filters/categories', 'UserImageController@getFilterCategories')
    ->name('user-images.filters.categories');

Route::get('user-images/{id}/get-image', 'UserImageController@getImage')
    ->name('user-image.get-image');

Route::post('watched-lesson/{lesson_id}', 'CourseController@watchedLesson')
    ->name('lesson.watched');

Route::post('comment/{lesson_id}', 'CourseController@saveComment')
    ->name('lesson.comment.store');
Route::put('comment/{lesson_id}', 'CourseController@updateComment')
    ->name('lesson.comment.update');
Route::delete('comment/{lesson_id}', 'CourseController@deleteComment')
    ->name('lesson.comment.delete');
