<?php

use App\Http\Controllers\PlaceController;
use App\Http\Controllers\WeatherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/place', [PlaceController::class, 'index']);
Route::get('/weather', [WeatherController::class, 'index']);
