<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Auth routes
    Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);
    Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
    Route::post('/forget-password', [App\Http\Controllers\API\AuthController::class, 'forgetPassword']);
    Route::post('/reset-password', [App\Http\Controllers\API\AuthController::class, 'resetPassword']);

//User routes
Route::get('/user', [App\Http\Controllers\API\UserrController::class, 'index'])->middleware('auth:api');



