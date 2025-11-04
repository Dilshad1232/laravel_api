<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/hello', function () {
    return response()->json([
        'message' => 'Hello Dilshad Sir 👋',
        'status' => 'success'
    ]);
});

use App\Http\Controllers\Api\UserApiController;

Route::get('/users', [UserApiController::class, 'index']);
Route::get('/users/{id}', [UserApiController::class, 'show']);
Route::post('/users', [UserApiController::class, 'store']);
Route::put('/users/{id}', [UserApiController::class, 'update']);
Route::delete('/users/{id}', [UserApiController::class, 'destroy']);




use App\Http\Controllers\Api\FirstCrudApiController;

Route::apiResource('firstcrudapi', FirstCrudApiController::class);
