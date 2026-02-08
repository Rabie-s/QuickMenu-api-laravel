<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api/v1/user')->group(function () {
    require __DIR__.'/api/v1/user/auth.php';
});

