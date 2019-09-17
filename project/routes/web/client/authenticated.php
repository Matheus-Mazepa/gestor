<?php
Route::resource('template_images', 'TemplateImageController')->only(['index', 'edit', 'show']);

