<?php

Route::get('categories/{id}/products', "ProductController@getProductsByCategoryId")->name('products');
