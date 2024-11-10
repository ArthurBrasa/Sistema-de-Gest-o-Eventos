<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('users', UserController::class);
});
// Route::get('users', [UserController::class, 'index']);
// Route::post('users', [UserController::class, 'store']);
// Route::get('users/{user}', [UserController::class, 'show']);
// Route::put('users/{user}', [UserController::class, 'update']);
// Route::delete('users/{user}', [UserController::class, 'destroy']);