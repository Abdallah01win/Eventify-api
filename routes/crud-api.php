<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\CategoryController;
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
                        Route::post('/join/{id}', 'join');
                        Route::post('/leave/{id}', 'leave');
                    }
                );
            }
        );

        Route::prefix('categories')->name('categories.')->group(
            function () {
                Route::controller(CategoryController::class)->group(
                    function () {
                        Route::get('/', 'readAll');
                    }
                );
            }
        );
    }
);
