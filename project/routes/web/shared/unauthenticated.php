<?php
/**
 * Unauthenticated routes
 */
Auth::routes(['register' => false]);

Route::get('/address/states', 'Address\StateCityController@getStatesJson')->name('states.json.all');
Route::get('/address/{abbr}/cities/', 'Address\StateCityController@getCitiesJsonFor')->name('cities.state.json');