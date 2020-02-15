<?php

use Illuminate\Http\Request;
use App\EventController;

Route::prefix('v1')->group(function() {
    // Route::get('/events', 'EventController@index');
    Route::post('/events', 'EventController@store');
    Route::put('/events/{event}', 'EventController@update');
    Route::delete('/events', 'EventController@delete');
});
