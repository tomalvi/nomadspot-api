<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/cities', [CityController::class, 'index']);
Route::get('/cities/panel', [CityController::class, 'panel']);
Route::get('/cities/{id}', [CityController::class, 'show']);

