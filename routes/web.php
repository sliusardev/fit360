<?php

use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
//    return view('welcome');
    return redirect()->route('activity');
})->name('welcome');

Route::get('/activity', [ActivityController::class, 'index'])
    ->name('activity');
Route::get('/activity/list', [ActivityController::class, 'list'])
    ->name('activity-list');
Route::get('/activity/my', [ActivityController::class, 'my'])
    ->name('activity-my');
Route::get('/activity/{id}', [ActivityController::class, 'show'])
    ->name('activity-show');
Route::get('/activity/{id}/join', [ActivityController::class, 'join'])
    ->name('activity-join');
Route::get('/activity/{id}/cancel-join', [ActivityController::class, 'cancelJoin'])
    ->name('activity-cancel-join');
