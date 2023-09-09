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

Route::middleware(['auth:api'])->group(function() {

    Route::post('users/logout', [UserController::class, 'logout'])->name('users.logout');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.delete');
    Route::get('/users', [UserController::class, 'index'])->middleware(['can:users.index'])->name('users.index');


    Route::post('/players', [PlayerController::class, 'store'])->name('players.store');
    Route::get('/players', [PlayerController::class, 'index'])->middleware(['can:players.index'])->name('players.index');
   
    Route::post('/players/{id}/games', [GameController::class, 'store'])->middleware(['can:games.store'])->name('games.store');
    Route::get('/players/{id}/games', [GameController::class, 'index'])->middleware(['can:games.index'])->name('games.index');
    Route::delete('/players/{id}/games', [GameController::class, 'destroy'])->middleware(['can:games.delete'])->name('games.delete');

    Route::get('/players/ranking', [PlayerController::class, 'ranking'])->middleware(['can:players.ranking'])->name('players.ranking');
    Route::get('/players/loser', [PlayerController::class, 'loser'])->middleware(['can:players.loser'])->name('players.loser');
    Route::get('/players/winner', [PlayerController::class, 'winner'])->middleware(['can:players.winner'])->name('players.winner');

});


/*Note: this route has passed to Users Routes according to API Model adopted:
Route::middleware('auth:api')->put('/players/{id}', [UserController::class, 'update'])->name('users.update');*/