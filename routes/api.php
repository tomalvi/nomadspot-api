<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use Illuminate\Support\Facades\Artisan;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/cities', [CityController::class, 'index']);
Route::get('/cities/panel', [CityController::class, 'panel']);
Route::get('/cities/{id}', [CityController::class, 'show']);



Route::get('/execute-import', function () {

    Artisan::call('data:import');

    return response()->json([
        'status' => 'success',
        'message' => '¡Datos importados correctamente!',
        'output' => Artisan::output()
    ]);
});
