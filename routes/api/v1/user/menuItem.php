<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\MenuItem\MenuItemController;

Route::prefix('menus/{menuUuid}/categories/{categoryId}')->group(function () {
    Route::apiResource('items', MenuItemController::class);
});