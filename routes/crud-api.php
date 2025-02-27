<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(
    function () {
        Route::prefix('events')->name('events.')->group(
            function () {
                Route::controller(EventController::class)->group(
                    function () {
                        Route::post('/', 'createOne');
                        Route::get('/{id}', 'readOne');
                        Route::get('/', 'readAll');
                        Route::put('/{id}', 'updateOne');
                        Route::patch('/{id}', 'patchOne');
                        Route::delete('/{id}', 'deleteOne');
                    }
                );
            }
        );
    }
);
