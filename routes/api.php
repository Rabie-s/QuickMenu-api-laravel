<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function(){


    Route::prefix('user')->group(function(){
        require __DIR__.'/api/v1/user/auth.php';
         require __DIR__.'/api/v1/user/menu.php';
         require __DIR__.'/api/v1/user/category.php';
    });


});

