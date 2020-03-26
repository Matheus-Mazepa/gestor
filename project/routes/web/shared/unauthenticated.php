<?php
/**
 * Unauthenticated routes
 */

Route::group(['domain' => '{subdomain}.' . base_domain()], function() {
    Route::get('/', 'LandingPageController@show');

    Route::post('/register/leads/{layout}', 'LandingPageController@registerLead');
});

Auth::routes();

Route::get('hire', 'HireController@index')->name('hire');
Route::post('hire', 'HireController@register')->name('hire.register');

Route::get('/address/states', 'Address\StateCityController@getStatesJson')->name('states.json.all');
Route::get('/address/{abbr}/cities/', 'Address\StateCityController@getCitiesJsonFor')->name('cities.state.json');

Route::get('layout-content/{id}', 'LandingPageController@preview')->name('layout.preview');
Route::get('layouts/{layout}/images/{image_id}', 'SingleInvokes\ImageLayoutController')->name('layouts.get-image');
Route::get('layouts/{layout}/images/{image_id}/users/{user_id}', 'SingleInvokes\ImageUserLayoutController')->name('layouts.get-image-user');

Route::get('image-instagram/{path_image}', 'SingleInvokes\ImageInstagramController')->name('instagram.image');

Route::get('payment/{path}', 'PaymentCheckoutController@index')->name('payment-checkout');

Route::post('payment', 'PaymentCheckoutController@store')->name('payment-checkout.store');

