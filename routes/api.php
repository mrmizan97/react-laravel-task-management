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
//projects   
Route::get('project',[App\Http\Controllers\API\ProjectController::class, 'index']);
Route::get('project/{item}/',[App\Http\Controllers\API\ProjectController::class, 'projecWithTask']);
Route::get('project/create',[App\Http\Controllers\API\ProjectController::class, 'create']);
Route::post('project/store',[App\Http\Controllers\API\ProjectController::class, 'store']);
Route::get('project/{item}/edit',[App\Http\Controllers\API\ProjectController::class, 'edit']);
Route::post('project/{item}/update',[App\Http\Controllers\API\ProjectController::class, 'update']);
Route::get('project/{item}/delete',[App\Http\Controllers\API\ProjectController::class, 'destroy']);

 //tasks   
Route::get('task',[App\Http\Controllers\API\TaskController::class, 'index']);
Route::get('task/{item}/',[App\Http\Controllers\API\TaskController::class, 'taskWithProject']);
Route::get('task/create',[App\Http\Controllers\API\TaskController::class, 'create']);
Route::post('task/store',[App\Http\Controllers\API\TaskController::class, 'store']);
Route::get('task/{item}/edit',[App\Http\Controllers\API\TaskController::class, 'edit']);
Route::post('task/{item}/update',[App\Http\Controllers\API\TaskController::class, 'update']);
Route::get('task/{item}/delete',[App\Http\Controllers\API\TaskController::class, 'destroy']);

 