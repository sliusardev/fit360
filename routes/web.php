<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\FeedBackController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PriceListController;
use App\Http\Controllers\TrainerController;
use App\Http\Middleware\ClientMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
//    return view('welcome');
    return redirect()->route('activity');
})->name('welcome');

Route::get('contacts', [PageController::class, 'contacts'])->name('page.contacts');

Route::prefix('activity')->group(function () {
   Route::get('/', [ActivityController::class, 'index'])
       ->name('activity');

    Route::get('/list', [ActivityController::class, 'list'])
        ->name('activity.list');

    Route::get('/my', [ActivityController::class, 'my'])
        ->middleware(ClientMiddleware::class)
        ->name('activity.my');

    Route::get('/my-archive', [ActivityController::class, 'myArchive'])
        ->middleware(ClientMiddleware::class)
        ->name('activity.myArchive');

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

Route::prefix('price-list')->group(function () {
    Route::get('/', [PriceListController::class, 'index'])->name('price-list.index');
    Route::get('/{id}', [PriceListController::class, 'show'])->name('price-list.show');
});

Route::prefix('feedback')->group(function () {
    Route::get('/', [FeedBackController::class, 'index'])->name('feedback.index');
    Route::post('/store', [FeedBackController::class, 'store'])->name('feedback.store');
});


