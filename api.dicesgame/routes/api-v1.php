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


Route::post('/register', [UserController::class, 'store'])->name('user.create');
Route::post('/login', [UserController::class, 'login'])->name('user.login');
Route::middleware('auth:api')->put('/users/{id}', [UserController::class, 'update'])->name('user.update');


Route::middleware('auth:api')->post('/players', [PlayerController::class, 'store'])->name('player.create');
Route::middleware('auth:api')->post('/players/{id}/games', [GameController::class, 'store'])->name('game.create');
Route::middleware('auth:api')->get('/players/{id}/games', [GameController::class, 'index'])->name('game.index');
Route::middleware('auth:api')->delete('/players/{id}/games', [GameController::class, 'destroy'])->name('game.delete');
Route::middleware('auth:api')->get('/players', [PlayerController::class, 'index'])->name('player.index');


/*This route has passed to Users according to DataBase Model adopted:
Route::middleware('auth:api')->put('/players/{id}', [UserController::class, 'update'])->name('users.update');*/