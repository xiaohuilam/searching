<?php

Route::group(['middleware' => 'web', 'prefix' => config('search.route.prefix'), ], function () {
    Route::get('searching', 'Searching\\Http\\Controllers\\SearchingController@index')->name('searching');
});
