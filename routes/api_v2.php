<?php

use App\Http\Controllers\Api\V2\Auth\LoginController;
use App\Http\Controllers\Api\V2\Auth\LogoutController;
use App\Http\Controllers\Api\V2\Auth\PasswordUpdateController;
use App\Http\Controllers\Api\V2\Auth\ProfileController;
use App\Http\Controllers\Api\V2\Auth\RegisterController;
use App\Http\Controllers\Api\V2\ParkingController;
use App\Http\Controllers\Api\V2\UserController;
use App\Http\Controllers\Api\V2\VehicleController;
use App\Http\Controllers\Api\V2\ZoneController;
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

Route::apiResource('/zones', ZoneController::class);

Route::middleware('guest')->prefix('auth')->group(function () {
    Route::post('/register', RegisterController::class);
    Route::post('/login', LoginController::class);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', LogoutController::class);

    Route::get('/user', UserController::class);
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::patch('/profile', [ProfileController::class, 'update']);
    Route::put('/password', PasswordUpdateController::class);

    Route::apiResource('/vehicles', VehicleController::class);

    Route::post('/parkings/start', [ParkingController::class, 'start']);
    Route::get('/parkings/{parking}', [ParkingController::class, 'show']);
    Route::put('/parkings/{parking}', [ParkingController::class, 'stop']);
});
