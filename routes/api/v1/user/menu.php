<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Menu\MenuController;


Route::apiResource('menu', MenuController::class)
    ->parameters(['menu' => 'uuid']);
