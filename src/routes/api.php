<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('sign-up', [AuthController::class, 'signUp'])->name('signUp');
Route::post('sign-in', [AuthController::class, 'signIn'])->name('signIn');

Route::middleware(['auth:sanctum', 'check_user_ip'])->group(function () {
    Route::post('sign-out', [AuthController::class, 'signOut'])->name('signOut');
    Route::get('get-current-weather',[WeatherController::class, 'getCurrentWeather'])->name('getWeather');
    Route::apiResource('invoice', InvoiceController::class)
        ->only(['index', 'update', 'destroy', 'store'])
        ->names('invoice');
});
