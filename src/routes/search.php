<?php

Route::middleware('web')
    ->get('searching', 'Searching\\Http\\Controllers\\SearchingController@index')
    ->name('searching');
