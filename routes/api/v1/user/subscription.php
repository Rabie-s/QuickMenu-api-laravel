<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Subscription\SubscriptionController;

Route::post('upgrade',[SubscriptionController::class,'upgrade']);