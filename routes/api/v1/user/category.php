<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Category\CategoryController;


Route::prefix('menus/{menuUuid}')->group(function () {
    Route::apiResource('categories', CategoryController::class);
});
