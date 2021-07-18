<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\userController;
use App\Http\Controllers\gameController;

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

Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    //Route CRUD posts
    Route::resource('posts', PostController::class);
    //Route CRUD Users 
    Route::resource('users', userController::class);
    Route::put('users/edit/{id}', [userController::class, 'update']);
    //Route Crud Game
    Route::resource('games', gameController::class);
   
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
    // return $request->user();
// });
// 