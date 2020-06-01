<?php

Route::group(['middleware' => config('search.route.middleware', 'web'), 'prefix' => config('search.route.prefix'), ], function () {
    $method = config('search.route.method', 'get');
    Route::{$method}('searching', 'Searching\\Http\\Controllers\\SearchingController@index')->name('searching');
});
