<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(
    function () {
        Route::prefix('events')->name('events.')->group( function ()   {
            Route::apiResource('/', EventController::class);
            Route::post('/{event}/join', [EventController::class, 'join']);
            Route::post('/{event}/leave', [EventController::class, 'leave']);
        });
    }
);
