<?php

Route::group(['middleware' => 'web', ], function () {
    Route::get('searching', 'Searching\\Http\\Controllers\\SearchingController@index')->name('searching');
});
