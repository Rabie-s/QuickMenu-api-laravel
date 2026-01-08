<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Menu\MenuController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('menu', MenuController::class)
        ->parameters(['menu' => 'uuid']);
});