<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
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

Route::middleware(['auth:sanctum', 'admin'])->get('/users', [UserController::class, 'users']);
Route::middleware('auth:sanctum')->post('/users/create', [UserController::class, 'register']);
Route::group(['prefix' => 'admin/users', 'middleware' => ['auth:sanctum', 'admin']], function () {
    Route::post('create', [UserController::class, 'register']);
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
// Route::get('user', [UserController::class, 'users']);
