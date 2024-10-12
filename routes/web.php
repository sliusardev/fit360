<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\TrainerController;
use App\Http\Middleware\ClientMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
//    return view('welcome');
    return redirect()->route('activity');
})->name('welcome');

Route::prefix('activity')->group(function () {
   Route::get('/', [ActivityController::class, 'index'])
       ->name('activity');

    Route::get('/list', [ActivityController::class, 'list'])
        ->name('activity.list');

    Route::get('/my', [ActivityController::class, 'my'])
        ->middleware(ClientMiddleware::class)
        ->name('activity.my');

    Route::get('/{id}', [ActivityController::class, 'show'])
        ->name('activity.show');

    Route::get('/{id}/join', [ActivityController::class, 'join'])
        ->name('activity.join');

    Route::get('/{id}/cancel-join', [ActivityController::class, 'cancelJoin'])
        ->name('activity.cancelJoin');
});

Route::prefix('trainer')->group(function () {
    Route::get('/', [TrainerController::class, 'index'])->name('trainer.index');
    Route::get('/{id}', [TrainerController::class, 'show'])->name('trainer.show');
});


