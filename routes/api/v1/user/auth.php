<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Auth\AuthController;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('me', [AuthController::class, 'me'])
        ->middleware('auth:sanctum');
    Route::post('logout', [AuthController::class, 'logout'])
        ->middleware('auth:sanctum');
});
