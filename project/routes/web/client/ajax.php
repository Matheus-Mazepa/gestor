<?php

Route::get('categories/{id}/products', "ProductController@getProductsByCategoryId")->name('products');
Route::post('order/{order}/set_delivered', "OrderController@setDelivered")->name('order.set_delivered');
