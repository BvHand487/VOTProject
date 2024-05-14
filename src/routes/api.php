<?php

use App\Http\Controllers\API\v1\UserController;
use App\Http\Controllers\API\v1\MessageController;
use App\Http\Controllers\API\v1\GroupController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\API\v1'], function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('messages', MessageController::class);
    Route::apiResource('groups', GroupController::class);
});