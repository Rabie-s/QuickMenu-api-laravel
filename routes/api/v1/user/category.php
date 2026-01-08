<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Category\CategoryController;

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('menus/{menuUuid}')->group(function () {
        Route::apiResource('categories', CategoryController::class);
    });
});
