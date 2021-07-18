<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\userController;
use App\Http\Controllers\gameController;
use App\Http\Controllers\partyController;
use App\Http\Controllers\partyUserController;

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
    Route::post('posts/showByUserId', [PostController::class, 'showByUserId']);
    Route::post('posts/showByPartyId', [PostController::class, 'showByPartyId']);

    //Route CRUD Users 
    Route::resource('users', userController::class);
    Route::put('users/edit/{id}', [userController::class, 'update']);

    //Route Crud Game
    Route::resource('games', gameController::class);
    Route::put('games/edit/{id}', [gameController::class, 'update']);
    Route::get('games/getGameById/{id}', [gameController::class, 'getGameById']);
    Route::post('games/title', [gameController::class, 'title']);
    Route::get('games/all', [gameController::class, 'allGames']);

    //Route CRUD Party
    Route::resource('parties', partyController::class);
    // Route::post('parties', [partyController::class, 'index']);
    Route::get('parties', [partyController::class, 'show']);
    Route::post('parties/showById', [partyController::class, 'showById']);
    Route::post('parties/showByName', [partyController::class, 'showByName']);

    //Route PartyUser
    Route::resource('partyusers', partyUserController::class);
    // Route::get('partyusers', [partyUserController::class, 'show']);
    Route::post('partyusers/showByUser', [partyUserController::class, 'showByUser']);
    Route::post('partyusers/showByParty', [partyUserController::class, 'showByParty']);
});




