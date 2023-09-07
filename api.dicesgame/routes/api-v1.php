<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PlayerController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GameController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('users/register', [UserController::class, 'store'])->name('user.create');
Route::post('users/login', [UserController::class, 'login'])->name('user.login');
Route::middleware('auth:api')->post('users/logout', [UserController::class, 'logout'])->name('user.logout');
Route::middleware('auth:api')->get('/users/{id}', [userController::class, 'show'])->name('user.show');
Route::middleware('auth:api')->put('/users/{id}', [UserController::class, 'update'])->name('user.update');
Route::middleware('auth:api')->delete('/users/{id}', [UserController::class, 'destroy'])->name('user.delete');
Route::middleware('auth:api')->get('/users', [UserController::class, 'index'])->name('user.index');



Route::middleware('auth:api')->post('/players', [PlayerController::class, 'store'])->name('player.create');
Route::middleware('auth:api')->post('/players/{id}/games', [GameController::class, 'store'])->name('game.create');
Route::middleware('auth:api')->get('/players/{id}/games', [GameController::class, 'index'])->name('game.index');
Route::middleware('auth:api')->delete('/players/{id}/games', [GameController::class, 'destroy'])->name('game.delete');
Route::middleware('auth:api')->get('/players', [PlayerController::class, 'index'])->name('player.index');
Route::middleware('auth:api')->get('/players/ranking', [PlayerController::class, 'ranking'])->name('player.ranking');
Route::middleware('auth:api')->get('/players/loser', [PlayerController::class, 'loser'])->name('player.winner');
Route::middleware('auth:api')->get('/players/winner', [PlayerController::class, 'winner'])->name('player.winner');



/*Note: this route has passed to Users according to API Model adopted:
Route::middleware('auth:api')->put('/players/{id}', [UserController::class, 'update'])->name('users.update');*/