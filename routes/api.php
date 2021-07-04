<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/home', [EventController::class, 'index']);
Route::post('/create', [EventController::class, 'store']);
Route::delete('/delete/{id}', [EventController::class, 'destroy']);
Route::get('/edit/{id}', [EventController::class, 'edit']);
Route::put('/update/{id}', [EventController::class, 'update']);
Route::post('/upload/{id}', [EventController::class, 'upload']);
Route::post('/event', [EventUserController::class, 'event']);
Route::get('/event/{auth}/{id}', [EventUserController::class, 'index']);
